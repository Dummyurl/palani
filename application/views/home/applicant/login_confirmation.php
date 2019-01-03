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
    <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrapValidator.css" type="text/css">
</head>

<body class="account-page">
    <section class="mainarea account-box-area">
    	<div class="container">
            
            
            <div class="account-box account-box-signup">
                <a href="<?php echo base_url(); ?>">
                    <div class="login-logo">
                       <img src="<?php echo base_url()."assets/" ?>images/login-icon.png" alt=""/>
                   </div>
               </a>
               
               <div class="small-step">
                <a href="<?php echo base_url()."user/login_confirmation/".$this->session->userdata('applicant_id')."/1/guru"; ?>">
                    <div class="step-left">
                        <div>
                        	<img src="<?php echo base_url()."assets/" ?>images/img-03.jpg" alt="" width="395" height="250"></div>
                            <div class="step-cont">
                                <div class="step-arrow">
                                    <p><span>Become a</span> <br/><span class="text-link">School Guru</span></p>
                                    <button type="button" class="btn btn-default btn-xs click-btn">Click Here</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <p>&nbsp;</p>
                
                <div class="small-step">
                    <a href="<?php echo base_url()."user/login_confirmation/".$this->session->userdata('applicant_id')."/0/user"; ?>">
                        <div class="step-right">
                            <img src="<?php echo base_url()."assets/" ?>images/img-02.jpg" alt="" width="395" height="250">
                            <div class="step-cont">
                                <div class="step-arrow">
                                    <button type="button" class="btn btn-default btn-xs click-btn">Click Here</button>
                                    <p><span>Get help from a</span> <br/><span class="text-link">School Guru</span></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>            
            </div>            
        </div>
        
    </section>
    <script> var base_url = "<?php echo base_url(); ?>" </script>
    <script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url()."assets/" ?>js/bootstrapValidator.js" type="text/javascript"></script>
    <script src="<?php echo base_url()."assets/" ?>js/applicant.js" type="text/javascript"></script>
</body>
</html>