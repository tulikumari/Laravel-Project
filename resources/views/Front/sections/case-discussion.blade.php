@extends('layouts.app-cm')
@section('title', 'Discussions')
@section('page-header', 'Discussions')
@section('content')
<div class="inner-info-content image_search">
    <div class="discussions_form">
        {{ Form::open(['route'=> 'cases.save-message', 'method' => 'POST']) }}
        <div class="form-group {{ $errors->first('message')?'has-error':'' }}">
            <input type="hidden" name="caseManagementId" value="{{$caseManagementId}}">
            {{ Form::textarea('message', null, ['class' => 'form-control', 'required' => 'true', 'placeholder' => 'Message', 'rows' => 4]) }}
            <span class="help-block">{{ $errors->first('message') }}</span>
        </div>
        {{ Form::button('Submit', ['type' => 'submit', 'class' => 'btn btn_primary pull-right', 'onclick' =>'validateFormt()']) }}
        {{ Form::close() }}
    </div>
    <div class="">
        @if(sizeof($get_discussiondata) > 0)
        @foreach($get_discussiondata as $val)
        <div>
            <div class="discuss_main">
                <div class="float-left blade-created"><p><strong>By</strong> <i>{{$fname}} {{$lname}}</i> <strong>On </strong> <i>{{ $val->created_at }} </i> </p></div>
                <div class="crossbox cursur delete_message_discussion float-right"  data-id="{{ $val->id }}" data-url="{{route('cases.delete-msg')}}">
                    <span id="x">X</span>
                </div>
                <div class="blade-message clear-both">
                    <p>
                    {!! nl2br(e($val->message)) !!}
                    </p>
                </div>
                
            </div>
        </div>
        @endforeach
        @else
        <p>Start Discussion</p>
        @endif
    </div>

</div>
<div class="fixed_buttons"></div>

<script>	
function validateFormt() {
  var xy = $('input[name="message"]').val();
  
  if (xy == "") {
   // alert("Name must be filled out");
    return false;
  }
   //parent.closeFancyBox(); 
}
</script>

@endsection

<style>
    .discuss_main {background: #3d4958; width: 100% !important;}    
    .crossbox {margin-left: 0px !important;height: 19px; padding-top: 1px;}
    .clear-both{clear: both;}
    .blade-created p{font-size: 16px; color:#1F262D; }
    .blade-created strong{color: #999; font-weight: bold;}
    .blade-message p{font-size: 16px;  color:#1F262D;}
    .discuss_main{padding:10px !important; background-color: #f1f1f1 !important; }
</style>