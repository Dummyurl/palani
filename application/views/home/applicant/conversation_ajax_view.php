<?php 

// echo '<pre>';
// print_r($today_conversation);

if(!empty($today_conversation)) : 

 function converToTz($time="",$toTz='',$fromTz='')
            {   
        // timezone by php friendly values
                $date = new DateTime($time, new DateTimeZone($fromTz));
                $date->setTimezone(new DateTimeZone($toTz));
                $time= $date->format('Y-m-d H:i:s');
                return $time;
            }

        
            $i = 0;
         foreach($today_conversation as $conversation) : 
          $i++;
          
    $img1 = '';
    if($conversation['picture_url'] != ''){
        $img1 = $conversation['picture_url'];        
    }
    if($conversation['profile_img'] != ''){
        $file_to_check = FCPATH . '/assets/images/' . $conversation['profile_img'];
        if (file_exists($file_to_check)) {
            $img1 = base_url() . 'assets/images/'.$conversation['profile_img'];
        }
    }
        $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
        
     ?>
    
  

<div class="card-box callbox">
    <div class="row">
        <div class="col-sm-6 col-md-8">
            <div class="row">
                <div class="col-sm-4 col-md-3 col-lg-2 text-center">
                    <img class="img-circle" alt="Guru" src="<?php echo $img; ?>" height="100" width="100">
                </div>
                <div class="col-sm-8 col-md-9 col-lg-10">
                    <h3><?php echo $conversation['first_name'].' '.$conversation['last_name']; ?></h3>                   
                </div>
            </div>
            <input type="hidden" id="mentor_image<?php echo $i; ?>" value="<?php echo $img; ?>">
            <input type="hidden" id="mentor_name<?php echo $i; ?>" value="<?php echo $conversation['first_name'].' '.$conversation['last_name']; ?>">
            <input type="hidden" id="logged_in<?php echo $i; ?>" value="<?php echo $conversation['logged_in']; ?>">
            <input type="hidden" id="mentor_username<?php echo $i; ?>" value="<?php echo $conversation['username']; ?>">
            <input type="hidden" id="mentor_user_id<?php echo $i; ?>" value="<?php echo $conversation['mentor_id']; ?>">
            

            <?php 
            
              $current_timezone = $conversation['time_zone'];               
              $old_timezone = $this->session->userdata('time_zone');               
              $invite_time  = converToTz($conversation['invite_date'].' '.$conversation['invite_time'],$old_timezone,$current_timezone);
              $invite_to  = converToTz($conversation['invite_date'].' '.$conversation['invite_end_time'],$old_timezone,$current_timezone);     
              $invite_date_real =  date('Y-m-d H:i:s', strtotime($invite_to . ' -45 minutes'));
              $invite_to_end_time =  date('Y-m-d H:i:s', strtotime($invite_to));




             ?>            
            <input type="hidden" value="<?php echo  $invite_to_end_time; ?>" class="invite_to_end_time">
            <input type="hidden" value="<?php echo  $invite_date_real; ?>" class="invite_date_real">
            <?php  $invite_time = date('Y-m-d H:i:s', strtotime($invite_time . ' -15 minutes')); ?>
            <input type="hidden" value="<?php echo  $invite_time; ?>" class="invite_date">
            <input type="hidden" value="<?php echo base64_encode($conversation['invite_id']); ?>" id="encoded_invite_id">
            <input type="hidden" value="<?php echo $conversation['invite_id']; ?>" class="invite_id">
            
            <input type="hidden" value="<?php echo  $invite_to; ?>" class="invite_to">
            <input type="hidden" id="callUserName" value="<?php echo base64_encode($conversation['username']); ?>">                 
             <input type="hidden" id="channel" value="<?php echo base64_encode($conversation['channel']) ?>">           
            <input type="hidden" id="mentor_id" value="<?php echo base64_encode($conversation['mentor_id']) ?>"> 
            <input type="hidden" id="receiver_id" value="<?php echo $conversation['mentor_id']; ?>"> 
        </div>        
        <div class="col-sm-6 col-md-4 text-center conversation_start<?php echo $conversation['invite_id']; ?> conversation_right">
           <?php  

           //if(date("Y-m-d g:i:s", strtotime($conversation['invite_date'].' '.$conversation['invite_time'])) <= date('Y-m-d g:i:s')): ?>
<!--                <div class="callbtn"><strong> Completed </strong></div>-->

           <?php //endif; ?>
        </div>
    </div>
</div>

<?php endforeach; ?>
<?php else: ?>
<p>No More Conversations</p>
<?php endif; ?>







