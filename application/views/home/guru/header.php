<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
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
		<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
		<script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>
		<?php if($this->uri->segment(1) == 'dashboard' || $this->uri->segment(2) =='dashboard#_=_' || $this->uri->segment(2) == 'dashboard'){ ?>
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/cropper.min.css">
		<?php } ?>
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap-datetimepicker.min.css" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/jquery.mCustomScrollbar.min.css" type="text/css">
		<?php if($this->uri->segment(1) == 'calendar'){ ?>
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/fullcalendar.min.css" type="text/css">
		<?php } ?>
		<?php if($this->uri->segment(2) == 'schedule_guru'){ ?>
		<?php } ?>
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/responsive.css" type="text/css">
	</head>
<body>
    <div class="overlay">
        <div id="loading-img"></div>
    </div>
    <?php $currentuser = get_userdata(); ?>
    <div id="verified" style="display:none;"><?php echo $currentuser['is_verified']; ?></div>
    <input type="hidden" id="sinch_username" value="<?php echo $currentuser['username']; ?>">
    <input type="hidden" id="user_role" value="<?php echo $currentuser['role']; ?>">
    <input type="hidden" id="uri_segment" value="<?php echo $this->uri->segment(1); ?>">
    <input type="hidden" id="uri_segments" value="<?php echo $this->uri->segment(2); ?>">
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
					<li>
						<h3>Notifications</h3>
					</li>
					<li class="text-center jnotify"><a href="<?php echo base_url();?>dashboard">See All Notifications <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></li>
				</ul>
			</li>
			<li class="dropdown search-icon-bg hidden-xs"> <a href="javascript:;" id="open_msg_box" class="" data-toggle="dropdown"><i class="fa fa-search"></i></a>
				<div class="dropdown-menu pull-right">
					<form class="titlerightsearch navbar-form"> <input type="search" placeholder="Search" autocomplete="off">
						<div id="divResult"></div>
					</form>
				</div>
			</li>
			<li class="dropdown">
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
				<a href="#" class="dropdown-toggle user-link" data-toggle="dropdown">
					<span class="user-img"><img class="img-responsive img-circle" height="50" width="50" src="<?php echo $img;?>"></span>
				</a>
				<ul class="dropdown-menu pull-right">
					<?php if($currentuser['is_verified'] == 1): ?>
					<li><a href="<?php echo base_url(); ?>user/profile">My Profile</a></li>
					<li><a href="<?php echo base_url(); ?>user/dashboard?account=true">Account Settings</a></li>
					<!-- <li><a href="<?php echo base_url(); ?>user/dashboard?account=true">My Account</a></li> -->
					<li role="separator" class="divider"></li>
					<li><a href="javascript:void(0)" onClick="sinchLogout();">Logout</a></li>
					<?php else: ?>
					<li class="warning-message"><a style="color:orange;"><i class="fa fa-warning"></i> Please verify your email</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="javascript:void(0)" onClick="sinchLogout();">Logout</a></li>
					<?php endif; ?> </ul>
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
							<li><a class="<?php echo ($this->uri->segment(1) == 'dashboard') ? 'active': ''; ?> " href="<?php echo base_url();?>dashboard"><i aria-hidden="true" class="fa fa-th"></i> Dashboard</a></li>
							<li><a class="<?php echo ($this->uri->segment(1) == 'calendar' || $this->uri->segment(1) == 'list-view') ? 'active': ''; ?> " href="<?php echo base_url();?>calendar"><i aria-hidden="true" class="fa fa-calendar"></i> Calendar</a></li>
							<?php if($this->session->userdata('role') == 0): ?>
							<li><a class="<?php echo ($this->uri->segment(1) == 'mentors') ? 'active': ''; ?> " href="<?php echo base_url();?>mentors"><i aria-hidden="true" class="fa fa-user-circle"></i> Gurus</a></li>
							<?php endif; ?>
							<?php if($this->session->userdata('role') == 1): ?>
							<li><a class="<?php echo ($this->uri->segment(1) == 'applicants') ? 'active': ''; ?> " href="<?php echo base_url();?>applicants"><i aria-hidden="true" class="fa fa-user-circle"></i> Applicant</a></li>
							<?php endif; ?>
							<li><a class="<?php echo ($this->uri->segment(1) == 'messages') ? 'active': ''; ?> " href="<?php echo base_url();?>messages"><i aria-hidden="true" class="fa fa-comments"></i> Messages</a></li>
							<li><a class="<?php echo ($this->uri->segment(1) == 'conversations') ? 'active': ''; ?> " href="<?php echo base_url();?>conversations"><i aria-hidden="true" class="fa fa-video-camera"></i> Conversations</a></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-3 top3">
					<div class="rightitem topsearch">
						<div class="topsearchform">
							<form class="titlerightsearch">
								<input type="search" id="page_common_search" placeholder="Search" autocomplete="off">
							<div id="divResult"></div>
							</form>
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
						}, 100);
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
							<?php if($currentuser['is_verified'] == 1): ?>
							<li><a href="<?php echo base_url(); ?>user/profile">My Profile</a></li>
							<li><a href="<?php echo base_url(); ?>user/dashboard?account=true">Account Settings</a></li>
							<!-- <li><a href="<?php echo base_url(); ?>user/dashboard?account=true">My Account</a></li> -->
							<li role="separator" class="divider"></li>
							<li><a href="javascript:void(0)" onClick="sinchLogout();">Logout</a></li>
							<?php else: ?>
							<li class="warning-message"><a style="color:orange;"><i class="fa fa-warning"></i> Please verify your email</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="javascript:void(0)" onClick="sinchLogout();">Logout</a></li>
							<?php endif; ?>
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
					<li><a class="<?php echo ($this->uri->segment(1) == 'dashboard') ? 'active': ''; ?> " href="<?php echo base_url();?>dashboard"><i aria-hidden="true" class="fa fa-th"></i> Dashboard</a></li>
					<li><a class="<?php echo ($this->uri->segment(1) == 'calendar' || $this->uri->segment(1) == 'list-view') ? 'active': ''; ?> " href="<?php echo base_url();?>calendar"><i aria-hidden="true" class="fa fa-calendar"></i> Calendar</a></li>
					<?php if($this->session->userdata('role') == 0): ?>
					<li><a class="<?php echo ($this->uri->segment(1) == 'mentors') ? 'active': ''; ?> " href="<?php echo base_url();?>mentors"><i aria-hidden="true" class="fa fa-user-circle"></i> Gurus</a></li>
					<?php endif; ?>
					<?php if($this->session->userdata('role') == 1): ?>
					<li><a class="<?php echo ($this->uri->segment(1) == 'applicants') ? 'active': ''; ?> " href="<?php echo base_url();?>applicants"><i aria-hidden="true" class="fa fa-user-circle"></i> Applicant</a></li>
					<?php endif; ?>
					<li><a class="<?php echo ($this->uri->segment(1) == 'messages') ? 'active': ''; ?> " href="<?php echo base_url();?>messages"><i aria-hidden="true" class="fa fa-comments"></i> Messages</a></li>
					<li><a class="<?php echo ($this->uri->segment(1) == 'conversations') ? 'active': ''; ?> " href="<?php echo base_url();?>conversations"><i aria-hidden="true" class="fa fa-video-camera"></i> Conversations</a></li>
				</ul>
			</div>
		</div>
	</div>
	<section class="mainarea">
		<div class="alert alert-success" id="profile_update_success" style="display: none">  </div>
		<div class="alert alert-danger" id="profile_update_error" style="display: none">  </div>
		<div class="container">
			<!-- video call alert notification  -->
			<div class="new_call form-group"></div>
			<audio id="ringback" src='<?php echo base_url();?>assets/css/style/ringback.wav' loop></audio>
			<audio id="ringtone" src='<?php echo base_url();?>assets/css/style/phone_ring.wav' loop></audio>