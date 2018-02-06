<?php if($this->session->userdata('role') == 0): ?>
 <div class="row">
    <div class="col-sm-4 col-md-3 col-xs-12 leftsidebar">
        <div class="theiaStickySidebar">
            <h3 class="filter-title">Filters</h3>
            <div class="form-group">
                <label class="control-label">Gender</label>
                <select class="form-control" name="gender" id="gender">
                    <option value="">No Preference</option>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Admitted School</label>
                <input type="email" class="form-control" name="admitted_school" id="admitted_school">
            </div>
            <div class="form-group">
                <label class="control-label">School Offers Received</label>
                <input type="email" class="form-control" name="school_offer" id="school_offer">
            </div>
            <div class="form-group">
                <label class="control-label">Year of School currently in</label>
                <select class="form-control" name="school_year" id="school_year">
                    <option value="">Select Year</option>
                    <option value="1">First Year</option>
                    <option value="2">Second Year</option>
                    <option value="3">Third Year</option>
                    <option value="4">Fourth Year</option>
                    <option value="5">Fifth Year</option>
                </select>
            </div>
            <div style="color:red;" id="search-error"></div>
            <div class="search-btn">
                <button class="btn btn-primary search-left" type="button">Search</button>
            </div>

            <div class="profile-preview">
                <a class="btn btn-success btn-block" href="#" data-toggle="modal" data-target="#advancedsearch">Advanced Search</a>
            </div>
            
        </div>
    </div>
    <div class="col-sm-8 col-md-9 col-xs-12">
        <input class="pull-left form-control right_top_search" name="right_top_search" id="right_top_search" type="text" placeholder="Search..." />
        <div id="right-search-content">
            <div class="widget">
                <div class="widget-heading widget-default b-b-0 clearfix">

                    <h3 class="widget-title pull-left" style=""><?php echo ($count > 0) ? $count : '0'; ?> Matches for your search</h3>
                    <div class="sort-by pull-right">
                        <div class="form-group">
                            <select class="select form-control ordering" >
                                <option value="Rating">Rating</option>
                                <option value="Popular">Popular</option>
                                <option value="Latest">Latest</option>
                                <option value="Free">Free</option>
                            </select>
                        </div>
                    </div>
                    <div class="sort-text pull-right">
                        <span>Sort by</span>
                    </div>
                </div>
            </div>
            <div id="guru-list">
                <?php if(!empty($gurus)): ?>
                    <?php foreach($gurus as $guru_list):   ?>
                        <?php 




                        $profile_img = '';
                        if(isset($guru_list['profile_img'])&&!empty($guru_list['profile_img'])){
                            $profile_img = $guru_list['profile_img'];
                        }  
                        $social_profile_img = '';
                        if(isset($guru_list['picture_url'])&&!empty($guru_list['picture_url'])){
                            $social_profile_img = $guru_list['picture_url'];
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
                        $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';


    //     $img1 = '';
    // if($guru_list['picture_url'] != '')
    // {
    //     $img1 = $guru_list['picture_url'];

    // }
    // if($guru_list['profile_img'] != '')
    // {
    //     $file_to_check = FCPATH . '/assets/images/' . $guru_list['profile_img'];
    //     if (file_exists($file_to_check)) {
    //         $img1 = base_url() . 'assets/images/'.$guru_list['profile_img'];
    //     }
    // }
    //     $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';


                        ?>
                        <a href="<?php echo base_url(); ?>gurus-profile/<?php echo $guru_list['username']; ?>" class="guru-list">
                            <div class="row">
                                <div class="col-sm-4 col-md-3 col-xs-12">
                                    <div class="guru-details text-center">
                                     <?php $city = ($guru_list['city'] != '') ? $guru_list['city'] : ""; ?>
                                     <?php $countryname = ($guru_list['country_name'] != '' && $guru_list['city'] != '') ? ', '.$guru_list['country_name'] : $guru_list['country_name']; ?>
                                     <div class="guru-img"><img src="<?php echo $img; ?>" height="100" width="100" alt="Guru" class="img-circle"></div>
                                     <div class="guru-name"><?php echo $guru_list['first_name']." ".$guru_list['last_name'] ; ?></div>
                                     <div class="guru-country"><?php echo $city.$countryname; ?></div>
                                     <?php 

                                     if($guru_list['charge_type'] == 'charge' ){ 
                                        ?>
                                        <div class="price">
                                            <span class="currency">$</span>
                                            <span class="amount"><?php echo ($guru_list['mentor_charge'] != '') ? $guru_list['mentor_charge'] : '0.00'; ?></span>/hour
                                        </div>
                                        <?php  }else{  ?>
                                        <div class="price">
                                            <button class="btn btn-primary btn-xs">Free</button>
                                        </div>
                                        <?php }  ?>
                                    </div>
                                </div>
                                <div class="col-sm-8 col-md-9 col-xs-12">							
                                    <div class="guru-det">
                                     <h4 class="guru-title"><?php echo $guru_list['mentor_personal_message']; ?></h4>
                                     <div class="ratings">
                                       <?php for($i=1; $i<=5 ;$i++) {
                                         if($i <= $guru_list['rating_value']){
                                            ?>
                                            <i class="fa fa-star" style="color:#ffc513 !important;"></i>
                                            <?php }else{ ?>
                                            <i class="fa fa-star"></i>
                                            <?php } 
                                        } ?>

                                        <span class="rating-count"><?php echo ($guru_list['rating_value'] > 0) ? $guru_list['rating_value'] : '0'; ?></span>
                                        <span class="total-rating">(<?php echo ($guru_list['rating_count'] > 0) ? $guru_list['rating_count'] : '0'; ?>)</span>
                                    </div>
                                    <p><?php echo $guru_list['mentor_job_desc']; ?></p>
                                    <span class="read-more">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                </div> 
                            </div>
                        </div>
                    </a>
                <?php endforeach; endif;  ?>
                <?php if($count > 5): ?>
                    <div class="load-more-btn text-center">
                       <button class="btn btn-default loadmore-a" data-page="2"><i class="fa fa-refresh"></i> Load More</button>
                   </div>
               <?php endif; ?>
           </div>

       </div>

       <!-- Modal -->
       <div class="modal fade bs-example-modal-lg" id="advancedsearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Advanced Search</h3>
            </div>
            <form action="<?php echo base_url();?>user/advance_search_guru" method="post" id="advance_search_form">
               <input type="hidden" value="<?php echo set_value('mentor_gender',$this->input->post('mentor_gender')); ?>" id="mentor_gender_hidden">
               <input type="hidden" value="<?php echo set_value('mentor_school',$this->input->post('mentor_school')); ?>" id="mentor_school_hidden">
               <input type="hidden" value="<?php echo set_value('mentor_schools_applied',$this->input->post('mentor_schools_applied')); ?>" id="mentor_schools_applied_hidden">
               <input type="hidden" value="<?php echo set_value('mentor_current_year',$this->input->post('mentor_current_year')); ?>" id="mentor_current_year_hidden">
               <input type="hidden" value="<?php echo set_value('mentor_extracurricular_activities',$this->input->post('mentor_extracurricular_activities')); ?>" id="mentor_extracurricular_activities_hidden">
               <input type="hidden" value="<?php echo set_value('mentor_job_company',$this->input->post('mentor_job_company')); ?>" id="mentor_job_company_hidden">
               <input type="hidden" value="<?php echo set_value('mentor_job_title',$this->input->post('mentor_job_title')); ?>" id="mentor_job_title_hidden">
               <input type="hidden" value="<?php echo set_value('mentor_job_from_year',$this->input->post('mentor_job_from_year')); ?>" id="mentor_job_from_year_hidden">
               <input type="hidden" value="<?php echo set_value('mentor_about',$this->input->post('mentor_about')); ?>" id="mentor_about_hidden">
               <input type="hidden" value="<?php echo set_value('mentor_languages_speak',$this->input->post('mentor_languages_speak')); ?>" id="mentor_languages_speak_hidden">


               <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Gender</label>
                            <select class="form-control" name="mentor_gender" id="mentor_gender">
                                <option value="">No Preference</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Admitted School</label>
                            <input type="text" class="form-control" name="mentor_school" id="mentor_school">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">School Offers Received</label>
                            <input type="text" class="form-control" name="mentor_schools_applied" id="mentor_schools_applied">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Year of School currently in</label>
                            <select class="form-control" name="mentor_current_year" id="mentor_current_year">
                                <option value="">Select Year</option>
                                <option value="1">First Year</option>
                                <option value="2">Second Year</option>
                                <option value="3">Third Year</option>
                                <option value="4">Fourth Year</option>
                                <option value="5">Fifth Year</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Extracurricular activities involved in</label>
                            <input type="text" class="form-control" name="mentor_extracurricular_activities" id="mentor_extracurricular_activities">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Prior firm / Company names</label>
                            <input type="text" class="form-control" name="mentor_job_company" id="mentor_job_company">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Prior job titles</label>
                            <input type="text" class="form-control" name="mentor_job_title" id="mentor_job_title">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Years of professional experience</label>
                            <input type="text" class="form-control" name="mentor_job_from_year" id="mentor_job_from_year">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Geography</label>
                            <input type="text" class="form-control" name="mentor_about" id="mentor_about">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Languages spoken</label>
                            <input type="text" class="form-control" name="mentor_languages_speak" id="mentor_languages_speak">
                        </div>
                    </div>
                </div>
                <div style="color:red;display:none;" id="search-advance-error"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="advance_search" onclick="return validateSearch();">Search</button>
            </div>
        </form>
    </div>
</div>
</div>
<!-- Modal -->


</div>
</div>
<?php else: ?>
    <?php $this->load->view('home/guru/gurus_list_view'); ?>
<?php endif; ?>
