<style type="text/css">
.saved-cards h2, .others-card h2 {
  background: transparent;
  text-transform: uppercase;
  font-size: 18px;
  margin-top: 0px;
  color: #000000;
  font-weight: bold;
  border-bottom: 1px solid #b5b5b5;
  padding: 0px 0px 18px;
  margin: 0px 0px 20px;
}
.list-unstyled{margin-bottom: 0px;}
.saved-card-list{margin-top: 8px;}
.pay-amt p{font-size: 21px;font-weight: bold;margin-bottom: 0px;}
.inner-shadow-box .custom-label {
  width: 100%;
  max-width: 167px;
  font-weight: bold;
}
.border-top {
  border-top: 1px solid #b5b5b5;
}
</style>


<?php  

function converToTz($time="",$toTz='',$fromTz='')
{           
  $date = new DateTime($time, new DateTimeZone($fromTz));
  $date->setTimezone(new DateTimeZone($toTz));
  $time= $date->format('Y-m-d H:i:s');
  return $time;
}

$pay_details =$this->session->userdata('payment_details');

$img1 = '';
if($product['picture_url'] != ''){
  $img1 = $product['picture_url'];
}
if($product['profile_img'] != ''){
  $file_to_check = FCPATH . 'assets/images/' . $product['profile_img'];
  if (file_exists($file_to_check)) {
    $img1 = base_url() . 'assets/images/'.$product['profile_img'];
  }
}
$img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
?>
<div class="row">
  <div class="col-sm-12">
    <div class="ndashboxright mode-of-payment">
      <div class="row">
        <div class="col-sm-4 progressleft">
          <div class="card-sample">
            <img class="img img-circle img-responsive center-block sm-mb-32" src="<?php echo $img; ?>" />  
            <p><?php echo $product['first_name'].' '.$product['last_name']; ?></p>            
          </div>
        </div>
        <div class="col-sm-8">
          <div class="inner-shadow-box">
            <form class="form-inline form-pay-method" role="form">
              <fieldset>
                <legend>Mentor details</legend>
                <div class="form-group custom-form-grp ">
                  <div class="row">
                    <div class="col-sm-3">
                      <label class="control-label custom-label" for="guru-name">Mentor Name</label>
                    </div>
                    <div class="col-sm-7">

                      <span class="xs-span">                    
                       <b><?php echo $product['first_name'].' '.$product['last_name']; ?></b>
                     </span>
                   </div>              
                 </div>    

               </div>
               <div class="clearfix"></div>
               <div class="form-group custom-form-grp ">
                <div class="row">
                  <div class="col-sm-3">
                    <label class="control-label custom-label" for="date-time">Date & Time</label>
                  </div>
                  <div class="col-sm-7">
                    <?php $hour = 0;  
                    foreach ($pay_details as $key => $value) { ?>

                      <?php

                      $from_date_time =  $value->date_value.' '.$value->start_time;
                      $to_date_time =  $value->date_value.' '.$value->end_time;
                      $from_timezone = $value->time_zone;                         
                      $to_timezone = $this->session->userdata('time_zone');

                      $from_date_time  = converToTz($from_date_time,$to_timezone,$from_timezone);
                      $to_date_time = converToTz($to_date_time,$to_timezone,$from_timezone);

                      $from_time  = date('h:i a',strtotime($from_date_time));
                      $to_time  = date('h:i a',strtotime($to_date_time));


                      echo '<span class="xs-span">'.date('d-m-Y',strtotime($value->date_value)).' '.date('g:i a',strtotime($from_time)).'-'.date('g:i a',strtotime($to_time)).'</span>';





                      ?>
                      <?php $hour++; } ?>

                    </div>                  
                  </div>







                </div>                                                
                <div class="clearfix"></div>
                <div class="form-group custom-form-grp ">
                  <div class="row">
                    <div class="col-sm-3">
                      <label class="control-label custom-label" for="amt">Amount (Per hour)</label>
                    </div>
                    <div class="col-sm-7">
                      <span class="xs-span">
                       <?php echo !empty($product['hourly_rate'])?'$'.$product['hourly_rate']:'N/A'; ?>
                     </span>
                   </div>                  
                 </div>


               </div>                                                
               <div class="clearfix"></div>
               <div class="form-group custom-form-grp ">
                <div class="row">
                  <div class="col-sm-3">
                    <label class="control-label custom-label" for="hours">Hours</label>
                  </div>
                  <div class="col-sm-7">
                    <span class="xs-span">
                      <?php echo $hour; ?>

                    </span>
                  </div>                
                </div>


              </div> 



              <div class="ot-total">
                <legend>Payment details</legend>
                <div class="ot-total-left">
                  <p>Call charge</p>
                </div>
                <div class="ot-total-right pull-right">
                  <span class="pull-right">$<?php echo $amount = $product['hourly_rate'] * $hour; ?></span>
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
               <div class="clearfix border-top"></div><br>
               <div class="ot-total-left">
                <p> Total</p>
              </div>
              <div class="ot-total-right pull-right">
                <span class="pull-right">$<?php echo $total_amount; ?></span>
              </div>
            </div>
          </fieldset>
          <input type="hidden" name="mentor_charge" value="<?php echo $product['hourly_rate']; ?>" id="mentor_charge">
        </form> 
      </div>
    </div>
  </div>
  <?php                                                                                      



  $where = array('user_id' => $this->session->userdata('applicant_id'));
  $cards  = $this->db->group_by('card')->order_by('card_id','desc')->get_where('card_details',$where)->result();
  if(!empty($cards)){

    $html = '<div class="row">
    <div class="col-sm-12">
    <div class="saved-cards sm-mt-14 inner-shadow-box">                                        
    <h2>Saved cards</h2>
    <div class="row">
    <div class="col-md-12 center-block no-float sm-mb-32">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false" >
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
    <div class="item active">      
    <div class="row custom-radios">';

    $i=0;

    foreach($cards as $c){
      $i++;
      if($c->type == 'Visa'){
        $card_img = 'saved-card-2.png';
      }elseif($c->type == 'MasterCard'){
        $card_img = 'saved-card-3.png';
      }else{
        $card_img = 'saved-card-1.png';
      }

      if($i%4 == 0){      
        $html .='</div>
        </div>
        <div class="item">      
        <div class="row custom-radios">';
      }


      $html .='<div class="col-sm-4">
      <div class="saved-card-style saved-card-list">
      <a href="#">
      <div class="row">
      <div class="col-sm-5">
      <ul class="list-unstyled list-inline">
      <li>                                                                            
      <input type="radio" class="animate-radio" id="savecard-'.$i.'" name="card" value="'.$c->card_id.'" >
      <label for="savecard-'.$i.'">
      <span></span>&nbsp;
      </label></li>
      <li>
      <img class="img img-responsive" src="'.base_url().'assets/images/'.$card_img.'" />
      </li>
      </ul>
      </div>
      <div class="col-sm-7">
      <ul class="list-unstyled text-right">
      <li><small>**** **** **** '.$c->card.'</small></li>
      <li><small>'.strtoupper($c->type).'</small></li>
      </ul>
      </div>                                                                                
      </div>
      </a>
      </div>
      </div>';

    }

    $html .=' </div>
    </div>
    </div>
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <img clas="img img-responsive" src="'.base_url().'assets/images/left-arrow.png" />
    <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <img clas="img img-responsive" src="'.base_url().'assets/images/right-arrow.png" />
    <span class="sr-only">Next</span>
    </a>
    </div>
    </div>
    </div>';
    echo $html;

    echo '<div class="row">
    <div class="col-sm-12">
    <div class="others-card">
    <h2>others</h2>

    <div class="row custom-radios">
    <div class="col-sm-4">
    <div class="saved-card-style">
    <a href="'.base_url().'user/pay_using_stripe/'.base64_encode($product['app_id']).'">
    <div class="row">
    <div class="col-sm-5">
    <ul class="list-unstyled list-inline">
    <li>                           
    <input type="radio" class="animate-radio" id="others-card" name="card" value="card">
    <label for="others-card">
    <span></span>&nbsp;
    </label></li>
    </ul>
    </div>
    <div class="col-sm-7 text-right">
    <ul class="list-unstyled">
    <li><small>**** **** **** ****</small></li>
    <li><small></small></li>
    </ul>
    </div>                                                                                
    </div>
    </a>
    </div>          
    </div> 
    <div class="col-sm-4">
    <div class="all-cards-type">
    <img class="img img-responsive" src="'.base_url().'assets/images/cc-icon.png" />
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>';


    echo '<div class="row totalbtn">
    <div class="col-lg-12 text-center" id="proceed">
    <a href="'.base_url().'user/pay_using_stripe/'.base64_encode($product['app_id']).'" class="btn btn-primary pay_btn" >Proceed for new card</a>
    </div>  
    <div class="col-lg-12 text-center" id="pay_now">
    <a href="javascript:void(0);" class="btn btn-primary pay_btn" id="pay_old_card">Proceed with selected saved card</a>
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


  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css">
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>mentori_assets/js/bootstrap.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>mentori_assets/js/appear.js"></script>
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
        $('.overlay').show();
        var card_id = $("input[name='card']:checked"). val();      
        var mentor_charge = $("#mentor_charge"). val();   


        $.post('<?php echo base_url(); ?>user/old_card_details',{
          card_id:card_id,
          mentor_charge:mentor_charge
        },function(response){
          $('.overlay').hide();        
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
