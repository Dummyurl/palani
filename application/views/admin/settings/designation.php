        <div class="main-wrapper">
           <?php $this->load->view('nav_bar'); ?>
            <div class="page-wrapper">
                <div class="content container-fluid">
					<div class="row">
						<div class="col-sm-8">
							<h4 class="page-title"><?php lang('designations'); ?></h4>
						</div>
						<div class="col-sm-4 text-right m-b-30">
							<a href="#" class="btn btn-primary rounded" data-toggle="modal" data-target="#add_designation"><i class="fa fa-plus"></i> <?php lang('add_new_designation') ?></a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped custom-table m-b-0 datatable" id="designation_table">
									<thead>
										<tr>
											<th>#</th>
											<th><?php lang('designation'); ?></th>
											<th><?php lang('department'); ?></th>
											<th class="text-right"><?php lang('action'); ?></th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
                </div>
                <!-- Popup -->
                <div id="add_designation" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title">Add Designation</h4>
						</div>
						<div class="modal-body">
							<form id="designation_form" method="post" >
								<div class="form-group">
									<label>Department Name <span class="text-danger">*</span></label>
									<select class="form-control select2-option" id="department_id" name="department_id">
										<option value="">Select Department</option>	
										<?php if(!empty($department)){
											foreach ($department as $d) {
											echo '<option value="'.$d->department_id.'">'.$d->department_name.'</option>';
											}
										} ?>									
									</select>
								</div>
								<div class="form-group">
									<label>Designation Name <span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="designation_name" id="designation_name"> 
									<input class="form-control" type="hidden" name="designation_id" id="designation_id"> 
								</div>
								<div class="m-t-20 text-center">
									<button class="btn btn-primary" type="submit">Save Designation</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div id="delete_designation" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title">Delete Designation</h4>
						</div>
						<div class="modal-body card-box">
							<p>Are you sure want to delete this?</p>
							<div class="m-t-20 text-left">
								<a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
								<button type="button" class="btn btn-danger" onclick="delete_designation()">Delete</button>
								<input type="hidden" name="designation_id" id="designation_hidden_id">
							</div>
						</div>
					</div>
				</div>
			</div>
			
        </div>
                <!-- Popup -->
				<?php $this->load->view('notifications'); ?>
			</div>
        </div>
		