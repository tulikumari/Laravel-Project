<!-- dialog box of adding event start-->
		<div class="modal fade" id="event_list_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title" id="myModalLabel">Event Listing</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>

					</div>
					<div class="modal-body">
 				 		<table class="table table-striped table-hover table-bordered" id="event_table">
							<thead>
								<tr>
									<th><center>Name</center></th>
									<th><center>Location</center></th>
									<th><center>Note</center></th>
									<th><center>Action</center></th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						  </table>
				  	</div>
				  	<div class="modal-footer">
				  		<a href="javascript:void(0)" onClick="$('#event_list_modal').hide();$('#addModal').modal();"><button class="btn btn_primary  add_btn">Add Event <i class="fa fa-plus"></i></button></a>
				  	</div>
				</div>
			</div>
		</div>
		<!-- end dialog box -->
