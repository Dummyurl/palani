<?php if($this->session->userdata('applicant_id') != '' && $this->session->userdata('role') == 0):  ?>
<div class="row welcomerow">
  <div class="col-sm-8">
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
    <h1>Welcome to School Guru, <?php echo $first_name . " " . $last_name; ?>!</h1>
  </div>
  <div class="col-sm-4">
    <div class="progress">
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


    $progress_value = number_format((float) ($count / $total) * 100, 0, '.', '');
    $applicant_school_apply_sts = "Y";
    if (isset($result['applicant_school_apply_sts']) && !empty($result['applicant_school_apply_sts'])) {
      $applicant_school_apply_sts = $result['applicant_school_apply_sts'];
    }
    $applicant_out_of_conversation_sts = "Y";
    if (isset($result['applicant_out_of_conversation_sts']) && !empty($result['applicant_out_of_conversation_sts'])) {
      $applicant_out_of_conversation_sts = $result['applicant_out_of_conversation_sts'];
    }
    $applicant_extracurricular_sts = "Y";
    if (isset($result['applicant_extracurricular_sts']) && !empty($result['applicant_extracurricular_sts'])) {
      $applicant_extracurricular_sts = $result['applicant_extracurricular_sts'];
    }
    $applicant_hs_sts = "Y";
    if (isset($result['applicant_hs_sts']) && !empty($result['applicant_hs_sts'])) {
      $applicant_hs_sts = $result['applicant_hs_sts'];
    }
    $applicant_from_sts = "Y";
    if (isset($result['applicant_from_sts']) && !empty($result['applicant_from_sts'])) {
      $applicant_from_sts = $result['applicant_from_sts'];
    }
    $applicant_live_and_work_sts = "Y";
    if (isset($result['applicant_live_and_work_sts']) && !empty($result['applicant_live_and_work_sts'])) {
      $applicant_live_and_work_sts = $result['applicant_live_and_work_sts'];
    }
    $applicant_language_speak_sts = "Y";
    if (isset($result['applicant_language_speak_sts']) && !empty($result['applicant_language_speak_sts'])) {
      $applicant_language_speak_sts = $result['applicant_language_speak_sts'];
    }
    $applicant_favourites_sts = "Y";
    if (isset($result['applicant_favourites_sts']) && !empty($result['applicant_favourites_sts'])) {
      $applicant_favourites_sts = $result['applicant_favourites_sts'];
    }
    $applicant_hobbies_sts = "Y";
    if (isset($result['applicant_hobbies_sts']) && !empty($result['applicant_hobbies_sts'])) {
      $applicant_hobbies_sts = $result['applicant_hobbies_sts'];
    }
    $applicant_quotes_sts = "Y";
    if (isset($result['applicant_quotes_sts']) && !empty($result['applicant_quotes_sts'])) {
      $applicant_quotes_sts = $result['applicant_quotes_sts'];
    }
    ?>
    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $progress_value; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $progress_value; ?>%"> <?php echo $progress_value; ?>% Complete </div>
  </div>
</div>
</div>

<?php 
if(!empty($_GET['notify'])){
  $menu = '<li ><a data-toggle="tab" href="#activity">Activity</a></li>
  <li class="active"><a data-toggle="tab" href="#editprofile">Edit Profile</a></li>
  
  <li><a data-toggle="tab" href="#account">Account</a></li>';
}
else if(!empty($_GET['account'])){
  $menu = '<li ><a data-toggle="tab" href="#activity">Activity</a></li>
  <li><a data-toggle="tab" href="#editprofile">Edit Profile</a></li>
  
  <li class="active"><a data-toggle="tab" href="#account">Account</a></li>';
}
else{
  $menu='<li class="active"><a data-toggle="tab" href="#activity">Activity</a></li>
  <li><a data-toggle="tab" href="#editprofile">Edit Profile</a></li>
  
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
  <?php if($this->session->flashdata('success_message') != ''): ?>
    <div id="profile_update_success">
      <div class="alert alert-success custom-alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">Hide</a> <?php echo $this->session->flashdata('success_message');?>.</div>
    </div>
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
            <div class="profile-right">
              <form id="applicant_profile_form">
                <div class="education-details">
                  <h4>Please update your details</h4>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Username <span>*</span></label>
                        <input type="text" class="form-control" name="username" id="username" value="<?php echo $user_name; ?>" required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Email <span>*</span></label>
                        <input type="email" class="form-control" name="applicant_email" id="applicant_email" value="<?php echo $email; ?>" required readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">First Name <span>*</span></label>
                        <input type="text" class="form-control" name="applicant_first_name" id="applicant_first_name" value="<?php echo $first_name; ?>" required >
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Last Name <span>*</span></label>
                        <input type="text" class="form-control" name="applicant_last_name" id="applicant_last_name" value="<?php echo $last_name; ?>" required >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Phone Number <span>*</span></label>
                        <input type="text" class="form-control" name="applicant_phone" id="applicant_phone" value="<?php echo $applicant_phone; ?>" required>
                      </div>
                    </div>
                    <div class="col-sm-6"></div>
                  </div>
                </div>
                <div class="bank-details">
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="form-group">
                        <label class="control-label">A personal message</label>
                        <textarea class="form-control" rows="3" name="applicant_personal_mess" id="applicant_personal_mess" ><?php echo $applicant_personal_mess; ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Schools wanting to apply to?</label>
                        <div class="shbox">
                          <div class="shinput">
                            <input type="text" class="form-control" name="applicant_school_apply" id="applicant_school_apply" value="<?php echo $applicant_school_apply; ?>" >
                          </div>
                          <div class="shbtns">
                            <div class="input-group">
                              <div class="btn-group radioBtn">
                                <?php
                                $visible = "active";
                                $invisible = "notActive";
                                if ($applicant_school_apply_sts == "N") {
                                  $visible = "notActive";
                                  $invisible = "active";
                                }
                                ?>
                                <a class="btn btn-primary btn-sm <?php echo $visible; ?> Visible" data-toggle="fun" data-value="applicant_school_apply_sts" data-title="Y">Show</a> <a class="btn btn-primary btn-sm <?php echo $invisible; ?> Invisible" data-toggle="fun" data-value="applicant_school_apply_sts" data-title="N">Hide</a> </div>
                                <input type="hidden" name="applicant_school_apply_sts" id="applicant_school_apply_sts" value="<?php echo $applicant_school_apply_sts; ?>">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="control-label">What do you want to get out of the conversation? </label>
                          <div class="shbox">
                            <div class="shinput">
                              <input type="text" class="form-control" name="applicant_out_of_conversation" id="applicant_out_of_conversation" value="<?php echo $applicant_out_of_conversation; ?>" >
                            </div>
                            <div class="shbtns">
                              <div class="input-group">
                                <div class="btn-group radioBtn">
                                  <?php
                                  $visible = "active";
                                  $invisible = "notActive";
                                  if ($applicant_out_of_conversation_sts == "N") {
                                    $visible = "notActive";
                                    $invisible = "active";
                                  }
                                  ?>
                                  <a class="btn btn-primary btn-sm <?php echo $visible; ?> Visible" data-toggle="fun" data-value="applicant_out_of_conversation_sts" data-title="Y">Show</a> <a class="btn btn-primary btn-sm <?php echo $invisible; ?> Invisible" data-toggle="fun" data-value="applicant_out_of_conversation_sts" data-title="N">Hide</a> </div>
                                  <input type="hidden" name="applicant_out_of_conversation_sts" id="applicant_out_of_conversation_sts" value="<?php echo $applicant_out_of_conversation_sts; ?>">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                          <div class="form-group">
                            <label class="control-label">What other extracurricular activities are you involved in at your college?</label>
                            <div class="shbox">
                              <div class="shtextarea">
                                <textarea rows="3" class="form-control" name="applicant_extracurricular" id="applicant_extracurricular" ><?php echo $applicant_extracurricular; ?></textarea>
                              </div>
                              <div class="shbtns">
                                <div class="input-group">
                                  <div class="btn-group radioBtn">
                                    <?php
                                    $visible = "active";
                                    $invisible = "notActive";
                                    if ($applicant_extracurricular_sts == "N") {
                                      $visible = "notActive";
                                      $invisible = "active";
                                    }
                                    ?>
                                    <a class="btn btn-primary btn-sm <?php echo $visible; ?> Visible" data-toggle="fun" data-value="applicant_extracurricular_sts" data-title="Y">Show</a> <a class="btn btn-primary btn-sm <?php echo $invisible; ?> Invisible" data-toggle="fun" data-value="applicant_extracurricular_sts" data-title="N">Hide</a> </div>
                                    <input type="hidden" name="applicant_extracurricular_sts" id="applicant_extracurricular_sts" value="<?php echo $applicant_extracurricular_sts; ?>">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">What HS did you go to?</label>
                              <div class="shbox">
                                <div class="shinput">
                                  <input type="text" class="form-control" name="applicant_hs" id="applicant_hs" value="<?php echo $applicant_hs; ?>" >
                                </div>
                                <div class="shbtns">
                                  <div class="input-group">
                                    <div class="btn-group radioBtn">
                                      <?php
                                      $visible = "active";
                                      $invisible = "notActive";
                                      if ($applicant_hs_sts == "N") {
                                        $visible = "notActive";
                                        $invisible = "active";
                                      }
                                      ?>
                                      <a class="btn btn-primary btn-sm <?php echo $visible; ?> Visible" data-toggle="fun" data-value ="applicant_hs_sts" data-title="Y">Show</a> <a class="btn btn-primary btn-sm <?php echo $invisible; ?> Invisible" data-toggle="fun" data-value ="applicant_hs_sts" data-title="N">Hide</a> </div>
                                      <input type="hidden" name="applicant_hs_sts" id="applicant_hs_sts" value="<?php echo $applicant_hs_sts; ?>">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label class="control-label">Where are you from?</label>
                                <div class="shbox">
                                  <div class="shinput">
                                    <input type="text" class="form-control" name="applicant_from" id="applicant_from" value="<?php echo $applicant_from; ?>" >
                                  </div>
                                  <div class="shbtns">
                                    <div class="input-group">
                                      <div class="btn-group radioBtn">
                                        <?php
                                        $visible = "active";
                                        $invisible = "notActive";
                                        if ($applicant_from_sts == "N") {
                                          $visible = "notActive";
                                          $invisible = "active";
                                        }
                                        ?>
                                        <a class="btn btn-primary btn-sm <?php echo $visible; ?> Visible" data-toggle="fun" data-value="applicant_from_sts" data-title="Y">Show</a> <a class="btn btn-primary btn-sm <?php echo $invisible; ?> Invisible" data-toggle="fun" data-value="applicant_from_sts" data-title="N">Hide</a> </div>
                                        <input type="hidden" name="applicant_from_sts" id="applicant_from_sts" value="<?php echo $applicant_from_sts; ?>">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label class="control-label">What countries did you live and work in?</label>
                                  <div class="shbox">
                                    <div class="shinput">
                                      <input type="text" class="form-control" name="applicant_live_and_work" id="applicant_live_and_work" value="<?php echo $applicant_live_and_work; ?>" >
                                    </div>
                                    <div class="shbtns">
                                      <div class="input-group">
                                        <div class="btn-group radioBtn">
                                          <?php
                                          $visible = "active";
                                          $invisible = "notActive";
                                          if ($applicant_live_and_work_sts == "N") {
                                            $visible = "notActive";
                                            $invisible = "active";
                                          }
                                          ?>
                                          <a class="btn btn-primary btn-sm <?php echo $visible; ?> Visible" data-toggle="fun" data-value="applicant_live_and_work_sts" data-title="Y">Show</a> <a class="btn btn-primary btn-sm <?php echo $invisible; ?> Invisible" data-toggle="fun" data-value="applicant_live_and_work_sts" data-title="N">Hide</a> </div>
                                          <input type="hidden" name="applicant_live_and_work_sts" id="applicant_live_and_work_sts" value="<?php echo $applicant_live_and_work_sts; ?>">
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label class="control-label">What languages do you speak?</label>
                                    <div class="shbox">
                                      <div class="shinput">
                                        <input type="text" class="form-control" name="applicant_language_speak" id="applicant_language_speak" value="<?php echo $applicant_language_speak; ?>" >
                                      </div>
                                      <div class="shbtns">
                                        <div class="input-group">
                                          <div class="btn-group radioBtn">
                                            <?php
                                            $visible = "active";
                                            $invisible = "notActive";
                                            if ($applicant_language_speak_sts == "N") {
                                              $visible = "notActive";
                                              $invisible = "active";
                                            }
                                            ?>
                                            <a class="btn btn-primary btn-sm <?php echo $visible; ?> Visible" data-toggle="fun" data-value="applicant_language_speak_sts" data-title="Y">Show</a> <a class="btn btn-primary btn-sm <?php echo $invisible; ?> Invisible" data-toggle="fun" data-value="applicant_language_speak_sts" data-title="N">Hide</a> </div>
                                            <input type="hidden" name="applicant_language_speak_sts" id="applicant_language_speak_sts" value="<?php echo $applicant_language_speak_sts; ?>">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-xs-12">
                                    <div class="form-group">
                                      <label class="control-label">Your Favorite Book, Movie, Business Book, Business Publication, Business Leader, Personal Role Model </label>
                                      <div class="shbox">
                                        <div class="shtextarea">
                                          <textarea rows="3" class="form-control" name="applicant_favourites" id="applicant_favourites"><?php echo $applicant_favourites; ?></textarea>
                                        </div>
                                        <div class="shbtns">
                                          <div class="input-group">
                                            <div class="btn-group radioBtn">
                                              <?php
                                              $visible = "active";
                                              $invisible = "notActive";
                                              if ($applicant_favourites_sts == "N") {
                                                $visible = "notActive";
                                                $invisible = "active";
                                              }
                                              ?>
                                              <a class="btn btn-primary btn-sm <?php echo $visible; ?> Visible" data-toggle="fun" data-value="applicant_favourites_sts" data-title="Y">Show</a> <a class="btn btn-primary btn-sm <?php echo $invisible; ?> Invisible" data-toggle="fun" data-value="applicant_favourites_sts" data-title="N">Hide</a> </div>
                                              <input type="hidden" name="applicant_favourites_sts" id="applicant_favourites_sts" value="<?php echo $applicant_favourites_sts; ?>">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label class="control-label">Hobbies</label>
                                        <div class="shbox">
                                          <div class="shinput">
                                            <input type="text" class="form-control" name="applicant_hobbies" id="applicant_hobbies" value="<?php echo $applicant_hobbies; ?>" >
                                          </div>
                                          <div class="shbtns">
                                            <div class="input-group">
                                              <div class="btn-group radioBtn">
                                                <?php
                                                $visible = "active";
                                                $invisible = "notActive";
                                                if ($applicant_hobbies_sts == "N") {
                                                  $visible = "notActive";
                                                  $invisible = "active";
                                                }
                                                ?>
                                                <a class="btn btn-primary btn-sm <?php echo $visible; ?> Visible" data-toggle="fun" data-value="applicant_hobbies_sts" data-title="Y">Show</a> <a class="btn btn-primary btn-sm <?php echo $invisible; ?> Invisible" data-toggle="fun" data-value="applicant_hobbies_sts" data-title="N">Hide</a> </div>
                                                <input type="hidden" name="applicant_hobbies_sts" id="applicant_hobbies_sts" value="<?php echo $applicant_hobbies_sts; ?>">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-6">
                                        <div class="form-group">
                                          <label class="control-label">Quotes</label>
                                          <div class="shbox">
                                            <div class="shinput">
                                              <input type="text" class="form-control" name="applicant_quotes" id="applicant_quotes" value="<?php echo $applicant_quotes; ?>" >
                                            </div>
                                            <div class="shbtns">
                                              <div class="input-group">
                                                <div class="btn-group radioBtn">
                                                  <?php
                                                  $visible = "active";
                                                  $invisible = "notActive";
                                                  if ($applicant_quotes_sts == "N") {
                                                    $visible = "notActive";
                                                    $invisible = "active";
                                                  }
                                                  ?>
                                                  <a class="btn btn-primary btn-sm <?php echo $visible; ?> Visible" data-value="applicant_quotes_sts" data-toggle="fun" data-title="Y">Show</a> <a class="btn btn-primary btn-sm <?php echo $invisible; ?> Invisible" data-value="applicant_quotes_sts" data-toggle="fun" data-title="N">Hide</a> </div>
                                                  <input type="hidden" name="applicant_quotes_sts" id="applicant_quotes_sts" value="<?php echo $applicant_quotes_sts; ?>">
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="bank-details">
                                      <h4>Contact Details</h4>
                                      <div class="row">
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label class="control-label">Address Line 1</label>
                                            <input type="text" class="form-control" name="address_line1" id="mentor_quotes" value="<?php echo $address_line1; ?>">
                                          </div>
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label class="control-label">Address Line 2</label>
                                            <input type="text" class="form-control" name="address_line2" id="mentor_quotes" value="<?php echo $address_line2; ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <!-- Country  Master -->
                                      <input type="hidden" id="country_id" value="<?php echo $result['country_id']; ?>" disabled>
                                      <input type="hidden" id="state_id" value="<?php echo $result['state_id']; ?>" disabled>
                                      <input type="hidden" id="city_id" value="<?php echo $result['city_id']; ?>" disabled>

                                      <div class="row">                     
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label class="control-label">Country<span> *</span></label>
                                            <select class="form-control countries" name="country" id="country" required data-placeholder="Choose a Country"  tabindex="2" chosen-select>
                                              <option value="">Select Country</option>                      
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label class="control-label">State<span> *</span></label>
                                            <select class="form-control states" name="state" id="state" required>
                                              <option value="">Select State</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                       <div class="col-sm-6">
                                        <div class="form-group">
                                          <label class="control-label">City<span> *</span></label>
                                          <select class="form-control cities" name="city" id="city" required>
                                            <option value="">Select City</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-6">
                                        <div class="form-group">
                                          <label class="control-label">Postal Code<span> *</span></label>
                                          <input type="text" class="form-control" name="postal_code" id="postal_code" value="<?php echo $postal_code; ?>" required>
                                        </div>
                                      </div>
                                      <div class="col-sm-6"></div>
                                    </div>
                                  </div>
                                  <div class="submit-btn">
                                    <button type="submit" class="btn btn-primary save_btn">Save Profile</button>
                                  </div>
                                </form>
                              </div>
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
                    <div class="col-sm-6">
                      <h2>Activity History</h2>
                    </div>
                    <div class="col-sm-6 text-right">
                      <form class="titlerightsearch">
                        <input type="search" id="activity_search" placeholder="Search">
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
                      <div class="row" id="row_<?php echo $activity['invite_id']; ?>" >
                        <div class="col-sm-6">
                          <div class="jprfpic"> <a href="<?php echo base_url();?>view-user/<?php echo $activity['username']; ?>"><img src="<?php echo $img; ?>" class="img-circle" height="40" width="40"></a></div>
                          <div class="jprfname">
                            <h3><a href="<?php echo base_url();?>view-user/<?php echo $activity['username']; ?>"><?php echo $activity['first_name'].' '.$activity['last_name']; ?></a></h3>
                            <h4><?php echo $activity['mentor_personal_message']; ?></h4>
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


                            <li><a href="'.base_url().'view-guru/'.$activity['username'].'" >View</a></li>                                    

                            <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->                                     

                            </ul>                          

                            </div>'; 

                          }else{

                            $status = '<div class="dropdown">

                            <button class="btn-xs btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Pending

                            <span class="caret"></span></button>

                            <ul class="dropdown-menu">                              

                            <li><a href="'.base_url().'view-guru/'.$activity['username'].'" >View</a></li>      
                            <li><a href="javascript:void(0)"  onclick="confirmCancel('.$activity['invite_id'].','.$activity['invite_from'].')">Cancel</a></li>                                 

                            <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->   
                            </ul>

                            </div

                            </div>';

                          } 

                           $count = $this->db->get_where('call_logs',array('invite_id'=>$activity['invite_id']))->num_rows();
                           $rating_count = $this->db->get_where('review_ratings',array('invite_id'=>$activity['invite_id']))->num_rows();

                           // Before Call time with approved 

                          if($activity['approved'] == 1 && date('Y-m-d H:i:s') <  date('Y-m-d H:i:s', strtotime($from_date_time)) ){
                          
                            $status = '<div class="dropdown">
                             <button class="btn-xs btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Approved
                             <span class="caret"></span></button>
                             <ul class="dropdown-menu">
                             <li><a href="javascript:void(0)"  onclick="confirmCancel('.$activity['invite_id'].','.$activity['invite_from'].')">Cancel</a></li>                           
                             <li><a href="'.base_url().'view-guru/'.$activity['username'].'" >View</a></li>                                    
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
                             <li><a href="javascript:void(0)"  onclick="confirmCancel('.$activity['invite_id'].','.$activity['invite_from'].')">Cancel</a></li>                           
                             <li><a href="'.base_url().'view-guru/'.$activity['username'].'" >View</a></li>';

                             if(  $rating_count == 0 ){
                              $status .='<li id="li'.$activity['invite_id'].'"><a href="javascript:void(0)"  onclick="rate_call('.$activity['invite_id'].','.$activity['app_id'].')">Rate the Guru</a></li>';
                             }
                                                                  
                             $status .='</ul>
                             </div>';                                

                           }else{ // After Call time with Approve  without call logs 

                             $status = '<div class="dropdown">
                             <button class="btn-xs btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Incomplete
                             <span class="caret"></span></button>
                             <ul class="dropdown-menu">                                         
                             <li><a href="'.base_url().'view-guru/'.$activity['username'].'" >View</a></li>                                    
                             <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->                                     
                             </ul>
                             </div>';

                           }
                         }

                         if($activity['approved'] == 2) { 
                           $status = '<div class="dropdown">
                           <button class="btn-xs btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Cancelled <span class="caret"></span></button>  
                           <ul class="dropdown-menu">      
                           <li><a href="javascript:void(0)"  onclick="confirmCancel('.$activity['invite_id'].','.$activity['invite_from'].')">Cancel</a></li>    
                           <li><a href="'.base_url().'view-guru/'.$activity['username'].'" >View</a></li>      
                           <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->                                      
                           </ul>                          
                           </div>'; 

                         }

                         echo $status;

                         ?>
                       </div>
                     </div>
                   <?php endforeach; endif;
                   echo $links; 
                   ?>
                 </div>
               </div>
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
                    <div class="col-md-6">
                      <h2>Account</h2>
                    </div>
                    <div class="col-md-6">
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
                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-sm-4 spa_earned"><span>$<?php echo ($applicant->earned)?$applicant->earned:'0.00'; ?></span>Earned</div>
                    <div class="col-sm-4 spa_paid"><span>$4,000</span>Paid</div>
                    <div class="col-sm-4 spa_balance"><span>$2,800</span>Balance</div>
                    <div class="col-lg-12 spa_paynow"><a class="btn btn-primary">Payment Request</a></div>
                  </div>
                </div>
              </div>



              <div class="spa_conversations">
               <table id="datatable" class="table table-striped" style="width: 100% !important">
                <thead>
                  <tr>
                    <th>Guru Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Duration</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>  
            </div>
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



          <!--Delete Confirmation  Modal -->
          <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3>Confirmation</h3>
                </div>
                <div class="modal-body"> Are you sure you want to delete this detail?
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
          function rate_call(invite_id,mentor_id){
            $('#mentor_id').val(mentor_id);
            $('#invite_id').val(invite_id);
            $('#rating_modal').modal('show');
          }

          function confirmCancel(id){
            $('#hidden_idss').val(id);
            $('#cancel_modal').modal('show');
          }

          function cancel_activity(){
            var invite_id = $('#hidden_idss').val();
            $('#btn_'+invite_id).removeClass('btn-info').addClass('btn-danger').html('Cancelled <span class="caret"></span>');
            $.post('<?php echo base_url(); ?>user/cancel_activity',{invite_id:invite_id},function(res){
            });
          }

          function edit_account(){
            $('#edit_acc').modal('show');
          }
          function save_acount(){
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
              // console.log(res);
            });

                  // console.log('test');
                }

                function confirmDelete(id){
                  $('#hidden_id').val(id);
                  $('#delete_modal').modal('show');
                }
                function delete_activity(){
                  var invite_id = $('#hidden_id').val();
                  $.post('<?php echo base_url(); ?>user/delete_activity',{invite_id:invite_id},function(res){
                    $('#row_'+invite_id).hide('slow'); 
                  });
                }
              </script>              
            <?php else: ?>
              <?php $this->load->view('home/guru/dashboard'); ?>
            <?php endif; ?>
