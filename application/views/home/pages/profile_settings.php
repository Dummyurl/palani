<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <!--[if IE]>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
<![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>Profile Settings</title>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/favicon.png">
<link href="<?php echo base_url(); ?>mentori_assets/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>mentori_assets/css/animate.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>mentori_assets/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/oldstyle.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>mentori_assets/css/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>mentori_assets/css/custom.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/profilesetting.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap-datetimepicker.min.css" type="text/css">


<link href="<?php echo base_url(); ?>assets/css/slim.min.css" rel="stylesheet">   
<script src="<?php echo base_url(); ?>assets/js/slim.kickstart.min.js"></script>


</head>
<body>
  <header class="header admin-header">
   <div class="container-fluid">
    <div class="row">
      <div class="col-md-4 col-sm-3">
       <a class="pull-left" href="#"><img src="<?php echo base_url(); ?>mentori_assets/img/logo_1.png" alt="Mentori.ng"></a>
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
    <div class="col-md-8 col-sm-9 mainnav-profile">
      <div class="collapse navbar-collapse" id="slide-navbar-collapse">     
        <ul>
         <li><a href="#">Dashboard</a></li>
         <li><a href="#">Messages</a></li>         
         <li><a href="#">Calendar</a></li>    
         <li><a href="<?php echo base_url(); ?>user/logout">Logout</a></li>    
       </ul>
     </div>
   </div>
 </div>

</div>
</div>
</header>
<style type="text/css">
.alert:empty{display: none;}
</style>
<div class="mainarea">
  <!--Copy paste below code-->
  <div class="container dashboard">
   <div class="ndashboxright">
     <div class="row">
       <div class="col-md-6">
        <h1>Steps to complete your profile</h1>
      </div>
      <div class="col-md-6"> 
       <input type="hidden" value="<?php echo date('m-d-Y', strtotime('-5 years')); ?>" id="maxDate">        
     </div>
   </div>
   <ul class="stepscntr" role="tablist">
     <li role="presentation" class="steps first active" >
      <a href="#step1" aria-controls="step1" role="tab" data-toggle="tab">Step 1</a></li>
      <li role="presentation" class="steps second" >
        <a href="#step2" aria-controls="step2" role="tab" data-toggle="tab" >Step 2</a></li>
        <li role="presentation" class="steps three" >
          <a href="#step3" aria-controls="step3" role="tab" data-toggle="tab" >Step 3</a></li>
          <li role="presentation" class="steps three" >
            <a href="#step4" aria-controls="step4" role="tab" data-toggle="tab" >Step 4</a></li>
          </ul>

          <div class="tab-content">
            <div role="tabpanel" class="tab-pane  active" id="step1">
             <p>Please select 1-5 subjects. You can add more subjects on later.</p>
             <div class="alert alert-danger"></div>
             <div class="alert alert-success"></div>
             <form action="" method="post" id="course_form">
               <?php
               foreach($subject as $s):
                $subject = str_replace(' ','', $s->subject);

                ?>
                <div class="accsignup">
                  <a role="button" data-toggle="collapse" href="#<?php                     
                  $subject1 = str_replace('/','_', $subject);
                  echo strtolower($subject1); ?>" aria-expanded="false" aria-controls="collapseExample"><?php echo $s->subject; ?></a>
                  <div class="collapse" id="<?php echo strtolower($subject1); ?>">
                    <div class="row">
                      <?php

                      $data = $this->db->get_where('courses',array('subject_id'=>$s->subject_id,'status'=>1))->result();

                      if(!empty($data)){
                        foreach ($data as $d) {
                          $where = array('course_id'=>$d->course_id,'mentor_id'=>$this->session->userdata('applicant_id'),'status'=>1);
                          $count = $this->db->get_where('mentor_course_details',$where)->num_rows();
                          if($count == 0){
                            echo '<div class="col-sm-6 col-sm-vmargin-14">
                            <label class="col-sm-12"><input type="checkbox" value="'.$d->subject_id.'|'.$d->course_id.'" name="courses[]" class="courses" onClick="chk_checkbox(this, '.$d->course_id.')" >'.$d->course.'</label>
                            <div class="col-sm-12" id="'.$d->course_id.'" style="display:none">
                            <div class="col-sm-6">
                            <select class="form-control" name="expYears['.$d->course_id.']">
                            <option value="">Years</option>
                            <option value="0">0 Year</option>
                            <option value="1">1 Year</option>
                            <option value="2">2 Years</option>
                            <option value="3">3 Years</option>
                            <option value="4">4 Years</option>
                            <option value="5">5 Years</option>
                            <option value="6">6 Years</option>
                            <option value="7">7 Years</option>
                            <option value="8">8 Years</option>
                            <option value="9">9 Years</option>
                            <option value="10">10 Years</option>
                            <option value="11">11 Years</option>
                            <option value="12">12 Years</option>
                            <option value="13">13 Years</option>
                            <option value="14">14 Years</option>
                            <option value="15">15 Years</option>
                            <option value="16">16 Years</option>
                            <option value="17">17 Years</option>
                            <option value="18">18 Years</option>
                            <option value="19">19 Years</option>
                            <option value="20">20 Years</option>
                            <option value="21">21 Years</option>
                            <option value="22">22 Years</option>
                            <option value="23">23 Years</option>
                            <option value="24">24 Years</option>
                            <option value="25">25 Years</option>
                            <option value="26">26 Years</option>
                            <option value="27">27 Years</option>
                            <option value="28">28 Years</option>
                            <option value="29">29 Years</option>
                            <option value="30">30 Years</option>
                            </select>
                            </div>
                            <div class="col-sm-6">
                            <select class="form-control" name="expMonths['.$d->course_id.']">
                            <option value="">Months</option>
                            <option value="0">0 Month</option>
                            <option value="1">1 Month</option>
                            <option value="2">2 Months</option>
                            <option value="3">3 Months</option>
                            <option value="4">4 Months</option>
                            <option value="5">5 Months</option>
                            <option value="6">6 Months</option>
                            <option value="7">7 Months</option>
                            <option value="8">8 Months</option>
                            <option value="9">9 Months</option>
                            <option value="10">10 Months</option>
                            <option value="11">11 Months</option>
                            </select>
                            </div>
                            </div>
                            </div>';
                          }else{
                            $individual_course = $this->db->get_where('mentor_course_details',$where)->row();
                            ?>
                            <div class="col-sm-6 col-sm-vmargin-14">
                              <label class="col-sm-12"><input type="checkbox" value="<?php echo $d->subject_id.'|'.$d->course_id; ?>" name="courses[]" class="courses" onClick="chk_checkbox(this, <?php echo $d->course_id; ?>)" checked="checked" ><?php echo $d->course; ?></label>
                              <div class="col-sm-12" id="<?php echo $d->course_id; ?>">
                                <div class="col-sm-6">
                                  <select class="form-control" name="expYears[<?php echo $d->course_id; ?>]">
                                    <option value="" <?php echo $individual_course->years==0 ? "selected" : ""; ?>>Years</option>
                                    <option value="0" <?php echo $individual_course->years==0 ? "selected" : ""; ?>>0 Year</option>
                                    <option value="1" <?php echo $individual_course->years==1 ? "selected" : ""; ?>>1 Year</option>
                                    <option value="2" <?php echo $individual_course->years==2 ? "selected" : ""; ?>>2 Years</option>
                                    <option value="3" <?php echo $individual_course->years==3 ? "selected" : ""; ?>>3 Years</option>
                                    <option value="4" <?php echo $individual_course->years==4 ? "selected" : ""; ?>>4 Years</option>
                                    <option value="5" <?php echo $individual_course->years==5 ? "selected" : ""; ?>>5 Years</option>
                                    <option value="6" <?php echo $individual_course->years==6 ? "selected" : ""; ?>>6 Years</option>
                                    <option value="7" <?php echo $individual_course->years==7 ? "selected" : ""; ?>>7 Years</option>
                                    <option value="8" <?php echo $individual_course->years==8 ? "selected" : ""; ?>>8 Years</option>
                                    <option value="9" <?php echo $individual_course->years==9 ? "selected" : ""; ?>>9 Years</option>
                                    <option value="10" <?php echo $individual_course->years==10 ? "selected" : ""; ?>>10 Years</option>
                                    <option value="11" <?php echo $individual_course->years==11 ? "selected" : ""; ?>>11 Years</option>
                                    <option value="12" <?php echo $individual_course->years==12 ? "selected" : ""; ?>>12 Years</option>
                                    <option value="13" <?php echo $individual_course->years==13 ? "selected" : ""; ?>>13 Years</option>
                                    <option value="14" <?php echo $individual_course->years==14 ? "selected" : ""; ?>>14 Years</option>
                                    <option value="15" <?php echo $individual_course->years==15 ? "selected" : ""; ?>>15 Years</option>
                                    <option value="16" <?php echo $individual_course->years==16 ? "selected" : ""; ?>>16 Years</option>
                                    <option value="17" <?php echo $individual_course->years==17 ? "selected" : ""; ?>>17 Years</option>
                                    <option value="18" <?php echo $individual_course->years==18 ? "selected" : ""; ?>>18 Years</option>
                                    <option value="19" <?php echo $individual_course->years==19 ? "selected" : ""; ?>>19 Years</option>
                                    <option value="20" <?php echo $individual_course->years==20 ? "selected" : ""; ?>>20 Years</option>
                                    <option value="21" <?php echo $individual_course->years==21 ? "selected" : ""; ?>>21 Years</option>
                                    <option value="22" <?php echo $individual_course->years==22 ? "selected" : ""; ?>>22 Years</option>
                                    <option value="23" <?php echo $individual_course->years==23 ? "selected" : ""; ?>>23 Years</option>
                                    <option value="24" <?php echo $individual_course->years==24 ? "selected" : ""; ?>>24 Years</option>
                                    <option value="25" <?php echo $individual_course->years==25 ? "selected" : ""; ?>>25 Years</option>
                                    <option value="26" <?php echo $individual_course->years==26 ? "selected" : ""; ?>>26 Years</option>
                                    <option value="27" <?php echo $individual_course->years==27 ? "selected" : ""; ?>>27 Years</option>
                                    <option value="28" <?php echo $individual_course->years==28 ? "selected" : ""; ?>>28 Years</option>
                                    <option value="29" <?php echo $individual_course->years==29 ? "selected" : ""; ?>>29 Years</option>
                                    <option value="30" <?php echo $individual_course->years==30 ? "selected" : ""; ?>>30 Years</option>
                                  </select>
                                </div>
                                <div class="col-sm-6">
                                  <select class="form-control" name="expMonths[<?php echo $d->course_id; ?>]">
                                    <option value="" <?php echo $individual_course->months=="" ? "selected" : ""; ?>>Months</option>
                                    <option value="0" <?php echo $individual_course->months==0 ? "selected" : ""; ?>>0 Month</option>
                                    <option value="1" <?php echo $individual_course->months==1 ? "selected" : ""; ?>>1 Month</option>
                                    <option value="2" <?php echo $individual_course->months==2 ? "selected" : ""; ?>>2 Months</option>
                                    <option value="3" <?php echo $individual_course->months==3 ? "selected" : ""; ?>>3 Months</option>
                                    <option value="4" <?php echo $individual_course->months==4 ? "selected" : ""; ?>>4 Months</option>
                                    <option value="5" <?php echo $individual_course->months==5 ? "selected" : ""; ?>>5 Months</option>
                                    <option value="6" <?php echo $individual_course->months==6 ? "selected" : ""; ?>>6 Months</option>
                                    <option value="7" <?php echo $individual_course->months==7 ? "selected" : ""; ?>>7 Months</option>
                                    <option value="8" <?php echo $individual_course->months==8 ? "selected" : ""; ?>>8 Months</option>
                                    <option value="9" <?php echo $individual_course->months==9 ? "selected" : ""; ?>>9 Months</option>
                                    <option value="10" <?php echo $individual_course->months==10 ? "selected" : ""; ?>>10 Months</option>
                                    <option value="11" <?php echo $individual_course->months==11 ? "selected" : ""; ?>>11 Months</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="clear-fix"></div>
                            <?php

                          }

                        }
                      }?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
              <div class="save-continue">
               <button class="btn btn-primary" type="button" onclick="onSubmit()">Save & Continue</button>
             </div>
           </form>
         </div><!--Step1 ends here-->

         <?php
         $wheres = array('id'=>$this->session->userdata('applicant_id'));
         $users = $this->db->get_where('applicants',$wheres)->row();

         $where = array('mentor_id'=>$this->session->userdata('applicant_id'),'status'=>1);
         $count = $this->db->get_where('mentor_course_details',$where)->num_rows();

         $step = ($count!=0)?'id="step2"':'';


         $result = $this->user_model->get_progress_bar($this->session->userdata('applicant_id'));
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

        ?>

        <div role="tabpanel" class="tab-pane step2" <?php echo $step; ?>>
         <h2>Profile Image & Biography </h2>
         <div class="alert alert-danger bio-alert"></div>
         <div class="alert alert-success bio-success-alert"></div>
         <div class="row">
           <div class="col-sm-12">
             <div class="profile-box">
               <div class="row">
                 <div class="col-md-3 col-sm-3 profile-img-left">
                   <div class="profile-left">
                    <div id="avatar-view" class="">             
                      <div class="slim edit-pro-slim"
                      data-will-remove="imageRemoved"
                      data-status-upload-success="Profile image updated"
                      data-label-loading="File uploading.."
                      data-instant-edit="true"
                      data-service="<?php echo base_url(); ?>user/upload_avatar"
                      data-push="true"
                      data-ratio="1:1"
                      data-label="Upload Image"
                      data-size="360,360"
                      data-max-file-size="2"                  
                      >
                      <img src="<?php echo $img; ?>" width="300" height="300" alt="Profile image" class="upprofile-img" />
                      <input type="file" name="slim[]"/>
                    </div>            
                  </div> 

                  <script type="text/javascript">
                    function imageRemoved(){
                      swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                      }).then((result) => {
                        if (result.value) {

                          $.get(base_url+'user/delete_profile_image',function(res){
                            var obj = jQuery.parseJSON(res);
                            if(obj.status == true){
                             swal(
                              'Deleted!',
                              'Profile image has been deleted.',
                              'success'
                              );
                             $('.upprofile-img,img-responsive,.in,.out').attr('src',obj.image_url);                   
                           }else{
                            swal({
                              type: 'error',
                              title: 'Oops...',
                              text: 'You dont have profile image yet!'                        
                            });
                          }

                        });
                        }
                      });
                    }
                  </script>                 
                </div>
              </div>
              <div class="col-md-9 col-sm-9 profile-img-right">
               <form id="reg_profile_form" action="" method="post">
                 <div class="profile-right">
                   <div class="education-details">
                     <div class="row">
                       <div class="col-sm-12">
                         <div class="form-group">
                           <label class="control-label">Biography <span>*</span></label>
                           <textarea class="form-control" name="mentor_personal_message" id="mentor_personal_message" maxlength="500" minlength="40" ><?php echo $mentor_personal_message=$result['mentor_personal_message']; ?></textarea>
                           <br>
                           <span class="help-block pull-right">
                             <span id="chars"><?php echo $charsb = 500 - strlen($mentor_personal_message); ?></span> characters remaining
                           </span>
                         </div>
                       </div>
                     </div>
                   </div>
                   <div class="submit-btn">
                     <button type="button" class="btn btn-primary pull-right" onclick="onProfileSubmit()">Save & Continue</button>
                   </div>
                 </div>
               </form>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div><!--Step2 ends here-->


   <?php

   $step3_wheres = array('id'=>$this->session->userdata('applicant_id'), 'profile_img !='=>"");
   $step3_count = $this->db->get_where('applicants',$step3_wheres)->num_rows();

   $where = array(  'mentor_id' => $this->session->userdata('applicant_id'));
   $data = $this->db->get_where('mentor_details',$where)->row();
   $step3 = ($step3_count!=0 && !empty($data->mentor_personal_message))?'id="step3"':'';
   $step4 = (!empty($data))?'id="step4"':'';

   ?>
   <div role="tabpanel" class="tab-pane step3" <?php echo $step3; ?>>
     <h2>Basic Information</h2>

     <div class="alert alert-danger profile-alert"></div>
     <div class="alert alert-success profile-success-alert"></div>
     <form id="profile_form" method="post">
       <div class="row m-t-30">
         <div class="col-md-6 col-sm-6">
          <div class="form-group">
           <label class="control-label">Gender</label>
           <div class="clearfix">
            <label class="radio-inline"><input type="radio" name="mentor_gender" id="inlineRadio1" value="1" <?php if($data->mentor_gender == 1){echo 'checked="checked"'; } ?>> Male</label>
            <label class="radio-inline"><input type="radio" name="mentor_gender" id="inlineRadio2" value="2" <?php if($data->mentor_gender == 2){echo 'checked="checked"'; } ?>> Female</label>
          </div>
        </div>
        <div class="form-group">
         <label class="control-label">Date of birth</label>
         <input type="text" id="dob" name="dob" class="form-control" value="<?php
         if(isset($data->dob)){
           echo ($data->dob!='0000-00-00')?date('d/m/Y',strtotime($data->dob)):'';
         } ?>">
       </div>
       <div class="form-group">
         <label class="control-label">Where did you hear about us?</label>
         <select class="form-control text" name="where_you_heard">
           <option value="">-- Please select --</option>
           <option value="Through web search" <?php if($data->where_you_heard == 'Through web search'){echo 'selected="selected"'; } ?>>Through web search</option>
           <option value="Heard from a friend" <?php if($data->where_you_heard == 'Heard from a friend'){echo 'selected="selected"'; } ?>>Heard from a friend</option>
         </select>
       </div>
       <div class="form-group <?php if($this->session->userdata('type') == 'user'){ echo 'hidden'; } ?>" >
         <label class="control-label">Charging <?php echo $result['charge_type']; ?></label>
         <div class="clear-fix">
           <label class="radio-inline">
            <input type="radio" name="charge_type" value="free" <?php if( $result['charge_type'] == 'free'){ echo 'checked="checked"'; } ?>> Free
          </label>

          <label class="radio-inline">                   
           <input type="radio" name="charge_type" value="charge" <?php if( $result['charge_type'] == 'charge'){ echo 'checked="checked"'; } ?> > Charge (per hour in dollar)
         </label>
         <label class="radio-inline">
           <input type="text" class="form-control" name="hourly_rate" id="hourly_rate" value="<?php echo $result['hourly_rate']; ?>" required min="1"  <?php if( $result['charge_type'] != 'charge'){ echo 'disabled'; } ?> onkeypress="return isRate(event)" maxlength="7">
         </label>
       </div>
     </div>
   </div>
   <div class="col-md-6 col-sm-6">
     <div class="form-group">
       <label class="control-label">Undergraduate college</label>
       <input type="text" id="" name="under_college" class="form-control text" value="<?php echo $data->under_college;?>" maxlength="30">
     </div>
     <div class="form-group">
       <label class="control-label">Undergraduate major</label>
       <input type="text" id="" name="under_major" class="form-control text" value="<?php echo $data->under_major;?>" maxlength="30">
     </div>
     <div class="form-group">
       <label class="control-label">Graduate college1</label>
       <input type="text" id="" name="graduate_college" class="form-control text" value="<?php echo $data->graduate_college;?>" maxlength="30">
     </div>
     <div class="form-group">
       <label class="control-label">Type of degree</label>
       <input type="text" id="" name="degree" class="form-control text" value="<?php echo $data->degree;?>" maxlength="30">
     </div>
   </div>
 </div>

 <h2>Your Address</h2>
 <div class="row m-t-30">
   <div class="col-md-6 col-sm-6">
    <div class="form-group">
     <label class="control-label">Address 1</label>
     <input type="text" id="" name="address_line1" class="form-control" value="<?php echo $data->address_line1;?>">
   </div>
   <div class="form-group">
     <label class="control-label">Address 2</label>
     <input type="text" id="" name="address_line2" class="form-control" value="<?php echo $data->address_line2;?>">
   </div>
   <div class="form-group">
     <label class="control-label">City</label>
     <input type="text"  class="form-control text" name="city" value="<?php echo $data->city;?>">
   </div>
 </div>
 <div class="col-md-6 col-sm-6">

   <div class="form-group">
     <label class="control-label">State</label>
     <input type="text"  class="form-control text" name="state" value="<?php echo $data->state;?>">

   </div>
   <div class="form-group">
     <label class="control-label">Country</label>
     <input type="text" id="" name="country" class="form-control text" value="<?php echo $data->country;?>">
   </div>

 </div>
</div>

<div class="save-continue">
 <button class="btn btn-primary" type="button" id="profile_form_btn">Save & Continue</button>
</div>
</form>
</div><!--Step3 ends here-->




<div role="tabpanel" class="tab-pane custom-notify-screen step4" <?php echo $step4; ?> >
  <div class="row vertical-align">
    <div class="col-md-5">
      <div class="row">
        <div class="col-md-10 center-block no-float custom-thankyou-screen  text-center">
          <img class="img img-responsive center-block" src="<?php echo base_url(); ?>assets/images/email-sent-icon.jpg" />
          <h1>Email Confirmation Sent</h1>                                    
          <p>An confirmation email has been sent to your email. If you don't receive the confirmation email, please confirm your email below and resend the confirmation email.</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-10 col-xs-11 center-block no-float inner-shadow-box md-vmargin">
          <div class="row">
            <div class="col-sm-6 col-md-6 text-center"><strong>Registered Email Address</strong></div>
            <div class="col-sm-6 col-md-6 custom-edit-style"><input type="email" class="form-control" id="exampleInputEmail2" placeholder="<?php echo $users->email; ?>" disabled ><small class="text-left"><a href="#" onclick="not_your_email()">Not your email?</a><i class="fa fa-pencil" aria-hidden="true"></i></small></div>

          </div>

          <div class="row">
            <div class="sm-mt-23 col-sm-6 col-md-6 center-block no-float text-center"><button class="btn btn-primary btn-resend" type="submit" onclick="resend_email()">Resend Email</button></div>                            
          </div>
        </div>
      </div> 


      <?php
      $wheres = array('id'=>$this->session->userdata('applicant_id'),'mobile_verified' =>1);
      $count = $this->db->get_where('applicants',$wheres)->num_rows();

      if($count == 0){
       $verified="style='display:block'";
       $success_msg="style='display:none'";
     }else{
       $verified="style='display:none'";
       $success_msg="style='display:block'";
     }
     ?>
   </div>
   <div class="sm-valign-32 col-md-2 text-center">
    <span class="span-style">(or)</span>
  </div>

  <br>

  <div class="col-md-5" id="mobile_first_verify" <?php echo $verified ?>>
    <h2 id="mobile_title" >Verify Your Mobile Number</h2>
    <form method="post" id="mobile_verify_form" <?php echo $verified ?>>
     <div id="error_msg" style="color:red;"></div>
     <div class="row">
      <div class="col-sm-4 resendemail">
       <select name="country_code" class="form-control" id="country_code">
         <option data-countryCode="GB" value="44" Selected>UK (+44)</option>
         <option data-countryCode="US" value="1">USA (+1)</option>
         <optgroup label="Other countries">
           <option data-countryCode="DZ" value="213">Algeria (+213)</option>
           <option data-countryCode="AD" value="376">Andorra (+376)</option>
           <option data-countryCode="AO" value="244">Angola (+244)</option>
           <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
           <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
           <option data-countryCode="AR" value="54">Argentina (+54)</option>
           <option data-countryCode="AM" value="374">Armenia (+374)</option>
           <option data-countryCode="AW" value="297">Aruba (+297)</option>
           <option data-countryCode="AU" value="61">Australia (+61)</option>
           <option data-countryCode="AT" value="43">Austria (+43)</option>
           <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
           <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
           <option data-countryCode="BH" value="973">Bahrain (+973)</option>
           <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
           <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
           <option data-countryCode="BY" value="375">Belarus (+375)</option>
           <option data-countryCode="BE" value="32">Belgium (+32)</option>
           <option data-countryCode="BZ" value="501">Belize (+501)</option>
           <option data-countryCode="BJ" value="229">Benin (+229)</option>
           <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
           <option data-countryCode="BT" value="975">Bhutan (+975)</option>
           <option data-countryCode="BO" value="591">Bolivia (+591)</option>
           <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
           <option data-countryCode="BW" value="267">Botswana (+267)</option>
           <option data-countryCode="BR" value="55">Brazil (+55)</option>
           <option data-countryCode="BN" value="673">Brunei (+673)</option>
           <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
           <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
           <option data-countryCode="BI" value="257">Burundi (+257)</option>
           <option data-countryCode="KH" value="855">Cambodia (+855)</option>
           <option data-countryCode="CM" value="237">Cameroon (+237)</option>
           <option data-countryCode="CA" value="1">Canada (+1)</option>
           <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
           <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
           <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
           <option data-countryCode="CL" value="56">Chile (+56)</option>
           <option data-countryCode="CN" value="86">China (+86)</option>
           <option data-countryCode="CO" value="57">Colombia (+57)</option>
           <option data-countryCode="KM" value="269">Comoros (+269)</option>
           <option data-countryCode="CG" value="242">Congo (+242)</option>
           <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
           <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
           <option data-countryCode="HR" value="385">Croatia (+385)</option>
           <option data-countryCode="CU" value="53">Cuba (+53)</option>
           <option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
           <option data-countryCode="CY" value="357">Cyprus South (+357)</option>
           <option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
           <option data-countryCode="DK" value="45">Denmark (+45)</option>
           <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
           <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
           <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
           <option data-countryCode="EC" value="593">Ecuador (+593)</option>
           <option data-countryCode="EG" value="20">Egypt (+20)</option>
           <option data-countryCode="SV" value="503">El Salvador (+503)</option>
           <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
           <option data-countryCode="ER" value="291">Eritrea (+291)</option>
           <option data-countryCode="EE" value="372">Estonia (+372)</option>
           <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
           <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
           <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
           <option data-countryCode="FJ" value="679">Fiji (+679)</option>
           <option data-countryCode="FI" value="358">Finland (+358)</option>
           <option data-countryCode="FR" value="33">France (+33)</option>
           <option data-countryCode="GF" value="594">French Guiana (+594)</option>
           <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
           <option data-countryCode="GA" value="241">Gabon (+241)</option>
           <option data-countryCode="GM" value="220">Gambia (+220)</option>
           <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
           <option data-countryCode="DE" value="49">Germany (+49)</option>
           <option data-countryCode="GH" value="233">Ghana (+233)</option>
           <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
           <option data-countryCode="GR" value="30">Greece (+30)</option>
           <option data-countryCode="GL" value="299">Greenland (+299)</option>
           <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
           <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
           <option data-countryCode="GU" value="671">Guam (+671)</option>
           <option data-countryCode="GT" value="502">Guatemala (+502)</option>
           <option data-countryCode="GN" value="224">Guinea (+224)</option>
           <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
           <option data-countryCode="GY" value="592">Guyana (+592)</option>
           <option data-countryCode="HT" value="509">Haiti (+509)</option>
           <option data-countryCode="HN" value="504">Honduras (+504)</option>
           <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
           <option data-countryCode="HU" value="36">Hungary (+36)</option>
           <option data-countryCode="IS" value="354">Iceland (+354)</option>
           <option data-countryCode="IN" value="91">India (+91)</option>
           <option data-countryCode="ID" value="62">Indonesia (+62)</option>
           <option data-countryCode="IR" value="98">Iran (+98)</option>
           <option data-countryCode="IQ" value="964">Iraq (+964)</option>
           <option data-countryCode="IE" value="353">Ireland (+353)</option>
           <option data-countryCode="IL" value="972">Israel (+972)</option>
           <option data-countryCode="IT" value="39">Italy (+39)</option>
           <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
           <option data-countryCode="JP" value="81">Japan (+81)</option>
           <option data-countryCode="JO" value="962">Jordan (+962)</option>
           <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
           <option data-countryCode="KE" value="254">Kenya (+254)</option>
           <option data-countryCode="KI" value="686">Kiribati (+686)</option>
           <option data-countryCode="KP" value="850">Korea North (+850)</option>
           <option data-countryCode="KR" value="82">Korea South (+82)</option>
           <option data-countryCode="KW" value="965">Kuwait (+965)</option>
           <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
           <option data-countryCode="LA" value="856">Laos (+856)</option>
           <option data-countryCode="LV" value="371">Latvia (+371)</option>
           <option data-countryCode="LB" value="961">Lebanon (+961)</option>
           <option data-countryCode="LS" value="266">Lesotho (+266)</option>
           <option data-countryCode="LR" value="231">Liberia (+231)</option>
           <option data-countryCode="LY" value="218">Libya (+218)</option>
           <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
           <option data-countryCode="LT" value="370">Lithuania (+370)</option>
           <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
           <option data-countryCode="MO" value="853">Macao (+853)</option>
           <option data-countryCode="MK" value="389">Macedonia (+389)</option>
           <option data-countryCode="MG" value="261">Madagascar (+261)</option>
           <option data-countryCode="MW" value="265">Malawi (+265)</option>
           <option data-countryCode="MY" value="60">Malaysia (+60)</option>
           <option data-countryCode="MV" value="960">Maldives (+960)</option>
           <option data-countryCode="ML" value="223">Mali (+223)</option>
           <option data-countryCode="MT" value="356">Malta (+356)</option>
           <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
           <option data-countryCode="MQ" value="596">Martinique (+596)</option>
           <option data-countryCode="MR" value="222">Mauritania (+222)</option>
           <option data-countryCode="YT" value="269">Mayotte (+269)</option>
           <option data-countryCode="MX" value="52">Mexico (+52)</option>
           <option data-countryCode="FM" value="691">Micronesia (+691)</option>
           <option data-countryCode="MD" value="373">Moldova (+373)</option>
           <option data-countryCode="MC" value="377">Monaco (+377)</option>
           <option data-countryCode="MN" value="976">Mongolia (+976)</option>
           <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
           <option data-countryCode="MA" value="212">Morocco (+212)</option>
           <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
           <option data-countryCode="MN" value="95">Myanmar (+95)</option>
           <option data-countryCode="NA" value="264">Namibia (+264)</option>
           <option data-countryCode="NR" value="674">Nauru (+674)</option>
           <option data-countryCode="NP" value="977">Nepal (+977)</option>
           <option data-countryCode="NL" value="31">Netherlands (+31)</option>
           <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
           <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
           <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
           <option data-countryCode="NE" value="227">Niger (+227)</option>
           <option data-countryCode="NG" value="234">Nigeria (+234)</option>
           <option data-countryCode="NU" value="683">Niue (+683)</option>
           <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
           <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
           <option data-countryCode="NO" value="47">Norway (+47)</option>
           <option data-countryCode="OM" value="968">Oman (+968)</option>
           <option data-countryCode="PK" value="92">Pakistan (+92)</option>
           <option data-countryCode="PW" value="680">Palau (+680)</option>
           <option data-countryCode="PA" value="507">Panama (+507)</option>
           <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
           <option data-countryCode="PY" value="595">Paraguay (+595)</option>
           <option data-countryCode="PE" value="51">Peru (+51)</option>
           <option data-countryCode="PH" value="63">Philippines (+63)</option>
           <option data-countryCode="PL" value="48">Poland (+48)</option>
           <option data-countryCode="PT" value="351">Portugal (+351)</option>
           <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
           <option data-countryCode="QA" value="974">Qatar (+974)</option>
           <option data-countryCode="RE" value="262">Reunion (+262)</option>
           <option data-countryCode="RO" value="40">Romania (+40)</option>
           <option data-countryCode="RU" value="7">Russia (+7)</option>
           <option data-countryCode="RW" value="250">Rwanda (+250)</option>
           <option data-countryCode="SM" value="378">San Marino (+378)</option>
           <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
           <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
           <option data-countryCode="SN" value="221">Senegal (+221)</option>
           <option data-countryCode="CS" value="381">Serbia (+381)</option>
           <option data-countryCode="SC" value="248">Seychelles (+248)</option>
           <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
           <option data-countryCode="SG" value="65">Singapore (+65)</option>
           <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
           <option data-countryCode="SI" value="386">Slovenia (+386)</option>
           <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
           <option data-countryCode="SO" value="252">Somalia (+252)</option>
           <option data-countryCode="ZA" value="27">South Africa (+27)</option>
           <option data-countryCode="ES" value="34">Spain (+34)</option>
           <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
           <option data-countryCode="SH" value="290">St. Helena (+290)</option>
           <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
           <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
           <option data-countryCode="SD" value="249">Sudan (+249)</option>
           <option data-countryCode="SR" value="597">Suriname (+597)</option>
           <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
           <option data-countryCode="SE" value="46">Sweden (+46)</option>
           <option data-countryCode="CH" value="41">Switzerland (+41)</option>
           <option data-countryCode="SI" value="963">Syria (+963)</option>
           <option data-countryCode="TW" value="886">Taiwan (+886)</option>
           <option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
           <option data-countryCode="TH" value="66">Thailand (+66)</option>
           <option data-countryCode="TG" value="228">Togo (+228)</option>
           <option data-countryCode="TO" value="676">Tonga (+676)</option>
           <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
           <option data-countryCode="TN" value="216">Tunisia (+216)</option>
           <option data-countryCode="TR" value="90">Turkey (+90)</option>
           <option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
           <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
           <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
           <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
           <option data-countryCode="UG" value="256">Uganda (+256)</option>
           <!-- <option data-countryCode="GB" value="44">UK (+44)</option> -->
           <option data-countryCode="UA" value="380">Ukraine (+380)</option>
           <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
           <option data-countryCode="UY" value="598">Uruguay (+598)</option>
           <!-- <option data-countryCode="US" value="1">USA (+1)</option> -->
           <option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
           <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
           <option data-countryCode="VA" value="379">Vatican City (+379)</option>
           <option data-countryCode="VE" value="58">Venezuela (+58)</option>
           <option data-countryCode="VN" value="84">Vietnam (+84)</option>
           <option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
           <option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
           <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
           <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
           <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
           <option data-countryCode="ZM" value="260">Zambia (+260)</option>
           <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
         </optgroup>
       </select>
     </div>

     <div class="col-md-6 resendemail">
       <input type="text" name="mobile_number" id="mobile_number" class="form-control" value="" onKeyUp="check_mobile(this.value);" required   autocomplete="off" onkeypress="return isNumberKey(event)"  />
     </div>
     <div class="col-md-4 resendemail">
       <button type="submit" class="btn btn-primary" >Send OTP</button>
     </div>
   </div>
 </form>

 <form method="post" id="mobile_verify_code_form" style="display: none"> 
  <div class="alert alert-success"> An OTP has been sent to your Mobile number. If you don't receive an OTP,Try to resend the OTP or try with alternate number.
  </div>
  <div id="error_msg" style="color:red;"></div>
  <div class="row resendemail">
    <div class="col-xs-12"><label class="control-label">Enter the verification code</label></div>
    <div class="col-sm-4">
     <input type="text" name="verification_code" id="verification_code" class="form-control" value="" required/>
     <br>
     <a href="javascript:void(0);" onclick="showMobileData_again()">Try alternate number?</a>
   </div>                
   <div class="col-sm-8">
    <button type="submit" class="btn btn-primary verify" >Verify</button>
    <button type="button" class="btn btn-primary send_again_otp" onclick="resend_otp()">Send Again</button>
  </div>

</div>
</div>
</form>


<script type="text/javascript">

 var email_status;
 function resend_otp(){
  $('.send_again_otp').text('Please wait...');
  $.get(base_url+'welcome/send_again_otp',function(res){
   var obj = jQuery.parseJSON(res);
   $('.send_again_otp').text('Send again');

   if(obj.status)
   {

    swal(
      'Success!',
      'OTP sent to your mobile number.',
      'success'
      )
    $('.verify').attr('disabled',false);

    $('#mobile_number').val('');
    $('#mobile_verify_form').css("display","none");
    $('#mobile_verify_code_form').css("display","block");
  }
  else
  {
    $('#error_msg').html(obj.message);
    $('#error_msg').css('display','block');
  }


});
}
</script>

<div class="col-md-5" id="mobile_first_verify_success" <?php echo $success_msg; ?>>
  <div class="col-md-8 center-block no-float text-center">
    <div class="mob-verify-notification">
      <img class="img img-responsive" src="<?php echo base_url(); ?>assets/images/mobile-verifiy.png" />
      <img class="img img-responsive" src="<?php echo base_url(); ?>assets/images/verify-tick-icon.png" />
    </div>
    <h1>Your mobile number has been verified successfully</h1>
    <a href="javascript:void(0)" class="btn btn-primary complete_signup" >Complete Signup!</a>
  </div>
</div> 
</div><!--Step2 ends here-->
</div>
</div>
</div>
<!--Copy paste code ends here-->
</div>




<!-- Email not yous modal  -->
<div class="modal fade" id="email_verify" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 style="color: white;">Change your email</h3>
      </div>
      <div class="modal-body">        
        <label> Enter your mail id</label>
        <input type="text" name="" id="email_id" class="form-control" onkeyup="check_email()">
        <span class="help-block"></span>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary new_mail">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Enter new email id -->

<script src="<?php echo base_url(); ?>mentori_assets/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo base_url(); ?>mentori_assets/js/bootstrap.js"></script>
<script src="<?php echo base_url(); ?>mentori_assets/js/appear.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrapValidator.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>
<script src='<?php echo base_url()."assets/" ?>js/moment.js'></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/cropper.min.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/main.js"></script>


<script type="text/javascript">
  function chk_checkbox(element, id)
  {
    if($(element).is(":checked")) {
      $('#'+id).css('display', 'block');
    }
    else{
      $('#'+id).css('display', 'none');
    }
  }
  function onSubmit()
  {
   $('html, body').animate({scrollTop:$('body').position().top}, 'slow');
   var course_count =$('.courses').parent().find('.courses:checked').length;
   if (course_count === 0){
     $('.alert-danger').html('<strong>Select atleast one course to coninue!</strong>');
     setTimeout(function() { $('.alert-danger').html('');
   }, 3000);
             // cancel submit
             return false;
           }
           else {

             $.ajax({
               url:'<?php echo base_url(); ?>welcome/add_mentor_course',
               data:$('#course_form').serialize(),
               method:'POST',
               success: function(data){
                 $('.step2').attr('id','step2');
                 $('.alert-success').html('Profile updated successfully!');
                 setTimeout(function() {
                   $('.alert-success').html('');
                   $("a[href='#step2']").click();
                   $('#step1').removeClass('active');
                   $('#step2').addClass('active');
                 }, 1000);

               }

             });
                 //alert(course_count + " courses selected");
               }
             }
           </script>

           <script type="text/javascript">

            $(document).ready(function() {
              var maxLength = 500;
              $('#mentor_personal_message').keyup(function() {
                var length = $(this).val().length;
                var length = maxLength-length;
                $('#chars').text(length);
              });
            });
            function onProfileSubmit()
            {
              $('.bio-alert').html('');
              $('html, body').animate({scrollTop:$('body').position().top}, 'slow');
              var profile_err = 0;
              var bio_err = 0;
              var profile_image = $('.upprofile-img').attr("src");
              var segment_str = profile_image;
              var segment_array = segment_str.split( '/' );
              var last_segment = segment_array[segment_array.length - 1];
              var bio = $('#mentor_personal_message').val();
              if(bio.length < 40){
                $('.bio-alert').html('<strong>Biography must have minimum 40 characters!</strong>');
                return false;
              }

              if(last_segment == "default-avatar.png"){
               profile_err = 1;
             }
             if(bio == ""){
               bio_err = 1;
              $('.bio-alert').html('<strong>Give biography to continue!</strong>');
               setTimeout(function() { $('.bio-alert').html('');
             }, 3000);
             // cancel submit
             return false;
             }else {
             $.ajax({
               url:'<?php echo base_url(); ?>welcome/add_biography',
               data:{mentor_personal_message: $('#mentor_personal_message').val()},
               method:'POST',
               success: function(result){
                 $('.step3').attr('id','step3');
                 $('.bio-success-alert').html('Profile updated successfully!');
                 setTimeout(function() {
                   $('.bio-success-alert').html('');
                   $("a[href='#step3']").click();
                   $('#step2').removeClass('active');
                   $('#step3').addClass('active');

                 }, 1000);

               }

             });
                 //alert(course_count + " courses selected");
               }
             }
           </script>


           <script type="text/javascript">

            $(document).ready(function(){
              $('input[name="charge_type"]').click(function(){
                var radioValue = $("input[name='charge_type']:checked"). val();
                if(radioValue == 'free'){
                  $('#hourly_rate').attr('disabled',true);
                }else{
                  $('#hourly_rate').attr('disabled',false);
                }
              });
            });

            var maxDate = $('#maxDate').val();
            maxDate =  moment(maxDate, 'MM-DD-YYYY hh:mm A');

            $('#dob').datetimepicker({
              maxDate: maxDate,
              format: "DD/MM/YYYY",
              useCurrent: false
            });


            var base_url ='<?php echo base_url(); ?>';


            $('#profile_form_btn').click(function(){

              $('html, body').animate({scrollTop:$('body').position().top}, 'slow');   

              <?php if($this->session->userdata('type') == 'guru'){ ?>           
                var hour_err = 0;
                var radioValue = $("input[name='charge_type']:checked"). val();                 

                if(radioValue == 'charge'){
                  var hourly_rate = $("#hourly_rate"). val();
                  if(hourly_rate == '' || hourly_rate == 0){
                    hour_err = 1;
                  }
                }else if(!radioValue){               
                 $('.profile-alert').html('<strong>Please select any option for charging !</strong>');
                 setTimeout(function() { $('.profile-alert').html('');
               }, 3000);
                 return false;
               }

               if(hour_err == 1){
                $('.profile-alert').html('<strong>Please give hourly rate!</strong>');
                setTimeout(function() { $('.profile-alert').html('');
              }, 3000);
                return false;
              }else{
                var url = base_url+"user/update_profile";
                var formData = $('#profile_form').serialize();
                $.ajax({
                  url:base_url+'user/update_mentor_profile',
                  data:formData,
                  type:'POST',
                  success:function(res){
                    $('.step4').attr('id','step4');
                    $('.profile-success-alert').html('Profile updated successfully!');
                    var obj = jQuery.parseJSON(res);
                    if(obj.is_verified == 0){

                      setTimeout(function() {
                        $('.profile-success-alert').html('');
                        $("a[href='#step4']").click();
                        $('#step3').removeClass('active');
                        $('#step4').addClass('active');
                      }, 1000);
                      
                      function get_email_status(){
                        $.get(base_url+'user/get_email_status',function(res){
                          var obj = jQuery.parseJSON(res);
                          if(obj.status!=0){
                            clearInterval(email_status);
                            swal({
                              title: "Success!",
                              text: "Email verified successfully!",
                              type: "success",
                              confirmButtonText: "Go to dashboard"
                            },
                            function(isConfirm){
                              if (isConfirm) {                         
                              }
                            });
                            $('.swal2-confirm').click(function(){
                             window.location.href=base_url+"dashboard";  
                           });

                          }                
                        });
                      }


                      var email_status =   setInterval(function(){ get_email_status(); }, 2000);
                    }else{

                     swal({
                      title: "Success!",
                      text: "Email verified successfully!",
                      type: "success",
                      confirmButtonText: "Go to dashboard"
                    },
                    function(isConfirm){
                      if (isConfirm) {    

                      }
                    }); 

                     $('.swal2-confirm').click(function(){
                       window.location.href=base_url+"dashboard";  
                     });

                   }
                 }
               });
                return false;
              }


            <?php }else{ ?>

              var url = base_url+"user/update_profile";
              var formData = $('#profile_form').serialize();
              $.ajax({
                url:base_url+'user/update_mentor_profile',
                data:formData,
                type:'POST',
                success:function(res){
                  $('.step4').attr('id','step4');
                  $('.profile-success-alert').html('Profile updated successfully!');
                  var obj = jQuery.parseJSON(res);
                  if(obj.is_verified == 0){

                    setTimeout(function() {
                      $('.profile-success-alert').html('');
                      $("a[href='#step4']").click();
                      $('#step3').removeClass('active');
                      $('#step4').addClass('active');
                    }, 1000);

                    function get_email_status(){
                      $.get(base_url+'user/get_email_status',function(res){
                        var obj = jQuery.parseJSON(res);
                        if(obj.status!=0){
                          clearInterval(email_status);
                          swal({
                            title: "Success!",
                            text: "Email verified successfully!",
                            type: "success",
                            confirmButtonText: "Go to dashboard"
                          },
                          function(isConfirm){
                            if (isConfirm) {                         
                            }
                          });
                          $('.swal2-confirm').click(function(){
                           window.location.href=base_url+"dashboard";  
                         });

                        }                
                      });
                    }


                    var email_status =   setInterval(function(){ get_email_status(); }, 2000);
                  }else{

                   swal({
                    title: "Success!",
                    text: "Email verified successfully!",
                    type: "success",
                    confirmButtonText: "Go to dashboard"
                  },
                  function(isConfirm){
                    if (isConfirm) {    

                    }
                  }); 

                   $('.swal2-confirm').click(function(){
                     window.location.href=base_url+"dashboard";  
                   });

                 }
               }
             });
              return false;


            <?php } ?>










          });












$('#mobile_verify_form').bootstrapValidator({
  fields: {
    country_code: {
      validators: {
        notEmpty: {
          message: 'Select country code '
        }
      }
    },
    mobile_number: {
      validators: {
        stringLength: {
          min: 10,
          max: 15,
          message: 'Mobile number should be more than 10 digit and maximum 15 digit'
        },
        notEmpty: {
          message: 'The Mobile Number is required'
        }
      }
    }
  }
}) .on('success.form.bv', function(e) {
                                      // Prevent form submission
                                      e.preventDefault();
                                      var number  = $('#mobile_number').val();
                                      if(number == ''){ 
                                        $('#mobile_verify_form').submit();                                         
                                        return false;
                                      }
                                      var url = base_url+"welcome/send_otp";
                                      var formData = $('#mobile_verify_form').serialize();
                                      $.ajax({
                                        type:'POST',
                                        url:url,
                                        data:formData,
                                        success:function(response)
                                        {

                                          var obj = jQuery.parseJSON(response);

                                          if(obj.status)
                                          {
                                            $('#mobile_number').val('');
                                            $('#mobile_verify_form').css("display","none");
                                            $('#mobile_verify_code_form').css("display","block");
                                          }
                                          else
                                          {
                                            $('#error_msg').html(obj.message);
                                            $('#error_msg').css('display','block');
                                          }
                                        }
                                      })


                                    });


$('#mobile_verify_code_form').bootstrapValidator({
  fields: {
    verification_code: {
      validators: {
        notEmpty: {
          message: 'The Verification Code is required'
        }
      }
    }
  }
}) .on('success.form.bv', function(e) {
                                      // Prevent form submission
                                      e.preventDefault();
                                      var url = base_url+"welcome/check_otp";
                                      var formData = $('#mobile_verify_code_form').serialize();
                                      $.ajax({
                                        type:'POST',
                                        url:url,
                                        data:formData,
                                        success:function(response)
                                        {
                                          var obj = jQuery.parseJSON(response);
                                           //   console.log(response);
                                           if(obj.mobile_number){
                                             $('#mobile_verify_form,#mobile_verify_code_form,#mobile_title,#mobile_first_verify').css("display","none");
                                             $('#mobile_first_verify_success').css("display","block");

                                           }else{
                                             swal({
                                              title: 'Oops!',
                                              text: "Wrong OTP you entered!",
                                              type: 'warning',
                                              showCancelButton: true,
                                              confirmButtonColor: '#3085d6',
                                              cancelButtonColor: '#d33',
                                              confirmButtonText: 'Send again OTP!',
                                              confirmButtonClass: 'btn btn-success',
                                              cancelButtonText: 'No will try again!',
                                              cancelButtonClass: 'btn btn-danger',
                                              buttonsStyling: false,
                                              reverseButtons: true
                                            }).then((result) => {
                                              if (result.value) {

                                                swal(
                                                  'Success!',
                                                  'OTP sent to your mobile number.',
                                                  'success'
                                                  )
                                                $('.verify').attr('disabled',false);
                                                $.get(base_url+'welcome/send_again_otp',function(res){

                                                });


                                              }else if(result.dismiss === 'cancel'){
                                                $('.verify').attr('disabled',false);

                                              }
                                            })
                                          }
                                        }
                                      });

                                    });

$('.complete_signup').click(function(){
  window.location.href=base_url+"dashboard";
});


function showMobileData_again()
{

  $("#mobile_verify_form").css('display','block');
  $("#mobile_verify_code_form").css('display','none');

}



function check_mobile(mobile)
{
  if(mobile !== '')
  {
    $('#error_msg').html('');
  }
}

function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : evt.keyCode
  return !(charCode > 31 && (charCode < 48 || charCode > 57));
}


function resend_email(){
  $('.resend_email').html('Please wait sending email... ');
  $.get('<?php echo base_url() ?>user/resend_email',function(res){
    $('.resend_email').html('<button class="btn btn-primary" type="button" onclick="resend_email()">Resend Email</button>');
  });
}

function not_your_email()
{

  $('#email_id').val('');
  $('.help-block').text('');
  $('#email_verify').modal('show');
}

function validate_email(email)
{
  var filter = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  if (filter.test(email)) {
    return true;
  }
  else {
    return false;
  }
}


$('#hourly_rate').keyup(function(){
  if($(this).val() == 0 || $(this).val() == '0.00'){
    $(this).val('');
  }
});




function check_email(){
  var email   = $('#email_id').val();

  if(email == ''){

    $('.help-block').text('Enter valid email id!');
    return false;
  }


  if(email!=''){

    if(validate_email(email)){
      $('.help-block').text('');
      $.post('<?php echo base_url(); ?>user/check_useremail',{'email':email},function(res){
        var obj = jQuery.parseJSON(res);
        if(obj.valid){
          $('.new_mail').attr('disabled',false);
           //$('.help-block').text('email valid');
            // $('.mail_id').html('<strong>'+email+'</strong>');
            // $('#email_verify').modal('show');
          }else{
            $('.new_mail').attr('disabled',true);
            $('.help-block').html('<font color="red">Email id already exist</font>');
          }
        });
    }else{
      $('.new_mail').attr('disabled',true);
      $('.help-block').html('<font color="red">Enter valid email id</font>');
    }


  }else{
    $('.help-block').text('Enter valid email id!');
    return false;
  }
}

$('#email_verify').on('hidden.bs.modal', function () {
  $('.help-block').html('Enter valid mobile number');
})


$('.new_mail').click(function(){
  var email = $('#email_id').val();
  if(email == ''){
    $('.help-block').html('<font color="red">Enter valid email id</font>');
    return false;
  }
  $('#exampleInputEmail2').val(email);
  $('.mail_id').html('<strong>'+email+'</strong><br><a href="#" onclick="not_your_email()">Not your email?</a></strong>');
  $('#email_verify').modal('hide');
  $('.resend_email').html('Please wait sending email... ');
  swal(
    'Success!',
    'Confirmation mail sent to your mail id.',
    'success'
    )

  $.post('<?php echo base_url(); ?>user/update_new_email',{email:email},function(res){

    $('.resend_email').html('<button class="btn btn-primary" type="button" onclick="resend_email()">Resend Email</button>');
  });


});


$('.datepicker').bind('copy paste cut',function(e) { 
        e.preventDefault(); //disable cut,copy,paste
      });

$('.text').keypress(function (e) {
  var regex = new RegExp(/^[a-zA-Z\s]+$/);              
  var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
  if (regex.test(str)) {
    return true;
  }
  else {
    e.preventDefault();
    return false;
  }
});



function isRate(evt) {
 var charCode = (evt.which) ? evt.which : evt.keyCode;
 if (charCode != 46 && charCode > 31 
  && (charCode < 48 || charCode > 57))
  return false;
return true;
}



function isNumber(evt) {
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
  }
  return true;
}

history.pushState(null, null, '#');
window.addEventListener('popstate', function(event) {
 history.pushState(null, null, '#');
});

</script>

<script type="text/javascript">

  var _URL = window.URL || window.webkitURL;
  function validateFileType(){
    var fileName = document.getElementById("avatarInput").value;
    var idxDot = fileName.lastIndexOf(".") + 1;
    var file = document.getElementById("avatarInput").files[0];
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();

    img = new Image();
    img.src = _URL.createObjectURL(file);
    img.onload = function() 
    {         

      if(this.width <256 && this.height <256 ){
        alert('Please upload your picture with the minimum resolution of width x height( 256 x 256 ) ');
        $('#avatarInput').val('');
        $('#avatar-modal').modal('hide');
        return false;
      }


    };





    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
                              //TO DO
                               if (file.size > 2097152) // 2 mb for bytes.
                               {
                                alert("File size must under 2mb!");
                                $('#avatarInput').val('');
                                return false;
                              }


                            }else{
                              alert("Only jpg/jpeg and png files are allowed!");
                              $('#avatarInput').val('');
                              return false;
                            }   
                          }
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

                      </body>
                      </html>
