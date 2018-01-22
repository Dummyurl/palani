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
                                <form id="applicant_signup_form" method="post">
                                    <input type="hidden" name="role" value="1" id="role"/>
                                    <input type="hidden" name="type" value="guru" id="type"/>
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
<!--			        <div class="login-or">
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
    <div class="modal fade bs-example-modal-lg" id="signup_guru_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form name="send_messages" id="send_messages"> 
                    <div class="modal-body">
                    	<div class="cong_icon"><i class="fa fa-check" aria-hidden="true"></i></div>
                    	<h2>Congratulations!</h2>
                        <h4>Your account has been created successfully.</h4>
                        <p>We are glad you decided to start helping out and make some cash. Feel free to browse around. Please complete your profile and payment information.</p>
                        <p>You will receive a verification email shortly.</p>
                    	<button type="button" class="btn btn-primary" onClick="show_mobile_modal();">Continue</button>
                    </div>
                    
                         
                  <!--<div class="modal-header">
                    <h3>Congratulations!!</h3>
                  </div>
                  <div class="modal-body">
                      <p>Welcome <?php echo $this->session->userdata('first_name'); ?>! We are glad you decided to start helping out and make some cash. Feel free to browse around. Please complete your Profile and Payment information.</p>                   
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onClick="show_mobile_modal();">Continue</button>
                  </div>-->
                  
                  
                  </form>
                </div>
              </div>
    </div>
    <div class="modal fade bs-example-modal-lg" id="verifymobile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                 <form name="send_messages" id="verifymobile_form">      
                  <div class="modal-header">
                    <h3>Verify your Mobile Number</h3>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                            <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Mobile Number <span>*</span></label>
                                <input type="text" name="mobile_number" id="mobile_number" class="form-control" value="" onKeyUp="check_mobile(this.value);" required/>
                                <div id="error_msg" style="color:red;"></div>
                            </div>
                            </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onClick="send_otp();">Continue</button>
                  </div>
                  </form>
                </div>
              </div>
    </div>
        
        <div class="modal fade bs-example-modal-lg" id="verify_code" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                 <form name="send_messages" id="verify_code_form">      
                        
                  <div class="modal-header">
                    <h3>Verify your Code</h3>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                            <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Enter verification code <span>*</span></label>
                                <input type="text" name="verification_code" id="verification_code" class="form-control" value="" onKeyUp="check_code(this.value);" required/>
                                <div id="error_msg_code" style="color:red;"></div>
                             </div>
                            </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onClick="send_code();">Continue</button>
                  </div>
                  </form>
                </div>
              </div>
    </div>
        
        <div class="modal fade bs-example-modal-lg" id="verify_success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                 <form name="send_messages" id="verify_code_form">      
                        
                  <div class="modal-header">
                    <h3>Congratulations!!</h3>
                  </div>
                  <div class="modal-body">
                      <p>Thank you! Your mobile number has been verified successfully.</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onClick="window.location='<?php echo base_url(); ?>user/dashboard'">Continue</button>
                  </div>
                  </form>
                </div>
              </div>
    </div>
            <!-- Modal -->
    </section>
        <script> var base_url = "<?php echo base_url(); ?>" </script>
	<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()."assets/" ?>js/dist/bootstrapValidator.js" type="text/javascript"></script>
        <script src="<?php echo base_url()."assets/" ?>js/guru.js" type="text/javascript"></script>
 
</script>
</body>
</html>