@extends('layouts.app-cm')
@section('title', 'Cases')
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment-with-locales.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
<div class="inner-info">
    <div class="container">
        <h3 class="info-head addspc">Events</h3>
        <div class="inner-info-content cases">
            <div class="blocked_spaced">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                          {{ Form::open(['method' => 'POST']) }}
                            <input type="hidden" id="events" value="{{ json_encode($events)}}">
                            <input type="hidden" name="caseManagementId" id="caseManagementId" value="{{$caseManagementId}}">
                            <div class="rightside">
                              <div class="clear"></div>
                              <div id="calendar1"></div>
                            </div>
                          {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.modal-header .close {
    margin-top: -10px !important;
}

.fc-event-container{
  color:#fff !important;
}
a.btn.btn-xs.btn-danger {
    color: #fff;
}
input#alert_interval {
    padding: 6px 4px;
}
</style>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
@include('Front.sections.event-list-dialog-box')
@include('Front.sections.event-dialog-box')
@endsection
