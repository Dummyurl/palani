<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Signup - Mentori</title>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.png">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/signup.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/responsive.css" type="text/css">
</head>

<body class="account-page">


    <section class="mainarea account-box-area">
    	<div class="container">
			<div class="row account-box account-box-signup">
				<a href="<?php echo base_url(); ?>">
					<div class="login-logo">
						<img src="<?php echo base_url()."assets/" ?>images/login-icon.png" class="img-responsive" alt=""/>
					</div>
				</a>
                   <?php  
                            if($this->session->flashdata('msg')){
                        echo '<div class="alert alert-danger">'.$this->session->flashdata('msg').'<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>';             
                            }
                    ?>
                <div class="becbox mt col-sm-6">
                    <a href="<?php echo base_url()."signup_mentor"; ?>">
                        <div class="bbtitle text-center">Become a <span>Mentor</span></div>
                        <div class="bbimg"><img src="<?php echo base_url(); ?>mentori_assets/img/mentor.jpg" class="img-responsive"></div>
                        <div class="bbarrow"><img src="<?php echo base_url(); ?>mentori_assets/img/arrow.png" class="img-responsive"></div>
                    </a>
                </div>
                
                <div class="becbox col-sm-6">
                    <a href="<?php echo base_url()."signup_mentee"; ?>">
                        <div class="bbtitle text-center">Become a <span>Mentee</span></div>
                        <div class="bbimg"><img src="<?php echo base_url(); ?>mentori_assets/img/mentee.jpg" class="img-responsive"></div>
                        <div class="bbarrow"><img src="<?php echo base_url(); ?>mentori_assets/img/arrow.png" class="img-responsive"></div>
                    </a>
                </div>
                
			</div>
        </div>
    </section>
	<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>