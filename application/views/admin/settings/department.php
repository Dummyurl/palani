	<div class="main-wrapper">
		<?php $this->load->view('nav_bar'); ?>
		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="row">
					<div class="col-sm-8">
						<h4 class="page-title"><?php lang('department'); ?></h4>
					</div>
					<div class="col-sm-4 text-right m-b-30">
						<a href="#" class="btn btn-primary rounded" data-toggle="modal" data-target="#add_department" onclick="show_modal(0)"><i class="fa fa-plus"></i> <?php lang('add_new_department'); ?></a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div>
							<table class="table table-striped custom-table m-b-0 datatable" id="department_table">
								<thead>
									<tr>
										<th>#</th>
										<th><?php lang('department_name'); ?></th>
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
			<div id="delete_department" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title">Delete Department</h4>
						</div>
						<div class="modal-body card-box">
							<p>Are you sure want to delete this?</p>
							<div class="m-t-20 text-left">
								<a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
								<button type="button" class="btn btn-danger" onclick="delete_department()">Delete</button>
								<input type="hidden" name="department_id" id="department_hidden_id">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="add_department" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title"></h4>
						</div>
						<div class="modal-body">
							<form method="post" id="department_form">
								<div class="form-group">
									<label><?php lang('department_name'); ?><span class="text-danger">*</span></label>
									<input class="form-control"  name="department_name" id="department_name" type="text">
									<input type="hidden" class="form-control"  name="department_id" id="department_id" >
								</div>
								<div class="m-t-20 text-center">
									<button class="btn btn-primary" type="submit" > <?php lang('save_new_department'); ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>			
        </div>
        <!-- Popup --> 
				<!-- Notifications -->
				<?php $this->load->view('notifications'); ?>
				<!-- Notifications -->
		</div>
	</div>
