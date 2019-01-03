<link href="<?php echo base_url(); ?>mentori_assets/css/custom.css" rel="stylesheet">
<style type="text/css">
  .ndashboxright{
  border-radius:none; 
  box-shadow: none; 
  }
  .alert:empty{
    display: none;
  }
</style>
 <div class="ndashboxright">
   <div class="alert alert-danger"></div>
   <div class="alert alert-success"></div>
   <div class="back-btn pull-right">
   <a href="<?php echo base_url(); ?>user/profile/<?php echo $result['app_id']; ?>" class="btn btn-default">Back </a>
   </div>
   <br>
   <div class="clearfix"></div> 
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
     <button class="btn btn-primary" type="button" onclick="onSubmit()">Update</button>
   </div>
 </form>
</div>

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
                 $('.alert-success').html('Course updated successfully!');
                 setTimeout(function() {
                   $('.alert-success').html('');
                    window.location.href="<?php echo base_url(); ?>user/profile/<?php echo $result['app_id'] ?>";
                 }, 1000);

               }

             });
                 //alert(course_count + " courses selected");
               }
             }
</script>
<script type="text/javascript">
  $(".container").removeClass("dashboard-container");
</script>