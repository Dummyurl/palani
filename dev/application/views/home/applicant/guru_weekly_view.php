 
<?php 
$time_zone = $this->session->userdata('time_zone');
date_default_timezone_set($time_zone);
$date =  date('Y-m-d');
if($date >= $selected_date){
  $class = 'hidden';
}else{
  $class = '';
}

?>
<input type="hidden" name="pre_date" id="pre_date" class="form-control" value="<?php echo date('Y-m-d', strtotime($selected_date."-7 day")); ?>">
<input type="hidden" name="next_date" id="next_date" class="form-control" value="<?php echo date('Y-m-d', strtotime($selected_date."+7 day")); ?>">
<div class="tmgsleft <?php echo $class; ?>"  onclick="getSchedule(1)">
  <a href="javascript:void(0);" ><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
</div>
<div class="tmgsright"><a href="javascript:void(0);" onclick="getSchedule(2)"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></div>
<table class="table table-bordered">
  <thead>
    <tr>
      <?php  
                            // echo '<pre>';
                            // print_r($result);
                            // exit;
      $num = 7;
      for($i=0;$i<7;$i++) { ?>
      <th><?php echo date('l', strtotime($selected_date."+$i day")); ?><span class="tdate"><?php echo date('M d, Y', strtotime($selected_date."+$i day")); ?></span></th>
      <?php } ?>


    </tr>
  </thead>
  <tbody>
    <tr>
      <td> 
        <?php foreach ($result as $key => $value) { ?>
        <?php 

                               // echo $value['day_name'].'<br>';
                             //   echo date('l', strtotime($selected_date."+0 day")).'<br>';

        $date =  date('Y-m-d');


        ?>
        <?php if($value['day_name'] == date('l', strtotime($selected_date."+0 day"))) {

         $explode_1 = explode(',',$value['available']);
         if(is_array($explode_1)){
           foreach ($explode_1 as $index1 => $indexvalue1) {
            $explode_single1 = explode('-', $indexvalue1);
            $rep_start1 = str_replace('["',"", $explode_single1[0]);
            $rep_end1 = str_replace('"]',"", $explode_single1[1]);
            $rep_start1 = str_replace('"',"", $rep_start1);
            $rep_end1 = str_replace('"',"", $rep_end1);

            ?>

            <?php 
                                // = delted here to hide current time in this condition 




            if(date('Y-m-d H') <= date('Y-m-d H',strtotime($date.' '.$rep_start1))){ ?> 

            <?php $class =  get_booked_class($available_data,$rep_start1,$rep_end1,0); ?>
            <div class="<?php echo $class; ?>">
              <?php if($class == 'ttiming'){ ?>
              <a href="javascript:void(0)" class="selectday" data-date="<?php echo date('Y-m-d', strtotime($selected_date."+0 day")); ?>" data-day="<?php echo $value['day_name']; ?>" data-timezone="<?php echo $value['time_zone'] ?>" data-day-id="<?php echo $value['days_id']; ?>"  data-start-time="<?php echo $rep_start1; ?>" data-end-time="<?php echo $rep_end1; ?>"><?php echo date('h:i a',strtotime($rep_start1)); ?> - <?php echo date('h:i a',strtotime($rep_end1)); ?></a>
              <?php }else{ ?>
              <?php echo date('h:i a',strtotime($rep_start1)); ?> - <?php echo date('h:i a',strtotime($rep_end1)); ?>
              <?php } ?>
            </div>
            <?php      
          }
        } 
      } } ?>
      <?php } ?>
    </td>
    <td>
      <?php  foreach ($result as $key => $value) {



                                // echo '<pre>'; 
                                // print_r($value);
        ?>
        <?php if($value['day_name'] == date('l', strtotime($selected_date."+1 day"))) { 

          $explode_2 = explode(',',$value['available']);
          if(is_array($explode_2)){
           foreach ($explode_2 as $index2 => $indexvalue2) {
            $explode_single2 = explode('-', $indexvalue2);
            $rep_start2 = str_replace('["',"", $explode_single2[0]);
            $rep_end2 = str_replace('"]',"", $explode_single2[1]);
            $rep_start2 = str_replace('"',"", $rep_start2);
            $rep_end2 = str_replace('"',"", $rep_end2);

            ?>

            <?php $class =  get_booked_class($available_data,$rep_start2,$rep_end2,1); ?>
            <div class="<?php echo $class; ?>">
              <?php if($class == 'ttiming'){ ?>
              <a href="javascript:void(0)" class="selectday" data-date="<?php echo date('Y-m-d', strtotime($selected_date."+1 day")); ?>" data-day="<?php echo $value['day_name']; ?>"  data-timezone="<?php echo $value['time_zone'] ?>" data-day-id="<?php echo $value['days_id']; ?>"  data-start-time="<?php echo $rep_start2; ?>" data-end-time="<?php echo $rep_end2; ?>"><?php echo date('h:i a',strtotime($rep_start2)); ?> - <?php echo date('h:i a',strtotime($rep_end2)); ?></a>
              <?php }else{ ?>
              <?php echo date('h:i a',strtotime($rep_start2)); ?> - <?php echo date('h:i a',strtotime($rep_end2)); ?>
              <?php } ?>
            </div>
            <?php } } } ?>
            <?php } ?>
          </td>
          <td>
            <?php foreach ($result as $key => $value) { 


                                 // echo $value['day_name'].'<br>';
                                  //echo date('l', strtotime($selected_date."+2 day")).'<br>';


              ?>
              <?php if($value['day_name'] == date('l', strtotime($selected_date."+2 day"))) { 

               $explode_3 = explode(',',$value['available']);
               if(is_array($explode_3)){
                 foreach ($explode_3 as $index3 => $indexvalue3) {
                  $explode_single3 = explode('-', $indexvalue3);
                  $rep_start3 = str_replace('["',"", $explode_single3[0]);
                  $rep_end3 = str_replace('"]',"", $explode_single3[1]);
                  $rep_start3 = str_replace('"',"", $rep_start3);
                  $rep_end3 = str_replace('"',"", $rep_end3);
                  ?>
                  <?php $class =  get_booked_class($available_data,$rep_start3,$rep_end3,2); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if($class == 'ttiming'){ ?>
                    <a href="javascript:void(0)" class="selectday" data-date="<?php echo date('Y-m-d', strtotime($selected_date."+2 day")); ?>" data-day="<?php echo $value['day_name']; ?>"   data-timezone="<?php echo $value['time_zone'] ?>" data-day-id="<?php echo $value['days_id']; ?>"  data-start-time="<?php echo $rep_start3; ?>" data-end-time="<?php echo $rep_end3; ?>"><?php echo date('h:i a',strtotime($rep_start3)); ?> - <?php echo date('h:i a',strtotime($rep_end3)); ?></a>
                    <?php }else{ ?>
                    <?php echo date('h:i a',strtotime($rep_start3)); ?> - <?php echo date('h:i a',strtotime($rep_end3)); ?>
                    <?php } ?>
                  </div>
                  <?php } } } ?>
                  <?php } ?>
                </td>
                <td>
                 <?php foreach ($result as $key => $value) { ?>
                 <?php if($value['day_name'] == date('l', strtotime($selected_date."+3 day"))) { 

                   $explode_4 = explode(',',$value['available']);
                   if(is_array($explode_4)){
                     foreach ($explode_4 as $index4 => $indexvalue4) {
                      $explode_single4 = explode('-', $indexvalue4);
                      $rep_start4 = str_replace('["',"", $explode_single4[0]);
                      $rep_end4 = str_replace('"]',"", $explode_single4[1]);
                      $rep_start4 = str_replace('"',"", $rep_start4);
                      $rep_end4 = str_replace('"',"", $rep_end4);

                      ?>
                      <?php $class =  get_booked_class($available_data,$rep_start4,$rep_end4,3); ?>
                      <div class="<?php echo $class; ?>">
                        <?php if($class == 'ttiming'){ ?>
                        <a href="javascript:void(0)" class="selectday" data-date="<?php echo date('Y-m-d', strtotime($selected_date."+3 day")); ?>" data-day="<?php echo $value['day_name']; ?>"  data-timezone="<?php echo $value['time_zone'] ?>" data-day-id="<?php echo $value['days_id']; ?>"  data-start-time="<?php echo $rep_start4; ?>" data-end-time="<?php echo $rep_end4; ?>"><?php echo date('h:i a',strtotime($rep_start4)); ?> - <?php echo date('h:i a',strtotime($rep_end4)); ?></a>
                        <?php }else{ ?>
                        <?php echo date('h:i a',strtotime($rep_start4)); ?> - <?php echo date('h:i a',strtotime($rep_end4)); ?>
                        <?php } ?>
                      </div>
                      <?php } } } ?>
                      <?php } ?>
                    </td>
                    <td>
                     <?php foreach ($result as $key => $value) { ?>
                     <?php if($value['day_name'] == date('l', strtotime($selected_date."+4 day"))) { 

                       $explode_5 = explode(',',$value['available']);
                       if(is_array($explode_5)){
                         foreach ($explode_5 as $index5 => $indexvalue5) {
                          $explode_single5 = explode('-', $indexvalue5);
                          $rep_start5 = str_replace('["',"", $explode_single5[0]);
                          $rep_end5 = str_replace('"]',"", $explode_single5[1]);
                          $rep_start5 = str_replace('"',"", $rep_start5);
                          $rep_end5 = str_replace('"',"", $rep_end5);

                          ?>
                          <?php $class =  get_booked_class($available_data,$rep_start5,$rep_end5,4); ?>
                          <div class="<?php echo $class; ?>">
                            <?php if($class == 'ttiming'){ ?>
                            <a href="javascript:void(0)" class="selectday" data-date="<?php echo date('Y-m-d', strtotime($selected_date."+4 day")); ?>" data-day="<?php echo $value['day_name']; ?>"   data-timezone="<?php echo $value['time_zone'] ?>" data-day-id="<?php echo $value['days_id']; ?>"  data-start-time="<?php echo $rep_start5; ?>" data-end-time="<?php echo $rep_end5; ?>"><?php echo date('h:i a',strtotime($rep_start5)); ?> - <?php echo date('h:i a',strtotime($rep_end5)); ?></a>
                            <?php }else{ ?>
                            <?php echo date('h:i a',strtotime($rep_start5)); ?> - <?php echo date('h:i a',strtotime($rep_end5)); ?>
                            <?php } ?>
                          </div>
                          <?php } } } ?>
                          <?php } ?>
                        </td>
                        <td>
                         <?php foreach ($result as $key => $value) { ?>
                         <?php if($value['day_name'] == date('l', strtotime($selected_date."+5 day"))) { 

                           $explode_6 = explode(',',$value['available']);
                           if(is_array($explode_6)){
                             foreach ($explode_6 as $index6 => $indexvalue6) {
                              $explode_single6 = explode('-', $indexvalue6);
                              $rep_start6 = str_replace('["',"", $explode_single6[0]);
                              $rep_end6 = str_replace('"]',"", $explode_single6[1]);
                              $rep_start6 = str_replace('"',"", $rep_start6);
                              $rep_end6 = str_replace('"',"", $rep_end6);
                              ?>
                              <?php $class =  get_booked_class($available_data,$rep_start6,$rep_end6,5); ?>
                              <div class="<?php echo $class; ?>">
                                <?php if($class == 'ttiming'){ ?>
                                <a href="javascript:void(0)" class="selectday" data-date="<?php echo date('Y-m-d', strtotime($selected_date."+5 day")); ?>" data-day="<?php echo $value['day_name']; ?>"  data-timezone="<?php echo $value['time_zone'] ?>"  data-day-id="<?php echo $value['days_id']; ?>"  data-start-time="<?php echo $rep_start6; ?>" data-end-time="<?php echo $rep_end6; ?>"><?php echo date('h:i a',strtotime($rep_start6)); ?> - <?php echo date('h:i a',strtotime($rep_end6)); ?></a>
                                <?php }else{ ?>
                                <?php echo date('h:i a',strtotime($rep_start6)); ?> - <?php echo date('h:i a',strtotime($rep_end6)); ?>
                                <?php } ?>
                              </div>
                              <?php } } } ?>
                              <?php } ?>
                            </td>
                            <td>
                             <?php foreach ($result as $key => $value) { ?>
                             <?php if($value['day_name'] == date('l', strtotime($selected_date."+6 day"))) { 

                               $explode_7 = explode(',',$value['available']);
                               if(is_array($explode_7)){
                                 foreach ($explode_7 as $index7 => $indexvalue7) {
                                  $explode_single7 = explode('-', $indexvalue7);
                                  $rep_start7 = str_replace('["',"", $explode_single7[0]);
                                  $rep_end7 = str_replace('"]',"", $explode_single7[1]);
                                  $rep_start7 = str_replace('"',"", $rep_start7);
                                  $rep_end7 = str_replace('"',"", $rep_end7);
                                  ?>
                                  <?php $class =  get_booked_class($available_data,$rep_start7,$rep_end7,6); ?>
                                  <div class="<?php echo $class; ?>">
                                    <?php if($class == 'ttiming'){ ?>
                                    <a href="javascript:void(0)" class="selectday" data-date="<?php echo date('Y-m-d', strtotime($selected_date."+6 day")); ?>" data-day="<?php echo $value['day_name']; ?>"  data-timezone="<?php echo $value['time_zone'] ?>" data-day-id="<?php echo $value['days_id']; ?>"  data-start-time="<?php echo $rep_start7; ?>" data-end-time="<?php echo $rep_end7; ?>"><?php echo date('h:i a',strtotime($rep_start7)); ?> - <?php echo date('g:i a',strtotime($rep_end7)); ?></a>
                                    <?php }else{ ?>
                                    <?php echo date('h:i a',strtotime($rep_start7)); ?> - <?php echo date('h:i a',strtotime($rep_end7)); ?>
                                    <?php } ?>
                                  </div>
                                  <?php } } } ?>
                                  <?php } ?>
                                </td>

                              </tr>
                            </tbody>
                          </table>