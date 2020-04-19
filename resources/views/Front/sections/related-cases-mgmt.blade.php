@extends('layouts.app-cm')

@section('title', 'Cases')

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
                                    <a href="{{route('cases.addrelatedcase',['caseManagementId'=>$caseManagementId])}}" data-fancybox data-type="iframe" class="pull-right btn btn_primary ">Add Related Cases</a>
                                    <h3 class="info-head">Related Cases</h3>

                                </div>
                                <table class="table table-bordered table-hover search-case dataTable searchable_table">
                                    
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Creator</th>
                                            <th class="actions_head">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody> 
                                    @foreach ($casedata as $value)                       
                                            <tr cliass="category_5 opened_status">

                                                <td class="creator_1tr"  data-href="{{route('cases.detail_case_desc',['id'=>$value->case_id])}}">{{ $value->case_title}}</td>

                                                <td class="creator_1tr"  data-href="{{route('cases.detail_case_desc',['id'=>$value->case_id])}}">{{ str_limit($value->case_description, $limit = 50, $end = '...') }}</td>

                                                <td class="creator_1tr"  data-href="{{route('cases.detail_case_desc',['id'=>$value->case_id])}}">{{ $value->case_category }}</td>

                                                <td class="creator_1tr"  data-href="{{route('cases.detail_case_desc',['id'=>$value->case_id])}}">{{ $value->case_status }}</td>

                                                <td class="creator_1tr"  data-href="{{route('cases.detail_case_desc',['id'=>$value->case_id])}}">{{ $value->case_fname }}{{ $value->case_lname }}</td>

                                                <td class="actions_td"><a href="javascript:void(0)" class="delete_relate_btn"  data-id="{{ $value->related_id }}" data-url="{{route('cases.delete-relate-case',['caseManagementId'=>$value->related_id])}}"><i class="fa fa-trash"></i></a></td>
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
});
</script>
@endsection