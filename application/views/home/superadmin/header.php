<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="<?php echo base_url()."assets/" ?>css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/dashboard.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/admin.css">

		
		<?php 
		// $title = 'Mentori';
		if($this->uri->segment(1) == 'dashboard'){
			$title = 'Dashboard';
		}
		if($this->uri->segment(1) == 'calendar'){
			$title = 'Calendar';
		}
		if($this->uri->segment(1) == 'mentor_list'){
			$title = 'Mentor list';
		}
		if($this->uri->segment(1) == 'mentee_list'){
			$title = 'Mentee list';
		}
		if($this->uri->segment(1) == 'messages'){
			$title = 'Messages';
		}
		if($this->uri->segment(1) == 'settings'){
			$title = 'Settings';
		}
		?>
		<title><?php echo $title; ?></title>		
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.ico"> 
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrapValidator.css" type="text/css">
		<?php if($this->uri->segment(1) == 'dashboard' || $this->uri->segment(2) =='dashboard#_=_' || $this->uri->segment(2) == 'dashboard'){ ?>
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/cropper.min.css">
		<?php } ?>
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap-datetimepicker.min.css" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" type="text/css">
		<?php if($this->uri->segment(1) == 'calendar'){ ?>
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/fullcalendar.min.css" type="text/css">
		<?php } ?>
		<?php if($this->uri->segment(2) == 'schedule_guru'){ ?>
		<?php } ?>
		<?php if($this->uri->segment(2) == 'profile_edit'){ ?>
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/cropper.min.css">
		<?php } ?>
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/responsive.css" type="text/css">
		<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
		
	</head>
	<body>
		<div class="overlay"><div id="loading-img"></div></div>
		<?php $currentuser = get_userdata(); ?>
		<div id="verified" style="display:none;"><?php echo $currentuser['is_verified']; ?></div>
		<input type="hidden" id="sinch_username" value="<?php echo $currentuser['username']; ?>">
		<input type="hidden" id="user_role" value="<?php echo $currentuser['role']; ?>">
		<div class="mobile-header">
			<div class="header-left">
				<a href="<?php echo base_url();?>user/dashboard" class="logo">
					<img src="<?php echo base_url()."assets/" ?>images/logo.png" alt="SchoolGuru" title="SchoolGuru" width="100">
				</a>
			</div>
			<a id="mobile_btn" class="mobile_btn pull-left" href="#sidebar"><i class="fa fa-bars" aria-hidden="true"></i></a>
			<ul class="nav navbar-nav navbar-right user-menu pull-right">
				<li class="dropdown topnotification hidden-xs"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o"></i></a>
					<ul class="dropdown-menu">
						<li><h3>Notifications</h3></li>
						<li class="text-center jnotify"><a href="<?php echo base_url();?>dashboard">See All Notifications <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></li>
					</ul>
				</li>
				<li class="dropdown search-icon-bg hidden-xs">
					<a href="javascript:;" id="open_msg_box" class="" data-toggle="dropdown"><i class="fa fa-search"></i></a>
					<div class="dropdown-menu pull-right">
						<form class="titlerightsearch navbar-form">
							<input type="search" placeholder="Search">
						</form>
					</div>
				</li>
				<li class="dropdown">
					<?php 
					$profile_img = '';
					if(isset($currentuser['profile_img'])&&!empty($currentuser['profile_img']))
					{
						$profile_img = $currentuser['profile_img'];
					}  
					$social_profile_img = '';
					if(isset($currentuser['picture_url'])&&!empty($currentuser['picture_url']))
					{
						$social_profile_img = $currentuser['picture_url'];
					}  
					$img1 = '';
					if($social_profile_img != '')
					{
						$img1 = $social_profile_img;
					}
					if($profile_img != '')
					{
						$file_to_check = FCPATH . '/assets/images/' . $profile_img;
						if (file_exists($file_to_check)) {
							$img1 = base_url() . 'assets/images/'.$profile_img;
						}
					}
						$img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
					?>
					<a href="#" class="dropdown-toggle user-link" data-toggle="dropdown">
						<span class="user-img"><img class="img-responsive img-circle" height="50" width="50" src="<?php echo $img;?>"></span>
					</a>
					<ul class="dropdown-menu pull-right">
						<li><a href="<?php echo base_url(); ?>user/profile">My Profile</a></li>						
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url(); ?>logout">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
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
									<li><a class="<?php echo ($this->uri->segment(2) == 'dashboard') ? 'active': ''; ?> " href="<?php echo base_url();?>user/dashboard"><i aria-hidden="true" class="fa fa-th"></i> Dashboard</a></li>
									<li><a class="<?php echo ($this->uri->segment(1) == 'mentor_list') ? 'active': ''; ?> " href="<?php echo base_url();?>mentor_list"><i aria-hidden="true" class="fa fa-user-circle"></i> Mentors</a></li>
									<li><a href="<?php echo base_url();?>mentee_list" <?php echo ($this->uri->segment(1) == 'mentee_list') ? 'active': ''; ?>><i aria-hidden="true" class="fa fa-user-circle"></i> Mentee</a></li>
									<li><a href="<?php echo base_url();?>calendar" class="<?php echo ($this->uri->segment(1) == 'calendar') ? 'active': ''; ?> "><i aria-hidden="true" class="fa fa-calendar"></i> Calendar</a></li>
									<li><a href="<?php echo base_url();?>settings" class="<?php echo ($this->uri->segment(1) == 'settings') ? 'active': ''; ?> "><i aria-hidden="true" class="fa fa-cog"></i> Settings</a></li>
									<li><a class="<?php echo ($this->uri->segment(1) == 'payments') ? 'active': ''; ?> " href="<?php echo base_url();?>payments"><i aria-hidden="true" class="fa fa-clock-o"></i> Payments</a></li>
									<li><a class="<?php echo ($this->uri->segment(1) == 'blog') ? 'active': ''; ?> " href="<?php echo base_url();?>blog"><i aria-hidden="true" class="fa fa-dashboard"></i> Blog</a></li>
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
						
								<li><a href="<?php echo base_url(); ?>user/profile">My Profile</a></li>
								<?php 

								$id = $this->session->userdata('applicant_id');
								$counts = $this->db->get_where('social_applicant_user',array('reference_id'=>$id))->num_rows();
								if($counts == 0){

									?>
									<li><a href="#" data-toggle="modal" data-target="#change_pwd_modal" onclick="$('#change_pwd').css('display','block');">Change Password</a></li>
								<?php } ?>
								<li><a href="<?php  echo base_url(); ?>user/logout">Logout</a></li>
								
								</ul>
							</div>
						</div>
					</div>
				</div>
			</header>
		<div class="sidebar" id="sidebar">
			<div class="sidebar-inner slimscroll">
				<div id="sidebar-menu" class="sidebar-menu">
					<ul>
						<li><a class="<?php echo ($this->uri->segment(2) == 'dashboard') ? 'active': ''; ?> " href="<?php echo base_url();?>user/dashboard?notify=true"><i aria-hidden="true" class="fa fa-th"></i> Dashboard</a></li>
						<li><a class="<?php echo ($this->uri->segment(1) == 'gurus') ? 'active': ''; ?> " href="<?php echo base_url();?>gurus"><i aria-hidden="true" class="fa fa-user-circle"></i> Mentors</a></li>
						<li><a href="<?php echo base_url();?>applicant" <?php echo ($this->uri->segment(1) == 'applicants') ? 'active': ''; ?>><i aria-hidden="true" class="fa fa-user-circle"></i> Mentee</a></li>
						<li><a href="<?php echo base_url();?>calendar"><i aria-hidden="true" class="fa fa-calendar"></i> Calendar</a></li>
					</ul>
				</div>
			</div>
		</div>
		<section class="mainarea">
			<div class="alert alert-success" id="profile_update_success" style="display: none"></div>
			<div class="alert alert-danger" id="profile_update_error" style="display: none"></div>
			<div class="container">


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