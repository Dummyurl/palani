
    <div class="profile-view-top">
        <div class="row">
            <div class="col-sm-9 col-xs-9">
                <div class="profile-section">
                    <div class="profile-top">
                        <div class="row">
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
                                $addr = $city.','.$countryname;
                            } 
                            ?>
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
                            <div class="col-md-3 col-sm-5 col-xs-12">
                                <div class="img-box">
                                    <a href="#" title="<?php echo $gurus['first_name']." ".$gurus['last_name']; ?>">

                                        <img src="<?php echo $img ?>" style="width:100%" class="img-responsive img-circle"></a>
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-7 col-xs-12">
                                    <div class="user-details">
                                        <div class="user-name"><a><?php echo $gurus['first_name']." ".$gurus['last_name']; ?></a></div>
                                        <h4 class="user-title"></h4>                                        
                                        <div class="user-phone"><i class="fa fa-phone"></i> <?php echo ($gurus['applicant_phone']) ? $gurus['applicant_phone'] : 'N/A'; ?></div>
                                        <div class="user-mail"><i class="fa fa-envelope"></i> <a href="mailto:<?php echo $gurus['email']; ?>"><?php echo ($gurus['email']) ? $gurus['email'] : 'N/A'; ?></a></div>
                                        <div class="user-education"><i class="fa fa-map-marker"></i> <?php echo $addr; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-3">
                    <div class="edit-btn text-right">
                        <a href="<?php echo base_url(); ?>user/profile_edit" class="btn btn-default" title="Edit Profile"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</a>
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
            ?>                
            </h5>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <h6>Date of birth</h6>
             <h5><?php echo ($gurus['dob']!='1970-01-01' && $gurus['dob']!='0000-00-00') ? date('d-m-Y',strtotime($gurus['dob'])) : 'N/A'; ?></h5>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <h6>Where did you hear about us??</h6>
            <h5><?php echo ($gurus['where_you_heard']) ? $gurus['where_you_heard'] : 'N/A'; ?></h5>
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

