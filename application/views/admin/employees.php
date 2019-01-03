<div class="main-wrapper">
	<?php $this->load->view('nav_bar'); ?>
	<div class="page-wrapper">
		<div class="content container-fluid">
			<div class="row">
				<div class="col-xs-4">
					<h4 class="page-title"><?php lang('employees'); ?></h4>
				</div>
				<div class="col-xs-8 text-right m-b-30">
					<a href="#" class="btn btn-primary pull-right rounded" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus" onClick="show_modal(0)"></i> <?php lang('add_employee'); ?></a>
					<div class="view-icons">
						<a href="javascript:void(0);" class="grid-view btn btn-link" id="staff-grid-view"><i class="fa fa-th"></i></a>
						<a href="javascript:void(0);" class="list-view btn btn-link active" id="staff-table-view"><i class="fa fa-bars"></i></a>
					</div>
				</div>
			</div>
			<div class="row filter-row">
				<div class="col-sm-3 col-xs-6">  
					<div class="form-group form-focus">
						<label class="control-label"><?php lang('employee_id'); ?></label>
						<input type="text" class="form-control floating"  name="employee_id" id="employee_ids" />
					</div>
				</div>
				<div class="col-sm-3 col-xs-6">  
					<div class="form-group form-focus">
						<label class="control-label"><?php lang('employee_name'); ?></label>
						<input type="text" class="form-control floating"  name="employee_name" id="employee_names" />
					</div>
				</div>
				
				<div class="col-sm-3 col-xs-6"> 
					<div class="form-group form-focus select-focus">
						<label class="control-label"><?php lang('designation'); ?></label>
						<select class="select floating" name="designation" id="designations" > 
							<option value=""><?php lang('select_designation'); ?></option>	
							<?php foreach($designations as $d){ ?>
								<option value="<?php echo $d['designation_id']?>"><?php echo $d['designation_name']?></option>
							 <?php } ?>						
						</select>
					</div>
				</div>
				<div class="col-sm-3 col-xs-6">  
					<a href="#" class="btn btn-success btn-block"><?php lang('search') ?></a>  
				</div>     
			</div>
			<div class="div-table"></div> <!-- ajax table -->
				 <div id='pagination'></div>
			</div>
			
		</div>
		<?php $this->load->view('notifications'); ?>
	</div>
</div>
<div id="add_employee" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="modal-content modal-lg">
			<div class="modal-header">
				<h4 class="modal-title">Add Employee</h4>
			</div>
			<div class="modal-body">
				<form class="m-b-30" id="employee_form" method="post">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><?php echo lang('first_name'); ?><span class="text-danger">*</span></label>
								<input class="form-control" type="text" id="first_name" name="first_name">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><?php echo lang('last_name'); ?></label>
								<input class="form-control" type="text" id="last_name" name="last_name">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><?php echo lang('user_name'); ?> <span class="text-danger">*</span></label>
								<input class="form-control" type="text" id="user_name" name="user_name">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><?php echo lang('email'); ?> <span class="text-danger">*</span></label>
								<input class="form-control" type="email" id="email" name="email" onkeyup="check_email()">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><?php echo lang('password'); ?> </label>
								<input class="form-control" type="password" id="password" name="password">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><?php echo lang('confirm_password'); ?></label>
								<input class="form-control" type="password" id="confirm_password" name="confirm_password">
							</div>
						</div>
						<div class="col-sm-6">  
							<div class="form-group">
								<label class="control-label"><?php echo lang('employee_id'); ?><span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="employee_id" name="employee_id">
							</div>
						</div>
						<div class="col-sm-6">  
							<div class="form-group">
								<label class="control-label"><?php echo lang('joining_date'); ?><span class="text-danger">*</span></label>
								<div class="cal-icon"><input class="form-control datetimepicker" type="text" id="joining_date" name="joining_date" ></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><?php echo lang('phone_number'); ?> </label>
								<input class="form-control" type="text" id="phone_number" name="phone_number">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><?php echo lang('company_name'); ?></label>
								<input type="text" name="company" class="form-control" value="<?php echo $this->session->userdata('company_name'); ?>" id="company_name" name="company_name">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><?php echo lang('department'); ?></label>
								<select class="form-control" id="department_id" name="department_id">
										<option value="">Select Department</option>	
										<?php if(!empty($department)){
											foreach ($department as $d) {
											echo '<option value="'.$d->department_id.'">'.$d->department_name.'</option>';
											}
										} ?>									
									</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><?php echo lang('designation'); ?></label>
								<select id="designation_id" name="designation_id" class="form-control">
									<option value="">Select Designation</option>
								</select>
							</div>
						</div>
					</div>
					<div class="m-t-20 text-center">
						<input type="hidden" name="login_id" id="login_id">
						<button class="btn btn-primary" type="submit" id="btn"><?php echo lang('save_employee'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="delete_employee" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content modal-md">
			<div class="modal-header">
				<h4 class="modal-title">Delete Employee</h4>
			</div>
			<form>
				<div class="modal-body card-box">
					<p>Are you sure want to delete this?</p>
					<div class="m-t-20"> <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
						<input type="hidden" id="employee_hidden_id" name="employee_hidden_id">
						<button type="button" class="btn btn-danger" onclick="delete_employee()"> Delete</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>		