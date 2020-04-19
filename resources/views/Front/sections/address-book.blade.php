@extends('layouts.app-cm')

@section('title', 'Cases')

@section('content')



<div class="inner-info">

    <div class="container">

        <h3 class="info-head addspc">Address Book</h3>

        <div class="inner-info-content cases">

            <div class="blocked_spaced">

                <div class="container">

                    <div class="row">

                        <div class="col-md-3 col-sm-3">

                            <div class="filters_main">

                                <h3 class="info-head">Filters</h3>

                                <div class="input-group"><input class="form-control search_keyword_contact" id="search_keyword_contact" placeholder="Search keyword" /></div>

                                <div class="accordion" id="accordionExample">

                                <div class="filters_section">

                                        <h5 class="expand_title"><a href="javascript:;" data-toggle="collapse" data-target="#genders_content" aria-expanded="false" aria-controls="genders_content">Gender<i class="fa fa-angle-down"></i></a href="javascript:;"></h5>

                                        <div id="genders_content" class="collapse" data-parent="#accordionExample">

                                            <div>
                                            @foreach ($gender as $key => $value)
                                                <div class="form-check checkbox_custom checkbox_custom_male">
                                                <input type="hidden" name="caseManagementId" value="{{$caseManagementId}}">
                                                    <input class=" form-check-input filter_address_book gender_chkbox" onClick="Contact_Search();"  name="gender" type="checkbox" value="{{ $value->id }}" id="{{$value->category}}">

                                                    <label class="form-check-label" for="{{$value->category}}">{{$value->category}}</label>

                                                </div>
                                            @endforeach
                                            </div>

                                        </div>

                                    </div>

                                    <div class="filters_section">

                                        <h5 class="expand_title"><a href="javascript:;" data-toggle="collapse" data-target="#types_content" aria-expanded="false" aria-controls="types_content">Types<i class="fa fa-angle-down"></i></a></h5>

                                        <div id="types_content" class="collapse" data-parent="#accordionExample">

                                            <div>
                                            @foreach ($types as $key => $value)
                                                <div class="form-check checkbox_custom checkbox_custom_media">

                                                    <input class="form-check-input filter_address_book" type="checkbox" onClick="Contact_Search();" name="types" value="{{$value->id}}" id="{{$value->category}}">

                                                    <label class="form-check-label" for="{{$value->category}}">{{$value->category}}</label>

                                                </div>
                                            @endforeach
                                            </div>

                                        </div>

                                    </div>

                                    <div class="filters_section">

                                        <h5 class="expand_title"><a href="javascript:;" data-toggle="collapse" data-target="#countries_content" aria-expanded="false" aria-controls="countries_content">Countries<i class="fa fa-angle-down"></i></a></h5>

                                        <div id="countries_content" class="collapse" data-parent="#accordionExample">

                                            <div>
                                            @foreach ($country as $key => $value)
                                                <div class="form-check checkbox_custom">
                                                    <input class="form-check-input filter_address_book" name="country" onClick="Contact_Search();" type="checkbox" value="{{$value->id}}" id="{{$value->name}}">

                                                    <label class="form-check-label" for="{{$value->name}}">{{$value->name}}</label>

                                                </div>
                                                @endforeach

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-9 col-sm-9">

                            <div>

                                <div class="container_head">

                                    <a href="{{route('cases.addcontacts',['caseManagementId'=>$caseManagementId])}}" class="pull-right btn btn_primary" data-fancybox data-type="iframe">Add Contacts</a>

                                    <h3 class="info-head">Contacts</h3>

                                </div>
                                <table class="table table-bordered table-hover search-case dataTable searchable_table">
                                    <thead>
                                    <tr>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Country</th>
                                            <th class="actions_head">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($contact_data as $value)                                    
                                        <tr class="category_5 opened_status cursur">
                                            <td><span class="gender_icon male"></span><a href="javascript:;">{{ $value ->full_name }}</a></td>
                                            <td>{{ $value->title }}</td>
                                            <td><a href="mailto:jmhabis@layoutintl.com">df</a></td>
                                            <td class="actions_td"><a href="javascript:void(0)" class="delete_contact"  data-id="{{ $value->id }}" data-url="{{route('cases.delete-contact')}}"><i class="fa fa-trash"></i></a><a href="{{route('cases.update-contact',['caseManagementId'=>$caseManagementId,'id'=>$value->id])}}" data-fancybox data-type="iframe"><i class="fa fa-edit"></i></a></td>
                                        </tr>

                                     @endforeach

                                    </tbody>

                                </table>

                            </div>

                            <!--end of .table-responsive-->

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<script>
$(document).ready(function() {
    var table = $('.dataTable').DataTable();
    table.draw();
} );
</script>
@endsection

