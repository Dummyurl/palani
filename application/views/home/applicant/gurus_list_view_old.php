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
                <label class="control-label">Subject</label>
                <select class="form-control" name="subject" id="subject">
                    <option value="">--Select--</option>   
                    <?php foreach($subjects as $s){
                        echo '<option value="'.$s->subject_id.'">'.$s->subject.'</option>';
                    } ?>                             
                </select> 
            </div>
            <div class="form-group">
                <label class="control-label">Course</label>
                <select class="form-control" name="course" id="course">
                    <option value="">--Select--</option>                                                       
                </select> 
            </div>          
            <div style="color:red;" id="search-error"></div>
            <div class="search-btn">
                <button class="btn btn-primary search-left" type="button" >Search</button>
            </div>
        </div>
    </div>
    <div class="col-sm-8 col-md-9 col-xs-12">
        <input class="pull-left form-control right_top_search" name="right_top_search" id="right_top_search" type="text" placeholder="Enter the mentor name " />
        <div id="right-search-content">
            <div class="widget">
                <div class="widget-heading widget-default b-b-0 clearfix">

                    <h3 class="widget-title pull-left" style=""><?php echo ($count > 0) ? $count : '0'; ?> Matches for your search</h3>
                    <div class="sort-by pull-right">
                        <div class="form-group">
                            <select class="select form-control ordering" >
                                <option value="">--Select--</option>
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

                        ?>
                        <a href="<?php echo base_url(); ?>mentor-profile/<?php echo $guru_list['username']; ?>" class="guru-list">
                            <div class="row">
                                <div class="col-sm-4 col-md-3 col-xs-12">
                                    <div class="guru-details text-center">                                    
                                     <div class="guru-img"><img src="<?php echo $img; ?>" height="100" width="100" alt="Guru" class="img-circle"></div>
                                     <div class="guru-name"><?php echo $guru_list['first_name']." ".$guru_list['last_name'] ; ?></div>
                                     <div class="guru-country"><?php echo $guru_list['country_name']; ?></div>
                                     <?php 


                                     if($guru_list['charge_type'] == 'charge'){ 
                                        ?>
                                        <div class="price">
                                            <span class="currency">$</span>
                                            <span class="amount"><?php echo ($guru_list['hourly_rate'] != '') ? $guru_list['hourly_rate'] : '0.00'; ?></span>/hour
                                        </div>
                                    <?php  }elseif($guru_list['charge_type'] == 'free'){   ?>
                                        <div class="price">
                                            <button class="btn btn-primary btn-xs">Free</button>
                                        </div>
                                    <?php }else{
                                        echo '<div class="price"></div>';
                                    }  ?>

                                </div>
                            </div>
                            <div class="col-sm-8 col-md-9 col-xs-12">							
                                <div class="guru-det">
                                 <h4 class="guru-title"><?php echo $guru_list['mentor_personal_message']; ?></h4>
                                 <div class="subject">Courses : 
                                    <?php 
                                    $where  = array('mentor_id'=>$guru_list['mentor_id']);
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
                            <!-- <p><?php echo $guru_list['mentor_job_desc']; ?></p> -->
                            <span class="read-more">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div> 
                    </div>
                </div>
            </a>
        <?php endforeach; endif;  ?>
        
   </div>

   <?php if($count > 5): ?>
            <div class="load-more-btn text-center">
               <button class="btn btn-default loadmore-a" data-page="2"><i class="fa fa-refresh"></i> Load More</button>
           </div>
       <?php endif; ?>

</div>
</div>
</div>
<?php else: ?>
    <?php $this->load->view('home/guru/gurus_list_view'); ?>
<?php endif; ?>
