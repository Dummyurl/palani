<?php if(!empty($gurus)): ?>
    <?php foreach($gurus as $guru_list): ?>  
      <?php 
    $img1 = '';
    if($guru_list['picture_url'] != '')
    {
        $img1 = $guru_list['picture_url'];
        
    }
    if($guru_list['profile_img'] != '')
    {
        $file_to_check = FCPATH . '/assets/images/' . $guru_list['profile_img'];
        if (file_exists($file_to_check)) {
            $img1 = base_url() . 'assets/images/'.$guru_list['profile_img'];
        }
    }
        $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
     ?>   
<a href="<?php echo base_url(); ?>mentee-profile/<?php echo $guru_list['username']; ?>" class="guru-list">
                <div class="row">
                        <div class="col-lg-2 col-md-3 col-xs-4">
                                <div class="guru-details text-center">                                   
                                        <div class="guru-img"><img src="<?php echo $img; ?>" height="100" width="100" alt="Guru" class="img-circle"></div>
                                        <div class="guru-name"><?php echo $guru_list['first_name']." ".$guru_list['last_name']; ?></div>
                                        <div class="guru-country"><?php echo $guru_list['country']; ?></div>
                                </div>
                        </div>
                        <div class="col-lg-10 col-md-9 col-xs-8">
                                <p><?php echo $guru_list['mentor_personal_message']; ?></p>
                                <div class="subject">Courses :                                                              <?php 
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
                                <span class="read-more">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                </div>
        </a>
<?php endforeach; endif;  ?>
 <?php if(!empty($loadcount)): ?>
        <div class="load-more-btn text-center">
           <button class="btn btn-default loadmore-applicant" data-page="<?php echo $loadcount; ?>"><i class="fa fa-refresh"></i> Load More</button>
        </div>
<?php else: ?>
        <div class="load-more-btn text-center">No More Mentees</div>
<?php endif; ?>