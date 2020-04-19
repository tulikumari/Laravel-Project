@extends('layouts.app-cm-fancybox')

@section('title', 'Tasks')

@section('content')

    <div class="main-login">

        {{ Form::open(['route' => 'cases.task-case-management', 'method' => 'POST','class' => 'form-main']) }}

        <div class="form-main">
        @if($task_managementupdata && $task_managementupdata['id'])
           <h1>Edit Task</h1>
           @else
            <h1>Add Task</h1>   
           @endif
            <div class="form_body normal_form_body">
            <div class="row">
            <div class="col-md-6 col-sm-6">
            <div class="font_white">Task Name</div>
                <div class="input-group">

                    <input type="hidden" name="task_id" value="{{ $task_managementupdata?$task_managementupdata['id']:''}}">

                    <input type="hidden" name="caseManagementId" value="{{$caseManagementId}}">

                    <input type="text" required  name="task_name" class="form-control" value="{{ $task_managementupdata?$task_managementupdata['task_name']:''}}" />

                </div>
                <div class="font_white">Date From</div>
                <div class="input-group">

                    <input type="date" readonly  name="date_from" value="{{  $task_managementupdata?$task_managementupdata['date_from']:''}}" class="form-control" />

                </div>
                <div class="font_white">Assigned To</div>
                <div class="input-group">
                
                    <select class="form-control" placeholder="Assigned To" name="assigned_to">
                    <option value="">Assigned To</option>
                        @foreach ($user_type as $key1 => $value1)
                        
                        <option value="{{$value1->id}}" @if($task_managementupdata && $task_managementupdata['assigned_to'] == $value1->id) selected @endif>{{ $value1->first_name.' '.$value1->last_name }}</option>

                        @endforeach

                    </select>

                </div>
                <div class="font_white">Location</div>
                <div class="input-group">
                    <input type="text"  name="location" class="form-control" value="{{ $task_managementupdata?$task_managementupdata['location']:''}}" />

                </div>
                <div class="font_white">Task Status</div>
                <div class="input-group">

                    <select class="form-control" name="task_status" id="task_status" required>

                        <option value="">Task Status</option>

                        @foreach ($status_type as $key2 => $value2)

                        <option value="{{ $value2?$value2['id']:''}}" @if($task_managementupdata && $task_managementupdata['task_status'] == $value2['id']) selected @endif>{{ $value2['category'] }}</option>

                        @endforeach

                    </select>

                </div>
            </div>
            <div class="col-md-6 col-sm-6"> 
            <div class="font_white">Assigned Group</div>
                <div class="input-group">
                    <select class="form-control" placeholder="Assigned Group" name="assigned_group" id="assigned_group" required>
                        @if($assignedGroups)
                        <option value="">Assigned Group</option>
                             @foreach($assignedGroups as $group)                            
                                <option value="{{ $group->id}}" @if($task_managementupdata && $task_managementupdata['assigned_group'] == $group->id) selected @endif>{{$group->category}}</option>
                             @endforeach
                        @endif
                    </select>

                </div>
                <div class="font_white">Date To</div>
                <div class="input-group">

                    <input type="date" placeholder="Date To" name="date_to" value="{{ $task_managementupdata?$task_managementupdata['date_to']:''}}" class="form-control" />

                </div>
                <div class="font_white">Alert</div>
                <div class="input-group">
                    <input type="text" name="alert_value" class="form-control" value="{{ $task_managementupdata?$task_managementupdata['alert_value']:''}}" />
                    <select class="form-control" placeholder="Alert" name="alert">
                    <option value="">Alert</option>
                        @foreach ($alert as $key1 => $value3)
                        
                        <option value="{{ $value3?$value3['id']:''}}" @if($task_managementupdata && $task_managementupdata['alert'] == $value3['id']) selected @endif>{{ $value3['category'] }}</option>

                        @endforeach

                    </select>

                </div>

                <div class="font_white">Notes</div>
                <div class="input-group">

                    <textarea  name="notes" class="form-control">{{ $task_managementupdata?$task_managementupdata['notes']:''}}</textarea>

                </div>

                <div class="form_buttons">
                    <button type="button" class="btn pull-right btn btn_primary" onclick="parent.closeFancyBox();$('form').attr('action', '');">Close</button>


                    <button type="submit" class="btn pull-right btn btn_primary margin15" onclick="validateFormt()">Submit</button>

                </div>
           </div> 

            </div>
        </div>
            {{ Form::close() }}

        </div>

    </div>
    <script>	
function validateFormt() {
  //var x = document.getElementById("full_name").value;
  var xy = $('input[name="task_name"]').val();
  var task_status = $( "#task_status option:selected" ).val();
  var assigned_group =  $( "#assigned_group option:selected" ).val();
  var alert_value = $('input[name="alert_value"]').val();
  
  
  if (xy == "") {
   // alert("Name must be filled out");
    return false;
  }
  else if (task_status == "") {
   // alert("Name must be filled out");
    return false;
  }
  else if (assigned_group == "") {
   // alert("Name must be filled out");
    return false;
  }
   parent.closeFancyBox();
  
  
}
</script>
@endsection

