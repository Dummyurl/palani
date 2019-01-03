        <div class="main-wrapper">
            <?php  $this->load->view('notifications'); ?>
            <div class="page-wrapper">
                <div class="content container-fluid">
					<div class="row">
						<div class="col-md-6 col-md-offset-3">
							<h4 class="page-title"><?php lang('change_password'); ?></h4>
							<form method="post" id="password_form">
								<div class="row">
									<div class="col-xs-12 col-sm-12">
										<div class="form-group">
											<label><?php lang('old_password'); ?></label>
											<input type="password" class="form-control" name="old_password" id="old_password" onblur="check_old_pwd()"/>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-sm-6">
										<div class="form-group">
											<label><?php lang('new_password'); ?></label>
											<input type="password" class="form-control" name="new_password" id="new_password" />
										</div>
									</div>
									<div class="col-xs-12  col-sm-6">
										<div class="form-group">
											<label><?php lang('confirm_password'); ?></label>
											<input type="password" class="form-control"  name="confirm_password" id="confirm_password">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 text-center m-t-20">
										<button type="submit" class="btn btn-primary updateBtn" disabled=><?php lang('update_password') ?></button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			<?php $this->load->view('nav_bar'); ?>
			</div>
        </div>
		