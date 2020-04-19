@extends('layouts.app-cm')

@section('title', 'Cases')

@section('content')

<div class="wrapper">

    <!-- Page Content  -->

    <div id="content">

        <!--Info Top---->

        <div class="inner-info">

            <div class="container">

                <div class="inner-info-content cases">

                    <div class="blocked_spaced">

                        <div class="container">

                            <div class="row">

                                <div class="col-md-12 col-sm-12">

                                    <div>

                                        <div class="container_head">

                                            <a href="{{route('cases.addnotes',['caseManagementId'=>$caseManagementId])}}"  class="pull-right btn btn_primary open-fancybox">Add New Note</a>

                                            <h3 class="info-head">My Notes</h3>



                                        </div>

                                        <div class="notes_list">

                                            <div class="row">

                                                @foreach ($notes as $value)

                                                <div class="col-md-3">

                                                    <div class="note_item">

                                                        <div class="block_header">

                                                            <div class="right_side_actions actions_td "><a href="javascript:void(0)" class="note_delete"  data-id="{{ $value['id'] }}" data-url="{{route('cases.delete.notes',['caseManagementId'=>$caseManagementId,'id'=>$value['id']])}}"><i class="fa fa-trash"></i></a>
                                                            <a href="{{route('cases.view.note',['caseManagementId'=>$caseManagementId,'id'=>$value['id']])}}" class="open-fancybox"><i class="fa fa-search-plus"></i></a>
                                                            <a href="{{route('cases.update.note',['caseManagementId'=>$caseManagementId,'id'=>$value['id']])}}" class="open-fancybox"><i class="fa fa-edit"></i></a></div>

                                                            <h4 class="note_title">{{str_limit($value['note_title'], $limit = 50, $end = '...')}}</h4>

                                                            <div class="small_date">{{$value['created_at']}}</div>

                                                        </div>

                                                        <div class="note_content">{{str_limit(strip_tags(html_entity_decode($value['title_desc'], ENT_QUOTES)), $limit = 150, $end = '...')}}</div>
                                 
                                                        <div class="small_date author_content">By: <a href="javascript:;">{{ $user_name}} {{ $user_lname}}</a></div>

                                                    </div>

                                                </div>

                                                @endforeach

                                            </div>

                                        </div>

                                    </div>

                                    <!--end of .table-responsive-->

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

