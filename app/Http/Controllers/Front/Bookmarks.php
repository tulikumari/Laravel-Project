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

class Bookmarks extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:front');
    }

    public function bookmark($caseManagementId)
    {
        $caseManagement         = CaseManagement::find($caseManagementId);
        $user             = auth()->user();
        $userid           = $user->id;
        return view('Front.sections.book-mark',['caseManagementId' => $caseManagementId, 'caseManagement' => $caseManagement,'user_id'=> $userid]);
       
    }
    // save map details
  /**
     * Author Latest Posts
     *
     * @param Request $request
     * @return Response
     */
    public function saveBookmark(Request $request)
    {
         try {
             $caseManagementId                 = $request->post('caseManagementId');
             $bookmark                         = new Bookmark();
             $bookmark->user_id                = $request->post('user_id');
             $bookmark->case_management_id     = $caseManagementId;
             $bookmark->bookmark_details       = $request->post('bookmark_details');
             $bookmark->bookmark_from          = $request->post('bookmark_from');
             $bookmark->save(); 
             return $bookmark; 
         } catch (\Exception $e) {
            return "failure";
        }
    } 

    /**
     * Author Latest Posts
     *
     * @param Request $request
     * @return Response
     */
    public function deleteBookmark(Request $request){   
        $bookmark_id         =  $request->get('bookmark_id'); 
        try {       
        if (isset($bookmark_id)) {
            $bookmark_data                  = Bookmark::findOrFail($bookmark_id);
            $bookmark_data->delete();
            return $bookmark_data;
        }
        }catch (\Exception $e) {
        return "failure";
      }
    }

    public function Get_bookmarkdata($caseManagementId)
    {
        $caseManagement = CaseManagement::find($caseManagementId);
        $markData       = Bookmark::where('case_management_id', '=', $caseManagementId)->get();
        return $markData;
    }
   
}
