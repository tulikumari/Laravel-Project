@extends('layouts.app-cm', ['withoutSidebar' => true])
@section('title', 'Cases')
@section('content')
<!--Info Top---->
<div class="inner-info">
	<div class="container">
		<h3 class="info-head">Dashboard</h3>
		<div class="inner-info-content cases">
			<div class="blocked_spaced">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div>
								<h3 class="info-head">My Cases</h3>
								<table class="table table-bordered table-hover search-case dataTable searchable_table" id="searchable_table11">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th width="60">Status</th>
                                            <th>Creator</th>
                                             
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($caseManagement as $value)
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
			<div class="blocked_spaced">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<div>
								<h3 class="info-head">My Tasks</h3>
								<table class="table table-bordered table-hover search-case dataTable searchable_table">

									<thead>

										<tr>

											<th width="40%">Task Name</th>

											<th>Assigned Group</th>

											<th>Assigned To</th>

											<th>Date</th>

											<th width="60">Status</th>

										 

										</tr>

									</thead>

									<tbody>

										@foreach ($taskManagement as $value)

											<tr class="category_5 opened_status ">

												<td class="" data-href="">{{ $value->task_name }}</td>

												<td class="" data-href="">{{ $value->group_data }}</td>

												<td class="" data-href="">{{ $value->date_to }}</td>

												<td class="" data-href="">{{ $value->date_from }}</td>

												<td class="" data-href="">
												@if($value->status =='Closed')
												   <span class="case_status close_status">{{ $value->status }}</span>
												@endif
												@if($value->status =='Pending')
													<span class="case_status pending_status">{{ $value->status }}</span>
												@endif
												@if($value->status =='Cancelled')
													<span class="case_status close_status">{{ $value->status }}</span>
												@endif
												@if($value->status =='Delete')
													<span class="case_status close_status">{{ $value->status }}</span>\
												@endif
												@if($value->status =='Done')
													<span class="case_status open_status">{{ $value->status }}</span>
												@endif
												@if($value->status =='In Progress')
													<span class="case_status yellow_status">{{ $value->status }}</span>
												@endif
												@if($value->status =='Not Started')
													<span class="case_status pending_status">{{ $value->status }}</span>
												@endif
												@if($value->status =='On Hold')
													<span class="case_status pending_status">{{ $value->status }}</span>
												@endif

												</td>

 
											</tr>

										@endforeach

									</tbody>

									</table>
							</div>
							<!--end of .table-responsive-->
						</div>
						<div class="col-md-6">
							<div>
								<h3 class="info-head">Notifications</h3>
								<table class="table table-bordered table-hover search-case dataTable">
									<thead>
										<tr>
											<th>Notification</th>
											<th>Notification</th>
											<th>Notification</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><a href="javascript:;">system 15</a></td>
											<td>Lorem ipsum</td>
											<td>Category 5</td>
										</tr>
										<tr>
											<td><a href="javascript:;">system 15</a></td>
											<td>Lorem ipsum</td>
											<td>Category 5</td>
										</tr>
										<tr>
											<td><a href="javascript:;">system 15</a></td>
											<td>Lorem ipsum</td>
											<td>Category 5</td>
										</tr>
										<tr>
											<td><a href="javascript:;">system 15</a></td>
											<td>Lorem ipsum</td>
											<td>Category 5</td>
										</tr>
										<tr>
											<td><a href="javascript:;">system 15</a></td>
											<td>Lorem ipsum</td>
											<td>Category 5</td>
										</tr>
										<tr>
											<td><a href="javascript:;">system 15</a></td>
											<td>Lorem ipsum</td>
											<td>Category 5</td>
										</tr>
										<tr>
											<td><a href="javascript:;">system 15</a></td>
											<td>Lorem ipsum</td>
											<td>Category 5</td>
										</tr>
										<tr>
											<td><a href="javascript:;">system 15</a></td>
											<td>Lorem ipsum</td>
											<td>Category 5</td>
										</tr>
										<tr>
											<td><a href="javascript:;">system 15</a></td>
											<td>Lorem ipsum</td>
											<td>Category 5</td>
										</tr>
										<tr>
											<td><a href="javascript:;">system 15</a></td>
											<td>Lorem ipsum</td>
											<td>Category 5</td>
										</tr>
										<tr>
											<td><a href="javascript:;">system 15</a></td>
											<td>Lorem ipsum</td>
											<td>Category 5</td>
										</tr>
										<tr>
											<td><a href="javascript:;">system 15</a></td>
											<td>Lorem ipsum</td>
											<td>Category 5</td>
										</tr>
										<tr>
											<td><a href="javascript:;">system 15</a></td>
											<td>Lorem ipsum</td>
											<td>Category 5</td>
										</tr>
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
