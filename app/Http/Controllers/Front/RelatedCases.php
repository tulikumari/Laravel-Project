<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Front\StoreCase;
use App\Http\Requests\Front\UpdateCase;
use App\Http\Controllers\Controller;
use App\Helpers\CommonHelper;
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
use App\Models\Map;
use App\Models\DiscussionCase;
use App\Models\Bookmark;
use App\Models\Relatedcase;
use App\Models\CaseMasterdata;
use Illuminate\Support\Facades\DB;

class RelatedCases extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:front');
    }

    public function relatedcases($caseManagementId)
    {
        $caseManagement   = CaseManagement::find($caseManagementId);
        $user             = auth()->user();
        $userid           = $user->id;
        $relatecase       = RelatedCase::where('case_management_id','=',$caseManagementId)->get();
        $caseid = "";
        // $i = 0;
        // foreach ($relatecase as $value){
        //     $caseid .= $value['related_case_id'].",";
        //     $i++;
        //  }
        //  $caseid = substr($caseid, 0, -1);
         $casedata =  DB::select('SELECT related_cases.id related_id, case_management.id case_id , case_management.title case_title, case_management.description case_description, case_masterdata.category case_category, users.first_name case_fname, users.last_name case_lname, x.category case_status FROM `case_management`  left join case_masterdata on case_masterdata.id=case_management.category and case_masterdata.category_type=1 left join case_masterdata x on x.id=case_management.status and x.category_type=3  LEFT join users on users.id=case_management.user_id join related_cases on related_cases.related_case_id=case_management.id AND related_cases.case_management_id = "'.$caseManagementId.'"');
         // $casedata[$i]         = CaseManagement::where('id' ,'=',$value['related_case_id'])->get();  
        
        return view('Front.sections.related-cases-mgmt',['caseManagementId' => $caseManagementId, 'caseManagement' => $caseManagement,'user_id'=> $userid, 'relatecase' => $relatecase, 'casedata' => $casedata]);
          
    }

    public function addrelatedcase($caseManagementId)
    {
        $user            = auth()->user();
        $user_companyid  = $user->company_id;
        $get_catdata     = CaseManagement::where('company_id' ,'=' ,$user_companyid)->where('id' ,'!=' ,$caseManagementId)->get();
        return view('Front.sections.add_relatedcase', ['withoutSidebar' => 1,'case_title' => $get_catdata,'case_management_id' =>$caseManagementId,'user_id' =>$user->id]);
    }

    public function save_rcase(Request $request, $id = null)
    {
        $related_cases                  = $request->post('related_case');
      
        foreach($related_cases as $key => $val){
           // $casecheck =  DB::select('SELECT related_cases.id related_id FROM `related_cases` where related_cases.case_id = "'.$caseManagementId.'" AND related_cases.related_case_id = "'.$val.'"');
           // Debugbar::info('Meglévő frissítése');
            // if(collect($casecheck)->first()) {
                $relate                         = new RelatedCase();
                $relate->user_id                = $request->post('user_id');
                $relate->case_management_id                = $request->post('case_management_id');
                $relate->related_case_id        = $val;
                // print_r($relate);
                $relate->save();
          //  }
        }     
    }

    public function relatecase_search(Request $request)
    {
        $key                = $request->get('key');
        $case_management_id = $request->get('case_management_id'); 
        $user               = auth()->user();
        $user_companyid     = $user->company_id;
        $get_catdata =  DB::select('SELECT * FROM `case_management` WHERE `id` not in (select related_cases.related_case_id from related_cases where related_cases.case_management_id="'.$case_management_id.'") and company_id="'.$user_companyid.'" and title LIKE "%'.$key.'%"');
        // $get_catdata        = CaseManagement::where('company_id' ,'=' ,$user_companyid)->where('id' ,'!=' ,$case_management_id)->where('title', 'LIKE', "%{$key}%")->get();
        return $get_catdata;

    }

    public function delete_relate_case($caseManagementId)
    {
        try {
            $relate = RelatedCase::findOrFail($caseManagementId);
            $relate->delete();
            return response()->json([
                'success' => 'Related case deleted successfully!'
            ]);
            return redirect(route('cases.files'));
        }catch (\Exception $e) {
            return redirect(route('cases.files'))->with('error', $e->getMessage())->withInput();
        }
    }
    

}
