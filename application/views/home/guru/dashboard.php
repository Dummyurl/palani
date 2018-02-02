<?php 
$count = 0 ;
$total = 44 ;
$mentor_first_name = '';
if(isset($result['first_name'])&&!empty($result['first_name'])){
  $mentor_first_name = $result['first_name'];
  $count++ ;
}
$mentor_last_name = '';
if(isset($result['last_name'])&&!empty($result['last_name'])){
  $mentor_last_name = $result['last_name'];
  $count++ ;
}
$mentor_user_name = '';
if(isset($result['email'])&&!empty($result['email'])){
  $mentor_user_name = $result['email'];
  $count++ ;
}
$mentor_email = '';
if(isset($result['email'])&&!empty($result['email'])){
  $mentor_email = $result['email'];
  $count++ ;
}  
$profile_img = '';
if(isset($result['profile_img'])&&!empty($result['profile_img'])){
  $profile_img = $result['profile_img'];
}  
$social_profile_img = '';
if(isset($result['picture_url'])&&!empty($result['picture_url'])){
  $social_profile_img = $result['picture_url'];
}  					
$img1 = '';                  
if($social_profile_img != ''){
  $img1 = $social_profile_img;
}
if($profile_img != ''){
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
$mentor_phone = '';
if(isset($result['mentor_phone'])&&!empty($result['mentor_phone'])){
  $mentor_phone = $result['mentor_phone'];
  $count++ ;
}
$mentor_gender = '';
if(isset($result['mentor_gender'])&&!empty($result['mentor_gender'])){
  $mentor_gender = $result['mentor_gender'];
  $count++ ;
}
$mentor_school = '';
if(isset($result['mentor_school'])&&!empty($result['mentor_school'])){
 $mentor_school = $result['mentor_school'];
 $count++ ;
}             
$mentor_current_year = '';
if(isset($result['mentor_current_year'])&&!empty($result['mentor_current_year'])){
  $mentor_current_year = $result['mentor_current_year'];
  $count++ ;
}
$mentor_schools_applied = '';
if(isset($result['mentor_schools_applied'])&&!empty($result['mentor_schools_applied'])){ 
  $mentor_schools_applied = $result['mentor_schools_applied'];
  $count++ ;
}
$mentor_clubs = '';
if(isset($result['mentor_clubs'])&&!empty($result['mentor_clubs'])){
  $mentor_clubs = $result['mentor_clubs'];
  $count++ ;
}
$mentor_charge = '';
if(isset($result['mentor_charge'])&&!empty($result['mentor_charge'])){
  $mentor_charge = $result['mentor_charge'];
  $count++ ;
}
$mentor_executive_positions = '';
if(isset($result['mentor_executive_positions'])&&!empty($result['mentor_executive_positions'])){
  $mentor_executive_positions = $result['mentor_executive_positions'];
  $count++ ;
}                            				
$mentor_undergrad_school = '';
if(isset($result['mentor_undergrad_school'])&&!empty($result['mentor_undergrad_school'])){
  $mentor_undergrad_school = $result['mentor_undergrad_school'];
  $count++ ;
}
$mentor_job_title = '';
if(isset($result['mentor_job_title'])&&!empty($result['mentor_job_title'])){
  $mentor_job_title = $result['mentor_job_title'];
  $count++ ;
}
$mentor_job_company = '';
if(isset($result['mentor_job_company'])&&!empty($result['mentor_job_company'])){
  $mentor_job_company = $result['mentor_job_company'];
  $count++ ;
}
$mentor_job_dept = '';
if(isset($result['mentor_job_dept'])&&!empty($result['mentor_job_dept'])){
  $mentor_job_dept = $result['mentor_job_dept'];
  $count++ ;
}             
$mentor_job_location = '';
if(isset($result['mentor_job_location'])&&!empty($result['mentor_job_location'])){
  $mentor_job_location = $result['mentor_job_location'];
  $count++ ;
}
$mentor_job_desc = '';
if(isset($result['mentor_job_desc'])&&!empty($result['mentor_job_desc'])){
  $mentor_job_desc = $result['mentor_job_desc'];
  $count++ ;
}
$mentor_job_from_month = '';
if(isset($result['mentor_job_from_month'])&&!empty($result['mentor_job_from_month'])){
  $mentor_job_from_month = $result['mentor_job_from_month'];
  $count++ ;
}
$mentor_job_from_year = '';
if(isset($result['mentor_job_from_year'])&&!empty($result['mentor_job_from_year'])){
  $mentor_job_from_year = $result['mentor_job_from_year'];
  $count++ ;
}             
$mentor_job_to_month = '';
if(isset($result['mentor_job_to_month'])&&!empty($result['mentor_job_to_month'])){
  $mentor_job_to_month = $result['mentor_job_to_month'];
  $count++ ;
}                            
$mentor_job_to_year = '';
if(isset($result['mentor_job_to_year'])&&!empty($result['mentor_job_to_year']))
{
  $mentor_job_to_year = $result['mentor_job_to_year'];
  $count++ ;
}
$mentor_about = '';
if(isset($result['mentor_about'])&&!empty($result['mentor_about']))
{
  $mentor_about = $result['mentor_about'];
  $count++ ;
}    
$mentor_personal_message = '';
if(isset($result['mentor_personal_message'])&&!empty($result['mentor_personal_message']))
{
  $mentor_personal_message = $result['mentor_personal_message'];
  $count++ ;
}                       
$mentor_school_accepted = '';
if(isset($result['mentor_school_accepted'])&&!empty($result['mentor_school_accepted']))
{
  $mentor_school_accepted = $result['mentor_school_accepted'];
  $count++ ;
}
$mentor_read_guide = '';
if(isset($result['mentor_read_guide'])&&!empty($result['mentor_read_guide']))
{
  $mentor_read_guide = $result['mentor_read_guide'];
  $count++ ;
}
$mentor_hire_consult = '';
if(isset($result['mentor_hire_consult'])&&!empty($result['mentor_hire_consult']))
{
  $mentor_hire_consult = $result['mentor_hire_consult'];
  $count++ ;
}
$mentor_visit_school = '';
if(isset($result['mentor_visit_school'])&&!empty($result['mentor_visit_school']))
{
  $mentor_visit_school = $result['mentor_visit_school'];
  $count++ ;
}                           
$mentor_tour = '';
if(isset($result['mentor_tour'])&&!empty($result['mentor_tour']))
{
  $mentor_tour = $result['mentor_tour'];
  $count++ ;
}
$mentor_other_extra = '';
if(isset($result['mentor_other_extra'])&&!empty($result['mentor_other_extra']))
{
  $mentor_other_extra = $result['mentor_other_extra'];
  $count++ ;
}
$mentor_extracurricular_activities = '';
if(isset($result['mentor_extracurricular_activities'])&&!empty($result['mentor_extracurricular_activities']))
{
  $mentor_extracurricular_activities = $result['mentor_extracurricular_activities'];
  $count++ ;
}
$mentor_hs = '';
if(isset($result['mentor_hs'])&&!empty($result['mentor_hs']))
{
  $mentor_hs = $result['mentor_hs'];
  $count++ ;
}                            
$mentor_from = '';
if(isset($result['mentor_from'])&&!empty($result['mentor_from']))
{
  $mentor_from = $result['mentor_from'];
  $count++ ;
}
$mentor_live_work = '';
if(isset($result['mentor_live_work'])&&!empty($result['mentor_live_work']))
{
  $mentor_live_work = $result['mentor_live_work'];
  $count++ ;
}                       
$mentor_languages_speak = '';
if(isset($result['mentor_languages_speak'])&&!empty($result['mentor_languages_speak']))
{
  $mentor_languages_speak = $result['mentor_languages_speak'];
  $count++ ;
}
$mentor_favourite = '';
if(isset($result['mentor_favourite'])&&!empty($result['mentor_favourite']))
{
  $mentor_favourite = $result['mentor_favourite'];
  $count++ ;
}
$mentor_hobbies = '';
if(isset($result['mentor_hobbies'])&&!empty($result['mentor_hobbies']))
{
  $mentor_hobbies = $result['mentor_hobbies'];
  $count++ ;
}
$mentor_quotes = '';
if(isset($result['mentor_quotes'])&&!empty($result['mentor_quotes']))
{
  $mentor_quotes = $result['mentor_quotes'];
  $count++ ;
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
$state = '';
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
$progress_value =  number_format((float)($count/$total)*100, 0, '.', '');
?>
<div class="row welcomerow">
	<div class="col-sm-8">
		<h1>Welcome to School Guru, <?php echo ucfirst($mentor_first_name)." ".$mentor_last_name; ?>!</h1>
	</div>
	<div class="col-sm-4">
		<div class="progress">
			<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $progress_value; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $progress_value; ?>%"> <?php echo $progress_value; ?>% Complete </div>
		</div>
	</div>
</div>
<?php 
if(!empty($_GET['notify'])){
  $menu = '<li ><a data-toggle="tab" href="#activity">Activity</a></li>
  <li class="active"><a data-toggle="tab" href="#editprofile">Edit Profile</a></li>
  <li><a data-toggle="tab" href="#timings">Schedule Timings</a></li>
  <li><a data-toggle="tab" href="#account">Account</a></li>';
}
else if(!empty($_GET['account'])){
  $menu = '<li ><a data-toggle="tab" href="#activity">Activity</a></li>
  <li><a data-toggle="tab" href="#editprofile">Edit Profile</a></li>
  <li><a data-toggle="tab" href="#timings">Schedule Timings</a></li>
  <li class="active"><a data-toggle="tab" href="#account">Account</a></li>';
}
else{
  $menu='<li class="active"><a data-toggle="tab" href="#activity">Activity</a></li>
  <li><a data-toggle="tab" href="#editprofile">Edit Profile</a></li>
  <li><a data-toggle="tab" href="#timings">Schedule Timings</a></li>
  <li><a data-toggle="tab" href="#account">Account</a></li>';
}
?>
<div class="subnav">
	<ul class="nav nav-tabs">
		<?php echo $menu; ?>
	</ul>
</div>
<div class="tab-content">
  <!--Edit Profile Tabs Starts Here-->
  <?php if(!empty($_GET['notify'])){
    echo '<div id="editprofile" class="tab-pane fade in active">';
  }else{
    echo '<div id="editprofile" class="tab-pane fade in">';
  }
  ?>
	<div class="row titlerow">
		<div class="col-sm-6">
			<h2>Edit Profile</h2>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
	<?php if($result['profile_updated'] == 1 && $progress_value < 100 ): ?>
    <div class="alert alert-success custom-alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">Got it</a> Your profile has been activated. Please improve your profile with filling other details.</div>
  <?php endif; ?>
  <?php if($result['profile_updated'] == 0): ?>
    <div class="alert alert-danger custom-alert"> <a href="#" class="close" data-dismiss="alert" aria-label="close">Got it</a> <span>*</span> Fill out the required questions below to activate your profile </div>
  <?php endif; ?>
  <?php if($this->session->flashdata('success_message') != '') : ?>
    <div class="alert alert-success custom-alert"> <a href="#" class="close" data-dismiss="alert" aria-label="close">Hide</a> <?php echo $this->session->flashdata('success_message'); ?>. </div>
  <?php endif; ?>
  <div class="row">
    <div class="col-sm-12">
      <div class="profile-box">
        <div class="row">
          <div class="col-md-3">
            <div class="profile-left">
              <div class="profile-img img-container" id="crop-avatar">
                <!-- Cropping modal -->
                <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form class="avatar-form" id="avatar-form" action="<?php echo base_url();?>cropavatar" enctype="multipart/form-data" method="post">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
                        </div>
                        <div class="modal-body">
                          <div class="avatar-body">
                            <!-- Upload image and data -->
                            <div class="avatar-upload">
                              <input type="hidden" class="avatar-src" name="avatar_src">
                              <input type="hidden" class="avatar-data" name="avatar_data">
                              <input type="file" class="avatar-input" id="avatarInput" name="avatar_file" value="">
                            </div>
                            <!-- Crop and preview -->
                            <div class="avatar-wrapper"> <img src="<?php echo $img; ?>" style="width: 100%;margin-left: 0px; margin-top: 0px; transform: none;"> </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                          <button type="submit" class="btn btn-primary avatar-save">Upload</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- /.modal -->
                <!-- Current avatar -->
                <div class="avatar-view" title="Change the avatar"> <img src="<?php echo $img; ?>" class="img-responsive" width="300" height="300" alt="Avatar"> </div>
                <!-- Loading state -->
                <!--                                        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>-->
              </div>
              <div class="change-picture" > <a href="#" class="btn btn-default btn-block" data-toggle="modal" data-target="#avatar-modal"><i class="fa fa-pencil" aria-hidden="true"></i> Change Picture</a> </div>
              <div class="profile-preview"> <a href="<?php echo base_url(); ?>user/profile/<?php echo $this->session->userdata('applicant_id'); ?>" class="btn btn-success btn-block">Preview Profile</a> </div>
            </div>
          </div>
          <div class="col-md-9">
            <form id="mentor_profile_form" method="post" novalidate>
              <div class="profile-right">
                <div class="education-details">
                  <h4>Build your profile</h4>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Username <span>*</span></label>
                        <input type="text" class="form-control" name="username" id="username" value="<?php echo $mentor_user_name; ?>" required readonly>
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Email <span>*</span></label>
                        <input type="text" class="form-control" name="email" id="email" value="<?php echo $mentor_email; ?>" required readonly>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">First Name <span>*</span></label>
                        <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $mentor_first_name; ?>" required>
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Last Name <span>*</span></label>
                        <input type="text" class="form-control" name="last_name" id="last_name" value="<?php  echo $mentor_last_name; ?>" required>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Phone Number <span>*</span></label>
                        <input type="text" class="form-control" name="mentor_phone" id="mentor_phone" value="<?php echo $mentor_phone; ?>" required >
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Gender <span>*</span></label>
                        <select class="form-control" name="mentor_gender" id="mentor_gender" required>
                          <option value="">Please Select</option>
                          <option value="1" <?php if($mentor_gender==1){ echo "selected";} ?> >Male</option>
                          <option value="2" <?php if($mentor_gender==2){ echo "selected";} ?> >Female</option>
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">What school are you in now? <span>*</span></label>
                        <input type="text" class="form-control" name="mentor_school" id="mentor_school" value="<?php echo $mentor_school; ?>"  required>
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">What year are you in? <span>*</span></label>
                        <select class="form-control" name="mentor_current_year" id="mentor_current_year" required>
                          <option value="">Current Pursuing Year </option>
                          <option value="1" <?php if($mentor_current_year==1){ echo "selected";} ?> >First Year</option>
                          <option value="2" <?php if($mentor_current_year==2){ echo "selected";} ?> >Second Year</option>
                          <option value="3" <?php if($mentor_current_year==3){ echo "selected";} ?> >Third Year</option>
                          <option value="4" <?php if($mentor_current_year==4){ echo "selected";} ?> >Fourth Year</option>
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">What schools did you apply to? <span>*</span></label>
                        <input type="text" class="form-control" name="mentor_schools_applied" id="mentor_schools_applied" value="<?php echo $mentor_schools_applied; ?>" required>
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">What clubs are you part of? <span>*</span></label>
                        <input type="text" class="form-control" name="mentor_clubs" id="mentor_clubs" value="<?php echo $mentor_clubs; ?>" required>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">What was your undergrad school? <span>*</span></label>
                        <input type="text" class="form-control" name="mentor_undergrad_school" id="mentor_undergrad_school" value="<?php echo $mentor_undergrad_school; ?>" required >
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">What executive positions in clubs do you hold at your school? <span>*</span></label>
                        <input type="text" class="form-control" name="mentor_executive_positions" id="mentor_executive_positions" value="<?php echo $mentor_executive_positions; ?>" required>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="education-details">
                  <h4>Charging</h4>
                  <div class="row">
                    <div class="col-sm-6 form-inline">
                      <div class="form-group">
                        <label class="control-label">Charge (per hour in dollar) <span>*</span></label>
                        <input type="text" class="form-control" name="mentor_charge" id="mentor_charge" value="<?php echo $mentor_charge; ?>" required min="1">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6"></div>
                  </div>
                </div>
                <div class="education-details">
                  <h4>What jobs did you hold between undergrad and B-school?</h4>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Title</label>
                        <input type="text" class="form-control" name="mentor_job_title" id="mentor_job_title" value="<?php echo $mentor_job_title; ?>" >
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Company Name</label>
                        <input type="text" class="form-control" name="mentor_job_company" id="mentor_job_company" value="<?php echo $mentor_job_company; 
                        ?>" >
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Department</label>
                        <input type="text" class="form-control" name="mentor_job_dept" id="mentor_job_dept" value="<?php echo $mentor_job_dept; ?>" >
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Location</label>
                        <input type="text" class="form-control" name="mentor_job_location" id="mentor_job_location" value="<?php echo $mentor_job_location; ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Description</label>
                        <textarea class="form-control" rows="3" name="mentor_job_desc" id="mentor_job_desc" ><?php echo $mentor_job_desc; ?></textarea>
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6"> From
                      <div class="row">
                        <div class="col-xs-6">
                          <div class="form-group">
                            <select class="form-control" name="mentor_job_from_month" id="mentor_job_from_month">
                              <option value="">Month</option>
                              <option value="1" <?php if($mentor_job_from_month==1){ echo "selected";} ?> >January</option>
                              <option value="2" <?php if($mentor_job_from_month==2){ echo "selected";} ?> >February</option>
                              <option value="3" <?php if($mentor_job_from_month==3){ echo "selected";} ?> >March</option>
                              <option value="4" <?php if($mentor_job_from_month==4){ echo "selected";} ?> >April</option>
                              <option value="5" <?php if($mentor_job_from_month==5){ echo "selected";} ?> >May</option>
                              <option value="6" <?php if($mentor_job_from_month==6){ echo "selected";} ?> >June</option>
                              <option value="7" <?php if($mentor_job_from_month==7){ echo "selected";} ?> >July</option>
                              <option value="8" <?php if($mentor_job_from_month==8){ echo "selected";} ?> >August</option>
                              <option value="9" <?php if($mentor_job_from_month==9){ echo "selected";} ?> >September</option>
                              <option value="10" <?php if($mentor_job_from_month==10){ echo "selected";} ?> >October</option>
                              <option value="11" <?php if($mentor_job_from_month==11){ echo "selected";} ?> >November</option>
                              <option value="12" <?php if($mentor_job_from_month==12){ echo "selected";} ?> >December</option>
                            </select>
                            <span class="help-block"></span>
                          </div>
                        </div>
                        <div class="col-xs-6">
                          <div class="form-group">
                            <input type="text" name="mentor_job_from_year" class="form-control" id="mentor_job_from_year" value="<?php echo $result['mentor_job_from_year']; ?>">
                            <span class="help-block"></span>
                           <!-- <select class="form-control from_year" name="mentor_job_from_year" id="mentor_job_from_year" >
                              <option value="">Year</option>
                              <?php
                              $year = date("Y"); 
                              for($i=0;$i<10;$i++)
                              {
                                $selected = '';
                                if($mentor_job_from_year==($year-$i))
                                {
                                  $selected = 'selected';
                                }
                                echo "<option value='".($year-$i)."' ".$selected.">".($year-$i)."</option>";                                                                                
                              }
                              ?>
                            </select> -->
                          </div>
                        </div>
                      </div>
                      To
                      <div class="row">
                        <div class="col-xs-6">
                          <div class="form-group">
                            <select class="form-control" name="mentor_job_to_month" id="mentor_job_to_month">
                              <option value="">Month</option>
                              <option value="1" <?php if($mentor_job_to_month==1){ echo "selected";} ?> >January</option>
                              <option value="2" <?php if($mentor_job_to_month==2){ echo "selected";} ?> >February</option>
                              <option value="3" <?php if($mentor_job_to_month==3){ echo "selected";} ?> >March</option>
                              <option value="4" <?php if($mentor_job_to_month==4){ echo "selected";} ?> >April</option>
                              <option value="5" <?php if($mentor_job_to_month==5){ echo "selected";} ?> >May</option>
                              <option value="6" <?php if($mentor_job_to_month==6){ echo "selected";} ?> >June</option>
                              <option value="7" <?php if($mentor_job_to_month==7){ echo "selected";} ?> >July</option>
                              <option value="8" <?php if($mentor_job_to_month==8){ echo "selected";} ?> >August</option>
                              <option value="9" <?php if($mentor_job_to_month==9){ echo "selected";} ?> >September</option>
                              <option value="10" <?php if($mentor_job_to_month==10){ echo "selected";} ?> >October</option>
                              <option value="11" <?php if($mentor_job_to_month==11){ echo "selected";} ?> >November</option>
                              <option value="12" <?php if($mentor_job_to_month==12){ echo "selected";} ?> >December</option>
                            </select>
                            <span class="help-block"></span>
                          </div>
                        </div>
                        <div class="col-xs-6">
                          <div class="form-group">
                            <input type="text" name="mentor_job_to_year" class="form-control" id="mentor_job_to_year" value="<?php echo $result['mentor_job_to_year'] ?>" >
                            <span class="help-block"></span>
                          <!--   <select class="form-control" name="mentor_job_to_year" id="mentor_job_to_year">
                              <option value="">Year</option>
                              <?php
                              $year = date("Y"); 
                              for($i=0;$i<10;$i++)
                              {
                                $selected = '';
                                if($mentor_job_to_year==($year-$i))
                                {
                                  $selected = 'selected';
                                }
                                echo "<option value='".($year-$i)."' ".$selected.">".($year-$i)."</option>";                                                                                
                              }
                              ?>
                            </select> -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="bank-details">
                  <h4>More Details</h4>
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="form-group">
                        <label class="control-label">About Yourself</label>
                        <textarea class="form-control" name="mentor_about" id="mentor_about" rows="3"><?php echo $mentor_about; ?></textarea>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">A personal statement</label>
                        <input type="text" class="form-control" name="mentor_personal_message" id="mentor_personal_message" value="<?php echo $mentor_personal_message; ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">What schools did you get accepted to?</label>
                        <input type="text" class="form-control" name="mentor_school_accepted" id="mentor_school_accepted" value="<?php echo $mentor_school_accepted; ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <h5>How much research did you do for each school?</h5>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Did you read the guides, which ones?</label>
                        <input type="text" class="form-control" name="mentor_read_guide" id="mentor_read_guide" value="<?php echo $mentor_read_guide; ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Did you hire a consultant?</label>
                        <input type="text" class="form-control" name="mentor_hire_consult" id="mentor_hire_consult" value="<?php echo $mentor_hire_consult; ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Did you visit schools applied to?</label>
                        <input type="text" class="form-control" name="mentor_visit_school" id="mentor_visit_school" value="<?php echo $mentor_visit_school; ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Did you take tours?</label>
                        <input type="text" class="form-control" name="mentor_tour" id="mentor_tour" value="<?php echo $mentor_tour; ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Other?</label>
                        <input type="text" class="form-control" name="mentor_other_extra" id="mentor_other_extra" value="<?php echo $mentor_other_extra; 
                        ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6"></div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="form-group">
                        <label class="control-label">What other extracurricular activities are you involved in? Were involved in undergrad?</label>
                        <textarea class="form-control" rows="3" name="mentor_extracurricular_activities" id="mentor_extracurricular_activities"><?php echo $mentor_extracurricular_activities; ?></textarea>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">What HS did you go to?</label>
                        <input type="text" class="form-control" name="mentor_hs" id="mentor_hs" value="<?php echo $mentor_hs; ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Where are you from?</label>
                        <input type="text" class="form-control" name="mentor_from" id="mentor_from" value="<?php echo $mentor_from; ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">What countries did you live and work in?</label>
                        <input type="text" class="form-control" name="mentor_live_work" id="mentor_live_work" value="<?php echo $mentor_live_work; ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">What languages do you speak?</label>
                        <input type="text" class="form-control" name="mentor_languages_speak" id="mentor_languages_speak" value="<?php echo $mentor_languages_speak; ?>" >
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="form-group">
                        <label class="control-label">You Favorite Book, Movie, Business Book, Business Publication, Business Leader, Personal Role Model</label>
                        <textarea class="form-control" rows="3" name="mentor_favourite" id="mentor_favourite"><?php echo $mentor_favourite; ?></textarea>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Hobbies</label>
                        <input type="text" class="form-control" name="mentor_hobbies" id="mentor_hobbies" value="<?php echo $mentor_hobbies; ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Quotes</label>
                        <input type="text" class="form-control" name="mentor_quotes" id="mentor_quotes" value="<?php echo $mentor_quotes; ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="bank-details">
                  <h4>Contact Details</h4>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Address Line 1<span> *</span></label>
                        <input type="text" class="form-control" name="address_line1" value="<?php echo $address_line1; ?>" required>
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Address Line 2</label>
                        <input type="text" class="form-control" name="address_line2" value="<?php echo $address_line2; ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>                 

                  <div class="row">                     
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Country<span> *</span></label>                        
                        <input type="text" name="country" class="form-control" id="country" value="<?php echo $country; ?>">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">State 
                          <span> *</span></label>
                        <input type="text" name="state" class="form-control" id="state" value="<?php echo $result['state']; ?>">                        
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                   <div class="col-sm-6">
                    <div class="form-group">
                      <label class="control-label">City<span> *</span></label>
                      <input type="text" class="form-control" name="city" id="city" value="<?php echo $city; ?>" required>                      
                      <span class="help-block"></span>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Postal Code<span> *</span></label>
                      <input type="text" class="form-control" name="postal_code" id="postal_code" value="<?php echo $postal_code; ?>" required>
                      <span class="help-block"></span>
                    </div>
                  </div>
                  <div class="col-sm-6"></div>
                </div>
              </div>
              <div class="submit-btn">
                <button type="submit" class="btn btn-primary">Save Profile</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!--Edit Profile Tabs Ends Here-->
<!--Activity Tabs Starts Here-->
<?php
if(empty($_GET['notify']) && empty($_GET['account'])){
  echo '<div id="activity" class="tab-pane fade in active">';
}else{
  echo '<div id="activity" class="tab-pane fade">';
}
?>
<div class="row titlerow">
  <div class="col-sm-5">
    <h2>Activity History</h2>
  </div>
  <div class="col-sm-7 text-right">
    <form class="titlerightsearch">
      <input type="search"  id="activity_search" placeholder="Search">
    </form>
  </div>
</div>
<div class="jlist">
  <?php if(!empty($activity_list)): 


  function converToTz($time="",$toTz='',$fromTz='')

  {           

    $date = new DateTime($time, new DateTimeZone($fromTz));

    $date->setTimezone(new DateTimeZone($toTz));

    $time= $date->format('Y-m-d H:i:s');

    return $time;

  }



  ?>
  <?php foreach($activity_list as $activity): ?>
    <?php 

    $img1 = '';

    if($activity['picture_url'] != '')

    {

      $img1 = $activity['picture_url'];



    }

    if($activity['profile_img'] != '')

    {

      $file_check = FCPATH . '/assets/images/' . $activity['profile_img'];

      if (file_exists($file_check)) {

        $img1 = base_url() . 'assets/images/'.$activity['profile_img'];

      }

    }



    $img = ($img1 !='') ? $img1 : base_url() . 'assets/images/default-avatar.png';

    ?>
    <div class="row" id="row_<?php echo $activity['invite_id'];?>">
      <div class="col-sm-6">
        <div class="jprfpic"><a href="<?php echo base_url();?>view-user/<?php echo $activity['username']; ?>"><img src="<?php echo $img; ?>" class="img-circle" height="40" width="40"></a></div>
        <div class="jprfname">
          <h3><a href="<?php echo base_url();?>view-user/<?php echo $activity['username']; ?>"><?php echo $activity['first_name'].' '.$activity['last_name']; ?></a></h3>
          <h4>
            <?php //echo $activity['applicant_personal_mess']; ?>
          </h4>
        </div>
      </div>
      <?php  

      $from_date_time =  $activity['invite_date'].' '.$activity['invite_time'];
      $from_timezone =$activity['time_zone'];                         
      $to_timezone = $this->session->userdata('time_zone');
      $from_date_time  = converToTz($from_date_time,$to_timezone,$from_timezone);
      $from_time  = date('h:i a',strtotime($from_date_time));
      ?>
      <div class="col-sm-2 text-left">
        <p>Date: <?php echo date('d-m-Y', strtotime($from_date_time)); ?></p>
      </div>
      <div class="col-sm-2 text-left">
        <p>Time: <?php echo date('h:i A', strtotime($from_time)); ?></p>
      </div>
      <div class="col-sm-2 text-left">
        <?php

                    if($activity['approved'] == 0 && date('Y-m-d H:i:s') >  date('Y-m-d H:i:s', strtotime($from_date_time . ' +1 hour'))) { 

                            $status = '<div class="dropdown">
                            <button class="btn-xs btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Cancelled <span class="caret"></span></button>  
                            <ul class="dropdown-menu">     
                            <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>                                    
                            <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->                                     
                            </ul>                          
                            </div>'; 

                          }else{

                            $status = '<div class="dropdown">
                            <button class="btn-xs btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Pending
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">                              
                               <li id="approve_'.$activity['invite_id'].'"><a href="javascript:void(0)"  onclick="confirmApprove('.$activity['invite_id'].','.$activity['invite_from'].')">Approve</a></li>
                            <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>      
                            <li><a href="javascript:void(0)"  onclick="confirmCancel('.$activity['invite_id'].','.$activity['invite_from'].')">Cancel</a></li>                                 

                            <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->   
                            </ul>

                            </div

                            </div>';

                          } 

                           $count = $this->db->get_where('call_logs',array('invite_id'=>$activity['invite_id']))->num_rows();

                           // Before Call time with approved 

                          if($activity['approved'] == 1 && date('Y-m-d H:i:s') <  date('Y-m-d H:i:s', strtotime($from_date_time)) ){
                          
                            $status = '<div class="dropdown">
                             <button class="btn-xs btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Approved
                             <span class="caret"></span></button>
                             <ul class="dropdown-menu">
                             <li><a href="javascript:void(0)"  onclick="confirmCancel('.$activity['invite_id'].','.$activity['invite_from'].')">Cancel</a></li>                           
                             <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>                                    
                             <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->                                     
                             </ul>
                             </div>';
                             
                         }
                        elseif($activity['approved'] == 1 && date('Y-m-d H:i:s') >  date('Y-m-d H:i:s', strtotime($from_date_time)) ){
                          // After Call time with Approve 


                          // After Call time with Approve  with call logs 
                           if($count>0){
                             $status = '<div class="dropdown">
                             <button class="btn-xs btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Finished
                             <span class="caret"></span></button>
                             <ul class="dropdown-menu">                                                
                             <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>                                    
                             <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->                                     
                             </ul>
                             </div>';                                

                           }else{ // After Call time with Approve  without call logs 

                             $status = '<div class="dropdown">
                             <button class="btn-xs btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Incomplete
                             <span class="caret"></span></button>
                             <ul class="dropdown-menu">                                         
                             <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>                                    
                             <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->                                     
                             </ul>
                             </div>';

                           }
                         }

                         if($activity['approved'] == 2) { 
                           $status = '<div class="dropdown">
                           <button class="btn-xs btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Cancelled <span class="caret"></span></button>  
                           <ul class="dropdown-menu">   
                           <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>      
                           <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->                                      
                           </ul>                          
                           </div>'; 

                         }

                         echo $status;

       ?>
     </div>
   </div>
   <?php 

 endforeach;

endif;



echo $links; 

?>
</div>
</div>
<!--Activity Tabs Starts Here-->
<!--Timings Tab Starts Here-->
<div id="timings" class="tab-pane fade">
  <div class="row titlerow">
    <div class="col-sm-6">
      <h2>Schedule Timings</h2>
    </div>
    <div class="col-sm-6 text-right"></div>
  </div>
  <div class="subnav timingsnav">
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" id="tsunday_link" href="#tsunday" data-day-value="1" data-append-value="tsunday">Sunday</a></li>
      <li><a data-toggle="tab" id="tmonday_link" href="#tmonday" data-day-value="2" data-append-value="tmonday">Monday</a></li>
      <li><a data-toggle="tab" id="ttuesday_link" href="#ttuesday" data-day-value="3" data-append-value="ttuesday">Tuesday</a></li>
      <li><a data-toggle="tab" id="twednesday_link" href="#twednesday" data-day-value="4" data-append-value="twednesday">Wednesday</a></li>
      <li><a data-toggle="tab" id="tthursday_link" href="#tthursday" data-day-value="5" data-append-value="tthursday">Thursday</a></li>
      <li><a data-toggle="tab" id="tfriday_link" href="#tfriday" data-day-value="6" data-append-value="tfriday">Friday</a></li>
      <li><a data-toggle="tab" id="tsaturday_link" href="#tsaturday" data-day-value="7" data-append-value="tsaturday">Saturday</a></li>
    </ul>
  </div>
  <div class="tab-content">
    <div class="row">
      <form id="schedule_mentor_form" name="schedule_mentor_form" method="post">
        <div class="col-md-2 col-sm-4">
          <input type="hidden" name="day_value" id="day_value" value="1">
          <input type="hidden" name="day_name" id="day_name" value="Sunday">
          <input type="hidden" name="id_value" id="id_value" value="">
          <label class="control-label">From</label>
          <select class="form-control" id="from_time" name="from_time">
          </select>
        </div>
        <div class="col-md-2 col-sm-4">
          <label class="control-label">To</label>
          <select class="form-control" id="to_time" name="to_time">
          </select>
        </div>
        <div class="col-md-8 col-sm-4">
          <button class="btn btn-success tadd" type="submit">ADD</button>
        </div>
      </form>
    </div>
    <!--Starts Here-->
    <div id="tsunday" class="tab-pane fade in active"> </div>
    <!--Ends Here-->
    <!--Starts Here-->
    <div id="tmonday" class="tab-pane fade"> </div>
    <!--Ends Here-->
    <!--Starts Here-->
    <div id="ttuesday" class="tab-pane fade"> </div>
    <!--Ends Here-->
    <!--Starts Here-->
    <div id="twednesday" class="tab-pane fade"> </div>
    <!--Ends Here-->
    <!--Starts Here-->
    <div id="tthursday" class="tab-pane fade"> </div>
    <!--Ends Here-->
    <!--Starts Here-->
    <div id="tfriday" class="tab-pane fade"> </div>
    <!--Ends Here-->
    <!--Starts Here-->
    <div id="tsaturday" class="tab-pane fade"> </div>
    <!--Ends Here-->
  </div>
</div>
<!--Timings Tab Ends Here-->
<!--Account Tab Starts Here-->

<?php
if(!empty($_GET['account'])){

  echo '<div id="account" class="tab-pane fade in dash_acc_tab  active">';
}else{
  echo '<div id="account" class="tab-pane fade in">';

}

?>

<div class="row titlerow">
  <div class="col-sm-6">
    <div class="row">
      <div class="col-md-6 col-xs-6">
        <h2>Account</h2>
      </div>
      <div class="col-md-6 col-xs-6">
        <div class="edit-btn text-right">
          <a title="Edit Profile" class="btn btn-default" href="javascript:void(0);" onclick="edit_account()"><i aria-hidden="true" class="fa fa-pencil"></i> Edit Details</a>
        </div>
      </div>
    </div>
    <div class="profile-view-bottom">
      <div class="row">
        <div class="col-md-6">
          <h6>Bank Name</h6>
          <h5 id="bank_name" ><?php echo ($account->bank_name)?$account->bank_name:'-'; ?></h5>
        </div>
        <div class="col-md-6">
          <h6>Account Type</h6>
          <h5 id="account_type" ><?php echo ($account->account_type)?$account->account_type:'-'; ?></h5>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h6>Routing (ABA)</h6>
          <h5 id="routing" ><?php echo ($account->routing)?$account->routing:'-'; ?></h5>
        </div>
        <div class="col-md-6">
          <h6>Beneficiary Name</h6>
          <h5 id="beneficiary_name" ><?php echo ($account->beneficiary_name)?$account->beneficiary_name:'-'; ?></h5>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h6>Account Number</h6>
          <h5 id="account_no" ><?php echo ($account->account_no)?$account->account_no:'-'; ?></h5>
        </div>
        <div class="col-md-6"></div>
      </div>
    </div>
  </div>

  <?php 
  $where = array('mentor_id'=>$this->session->userdata('applicant_id'));
  $earned = $this->db->select('SUM(payment_gross) as earned')->get_where('payments',$where)->row(); 


  ?>
  <div class="col-sm-6">
    <div class="row">
      <div class="col-sm-6 col-md-4 spa_earned"><span>$<?php echo ($earned)?$earned->earned:'0.00'; ?></span>Earned</div>
      <div class="col-sm-6 col-md-4 spa_paid"><span>$0.00</span>Refunded</div>
      <div class="col-sm-6 col-md-4 spa_balance"><span>$0.00</span>Balance</div>
      <div class="col-md-12 spa_paynow"><a class="btn btn-primary">Payment Request</a></div>
    </div>
  </div>
</div>



	<div class="spa_conversations">		<div class="table-responsive">
			<table id="datatable" class="table table-striped" style="width:100% !important;">
				<thead>
					<tr>
						<th>Applicant Name</th>
						<th>Date</th>
						<th>From time</th>
						<th>To time</th>
						<th>Duration</th>
						<th>Amount</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>  
		</div>	</div>
</div>
<!--Account Tab Ends Here-->
<!--Edit Account Details Modal-->
<div class="modal fade" id="edit_acc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3>Account Details</h3>
      </div>
      <div class="modal-body">
        <form class="form-vertical" id="account_form" >     
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Bank Name</label>
                <input type="text" name="bank_name" class="form-control bank_name" value="<?php echo ($account->bank_name)?$account->bank_name:''; ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Account Type</label>
                <input type="text" name="account_type" class="form-control account_type" value="<?php echo ($account->account_type)?$account->account_type:''; ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Routing (ABA)</label>
                <input type="text" name="routing" class="form-control routing" value="<?php echo ($account->routing)?$account->routing:''; ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Beneficiary Name</label>
                <input type="text" name="beneficiary_name" class="form-control beneficiary_name" value="<?php echo ($account->beneficiary_name)?$account->beneficiary_name:''; ?>">
              </div>
            </div>
          </div> 
          <div class="row">                            
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Account Number</label>
                <input type="text" name="account_no" class="form-control account_no" value="<?php echo ($account->account_no)?$account->account_no:''; ?>">
              </div>
            </div>
          </div>

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="save_acount()">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


</div>
<!-- Modal -->
<div class="modal fade" id="approve_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3>Confirmation</h3>
      </div>
      <div class="modal-body"> Are you sure? you want to approve this call?
        <input type="hidden" name="" id="hidden_ids">
        <input type="hidden" name="" id="user_id">
        <input type="hidden" name="" id="channel" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="approve_activity()">Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3>Confirmation</h3>
      </div>
      <div class="modal-body"> Are you sure?  you want to delete this detail?
        <input type="hidden" name="" id="hidden_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="delete_activity()">Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<!--Cancel Modal -->
<div class="modal fade" id="cancel_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3>Confirmation</h3>
      </div>
      <div class="modal-body"> Are you sure? you want to cancel this request ?
        <input type="hidden" name="" id="hidden_idss">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="cancel_activity()">Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">



 function edit_account()
 {
  $('#edit_acc').modal('show');
}

function save_acount()
{
  var bank_name = $('.bank_name').val();
  var account_type = $('.account_type').val();
  var routing = $('.routing').val();
  var beneficiary_name = $('.beneficiary_name').val();
  var account_no = $('.account_no').val();

  $('#bank_name').text(bank_name);
  $('#account_type').text(account_type);
  $('#routing').text(routing);
  $('#beneficiary_name').text(beneficiary_name);
  $('#account_no').text(account_no);


  $.post('<?php echo base_url(); ?>user/save_acount',{
    bank_name :bank_name ,
    account_type :account_type ,
    routing :routing ,
    beneficiary_name :beneficiary_name ,
    account_no :account_no ,
  },function(res){
    console.log(res);
  });

                  // console.log('test');
                }


                function confirmCancel(id){

                  $('#hidden_idss').val(id);

                  $('#cancel_modal').modal('show');

                }
                function confirmDelete(id){

                  $('#hidden_id').val(id);

                  $('#delete_modal').modal('show');

                }

                function delete_activity()

                {

                  var invite_id = $('#hidden_id').val();

                  $.post('<?php echo base_url(); ?>user/delete_activity',{invite_id:invite_id},function(res){

                    $('#row_'+invite_id).hide('slow'); 

                  });

                }
                function cancel_activity()
                {

                  var invite_id = $('#hidden_idss').val();
                  $('#btn_'+invite_id).removeClass('btn-info').addClass('btn-danger').html('Cancelled <span class="caret"></span>');

                  $.post('<?php echo base_url(); ?>user/cancel_activity',{invite_id:invite_id},function(res){


                  });

                }



                function confirmApprove(id,user_id){
                  var channel  = getUuid();
                  $('#hidden_ids').val(id);
                  $('#channel').val(channel);
                  $('#user_id').val(user_id);
                  $('#approve_modal').modal('show');

                }

                //Support functions
                function getUuid(){
                  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                    var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
                    return v.toString(16);
                  });
                }



                function approve_activity()

                {



                 var invite_id = $('#hidden_ids').val();
                 var user_id = $('#user_id').val();
                 var user_id = $('#user_id').val();
                 var channel = $('#channel').val();

                 $('#btn_'+invite_id).removeClass('btn-info').addClass('btn-success').html('Approved  <span class="caret"></span>');



                 $('#approve_'+invite_id).remove();

                 $.post('<?php echo base_url(); ?>user/approve_activity',{channel:channel,user_id:user_id,invite_id:invite_id},function(res){



                 });



               }

             </script>
