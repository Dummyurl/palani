<?php if(!empty($today_conversation)): 
error_reporting(1);

 function converToTz($time="",$toTz='',$fromTz='')

    {           

      $date = new DateTime($time, new DateTimeZone($fromTz));

      $date->setTimezone(new DateTimeZone($toTz));

      $time= $date->format('Y-m-d H:i:s');

      return $time;

    }



    ?> 
<?php foreach($today_conversation as $conversation): 



$from_timezone = $conversation['time_zone'];
$to_timezone = $this->session->userdata('time_zone');

 $from_date_time =  $conversation['invite_date'].' '.$conversation['invite_time'];
 $from_date_time  = converToTz($from_date_time,$to_timezone,$from_timezone);
 $from_time  = date('g:i a',strtotime($from_date_time));

?>
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
 <div class="row clpagebox">
         <div class="col-sm-10">
             <div class="clprfleft"><a href="<?php echo base_url(); ?>view-user/<?php echo $conversation['username']; ?>"><img src="<?php echo $img; ?> " class="img-circle" height="40" width="40"></a></div>
         <div class="clprfright">
             <h3><a href="<?php echo base_url(); ?>view-user/<?php echo $conversation['username']; ?>"><?php echo $conversation['first_name'].' '.$conversation['last_name']; ?></a></h3>
             <h4><?php //echo $conversation['applicant_personal_mess']; ?></h4>
         </div>
     </div>
     <div class="col-sm-2 text-right"><div class="clprftime"><?php echo $from_time; ?></div></div>
 </div>
<?php endforeach; ?>
<?php endif; ?>      