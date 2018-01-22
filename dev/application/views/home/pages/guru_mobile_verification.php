<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mobile Verification</title>

<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.png"> 
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/dist/bootstrapValidator.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">
 <script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>
</head>

<body>

<div class="success-signup" id="signup_applicant_modal">
	<div class="container">
        <form name="send_messages" id="send_messages">      
            <div class="cong_icon"><i class="fa fa-check"></i></div>
            <h2>Congratulations!</h2>
            <h4>Your account has been created successfully.</h4>
            <p>We are glad you decided to start helping out and make some cash. Feel free to browse around. Please complete your profile and payment information.</p>
            <p>You will receive a verification email shortly.</p>
            <button type="button" class="btn btn-primary" onclick="showMobileData();">Continue</button>
        </form>
    </div>
</div>

<div class="success-signup" id="mobile_first_verify" style="display: none;">
	<div class="container">
        <p><img src="<?php echo base_url(); ?>assets/images/schoolguru-logo-emailtemplate.png" /></p>
        <h2>One more step to go!</h2>
		<h4>Please verify your mobile number</h4>
        <form method="post" id="mobile_verify_form"  onsubmit="redirection()">
            <div id="error_msg" style="color:red;"></div>
            <div class="row">
            	<div class="col-xs-12"><label class="control-label">Enter your mobile number</label></div>
                <div class="col-sm-9"><input type="text" name="mobile_number" id="mobile_number" class="form-control" value="" onKeyUp="check_mobile(this.value);" required max="15"/></div>
                <div class="col-sm-3">
                    <!-- <button type="submit" class="btn btn-primary">Send OTP</button> -->
                    <a href="<?php echo base_url(); ?>dashboard" class="btn btn-primary">Send OTP</a>
                </div>
             </div>
        </form>
    </div>
</div>

<div class="success-signup" id="mobile_first_verify_code" style="display: none;">
	<div class="container">
        <p><img src="<?php echo base_url(); ?>assets/images/schoolguru-logo-emailtemplate.png" /></p>
        <h2>One more step to go!</h2>
		<h4>Please verify your mobile number</h4>
        <form method="post" id="mobile_verify_code_form">
            <div id="error_msg" style="color:red;"></div>
            <div class="row">
            	<div class="col-xs-12"><label class="control-label">Enter the verification code</label></div>
                <div class="col-sm-9"><input type="text" name="verification_code" id="verification_code" class="form-control" value="" required/></div>
                <div class="col-sm-3"><button type="submit" class="btn btn-primary">Verify</button></div>
             </div>
        </form>
    </div>
</div>

<div class="success-signup" id="mobile_first_verify_success" style="display:none;">
	<div class="container">
        <div class="cong_icon"><i class="fa fa-check"></i></div>
        <h2>Verified!</h2>
        <h4>Your mobile number has been verified successfully.</h4>
        <a href="<?php echo base_url(); ?>user/dashboard?notify=true" class="btn btn-primary">Get Started!</a>
    </div>
</div>
    
<script> var base_url = '<?php echo base_url(); ?>'; </script>

<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/dist/bootstrapValidator.js" type="text/javascript"></script>
<script>
//   window.onload = function() {
//        $('#signup_guru_modal').modal();
//    }
</script>

<script src="<?php echo base_url()."assets/" ?>js/guru.js" type="text/javascript"></script>

</body>
</html>
