   <div class="main-wrapper">
           <?php $this->load->view('nav_bar'); ?>
            <div class="page-wrapper">
                <div class="content container-fluid">
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<form id="company_settings" method="post" >
								<h3 class="page-title"><?php lang('company_details'); ?></h3>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('company_name'); ?><span class="text-danger">*</span></label>
											<input class="form-control" type="text" placeholder="Focus Technologies" name="company_name" id="company_name">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('contact_person'); ?></label>
											<input class="form-control " placeholder="Daniel Porter" type="text" name="contact_person" id="contact_person" >
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label><?php lang('address'); ?></label>
											<input class="form-control " placeholder="3864 Quiet Valley Lane, Sherman Oaks, CA" name="address" id="address" type="text">
										</div>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-3">
										<div class="form-group">
											<label><?php lang('country'); ?></label>
											<select class="form-control select2-option" name="country_id" id="country">
												<option value="">Select Country</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-3">
										<div class="form-group">
											<label><?php lang('state_province'); ?></label>
											<select class="form-control select2-option" name="state_id" id="state">
												<option value="">Select State</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-3">
										<div class="form-group">
											<label><?php lang('city'); ?></label>
												<select class="form-control select2-option" name="city_id" id="city">
														<option value="">Select City</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-3">
										<div class="form-group">
											<label><?php lang('postal_code'); ?></label>
											<input class="form-control" placeholder="91403" type="text" name="postal_code" id="postal_code" >
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('email'); ?></label>
											<input class="form-control" placeholder="danielporter@example.com" type="email" name="email" id="email" >
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('phone_number'); ?></label>
											<input class="form-control" placeholder="818-978-7102" type="text" name="phone_number" id="phone_number" >
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('mobile_number'); ?></label>
											<input class="form-control" placeholder="818-635-5579" type="text" name="mobile_number" id="mobile_number" >
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('fax'); ?></label>
											<input class="form-control" placeholder="818-978-7102" type="text" name="fax" id="fax" >
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label><?php lang('website_url'); ?></label>
											<input class="form-control" placeholder="https://www.example.com" type="text" name="website_url" id="website_url" >
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 text-center m-t-20">
										<button type="submit" class="btn btn-primary"><?php lang('save_update') ?></button>
									</div>
								</div>
							</form>
						</div>
					</div>
                </div>
				
				<!-- Notifications -->
				<?php $this->load->view('notifications'); ?>
				<!-- Notifications -->
            </div>
        </div>
		