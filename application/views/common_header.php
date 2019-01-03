<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <title>Mentori.ng</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/images/favicon.png">
  <link href="<?php echo base_url();?>mentori_assets/css/bootstrap.css" rel="stylesheet">
  <link href="<?php echo base_url();?>mentori_assets/css/animate.css" rel="stylesheet">
  <link href="<?php echo base_url();?>mentori_assets/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>mentori_assets/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url()."assets/" ?>css/search.css" rel="stylesheet">
  <link href="<?php echo base_url()."assets/" ?>css/style.css" rel="stylesheet">
  <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
   <script type="text/javascript">
      $('document').ready(function () {

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
</head>
<body>
  <div class="overlay">
    <div id="loading-img"></div>
  </div>
    <header class="header admin-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-3 mob-menu">
                        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>mentori_assets/img/logo_1.png" alt="Mentori.ng" class="img-responsive">
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

                            <li><a href="<?php echo base_url()."signup_mentor"; ?>">Become a Mentor</a></li>
                            <li><a href="<?php echo base_url()."signup_mentee"; ?>">Become a Mentee</a></li>
                            <!-- <li><a href="#feedback">Feedback</a></li> -->
                            <li><a href="<?php echo base_url()."login" ?>">Login</a></li>
                            <li><a href="<?php echo base_url()."signup" ?>">Register</a></li>
                            <?php }else{

                                echo '<li><a href="'.base_url().'dashboard">Dashboard</a></li>
                                      <li><a href="'.base_url().'user/logout">Logout</a></li>';

                            } ?>
                        </ul>
                     </div>
                </div>
            </div>    
        </div>
    </header>


  <section class="mainarea search-mainarea">