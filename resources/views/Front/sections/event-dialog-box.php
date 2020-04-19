<!-- dialog box of adding event start-->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
				<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Add Calender Event</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
								<div class="form-group col-md-12">
									<div class="col-md-4">
										<label class="control-label">Name</label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" name="eventname" id="event_name" value="">
										<div class="error" id="task_error" style="color:red"></div>
									</div>
								</div>
								<div class="form-group col-md-12">
									<div class="col-md-4">
										<label class="control-label"> From </label>
									</div>
									<div class="col-md-8">
										 <div class='input-group date' id='datetimepicker1'>
												<input type="text" class="form-control" value="" name="start_date" id="start_date"/>
												<span class="input-group-addon">
														<span class="fa fa-calendar"></span>
												</span>
										</div>
										<div class="error" id="start_error" style="color:red"></div>
									</div>
								</div>
								<div class="form-group col-md-12">
									<div class="col-md-4">
										<label class="control-label"> To </label>
									</div>
									<div class="col-md-8">
										<div class='input-group date' id='datetimepicker2'>
											 <input type="text" class="form-control" value="" name="end_date" id="end_date"/>
											 <span class="input-group-addon">
													 <span class="fa fa-calendar"></span>
											 </span>
									 </div>
										<div class="error" id="end_error" style="color:red"></div>
									</div>
								</div>
								<div class="form-group col-md-12">
									<div class="col-md-4">
										<label class="control-label"> Repeat </label>
									</div>
									<div class="col-md-8">
										<?php $repeatArray  = array('Daily','Weekly','Monthly'); ?>
										<?php if($repeatArray){ ?>
											 	<select name="repeat" id="repeat" class="form-control">
													<?php foreach($repeatArray as $item){ ?>
														<option value="<?php echo $item; ?>"><?php echo $item; ?></option>
													<?php } ?>
												</select>
										<?php } ?>
										<div class="error" id="repeat_error" style="color:red"></div>
									</div>
								</div>
								<div class="form-group col-md-12">
									<div class="col-md-4">
										<label class="control-label">Location</label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" name="location" id="location" value="">
										<div class="error" id="location_error" style="color:red"></div>
									</div>
								</div>
								<div class="form-group col-md-12">
									<div class="col-md-4">
										<label class="control-label"> Groups </label>
									</div>
									<div class="col-md-8">
									 <?php if($groupData){ ?>
												<select name="groups" id="groups" class="form-control">
													 <?php foreach($groupData as $item){  ?>
														 <option value="<?php echo $item->id; ?>"><?php echo $item->category; ?></option>
													<?php } ?>
												</select>
										<?php } ?>
										<div class="error" id="groups_error" style="color:red"></div>
									</div>
								</div>
								<div class="form-group col-md-12">
									<div class="col-md-4">
										<label class="control-label"> Alert </label>
									</div>
									<div class="col-md-3">
											<select name="alert_by" id="alert_by" class="form-control">
													 <option value="dashboard">Dashboard</option>
											</select>
											<div class="error" id="alert_by_error" style="color:red"></div>
									</div>
									<div class="col-md-2">
										<input type="number" class="form-control" name="alert_interval" id="alert_interval" min="1" value="1" step="1">
										<div class="error" id="alert_interval" style="color:red"></div>
									</div>
									<div class="col-md-3">
											<select name="alert_by" id="alert_timing" class="form-control">
													 <option value="days">Days</option>
													 <option value="hours">Hours</option>
											</select>
											<div class="error" id="alert_timing_error" style="color:red"></div>
									</div>

								</div>
								<div class="form-group col-md-12">
									<div class="col-md-4">
										<label class="control-label"> Note</label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" id="description" name="description">
										<div class="error" id="des_error" style="color:red"></div>
									</div>
								</div>

					  	</div>
							<input type="hidden" name="event_id" id="event_id"/>
							<div class="modal-footer">
								<div class="col-md-12">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<input type="submit" id="add_event" class="pull-right btn btn_primary event_task"  value="Add Event">
								</div>
							</div>
				 </div>
		 </div>
</div>
<!-- end dialog box -->
