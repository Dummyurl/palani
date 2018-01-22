<?php if($this->session->userdata('applicant_id') != '' && $this->session->userdata('role') == 0): ?>
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
                                        <div class="user-phone"><i class="fa fa-user"></i>  <?php echo ($gurus['username'] !='') ? $gurus['username'] : 'N/A'; ?> (username)</div>
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
                        <a href="<?php echo base_url(); ?>user/dashboard?notify=true" class="btn btn-default" title="Edit Profile"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-view-bottom">
            <div class="row">
                <div class="col-xs-12">
                    <h6>A personal statement</h6>
                    <h5><?php echo ($gurus['applicant_personal_mess']!= '') ? $gurus['applicant_personal_mess']: 'N/A' ; ?></h5>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h6>Schools wanting to apply to?</h6>
                    <h5><?php echo ($gurus['applicant_school_apply']!= '') ? $gurus['applicant_school_apply']: 'N/A' ; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h6>What do you want to get out of the conversation?</h6>
                    <h5><?php echo ($gurus['applicant_out_of_conversation']!= '') ? $gurus['applicant_out_of_conversation']: 'N/A' ; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h6>What other extracurricular activities are you involved in at your college?</h6>
                    <h5><?php echo ($gurus['applicant_extracurricular']!= '') ? $gurus['applicant_extracurricular']: 'N/A' ; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h6>What HS did you go to?</h6>
                    <h5><?php echo ($gurus['applicant_hs']!= '') ? $gurus['applicant_hs']: 'N/A' ; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h6>Where are you from?</h6>
                    <h5><?php echo ($gurus['applicant_from']!= '') ? $gurus['applicant_from']: 'N/A' ; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h6>What countries did you live and work in?</h6>
                    <h5><?php echo ($gurus['applicant_live_and_work']!= '') ? $gurus['applicant_live_and_work']: 'N/A' ; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h6>What languages do you speak?</h6>
                    <h5><?php echo ($gurus['applicant_language_speak']!= '') ? $gurus['applicant_language_speak']: 'N/A' ; ?></h5>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h6>You Favorite Book, Movie, Business Book, Business Publication, Business Leader, Personal Role Model</h6>
                    <h5><?php echo ($gurus['applicant_favourites']!= '') ? $gurus['applicant_favourites']: 'N/A' ; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h6>Hobbies</h6>
                    <h5><?php echo ($gurus['applicant_hobbies']!= '') ? $gurus['applicant_hobbies']: 'N/A' ; ?></h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h6>Quotes</h6>
                    <h5><?php echo ($gurus['applicant_quotes']!= '') ? $gurus['applicant_quotes']: 'N/A' ; ?></h5>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php $this->load->view('home/guru/guru_profile'); ?>
    <?php endif; ?>