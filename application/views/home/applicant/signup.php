<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Signup - Mentori</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.png">
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrapValidator.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/responsive.css" type="text/css">
	<script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>
</head>
<style type="text/css">
#errors:empty{ display: none; }
#errors>pre:empty{ display: none; }
.account-page{
	background:url('<?php echo base_url(); ?>assets/images/mentee_bg.jpg') !important;
}
</style>
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
					<div class="row row-sm">
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" class="form-control text" placeholder="First name" name="first_name" id="first_name" required onkeypress="return AvoidSpace(event)" maxlength="15">
							</div>							
						</div>
						<div class="col-md-6">								
							<div class="form-group">
								<input type="text" class="form-control text" placeholder="Last name" name="last_name" id="last_name" required onkeypress="return AvoidSpace(event)" maxlength="15">
							</div>							
						</div>
					</div> 
					<div class="form-group">
						<input type="text" class="form-control" name="email" id="email" placeholder="Email Address" required onkeypress="return AvoidSpace(event)" />
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" id="password" placeholder="Password" required onkeypress="return AvoidSpace(event)"/>
						<div id="errors"></div>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required onkeypress="return AvoidSpace(event)"/>
					</div>
					<input type="hidden" id="signup_type" name="signup_type" value="guru" />
					<button class="btn btn-primary btn-block account-btn" type="submit">Signup</button>
				</form>
				<div class="text-right">
					<a href="javascript:void(0)" class="forgot-link" onclick="history.back();">Go Back</a>
				</div>
				<div class="text-right"><a class="forgot-link" href="<?php echo base_url()."login"; ?>">Already have an account?</a></div>
				<div class="login-or">
					<hr class="hr-or">
					<span class="span-or">or</span>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<a href="<?php echo $facebook_url; ?>" class="btn btn-facebook btn-block" onclick="return check_email();"><i class="fa fa-facebook" aria-hidden="true"></i> Signup with Facebook</a>
						</div>						</div>
						<div class="col-md-6">							<div class="form-group">
							<a href="<?php echo $google_url; ?>" class="btn btn-google btn-block" onclick="return check_email();"><i class="fa fa-google" aria-hidden="true"></i> Signup with Google</a>
						</div>						</div>
					</div>				</div>
				</div>
			</section>	
			<script> var base_url = "<?php echo base_url(); ?>" </script>
			<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url()."assets/" ?>js/jquery.password-validation.js" type="text/javascript"></script>
			<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
			<script>
				$(document).ready(function() {

					$("#password").passwordValidation({"confirmField": "#confirm_password"}, function(element, valid, match, failedCases) {
						$("#errors").html("<pre>" + failedCases.join("\n") + "</pre>");

						if(valid){							 
							$('.account-btn').attr('disabled','false');
						}
						if(!valid){							
							$('.account-btn').attr('disabled','true');
							//$('.account-btn').removeAttr('disabled');
						}

						if(!valid || !match){							
							$('.account-btn').attr('disabled','true');
						}
						if(valid && match){							
							$('.account-btn').removeAttr('disabled');
						}



					});
				});
			</script>

			<script src="<?php echo base_url()."assets/" ?>js/bootstrapValidator.js" type="text/javascript"></script>
			<script src="<?php echo base_url()."assets/" ?>js/sinch/VIDEOsample.js" type="text/javascript"></script>
			<script src="<?php echo base_url()."assets/" ?>js/guru.js" type="text/javascript"></script>
			<script type = "text/javascript" >

				$('.text').keypress(function (e) {
					var regex = new RegExp("^[\\w\\-\\/ \\b\\t]+$");
					var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
					if (regex.test(str)) {
						return true;
					}
					else {
						e.preventDefault();
						return false;
					}
				});


			// history.pushState(null, null, '#');
			// window.addEventListener('popstate', function(event) {
			// 	history.pushState(null, null, '#');
			// });


		</script>
	</body>
	</html>