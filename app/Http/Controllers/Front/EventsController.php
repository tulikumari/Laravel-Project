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
use App\Models\CaseMasterdata;
use App\Models\CaseCategory;
use App\Models\TaskManagement;
use App\Models\Notes;
use App\Models\Countries;
use App\Models\Events;
use App\Models\Map;
use Carbon\Carbon;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:front');
    }

    public function events($caseManagementId)
    {
        $groupData      = CaseMasterdata::where('category_type', '=', 8)->get();
        $eventsObj      = Events::where('case_management_id', '=', $caseManagementId)->get();
        $eventsFilter = $eventsObj->map(function ($event) {
            return collect($event->toArray())
        ->only(['id','event_name','event_description','event_startdate','event_enddate','case_management_id','type','repeat_event'])
        ->all();
        });
        $events = $eventsFilter->toArray();
        $caseManagement = CaseManagement::find($caseManagementId);
        return view('Front.sections.events', ['caseManagementId'=>$caseManagementId,'caseManagement'=>$caseManagement,'events'=>$events,'groupData'=>$groupData]);
    }

    public function saveEvent(Request $request)
    {
        try {
            $caseManagementId                = $request->post('caseManagementId');
            if ($request->post('eventId')) {
                $events = Events::find($request->post('eventId'));
                $events->event_name            = $request->post('event_name');
                $events->event_description     = $request->post('description');
                $events->repeat_event          = $request->post('repeat');
                $events->location              = $request->post('location');
                $events->groups                = $request->post('groups');
                $events->alert_by              = $request->post('alert_by');
                $events->alert_interval        = $request->post('alert_interval');
                $events->alert_timing          = $request->post('alert_timing');
                $events->event_startdate       = Carbon::parse($request->post('start_date'));
                $events->event_enddate         = Carbon::parse($request->post('end_date'));
                $events->case_management_id    = $request->post('caseManagementId');
                $events->type                  = 1;
                $events->updated_at            = Carbon::now();
                $events->save();
                return response()->json(['success' => true]);
            } else {
                $events = new Events();
                $events->event_name            = $request->post('event_name');
                $events->event_description     = $request->post('description');
                $events->repeat_event          = $request->post('repeat');
                $events->location              = $request->post('location');
                $events->groups                = $request->post('groups');
                $events->alert_by              = $request->post('alert_by');
                $events->alert_interval        = $request->post('alert_interval');
                $events->alert_timing          = $request->post('alert_timing');
                $events->event_startdate       = Carbon::parse($request->post('start_date'));
                $events->event_enddate         = Carbon::parse($request->post('end_date'));
                $events->case_management_id    = $request->post('caseManagementId');
                $events->type                  = 1;
                $events->created_at            = Carbon::now();
                $events->updated_at            = Carbon::now();
                $events->save();
                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }

    public function getEventListing(Request $request)
    {
        try {
              $eventId   = $request->get('eventId');
              $events    = Events::getEvent($eventId);
              $tbody_str = "";
              $tbody_str.='<tr>';
                $tbody_str.='<td><center>'.$events->event_name.'</center></td>';
                $tbody_str.='<td><center>'.$events->location.'</center></td>';
                $tbody_str.='<td><center>'.$events->event_description.'</center></td>';
                $tbody_str.='<td><center>';
                $tbody_str.='<a href="javascript:void(0)" data-id="'.$events->id.'" data-act ="edit" class="btn btn-xs btn-default" onClick="event_task(this)";><i class="fa fa-pencil"></i> Edit</a>';
                $tbody_str.='&nbsp;&nbsp;<a class="btn btn-xs btn-danger" "href="javascript:void(0)" data-id="'.$events->id.'" data-act ="del" onClick="event_task(this);"><i class="fa fa-remove"></i>Delete</a>';
                $tbody_str.='</center></td>';
              $tbody_str.='</tr>';
              return response()->json(['success' => true,'tbody_str'=>$tbody_str]);

        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }

    public function getEvent(Request $request)
    {
        try {
              $eventId    = $request->get('eventId');
              $eventObj   = Events::getEvent($eventId);
              $events     = $eventObj->getOriginal();
              return response()->json(['success' => true,'events'=>$events]);
        } catch (\Exception $e) {
            return response()->json(['success' => $e]);
        }
    }


    public function deleteEvent(Request $request)
    {

        try {
              $eventId    = $request->get('eventId');
              $isDeleted  = Events::where('id','=',$eventId)->delete();
              if($isDeleted){
                return response()->json(['success' => true]);
              }else{
                return response()->json(['success' => false]);
              }
        } catch (\Exception $e) {
            return response()->json(['success' => $e]);
        }
    }

}
