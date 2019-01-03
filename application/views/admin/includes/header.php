<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <?php   
    $session_favicon = $this->session->userdata('favicon');
    if(!empty($session_favicon)){
        $favicon = 'uploads/'.$session_favicon;
    }else{
        $favicon = 'assets/img/favicon.png';
    }
    ?>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url().$favicon ?>">
    <title><?php echo $title; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
		<!--[if lt IE 9]>
			<script src="<?php echo base_url(); ?>assets/js/html5shiv.min.js"></script>
			<script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
		<![endif]-->
    </head>
    <body>
        <!-- Notification -->
        <div class="notification-popup success hide">
            <p>
                <span class="task"></span>
                <span class="notification-text"></span>
            </p>
        </div>
        <!-- Notification -->