<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Signup - SchoolGuru</title>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.png">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/dist/bootstrapValidator.css" type="text/css">

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
				<h3 class="account-title">Signup</h3>
                                <span id="form-registeration-success" class="success" style="display: none;color:green;"></span>
                                <span id="form-registeration-error" class="error" style="display: none;color:green;"></span>
                                <form id="applicant_signup_form">
                                    <input type="hidden" name="role" value="0" id="role"/>
                                    <input type="hidden" name="type" value="user" id="type"/>
                                    <div class="form-group">
                                            <div class="row row-sm">
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" placeholder="First name" name="first_name" id="first_name" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" placeholder="Last name" name="last_name" id="last_name" required>
                                                    </div>
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="email" id="email" placeholder="Email Address" required  />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required />
                                    </div>
                                    <input type="hidden" id="signup_type" name="signup_type" value="guru" />
                                    <button class="btn btn-primary btn-block account-btn" type="submit">Signup</button>
				</form>
				<div class="text-right"><a class="forgot-link" href="<?php echo base_url()."login"; ?>">Already have an account?</a></div>
<!--			<div class="login-or">
					<hr class="hr-or">
					<span class="span-or">or</span>
				</div>
				<div class="row">
					<div class="col-md-6">
						<a href="<?php echo $facebook_url; ?>" class="btn btn-facebook btn-block" onclick="return check_email();"><i class="fa fa-facebook" aria-hidden="true"></i> Signup with Facebook</a>
					</div>
					<div class="col-md-6">
						<a href="<?php echo $google_url; ?>" class="btn btn-google btn-block" onclick="return check_email();"><i class="fa fa-google" aria-hidden="true"></i> Signup with Google</a>
					</div>
				</div>-->
                        </div>
        </div>
        
    </section>
        <script> var base_url = "<?php echo base_url(); ?>" </script>
	<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()."assets/" ?>js/dist/bootstrapValidator.js" type="text/javascript"></script>
        <script src="<?php echo base_url()."assets/" ?>js/applicant.js" type="text/javascript"></script>
  
</body>
</html>