@extends('layouts.app-cm-fancybox')
@section('title', 'Cases')
@section('content')

    <div class="main-login">
        {{ Form::open(['route' => 'cases.save-case-management', 'method' => 'POST','class' => 'form-main']) }}		
        <div class="form-main">			
		@if($case_managementupdata && $case_managementupdata['id'])
           <h1>Edit Case</h1>
           @else
            <h1>Add Case</h1>   
           @endif   
            <div class="form_body normal_form_body">
				<div class="row">
				   <div class="col-md-6 col-sm-6">
						<div class="font_white">Title</div>  
						<div class="input-group">                    
							<input type="hidden" name="case_id" value="{{ $case_managementupdata?$case_managementupdata['id']:''}}">
							<input type="hidden" name="user_id" value="{{$user?$user['id']:''}}">
							<input type="hidden" name="company_id" value="{{$user?$user['company_id']:''}}">
							<input type="text" required  name="title" id="title" class="form-control"  value="{{ $case_managementupdata?$case_managementupdata['title']:''}}" />
							<span></span>
						</div>
						<div class="font_white">Case Keywords</div>  
						 <div class="input-group">
							<textarea placeholder="Case Keywords" name="case_keywords" class="form-control">{{ $case_managementupdata?$case_managementupdata['case_keywords']:''}}</textarea>
						</div> 
						<!-- <div class="input-group"><input type="email" placeholder="Email" class="form-control" /></div> -->
						<div class="font_white">Select Users</div>
						<div class="input-group">
							<select class="form-control" placeholder="Assignee" name="assignee">
								<option value="">Select Users</option>
								@foreach ($user_type as $key1 => $value1)
								<option value="{{$value1['id']}}" @if($case_managementupdata && $case_managementupdata['assignee'] == $value1['id']) selected @endif>{{ $value1['first_name'] }}{{ $value1['last_name'] }}</option>
								@endforeach
							</select>
						</div>

						<div class="font_white">Country</div>
						 <div class="input-group">
							<select class="form-control" placeholder="Country" name="country">
								<option value="">Country</option>
								@foreach ($country as $key1 => $value1)
								<option value="{{ $value1['id'] }}" @if($case_managementupdata && $case_managementupdata['country'] == $value1['id']) selected @endif >{{ $value1['name'] }}</option>
								@endforeach
							</select>
						</div>
						<div class="font_white">Status</div>
						<div class="input-group">
							<select class="form-control" placeholder="status" name="status">
								<option value="">--- Select status ---</option>
								@foreach ($status_type as $key2 => $value2)
								<option value="{{$value2['id']}}" @if($case_managementupdata && $case_managementupdata['status'] == $value2['id']) selected @endif>{{ $value2['category'] }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="font_white"> Case Category </div>
						<div class="input-group">
							<select class="form-control" placeholder="Choose your category" name="category">
								<!-- <option value="">Case Category</option> -->
								@foreach ($category_data as $key => $value)
								<option value="{{$value['id']}}" @if($case_managementupdata && $case_managementupdata['category'] == $value['id']) selected @endif>{{ $value['category'] }}</option>
								@endforeach
							</select>
						</div>
						<div class="font_white">Description</div>
						<div class="input-group">

							<textarea placeholder="Description" name="description"  rows="14"  class="form-control">{{ $case_managementupdata?$case_managementupdata['description']:''}}</textarea>
						</div>
						<div class="font_white">Assigned To</div>
						 <div class="input-group">
							<select class="form-control" placeholder="Assigned To" name="assigned_to">
								<option value="">Assigned To</option>
								@foreach ($user_type as $key1 => $val)
								<option value="{{$val['id']}}" @if($case_managementupdata && $case_managementupdata['assigned_to'] == $val['id']) selected @endif >{{ $val['first_name'] }} {{ $val['last_name'] }}</option>
								@endforeach
							</select>
						</div>	
						<div class="font_white">Case Info</div>						
						<div class="input-group">
							<textarea placeholder="Case Info" name="case_info" class="form-control" />{{ $case_managementupdata?$case_managementupdata['case_info']:''}}</textarea>
						</div>
						
					</div>
				</div>
                <!-- // row div end -->
               
            <div class="form_buttons">
				<button type="submit" class="btn pull-right btn btn_primary" onclick="parent.closeFancyBox('0');$('form').attr('action', '');">close</button>
             
                <button type="submit" class="btn pull-right btn btn_primary margin15" onclick="validateForm()">Submit</button>
            </div>
        </div>

        {{ Form::close() }}
    </div>
<script>	
function validateForm() {
  var x = document.getElementById("title").value;
  if (x == "") {
   // alert("Name must be filled out");
    return false;
  }
  parent.closeFancyBox();
}
</script>
@endsection
