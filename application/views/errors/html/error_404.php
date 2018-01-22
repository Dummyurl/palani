<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
        <head>
                <meta charset="utf-8">
                <!--[if IE]>
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <![endif]-->
                <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
                <title>School Guru</title>
                <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.png">
                <link href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" rel="stylesheet">
                <link href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" rel="stylesheet">
                <link href="<?php echo base_url()."assets/" ?>css/cardeffect.css" rel="stylesheet">
                <link href="<?php echo base_url()."assets/" ?>css/style.css" rel="stylesheet">     
	   </head>
         <body class="search-page">
		 <div class="overlay">
           <div id="loading-img"></div>
         </div>
           <section class="mainarea">
    	   <div class="container">
                <header id="header" class="horz header">
                        <nav class="navbar navbar-fixed-top bg-transparent top-nav-collapse" id="main-navbar">
                                <div class="container">
                                        <div class="navbar-header">
                                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                                                        <span class="sr-only">Toggle navigation</span>
                                                        <span class="icon-bar"></span>
                                                        <span class="icon-bar"></span>
                                                        <span class="icon-bar"></span>
                                                </button>
                                                <a href="<?php echo base_url(); ?>" class="navbar-brand"><img src="<?php echo base_url()."assets/" ?>images/logo-dark.png" alt="logo" /></a>
                                        </div>
                                        <div class="collapse navbar-collapse" id="navbar-collapse">
                                                <ul class="nav navbar-nav navbar-right top-menu">
                                                    <li><a href="<?php echo base_url()."guru"; ?>">Become a School Guru</a></li>
                                                    <li><a href="<?php echo base_url()."user"; ?>">Get help from School Guru</a></li>
                                                    <li><a href="<?php echo base_url(); ?>welcome/#feedback">Feedback</a></li>
                                                    <li class="login-menu"><a href="<?php echo base_url()."login" ?>">Login</a></li>
                                                    <li class="login-menu"><a href="<?php echo base_url()."signup" ?>">Signup</a></li>
                                                </ul>
                                        </div>
                                </div>
                        </nav>
                </header>    
<section class="mainarea ">
 <div class="container">
<div class="row">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
     </div>
        </section>
        </div>
        </section>
         </div>
<script> var base_url = "<?php echo base_url(); ?>" </script>
<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js"></script>

<script>
(function() {
var rotate, timeline;

rotate = function() {
return $('.card:first-child').fadeOut(400, 'swing', function() {
return $('.card:first-child').appendTo('.work-img').hide();
}).fadeIn(400, 'swing');
};

timeline = setInterval(rotate, 4000);

$('body').hover(function() {
return clearInterval(timeline);
});

$('.card').click(function() {
return rotate();
});
}).call(this);
</script>
</body>
</html>