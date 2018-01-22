<?php 
    if($this->session->userdata('applicant_id') != '' && $this->session->userdata('type') != ''){
            $this->load->view('home/guru/header'); 
}else{ 
    
    ?>
<!DOCTYPE html>
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
                <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrapValidator.css" type="text/css">
        </head>
         <body class="search-page">
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
                                                    <li><a href="<?php echo base_url(); ?>welcome#feedback">Feedback</a></li>
                                                    <li class="login-menu"><a href="<?php echo base_url()."login" ?>">Login</a></li>
                                                    <li class="login-menu"><a href="<?php echo base_url()."signup" ?>">Signup</a></li>
                                                </ul>
                                        </div>
                                </div>
                        </nav>
                </header>    
<section class="mainarea ">
 <div class="container">
    <?php } ?>
<div class="row">
    <?php 
    $img1 = '';
    if($gurus['picture_url'] != '')
    {
        $img1 = $gurus['picture_url'];
        
    }
    if($gurus['profile_img'] != '')
    {
        $file_to_check = FCPATH . '/assets/images/' . $gurus['profile_img'];
        if (file_exists($file_to_check)) {
            $img1 = base_url() . 'assets/images/'.$gurus['profile_img'];
        }
    }
        $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
     ?>
<div class="col-sm-8 col-xs-8">
        <div class="profile-section">
                <div class="profile-top">
                        <div class="row">
                                <div class="col-md-3 col-sm-5 col-xs-12">
                                        <div class="img-box">
                                                <img alt="" class="img-responsive img-circle" src="<?php echo $img; ?>" height="165" width="165">
                                        </div>
                                </div>
                                <div class="col-md-9 col-sm-7 col-xs-12">
                                        <div class="user-details">
                                             <?php $city = ($gurus['city'] != '') ? $gurus['city'] : ""; ?>
                                                  <?php $countryname = ($gurus['country_name'] != '') ? $gurus['country_name'] : ""; ?>
                                                  <?php $addr = 'N/A';
                                                        if($city != '') {
                                                            $addr = $city;
                                                        } 
                                                        if($countryname != '') {
                                                            $addr = $countryname;
                                                        } 
                                                        if($city != '' && $countryname != '') {
                                                            $addr = $city.', '.$countryname;
                                                        } 
                                                   ?>
                                                   <?php $mentor_year = 'N/A';
                                                        if($gurus['mentor_current_year'] != '' && $gurus['mentor_current_year'] > 0) {
                                                            if($gurus['mentor_current_year'] == 1){
                                                             $mentor_year ='First Year'; 
                                                            }
                                                            if($gurus['mentor_current_year'] == 2){
                                                             $mentor_year ='Second Year'; 
                                                            }
                                                            if($gurus['mentor_current_year'] == 3){
                                                             $mentor_year ='Third Year'; 
                                                            } 
                                                            if($gurus['mentor_current_year'] == 4){
                                                             $mentor_year ='Fourth Year'; 
                                                            } 
                                                        } 
                                                        if($gurus['mentor_school'] != '') {
                                                            $mentor_year = $gurus['mentor_school'];
                                                        } 
                                                        if($gurus['mentor_current_year'] != '' && $gurus['mentor_current_year'] > 0 && $gurus['mentor_school'] != '') {
                                                            if($gurus['mentor_current_year'] == 1){
                                                             $mentor_year ='First Year'; 
                                                            }
                                                            if($gurus['mentor_current_year'] == 2){
                                                             $mentor_year ='Second Year'; 
                                                            }
                                                            if($gurus['mentor_current_year'] == 3){
                                                             $mentor_year ='Third Year'; 
                                                            } 
                                                            if($gurus['mentor_current_year'] == 4){
                                                             $mentor_year ='Fourth Year'; 
                                                            } 
                                                            $mentor_year = $mentor_year.', '.$gurus['mentor_school'];
                                                        } 
                                                   ?>
                                            <?php //$school = ($current_year != '' && $gurus['mentor_school'] != '') ? ', '.$gurus['mentor_school'] : $gurus['mentor_school']; ?>
                                                
                                            <div class="user-name"><a><?php echo $gurus['first_name']." ".$gurus['last_name'];  ?></a></div>
                                                <h4 class="user-title"><a><?php echo $gurus['mentor_personal_message'] ?></a></h4>
                                                <div class="user-education"><i class="fa fa-graduation-cap"></i> <?php echo $mentor_year; ?></div>
                                                <div class="user-address"><i class="fa fa-map-marker"></i><?php echo $addr; ?></div>
                                                <div class="ratings">
                                                    <?php for($i=1; $i<=5 ;$i++) {
                                                            if($i <= $gurus['rating_value']){
                                                     ?>
                                                        <i class="fa fa-star" style="color:#ffc513;"></i>
                                                     <?php }else{ ?>
                                                        <i class="fa fa-star"></i>
                                                    <?php } 
                                                 } ?>
                                                        
                                                        <span class="rating-count"><?php echo ($gurus['rating_value'] > 0) ? $gurus['rating_value'] : '0'; ?></span>
                                                        <span class="total-rating">(<?php echo ($gurus['rating_count'] > 0) ? $gurus['rating_count'] : '0'; ?>)</span>
                                                </div>
                                        </div>
                           </div>
                        </div>
                </div>
                <div class="profile-view-bottom">
        <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>What schools did you apply to?</h6>
                        <h5><?php echo ($gurus['mentor_schools_applied']) ? $gurus['mentor_schools_applied'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>What clubs are you part of?</h6>
                        <h5><?php echo ($gurus['mentor_clubs']) ? $gurus['mentor_clubs'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>What executive positions in clubs do you hold at your school?</h6>
                        <h5><?php echo ($gurus['mentor_executive_positions']) ? $gurus['mentor_executive_positions'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>What schools did you apply to?</h6>
                        <h5><?php echo ($gurus['mentor_schools_applied']) ? $gurus['mentor_schools_applied'] : 'N/A'; ?></h5>
                </div>
        </div>
        <div class="row">
                <div class="col-sm-12 m-t-20 m-b-30">
                        <h4>What jobs did you hold between undergrad and B-school?</h4>
                        <h5 class="dsgnation"><?php echo ($gurus['mentor_job_title']) ? $gurus['mentor_job_title'] : 'N/A' ; ?><br/>
                                <?php echo $gurus['mentor_job_company']; ?><br/>
                                <?php echo $gurus['mentor_job_dept']; ?><br/>
                                <?php echo $gurus['mentor_job_location']; ?>
                        </h5>
                        <p><?php echo $gurus['mentor_job_desc']; ?></p>
                </div>
        </div>
<div class="row">
                <div class="col-sm-12 m-t-0 m-b-50">
                        <h4>Charging: $<?php echo ($gurus['mentor_charge'] != '' ) ? $gurus['mentor_charge'] : "0.00"; ?>/hour</h4>
                </div>
        </div>
        <div class="row">
                <div class="col-xs-12">
                        <h6>About yourself</h6>
                        <h5><?php echo ($gurus['mentor_personal_message'] != '') ? $gurus['mentor_personal_message'] : 'N/A'; ?></h5>
                </div>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>A personal statement</h6>
                        <h5><?php echo ($gurus['mentor_personal_message'] != '') ? $gurus['mentor_personal_message'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>What was your undergrad school?</h6>
                        <h5><?php echo ($gurus['mentor_school_accepted'] != '') ? $gurus['mentor_school_accepted'] : 'N/A'; ?></h5>
                </div>
<div class="col-xs-12 m-b-20">
                        <h4>How much research did you do for each school?</h4>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Did you read the guides, which ones?</h6>
                        <h5><?php echo ($gurus['mentor_read_guide'] != '') ? $gurus['mentor_read_guide'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Did you hire a consultant?</h6>
                        <h5><?php echo ($gurus['mentor_hire_consult'] != '') ? $gurus['mentor_hire_consult'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Did you visit schools applied to?</h6>
                        <h5><?php echo ($gurus['mentor_visit_school'] != '') ? $gurus['mentor_visit_school'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Did you take tours?</h6>
                        <h5><?php echo ($gurus['mentor_tour'] != '') ? $gurus['mentor_tour'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Other?</h6>
                        <h5><?php echo ($gurus['mentor_other_extra'] != '') ? $gurus['mentor_other_extra'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h6>What other extracurricular activities are you involved in? Were involved in undergrad?</h6>
                        <h5><?php echo ($gurus['mentor_extracurricular_activities'] != '') ? $gurus['mentor_extracurricular_activities'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>What HS did you go to?</h6>
                        <h5><?php echo ($gurus['mentor_hs'] != '') ? $gurus['mentor_hs'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Where are you from?</h6>
                        <h5><?php echo ($gurus['mentor_from'] != '') ? $gurus['mentor_from'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>What countries did you live and work in?</h6>
                        <h5><?php echo ($gurus['mentor_live_work'] != '') ? $gurus['mentor_live_work'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>What languages do you speak?</h6>
                        <h5><?php echo ($gurus['mentor_languages_speak'] != '') ? $gurus['mentor_languages_speak'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h6>You Favorite Book, Movie, Business Book, Business Publication, Business Leader, Personal Role Model</h6>
                        <h5><?php echo ($gurus['mentor_favourite'] != '') ? $gurus['mentor_favourite'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Hobbies</h6>
                        <h5><?php echo ($gurus['mentor_hobbies'] != '') ? $gurus['mentor_hobbies'] : 'N/A'; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Quotes</h6>
                        <h5><?php echo ($gurus['mentor_quotes'] !='') ? $gurus['mentor_quotes'] : 'N/A'; ?></h5>
                </div>
        </div>
</div>
        </div>
</div>
<div class="col-sm-4 col-xs-4">
        <div class="rightsidebar">
                <div class="widget guru-details-widget">
                        <div class="price text-center"><sup class="currency">$</sup> <span class="amount"><?php echo ($gurus['mentor_charge']!= '') ? $gurus['mentor_charge'] : '0.00'; ?></span>/hour</div>
                        <div class="contact-btn text-center">
                           <button class="btn btn-primary" title="Contact <?php echo $gurus['first_name']; ?>" onClick="window.location='<?php echo base_url(); ?>user/login'"><img src="<?php echo base_url();?>assets/images/contact-icon.png"> Contact <?php echo $gurus['first_name']; ?></button>
                        </div>
                </div>
            <div class="widget review-widget">
                        <h4>Reviews</h4>
                        <?php $i=1; ?>
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php $count_review = 0; if(!empty($reviews)) : ?>
                    <?php foreach($reviews as $review): ?>
                    <?php if(!empty($review['review'])): ?>
                        <?php $count_review++; ?>
                        <div class="item <?php if ($i == 1) echo 'active'; ?>">
                        <div class="review-content">
                        <div class="review-details">
                        <span class="testimonial-caret"></span>
                        <p><?php echo $review['review']; ?></p>
                        </div>
                        <div class="review-author"><span><?php echo $review['reviewer_name']; ?></span></div>
                        </div>
                        </div>
                    <?php $i++; endif; endforeach;  ?>
                    <?php if(!empty($reviews) && $count_review < 1): ?>
                    <p>No more reviews</p>
                    <?php endif; ?>
                    <?php else: ?>
                    <p>No more reviews</p>
                    <?php endif; ?>
                </div>
                </div>
                </div>
        </div>
        </div>
   </div>
     </div>
        </section>
           </div>
        </section>
<script> var base_url = "<?php echo base_url(); ?>" </script>
<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrapValidator.js" type="text/javascript"></script>

<script src="<?php echo base_url()."assets/" ?>js/chosen.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/guru.js" type="text/javascript"></script>

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