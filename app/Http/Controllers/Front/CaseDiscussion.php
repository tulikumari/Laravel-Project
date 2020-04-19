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

class CaseDiscussion extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:front');
    }

    public function casediscussions($caseManagementId)
    {
      
        $caseManagement         = CaseManagement::find($caseManagementId);
        $get_discussiondata     = DiscussionCase::where('case_management_id', '=', $caseManagementId)->orderBy('id', 'DESC')->get();
        $user                   = auth()->user();
        $user_id                = $user->id;
        $user_fname              = $user->first_name; 
        $user_lname             = $user->last_name; 
        return view('Front.sections.case-discussion', ['caseManagementId' => $caseManagementId, 'caseManagement' => $caseManagement, 'get_discussiondata' => $get_discussiondata,'fname'=> $user_fname,'lname'=> $user_lname]);
    }

    public function saveMessage(Request $request, $id = null)
    {

        $caseManagementId                       = $request->post('caseManagementId');
        $caseManagement                         = new DiscussionCase();
        $caseManagement->case_management_id     = $request->post('caseManagementId');
        $caseManagement->message                = $request->post('message');
        $caseManagement->save();
        return redirect(route('cases.case-discussions', ['caseManagementId' => $caseManagementId, 'caseManagement' => $caseManagement]));
    }
    public function deleteMessage()
    {
        $request         =  $_GET;
        $data = DiscussionCase::findOrFail($_GET['msg_id']);
        $data->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
        return redirect(route('case-discussion'));
    }
}
