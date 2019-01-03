       <div class="main-wrapper" id="wrapper">
       	<?php $this->load->view('nav_bar'); ?>
       	<div class="page-wrapper">
       		<div class="content container-fluid">
       			<div class="row">
       				<div class="col-md-8 col-md-offset-2">
       					<form class="form-horizontal" method="post" id="theme_form" enctype="multipart/form-data">
       						<h4 class="page-title"><?php lang('theme_settings'); ?></h4>
       						<div class="form-group">
       							<label class="col-lg-3 control-label"><?php lang('website_name'); ?></label>
       							<div class="col-lg-9">
       								<input name="website_name" class="form-control" placeholder="Focus Technologies" type="text" id="website_name" value="<?php echo (!empty($theme->website_name)?$theme->website_name:''); ?>">
       							</div>
       						</div>
       						<div class="form-group">
       							<label class="col-lg-3 control-label"><?php lang('light_logo'); ?></label>
       							<div class="col-lg-5">
       								<input class="form-control" type="file" name="light_logo" id="light_logo" onchange="upload_image(this)" maxwidth="40" maxheight="40">
       								<span class="help-block">Recommended image size is 40px x 40px</span>
       							</div>
       							<?php 
       							$light_logo = (!empty($theme->light_logo)?base_url().'uploads/'.$theme->light_logo:'assets/img/logo2.png');
       							?>									  
       							<div class="col-lg-4">
       								<div class="img-thumbnail pull-right">
       									<img src="<?php echo $light_logo; ?>" class="light_logo" alt="" width="40" height="40"></div>
       								</div>
       							</div>
       							<?php 
       							$dark_logo = (!empty($theme->dark_logo)?base_url().'uploads/'.$theme->dark_logo:'assets/img/logo3.png');
       							?>	
       							<div class="form-group">
       								<label class="col-lg-3 control-label"><?php lang('dark_logo'); ?></label>
       								<div class="col-lg-5">
       									<input class="form-control" type="file" name="dark_logo" id="dark_logo" onchange="upload_image(this)" maxwidth="140" maxheight="40">
       									<span class="help-block">Recommended image size is 140px x 40px</span>
       								</div>
       								<div class="col-lg-4">
       									<div class="img-thumbnail pull-right"><img src="<?php echo $dark_logo; ?>" class="img-responsive dark_logo" alt="" width="140" height="40"></div>
       								</div>
       							</div>
       							<?php 
       							$favicon = (!empty($theme->favicon)?base_url().'uploads/'.$theme->favicon:'assets/img/favicon.png');
       							?>	
       							<div class="form-group">
       								<label class="col-lg-3 control-label"><?php lang('favicon'); ?></label>
       								<div class="col-lg-5">
       									<input class="form-control" type="file"  name="favicon" id="favicon" onchange="upload_image(this)" maxwidth="16" maxheight="16">
       									<span class="help-block">Recommended image size is 16px x 16px</span>
       								</div>
       								<div class="col-lg-4">
       									<div class="settings-image img-thumbnail pull-right">
       										<img src="<?php echo $favicon; ?>" class="img-responsive favicon" width="16" height="16" alt="" ></div>
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
       		