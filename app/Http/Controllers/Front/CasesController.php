<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Front\StoreCase;
use App\Http\Requests\Front\UpdateCase;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Mapper;
use Cache;
use App\NewsCase;
use App\CaseResult;
use App\Company;
use App\Setting;
use App\CaseSectionResult;
use App\Classes\TwitterManager;
use App\Classes\TwitterUser;
use App\Classes\TineyeApi;
use Illuminate\Database\Eloquent\Collection;
use App\Models\CaseManagement;
use App\Models\CaseCategory;
use App\Models\TaskManagement;
use App\Models\Notes;
use App\Models\Countries;
use App\Models\Events;
use App\Models\CaseMasterdata;
use Illuminate\Support\Facades\DB;

class CasesController extends Controller
{
    /** @var NewsCase */
    private $case;

    /** @var Company */
    private $company;

    /** @var Setting */
    private $settings;

    /** @var TwitterManager */
    private $twitterManager;

    private $pagination = 10;

    /**
     * Create a new controller instance.
     *
     * @param Case $case
     * @param Company $company
     * @param TwitterManager $twitterManager
     * @param Setting $settings
     * @return void
     */
    public function __construct(NewsCase $case, Company $company, TwitterManager $twitterManager, Setting $settings)
    {
        $this->middleware('auth:front');

        $this->case = $case;
        $this->company = $company;
        $this->twitterManager = $twitterManager;
        $this->settings = $settings;
    }

    /**
     * Set Twitter config details
     *
     * @return none
     */
    public function setTwitterConfig()
    {
        $config = $this->company->getCompanyTwitterDetails();
        $this->twitterManager->setConfig($config);
    }

    /**
     * Set Twitter config details
     *
     * @param int $tweetId
     * @return boolean
     */
    public function isUniqueTweet($tweetId)
    {
        $tweetCount = $this->case->where('tweet_id', $tweetId)->count();

        if ($tweetCount < 1) {
            return true;
        }
        return false;
    }

    /**
     * Flag a case from section
     *
     * @param Request $request
     * @param int $sectionId
     * @param int $caseId
     * @return boolean
     */
    public function flagCaseBySection(Request $request, $sectionId, $caseId)
    {
        $caseSectionResult = new CaseSectionResult;
        $caseSectionResult->case_id = $caseId;
        $caseSectionResult->section_id = $sectionId;
        $caseSectionResult->flag = $request->get('flag');

        $caseSectionResult->user()->associate(Auth::user());
        $caseSectionResult->save();

        return redirect()->back()
            ->with('success', 'Case Flaged successfully!');
    }

    /**
     * Flag a case
     *
     * @param Request $request
     * @param int $caseId
     * @return boolean
     */
    public function flagCase(Request $request, $caseId)
    {
        $caseSectionResult = new CaseResult;
        $caseSectionResult->flag = $request->get('flag');

        $case = $this->case->findorFail($caseId);
        $caseSectionResult->case()->associate($case);
        $caseSectionResult->user()->associate(Auth::user());
        $caseSectionResult->save();

        return redirect()->back()
            ->with('success', 'Case Flaged successfully!');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
   public function index(Request $request)
   {
    	$currentUser      = Auth::user();
		$userCompany      = $currentUser->company;
		$userSetting      = $userCompany->settings;
		$userSettingsKey  = [];
		if($userSetting){
			foreach($userSetting as $setting){
				$userSettingsKey[$setting->key]  = $setting->value;
			}
		}
		
	   $cases = $this->case;
	   // Search Case
	   if ($request->has('s')) {
	       $search = $request->get('s');
	       $cases = $cases->where('title', 'LIKE', "%{$search}%");
	   }
	
	   $cases = $cases->orderBy('flag')->paginate($this->pagination);
       return view('Front.index', ['cases' => $cases,'userSettingsKey'=>$userSettingsKey]);
   }

    /**
     * Show the new case form
     *
     * @return Response
     */
    public function newCase()
    {
        return view('Front.newcase');
    }

    /**
     * Store case in database
     *
     * @param StoreCase $request
     * @return Response
     */
    public function storeCase(StoreCase $request)
    {
        // Set Twitter config
        $this->setTwitterConfig();

        // Verify Tweet
        $url = explode('/', rtrim($request->get('url'), "/"));
        $tweetId = end($url);
        $tweet = $this->twitterManager->verifyTweet($tweetId);

        if (!$tweet) {
            return redirect()->back()
                ->with('error', 'Invalid Tweet URL, Please try again.')
                ->withInput();
        }
        // Check tweet is unique
        if (!$this->isUniqueTweet($tweet->id)) {
            return redirect()->back()
                ->with('error', 'Tweet is already exist, Please try again.')
                ->withInput();
        }

        $location = '';
        $tweetImage = isset($tweet->entities->media[0]->media_url) ? $tweet->entities->media[0]->media_url : null;
        if ($tweet->user->location != '') {
            $location = $tweet->user->location;
        } else {
            $location = isset($tweet->place->full_name) && $tweet->place->full_name != '' ? $tweet->place->full_name : '';
        }

        $this->case->title = $request->get('title');
        $this->case->url = rtrim($request->get('url'), "/");
        $this->case->keywords = $request->get('keywords');
        $this->case->tweet_id = $tweet->id;
        $this->case->tweet_image = $tweetImage;
        $this->case->tweet_author = $tweet->user->screen_name;

        $latitude = null;
        $longitude = null;

        if ($tweet->place != '') {
            $geo = $this->twitterManager->getGeo($tweet->place->id);
            $latitude = $geo['latitude'];
            $longitude = $geo['longitude'];
        } elseif ($location != '') {
            try {
                $geo = Mapper::location($location);
                $location = $geo->getAddress();
                $latitude = $geo->getLatitude();
                $longitude = $geo->getLongitude();
            } catch (\Exception $e) {
                $latitude = null;
                $longitude = null;
            }
        }

        $this->case->location = $location;
        $this->case->latitude = $latitude;
        $this->case->longitude = $longitude;

        // Assign user to case
        $this->case->user()->associate(Auth::user());

        $this->case->save();

        return redirect(route('caseinfo', $this->case->id))
            ->with('success', 'Case created successfully!');
    }

    /**
     * Show the case info
     *
     * @param int $id
     * @return Response
     */
    public function caseInfo($id)
    {
        try {
            $sectionId = NewsCase::SECTION_INFO;
            $cacheKey = "{$sectionId}{$id}";
            $case = $this->case->findorFail($id);

            $this->setTwitterConfig();

            if (!Cache::has($cacheKey)) {
                Cache::forever($cacheKey, $this->twitterManager->getTweetPreview($case->url));
            }

            $tweetPreview = Cache::get($cacheKey);

            return view('Front.sections.info', ['case' => $case, 'sectionId' => $sectionId, 'tweetPreview' => $tweetPreview]);
        } catch (\Exception $e) {
            return redirect('/')
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the Edit case form
     *
     * @param int $id
     * @return Response
     */
    public function editCase($id)
    {
        $case = $this->case->findorFail($id);
        return view('Front.editcase', ['case' => $case]);
    }

    /**
     * Update case in database
     *
     * @param UpdateCase $request
     * @param int $id
     * @return Response
     */
    public function updateCase(UpdateCase $request, $id)
    {
        if($request){
            $case = $this->case->findorFail($id);
            $case->title = $request->get('title');
            $case->keywords = $request->get('keywords');
            $case->save();
            return redirect(route('caseinfo', $case->id))->with('success', 'Case updated successfully!');
        }else{
            redirect(route('caseinfo', $case->id));
        }
        
    }

    /**
     * Post Analysis Section
     *
     * @param int $id
     * @return Response
     */
    public function postAnalysis($id)
    {
        try {
            $sectionId = NewsCase::SECTION_POST_ANALYSIS;
            $cacheKey = "{$sectionId}{$id}";
            $case = $this->case->findorFail($id);

            $this->setTwitterConfig();
            if (!Cache::has($cacheKey)) {
                Cache::forever($cacheKey, $this->twitterManager->getTweetPreview($case->url));
            }

            $tweetPreview = Cache::get($cacheKey);

            return view('Front.sections.analysis', ['case' => $case, 'sectionId' => $sectionId, 'tweetPreview' => $tweetPreview]);
        } catch (\Exception $e) {
            return redirect('/')
                ->with('error', 'Invalid Tweet, Please try again.')
                ->withInput();
        }
    }

    /**
     * Author Latest Posts
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function authorPosts(Request $request, $id)
    {
        try {
            $sectionId = NewsCase::SECTION_AUTHOR_LATEST_POSTS;
            $case = $this->case->findorFail($id);
            $this->setTwitterConfig();

            $duration = $request->has('duration') ? $request->get('duration') : 'month';

            $cacheKey = "{$sectionId}{$id}{$duration}";
            if (!Cache::has($cacheKey)) {
                Cache::forever($cacheKey, $this->twitterManager->getAuthorPosts($case->tweet_author, $duration));
            }

            $authorPosts = Cache::get($cacheKey);

            return view('Front.sections.authorposts', ['case' => $case, 'sectionId' => $sectionId, 'duration' => $duration, 'authorPosts' => $authorPosts]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Invalid Tweet, Please try again.')
                ->withInput();
        }
    }

    /**
     * Geo Location map
     *
     * @param int $id
     * @return Response
     */
    public function geoLocationMap($id)
    {
        try {
            $sectionId = NewsCase::SECTION_POST_GEO_LOCATION;
            $case = $this->case->findorFail($id);

            if ($case->latitude == null || $case->longitude == null) {
                return redirect()->back()
                    ->with('error', 'Location is not correct of this case')
                    ->withInput();
            }

            Mapper::map($case->latitude, $case->longitude);

            return view('Front.sections.geolocation', ['case' => $case, 'sectionId' => $sectionId]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Similar Posts
     *
     * @param int $id
     * @return Response
     */
    public function similarPosts($id)
    {
        try {
            $sectionId = NewsCase::SECTION_SIMILAR_POSTS;
            $cacheKey = "{$sectionId}{$id}";
            $case = $this->case->findorFail($id);

            $this->setTwitterConfig();

            if (!Cache::has($cacheKey)) {
                Cache::forever($cacheKey, $this->twitterManager->getSimilarPosts($case));
            }

            $similarPosts = Cache::get($cacheKey);

            return view('Front.sections.similarposts', ['case' => $case, 'sectionId' => $sectionId, 'similarPosts' => $similarPosts]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Invalid Tweet, Please try again.')
                ->withInput();
        }
    }

    /**
     * Posts from same area
     *
     * @param int $id
     * @return Response
     */
    public function sameAreaPosts($id)
    {
        try {
            $sectionId = NewsCase::SECTION_SIMILAR_POSTS_SAME_AREA;
            $cacheKey = "{$sectionId}{$id}";
            $case = $this->case->findorFail($id);

            $this->setTwitterConfig();

            if (!Cache::has($cacheKey)) {
                Cache::forever($cacheKey, $this->twitterManager->getSameAreaPosts($case));
            }

            $sameAreaPosts = Cache::get($cacheKey);

            return view('Front.sections.sameareaposts', ['case' => $case, 'sectionId' => $sectionId, 'sameAreaPosts' => $sameAreaPosts]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    // case_management for users

    public function case_management(Request $request)
    {
        $user            = auth()->user();
        $user_companyid  = $user->company_id;   
        $case_data       = DB::select('SELECT  case_management.id case_id , case_management.title case_title, case_management.description case_description, case_masterdata.category case_category, users.first_name case_fname, users.last_name case_lname, x.category case_status FROM `case_management`  left join case_masterdata on case_masterdata.id=case_management.category and case_masterdata.category_type=1 left join case_masterdata x on x.id=case_management.status and x.category_type=3  LEFT join users on users.id=case_management.user_id where case_management.company_id='.$user_companyid);
        $get_catdata     = CaseMasterdata::where('category_type', '=', '1')->where('company_id' ,'=' ,$user_companyid)->get();
        $get_usertype    = auth()->user()->where('company_id' ,'=' ,$user_companyid)->get();
        $get_statustype  = CaseMasterdata::where('category_type', '=', '3')->where('company_id' ,'=' ,$user_companyid)->get();
        $get_assignedto  = CaseMasterdata::where('category_type', '=', '5')->where('company_id' ,'=' ,$user_companyid)->get();
        return view('Front.sections.cases', ['case_managementdata' => $case_data,'category_data' => $get_catdata,'status_type' => $get_statustype,'asigned_to'=> $get_assignedto,'usertype' => $get_usertype ]);
    }

    //case searching

    public function case_search(Request $request)
    { 
        $user             = auth()->user();
        $user_companyid   = $user->company_id;  

        $CaseManagement = (new CaseManagement)->newQuery(); 
        $category_query='';
        $status_query='';
        $creator_query='';
        $keyword_query='';
        $category          = $request->get('category');
        if($category){
          //  $category = $category == 'EMPTY' ? [] : explode(',', $category);
            $category_query= " and case_management.category in(".$category.") ";
           // $CaseManagement->whereIn('category', $category)  ;          
        } 
        $status          = $request->get('status');
        if($status){
           // $status = $status == 'EMPTY' ? [] : explode(',', $status);
            $status_query= " and case_management.status in(".$status.") ";
            //$CaseManagement->whereIn('status', $status);           
        } 
        $creator          = $request->get('creator');
        if($creator){
         //   $creator = $creator == 'EMPTY' ? [] : explode(',', $creator);
            $creator_query= " and case_management.user_id in(".$creator.") ";
           // $CaseManagement->whereIn('creator', $creator) ;          
        }         
        $keyword          = $request->get('keyword');
        if($keyword){
            //   $creator = $creator == 'EMPTY' ? [] : explode(',', $creator);
               $keyword_query= " and  (`case_management`.`title` like '%".$keyword."%' or `case_management`.`description` like '%".$keyword."%' or `case_management`.`case_keywords` like '%".$keyword."%')";
              // $CaseManagement->whereIn('creator', $creator) ;          
           }           
        $case_data = DB::select('SELECT  case_management.id case_id , case_management.title case_title, case_management.description case_description, case_masterdata.category case_category, users.first_name case_fname, users.last_name case_lname, x.category case_status FROM `case_management`  left join case_masterdata on case_masterdata.id=case_management.category and case_masterdata.category_type=1 left join case_masterdata x on x.id=case_management.status and x.category_type=3  LEFT join users on users.id=case_management.user_id where case_management.company_id='.$user_companyid.$category_query. $status_query. $creator_query.$keyword_query);
       // $case_data = DB::select('SELECT * FROM `case_management` WHERE  case_management.company_id='.$user_companyid.$category_query. $status_query. $creator_query);

       return $case_data;
    }


    // add case popup
    public function create_case()
    {         
        $user            = auth()->user();
        $user_companyid  = $user->company_id;
        $get_catdata     = CaseMasterdata::where('category_type', '=', '1')->where('company_id' ,'=' ,$user_companyid)->get();
        $get_usertype    = auth()->user()->where('company_id' ,'=' ,$user_companyid)->get();
        $get_statustype  = CaseMasterdata::where('category_type', '=', '3')->where('company_id' ,'=' ,$user_companyid)->get();
        $get_assignedto  = CaseMasterdata::where('category_type', '=', '5')->where('company_id' ,'=' ,$user_companyid)->get();
        $get_country     = Countries::all();
        return view('Front.sections.add_case', ['withoutSidebar' => 1, 'case_managementupdata' => array(), 'category_data' => $get_catdata, 'user_type' => $get_usertype, 'status_type' => $get_statustype,'asigned_to'=> $get_assignedto,'country' => $get_country,'user'=> $user]);
    }
    // update case
    public function update_case($id)
    {
        if ($id) {
            $user            = auth()->user();
            $user_companyid  = $user->company_id;  
            $get_caseid      = CaseManagement::find($id);
            $get_catdata     = CaseMasterdata::where('category_type', '=', '1')->where('company_id' ,'=' ,$user_companyid)->get();
            $get_usertype    = auth()->user()->where('company_id' ,'=' ,$user_companyid)->get();
            $get_statustype  = CaseMasterdata::where('category_type', '=', '3')->where('company_id' ,'=' ,$user_companyid)->get();
            $get_assignedto  = CaseMasterdata::where('category_type', '=', '5')->where('company_id' ,'=' ,$user_companyid)->get();
            $get_country     = Countries::all();
            return view('Front.sections.add_case', ['withoutSidebar' => 1, 'case_managementupdata' => $get_caseid, 'category_data' => $get_catdata, 'user_type' => $get_usertype, 'status_type' => $get_statustype,'asigned_to'=> $get_assignedto,'country' => $get_country,'user'=> $user]);
        }
    }
    // update task management
    public function updatetask_case($caseManagementId, $id)
    {
        if ($id) {
            $user            = auth()->user();
            $user_companyid  = $user->company_id;  
            $caseManagement  = CaseManagement::find($caseManagementId);
            $get_task_data   = TaskManagement::find($id);
            $get_catdata     = CaseMasterdata::where('category_type', '=', '1')->where('company_id' ,'=' ,$user_companyid)->get();
            $get_usertype    = User::where('company_id' ,'=' ,$user_companyid)->get();
            $get_statustype  = CaseMasterdata::where('category_type', '=', '3')->where('company_id' ,'=' ,$user_companyid)->get();
            $get_alertype    = CaseMasterdata::where('category_type', '=', '4')->where('company_id' ,'=' ,$user_companyid)->get();
            $get_group       = CaseMasterdata::where('category_type', '=', '8')->where('company_id' ,'=' ,$user_companyid)->get();
            return view('Front.sections.add_task', ['task_managementupdata' => $get_task_data,'caseManagementId'=>$caseManagementId,'caseManagement'=>$caseManagement, 'category_data' => $get_catdata, 'user_type' => $get_usertype, 'status_type' => $get_statustype, 'alert' => $get_alertype,'assignedGroups'=>$get_group]);
        }
    }

    /**
     * Author Latest Posts
     *
     * @param Request $request
     * @return Response
     */
    // save case management details
    public function save_case_management(Request $request, $id = null)
    {
        /*$validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
       }*/
        try {
            if ($request->post('case_id')) {
               if($request->post('title')){
				$caseManagement                = CaseManagement::find($request->post('case_id'));
                $caseManagement->title         = $request->post('title');
                $caseManagement->status        = $request->post('status');
                $caseManagement->description   = $request->post('description');
                $caseManagement->category      = $request->post('category');
                $caseManagement->assignee      = $request->post('assignee');
                $caseManagement->assigned_to   = $request->post('assigned_to');
                $caseManagement->case_keywords = $request->post('case_keywords');
                $caseManagement->country       = $request->post('country');
                $caseManagement->case_info     = $request->post('case_info');
                $caseManagement->user_id       = $request->post('user_id');
                $caseManagement->company_id    = $request->post('company_id');
                $caseManagement->save();
                return redirect(route('cases.management'))->with('success', 'Case updated successfully!');   
			   }else{
				  return redirect(route('cases.management')); 
			   }				   
                
            } else {
                $caseManagement                = new CaseManagement();
                $caseManagement->title         = $request->post('title');
                $caseManagement->status        = $request->post('status');
                $caseManagement->description   = $request->post('description');
                $caseManagement->category      = $request->post('category');
                $caseManagement->assignee      = $request->post('assignee');
                $caseManagement->assigned_to   = $request->post('assigned_to');
                $caseManagement->case_keywords = $request->post('case_keywords');
                $caseManagement->country       = $request->post('country');
                $caseManagement->case_info     = $request->post('case_info');
                $caseManagement->user_id       = $request->post('user_id');
                $caseManagement->company_id    = $request->post('company_id');
                $caseManagement->save();
                return redirect(route('cases.management'))->with('success', 'Case inserted successfully!');
                ;
            }
        } catch (\Exception $e) {
            return redirect(route('cases.management'))->with('error', $e->getMessage())->withInput();
        }
    }
    // save task management
    /**
     * Author Latest Posts
     *
     * @param Request $request
     * @return Response
     */
    public function task_case_management(Request $request, $id=null)
    {
        try {
            $caseManagementId                = $request->post('caseManagementId');
            if ($request->post('task_id')) {
                $taskManagement = TaskManagement::find($request->post('task_id'));
                $taskManagement->task_name           = $request->post('task_name');
                $taskManagement->date_from           = $request->post('date_from');
                $taskManagement->date_to             = $request->post('date_to');
                $taskManagement->task_status         = $request->post('task_status');
                $taskManagement->location            = $request->post('location');
                $taskManagement->assigned_group      = $request->post('assigned_group');
                $taskManagement->assigned_to         = $request->post('assigned_to');
                $taskManagement->alert               = $request->post('alert');
                $taskManagement->notes               = $request->post('notes');
                $taskManagement->alert_value         = $request->post('alert_value');
                $taskManagement->case_management_id  = $caseManagementId;
                $taskManagement->save();
                return redirect(route('cases.files', ['caseManagementId'=>$caseManagementId]))->with('success', 'Task updated successfully!');
            } else {
                $taskManagement = new TaskManagement();
                $taskManagement->task_name           = $request->post('task_name');
                $taskManagement->date_from           = $request->post('date_from');
                $taskManagement->date_to             = $request->post('date_to');
                $taskManagement->task_status         = $request->post('task_status');
                $taskManagement->location            = $request->post('location');
                $taskManagement->assigned_group      = $request->post('assigned_group');
                $taskManagement->assigned_to         = $request->post('assigned_to');
                $taskManagement->alert               = $request->post('alert');
                $taskManagement->notes               = $request->post('notes');
                $taskManagement->alert_value         = $request->post('alert_value');
                $taskManagement->case_management_id  = $caseManagementId;
                $taskManagement->save();
                return redirect(route('cases.files', ['caseManagementId'=>$caseManagementId]))->with('success', 'Task inserted successfully!');
            }
        } catch (\Exception $e) {
            return redirect(route('cases.files'))->with('error', $e->getMessage())->withInput();
        }
    }
    // save notes
    /**
     * Author Latest Posts
     *
     * @param Request $request
     * @return Response
     */
    public function saveNote(Request $request)
    {
        try {
            $caseManagementId  = $request->post('caseManagementId');
            if ($request->post('noteId')) {
                $note = Notes::find($request->post('noteId'));
                $note->note_title = $request->post('title');

                $description = "";
                $description_val = $request->post('description');
                if(isset($description_val)){
                    $description = $request->post('description');
                }
                $note->title_desc = $description;
                $note->user_id    = $request->post('user_id');
                $note->save();
                return redirect(route('cases.notes', ['caseManagementId'=>$caseManagementId]))->with('success', 'Note updated successfully!');
            } else {
                $note = new Notes();
                $note->note_title           = $request->post('title');

                $description = "";
                $description_val = $request->post('description');
                if(isset($description_val)){
                    $description = $request->post('description');
                }
                $note->title_desc           = $description;
                $note->case_management_id   = $caseManagementId;
                $note->user_id              = $request->post('user_id');
                $note->save();
                return redirect(route('cases.notes', ['caseManagementId'=>$caseManagementId]))->with('success', 'Note inserted successfully!');
            }
        } catch (\Exception $e) {
            return redirect(route('cases.notes'))->with('error', $e->getMessage())->withInput();
        }
    }

    // delete case for case management
    public function delete_case()
    { 
     try{
        $request         =  $_GET;
        $data = CaseManagement::findOrFail($_GET['case_id']);
        $data->delete();
        return redirect(route('cases.management'))->with('success','Case deleted successfully');
       }catch (\Exception $e) {
        return redirect(route('cases.management'))->with('error', $e->getMessage())->withInput();
      } 

    }
    
    public function delete_taskcase()
    {
        try{
            $request         =  $_GET;
            $data = TaskManagement::findOrFail($_GET['task_id']);
            $data->delete();
            return response()->json([
                'success' => 'Task deleted successfully!'
            ]);
            return redirect(route('cases.files'));
        }catch (\Exception $e) {
            return redirect(route('cases.files'))->with('error', $e->getMessage())->withInput();
        }

    }

    public function deleteNote($caseManagementId, $id)
    {
        try {
            $note = Notes::findOrFail($id);
            $note->delete();
            return redirect(route('cases.notes', ['caseManagementId'=>$caseManagementId]))->with('warning', 'Note deleted successfully!');
        } catch (\Exception $e) {
            return redirect(route('cases.notes', ['caseManagementId'=>$caseManagementId]))->with('error', $e->getMessage())->withInput();
        }
    }

    public function detail_case()
    {
        return view('Front.sections.case-description', ['case_detail' => array()]);
    }

    public function notes($caseManagementId)
    {
        //$user            = auth()->user();
        $caseManagement  = CaseManagement::find($caseManagementId);
        $user            = User::find($caseManagement->user_id);
        if(isset($user)){
            $user_id         = $caseManagement->user_id; 
            $user_name       = $user->first_name; 
            $user_lastn      = $user->last_name;
        }else{
            $user_id         = ''; 
            $user_name       = ''; 
            $user_lastn      = '';
        }
        
        $notesData       = Notes::where('case_management_id', '=', $caseManagementId)->get();
        return view('Front.sections.notes', ['caseManagementId'=>$caseManagementId,'caseManagement'=>$caseManagement,'notes' => $notesData,'user'=> $user_id,'user_name' => $user_name,'user_lname' => $user_lastn]);
    }

    public function addNote($caseManagementId)
    {
        $user            = auth()->user();
        $user_id         = $user->id;
        $caseManagement = CaseManagement::find($caseManagementId);
        return view('Front.sections.add_note', ['caseManagementId'=>$caseManagementId,'caseManagement'=>$caseManagement,'note'=>array(),'user_id'=> $user_id]);
    }

    public function updateNote($caseManagementId, $id)
    {
        try {
            if (empty($id)) {
                return redirect()->back()->with('error', 'Note ID can not be empty')->withInput();
            }
            $note = Notes::find($id);
            $user            = auth()->user();
            $user_id         = $user->id;
            $caseManagement  = CaseManagement::find($caseManagementId);
            return view('Front.sections.add_note', ['caseManagementId'=>$caseManagementId,'caseManagement'=>$caseManagement,'note'=>$note,'user_id'=> $user_id]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function viewNote($caseManagementId, $id)
    {
        try {
            if (empty($id)) {
                return redirect()->back()->with('error', 'Note ID can not be empty')->withInput();
            }
            $note = Notes::find($id);
            $user            = auth()->user();
            $user_id         = $user->id;
            $caseManagement  = CaseManagement::find($caseManagementId);
            return view('Front.sections.view_note', ['caseManagementId'=>$caseManagementId,'caseManagement'=>$caseManagement,'note'=>$note,'user_id'=> $user_id]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function detail_case_desc($id = '')
    {
        $get_casedetails = CaseManagement::find($id);
        
        $get_statustype = "";
        if(isset($get_casedetails->status)){
            $get_statustype  = CaseMasterdata::where('id', '=', $get_casedetails->status)->first();
            if(isset($get_statustype->category))
               $get_statustype    = $get_statustype->category;
        }
        
        $get_category = "";
        if(isset($get_casedetails->category)){
            $get_category    = CaseMasterdata::where('id', '=', $get_casedetails->category)->first();
            if(isset($get_category->category))
               $get_category    = $get_category->category;
        }
        
        $get_country="";
        if(isset($get_casedetails->country)){
            $get_country     = Countries::find($get_casedetails->country);
            if(isset($get_country->name))
              $get_country    = $get_country->name;
        }

        $user_assign_first_name="";
        $user_assign_last_name="";
        if(isset($get_casedetails->assignee)){
            $user_assign     = User::where('id', '=', $get_casedetails->assignee)->first();
            if(isset($user_assign->first_name))
              $user_assign_first_name    = $user_assign->first_name;
            if(isset($user_assign->last_name))
              $user_assign_last_name    = $user_assign->last_name;
        }
        
        $user_assignto_first_name="";
        $user_assignto_last_name="";
        if(isset($get_casedetails->assigned_to)){
            $user_assignto     = User::where('id', '=', $get_casedetails->assigned_to)->first();
            if(isset($user_assignto->first_name))
              $user_assignto_first_name    = $user_assignto->first_name;            
            if(isset($user_assignto->last_name))
              $user_assignto_last_name    = $user_assignto->last_name;
        }
       // $get_statustype  = CaseMasterdata::where('id', '=', $get_casedetails->status)->first();
       // $get_category    = CaseMasterdata::where('id', '=', $get_casedetails->category)->first();
       // $get_country     = Countries::find($get_casedetails->country);
        //$user_assign = User::where('id', '=', $get_casedetails->assignee)->first();
       // $user_assignto = User::where('id', '=', $get_casedetails->assigned_to)->first();
       // print_r($get_country);
       // die();
        return view('Front.sections.case-description', ['caseManagement'=>$get_casedetails,'case_detail' => $get_casedetails,'country'=>$get_country,'status'=>$get_statustype,'category_name'=>$get_category,'assign_user'=>$user_assign_first_name.' '.$user_assign_last_name,'assign_user_to'=>$user_assignto_first_name.' '.$user_assignto_last_name]);
    }

    public function files($caseManagementId)
    {
        $caseManagement = CaseManagement::find($caseManagementId);
        $taskData       = TaskManagement::where('case_management_id', '=', $caseManagementId)->get();
        $alldata=array();
        foreach ($taskData as  $value) {
            $get_usertype    = User::where('id' ,'=' ,$value->assigned_to)->first(); 

            $get_group="";
            if(isset($value->assigned_group)){
                $get_group       = CaseMasterdata::where('id', '=', $value->assigned_group)->first();
                if(isset($get_group->category))
                   $get_group    = $get_group->category;
            }

            $get_usertype_first_name="";
            if(isset($get_usertype)){
                if(isset($get_usertype->first_name))
                   $get_usertype_first_name    = $get_usertype->first_name;
            }

            $get_usertype_last_name="";
            if(isset($get_usertype)){
                if(isset($get_usertype->last_name))
                   $get_usertype_last_name    = $get_usertype->last_name;
            }

            $date_from="";
            if(isset($value['date_from'])){
                $date_from    = $value['date_from'];
            }

            // $get_group       = CaseMasterdata::where('id', '=', $value->assigned_to)->first();
            $get_statustype  = CaseMasterdata::where('id', '=', $value->task_status)->first();
            $alldata[]=array(
                'id'=>$value['id'],
                'task_name'=>$value['task_name'],
                'assigned_group'=>$get_group,
                'assigned_to'=>$get_usertype_first_name.' '.$get_usertype_last_name,
                'date_from'=>$date_from,
                'task_status'=>$get_statustype->category
            );
        }
        //print_r($taskData);
        //$user_companyid  = $user->company_id;
        //$get_usertype    = User::where('company_id' ,'=' ,$user_companyid)->get();
        //$get_statustype  = CaseMasterdata::where('category_type', '=', '3')->where('company_id' ,'=' ,$user_companyid)->get();
        //$get_alertype    = CaseMasterdata::where('category_type', '=', '4')->where('company_id' ,'=' ,$user_companyid)->get();
        //$get_group       = CaseMasterdata::where('category_type', '=', '8')->where('company_id' ,'=' ,$user_companyid)->get();
        return view('Front.sections.task-management', ['caseManagementId'=>$caseManagementId,'caseManagement'=>$caseManagement,'task_mgmtdata' => $alldata]);
    }

    public function taskmanagement($caseManagementId)
    {
        $user            = auth()->user();
        $user_companyid  = $user->company_id;  
        $get_catdata     = CaseMasterdata::where('category_type', '=', '1')->where('company_id' ,'=' ,$user_companyid)->get();
        $get_usertype    = User::where('company_id' ,'=' ,$user_companyid)->get();
        $get_statustype  = CaseMasterdata::where('category_type', '=', '3')->where('company_id' ,'=' ,$user_companyid)->get();
        $get_alertype    = CaseMasterdata::where('category_type', '=', '4')->where('company_id' ,'=' ,$user_companyid)->get();
        $get_group       = CaseMasterdata::where('category_type', '=', '8')->where('company_id' ,'=' ,$user_companyid)->get();
        $caseManagement  = CaseManagement::find($caseManagementId);
        return view('Front.sections.add_task', ['task_managementupdata'=>[],'caseManagementId'=>$caseManagementId,'caseManagement'=>$caseManagement,'category_data' => $get_catdata, 'user_type' => $get_usertype, 'status_type' => $get_statustype, 'alert' => $get_alertype,'assignedGroups'=>$get_group]);
    }

    /**
     * Author Profile
     *
     * @param int $id
     * @return Response
     */
    public function authorProfile($id)
    {
        $sectionId = NewsCase::SECTION_AUTHOR_PROFILE;
        $cacheKey = "{$sectionId}{$id}";
        $case = $this->case->findorFail($id);
        $screen_name = $case->tweet_author;

        $config = $this->company->getCompanyTwitterDetails();
        $twitter_user = new TwitterUser($config['consumer_key'], $config['consumer_secret'], $config['token'], $config['secret'], $screen_name);

        if (!Cache::has($cacheKey)) {
            Cache::forever($cacheKey, $twitter_user->getUserStatistics());
        }

        $stats = Cache::get($cacheKey);

        return view('Front.sections.authorprofile', ['case' => $case, 'sectionId' => $sectionId, 'stats' => $stats]);
    }

    /**
     * Image Search
     *
     * @param int $id
     * @return Response
     */
    public function imageSearch($id)
    {
        try {
            $sectionId = NewsCase::SECTION_IMAGE_SEARCH;
            $cacheKey = "{$sectionId}{$id}";
            $case = $this->case->findorFail($id);

            if ($case->tweet_image == null) {
                throw new \Exception("Tweet has no image!");
            }

            if (!Cache::has($cacheKey)) {
                $tineyeApi = new TineyeApi(
                    $this->settings->getSettingValueByKey(Setting::TYPE_TINEYE_PRIVATE_KEY),
                    $this->settings->getSettingValueByKey(Setting::TYPE_TINEYE_PUBLIC_KEY)
                );
                $data = $tineyeApi->searchImageUrl($case->tweet_image);
                Cache::forever($cacheKey, $data);
            }

            $data = Cache::get($cacheKey);

            return view('Front.sections.imagesearch', ['case' => $case, 'sectionId' => $sectionId, 'data' => $data]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Source Cross Check
     *
     * @param int $id
     * @return Response
     */
    public function sourceCrossCheck($id)
    {
        $sectionId = NewsCase::SECTION_SOURCE_CROSSS_CHECKING;
        $case = $this->case->findorFail($id);

        $fakeCount = $case->results()->where('flag', NewsCase::FLAG_FAKE)->count();

        return view('Front.sections.source-cross', ['case' => $case, 'sectionId' => $sectionId, 'fakeCount' => $fakeCount]);
    }

    /**
     * Case Results
     *
     * @param int $id
     * @return Response
     */
    public function results($id)
    {
        $case = $this->case->findorFail($id);
        $sections = $this->case->getSections();

        return view('Front.sections.results', ['case' => $case, 'sections' => $sections]);
    }

    /**
     * Related Cases
     *
     * @param int $id
     * @return Response
     */
    public function relatedCases($id)
    {
        $case = $this->case->findorFail($id);
        $relatedCases = $this->case
            ->where(function ($query) use ($case) {
                $query->where('title', 'like', '%' . $case->title . '%')
                    ->orWhere('keywords', 'like', '%' . $case->title . '%')
                    ->orWhere('title', 'like', '%' . $case->keywords . '%')
                    ->orWhere('keywords', 'like', '%' . $case->keywords . '%');
            })
            ->where('id', '!=', $id)
            ->take(3)
            ->get();

        return view('Front.sections.related-cases', ['case' => $case, 'relatedCases' => $relatedCases]);
    }

    public function events($caseManagementId)
    {
        $events = Events::where('case_management_id', '=', $caseManagementId)->get();
        $caseManagement = CaseManagement::find($caseManagementId);
        return view('Front.sections.events', ['caseManagementId'=>$caseManagementId,'caseManagement'=>$caseManagement,'events'=>$events]);
    }

    public function saveEvent(Request $request)
    {
        try {
            $caseManagementId                = $request->post('caseManagementId');
            if ($request->post('eventId')) {
                $events = Events::find($request->post('eventId'));
                $events->event_name            = $request->post('task_name');
                $events->event_description     = $request->post('date_from');
                $events->event_startdate       = $request->post('date_to');
                $events->event_enddate         = $request->post('task_status');
                $events->case_management_id    = $request->post('assigned_group');
                $taskManagement->type          = 1;
                $taskManagement->save();
                return response()->json(['success' => true]);
            } else {
                $events = new Events();
                $events->event_name            = $request->post('task_name');
                $events->event_description     = $request->post('date_from');
                $events->event_startdate       = $request->post('date_to');
                $events->event_enddate         = $request->post('task_status');
                $events->case_management_id    = $request->post('assigned_group');
                $taskManagement->type          = 1;
                $taskManagement->save();
                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }

    public function getEventListing(Request $request)
    {
        try {
            $caseManagementId                = $request->post('caseManagementId');
            if ($request->post('eventId')) {
                $events = Events::find($request->post('eventId'));
                $events->event_name            = $request->post('task_name');
                $events->event_description     = $request->post('date_from');
                $events->event_startdate       = $request->post('date_to');
                $events->event_enddate         = $request->post('task_status');
                $events->case_management_id    = $request->post('assigned_group');
                $taskManagement->type          = 1;
                $taskManagement->save();
                return response()->json(['success' => true]);
            } else {
                $events = new Events();
                $events->event_name            = $request->post('task_name');
                $events->event_description     = $request->post('date_from');
                $events->event_startdate       = $request->post('date_to');
                $events->event_enddate         = $request->post('task_status');
                $events->case_management_id    = $request->post('assigned_group');
                $taskManagement->type          = 1;
                $taskManagement->save();
                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }

    /**
     * Clear Cache
     *
     * @return Response
     */
    public function clearCache($key)
    {
        Cache::forget($key);
        return redirect()->back();
    }
}
