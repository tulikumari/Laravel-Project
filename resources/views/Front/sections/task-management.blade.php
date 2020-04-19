@extends('layouts.app-cm')

@section('title', 'Task')

@section('page-header', 'Task Management')

@section('content')

<style>
 td, th{ word-break:break-all; }
</style>

<div class="inner-info">

    <div class="container">

        <div class="inner-info-content cases">

            <div class="blocked_spaced">

                <div class="container">

                    <div class="row">

                        <div class="col-md-12 col-sm-12">

                            <div>

                                <div class="container_head">

                                    <a href="{{route('cases.task-management',['caseManagementId'=>$caseManagementId])}}" data-fancybox data-type="iframe" class="pull-right btn btn_primary ">Add Task</a>

                                    <h3 class="info-head">Task</h3>

                                </div>

                                <table class="table table-bordered table-hover search-case dataTable searchable_table">

                                    <thead>

                                        <tr>

                                            <th width="40%">Task Name</th>

                                            <th>Assigned Group</th>

                                            <th>Assigned To</th>

                                            <th>Date</th>

                                            <th>Status</th>

                                            <th class="actions_head">Actions</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach ($task_mgmtdata as $value)

                                            <tr class="category_5 opened_status ">

                                                <td class="" data-href="">{{ $value['task_name'] }}</td>

                                                <td class="" data-href="">{{ $value['assigned_group'] }}</td>

                                                <td class="" data-href="">{{ $value['assigned_to'] }}</td>

                                                <td class="" data-href="">{{ $value['date_from'] }}</td>

                                                <td class="" data-href="">{{ $value['task_status'] }}</td>

                                                <td class="actions_td"><a href="javascript:void(0)" class="delete_taskconfirm"   data-id="{{ $value['id'] }}" data-url="{{route('cases.delete-task-case')}}"><i class="fa fa-trash"></i></a><a href="{{route('cases.updatetask_case',['caseManagementId'=>$caseManagementId,'id'=>$value['id']])}}" class="edit_confirm2" data-id="<?php echo $value['id'] ?>" data-fancybox data-type="iframe"><i class="fa fa-edit"></i></a></td>

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

