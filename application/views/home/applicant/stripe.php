<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">

       <div class="row">
            <div class="col-sm-12">
                <div class="ndashboxright paymet-flow">
                    <div class="row">
                        <div class="col-sm-6 col-md-4 progressleft">
                            <div class="card-sample enter-card-no">
                                <div class="card-wrapper"></div>
                                <!--<img class="img img-responsive center-block sm-mb-32" src="<?php echo base_url(); ?>assets/images/card-specimen.png" /> 
                                <img class="img img-responsive center-block" src="<?php echo base_url(); ?>assets/images/cc-icon.png" /> -->
                            </div>
                            <div class="acceptable-pyt hidden-xs">
                                <span class="acc-payment-title">Acceptable Payments :</span>
                                <span class="acc-payment-img"><img class="img img-responsive center-block" src="<?php echo base_url(); ?>assets/images/cc-icon.png" /></span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-5 enter-card-details">
                            <div class="entercard-cc">
                              <h3>STRIPE PAYMENT</h3>
                              <div class="form-container active enter-card-form">
                                  <form role="form" method="POST" id="payment-form">
                                      <div class="row">
                                          <div class="col-md-12">
                                              <lable>Card Number</lable>
                                              <div class="card-input">
                                                <input placeholder="Card number" type="text" name="number" class="cardno form-control" data-stripe="number"  id="card_number" required onkeypress="return isNumberKey(event)" autocomplete="off" >
                                                <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                                              </div> 
                                          </div>
                                      </div>
                                      <div class="row card-expiry-date">
                                          <div class="col-md-6">
                                              <lable>Card Expiry Date</lable>                                              
                                            <input type="text" size="4" class="cardno"   placeholder="MM" 
                                            onkeypress="return isNumberKey(event)" autocomplete="off" name="expiry" 
                                            data-stripe="exp_month" id="exp_month" maxlength="2"/>
                                            <span> / </span>
                                            <input type="text" size="4" maxlength="2" class="cardno"  placeholder="YY" 
                                             onkeypress="return isNumberKey(event)" autocomplete="off" name="expiry" id="exp_year" data-stripe="exp_year"/>
                                          </div> 
                                          <div class="col-md-6">
                                              <lable>CVV</lable>
                                              <input placeholder="CVC" type="password" name="cvc" class="cardno form-control" data-stripe="cvc"  id="cvv" required onkeypress="return isNumberKey(event)" autocomplete="off" maxlength="4" >
                                              <input type="hidden" class="form-control" id="amount" data-stripe="amount" required value="<?php echo $amount; ?>">
                                          </div>                                     
                                      </div>
                                      <div class="row">
                                          <div class="col-sm-6">
                                              <input type="submit" value="Approve Payment" class="button_postfix">
                                          </div>
                                          <!-- <div class="col-sm-6 hidden-xs hidden-md card-total-pricecard-total-price">
                                              <span>Total : $<?php echo $amount;?></span>
                                          </div> -->
                                      </div>
                                  </form>
                              </div>

                            <!--<div class="inner-shadow-box">
                                <form class="form-inline" role="form" method="POST" id="payment-form">
                                    <fieldset>
                                        <legend>Stripe payments</legend>
                                        <div class="form-group custom-form-grp ">
                                            <label class="control-label custom-label" for="card-number">Card Number</label>
                                            <span class="xs-span">
                                                <input type="text" class="form-control custom-lock-icon cpy" name="card-number"  placeholder="1234-1234-1234-1234" data-stripe="number"  id="card_number" required onkeypress="return isNumberKey(event)" autocomplete="off" >
                                                <i class="fa fa-lock"></i>
                                            </span>

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group custom-form-grp ">
                                            <label class="control-label custom-label" for="expiry-month">Expiry Date</label>
                                            <select class="form-control xs-custom-style xs-pull-left xs-mr-5 cpy" data-stripe="exp_month" required id="month"   maxlength="2">   
                                                <option value="">MM</option>
                                                <option value="01">Jan (01)</option>
                                                <option value="02">Feb (02)</option>
                                                <option value="03">Mar (03)</option>
                                                <option value="04">Apr (04)</option>
                                                <option value="05">May (05)</option>
                                                <option value="06">June (06)</option>
                                                <option value="07">July (07)</option>
                                                <option value="08">Aug (08)</option>
                                                <option value="09">Sep (09)</option>
                                                <option value="10">Oct (10)</option>
                                                <option value="11">Nov (11)</option>
                                                <option value="12">Dec (12)</option>
                                            </select>
                                            <select class="form-control xs-custom-style-mini cpy" data-stripe="exp_year"  required id="year" onkeypress="return isNumberKey(event)"  maxlength="2">                                     
                                                <option value="">YY</option>
                                                <option value="18">2018</option>
                                                <option value="19">2019</option>
                                                <option value="20">2020</option>
                                                <option value="21">2021</option>
                                                <option value="22">2022</option>
                                                <option value="23">2023</option>
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group custom-form-grp">
                                            <label class="control-label custom-label" for="cvv">CVV Code</label>
                                            <span class="xs-span">
                                                <input type="password" class="form-control custom-info-tooltip" id="cvv" placeholder="CVV"  data-stripe="cvc"  required id="cv" onkeypress="return isNumberKey(event)" maxlength="3">
                                                <i class="fa fa-info-circle custom-info-fa"></i>
                                            </span>
                                        </div>
                                        <div class="clearfix border-top"></div>
                                        <div class="form-group custom-form-grp bold-blk sm-mb-0 sm-mt-14">
                                            <label class="control-label custom-label xs-inline" for="total-amt">total</label></span>
                                            <span>$</span>
                                            <input type="number" class="form-control xs-inline" name="total-amt" id="total-amt" placeholder="total amount" value="<?php echo $amount; ?>" readonly>
                                        </div>                                                
                                    </fieldset>
                                    <input type="hidden" class="form-control" id="amount" data-stripe="amount" required value="<?php echo $amount; ?>">
                                    <br>
                                    <div class="paymentbutton" align="center">
                                       <input type="submit" class="submit btn btn-primary" value="Save Card">
                                   </div>
                               </form>                                           

                           </div>-->
                          </div>
                       </div>
                       <div class="col-md-3 order-total hidden-sm">
                            <h3>ORDER TOTAL</h3>                         
                            <div class="ot-total">
                                <div class="ot-total-left">
                                  <p>Call charge</p>
                                </div>
                                <div class="ot-total-right pull-right">
                                  <span class="pull-right">$<?php echo $amount; ?></span>
                                </div>
                            </div> <div class="ot-total">
                                <div class="ot-total-left">
                                  <p> GST (<?php echo GST ?>%)</p>
                                </div>
                                <?php
                                      $gst_amount = ($amount * GST)/100;
                                      $gst_amount = number_format($gst_amount,2);
                                      $total_amount = $gst_amount + $amount;
                                      $total_amount = number_format($total_amount,2);



                                      $amount_details = array(
                                          'per_hour_charge' => $amount,
                                          'tax_percentage' => GST,
                                          'tax_amount' => $gst_amount,
                                          'total_hours_charge' => $total_amount 
                                      );
                                      $this->session->set_userdata($amount_details);                                    

                                         ?>
                                <div class="ot-total-right pull-right">
                                  <span class="pull-right">$<?php echo  $gst_amount; ?></span>
                                </div>
                            </div>
                             <div class="ot-total">
                                <div class="ot-total-left">
                                  <p><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> Total</p>
                                </div>
                                <div class="ot-total-right pull-right">
                                  <span class="pull-right">$<?php echo $total_amount; ?></span>
                                </div>
                            </div>
                            <div class="secure-payment">
                              <img src="<?php echo base_url(); ?>assets/images/Secure.png" class="img-responsive" alt="">
                              <small>100% Secure Payment</small>
                              <a href="javascript:" onclick="history.back()"><i class="fa fa-angle-left" aria-hidden="true"></i> Go Back </a>
                            </div> 
                       </div>
                   </div>

               </div>
           </div>
       </div>


   <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
   <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css">
   <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>
   <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/payment-build.js"></script>
   <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/payment-card.js"></script>
   <script>
        $('code').each(function(i, e) {hljs.highlightBlock(e)});
        var card = new Card({ form: '.active form', container: '.card-wrapper' })
   </script>
   <script type="text/javascript">

   
     function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : evt.keyCode
      return !(charCode > 31 && (charCode < 48 || charCode > 57));
  }

    
  
  Stripe.setPublishableKey('<?php echo $this->config->item('stripe_publishable_key'); ?>');
  $(function() {
  // alert();
  var $form = $('#payment-form');
  $form.submit(function(event) {
    event.preventDefault();
    $('.overlay').show();
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
   $('.overlay').hide();    
     swal("Warning!", response.error.message, "error");
     $('.submit').prop('disabled', false);
     $('.submit').val('Pay');
 } else { 
  $('.overlay').show();     
  $.ajax({
    url: '<?=base_url('user/add_card_details');?>',
    data: {
       access_token : response.id,
       type : response.card.brand,
       amount : $('#amount').val(),
       card_number : $('#card_number').val()          
   },
   type: 'POST',
   dataType: 'JSON',
   success: function(response){
       $('.overlay').hide();
       if(response.status == 200){
          swal({ 

             title: "Success!",      
             type: "success" ,
             icon: 'success',
             showConfirmButton:false,
             html:'<p>Card  details saved successfully! <br>Now you can chat with our Mentor.</p><p><a href="<?php echo base_url(); ?>messages" class="btn btn-primary">Go to Messages</a></p>',
         });

          setTimeout(function() {
             window.location.href="<?php echo base_url();?>messages";
         }, 3000);


          //  swal({ 
          //  title: "Success!",
          //  text: "Payment successfully done !",
          //  type: "success" ,
          //  icon: 'success',
          //  showConfirmButton:false
          // }).then(function(){
          //  // window.location.href = '<?php echo base_url(); ?>user/pay_using_stripe/MQ==';
          //  window.location.href = '<?php echo base_url(); ?>dashboard';
          // });
          $('.submit').prop('disabled', false);
          $('.submit').val('Pay');

        }else{
           $('.overlay').hide();
          swal("Warning!", response.error, "error");
          $('.submit').prop('disabled', false);
          $('.submit').val('Pay');


        }
        


      },
      error: function(error){
          $('.overlay').hide();
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

