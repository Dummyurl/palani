 <?php 

 if(!empty($gurus)): 

    // echo $this->db->last_query();
    foreach($gurus as $guru_list):  
        $img1 = '';
        if($guru_list['picture_url'] != '') {
            $img1 = $guru_list['picture_url'];
        }
        if($guru_list['profile_img'] != ''){
            $file_to_check = FCPATH . '/assets/images/' . $guru_list['profile_img'];
            if (file_exists($file_to_check)) {
                $img1 = base_url() . 'assets/images/'.$guru_list['profile_img'];
            }
        }
        $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
        ?>   
        <a href="<?php echo base_url(); ?>mentor-profile/<?php echo $guru_list['username']; ?>" class="guru-list">            
            <div class="row">
                <div class="col-sm-3 col-xs-4">
                    <div class="guru-details text-center">
                        <div class="guru-img"><img src="<?php echo $img; ?>" height="100" width="100" alt="Guru" class="img-circle"></div>
                        <div class="guru-name"><?php echo $guru_list['first_name']." ".$guru_list['last_name'] ; ?></div>
                        <div class="guru-country"><?php echo $guru_list['country']; ?></div>
                        <?php 
                        if($guru_list['charge_type'] == 'charge'){ 
                            ?>
                            <div class="price">
                                <span class="currency">$</span>
                                <span class="amount"><?php echo ($guru_list['hourly_rate'] != '') ? $guru_list['hourly_rate'] : '0.00'; ?></span>/hour
                            </div>
                        <?php  }elseif($guru_list['charge_type'] == 'free'){  ?>
                            <div class="price">
                                <button class="btn btn-primary btn-xs">Free</button>
                            </div>
                        <?php }  ?>

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
<?php if(!empty($loadcount)): ?>
    <div class="load-more-btn text-center">
     <button class="btn btn-default loadmore-a" data-page="<?php echo $loadcount; ?>"><i class="fa fa-refresh"></i> Load More</button>
 </div>
 <?php else: ?>
    <div class="load-more-btn text-center">No More Mentors</div>
    <?php endif; ?>