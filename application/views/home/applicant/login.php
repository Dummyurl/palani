<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Login - SchoolGuru</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.png">	
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/responsive.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrapValidator.css" type="text/css">
	<script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>
</head>

<body class="account-page">
	<section class="mainarea account-box-area">
		<div class="container">
			<div class="account-box">
				<div class="preloader" style="display:none;"></div>
				<a href="<?php echo base_url(); ?>">
					<div class="login-logo">
						<img src="<?php echo base_url()."assets/" ?>images/login-icon.png" alt=""/>
					</div>
				</a>
				<h3 class="account-title">Login</a></h3>
				<form id="applicant_login_form" autocomplete="off">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Email" name="email" id="email" autofocus required />
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" name="password" id="password" required />
					</div>
					<button class="btn btn-primary btn-block account-btn" type="submit">Login</button>
				</form>
				<span class="text-center error" id="applicant_login_error" ></span>
				<div class="text-right"><a class="forgot-link" href="<?php echo base_url()."user/forgot_password" ?>">Forgot Password</a></div>
				<div class="login-or">
					<hr class="hr-or">
					<span class="span-or">or</span>
				</div>
				<div class="row">
					<div class="col-md-6">
						<a href="<?php echo $facebook_url ; ?>" class="btn btn-facebook btn-block"><i class="fa fa-facebook" aria-hidden="true"></i> Login with Facebook</a>
					</div>
					<div class="col-md-6">
						<a href="<?php echo $google_url ; ?>" class="btn btn-google btn-block"><i class="fa fa-google" aria-hidden="true"></i> Login with Google</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 signup-link">
						<a href="<?php echo base_url()."signup"; ?>">Create New Account</a>
					</div>
				</div>
			</div>
		</div>
		
	</section>
	<script> var base_url = "<?php echo base_url(); ?>" </script>
	<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>
	<script src="<?php echo base_url()."assets/" ?>js/chosen.js"></script>
	<script src="<?php echo base_url()."assets/" ?>js/bootstrapValidator.js" type="text/javascript"></script>

	<script src="<?php echo base_url()."assets/" ?>js/applicant.js" type="text/javascript"></script>


	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jstz-1.0.4.min.js"></script>   
	<script type="text/javascript">

		
		$(document).ready(function() {
			var tz = jstz.determine();
			var timezone = tz.name();
			$.post('<?php echo base_url(); ?>user/set_timezone',{timezone:timezone},function(res){
        // console.log(res);
    })      
		});
	</script>
</body>
</html>