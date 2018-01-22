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

// echo '<pre>';
// print_r($value);
// exit;


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

<div class="row totalbtn">
	<div class="col-sm-6 text-center">
    	<label for="stripe"><input type="radio" name="payment" id="stripe" value="stripe"> <img src="<?php echo base_url(); ?>assets/images/stripe.png"></label>
    </div>
    <div class="col-sm-6 text-center">
    	<label for="paypal"><input type="radio" name="payment" id="paypal" value="paypal"> <img src="<?php echo base_url(); ?>assets/images/paypal.png"></label>
    </div>
</div>
<div class="row totalbtn">
    <div class="col-lg-12"><button class="btn btn-primary pay_btn" pay="<?php echo $product['app_id']?>">Pay Now</button></div>
</div>

</div>

<script type="text/javascript">
  $(document).ready(function(){
  $('.pay_btn').click(function(){
    var gateway = $("input[name='payment']:checked"). val();
    if(gateway=='stripe'){

      window.location = '<?php echo base_url(); ?>user/pay_using_stripe/<?php echo base64_encode($product['app_id']); ?>';

    }else{      
    window.location = '<?php echo base_url(); ?>user/buy/<?php echo $product['app_id']?>';
    }
  })

  });
</script>