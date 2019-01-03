<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
        <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>eLearning Portal | Your mentor is a click away</title>
    
    <meta charset="utf-8" description="Mentoring is the 1st e-learning portal, offer 5000+ courses in a wide range of categories like Education, Yoga, Dance, Music, Skill and more classes with all new technologies tools.">

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.png">  
    <link href="<?php echo base_url();?>mentori_assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>mentori_assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url();?>mentori_assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>mentori_assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/home.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrapValidator.css" type="text/css">

</head>
<body>
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-3 mob-menu">
                        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>mentori_assets/img/logo.png" alt="Mentori.ng" class="img-responsive">
                        </a>
                        <div class="hamburger navbar-toggle collapsed mob-icon-menu img-responsive visible-xs" data-toggle="slide-collapse" data-target="#slide-navbar-collapse" aria-expanded="false">
                          <div class="burger-main">
                            <div class="burger-inner">
                              <span class="top"></span>
                              <span class="mid"></span>
                              <span class="bot"></span>
                            </div>
                          </div>
                        </div> 
                </div>
                <div class="col-md-8 col-sm-9 mainnav nav-mobile-menu">
                    <div class="collapse navbar-collapse" id="slide-navbar-collapse">    
                        <ul>
                            <?php if(empty($this->session->userdata('applicant_id'))){?>

                            <li><a href="<?php echo base_url()."blog"; ?>">Blog</a></li>
                            <li><a href="<?php echo base_url()."signup_mentor"; ?>">Become a Mentor</a></li>
                            <li><a href="<?php echo base_url()."signup_mentee"; ?>">Become a Mentee</a></li>
                            <!-- <li><a href="#feedback">Feedback</a></li> -->
                            <li><a href="<?php echo base_url()."login" ?>">Login</a></li>
                            <li><a href="<?php echo base_url()."signup" ?>">Register</a></li>
                            <?php }else{

                                echo ' <li><a href="'.base_url().'blog">Blog</a></li>
                                        <li><a href="'.base_url().'dashboard">Dashboard</a></li>
                                      <li><a href="'.base_url().'user/logout">Logout</a></li>';

                            } ?>
                        </ul>
                     </div>
                </div>
            </div>    
        </div>
    </header>
    <!-- video section start -->
    <section class="section-banner">
        <div class="home-banner">        
                 <div class="videoWrapper">
                     <div class="overlays"></div>
                     <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
                            <source src="<?php echo base_url();?>assets/videos/banner_video.mp4" type="video/mp4">
                     </video>
                 </div>
                 <div class="banner-container">
                            <div class="bancntr">
                                <h1 class="fadeInDown animated"><span class="bancntr-title">MENTORI.NG</span> People to grow</h1>                    
                                <p>Private, 1–on–1 lessons with the expert instructor of your choice. You decide when to meet, how much to pay, and who you want to work with.</p>
                                <div class="formcntr fadeIn animated">
                                    <small>What would you like to learn?</small>
                                    <form action="<?php echo base_url(); ?>search-mentor" method="post" id="search_by_subject1">
                                        <div class="input-group">
                                            <input type="text" class="form-control subject_keyword" name="keyword" id="subject_keyword" autocomplete="off">
                                            <span class="input-group-addon">
                                                <input type="submit" class="form-control" value="Go">
                                        </div>
                                    </form>
                                </div>
                                 <div class="keyword_result divResult"></div>
                            </div>
                </div>
            </div>  
            <div class='icon-scroll hidden-xs hidden-sm'></div>    
    </section>        
    <!-- video section end -->
       
    <!-- intro section start -->
        <section class="introrow">
            <div class="container">
                <div class="row intro-section">
                    <div class="col-sm-7 col-md-6 introleft">                
                        <h2>Did you know?</h2>
                        <h3>Mentoring, What it does?</h3>                        
                        <p>Mentoring is a sophisticated platform created to spread knowledge. There are several types of mentors you can find, and using this sophisticated platform, you will be able to improve your knowledge or skill in several areas through skilled personal on a very small price. Mentori.ng is a platform that is invested in your growth and success. Sign-up now!.</p>
                    </div>
                    <div class="col-sm-5 col-md-6">
                        <div class="introright">
                            <iframe src="https://www.youtube.com/embed/o0uOynG5VX8" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen autoplay="off"></iframe></div>
                    </div>
                </div>
            </div>
        </section>
    <!-- video section end  -->

    <!-- howit works section start -->
        <section class="howitrow">
            <div class="container">
                <div class="row intro-section">
                    <h2 class="how-title">How does it works ?</h2>
                   <div>
                        <img src="<?php echo base_url();?>assets/images/howto.png" class="img-responsive">
                   </div>                   
              
                <div class="col-sm-12 col-md-12 howitright">
                    <div class="row">
                        <div class="howiconrow col-md-4 col-sm-4">
                            <div class="howitworks">
                                <div class="howiconleft"><img src="<?php echo base_url();?>assets/images/Signup.png" class="img-responsive"></div>
                                <div class="howiconright">
                                    <h4>Sign up</h4>
                                    <p>Join to search your mentor on the skill you need.</p>
                                </div>
                            </div>
                        </div>
                        <div class="howiconrow col-md-4 col-sm-4">
                            <div class="howitworks">
                                <div class="howiconleft btn-video"><img src="<?php echo base_url();?>assets/images/collabrate.png" class="img-responsive"></div>
                                <div class="howiconright">
                                    <h4>Colloborate</h4>
                                    <p>collaborate on your own timing, by scheduling with mentor</p>
                                </div>
                            </div>
                        </div>
                        <div class="howiconrow col-md-4 col-sm-4">
                            <div class="howitworks">
                                <div class="howiconleft"><img src="<?php echo base_url();?>assets/images/Improve.png" class="img-responsive"></div>
                                <div class="howiconright">
                                    <h4>Improve and Get Back</h4>
                                    <p>you can gather different skill set, and you can become mentor too.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Howit works section end -->
    <!-- Platform section start -->
    <section class="becomerow">
        <div class="container">
            <div class="row platform-section">
                <div class="section-tiel-platform">
                    <h2 class="text-center">Platform for both Mentors & Mentees</h2>
                    <h3 class="text-center">“One small step on the right direction, will lead to a new world”</h3>
                </div>    
                <div class="col-sm-6 col-md-6 col-xs-6">
                    <div class="becbox">
                        <a href="<?php echo base_url()."signup_mentor"; ?>">
                            <div class="bbtitle">Become a <span>Mentor</span></div>
                            <div class="bbimg"><img src="<?php echo base_url();?>mentori_assets/img/mentor.jpg" class="img-responsive"></div>
                            <div class="bbarrow"><img src="<?php echo base_url();?>mentori_assets/img/arrow.png" class="img-responsive"></div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-xs-6">
                    <div class="becbox">
                        <a href="<?php echo base_url()."signup_mentee"; ?>">
                            <div class="bbtitle">Become a <span>Mentee</span></div>
                            <div class="bbimg"><img src="<?php echo base_url();?>mentori_assets/img/mentee.jpg" class="img-responsive"></div>
                            <div class="bbarrow"><img src="<?php echo base_url();?>mentori_assets/img/arrow.png" class="img-responsive"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Platform section end -->
    <!-- FAQ  -->
    <section class="faq-blk">
        <div class="container">
            <div class="row">
                        <div class="col-sm-2 col-md-1 col-xs-2 help-center-img">
                            <img class="img img-responsive" src="<?php echo base_url(); ?>assets/images/faq-icon.png" class="img-responsive"/>
                        </div>
                        <div class="col-sm-10 col-md-11 col-xs-10">
                            <div class="row">
                                <div class="col-sm-8 still">
                                    <h2>Still have a question?</h2>
                                    <p>Get answers in our Help Center or connect with Customer Support.</p>                            
                                </div>
                                <div class="col-sm-4">
                                    <a class="btn btn-faq pull-right" href="<?php echo base_url();?>faq">get answers</a>
                                </div>                        
                            </div>
                        </div>          
            </div>
        </div>
    </section>

    <section class="course-grid-blk">
        <div class="container">
            <div class="row">

                <!-- List of mentors  starts here  -->
                <?php if(!empty($mentors)){ 

                    foreach($mentors as $guru_list){?>
                      <div class="course-grid">
                        <a href="<?php echo base_url(); ?>mentor-profile/<?php echo $guru_list['username'] ?>">
                        <div class="col-md-3 col-sm-6">
                            <div class="course-blk">
                                <div class="course-img-top">
                                    <img class="img img-responsive" src="<?php echo base_url(); ?>assets/images/course-4.jpg" class="img-responsive" />
                                </div>
                                <div class="course-content-bottom">
                                    <?php 
                                    $where  = array('mentor_id'=>$guru_list['mentor_id']);
                                    $courses = $this->db
                                    ->select('c.course')                                                
                                    ->join('courses c','c.course_id = m.course_id')
                                    ->join('subject s','s.subject_id = c.subject_id')
                                    ->get_where('mentor_course_details m',$where)
                                    ->result_array(); 
                                    $subs=array();
                                    if(!empty($courses)){
                                        foreach($courses as $s){
                                            $subs[]=$s['course'];
                                        }
                                        $course = implode(',',$subs);
                                        
                                    }else{
                                        $course = '-';
                                    }
                                    echo '<h5>'.$course.'</h5>';                                   


                                    if(!empty($guru_list['profile_img'])){

                                        $mentor_img = $guru_list['profile_img'];    
                                        $file_to_check = FCPATH . '/assets/images/' . $mentor_img;
                                        if (file_exists($file_to_check)) {
                                            $mentor_img = base_url() . 'assets/images/'.$mentor_img;
                                        }else{
                                            $mentor_img = base_url() . 'assets/images/default-avatar.png';
                                        }  
                                    }else if(empty($guru_list['picture_url']) && !empty($guru_list['picture_url'])){
                                        $mentor_img = $guru_list['picture_url'];      
                                    }else{
                                        $mentor_img = base_url() . 'assets/images/default-avatar.png';
                                    }





                                    ?>

                                    <div class="row vertical-align md-mb-14">
                                        <div class="col-xs-7">
                                            <div class="course-author-blk">
                                                <ul class="list-unstyled">
                                                    <li><img class="img img-responsive img-circle" height="40" width="40" src="<?php echo $mentor_img;?>"  /></li>
                                                    <li><p><?php echo $guru_list['first_name'].' '.$guru_list['last_name']; ?></p></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-xs-5">
                                            <div class="user-count pull-right">
                                                <ul class="list-inline">
                                                    <li><i class="fa fa-users"></i></li>
                                                    <?php 

                                                    $where = array('invite_to'=>$guru_list['app_id'],'approved' =>1);

                                                    $count = $this->db->group_by('invite_from')
                                                    ->get_where('invite',$where)
                                                    ->num_rows();

                                                    ?>
                                                    <li><p><?php echo $count; ?></p></li>
                                                </ul>
                                            </div>
                                        </div>          
                                    </div>
                                    <div class="clearfix border-top"></div>
                                    <div class="row vertical-align row-vmargin-14">
                                        <div class="col-xs-7">
                                            <div class="ratings">
                                                <?php 
                                                echo '<div class="course-rating-blk starrr" id="stars" data-rating="'.$guru_list['rating_value'].'"></div>';                              ?>                                
                                            </div>                                    
                                        </div>
                                        <div class="col-xs-5">
                                            <div class="course-price pull-right">
                                                <ul class="list-inline">                                            
                                                    <?php
                                                    if($guru_list['charge_type'] == 'charge' && !empty($guru_list['hourly_rate'])){
                                                        $rate =  '$'.number_format($guru_list['hourly_rate'],2);
                                                    }elseif($guru_list['charge_type'] == 'free'){
                                                        $rate =  'Free';
                                                    }else{
                                                        $rate =  'N/A';
                                                    }
                                                    ?>
                                                    <li><p><?php echo $rate; ?></p></li>
                                                </ul>
                                            </div>
                                        </div>          
                                    </div>          
                                </div>
                            </div>
                        </div> 
                        </a>  
                    </div>
                    <?php     }   } ?>       
                    <!-- List of mentors  ends here  -->   

                </div>
            </div>
        </section>

        <section class="formrow">
            <div class="container">
                <div class="row flex-formrow">
                    <div class="col-sm-6 formleft">
                        <h2>We want your feedback</h2>
                        <h3>How to make our service better</h3>
                    </div>
                    <div class="col-sm-6">
                        <form id="feedback">
                            <div class="form-group">
                                <input type="text" placeholder="Your Name" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Your Email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <textarea placeholder="Your Message" class="form-control" id="message" name="message"></textarea><br>
                            </div>
                            <input type="submit" value="submit" class="form-control">
                        </form>
                    </div>
                </div>
            </div>
        </section>
            <!-- app download section start -->
        <section class="app-download-wrapper">
            <div class="container">
                <div class="row flex-formrow">
                    <div class="col-md-6">
                        <div class="p1-lft">
                                <img src="<?php echo base_url(); ?>assets/images/app-img.png" class="img-responsive" alt="">
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="p1-rhts">
                                <div class="p1-rht">
                                    <div class="p1-rht-header">
                                        <h2>Download our free app</h2>
                                        <h3>Please click the below link to download the app.</h3>
                                    </div>
                                    <div class="p1-rht-content">                            
                                        <div class="social-link text-center">
                                            <span><a href=" https://play.google.com/store/apps/details?id=com.dreamguys.mentoring&hl=en" target="_blank"><img src="<?php echo base_url(); ?>assets/images/googleplay.png" class="img-responsive" alt=""></a></span>
                                            <!-- <span><a href="javascript:void(0)"><img src="<?php echo base_url(); ?>assets/images/appstore.png" class="img-responsive" alt=""></a></span> -->
                                        </div>
                                    </div>
                                </div>
                        </div>  
                    </div>
                </div>
            </div>
        </section>
        <!-- app download section end -->
        
        

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-2 col-xs-6 col-sm-3">
                        <div class="footer-widget-first">
                            <h4>learn with us</h4>
                            <ul class="list-unstyled">
                                <li><a href="<?php echo base_url(); ?>signup_mentor">Become a mentor</a></li>
                                <li><a href="<?php echo base_url(); ?>signup_mentee">Become a mentee</a></li>
                                <li><a href="<?php echo base_url(); ?>login">login</a></li>
                                <li><a href="<?php echo base_url(); ?>signup">register</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-6 col-sm-3">
                        <div class="footer-widget-first">
                            <h4>Become a mentor</h4>
                            <ul class="list-unstyled">
                                <li><a href="<?php echo base_url(); ?>signup_mentor">signup</a></li>
                                <li><a href="<?php echo base_url(); ?>login">login</a></li>
                            </ul>
                        </div>      
                    </div>
                    <div class="col-md-2 col-xs-6 col-sm-3">
                        <div class="footer-widget-first">
                            <h4>Become a mentee</h4>
                            <ul class="list-unstyled">
                                <li><a href="<?php echo base_url(); ?>signup_mentee">signup</a></li>
                                <li><a href="<?php echo base_url(); ?>login">login</a></li>      
                            </ul>
                        </div>      
                    </div>      
                    <div class="col-md-6 col-xs-6 col-sm-3">
                        <div class="footer-widget-first">
                            <h4>Download our free app</h4>
                            <p>Please click the below link to download the app.</p>
                            <div class="footer-form-blk">
                                <form>
                                   <!--  <div class="row row-vmargin-14">
                                        <div class="col-xs-7">
                                            <div class="form-group">
                                                <input type="tel" class="form-control" id="telphone" placeholder="(123) 456-7890" maxlength="14" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="col-xs-5">
                                            <div class="form-check">
                                                <label>
                                                    <input type="radio" name="radio" checked> <span class="label-text">App for Mentee</span>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label>
                                                    <input type="radio" name="radio"> <span class="label-text">App for Mentors</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="row vertical-align">
                                      <!--   <div class="col-xs-5">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-app">send a link</button>
                                            </div>
                                        </div> -->
                                        <div class="col-xs-7">
                                            <div class="app-download">
                                                <ul class="list-unstyled list-inline">
                                                    <li><a href="https://play.google.com/store/apps/details?id=com.dreamguys.mentoring&hl=en" target="_blank"><img class="img img-responsive" src="<?php echo base_url(); ?>assets/images/googleplay-icon.png"><span>Google Play</span></a></li>
                                                    <!-- <li><a href="javascript:;"><img class="img img-responsive iphone-size" src="<?php echo base_url(); ?>assets/images/iphone-icon.png">App Store</a></li> -->
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>      
                    </div>      
                </div>
                <hr>
                <div class="row vertical-align">
                    <div class="col-sm-6 col-xs-12">
                        <p class="hidden">
                            <a href="#">Become a Mentor</a><span class="divider">/</span>
                            <a href="#">Become a Mentee</a><span class="divider">/</span>
                            <a href="#">Feedback</a><span class="divider">/</span>
                            <a href="#">Login</a><span class="divider">/</span>
                            <a href="#">Register</a>
                        </p>
                        <p>© 2018 Mentori.ng. All rights reserved.</p>
                    </div>
                    <div class="col-sm-6 col-xs-12 social">
                        <ul>
                            <li><a href="https://www.facebook.com/MentoringElearning" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="https://twitter.com/Mentori_ng" target="blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href=" https://www.linkedin.com/in/mentoring-dgt-3b4080176/" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                            <li><a href="https://www.youtube.com/embed/o0uOynG5VX8" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>      

            </div>
        </footer>
        <script> var base_url = "<?php echo base_url(); ?>" </script>
        <script src="<?php echo base_url();?>mentori_assets/js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url();?>mentori_assets/js/bootstrap.js"></script>
        <script src="<?php echo base_url();?>mentori_assets/js/appear.js"></script>
        <script src="<?php echo base_url()."assets/" ?>js/bootstrapValidator.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>
        <script>

            var check_email_path = base_url+"user/check_email";
            $('#feedback').bootstrapValidator({
                fields: {

                 name: {                 
                    validators: {
                        notEmpty: {
                            message: 'Enter your name'
                        },
                        regexp: {
                            regexp: /^[a-z\s]+$/i,
                            message: 'Your name can consist of alphabetical characters and spaces only'
                        }
                    }
                },  
                email: {
                    validators: {
                     notEmpty: {
                        message: 'Enter valid email address'
                    },
                    regexp: {
                      regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                      message: 'Enter valid email address'
                  }             
              }
          },
          message: {
            validators: {
                notEmpty: {
                    message: 'Enter message '
                }           
            }
        }
    }
}) .on('success.form.bv', function(e) {
                                        // Prevent form submission
                                        e.preventDefault();                                        

                                        var url = base_url + "welcome/feedback_mail";
                                        var formData = $('#feedback').serialize();
                                        $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            success:function(response){     
                                                $('#feedback')[0].reset();
                                                swal(
                                                    'Success!',
                                                    'Mail Sent !Thank you for your Feedback.',
                                                    'success'
                                                    )
                            //console.log(response);                                       
                        }
                    });
                                    });


            // Starrr plugin (https://github.com/dobtco/starrr)
            var __slice = [].slice;

            (function ($, window) {
                var Starrr;

                Starrr = (function () {
                    Starrr.prototype.defaults = {
                        rating: void 0,
                        numStars: 5,
                        change: function (e, value) {}
                    };

                    function Starrr($el, options) {
                        var i, _, _ref,
                        _this = this;

                        this.options = $.extend({}, this.defaults, options);
                        this.$el = $el;
                        _ref = this.defaults;
                        for (i in _ref) {
                            _ = _ref[i];
                            if (this.$el.data(i) != null) {
                                this.options[i] = this.$el.data(i);
                            }
                        }
                        this.createStars();
                        this.syncRating();
                        this.$el.on('mouseover.starrr', 'span', function (e) {
                            return _this.syncRating(_this.$el.find('span').index(e.currentTarget) + 1);
                        });
                        this.$el.on('mouseout.starrr', function () {
                            return _this.syncRating();
                        });
                        this.$el.on('click.starrr', 'span', function (e) {
                            return _this.setRating(_this.$el.find('span').index(e.currentTarget) + 1);
                        });
                        this.$el.on('starrr:change', this.options.change);
                    }

                    Starrr.prototype.createStars = function () {
                        var _i, _ref, _results;

                        _results = [];
                        for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
                            _results.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"));
                        }
                        return _results;
                    };

                    Starrr.prototype.setRating = function (rating) {
                        if (this.options.rating === rating) {
                            rating = void 0;
                        }
                        this.options.rating = rating;
                        this.syncRating();
                        return this.$el.trigger('starrr:change', rating);
                    };

                    Starrr.prototype.syncRating = function (rating) {
                        var i, _i, _j, _ref;

                        rating || (rating = this.options.rating);
                        if (rating) {
                            for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
                                this.$el.find('span').eq(i).removeClass('glyphicon-star-empty').addClass('glyphicon-star');
                            }
                        }
                        if (rating && rating < 5) {
                            for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
                                this.$el.find('span').eq(i).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
                            }
                        }
                        if (!rating) {
                            return this.$el.find('span').removeClass('glyphicon-star').addClass('glyphicon-star-empty');
                        }
                    };

                    return Starrr;

                })();
                return $.fn.extend({
                    starrr: function () {
                        var args, option;

                        option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
                        return this.each(function () {
                            var data;

                            data = $(this).data('star-rating');
                            if (!data) {
                                $(this).data('star-rating', (data = new Starrr($(this), option)));
                            }
                            if (typeof option === 'string') {
                                return data[option].apply(data, args);
                            }
                        });
                    }
                });
            })(window.jQuery, window);

            $(function () {
                return $(".starrr").starrr();
            });

            $(document).ready(function () {

                $('#stars').on('starrr:change', function (e, value) {
                    $('#count').html(value);
                });

                $('#stars-existing').on('starrr:change', function (e, value) {
                    $('#count-existing').html(value);
                });
            });
        </script>
        
        <!-- FAQ  -->

        <script>
         var base_url = '<?php echo base_url(); ?>';
         var segment = '<?php echo $this->uri->segment(1); ?>';
     </script>

     <script type="text/javascript">
        $(document).ready(function() {
            $('#mentor_job_from_year,#mentor_job_to_year').bind('keyup keydown keypress', function (evt) {
                return false;
            });
            $('#search_by_subject1').submit(function(){
               var keyword =  $('#subject_keyword').val();
               if(keyword==''){
                  $('.subject_error').html('<font style="color:red;">Please Enter Subject</font>');
                  setTimeout(function() {
                     $('.help-block').html('');
                 }, 3000);
                  return false;
              }

          }); 




          $( "#subject_keyword" ).keyup(function(){
            var  keyword =  $.trim($(this).val());
            if(keyword!=''){
                $.ajax({
                    type: "POST",
                    url: base_url+'welcome/search_by_subject',
                    data: 'keyword='+keyword,
                    success: function(data)
                    {
                                            // console.log(data);
                                            if(data.length){
                                                var obj = jQuery.parseJSON(data);
                                                var names = ''

                                                if(obj.gurus!=null){
                                                    $(obj.gurus).each(function(){
                                                    names +='<a href="'+base_url+'search-mentor/'+this.first_name+'"><b>'
                                                    +this.first_name+' '+this.last_name+
                                                    '</b><br><small>Subject -'+this.subject+'</small>'+
                                                    '<br><small>Course -'+this.course+'</small>'+
                                                    '<br><small>Bio -'+this.mentor_personal_message+'</small>'+
                                                    '</a>';
                                                });

                                                $('.keyword_result').css('display','block');
                                                $('.keyword_result').html(names);    
                                             }else{
                                                $('.keyword_result').css('display','block');
                                                $('.keyword_result').html('<b>No Mentor found.</b>');
                                             }
                                                

                                            }else{
                                                 $('.keyword_result').css('display','block');
                                                $('.keyword_result').html('<b>No Mentor found.</b>');
                                                //$('.keyword_result').css('display','none');
                                            }

                                        }
                                    });
            }else{
             $('.keyword_result').html('');
             $('.keyword_result').css('display','none');
         }
     });
     

      });
  </script>
  <script>
        $('[data-toggle="slide-collapse"]').on('click', function() {
          $navMenuCont = $($(this).data('target'));
          $navMenuCont.animate({
            'width': 'toggle'
          }, 350);
          $(".menu-overlay").fadeIn(500);

        });
        $(".menu-overlay").click(function(event) {
          $(".navbar-toggle").trigger("click");
          $(".menu-overlay").fadeOut(500);
        });
  </script>
  <script>
         $(".carousel").on("touchstart", function(event){
       var xClick = event.originalEvent.touches[0].pageX;
   $(this).one("touchmove", function(event){
       var xMove = event.originalEvent.touches[0].pageX;
       if( Math.floor(xClick - xMove) > 5 ){
           $(".carousel").carousel('next');
       }
       else if( Math.floor(xClick - xMove) < -5 ){
           $(".carousel").carousel('prev');
       }
   });
   $(".carousel").on("touchend", function(){
           $(this).off("touchmove");
   });
});
  </script>
  <script type="text/javascript">
      $('document').ready(function () {
      var Closed = false;

      $('.hamburger').click(function () {
        if (Closed == true) {
          $(this).removeClass('open');
          $(this).addClass('closed');
          Closed = false;
        } else {               
          $(this).removeClass('closed');
          $(this).addClass('open');
          Closed = true;
        }
      });
});
  </script>
  <script>

(function ($) {
  "use strict";

  $.fn.placeholderTypewriter = function (options) {

    // Plugin Settings
    var settings = $.extend({
      delay: 70,
      pause: 1000,
      text: []
    }, options);

    // Type given string in placeholder
    function typeString($target, index, cursorPosition, callback) {

      // Get text
      var text = settings.text[index];

      // Get placeholder, type next character
      var placeholder = $target.attr('placeholder');
      $target.attr('placeholder', placeholder + text[cursorPosition]);

      // Type next character
      if (cursorPosition < text.length - 1) {
        setTimeout(function () {
          typeString($target, index, cursorPosition + 1, callback);
        }, settings.delay);
        return true;
      }

      // Callback if animation is finished
      callback();
    }

    // Delete string in placeholder
    function deleteString($target, callback) {

      // Get placeholder
      var placeholder = $target.attr('placeholder');
      var length = placeholder.length;

      // Delete last character
      $target.attr('placeholder', placeholder.substr(0, length - 1));

      // Delete next character
      if (length > 1) {
        setTimeout(function () {
          deleteString($target, callback)
        }, settings.delay);
        return true;
      }

      // Callback if animation is finished
      callback();
    }

    // Loop typing animation
    function loopTyping($target, index) {

      // Clear Placeholder
      $target.attr('placeholder', '');

      // Type string
      typeString($target, index, 0, function () {

        // Pause before deleting string
        setTimeout(function () {

          // Delete string
          deleteString($target, function () {
            // Start loop over
            loopTyping($target, (index + 1) % settings.text.length)
          })

        }, settings.pause);
      })

    }

    // Run placeholderTypewriter on every given field
    return this.each(function () {

      loopTyping($(this), 0);
    });

  };

}(jQuery));
  </script>
  <script>
   $(document).ready(function () {
      $('.icon-scroll').click(function() {
        $('html, body').animate({
            scrollTop: $(".introrow").offset().top
        }, 1000);
   });
  });
</script>
<script>

  $('#subject_keyword').placeholderTypewriter({text: ["Search by course or mentor...."]});

</script>
</body>
</html>
