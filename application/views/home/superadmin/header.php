<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="<?php echo base_url()."assets/" ?>css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
		<?php 
		$title = 'SchoolGuru';
		if($this->uri->segment(1) == 'dashboard'){
			$title = 'Dashboard';
		}
		if($this->uri->segment(1) == 'calendar'){
			$title = 'Calendar';
		}
		if($this->uri->segment(1) == 'mentors'){
			$title = 'Guru';
		}
		if($this->uri->segment(1) == 'applicants'){
			$title = 'Applicants';
		}
		if($this->uri->segment(1) == 'messages'){
			$title = 'Messages';
		}
		if($this->uri->segment(1) == 'conversations'){
			$title = 'Conversations';
		}
		?>
		<title><?php echo $title; ?> - SchoolGuru</title>		
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
						<li><a href="#">Account Settings</a></li>
						<li><a href="#">My Account</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url(); ?>logout">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<header class="header admin-header">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-2 top1">
						<div class="logo"><a href="<?php echo base_url();?>user/dashboard"><img src="<?php echo base_url()."assets/" ?>images/logo.png" alt="SchoolGuru" title="SchoolGuru"></a></div>
					</div>
					<div class="col-sm-7 top2">
						<div class="mainnav">
							<ul>
								<li><a class="<?php echo ($this->uri->segment(2) == 'dashboard') ? 'active': ''; ?> " href="<?php echo base_url();?>user/dashboard?notify=true"><i aria-hidden="true" class="fa fa-th"></i> Dashboard</a></li>
								<li><a class="<?php echo ($this->uri->segment(1) == 'gurus') ? 'active': ''; ?> " href="<?php echo base_url();?>gurus"><i aria-hidden="true" class="fa fa-user-circle"></i> Gurus</a></li>
								<li><a href="<?php echo base_url();?>applicant" <?php echo ($this->uri->segment(1) == 'applicants') ? 'active': ''; ?>><i aria-hidden="true" class="fa fa-user-circle"></i> Applicants</a></li>
								<li><a href="<?php echo base_url();?>calendar"><i aria-hidden="true" class="fa fa-calendar"></i> Calendar</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 top3">
						<div class="rightitem topsearch">
							<div class="topsearchform">
								<form class="titlerightsearch">
									<input type="search" id="page_common_search" placeholder="Search">
								</form>
							</div>
						</div>
						<div class="rightitem topnotification">
							<div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<a href="#"><img src="<?php echo base_url()."assets/" ?>images/notification-icon.png" alt="Notification" title="Notification"></a>
								<div class="redcircle" style="display: none;"></div>
							</div>
							<ul class="dropdown-menu">
								<li><h3>Notifications</h3></li>
								<li class="text-center jnotify"><a href="<?php echo base_url();?>dashboard">See All Notifications <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></li>
							</ul>
						</div>
						<div class="rightitem topprofile">
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
							<div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<div class="topprfpic "><img class="img-responsive" height="60" width="60" src="<?php echo $img;?>"></div>
							</div>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url(); ?>user/profile">My Profile</a></li>
								<li><a href="#">Account Settings</a></li>
								<li><a href="#">My Account</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo base_url(); ?>logout">Logout</a></li>
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
						<li><a class="<?php echo ($this->uri->segment(1) == 'gurus') ? 'active': ''; ?> " href="<?php echo base_url();?>gurus"><i aria-hidden="true" class="fa fa-user-circle"></i> Gurus</a></li>
						<li><a href="<?php echo base_url();?>applicant" <?php echo ($this->uri->segment(1) == 'applicants') ? 'active': ''; ?>><i aria-hidden="true" class="fa fa-user-circle"></i> Applicants</a></li>
						<li><a href="<?php echo base_url();?>calendar"><i aria-hidden="true" class="fa fa-calendar"></i> Calendar</a></li>
					</ul>
				</div>
			</div>
		</div>
		<section class="mainarea">
			<div class="alert alert-success" id="profile_update_success" style="display: none"></div>
			<div class="alert alert-danger" id="profile_update_error" style="display: none"></div>
			<div class="container">