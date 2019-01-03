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
                <title>Mentori.ng</title>
                <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.png">
                <link href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" rel="stylesheet">
                <link href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" rel="stylesheet">
                <link href="<?php echo base_url()."assets/" ?>css/cardeffect.css" rel="stylesheet">
                <link href="<?php echo base_url()."assets/" ?>css/style.css" rel="stylesheet">
                 <link href="<?php echo base_url();?>mentori_assets/css/style.css" rel="stylesheet">
                <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrapValidator.css" type="text/css">
        </head>
         <body class="search-page">
           
              <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-4"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>mentori_assets/img/logo.png" alt="Mentori.ng"></a></div>
                <div class="col-xs-8 mainnav">
                    <ul>
                        <li><a href="<?php echo base_url()."signup_mentor"; ?>">Become a Mentor</a></li>
                        <li><a href="<?php echo base_url()."signup_mentee"; ?>">Become a Mentee</a></li>
                        <!-- <li><a href="#feedback">Feedback</a></li> -->
                        <li><a href="<?php echo base_url()."login" ?>">Login</a></li>
                        <li><a href="<?php echo base_url()."signup" ?>">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>  
<section class="mainarea ">
 <div class="container">
    <?php } ?>
    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <div class="profile-section">
                <div class="profile-top">
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
                        <div class="col-md-3 col-sm-5 col-xs-12">
                            <div class="img-box">                           <img alt="" class="img-responsive img-circle" src="<?php echo $img; ?>" height="165" width="165">
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-7 col-xs-12">
                            <div class="user-details">
                                <?php $city = ($gurus['city'] != '') ? $gurus['city'] : ""; ?>
                                <?php $countryname = ($gurus['country'] != '') ? $gurus['country'] : ""; ?>
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
                                <div class="user-name"><a><?php echo $gurus['first_name']." ".$gurus['last_name'];  ?></a></div>
                                <h4 class="user-title"><a><?php echo $gurus['mentor_personal_message'] ?></a></h4>
                                <div class="subject">Courses : 

                                    <?php 
                                    $where  = array('mentor_id'=>$gurus['mentor_id']);
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
                                    echo $course;
                                    ?>
                                </div> 
                                
                                <div class="user-address"><i class="fa fa-map-marker"></i><?php echo $addr; ?></div>
                                <div class="ratings">
                                    <?php for($i=1; $i<=5 ;$i++) {
                                        if($i <= $gurus['rating_value']){
                                            ?>
                                            <i class="fa fa-star" style="color:#ffc513 !important;"></i>
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
                            <h6>Gender</h6>
                            <h5><?php 
                            if($gurus['mentor_gender']==1){echo  'Male';}
                            elseif($gurus['mentor_gender']==2){echo  'Female';}
                            else{ echo 'N/A' ; } 
                            ?></h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h6>Date of birth</h6>
                            <h5><?php echo ($gurus['dob']!='1970-01-01' && $gurus['dob']!='0000-00-00' && !empty($gurus['dob'])) ? date('d-m-Y',strtotime($gurus['dob'])) : 'N/A'; ?></h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h6>Where did you hear about us??</h6>
                            <h5><?php echo ($gurus['where_you_heard']) ? $gurus['where_you_heard'] : 'N/A'; ?></h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 m-t-0 m-b-50">
                            <h4>Charging:
                                <?php
                                if($gurus['charge_type'] == 'charge' && !empty($gurus['hourly_rate'])){
                                    echo '$'.$gurus['hourly_rate'];
                                }elseif($gurus['charge_type'] == 'free'){
                                    echo 'Free';
                                }else{
                                    echo 'N/A';
                                }
                                ?>
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 m-t-0 m-b-50">
                            <h4>Qualifications</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-6 col-sm-12 col-xs-12">
                            <h6>Undergraduate college</h6>
                            <h5><?php echo ($gurus['under_college'] != '') ? $gurus['under_college'] : 'N/A'; ?></h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h6>Undergraduate major</h6>
                            <h5><?php echo ($gurus['under_major'] != '') ? $gurus['under_major'] : 'N/A'; ?></h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h6>Graduate college1?</h6>
                            <h5><?php echo ($gurus['graduate_college'] != '') ? $gurus['graduate_college'] : 'N/A'; ?></h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h6>Type of degree </h6>
                            <h5><?php echo ($gurus['degree'] != '') ? $gurus['degree'] : 'N/A'; ?></h5>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 m-t-0 m-b-50">
                                <h4>Contact Details</h4>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h6>Address 1</h6>
                            <h5><?php echo ($gurus['address_line1'] != '') ? $gurus['address_line1'] : 'N/A'; ?></h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h6>Address 2</h6>
                            <h5><?php echo ($gurus['address_line2'] != '') ? $gurus['address_line2'] : 'N/A'; ?></h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h6>City</h6>
                            <h5><?php echo ($gurus['city'] != '') ? $gurus['city'] : 'N/A'; ?></h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h6>State</h6>
                            <h5><?php echo ($gurus['state'] != '') ? $gurus['state'] : 'N/A'; ?></h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h6>Country</h6>
                            <h5><?php echo ($gurus['country'] != '') ? $gurus['country'] : 'N/A'; ?></h5>
                        </div>



                    </div>  
                </div>      
            </div>
        </div>

        <div class="col-sm-4 col-xs-12">
            <div class="rightsidebar">
                <div class="widget guru-details-widget">
                    <?php 
                    if($gurus['charge_type'] == 'charge' && !empty($gurus['hourly_rate'])){ ?>
                        <div class="price text-center"><sup class="currency">$</sup> <span class="amount"><?php echo ($gurus['hourly_rate']!= '') ? $gurus['hourly_rate'] : '0.00'; ?></span>/hour</div>

                    <?php }elseif($gurus['charge_type'] == 'free'){
                        echo '<div class="price text-center">
                        <button class="btn btn-default ">FREE</button></h1>
                        </div>';
                    }
                    if($gurus['charge_type'] == 'charge' && !empty($gurus['hourly_rate']) || $gurus['charge_type'] == 'free'){ ?>                       
                        <div class="contact-btn text-center">
                            <button class="btn btn-primary" onclick="<?php if($gurus['charge_type'] == 'charge' || $gurus['charge_type'] == 'free'){ ?>window.location='<?php echo base_url(); ?>user/schedule_mentor/<?php echo $gurus['app_id']; ?>';<?php }else{ ?>showVerifyModal();<?php } ?>" title="Contact <?php echo $gurus['first_name']; ?>"><img src="<?php echo base_url();?>assets/images/contact-icon.png"> Contact <?php echo $gurus['first_name']; ?></button>
                        </div>
                    <?php } ?>
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
                                            <div class="review-author"><span><?php echo $review['first_name'].' '.$review['last_name']; ?></span></div>
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