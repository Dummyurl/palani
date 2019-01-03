<?php 



if($this->session->userdata('role') == 0): 


  $time_zone = $this->session->userdata('time_zone');
  date_default_timezone_set($time_zone);

  function converToTz($time="",$toTz='',$fromTz='')
  {           
    $date = new DateTime($time, new DateTimeZone($fromTz));
    $date->setTimezone(new DateTimeZone($toTz));
    $time= $date->format('Y-m-d H:i:s');
    return $time;
  }



  function get_booked_class($availabe_days,$start_time,$end_time,$day_value,$to_timezone)
  {
   $class = 'ttiming';
   if(!empty($availabe_days)){
     foreach ($availabe_days as $key => $value) {

      $from_timezone = $value['time_zone'];    
      $from_time = $value['invite_date'].' '.$value['invite_time'];
      $to_time = $value['invite_date'].' '.$value['invite_end_time'];
      $from_date_time  = converToTz($from_time,$to_timezone,$from_timezone);
      $to_date_time = converToTz($to_time,$to_timezone,$from_timezone);        

      if( date('H:i:s',strtotime($from_time)) == date('H:i:s',strtotime($start_time)) && date('H:i:s',strtotime($to_time))== date('H:i:s',strtotime($end_time)) && date('Y-m-d', strtotime($from_time)) ==date('Y-m-d', strtotime("+$day_value day")) && $value['cancelled'] == 0){
        $class = 'ttiming notavailable';
      }
    }
  }
  return $class;
}
?>
<div class="schedule-mentor">
<div class="row titlerow">
  <input type="hidden" name="mentor_id" id="mentor_id" value="<?php echo $gurus['app_id']; ?>">
  <div class="col-sm-5 col-xs-12 availalbe-timing">
    <h2><?php echo $gurus['first_name'].' '.$gurus['last_name']; ?>’s available timings</h2>
  </div>
  <div class="col-sm-5 col-xs-12 form-inline avail-time text-right">
   Date: <input type="text" name="schedule_date" id="choosedate" class="form-control">
   <input type="button" name="submit" value="Search" class="btn btn-primary" onclick="getSchedule('');">
   <div id="schedule_date_error"></div>
 </div>
  <div class="col-sm-2 col-xs-12 schedule-back text-right">           
    <a  class="btn btn-default" onclick="history.back();"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a>
  </div>
</div>

<div class="tmgschedule">
  <div class="tmgsleft hidden" onclick="getSchedule(1)"><a href="javascript:void(0);" ><i class="fa fa-chevron-left" aria-hidden="true"></i></a></div>
  <div class="tmgsright"><a href="javascript:void(0);" onclick="getSchedule(2)"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></div>
  <div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>

        <?php  
        
        $num = 7;
        for($i=0;$i<7;$i++) { ?>
          <th><?php echo date('l', strtotime($selected_date."+$i day")); ?><span class="tdate"><?php echo date('M d, Y', strtotime($selected_date."+$i day")); ?></span></th>
        <?php } ?>
        
      </tr>
    </thead>
    <tbody>
      <tr>
        <td> 
          <?php foreach ($result as $key => $value) { 

           


            $date =  date('Y-m-d');   
            if($value['day_name'] == date('l', strtotime($selected_date."+0 day"))) {

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

                  $from_timezone = $value['time_zone'];                         
                  $to_timezone = $this->session->userdata('time_zone');
                  $from_time =  $selected_date.' '.$rep_start1;
                  $from_time =  converToTz($from_time,$to_timezone,$from_timezone);

                if(date('Y-m-d H') < $from_time){


                  $from_time =  $selected_date.' '.$rep_start1;
                  $to_time =  $selected_date.' '.$rep_end1;


                  $from_timezone = $value['time_zone'];                         
                  $to_timezone = $this->session->userdata('time_zone');


                  $from_date_time  = converToTz($from_time,$to_timezone,$from_timezone);
                  $to_date_time = converToTz($to_time,$to_timezone,$from_timezone);

                  $from_time  = date('h:i a',strtotime($from_date_time));
                  $to_time  = date('h:i a',strtotime($to_date_time));
                  $class =  get_booked_class($available_data,$rep_start1,$rep_end1,0,$to_timezone); 

              // echo '<pre>';print_r($available_data); exit;

                  ?>







                  <div class="<?php echo $class; ?>">
                    <?php if($class == 'ttiming'){ ?>
                      <a href="javascript:void(0)" class="selectday" data-date="<?php echo date('Y-m-d', strtotime($selected_date."+0 day")); ?>" data-day="<?php echo $value['day_name']; ?>" data-day-id="<?php echo $value['days_id']; ?>"  data-start-time="<?php echo $rep_start1; ?>" data-end-time="<?php echo $rep_end1; ?>" data-timezone="<?php echo $value['time_zone'] ?>" ><?php echo date('h:i a',strtotime($from_time)); // From time  ?> - <?php echo date('h:i a',strtotime($to_time)); // to time  ?></a>
                    <?php }else{ ?>
                      <?php echo date('h:i a',strtotime($from_time));// From time ?> - <?php echo date('h:i a',strtotime($to_time)); // to time  ?>
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



                $from_time =  $selected_date.' '.$rep_start2;
                $to_time =  $selected_date.' '.$rep_end2;


                $from_timezone = $value['time_zone'];                         
                $to_timezone = $this->session->userdata('time_zone');


                $from_date_time  = converToTz($from_time,$to_timezone,$from_timezone);
                $to_date_time = converToTz($to_time,$to_timezone,$from_timezone);

                $from_time  = date('h:i a',strtotime($from_date_time));
                $to_time  = date('h:i a',strtotime($to_date_time));




                ?>

                <?php $class =  get_booked_class($available_data,$rep_start2,$rep_end2,1,$to_timezone); ?>
                <div class="<?php echo $class; ?>">
                  <?php if($class == 'ttiming'){ ?>
                    <a href="javascript:void(0)" class="selectday" data-date="<?php echo date('Y-m-d', strtotime($selected_date."+1 day")); ?>" data-day="<?php echo $value['day_name']; ?>" data-day-id="<?php echo $value['days_id']; ?>"  data-start-time="<?php echo $rep_start2; ?>" data-end-time="<?php echo $rep_end2; ?>" data-timezone="<?php echo $value['time_zone'] ?>"><?php echo date('h:i a',strtotime($from_time)); ?> - <?php echo date('h:i a',strtotime($to_time)); ?></a>
                  <?php }else{ ?>
                    <?php echo date('h:i a',strtotime($from_time)); ?> - <?php echo date('h:i a',strtotime($to_time)); ?>
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



                  $from_time =  $selected_date.' '.$rep_start3;
                  $to_time =  $selected_date.' '.$rep_end3;


                  $from_timezone = $value['time_zone'];                         
                  $to_timezone = $this->session->userdata('time_zone');


                  $from_date_time  = converToTz($from_time,$to_timezone,$from_timezone);
                  $to_date_time = converToTz($to_time,$to_timezone,$from_timezone);

                  $from_time  = date('h:i a',strtotime($from_date_time));
                  $to_time  = date('h:i a',strtotime($to_date_time));



                  ?>
                  <?php $class =  get_booked_class($available_data,$rep_start3,$rep_end3,2,$to_timezone); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if($class == 'ttiming'){ ?>
                      <a href="javascript:void(0)" class="selectday" data-date="<?php echo date('Y-m-d', strtotime($selected_date."+2 day")); ?>" data-day="<?php echo $value['day_name']; ?>" data-day-id="<?php echo $value['days_id']; ?>"  data-start-time="<?php echo $rep_start3; ?>" data-end-time="<?php echo $rep_end3; ?>" data-timezone="<?php echo $value['time_zone'] ?>"><?php echo date('h:i a',strtotime($from_time)); ?> - <?php echo date('h:i a',strtotime($to_time)); ?></a>
                    <?php }else{ ?>
                      <?php echo date('h:i a',strtotime($from_time)); ?> - <?php echo date('h:i a',strtotime($to_time)); ?>
                    <?php } ?>
                  </div>
                <?php } } } ?>
              <?php } ?>
            </td>
            <td>
             <?php

             foreach ($result as $key => $value) { ?>
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
                    <?php $class =  get_booked_class($available_data,$rep_start4,$rep_end4,3,$to_timezone); ?>
                    <div class="<?php echo $class; ?>">
                      <?php if($class == 'ttiming'){ ?>
                        <a href="javascript:void(0)" class="selectday" data-date="<?php echo date('Y-m-d', strtotime($selected_date."+3 day")); ?>" data-day="<?php echo $value['day_name']; ?>" data-day-id="<?php echo $value['days_id']; ?>"  data-start-time="<?php echo $rep_start4; ?>" data-end-time="<?php echo $rep_end4; ?>" data-timezone="<?php echo $value['time_zone'] ?>"><?php echo date('h:i a',strtotime($rep_start4)); ?> - <?php echo date('h:i a',strtotime($rep_end4)); ?></a>
                      <?php }else{ ?>
                        <?php echo date('h:i a',strtotime($rep_start4)); ?> - <?php echo date('h:i a',strtotime($rep_end4)); ?>
                      <?php } ?>
                    </div>
                  <?php } } } ?>
                <?php } ?>
              </td>
              <td>
               <?php 

               foreach ($result as $key => $value) { ?>
                 <?php if($value['day_name'] == date('l', strtotime($selected_date."+4 day"))) { 

                   $explode_5 = explode(',',$value['available']);
                   if(is_array($explode_5)){
                     foreach ($explode_5 as $index5 => $indexvalue5) {
                      $explode_single5 = explode('-', $indexvalue5);
                      $rep_start5 = str_replace('["',"", $explode_single5[0]);
                      $rep_end5 = str_replace('"]',"", $explode_single5[1]);
                      $rep_start5 = str_replace('"',"", $rep_start5);
                      $rep_end5 = str_replace('"',"", $rep_end5);


                      $from_time =  $selected_date.' '.$rep_start5;
                      $to_time =  $selected_date.' '.$rep_end5;


                      $from_timezone = $value['time_zone'];                         
                      $to_timezone = $this->session->userdata('time_zone');


                      $from_date_time  = converToTz($from_time,$to_timezone,$from_timezone);
                      $to_date_time = converToTz($to_time,$to_timezone,$from_timezone);

                      $from_time  = date('h:i a',strtotime($from_date_time));
                      $to_time  = date('h:i a',strtotime($to_date_time));



                      ?>
                      <?php $class =  get_booked_class($available_data,$rep_start5,$rep_end5,4,$to_timezone); ?>
                      <div class="<?php echo $class; ?>">
                        <?php if($class == 'ttiming'){ ?>
                          <a href="javascript:void(0)" class="selectday" data-date="<?php echo date('Y-m-d', strtotime($selected_date."+4 day")); ?>" data-day="<?php echo $value['day_name']; ?>" data-day-id="<?php echo $value['days_id']; ?>"  data-start-time="<?php echo $rep_start5; ?>" data-end-time="<?php echo $rep_end5; ?>" data-timezone="<?php echo $value['time_zone'] ?>"><?php echo date('h:i a',strtotime($from_time)); ?> - <?php echo date('h:i a',strtotime($to_time)); ?></a>
                        <?php }else{ ?>
                          <?php echo date('h:i a',strtotime($from_time)); ?> - <?php echo date('h:i a',strtotime($to_time)); ?>
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


                        $from_time =  $selected_date.' '.$rep_start6;
                        $to_time =  $selected_date.' '.$rep_end6;


                        $from_timezone = $value['time_zone'];                         
                        $to_timezone = $this->session->userdata('time_zone');


                        $from_date_time  = converToTz($from_time,$to_timezone,$from_timezone);
                        $to_date_time = converToTz($to_time,$to_timezone,$from_timezone);

                        $from_time  = date('h:i a',strtotime($from_date_time));
                        $to_time  = date('h:i a',strtotime($to_date_time));



                        ?>
                        <?php $class =  get_booked_class($available_data,$rep_start6,$rep_end6,5,$to_timezone); ?>
                        <div class="<?php echo $class; ?>">
                          <?php if($class == 'ttiming'){ ?>
                            <a href="javascript:void(0)" class="selectday" data-date="<?php echo date('Y-m-d', strtotime($selected_date."+5 day")); ?>" data-day="<?php echo $value['day_name']; ?>" data-day-id="<?php echo $value['days_id']; ?>"  data-start-time="<?php echo $rep_start6; ?>" data-end-time="<?php echo $rep_end6; ?>" data-timezone="<?php echo $value['time_zone'] ?>"><?php echo date('h:i a',strtotime($from_time)); ?> - <?php echo date('h:i a',strtotime($to_time)); ?></a>
                          <?php }else{ ?>
                            <?php echo date('h:i a',strtotime($from_time)); ?> - <?php echo date('h:i a',strtotime($to_time)); ?>
                          <?php } ?>
                        </div>
                      <?php } } } ?>
                    <?php } ?>
                  </td>
                  <td>
                   <?php


                   foreach ($result as $key => $value) { ?>
                     <?php if($value['day_name'] == date('l', strtotime($selected_date."+6 day"))) { 

                       $explode_7 = explode(',',$value['available']);
                       if(is_array($explode_7)){
                         foreach ($explode_7 as $index7 => $indexvalue7) {
                          $explode_single7 = explode('-', $indexvalue7);
                          $rep_start7 = str_replace('["',"", $explode_single7[0]);
                          $rep_end7 = str_replace('"]',"", $explode_single7[1]);
                          $rep_start7 = str_replace('"',"", $rep_start7);
                          $rep_end7 = str_replace('"',"", $rep_end7);

                          $from_time =  $selected_date.' '.$rep_start7;
                          $to_time =  $selected_date.' '.$rep_end7;


                          $from_timezone = $value['time_zone'];                         
                          $to_timezone = $this->session->userdata('time_zone');


                          $from_date_time  = converToTz($from_time,$to_timezone,$from_timezone);
                          $to_date_time = converToTz($to_time,$to_timezone,$from_timezone);

                          $from_time  = date('h:i a',strtotime($from_date_time));
                          $to_time  = date('h:i a',strtotime($to_date_time));


                          ?>
                          <?php $class =  get_booked_class($available_data,$rep_start7,$rep_end7,6,$to_timezone); ?>
                          <div class="<?php echo $class; ?>">
                            <?php if($class == 'ttiming'){ ?>
                              <a href="javascript:void(0)" class="selectday" data-date="<?php echo date('Y-m-d', strtotime($selected_date."+6 day")); ?>" data-day="<?php echo $value['day_name']; ?>" data-day-id="<?php echo $value['days_id']; ?>"  data-start-time="<?php echo $rep_start7; ?>" data-end-time="<?php echo $rep_end7; ?>" data-timezone="<?php echo $value['time_zone'] ?>"><?php echo date('h:i a',strtotime($from_time)); ?> - <?php echo date('g:i a',strtotime($to_time)); ?></a>
                            <?php }else{ ?>
                              <?php echo date('h:i a',strtotime($from_time)); ?> - <?php echo date('h:i a',strtotime($to_time)); ?>
                            <?php } ?>

                          </div>
                        <?php } } } ?>
                      <?php } ?>
                    </td>

                  </tr>
                </tbody>
              </table>
            </div>
            </div>
            <input type="hidden" name="pre_date" id="pre_date" class="form-control" value="<?php echo date('Y-m-d', strtotime($selected_date."-7 day")); ?>">
            <input type="hidden" name="next_date" id="next_date" class="form-control" value="<?php echo date('Y-m-d', strtotime($selected_date."+7 day")); ?>">

            <input type="hidden" name="charge_type" id="charge_type" value="<?php echo $gurus['charge_type'] ?>">
            <input type="hidden" name="hourly_rate" id="hourly_rate" value="<?php echo $gurus['hourly_rate'] ?>">
            <?php if($gurus['charge_type'] == 'charge' && $gurus['hourly_rate'] != 0 && !empty($gurus['hourly_rate'])){?>

              <div class="tmgconfirmation">
                You have booked <strong>0 hour</strong> session <a href="javascript:void(0)" class="btn btn-primary" >Proceed to Pay <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
              </div>


              <?php   
            }elseif($gurus['charge_type'] == 'free' || $gurus['hourly_rate'] == 0 || $gurus['hourly_rate'] == ''){

              echo '<div class="tmgconfirmation">
              You have booked <strong>0 hour</strong> session <a href="javascript:void(0)" class="btn btn-primary" >Book Appoinment <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
              </div>';
            }  
          endif;         ?>
</div>