@extends('layouts.app-cm-fancybox')
@section('title', 'Cases')
@section('content')

<div class="main-login"> 
{{ Form::open(['route' => 'cases.save_rcase', 'method' => 'POST','class' => 'form-main']) }}  		
        <div class="form-main" style="height:350px;">			
           <h1>Add Related Cases</h1>
         <div class="form_body normal_form_body">
			<div class="row">
				<div class="col-md-12 col-sm-12"> 
                <div class="input-group">          
                <input type="hidden" name="case_management_id" value="{{ $case_management_id}}">
                <input type="hidden" name="user_id" value="{{$user_id}}">  
                <input class="form-control related_cases_search" id="related_cases_search" placeholder="Search keyword" />
                <div class="form_buttons btngo" style="padding-top:0;">
                     <button type="button" class="btn pull-right btn btn_primary bttngo" >Go</button>
                </div>
                </div>  
                   <div class="input-group"  style="height:150px; overflow-y:auto; margin-top:25px; margin-bottom:25px;">
                       <div id="titlebox">
                                                  
                       </div>
                    </div> 
                </div>
			
		</div>
         <!-- // row div end -->   
            <div class="form_buttons">
                <button type="submit" class="btn pull-right btn btn_primary margin15 " id="related_sub_btn" style="display:none;" onclick="parent.closeFancyBox();">Submit</button>
            </div>
        </div> 
        {{ Form::close() }}   
    </div>
@endsection
