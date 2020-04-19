<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Front\StoreCase;
use App\Http\Requests\Front\UpdateCase;
use App\Http\Controllers\Controller;
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

class MapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:front');
    }

    public function map($caseManagementId)
    {
        $caseManagement   = CaseManagement::find($caseManagementId);
        $user             = auth()->user();
        $userid           = $user->id; 
        return view('Front/sections.map',['caseManagementId'=>$caseManagementId,'caseManagement'=>$caseManagement,'userid'=>$userid]);
    }
  // save map details
  /**
     * Author Latest Posts
     *
     * @param Request $request
     * @return Response
     */
    public function save_Map(Request $request)
    {
         try {
              $caseManagementId  = $request->get('caseManagementId');
              $user             = auth()->user();
              $userid           = $user->id; 
             $map = new Map();
             $map->User_id              = $userid;
             $map->latitude             = $request->get('latitude');
             $map->longitude            = $request->get('longitude');
             $map->address              = $request->get('address');
             $map->description          = $request->get('description');
             $map->index_map            = $request->get('index_map');
             $map->case_management_id   = $caseManagementId;
             $map->save();
            
             return $map;
            
          } catch (\Exception $e) {
            return "failure";
        }
    }


    public function Getmapdata($caseManagementId)
    {
        $caseManagement = CaseManagement::find($caseManagementId);
        $mapData       = Map::where('case_management_id', '=', $caseManagementId)->get();
        return $mapData;
       // return view('Front.sections.map', ['caseManagementId'=>$caseManagementId,'caseManagement'=>$caseManagement,'mapdata' =>$mapData]);
    }

    /**
     * Author Latest Posts
     *
     * @param Request $request
     * @return Response
     */
    public function update_Map(Request $request){
        
        $map_id         =  $request->get('map_id');
        try {       
        if (isset($map_id)) {
            $mapdata                  = Map::findOrFail($map_id);
            $mapdata->description     = $request->get('description');
            $mapdata->save();
            return $mapdata;
        }
      }catch (\Exception $e) {
        return "failure";
      }
    }
/**
     * Author Latest Posts
     *
     * @param Request $request
     * @return Response
     */
    public function deleteMap(Request $request){   
        $map_id         =  $request->get('map_id'); 
        try {       
        if (isset($map_id)) {
            $mapdata                  = Map::findOrFail($map_id);
            $mapdata->delete();
            return $mapdata;
        }
        }catch (\Exception $e) {
        return "failure";
      }
    }


}
