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
            <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/dist/bootstrapValidator.css" type="text/css">
        </head>
        <body>
            <div>
                <section class="main-section">
                    <div class="inner-main">
                        <div class="bgvideo">
                            <video width="1920" height="700" loop autoplay>
                                <source src="<?php echo base_url()."assets/" ?>images/top_banner.mp4" type="video/mp4">
                                    <source src="<?php echo base_url()."assets/" ?>images/top_banner.ogv" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>

                                <header id="header" class="horz header">
                                    <nav class="navbar navbar-fixed-top bg-transparent" id="main-navbar">
                                        <div class="container">
                                            <div class="navbar-header">
                                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                                                    <span class="sr-only">Toggle navigation</span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                                <a href="#" class="navbar-brand"><img src="<?php echo base_url()."assets/" ?>images/logo-dark.png" alt="logo" /></a>
                                            </div>
                                            <div class="collapse navbar-collapse" id="navbar-collapse">
                                                <ul class="nav navbar-nav navbar-right top-menu">
                                                    <li><a href="<?php echo base_url()."guru"; ?>">Become a School Guru</a></li>
                                                    <li><a href="<?php echo base_url()."user"; ?>">Get help from School Guru</a></li>
                                                    <li><a href="#feedback">Feedback</a></li>
                                                    <li class="login-menu"><a href="<?php echo base_url()."login" ?>">Login</a></li>
                                                    <li class="login-menu"><a href="<?php echo base_url()."signup" ?>">Signup</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </nav>
                                </header>
                                <section class="intro-section ">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="banner-content text-center">
                                                    <h1>Knowledge is power. Practice makes perfect. <br/>Don’t jump into something blindly. Maximize your chances of success.</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="nav nav-tabs search-tabs">
                                                    <li class="<?php echo ($this->session->flashdata('university_error') == '') ? 'active' : ''; ?>">
                                                        <a data-toggle="tab" href="#home" class="subject-link" title="Search by Subject">
                                                            <span class="subject-icon"></span>
                                                            <div>Search by Subject</div>
                                                        </a>
                                                    </li>
                                                    <li class="<?php echo ($this->session->flashdata('university_error') != '') ? 'active' : ''; ?>">
                                                        <a data-toggle="tab" href="#menu1" class="university-link" title="Search by University">
                                                            <span class="university-icon"></span>
                                                            <div>Search by University</div></a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">

                                                        <div id="home" class="tab-pane fade <?php echo ($this->session->flashdata('university_error') == '') ? 'in active' : ''; ?>">
                                                            <div class="searchform">
                                                                <form action="<?php echo base_url(); ?>search-guru" method="post" id="search_by_subject1">
                                                                    <div class="input-group">
                                                                        <input type="text" name="keyword" id="subject_keyword" class="form-control search-input" id="btn-input" autocomplete="off">
                                                                        <span class="input-group-btn">
                                                                            <button type="submit" class="btn btn-primary">Search</button>
                                                                        </span>

                                                                    </div>
                                                                    <span class="help-block subject_error"></span>
                                                                    <?php echo $this->session->flashdata('subject_error'); ?>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div id="menu1" class="tab-pane fade <?php echo ($this->session->flashdata('university_error') != '') ? 'in active' : ''; ?> ">
                                                            <div class="searchform">
                                                                <form action="<?php echo base_url(); ?>search-guru-university" method="post" id="search_by_university1">
                                                                    <div class="input-group">
                                                                        <input type="text" name="keyword" id="keyword" class="form-control search-input" id="btn-input" autocomplete="off">
                                                                        <span class="input-group-btn">
                                                                            <button type="submit" class="btn btn-primary">Search</button>
                                                                        </span>
                                                                    </div>
                                                                 <span class="help-block university_error"></span>
                                                                    <?php echo $this->session->flashdata('university_error'); ?>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                </div>

                            </section>
                            
                            <div class="keyword_result"></div>
                     
                        
                            <section class="work-process">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="section-header">
                                                <h3 class="header-title m-t-0 m-b-30">What the product is & what it does</h3>
                                                <p>
                                                    Information discovery and interview practice platform. Learn about programs first hand from current students who just went through the process. Get inside scoop they don’t tell you in school guides. Get anecdotes about programs and school life. Speak to as many people as you want to compare various view points.
                                                </p>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="pro-img">
                                                        <video width="686" height="385" controls poster="<?php echo base_url()."assets/" ?>images/videoposter.jpg">
                                                            <source src="<?php echo base_url()."assets/" ?>images/School_Guru_Official_Promo.mp4" type="video/mp4">
                                                                <source src="<?php echo base_url()."assets/" ?>images/School_Guru_Official_Promo.ogv" type="video/ogg">
                                                                    Your browser does not support the video tag.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="product-works">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="section-header text-center">
                                                            <h3 class="header-title m-t-0 m-b-30">How does it works?</h3>
                                                            <p class="m-b-30">
                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sollicitudin urna, et tempor eros. <br/>Vivamus vestibulum mauris eu elementum semper. 
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="work-list">
                                                            <div class="media">
                                                                <div class="media-left">
                                                                    <a href="#"><img src="<?php echo base_url()."assets/" ?>images/icon-01.png" alt="" width="80" height="80"></a>
                                                                </div>
                                                                <div class="media-body">
                                                                    <h4 class="work-title">Sign Up</h4>
                                                                    <p>Lorem ipsum dolor sit amet, consectetur ing elit, sed do Consectetur ing elit, sed do eiusmod tempor.</p>
                                                                </div>
                                                            </div>
                                                            <div class="media">
                                                                <div class="media-left">
                                                                    <a href="#"><img src="<?php echo base_url()."assets/" ?>images/icon-02.png" alt="" width="80" height="80"></a>
                                                                </div>
                                                                <div class="media-body">
                                                                    <h4 class="work-title">Offering</h4>
                                                                    <p>Lorem ipsum dolor sit amet, consectetur ing elit, sed do Consectetur ing elit, sed do eiusmod tempor.</p>
                                                                </div>
                                                            </div>
                                                            <div class="media">
                                                                <div class="media-left">
                                                                    <a href="#"><img src="<?php echo base_url()."assets/" ?>images/icon-03.png" alt="" width="80" height="80"></a>
                                                                </div>
                                                                <div class="media-body">
                                                                    <h4 class="work-title">Get Back</h4>
                                                                    <p>Lorem ipsum dolor sit amet, consectetur ing elit, sed do Consectetur ing elit, sed do eiusmod tempor.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="work-img">

                                                            <div data-card="4" class="card"><img src="<?php echo base_url()."assets/" ?>images/webappscreen1.png"></div>
                                                            <div data-card="3" class="card"><img src="<?php echo base_url()."assets/" ?>images/webappscreen2.png"></div>
                                                            <div data-card="2" class="card"><img src="<?php echo base_url()."assets/" ?>images/webappscreen3.png"></div>
                                                            <div data-card="1" class="card"><img src="<?php echo base_url()."assets/" ?>images/webappscreen4.png"></div>
                                                            <div data-card="0" class="card"><img src="<?php echo base_url()."assets/" ?>images/webappscreen5.png"></div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="about-school">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-8 col-md-offset-2">
                                                        <div class="section-header text-center">
                                                            <h3 class="header-title m-t-0 m-b-30">Take a small step to get right thing</h3>
                                                            <p class="m-b-30">
                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor. Incididunt ut labore et dolore magna aliqua.
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12">
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                                <div class="small-step">
                                                                    <a href="<?php echo base_url()."guru"; ?>">
                                                                        <div class="step-left">
                                                                            <div><img src="<?php echo base_url()."assets/" ?>images/img-03.jpg" alt="" width="395" height="250"></div>
                                                                            <div class="step-cont">
                                                                                <div class="step-arrow">
                                                                                    <p><span>Become a</span> <br/><span class="text-link">School Guru</span></p>
                                                                                    <button type="button" class="btn btn-default btn-xs click-btn">Click Here</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                                <div class="small-step">
                                                                    <a href="<?php echo base_url()."user"; ?>">
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
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="feedback" id="feedback">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center">
                                                        <div class="section-header text-center">
                                                            <h3 class="header-title m-t-0 m-b-50">We want your feedback How to make our service better!</h3>
                                                            <span id="feedback-form-success" class="success" style="display: none"></span>
                                                            <span id="feedback-form-error" class="error" style="display: none"></span>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-8 col-md-offset-2">  
                                                                <form id="general_feedback">
                                                                    <div class="form-group">
                                                                        <input type="text" name="feedbacker_name" id="feedbacker_name" class="form-control" placeholder="Enter your name here" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="email" name="feedbacker_email" id="feedbacker_email" class="form-control" placeholder="Enter your email here" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <textarea class="form-control" name="feedbacker_comment" id="feedbacker_comment"  placeholder="Enter your comments here" rows="6" required></textarea>
                                                                    </div>
                                                                    <button class="btn btn-primary feed-btn" type="submit">Submit</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <footer id="footer" class="footer">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <div>
                                                            <ul class="nav-links pull-left">
                                                                <li>
                                                                    <a href="<?php echo base_url()."guru"; ?>">Become a School Guru</a>
                                                                </li>
                                                                <li>
                                                                    <a href="<?php echo base_url()."user"; ?>">Get help from a School Guru</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Feedback</a>
                                                                </li>
                                                                <li>
                                                                    <a href="<?php echo base_url()."login" ?>">Login</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <p class="copyright pull-left">
                                                            &copy; 2017 <a href="#">School Guru</a>. All rights reserved.
                                                        </p>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <ul class="social-icons">
                                                            <li>
                                                                <a href="#"><i class="fa fa-facebook"></i></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><i class="fa fa-twitter"></i></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><i class="fa fa-google-plus"></i></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><i class="fa fa-youtube"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </footer>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-body">
                                            <div class="account-box ">
                                             
                                                <div class="small-step">
                                                    <a href="<?php echo base_url()."login"; ?>">
                                                        <div class="step-left">
                                                            <div><img src="<?php echo base_url()."assets/" ?>images/img-03.jpg" alt="" width="395" height="250"></div>
                                                            <div class="step-cont">
                                                                <div class="step-arrow">
                                                                    <p><span>Become a</span> <br/><span class="text-link">School Guru</span></p>
                                                                    <button type="button" class="btn btn-default btn-xs click-btn">Login</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                
                                                <p>&nbsp;</p>
                                                
                                                <div class="small-step">
                                                    <a href="<?php echo base_url()."login"; ?>">
                                                        <div class="step-right">
                                                            <img src="<?php echo base_url()."assets/" ?>images/img-02.jpg" alt="" width="395" height="250">
                                                            <div class="step-cont">
                                                                <div class="step-arrow">
                                                                    <button type="button" class="btn btn-default btn-xs click-btn">Login</button>
                                                                    <p><span>Get help from a</span> <br/><span class="text-link">School Guru</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <script> var base_url = "<?php echo base_url(); ?>"; </script>
                            <script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js"></script>
                            <script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js"></script>
                                <script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>
                            <script src="<?php echo base_url()."assets/" ?>js/chosen.js"></script>
                            <script src="<?php echo base_url()."assets/" ?>js/dist/bootstrapValidator.js" type="text/javascript"></script>
                            <script src="<?php echo base_url()."assets/" ?>js/guru.js" type="text/javascript"></script>
                            
                            <script>
                                $(document).ready(function() {
                                    "use strict";
                                    $(window).on('scroll', function(){
                                        var b = $(window).scrollTop();
                                        if( b > 60 ){
                                            $(".navbar").addClass("top-nav-collapse");
                                        } else {
                                            $(".navbar").removeClass("top-nav-collapse");
                                        }
                                    });
                                });
                            </script>
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