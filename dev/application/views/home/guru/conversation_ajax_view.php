<?php if(!empty($today_conversation)) : 

function converToTz($time="",$toTz='',$fromTz='')
{   
        // timezone by php friendly values
  $date = new DateTime($time, new DateTimeZone($fromTz));
  $date->setTimezone(new DateTimeZone($toTz));
  $time= $date->format('Y-m-d H:i:s');
  return $time;
}

// echo '<pre>';
// print_r($today_conversation);
// exit;

?>
<?php foreach($today_conversation as $conversation) : ?>
  <?php 

  $img1 = '';
  if($conversation['picture_url'] != '')
  {
    $img1 = $conversation['picture_url'];
    
  }
  if($conversation['profile_img'] != '')
  {
    $file_to_check = FCPATH . '/assets/images/' . $conversation['profile_img'];
    if (file_exists($file_to_check)) {
      $img1 = base_url() . 'assets/images/'.$conversation['profile_img'];
    }
  }
  $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
  
  ?>
  <div class="card-box callbox">
    <div class="row">
      <div class="col-sm-6">
        <div class="row">
          <div class="col-sm-3 text-center">
            <img class="img-circle" alt="Applicant" src="<?php echo $img; ?>" height="100" width="100">
          </div>
          <div class="col-sm-9">
            <h3><?php echo $conversation['first_name'].' '.$conversation['last_name']; ?></h3>
            
          </div>
        </div>

        <?php 
        $current_timezone = $conversation['time_zone'];               
        $old_timezone = $this->session->userdata('time_zone');               
        $invite_time  = converToTz($conversation['invite_date'].' '.$conversation['invite_time'],$old_timezone,$current_timezone);
        $invite_to  = converToTz($conversation['invite_date'].' '.$conversation['invite_end_time'],$old_timezone,$current_timezone);   
        $invite_date_real =  date('Y-m-d H:i:s', strtotime($invite_to . ' -45 minutes'));
        $invite_to_end_time =  date('Y-m-d H:i:s', strtotime($invite_to,'+15 minutes'));

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
        <input type="hidden" id="applicant_id" value="<?php echo base64_encode($conversation['app_id']) ?>"> 
      </div>      
      <div class="col-sm-6 text-center conversation_start<?php echo $conversation['invite_id']; ?>">           
         </div>
       </div>
     </div>

   <?php endforeach; ?>
 <?php else: ?>
  <p>No More Conversations</p>
<?php endif; ?>