<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mobile Verification</title>

<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.png"> 
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrapValidator.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">
</head>

<body>

<div class="success-signup" id="signup_applicant_modal">
	<div class="container">
        <form name="send_messages" id="send_messages">
            <div class="cong_icon"><i class="fa fa-check"></i></div>
            <h2>Congratulations!</h2>
            <h4>Your account has been created successfully.</h4>
            <p>We are glad you decided to take charge of your future. Feel free to browse around.</p>
            <p>You will receive a verification email shortly.</p>
            <button type="button" class="btn btn-primary" onClick="window.location='<?php echo base_url(); ?>user/gurus'">Continue</button>
        </form>
    </div>
</div>
 
<?php /*?><div class="" id="signup_applicant_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <form name="send_messages" id="send_messages">      
                  <div class="modal-header">
                    <h3>Congratulations!!</h3>
                  </div>
                  <div class="modal-body">
                      <p>Welcome <?php echo $this->session->userdata('first_name'); ?>! We are glad you decided to take charge of your future. Feel free to browse around.</p>                   
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onClick="window.location='<?php echo base_url(); ?>user/gurus'">Continue</button>
                  </div>
                  </form>
                </div>
              </div>
</div><?php */?>


<script> var base_url = '<?php echo base_url(); ?>'; </script>
<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/guru.js" type="text/javascript"></script>
</body>
</html>