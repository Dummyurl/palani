<div class="profile-view-top">
        <div class="row">
                <div class="col-sm-9 col-xs-9">
                        <div class="profile-section">
                                <div class="profile-top">
                                        <div class="row">
                                    <div class="col-md-3 col-sm-5 col-xs-12">
                                            <div class="img-box">
                                                    <a href="#" title="<?php echo $gurus['first_name']." ".$gurus['last_name']; ?>"><img alt="<?php echo $gurus['first_name']." ".$gurus['last_name']; ?>" class="img-responsive img-circle" src="<?php echo ($gurus['profile_img'] != '') ? base_url() . 'assets/images/'.$gurus['profile_img'] : base_url() . 'assets/images/default-avatar.png'; ?>"></a>
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
                                                        if($country != '') {
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

                                                <div class="user-name"><a><?php echo $gurus['first_name']." ".$gurus['last_name']; ?></a></div>
                                                    <h4 class="user-title"><?php echo ($gurus['mentor_personal_message']) ? $gurus['mentor_personal_message'] : 'N/A'; ?></h4>
                                                    <div class="user-phone"><i class="fa fa-user"></i> <?php echo ($gurus['username'] !='') ? $gurus['username'] : 'N/A'; ?></div>
        <div class="user-phone"><i class="fa fa-phone"></i> <?php echo ($gurus['mentor_phone']) ? $gurus['mentor_phone'] : 'N/A'; ?></div>
                                                    <div class="user-mail"><i class="fa fa-envelope"></i> <a href="mailto:<?php echo $gurus['email']; ?>"><?php echo ($gurus['email']) ? $gurus['email'] : 'N/A'; ?></a></div>
                                                    <div class="user-education"><i class="fa fa-graduation-cap"></i> <?php echo $mentor_year; ?></div>
        <div class="user-education"><i class="fa fa-map-marker"></i> <?php echo $addr; ?></div>
                                            </div>
                                           </div>
                                        </div>
                                </div>
                        </div>
                </div>
                <div class="col-sm-3 col-xs-3">
                        <div class="edit-btn text-right">
                                <a href="<?php echo base_url();?>user/profile_edit" class="btn btn-default" title="Edit Profile"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</a>
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
                
        </div>
        <div class="row">
                <div class="col-sm-12 m-t-20 m-b-30">
                        <h4>What jobs did you hold between undergrad and B-school?</h4>
                        <h5 class="dsgnation"><?php echo ($gurus['mentor_job_title']) ? $gurus['mentor_job_title'] : 'N/A' ; ?><br/>
                                <?php echo $gurus['mentor_job_company']; ?><br/>
                                <?php echo $gurus['mentor_job_dept']; ?><br/>
                                From <?php echo date("F", mktime(0, 0, 0, $gurus['mentor_job_from_month'], 10)); ?> <?php echo $gurus['mentor_job_from_year']; ?> 
                                to <?php echo date("F", mktime(0, 0, 0, $gurus['mentor_job_to_month'], 10)); ?> <?php echo $gurus['mentor_job_to_year']; ?><br/>
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
