<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php
	//$title = 'Mentori';

	if($this->uri->segment(1) == 'dashboard'){
		$title = 'Dashboard';
	}
	if($this->uri->segment(1) == 'calendar'){
		$title = 'Calendar';
	}
	if($this->uri->segment(1) == 'mentors'){
		$title = 'Mentors';
	}
	if($this->uri->segment(1) == 'mentee'){
		$title = 'Mentee';
	}
	if($this->uri->segment(1) == 'messages'){
		$title = 'Messages';
	}
	if($this->uri->segment(1) == 'conversations'){
		$title = 'Conversations';
	}

	?>
	<title><?php echo $title; ?> - Mentori</title>

	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.ico">
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrapValidator.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/dashboard.css">

	<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
	
	<script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script> 
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>
	<?php if($this->uri->segment(1) == 'dashboard' || $this->uri->segment(2) =='dashboard#_=_' || $this->uri->segment(2) == 'dashboard'){ ?>
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/cropper.min.css">
	<?php } ?>
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap-datetimepicker.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/jquery.mCustomScrollbar.min.css" type="text/css">
	<?php if($this->uri->segment(1) == 'calendar'){ ?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.css" type="text/css">
	<?php } ?>

	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/responsive.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>mentori_assets/css/custom.css">
	<style type="text/css">
	#errors:empty{ display: none; }
	#errors>pre:empty{ display: none; }
</style>

</head>
<body>
	<script>
		$('[data-toggle="slide-collapse"]').on('click', function() {
			$navMenuCont = $($(this).data('target'));
			$navMenuCont.animate({
				'width': 'toggle'
			}, 350);
			$(".menu-overlay").fadeIn(500);

		});
		$(".menu-overlay").click(function(event) {
			$(".navbar-toggle").trigger("click");
			$(".menu-overlay").fadeOut(500);
		});
	</script>

	<div class="overlay">
		<div id="loading-img"></div>
	</div>
	<?php $currentuser = get_userdata(); 

	


	?>
	<div id="verified" style="display:none;"><?php echo $currentuser['is_verified']; ?></div>
	<div id="mobile_verified" style="display:none;"><?php echo $currentuser['mobile_verified']; ?></div>
	<input type="hidden" id="sinch_username" value="<?php echo $currentuser['username']; ?>">
	<input type="hidden" id="user_role" value="<?php echo $currentuser['role']; ?>">
	<input type="hidden" id="uri_segment" value="<?php echo $this->uri->segment(1); ?>">
	<input type="hidden" id="uri_segments" value="<?php echo $this->uri->segment(2); ?>">


	
	<!-- New chat Notifiy   -->
	<input type="hidden" name="user_selected_id" id="user_selected_id">
	<!-- New chat Notifiy   -->
	<header class="header admin-header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-9 col-xs-5 col-md-10">

					<div class="logo">
						<a href="<?php echo base_url();?>dashboard">
							<img src="<?php echo base_url()."assets/" ?>images/logo.png" alt="Mentori" title="Mentori">
						</a>							
					</div>

					<div class="mainnav dashboard-menu">
						<div class="" id="slide-navbar-collapse">
							<ul>
								<?php 
								if($currentuser['is_verified'] == 0 && $currentuser['mobile_verified'] == 0){ ?>



									<li><a class="inactive-menu" href="<?php echo base_url();?>dashboard"><i aria-hidden="true" class="fa fa-th"></i> Dashboard</a></li>
									<li><a class="inactive-menu"href="<?php echo base_url();?>calendar"><i aria-hidden="true" class="fa fa-calendar"></i> Calendar</a></li>

									<?php if($this->session->userdata('role') == 0): ?>
										<li><a class="inactive-menu"href="<?php echo base_url();?>mentors"><i aria-hidden="true" class="fa fa-user-circle"></i> Mentors</a></li>
									<?php endif; ?>



									<?php if($this->session->userdata('role') == 1): ?>
										<li><a class="inactive-menu"href="<?php echo base_url();?>mentee"><i aria-hidden="true" class="fa fa-user-circle"></i> Mentee</a></li>
									<?php endif; ?>



									<li><a class="inactive-menu" href="<?php echo base_url();?>messages"><i aria-hidden="true" class="fa fa-comments"></i> Messages</a></li>
									<li><a class="inactive-menu"href="<?php echo base_url();?>conversations"><i aria-hidden="true" class="fa fa-video-camera"></i> Conversations</a></li>
									<?php if($this->session->userdata('role') == 1): ?>
										<li><a class="inactive-menu" href="<?php echo base_url();?>schedule_timings"><i aria-hidden="true" class="fa fa-clock-o"></i> Schedule Timings</a></li>
									<?php endif; ?>
									<li><a class="inactive-menu" href="<?php echo base_url();?>account"><i aria-hidden="true" class="fa fa-clock-o"></i> Account</a></li>
									
									<li><a class="inactive-menu" href="<?php echo base_url();?>blog"><i aria-hidden="true" class="fa fa-dashboard"></i> Blog</a></li>



								<?php } else{?>





									<li><a class="<?php echo ($this->uri->segment(1) == 'dashboard') ? 'active': ''; ?> " href="<?php echo base_url();?>dashboard"><i aria-hidden="true" class="fa fa-th"></i> Dashboard</a></li>
									<li><a class="<?php echo ($this->uri->segment(1) == 'calendar' || $this->uri->segment(1) == 'list-view') ? 'active': ''; ?> " href="<?php echo base_url();?>calendar"><i aria-hidden="true" class="fa fa-calendar"></i> Calendar</a></li>


									<?php if($this->session->userdata('role') == 0): ?>
										<li><a class="<?php echo ($this->uri->segment(1) == 'mentors') ? 'active': ''; ?> " href="<?php echo base_url();?>mentors"><i aria-hidden="true" class="fa fa-user-circle"></i> Mentors</a></li>
									<?php endif; ?>



									<?php if($this->session->userdata('role') == 1): ?>
										<li><a class="<?php echo ($this->uri->segment(1) == 'mentee') ? 'active': ''; ?> " href="<?php echo base_url();?>mentee"><i aria-hidden="true" class="fa fa-user-circle"></i> Mentee</a></li>
									<?php endif; ?>



									<li><a class="<?php echo ($this->uri->segment(1) == 'messages') ? 'active': ''; ?> " href="<?php echo base_url();?>messages"><i aria-hidden="true" class="fa fa-comments"></i> Messages</a></li>
									<li><a class="<?php echo ($this->uri->segment(1) == 'conversations') ? 'active': ''; ?> " href="<?php echo base_url();?>conversations"><i aria-hidden="true" class="fa fa-video-camera"></i> Conversations</a></li>
									<?php if($this->session->userdata('role') == 1): ?>
										<li><a class="<?php echo ($this->uri->segment(1) == 'schedule_timings') ? 'active': ''; ?> " href="<?php echo base_url();?>schedule_timings"><i aria-hidden="true" class="fa fa-clock-o"></i> Schedule Timings</a></li>
									<?php endif; ?>
									<li><a class="<?php echo ($this->uri->segment(1) == 'account') ? 'active': ''; ?> " href="<?php echo base_url();?>account"><i aria-hidden="true" class="fa fa-user"></i> Account</a></li>

									<li><a class="<?php echo ($this->uri->segment(1) == 'payments') ? 'active': ''; ?> " href="<?php echo base_url();?>payments"><i aria-hidden="true" class="fa fa-money"></i> Payments</a></li>

									<li><a class="<?php echo ($this->uri->segment(1) == 'blog') ? 'active': ''; ?> " href="<?php echo base_url();?>blog"><i aria-hidden="true" class="fa fa-dashboard"></i> Blog</a></li>

									<!-- 	<li><a class="<?php echo ($this->uri->segment(1) == 'faq') ? 'active': ''; ?> " href="<?php echo base_url();?>faq"><i aria-hidden="true" class="fa fa-question"></i> FAQ</a></li> -->
								<?php  }?> 

							</ul>
						</div>
					</div>

				</div>

				<div class="col-sm-3 col-xs-7 col-md-2 top3">
					<div class="hamburger navbar-toggle collapsed mob-icon-menu img-responsive visible-xs visible-sm" data-toggle="slide-collapse" data-target="#slide-navbar-collapse" aria-expanded="false">
						<div class="burger-main">
							<div class="burger-inner">
								<span class="top"></span>
								<span class="mid"></span>
								<span class="bot"></span>
							</div>
						</div>
					</div>

					<script>
						$("#page_common_search").keyup(function(){
							var inputSearch = $(this).val();
							var dataString = 'user_name='+ inputSearch;
							if(inputSearch!=''){
								$.ajax({
									type: "POST",
									url: "<?php echo base_url(); ?>user/get_user",
									data: dataString,
									cache: false,
									success: function(html)
									{
									// console.log(html);
									if(html){
										$("#divResult").html(html).show();
									}else{
										$("#divResult").html('').hide();
									}
								}
							});
							}else{
								$("#divResult").html('').hide();
							}
							return false;
						});
						$("#page_common_search").blur(function(){
							setTimeout(function() {

								$("#divResult").html('').hide();
								$("#page_common_search").val('');
							}, 500);
						});
					</script>
					<?php //exit; ?>
					<div class="rightitem topnotification">
						<div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<a href="<?php echo base_url(); ?>dashboard">
								<i class="fa fa-bell-o" aria-hidden="true"></i>
							</a>
							<div class="redcircle" style="display: none;"></div>
						</div>
						<ul class="dropdown-menu">
							<li><h3>Notifications</h3></li>
							<li class="text-center jnotify"><a href="<?php echo base_url();?>dashboard">See All Notifications <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></li>
						</ul>
					</div>

					<div class="rightitem topsearch">
						<div class="topsearchform">
							<form class="titlerightsearch">
								<input type="search" id="page_common_search" placeholder="Search" autocomplete="off">
								<div id="divResult"></div>
							</form>
						</div>
					</div>
					<div class="rightitem topprofile">
						<?php
						$profile_img = '';
						if(isset($currentuser['profile_img'])&&!empty($currentuser['profile_img'])){
							$profile_img = $currentuser['profile_img'];
						}
						$social_profile_img = '';
						if(isset($currentuser['picture_url'])&&!empty($currentuser['picture_url'])){
							$social_profile_img = $currentuser['picture_url'];
						}
						$img1 = '';
						if($social_profile_img != ''){
							$img1 = $social_profile_img;
						}
						if($profile_img != ''){
							$file_to_check = FCPATH . '/assets/images/' . $profile_img;
							if (file_exists($file_to_check)) {
								$img1 = base_url() . 'assets/images/'.$profile_img;
							}
						}
						$img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
						?>
						<div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<div class="topprfpic "><img class="img-responsive" height="60" width="60" src="<?php echo $img;?>"></div>
						</div>
						<ul class="dropdown-menu">
							<?php if($currentuser['is_verified'] == 1 || $currentuser['mobile_verified'] == 1): ?>
								<li><a href="<?php echo base_url(); ?>user/profile">My Profile</a></li>
								<?php 

								$id = $this->session->userdata('applicant_id');
								$counts = $this->db->get_where('social_applicant_user',array('reference_id'=>$id))->num_rows();
								if($counts == 0){

									?>
									<li><a href="#" data-toggle="modal" data-target="#change_pwd_modal" onclick="$('#change_pwd').css('display','block');">Change Password</a></li>
								<?php } ?>
								<li><a href="javascript:void(0)" onClick="sinchLogout();">Logout</a></li>
								<?php else: ?>
									<li class="warning-message">
										<a style="color:orange;" href="<?php echo base_url(); ?>welcome/profile_settings" ><i class="fa fa-warning"></i> Please verify your email</a></li>
										<li role="separator" class="divider"></li>
										<li><a href="javascript:void(0)" onClick="sinchLogout();">Logout</a></li>
									<?php endif; ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</header>
			<section class="mainarea clickable">
				<div class="alert alert-success" id="profile_update_success" style="display: none">  </div>
				<div class="alert alert-danger" id="profile_update_error" style="display: none">  </div>
				<?php
				if($this->uri->segment(1) != 'dashboard' ){echo '<div class="container dashboard-container">';}  ?>

				<?php 
				if($currentuser['is_verified'] == 0 && $currentuser['mobile_verified'] == 0){
					echo '<div class="alert alert-danger fade in alert-dismissible" align="center">
					<font color="red">
					<strong>Alert!</strong>
					</font><a href="'.base_url().'welcome/profile_settings" style="text-decoration:underline">
					<font color="red">Please Verify your mail to complete the signup process!
					</a>
					</font>
					</div>
					';
				} 
				?>













				<!-- video call alert notification  -->
				<div class="new_call"></div>

				<audio id="ringback" src='<?php echo base_url();?>assets/css/style/ringback.wav' loop></audio>
				<audio id="ringtone" src='<?php echo base_url();?>assets/css/style/phone_ring.wav' loop></audio>
				<!-- Notification bell  -->
				<audio id="notify_ring" src='<?php echo base_url();?>assets/chime.mp3'></audio>
				<audio id="message_ring" src='<?php echo base_url();?>assets/notification.mp3'></audio>



				<!-- Let us know  -->
				<div class="modal fade bs-example-modal-md" id="change_pwd_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
					<div class="modal-dialog modal-md" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h3>Change Password</h3>
							</div>
							<div class="alert alert-success note">Password updated successfully!</div>
							<form id="change_pwd_form" method="post">
								<div class="modal-body">
									<div class="form-group">
										<label class="control-label">Current Password</label>
										<input type="password" name="current_password" id="current_password" class="form-control" autocomplete="off">
										<span class="help-block" id="current_password_span"></span>
									</div>
									<div class="form-group">
										<label class="control-label">New Password</label>
										<input type="password" name="password" id="password" class="form-control" autocomplete="off">
										<span class="help-block" id="new_password_span"></span>
										<div id="errors"></div>
									</div>
									<div class="form-group">
										<label class="control-label">Confirm New Password</label>
										<input type="password" name="confirm_password" id="confirm_password" class="form-control confirm_password" autocomplete="off">
										<span  class="help-block confirm_password_span"></span>
									</div>
								</div>
								<div class="modal-footer text-right">
									<button class="btn btn-primary account-btn" type="submit" disabled >Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<style type="text/css">
				.help-block{ color: red; }
			</style>
			<script>
				$('[data-toggle="slide-collapse"]').on('click', function() {
					$navMenuCont = $($(this).data('target'));
					$navMenuCont.animate({
						'width': 'toggle'
					}, 350);
					$(".menu-overlay").fadeIn(500);

				});
				$(".menu-overlay").click(function(event) {
					$(".navbar-toggle").trigger("click");
					$(".menu-overlay").fadeOut(500);
				});
			</script>
			<script type="text/javascript">
				$('document').ready(function () {
					var Closed = false;

					$('.hamburger').click(function () {
						if (Closed == true) {
							$(this).removeClass('open');
							$(this).addClass('closed');
							Closed = false;
						} else {               
							$(this).removeClass('closed');
							$(this).addClass('open');
							Closed = true;
						}
					});
				});
			</script>