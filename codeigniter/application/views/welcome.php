
<script src="https://checkout.stripe.com/checkout.js"></script>
<button id="my_stripe_payyment">Purchase</button>
<script>
  var base_url = '<?php echo base_url(); ?>';

var handler = StripeCheckout.configure({
  key: 'pk_test_645yNawcY04jw6A4I5YUGOVc',
  image: 'https://www.school-guru.com/assets/images/schoolguru-onesignal.png',
  locale: 'auto',
  token: function(token,args) {    
    $('#access_token').val(token.id);
    $.ajax({    	
			url: base_url+'welcome/stripe_payment/',
			data: $('#payment-form').serialize(),			
			type: 'POST',
			dataType: 'JSON',
			success: function(response){
        console.log('test');
				// window.location.href = base_url+'user/buy_service/send_stripe_mail/'+response.payment_id;
			},
			error: function(error){
				// console.log(error);
			}
		});
  }
});
document.getElementById('my_stripe_payyment').addEventListener('click', function(e) {
	//final_gig_amount = (final_gig_amount * 100); //  dollar to cent 
  // Open Checkout with further options:
  handler.open({
    name: 'School Guru',
    description: 'Pay Andrew ',
    amount: 123
  });
 
  e.preventDefault();
});

// Close Checkout on page navigation:
window.addEventListener('popstate', function() {
  handler.close();
});
</script>