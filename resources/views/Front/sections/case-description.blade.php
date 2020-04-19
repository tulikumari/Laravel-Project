@extends('layouts.app-cm')
@section('title', '')
@section('page-header', 'Description')
@section('content')
<div class="inner-info">
    <div class="container">

        <div class="inner-info-content cases">
            <div class="blocked_spaced">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div>
                                <div class="container_head">
                                    <a href="{{route('cases.update_case',$case_detail?$case_detail['id']:'')}}" data-fancybox data-type="iframe" class="pull-right btn btn_primary">EDIT</a>
                                </div>
                                <div class="notes_list">
                                    <div class="row">
                                                <div class="col-md-6 case-bod">
                                                    <div class="boldTitle">Case Title</div>
                                                    <div class="note_content">{{ $case_detail?$case_detail['title']:''}}</div>
                                                </div>
                                                <div class="col-md-6 case-bod">
                                                    <div  class="boldTitle">Case Category</div>
                                                    <div class="note_content">{{ $category_name?$category_name:''}}</div>
                                                </div>
                                              <div class="col-md-6 case-bod">
                                                    <div class="boldTitle">Case Keywords</div>
                                                    <div class="note_content">{{ $case_detail?$case_detail['case_keywords']:''}}</div>
                                                </div>

                                                <div class="col-md-6 case-bod">
                                                    <div class="boldTitle">User</div>
                                                    <div class="note_content">{{ $assign_user?$assign_user:''}}</div>
                                                </div>

                                                <div class="col-md-6 case-bod">
                                                    <div  class="boldTitle">Assigned To</div>
                                                    <div class="note_content">{{ $assign_user_to?$assign_user_to:''}}</div>
                                                </div>
                                                <div class="col-md-6 case-bod">
                                                    <div  class="boldTitle">Country</div>
                                                    <div class="note_content">{{ $country?$country:''}}</div>
                                                </div>
                                                <div class="col-md-6 case-bod">
                                                    <div  class="boldTitle">Case Status</div>
                                                    <div class="note_content">{{ $status?$status:''}}</div>
                                                </div>                                                
                                                <div class="col-md-6 case-bod">
                                                    <div class="boldTitle" >Case Info</div>
                                                    <div class="note_content">{{ $case_detail?$case_detail['case_info']:''}}</div>
                                                </div>


                                                <div class="col-md-6 case-bod">
                                                    <div  class="boldTitle">Description</div>
                                                    <div class="note_content">{{ $case_detail?$case_detail['description']:''}}</div>
                                                </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--end of .table-responsive-->
                    </div>
                </div>
            </div>
        </div>
        @endsection
