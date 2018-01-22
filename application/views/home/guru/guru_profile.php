<div class="profile-view-top">
    <div class="row">
        <div class="col-sm-9 col-xs-12">
            <div class="profile-section">
                <div class="profile-top">
                    <div class="row">
                        <div class="col-md-3 col-sm-5 col-xs-12">
                            <div class="img-box">
                             <?php $currentuser = get_userdata(); 
								$profile_img = '';
                              if(isset($currentuser['profile_img'])&&!empty($currentuser['profile_img']))
                              {
                                $profile_img = $currentuser['profile_img'];
                            }  
                            $social_profile_img = '';
                            if(isset($currentuser['picture_url'])&&!empty($currentuser['picture_url']))
                            {
                                $social_profile_img = $currentuser['picture_url'];
                            }  
                            $img1 = '';
                            if($social_profile_img != '')
                            {
                                $img1 = $social_profile_img;
                            }
                            if($profile_img != '')
                            {
                                $file_to_check = FCPATH . '/assets/images/' . $profile_img;
                                if (file_exists($file_to_check)) {
                                    $img1 = base_url() . 'assets/images/'.$profile_img;
                                }
                            }
                            $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
                            ?>
								<a href="#" title="<?php echo $gurus['first_name']." ".$gurus['last_name']; ?>">									<img alt="<?php echo $gurus['first_name']." ".$gurus['last_name']; ?>" class="img-responsive img-circle" src="<?php echo $img; ?>">								</a>
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
		<div class="col-sm-3 col-xs-12">
			<div class="edit-btn text-right">
				<a href="<?php echo base_url();?>user/dashboard?notify=true" class="btn btn-default" title="Edit Profile"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</a>
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
<!-- New  -->
  <?php
    $count = 0;
    $total = 22;
    $first_name = '';
    if (isset($result['first_name']) && !empty($result['first_name'])) {
      $first_name = ucfirst($result['first_name']);
      $count++;
    }
    $last_name = '';
    if (isset($result['last_name']) && !empty($result['last_name'])) {
      $last_name = $result['last_name'];
      $count++;
    }
    $user_name = '';
    if(isset($result['username'])&&!empty($result['username']))
    {
      $user_name = $result['username'];
      $count++ ;
    }
    ?>
      <?php
      $email = '';
      if (isset($result['email']) && !empty($result['email'])) {
        $email = $result['email'];
        $count++;
      }
      $profile_img = '';
      if(isset($result['profile_img'])&&!empty($result['profile_img']))
      {
        $profile_img = $result['profile_img'];
      }  
      $social_profile_img = '';
      if(isset($result['picture_url'])&&!empty($result['picture_url']))
      {
       $social_profile_img = $result['picture_url'];
     }  
     $img1 = '';          
     if($social_profile_img != '')
     {
      $img1 = $social_profile_img;
    }
    if($profile_img != '')
    {
      $file_to_check = FCPATH . '/assets/images/' . $profile_img;
      if (file_exists($file_to_check)) {
        $img1 = base_url() . 'assets/images/'.$profile_img;
      }
    }
    if(!empty($img1)){
      $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
       $count++ ;
    }else{
      $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';  
    }
    $applicant_phone = '';
    if (isset($result['applicant_phone']) && !empty($result['applicant_phone'])) {
      $applicant_phone = $result['applicant_phone'];
      $count++;
    }
    $applicant_personal_mess = '';
    if (isset($result['applicant_personal_mess']) && !empty($result['applicant_personal_mess'])) {
      $applicant_personal_mess = $result['applicant_personal_mess'];
      $count++;
    }
    $applicant_school_apply = '';
    if (isset($result['applicant_school_apply']) && !empty($result['applicant_school_apply'])) {
      $applicant_school_apply = $result['applicant_school_apply'];
      $count++;
    }
    $applicant_out_of_conversation = '';
    if (isset($result['applicant_out_of_conversation']) && !empty($result['applicant_out_of_conversation'])) {
      $applicant_out_of_conversation = $result['applicant_out_of_conversation'];
      $count++;
    }
    $applicant_extracurricular = '';
    if (isset($result['applicant_extracurricular']) && !empty($result['applicant_extracurricular'])) {
      $applicant_extracurricular = $result['applicant_extracurricular'];
      $count++;
    }
    $applicant_hs = '';
    if (isset($result['applicant_hs']) && !empty($result['applicant_hs'])) {
      $applicant_hs = $result['applicant_hs'];
      $count++;
    }
    $applicant_from = '';
    if (isset($result['applicant_from']) && !empty($result['applicant_from'])) {
      $applicant_from = $result['applicant_from'];
      $count++;
    }
    $applicant_live_and_work = '';
    if (isset($result['applicant_live_and_work']) && !empty($result['applicant_live_and_work'])) {
      $applicant_live_and_work = $result['applicant_live_and_work'];
      $count++;
    }
    $applicant_language_speak = '';
    if (isset($result['applicant_language_speak']) && !empty($result['applicant_language_speak'])) {
      $applicant_language_speak = $result['applicant_language_speak'];
      $count++;
    }
    $applicant_favourites = '';
    if (isset($result['applicant_favourites']) && !empty($result['applicant_favourites'])) {
      $applicant_favourites = $result['applicant_favourites'];
      $count++;
    }
    $applicant_hobbies = '';
    if (isset($result['applicant_hobbies']) && !empty($result['applicant_hobbies'])) {
      $applicant_hobbies = $result['applicant_hobbies'];
      $count++;
    }
    $applicant_quotes = '';
    if (isset($result['applicant_quotes']) && !empty($result['applicant_quotes'])) {
      $applicant_quotes = $result['applicant_quotes'];
      $count++;
    }
    $address_line1 = '';
    if(isset($result['address_line1'])&&!empty($result['address_line1']))
    {
      $address_line1 = $result['address_line1'];
      $count++ ;
    } 
    $address_line2 = '';
    if(isset($result['address_line2'])&&!empty($result['address_line2']))
    {
      $address_line2 = $result['address_line2'];
      $count++ ;
    } 
    $city = '';
    if(isset($result['city'])&&!empty($result['city']))
    {
      $city = $result['city'];
      $count++ ;
    } 
    $country = '';
    if(isset($result['country'])&&!empty($result['country']))
    {
      $country = $result['country'];
      $count++ ;
    } 
    $postal_code = '';
    if(isset($result['postal_code'])&&!empty($result['postal_code']))
    {
      $postal_code = $result['postal_code'];
      $count++ ;
    }
    ?>
    <div class="progress-bar progress-bar-success progress-bar-striped hidden" role="progressbar" aria-valuenow="<?php echo $progress_value; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $count; ?>%"> <?php echo $count; ?>% Complete </div>
  </div>
