<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Forgot Password - SchoolGuru</title>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.png">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/dist/bootstrapValidator.css" type="text/css">
</head>

<body class="account-page">
    <section class="mainarea">
    	<div class="container">
			<div class="account-box">
				<a href="<?php echo base_url(); ?>">
					<div class="login-logo">
						<img src="<?php echo base_url()."assets/" ?>images/login-icon.png" alt=""/>
					</div>
				</a>
				<h3 class="account-title">Forgot Password</a></h3>
                                <span id="applicant_forgot_password_success" class="success" style="display: none"> </span>
                                <span id="applicant_forgot_password_error" class="error" style="display: none"> </span>
				<form id="applicant_forgot_password_form">
					<div class="form-group">
                                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Your Email" required />
					</div>
					<button class="btn btn-primary btn-block account-btn" type="submit">Reset password</button>
				</form>
				<div class="text-right m-t-30"><a class="forgot-link" href="<?php echo base_url()."user/login"; ?>">Back to Login</a></div>
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