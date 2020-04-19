@extends('layouts.app-cm', ['withoutSidebar' => true])
@section('title', 'Cases')
@section('content')
<div id="catt">
<div class="inner-info">
    <div class="container">
        <h3 class="info-head addspc">Cases List</h3>
        <div class="inner-info-content cases">
            <div class="blocked_spaced">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="filters_main">
                                <h3 class="info-head">Filters</h3>
                                <div class="input-group"><input class="form-control" id="keyword" placeholder="Search keyword" /></div>
                                <div class="accordion" id="accordionExample">
                                    <div class="filters_section">
                                        <h5 class="expand_title"><a href="javascript:;" data-toggle="collapse" data-target="#categories_content" aria-expanded="false" aria-controls="categories_content">Categories<i class="fa fa-angle-down"></i></a href="javascript:;"></h5>
                                        <div id="categories_content" class="collapse" data-parent="#accordionExample">
                                            <div>
                                                @foreach($category_data as $key => $value)
                                                <div class="form-check checkbox_custom">
                                                    <input class=" form-check-input filter_address_book category_chkbox" name="category"  onClick="Search();" type="checkbox" value="{{ $value->id }}" id="{{$value->category}}">
                                                    <label class="form-check-label" for="{{$value->category}}">{{ $value->category}}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filters_section">
                                        <h5 class="expand_title"><a href="javascript:;" data-toggle="collapse" data-target="#statuses_content" aria-expanded="false" aria-controls="statuses_content">Status<i class="fa fa-angle-down"></i></a></h5>
                                        <div id="statuses_content" class="collapse" data-parent="#accordionExample">
                                            <div>
                                                @foreach($status_type as $key1 => $value1)
                                                <div class="form-check checkbox_custom">
                                                    <input class="form-check-input filter_address_book" type="checkbox"  onClick="Search();"   name="status"   value="{{ $value1 -> id}}" id="{{$value1->category}}">
                                                    <label class="form-check-label" for="{{$value1->category}}">{{ $value1-> category}}</label>
                                                </div>    
                                                @endforeach                                           
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filters_section">
                                        <h5 class="expand_title"><a href="javascript:;" data-toggle="collapse" data-target="#countries_content" aria-expanded="false" aria-controls="countries_content">Creator<i class="fa fa-angle-down"></i></a></h5>
                                        <div id="countries_content" class="collapse" data-parent="#accordionExample">
                                            <div>
                                                @foreach($usertype as $key2 => $value2)
                                                <div class="form-check checkbox_custom">
                                                    <input class="form-check-input filter_address_book"   onClick="Search();"  name="creator"   type="checkbox" value="{{ $value2->id}}" id="{{ $value2['first_name'] }}{{ $value2['last_name'] }}">
                                                    <label class="form-check-label" for="{{ $value2['first_name'] }}{{ $value2['last_name'] }}">{{ $value2['first_name'] }}{{ $value2['last_name'] }}</label>
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
                                    <a href="{{route('cases.create')}}" class="pull-right btn btn_primary" data-fancybox data-type="iframe">Add New Case</a>
                                    <h3 class="info-head">My Cases</h3>
                                </div>
                                <table class="table table-bordered table-hover search-case dataTable searchable_table" id="searchable_table11">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th width="60">Status</th>
                                            <th>Creator</th>
                                            <th class="actions_head">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($case_managementdata as $value)
                                        <?php
                                       /* $user             = auth()->user();
                                        $user_companyid   = $user->company_id;
                                        $get_catdata     = DB::table('case_masterdata')->where('company_id' ,'=' ,$user_companyid)->where('id' ,'=' ,$value['category'])->orWhere('id', '=', $value['status'])->orWhere('id', '=', $value['assignee'])->pluck('category');        
                            */
                                       ?>
                                           <tr class="category_5 opened_status cursur">
                                                <td class="creator_1tr" data-href="{{route('cases.detail_case_desc',['id'=>$value->case_id])}}"  >{{ $value->case_title}}</td>
                                                <td class="creator_1tr"  data-href="{{route('cases.detail_case_desc',['id'=>$value->case_id])}}"  >{{ str_limit($value->case_description, $limit = 200, $end = '...') }}</td>
                                                <td class="creator_1tr"   data-href="{{route('cases.detail_case_desc',['id'=>$value->case_id])}}"  >{{ $value->case_category }} </td>
                                                <td class="creator_1tr"   data-href="{{route('cases.detail_case_desc',['id'=>$value->case_id])}}"   > 
                                                    
                                               
                                                @if($value->case_status =='Closed')
												   <span class="case_status close_status">{{ $value->case_status }}</span>
												@endif
												@if($value->case_status =='Pending')
													<span class="case_status pending_status">{{ $value->case_status }}</span>
												@endif
												@if($value->case_status =='Cancelled')
													<span class="case_status close_status">{{ $value->case_status }}</span>
												@endif
												@if($value->case_status =='Delete')
													<span class="case_status close_status">{{ $value->case_status }}</span>\
												@endif
												@if($value->case_status =='Done')
													<span class="case_status open_status">{{ $value->case_status }}</span>
												@endif
												@if($value->case_status =='In Progress')
													<span class="case_status yellow_status">{{ $value->case_status }}</span>
												@endif
												@if($value->case_status =='Not Started')
													<span class="case_status pending_status">{{ $value->case_status }}</span>
												@endif
												@if($value->case_status =='On Hold')
													<span class="case_status pending_status">{{ $value->case_status }}</span>
												@endif
                                                </td>
                                                <td class="creator_1tr"   data-href="{{route('cases.detail_case_desc',['id'=>$value->case_id])}}"  ><i class="fa fa-user">{{ $value->case_fname }}{{ $value->case_lname }}</i></td>
                                                <td class="actions_td"  data-href="{{route('cases.detail_case_desc',['id'=>$value->case_id])}}"  ><a href="javascript:void(0)" class="delete_confirm"  data-id="<?php echo $value->case_id ?>" data-url="{{route('cases.delete-case')}}"><i class="fa fa-trash"></i></a><a href="{{route('cases.update_case',['id'=>$value->case_id])}}" class="edit_confirm2"  data-id="<?php echo $value->case_id ?>" data-fancybox data-type="iframe"><i class="fa fa-edit"></i></a></td>
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
</div>
<script>


$(document).ready(function() {
    var table = $('.dataTable').DataTable();
  
        table.draw();
 
} );
</script>
@endsection
