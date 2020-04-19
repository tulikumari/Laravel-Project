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
use App\Models\File;
use App\Models\Map;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:front');
    }

    public function fileUpload($caseManagementId)
    {
        $caseManagement = CaseManagement::find($caseManagementId);
        return view('Front.sections.file-upload',['caseManagementId'=>$caseManagementId,'caseManagement'=>$caseManagement]);
    }

    /**
     * Updata title, description in file
     *
     * @param int $id
     * @return Response
     */
    public function updateData(Request $request)
    {

        try {
            $id = $request->post('id');
            $file = File::find($id);
            if($request->post('act')=='title'){
                $file->title = $request->post('title')?$request->post('title'):'';
            }else if($request->post('act')=='decription'){
                $file->description = $request->post('decription')?$request->post('decription'):'';
            }
            $isUpdated = $file->save();
            if($isUpdated){
                return response()->json(['success'=>true]);
            }
            return response()->json(['success'=>false]);
        } catch (\Exception $e) {
            return response()->json(['success'=>false]);
        }
    }
}
