<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">

<div class="paymentcontainer">
    <form action="" method="POST" id="payment-form" class="form-inline">
        <div class="paymentbox">
            <div class="paymenttitle">Stripe Payment</div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Card Number</label>
                        <input type="text" class="form-control cpy" data-stripe="number" placeholder="Valid Card Number" id="card_number" required>
                    </div>    	
                </div>
                <div class="col-xs-7">
                    <div class="form-group">
                        <label>Expiry Date</label>
                        <div class="row">
                            <div class="col-xs-6"><input type="text" class="form-control cpy" data-stripe="exp_month" placeholder="MM" required id="month" ></div>
                            <div class="col-xs-6"><input type="text" class="form-control cpy" data-stripe="exp_year" placeholder="YY" required id="year" ></div>
                        </div>
                    </div> 
                </div>
                <div class="col-xs-5">
                    <div class="form-group">
                        <label>CV CODE</label>
                        <input type="text" class="form-control cpy" data-stripe="cvc" placeholder="CV" required id="cv">
                    </div> 
                </div>
            </div>
        </div>
        
        <div class="paymentamount">
            Final Amount <span>$<?php echo $amount; ?><input type="hidden" class="form-control" id="amount" data-stripe="amount" required value="<?php echo $amount; ?>"></span>
        </div>
        
        <div class="paymentbutton"><input type="submit" class="submit btn btn-primary" value="Save Card"></div>
    </form>
    
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>

<script type="text/javascript">
	Stripe.setPublishableKey('pk_test_645yNawcY04jw6A4I5YUGOVc');
	$(function() {
	// alert();
	var $form = $('#payment-form');
	$form.submit(function(event) {
// Disable the submit button to prevent repeated clicks:
$form.find('.submit').prop('disabled', true);
$form.find('.submit').val('Please wait...');

// Request a token from Stripe:
Stripe.card.createToken($form, stripeResponseHandler);
// Prevent the form from being submitted:
return false;
});
});
	function stripeResponseHandler(status, response) {

		if (response.error) {			
			swal("Warning!", response.error.message, "error");
			$('.submit').prop('disabled', false);
			$('.submit').val('Pay');
		} else {		 	 	
			$.ajax({
				url: '<?=base_url('user/add_card_details');?>',
				data: {
					access_token : response.id,
				    amount : $('#amount').val(),
				    card_number : $('#card_number').val()					
				},
				type: 'POST',
				dataType: 'JSON',
				success: function(response){

					if(response.status == 200){
						swal({ 
          
          title: "Success!",      
          type: "success" ,
          icon: 'success',
          showConfirmButton:false,
          html:'<p>Card  details saved successfully! <br>Now you can chat with our guru.</p><p><a href="<?php echo base_url(); ?>messages" class="btn btn-primary">Go to Messages</a></p>',
        });

					setTimeout(function() {
						window.location.href="<?php echo base_url();?>messages";
					}, 3000);


					// 	swal({ 
					// 	title: "Success!",
					// 	text: "Payment successfully done !",
					// 	type: "success" ,
					// 	icon: 'success',
					// 	showConfirmButton:false
					// }).then(function(){
					// 	// window.location.href = '<?php echo base_url(); ?>user/pay_using_stripe/MQ==';
					// 	window.location.href = '<?php echo base_url(); ?>dashboard';
					// });
					$('.submit').prop('disabled', false);
					$('.submit').val('Pay');

					}else{

				swal("Warning!", response.error, "error");
				$('.submit').prop('disabled', false);
				$('.submit').val('Pay');


					}
					


		},
		error: function(error){
			swal("Warning!", error, "error");
			$('.submit').prop('disabled', false);
			$('.submit').val('Pay');
		}
	});

		}
	}

$('.cpy').bind("cut copy paste",function(e) {
   e.preventDefault();
	});

</script>

</body>
</html>
