<div class="row titlerow">
  <div class="col-sm-6">
   <h2>Payment</h2>
 </div>
 <div class="col-sm-6 text-right">
   <a onclick="history.back();" class="btn btn-default"><i aria-hidden="true" class="fa fa-angle-left"></i> Back</a>
 </div>
</div>
<?php  


// error_reporting(0);

function converToTz($time="",$toTz='',$fromTz='')
{           
  $date = new DateTime($time, new DateTimeZone($fromTz));
  $date->setTimezone(new DateTimeZone($toTz));
  $time= $date->format('Y-m-d H:i:s');
  return $time;
}



$pay_details =$this->session->userdata('payment_details'); ?>

<div class="payment_details">
	<div class="row">
		<div class="col-md-6">Guru Name</div>
		<div class="col-md-6"><?php echo $product['first_name'].' '.$product['last_name']; ?></div>
	</div>
	<div class="row">
   <div class="col-md-6">Date & Time</div>
   <div class="col-md-6">
     <?php $hour = 0;  ?>
     <?php foreach ($pay_details as $key => $value) { ?>
     <span class="display_date">
      <?php

      $from_date_time =  $value->date_value.' '.$value->start_time;
      $to_date_time =  $value->date_value.' '.$value->end_time;
      $from_timezone = $value->time_zone;                         
      $to_timezone = $this->session->userdata('time_zone');

      $from_date_time  = converToTz($from_date_time,$to_timezone,$from_timezone);
      $to_date_time = converToTz($to_date_time,$to_timezone,$from_timezone);

      $from_time  = date('h:i a',strtotime($from_date_time));
      $to_time  = date('h:i a',strtotime($to_date_time));



      echo  date('d-m-Y',strtotime($value->date_value)).' ';
      echo  date('g:i a',strtotime($from_time)).'-'.date('g:i a',strtotime($to_time)).'<br>'; 

      ?>

    </span>
    <?php $hour++; } ?>
  </div>
</div>

	<!-- <div class="row">

    	<div class="col-md-6">Time</div>

    	<div class="col-md-6"><?php echo date('g:i a',strtotime($this->session->userdata('schedule_time_start'))).'-'.date('g:i a',strtotime($this->session->userdata('schedule_time_end'))); ?></div>

    </div>
  -->
  <div class="row">
   <div class="col-md-6">Amount (hour)</div>
   <div class="col-md-6">$<?php echo $product['mentor_charge']; ?></div>
 </div>
 <div class="row">
   <div class="col-md-6">Hours</div>
   <div class="col-md-6"><?php echo $hour; ?></div>
 </div>
 <div class="row totalpay">
   <div class="col-md-6">Total</div>
   <div class="col-md-6">$<?php echo $product['mentor_charge'] * $hour; ?></div>
 </div>

 <input type="hidden" name="mentor_charge" value="<?php echo $product['mentor_charge']; ?>" id="mentor_charge">

 <!-- <div class="row totalbtn">
   <div class="col-sm-6 text-center">
     <label for="stripe"><input type="radio" name="payment" id="stripe" value="stripe"> <img src="<?php echo base_url(); ?>assets/images/stripe.png"></label>
   </div>
   <div class="col-sm-6 text-center">
     <label for="paypal"><input type="radio" name="payment" id="paypal" value="paypal"> <img src="<?php echo base_url(); ?>assets/images/paypal.png"></label>
   </div>
 </div> 
 <button class="btn btn-primary pay_btn" pay="<?php echo $product['app_id']?>">Pay Now</button> -->

 <?php  

//error_reporting(1);

 $where = array('user_id' => $this->session->userdata('applicant_id'));

 $cards  = $this->db->group_by('card')->order_by('card_id','desc')->get_where('card_details',$where)->result();

 
 if(!empty($cards)){

   foreach($cards as $c){
    echo '<label><input type="radio" name="card" value="'.$c->card_id.'">XXXX XXXX '.$c->card.'</label><br>';
  }

  echo '<label><input type="radio" name="card" value="card" >Other</label>
  <div class="row totalbtn">

  <div class="col-lg-12 text-center" id="proceed">
  <a href="'.base_url().'user/pay_using_stripe/'.base64_encode($product['app_id']).'" class="btn btn-primary pay_btn" >Proceed</a>
  </div>  
  <div class="col-lg-12 text-center" id="pay_now">
  <a href="javascript:void(0);" class="btn btn-primary pay_btn" id="pay_old_card">Proceed</a>
  </div>
  </div>';


}
else{


  echo '<div class="row totalbtn">
   <div class="col-lg-12 text-center">
  <a href="'.base_url().'user/pay_using_stripe/'.base64_encode($product['app_id']).'" class="btn btn-primary pay_btn" >Proceed</a>
  </div>  
  </div>';

} 


?>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#proceed').hide();         
    $('#pay_now').hide();   

    $('input[name=card]').click(function(){
      var val = $(this).val();            
      if(val=='card'){
       $('#proceed').show();         
       $('#pay_now').hide();         
     }else{
      $('#pay_now').show();        
      $('#proceed').hide();        
    }
  });
    

    $('#pay_old_card').click(function(){            
      var card_id = $("input[name='card']:checked"). val();      
      var mentor_charge = $("#mentor_charge"). val();      
      $.post('<?php echo base_url(); ?>user/old_card_details',{
        card_id:card_id,
        mentor_charge:mentor_charge
      },function(response){        
        swal({           
          title: "Success!",      
          type: "success" ,
          icon: 'success',
          showConfirmButton:false,
          html:'<p>Appoinment has been successfully booked.Now you can chat with our guru.</p><p><a href="<?php echo base_url(); ?>messages" class="btn btn-primary">Go to Messages</a></p>',
        });
        setTimeout(function() {
          window.location.href="<?php echo base_url();?>messages";
        }, 3000);

      });
    });



  });
</script>