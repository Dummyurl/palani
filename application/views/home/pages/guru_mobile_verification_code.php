<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mobile Verification</title>

<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.png"> 
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrapValidator.css" type="text/css">
<script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>
</head>

<body>

<table width="600" cellpadding="0" cellspacing="0" align="center">
	<tr>
    	<td style="padding:50px 50px 50px 50px; border:1px solid #bfc0cd; border-radius:20px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td>
                        <p style="margin:0; padding:0;"><a href="<?php echo base_url(); ?>" target="_blank"><img src="<?php echo base_url(); ?>assets/images/schoolguru-logo-emailtemplate.png" /></a></p>
                        <h1 style="font-family:Arial, Helvetica, sans-serif; font-size:36px; color:#000; font-weight:bold; margin:50px 0 10px 0; padding:0;">Hi, <?php echo $result['first_name'].' '.$result['last_name']; ?></h1>
                        <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#808080; font-weight:normal; margin:0 0 30px 0; padding:0;">Thank you for choosing <span style="font-weight:bold; color:#5c65be;">SchoolGuru</span></h2>
                        <form method="post" id="mobile_verify_code_form">
                        <div id="error_msg" style="color:red;"></div>
                        <div class="row">
                            <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Mobile Verification Code <span style="color:red;">*</span></label>
                                <input type="text" name="verification_code" id="verification_code" class="form-control" value="" required/>
                            </div>
                            </div>
                         </div>
                        <button type="submit" class="btn btn-success account-btn">Verify Your Code</button>
                        </form>
                    </td>
                </tr>
            </table>	
        </td>
    </tr>
    <tr>
    	<td align="center">
        	<p style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#808080; font-weight:normal; line-height:24px; margin:40px 0 40px 0; padding:0;">&copy; 2017 All rights reserved by <a href="<?php echo base_url(); ?>" target="_blank" style="color:#808080; text-decoration:none;">schoolguru.com</a><br />
			<a href="#" target="_blank" style="color:#808080; text-decoration:none;">Privacy Policy</a> and <a href="#" target="_blank" style="color:#808080; text-decoration:none;">Terms & Conditions</a></p>
        </td>
    </tr>
</table>
<script> var base_url = '<?php echo base_url(); ?>'; </script>
<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/guru.js" type="text/javascript"></script>
</body>
</html>
