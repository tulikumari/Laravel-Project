<?php

namespace App\Http\Controllers\Front;

use Auth;
use App\NewsCase;
use App\Discussion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\StoreDiscussion;
use App\Models\ContactPeople;
use App\Models\Countries;
use App\Models\CaseManagement;
use App\Models\CaseMasterdata;
use Illuminate\Support\Facades\DB;

class DiscussionController extends Controller

{
    /** @var NewsCase */
    private $case;

    /** @var Discussion */
    private $discussion;

    /** Cache Expirty time */
    private $cacheExpiryTime;

    /**
     * Create a new controller instance.
     *
     * @param Case $case
     * @param Discussion $discussion
     * @return void
     */
    public function __construct(NewsCase $case, Discussion $discussion)
    {
        $this->middleware('auth:front');

        $this->case = $case;
        $this->discussion = $discussion;
        $this->cacheExpiryTime = now()->addMinutes(60);
    }


    // for contact people
    public function contact_people($caseManagementId)
    {
        $user             = auth()->user();
        $user_companyid   = $user->company_id;  
        $get_gendata      = CaseMasterdata::where('category_type', '=', '6')->where('company_id' ,'=' ,$user_companyid)->get();
        $get_type         = CaseMasterdata::where('category_type', '=', '7')->where('company_id' ,'=' ,$user_companyid)->get();
       // $contact_data    = DB::select('SELECT  contact_people.id contact_id , contact_people.title contact_people_title, contact_people.full_name contact_fname, countries.name countries_name  FROM `contact_people`  left join contact_people on countries.id=contact_people.country  where contact_people.case_management_id='.$caseManagementId);
        $caseManagement   = CaseManagement::find($caseManagementId);
        $notesData        = ContactPeople::where('case_management_id', '=', $caseManagementId)->get();
        $get_country      = Countries::all();
        $get_contactdata  = DB::table('contact_people')->where('case_management_id', '=', $caseManagementId)->get();
        //$get_contactdata  = DB::table('countries')->join('contact_people', 'contact_people.country', '=', 'countries.id')->where('case_management_id', '=', $caseManagementId)->get();  
       return view('Front.sections.address-book', ['caseManagementId' => $caseManagementId, 'caseManagement' => $caseManagement, 'contact_data' => $get_contactdata,'gender' => $get_gendata,'types' => $get_type,'country'=> $get_country]);

    }

    public function update_contact($caseManagementId, $id)
    {
        if ($id) {
            $caseManagement       = CaseManagement::find($caseManagementId);
            $get_country          = Countries::all();
            $user                 = auth()->user();
            $user_companyid       = $user->company_id;  
            $get_gendata          = CaseMasterdata::where('category_type', '=', '6')->where('company_id' ,'=' ,$user_companyid)->get();
            $get_type             = CaseMasterdata::where('category_type', '=', '7')->where('company_id' ,'=' ,$user_companyid)->get();
            $get_contactdata      = ContactPeople::find($id);
            $caseManagement       = CaseManagement::find($id);
            return view('Front.sections.add_contact', ['country' => $get_country, 'caseManagementId' => $caseManagementId, 'caseManagement' => $caseManagement,'contact_data' => $get_contactdata, 'gender' => $get_gendata,'types' => $get_type]);
        }
    }

    public function addcontacts($caseManagementId)
    {
        $user            = auth()->user();
        $user_companyid  = $user->company_id;  
        $get_gendata     = CaseMasterdata::where('category_type', '=', '6')->where('company_id' ,'=' ,$user_companyid)->get();
        $get_type        = CaseMasterdata::where('category_type', '=', '7')->where('company_id' ,'=' ,$user_companyid)->get();
        $get_country     = Countries::all();
        $get_contactdata = ContactPeople::all();
        $caseManagement = CaseManagement::find($caseManagementId);
        return view('Front.sections.add_contact', ['country' => $get_country, 'caseManagementId' => $caseManagementId, 'caseManagement' => $caseManagement, 'contact_data' => array(),'gender' => $get_gendata,'types' => $get_type]);
    }

    public function delete_contact()
    {
        $request         =  $_GET;

        $data            = ContactPeople::findOrFail($_GET['contact_id']);

        $data->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
        return redirect(route('cases.contact-people'));
    }

    /**
     * Author Latest Posts
     *
     * @param Request $request
     * @return Response
     */

    public  function save_contact(Request $request, $id = null)
    {
        try {
        $caseManagementId               = $request->post('caseManagementId');
        if ($_POST['contact_id']) {
        $data                           = ContactPeople::find($_POST['contact_id']);
        $data->full_name                = $request->post('full_name');
        $data->title                    = $request->post('title');
        $data->address                  = $request->post('address');
        $data->notes                    = $request->post('notes');
        $data->country                  = $request->post('country');
        $data->email                    = $request->post('email');
        $data->phone                    = $request->post('phone');
        $data->gender                   = $request->post('gender');
        $data->types                    = $request->post('types');
        $data->case_management_id       = $caseManagementId;
        $data->save();
        return redirect(route('cases.contact-people', ['caseManagementId' => $caseManagementId]))->with('success', 'Contacts updated successfully!');
        ;
        } 
        else {
        $data                           = new ContactPeople();
        $data->full_name                = $request->post('full_name');
        $data->title                    = $request->post('title');
        $data->address                  = $request->post('address');
        $data->notes                    = $request->post('notes');
        $data->country                  = $request->post('country');
        $data->email                    = $request->post('email');
        $data->phone                    = $request->post('phone');
        $data->gender                   = $request->post('gender');
        $data->types                    = $request->post('types');
        $data->case_management_id       = $caseManagementId;
        $data->save();
        return redirect(route('cases.contact-people', ['caseManagementId' => $caseManagementId]))->with('success', 'Contacts inserted successfully!');
        ;
        }
       }
        catch (\Exception $e) {
            return redirect(route('cases.contact-people', ['caseManagementId' => $caseManagementId]))->with('error', $e->getMessage())->withInput();
        }
    
    }

    public function cont_search(Request $request)
    { 
        $user             = auth()->user();
        $user_companyid   = $user->company_id;  
        $CaseManagement = (new ContactPeople)->newQuery(); 
        $gender_query='';
        $types_query='';
        $country_query='';
        $keyword_query='';
        $gender            = $request->get('gender');
        if($gender){
            $gender_query  = " and contact_people.gender in(".$gender.") ";
        } 
        $types             = $request->get('types');
        if($types){  
            $types_query   = " and contact_people.types in(".$types.") ";
        } 
        $country           = $request->get('country');
        if($country){
            $country_query = " and contact_people.country in(".$country.") ";         
        } 

        $keyword          = $request->get('search_keyword_contact');
        if($keyword){
               $keyword_query= " and  (`contact_people`.`title` like '%".$keyword."%' or `contact_people`.`full_name` like '%".$keyword."%' or `contact_people`.`address` like '%".$keyword."%' or `contact_people`.`email` like '%".$keyword."%' or `contact_people`.`phone` like '%".$keyword."%' or `contact_people`.`notes` like '%".$keyword."%')";
           } 

        $case_management_id           = $request->get('case_id');
        if($case_management_id){
            $case_management_query = " contact_people.case_management_id in(".$case_management_id.") ";         
        }   
             
        //$contact_data      = DB::table('countries')->join('contact_people', 'contact_people.country', '=', 'countries.id')->where('case_management_id', '=', $case_management_id)->where('gender', '=', $gender)->get(); 
        //$contact_data =  DB::select('SELECT * FROM `contact_people` left join case_masterdata on case_masterdata.id=contact_people.gender and case_masterdata.category_type=6 left join case_masterdata x on x.id=contact_people.types and x.category_type=7 LEFT join countries on countries.id=contact_people.country where'.$case_management_query.$gender_query.$types_query.$country_query.$keyword_query);
        $contact_data =  DB::select('SELECT contact_people.id, contact_people.full_name, contact_people.title, countries.name FROM `contact_people` left join case_masterdata on case_masterdata.id=contact_people.gender and case_masterdata.category_type=6 left join case_masterdata x on x.id=contact_people.types and x.category_type=7 LEFT join countries on countries.id=contact_people.country where'.$case_management_query.$gender_query.$types_query.$country_query.$keyword_query);

        
       return $contact_data;
    }



    /**
     * Case Discussion
     *
     * @param int $id
     * @return Response
     */
    public function discussion($id)
    {
        $sectionId = NewsCase::SECTION_DISCUSSION;
        $case = $this->case->findorFail($id);
        $discussions = $case->discussions()->get();

        return view('Front.sections.discussions', ['case' => $case, 'sectionId' => $sectionId, 'discussions' => $discussions]);
    }

    /**
     * Case Discussion save
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function discussionSave(StoreDiscussion $request, $id)
    {
        $case = $this->case->findorFail($id);

        $this->discussion->message = $request->get('message');
        $this->discussion->user()->associate(Auth::user());
        $this->discussion->case()->associate($case);
        $this->discussion->save();

        return redirect()->back()->with('success', 'Message sent!');
    }
}
