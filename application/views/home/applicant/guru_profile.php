<style type="text/css">
    .user-title{
        font-size: 14px;
    }
</style>
<div class="profile-view-top">
    <?php if($this->session->flashdata('success_message') != '') : ?>
  <div class="alert alert-success custom-alert"> <a href="#" class="close" data-dismiss="alert" aria-label="close">Hide</a> <?php echo $this->session->flashdata('success_message'); ?>. </div>
<?php endif; ?>
<div class="user_profile_section">
    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <div class="profile-section">
                <div class="profile-top">
                    <div class="row">
                        <div class="col-md-3 col-sm-5 col-xs-12">
                            <div class="img-box">
                             <?php
                             $currentuser = get_userdata();
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
                                <a href="#" title="<?php echo $gurus['first_name']." ".$gurus['last_name']; ?>">                                    <img alt="<?php echo $gurus['first_name']." ".$gurus['last_name']; ?>" class="img-responsive img-circle" src="<?php echo $img; ?>">                             </a>
                            </div>
                        </div>


                        <div class="col-md-9 col-sm-7 col-xs-12">
                            <div class="user-details">
                              <?php
                            $addr = '';
                            if(!empty($gurus['city'])){
                                    $addr .=  ucfirst($gurus['city']).' ';
                            }
                            if(!empty($gurus['state'])){
                                    $addr .= ucfirst($gurus['state']).' ';
                            }
                            if(!empty($gurus['country'])){
                                    $addr .= ucfirst($gurus['country']);
                            }

                            if(empty($addr)){
                                $addr = 'N/A';
                            }
                            ?>                  
                        
                                <div class="user-name">
                                    <h2><?php echo $gurus['first_name']." ".$gurus['last_name']; ?></h2>,
                                    <span><?php echo ($gurus['mentor_personal_message']) ? $gurus['mentor_personal_message'] : 'N/A'; ?></span>
                                    <div class="user-address"><i class="fa fa-map-marker"></i> <?php echo $addr; ?></div>
                                </div>
                                
                                <div class="subject">
                                    <strong>Courses :</strong>                                                              <?php 
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
                                <div class="user-phone"><i class="fa fa-phone"></i> <?php echo ($gurus['mobile_number']) ? '+'.$gurus['mobile_number'] : 'N/A'; ?></div>
                                <div class="user-mail"><i class="fa fa-envelope"></i> <a href="mailto:<?php echo $gurus['email']; ?>"><?php echo ($gurus['email']) ? $gurus['email'] : 'N/A'; ?></a></div>
                            </div>
                        </div>
                        <?php // exit; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-xs-12">
            <div class="edit-btn text-right">
                <a href="<?php echo base_url();?>user/edit_profile" class="btn btn-default" title="Edit Profile"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</a>
                <a href="<?php echo base_url(); ?>user/edit_course" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Course</a>
            </div>
        </div>          
    </div>
   

<div class="profile-view-bottom">
    <div class="row">
        <div class="col-sm-8">
            <div class="row">
                <div class="search-detail-title">
                    <h3>Personal Details</h3>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h6>Gender</h6>
                    <h5><?php
                     
                    if($gurus['mentor_gender']==1){echo  'Male';}
                    elseif($gurus['mentor_gender']==2){echo  'Female';}
                    else{ echo 'N/A' ; } ?>      </h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h6>Date of birth</h6>
                   <h5><?php 



                   if(!empty($gurus['dob']) && $gurus['dob']!='1970-01-01' && $gurus['dob']!='0000-00-00'){            
                    echo date('d-m-Y',strtotime($gurus['dob']));
                   }else{
                    echo 'N/A';
                   }
                   ?>
                   </h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h6>Where did you hear about us??</h6>
                    <h5><?php echo ($gurus['where_you_heard']) ? $gurus['where_you_heard'] : 'N/A'; ?></h5>
                </div>
            </div>
        </div>
    </div>   

    <div class="row">
        <div class="col-sm-8">         
            <div class="row">
                <div class="search-detail-title">
                    <h3>Qualifications</h3>
                </div>
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
            </div>
        </div>
    </div>            
    <div class="row">
        <div class="col-sm-8">
            <div class="row">
                <div class="search-detail-title">
                    <h3>Contact Details</h3>
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
                 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h6>Postal Code</h6>
                    <h5><?php echo ($gurus['postal_code'] != '') ? $gurus['postal_code'] : 'N/A'; ?></h5>
                </div>
            </div>
        </div>
    </div>

        </div>
    </div>
</div>
 <script type="text/javascript">
     $(".container").removeClass("dashboard-container");
 </script>