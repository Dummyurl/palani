   <style type="text/css">
              .notification_link:hover{
                    text-decoration: underline;
              }
            </style>

<script type="text/javascript">
  var base_url = '<?php echo base_url(); ?>';
</script>
<?php

$count = 0 ;
$total = 20 ;



$mentor_first_name = '';
$mentor_last_name = '';
$mentor_user_name = '';
$mentor_email = '';
$profile_img = '';
$social_profile_img = '';
$img1 = '';

if(!empty($result['first_name'])){$mentor_first_name = $result['first_name']; $count++ ; }
if(isset($result['last_name'])&&!empty($result['last_name'])){ $mentor_last_name = $result['last_name']; $count++ ; }
if(isset($result['email'])&&!empty($result['email'])){ $mentor_user_name = $result['email'];   $count++ ; }
if(isset($result['email'])&&!empty($result['email'])){   $mentor_email = $result['email']; $count++ ; }
if(isset($result['profile_img'])&&!empty($result['profile_img'])){ $profile_img = $result['profile_img']; }
if(isset($result['picture_url'])&&!empty($result['picture_url'])){ $social_profile_img = $result['picture_url']; }

if($social_profile_img != ''){ $img1 = $social_profile_img; }
if($profile_img != ''){
  $file_to_check = FCPATH . '/assets/images/' . $profile_img;
  if (file_exists($file_to_check)) {
    $img1 = base_url() . 'assets/images/'.$profile_img;
  }
}





if(!empty($img1)){
  $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
  $count++;
}else{
  $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
}





$mobile_number = '';
if(isset($result['mobile_number'])&&!empty($result['mobile_number'])){
  $mobile_number = $result['mobile_number'];
  $count++ ;
}

$dob = '';
if(isset($result['dob'])&&!empty($result['dob'])){
  $dob = $result['dob'];
  $count++ ;
}


$mentor_gender = '';
if(isset($result['mentor_gender'])&&!empty($result['mentor_gender'])){
  $mentor_gender = $result['mentor_gender'];
  $count++ ;
}

$hourly_rate = '';
if(isset($result['hourly_rate'])&&!empty($result['hourly_rate']))
{
  $hourly_rate = $result['hourly_rate'];
  $count++ ;
}


$mentor_personal_message = '';
if(isset($result['mentor_personal_message'])&&!empty($result['mentor_personal_message']))
{
  $mentor_personal_message = $result['mentor_personal_message'];
  $count++ ;
}



$address_line1 = '';
if(isset($result['address_line1'])&&!empty($result['address_line1']))
{
  $address_line1 = $result['address_line1'];
  $count++ ;
}
$address_line2 = '';
if(isset($result['address_line2'])&&!empty($result['address_line2']))
{
  $address_line2 = $result['address_line2'];
  $count++ ;
}

$country = '';
if(isset($result['country'])&&!empty($result['country']))
{
  $country = $result['country'];
  $count++ ;
}

$state = '';
if(isset($result['state'])&&!empty($result['state']))
{
  $state = $result['state'];
  $count++ ;
}

$city = '';
if(isset($result['city'])&&!empty($result['city']))
{
  $city = $result['city'];
  $count++ ;
}


$postal_code = '';
if(isset($result['postal_code'])&&!empty($result['postal_code']))
{
  $postal_code = $result['postal_code'];
  $count++ ;
}

$under_college = '';
if(isset($result['under_college'])&&!empty($result['under_college']))
{
  $under_college = $result['under_college'];
  $count++ ;
}

$under_major = '';
if(isset($result['under_major'])&&!empty($result['under_major']))
{
  $under_major = $result['under_major'];
  $count++ ;
}

$graduate_college = '';
if(isset($result['graduate_college'])&&!empty($result['graduate_college']))
{
  $graduate_college = $result['graduate_college'];
  $count++ ;
}

$degree = '';
if(isset($result['degree'])&&!empty($result['degree']))
{
  $degree = $result['degree'];
  $count++ ;
}

$progress_value =  number_format((float)($count/$total)*100, 0, '.', '');
?>

<!--Copy paste below code-->
<div class="container dashboard">
  <div class="row">
    <div class="col-sm-4">
      <div class="ndashboxleft">
        <div class="profilebox">
          <div class="profileleft">
            <img class="img-circle" src="<?php echo $img; ?>"  height="100" width="100">
          </div>
          <div class="profileright">
            <h4>Welcome Back,</h4>
            <h3><?php echo ucfirst($mentor_first_name)." ".$mentor_last_name; ?></h3>
            <div class="ratings">
              <?php $style = 'style="color:#ffc513 !important;"'; ?>
              <i  class="fa fa-star" <?php echo (@$rating->rating_value >= 1)?$style:''; ?>></i>                   
              <i  class="fa fa-star" <?php echo (@$rating->rating_value >= 2)?$style:''; ?>></i>                   
              <i  class="fa fa-star" <?php echo (@$rating->rating_value >= 3)?$style:''; ?>></i>                   
              <i  class="fa fa-star" <?php echo (@$rating->rating_value >= 4)?$style:''; ?>></i>                   
              <i  class="fa fa-star" <?php echo (@$rating->rating_value >= 5)?$style:''; ?>></i>                   
              <span class="total-rating"><?php echo !empty($rating->rating_value)?$rating->rating_value:0; ?></span>
              <span class="rating-count">(<?php echo !empty($rating->rating_count)?$rating->rating_count:0; ?>)</span>
              
            </div>
            <p><a href="<?php echo base_url(); ?>user/profile/<?php echo $this->session->userdata('applicant_id'); ?>">View Profile ></a></p>
          </div>
        </div>

        <h2>Payments</h2>
        <div class="inforow clearfix">
          <span class="pull-left">Total Earnings</span>
          <span class="pull-right">$0.00</span>
        </div>
        <div class="inforow clearfix">
          <span class="pull-left">Amount Paid</span>
          <span class="pull-right">$0.00</span>
        </div>
        <div class="inforow clearfix">
          <span class="pull-left">Amount Balance</span>
          <span class="pull-right">$0.00</span>
        </div>
        <div class="inforow clearfix">
          <span class="pull-left">Pay Percent</span>
          <span class="pull-right">0%</span>
        </div>
      </div>
    </div>
    <div class="col-sm-8">
      <div class="ndashboxright">
        <div class="row">
          <div class="col-sm-8 progressleft">
            <h3>Profile Progress</h3>
            <p>You must fully complete your profile for get the exact match</p>
          </div>
          <div class="col-sm-4">
            <div class="progress-cntr">
              <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: <?php echo $progress_value; ?>%;">
                  <div class="progresstip"><?php echo $progress_value; ?>%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <h2>Messages 
          <?php if(!empty($notification)){  ?>
          <span class="pull-right" id="view_all"><a href="#" onclick="see_all_notify()">View All</a>
          </span>
        <?php } ?>
        </h2>

        <script type="text/javascript">
          function see_all_notify(){
            $.get('<?php echo base_url(); ?>user/get_all_notification',function(res){
              $('.msgcontainer').html(res);
              $('#view_all').hide();
            });

          }
        </script>
        <div class="msgcontainer" <?php echo (empty($notification)?'align="center"':''); ?>>
          <?php
  

          function time_elapsed_string($datetime, $full = false) {
            $now = new DateTime;
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);

            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;

            $string = array(
              'y' => 'year',
              'm' => 'month',
              'w' => 'week',
              'd' => 'day',
              'h' => 'hour',
              'i' => 'minute',
              's' => 'second',
            );
            foreach ($string as $k => &$v) {
              if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
              } else {
                unset($string[$k]);
              }
            }

            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? implode(', ', $string) . ' ago' : 'just now';
          }


          $session_id = $this->session->userdata('applicant_id');


             if(!empty($notification)){
          foreach($notification as $notify ){


            if($notify['notification_id'] == $session_id ){
              $id = $notify['user_id'];
            }else{
              $id = $notify['notification_id'];
            }

            
            $user = $this->db->get_where('applicants',array('id' =>$id ))->row_array();
            $user_id = $notify['user_id'];
            $session_id = $this->session->userdata('applicant_id');            
            $msg= $notify['mentor_message'];

            if(!empty($user['profile_img'])){
              $profile_img = base_url() . 'assets/images/'.$user['profile_img'];
            }else{
              $profile_img = base_url() . 'assets/images/default-avatar.png';
            }



            ?>
            <div class="msgrow" id="note_<?php echo $notify['notify_id']; ?>">
              <div class="msgimg">
                <img class="img-circle" src="<?php echo $profile_img;?>" height="40" width="40"></div>
            <div class="msgcontent">
                <h3><a href="<?php echo base_url();?>mentee-profile/<?php echo $user['username']; ?>"><?php
               
                 $created_time = $notify['created_date'];
                 $fromTz = $notify['time_zone'];
                 $toTz = date_default_timezone_get();                 
                 $notify_datetime  = converToTz($created_time,$toTz,$fromTz);

                 echo $user['first_name'].' '.$user['last_name'];  ?> <span><?php 
                 echo time_elapsed_string($notify_datetime); 

                 ?></span></a></h3>
                <p><a href="#"> <?php echo $msg;  ?></a></p>
              </div>
                <div class="msgdelete"><a href="#" onclick="delete_notification(<?php echo $notify['notify_id']; ?>)"><img src="<?php echo base_url(); ?>mentori_assets/img/delete-icon.png"></a></div>
              </div>
            <?php } }else{
                echo 'No Messages';
              }?>

          </div>

          <script type="text/javascript">
            function delete_notification(notify_id){
              $('#hidden_notify_id').val(notify_id);
              $('#delete_notify_modal').modal('show');

            }
            function delete_notify(){
              var notify_id = $('#hidden_notify_id').val();
              $.post('<?php echo base_url(); ?>user/delete_mentor_notification',{notify_id:notify_id},function(res){
                $('#note_'+notify_id).remove();
              });
            }
          </script>

          <h2>Recent Activity</h2>
          <div class="actcontainer" <?php echo (empty($activity_list)?'align="center"':''); ?>>

            <?php

            if(!empty($activity_list)){

              foreach($activity_list as $activity):
                $img1 = '';
                if($activity['picture_url'] != ''){
                  $img1 = $activity['picture_url'];
                }
                if($activity['profile_img'] != ''){
                  $file_check = FCPATH . '/assets/images/' . $activity['profile_img'];
                  if (file_exists($file_check)) {
                    $img1 = base_url() . 'assets/images/'.$activity['profile_img'];
                  }
                }

                $img = ($img1 !='') ? $img1 : base_url() . 'assets/images/default-avatar.png';

                $from_date_time =  $activity['invite_date'].' '.$activity['invite_time'];
                $from_timezone =$activity['time_zone'];
                $to_timezone = $this->session->userdata('time_zone');
                $from_date_time  = converToTz($from_date_time,$to_timezone,$from_timezone);
                $from_time  = date('h:i a',strtotime($from_date_time));

              // echo '<pre>'; print_r($activity);
                ?>

                <div class="actrow">
                  <div class="row actrow-selected" id="row_<?php echo $activity['invite_id'];?>">
                    <div class="actimg">
                      <a href="<?php echo base_url().'view-user/'.$activity['username'] ?>"><img class="img-circle" src="<?php echo $img; ?>" height="40" width="40">
                         <span><?php echo $activity['first_name'].' '.$activity['last_name']; ?></span>
                       </a>
                      </div>
                      <div class="activity-date"><?php echo date('d-m-Y', strtotime($from_date_time)); ?></div>
                      <div class="activity-time"><?php echo date('h:i A', strtotime($from_time)); ?></div>                      
                      <div class="text-right actaction">
                        <?php

                        if($activity['approved'] == 0 && date('Y-m-d H:i:s') >  date('Y-m-d H:i:s', strtotime($from_date_time . ' +1 hour'))) {

                          $status = '<div class="dropdown">
                          <button class="btn-xs btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Cancelled <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                          <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>
                          </ul>
                          </div>';

                        }else{

                          $status = '<div class="dropdown">
                          <button class="btn-xs btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Pending
                          <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                          <li id="approve_'.$activity['invite_id'].'"><a href="javascript:void(0)"  onclick="confirmApprove('.$activity['invite_id'].','.$activity['invite_from'].')">Approve</a></li>
                          <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>
                          <li id="cancel_'.$activity['invite_id'].'"><a href="javascript:void(0)"  onclick="confirmCancel('.$activity['invite_id'].','.$activity['invite_from'].')">Cancel</a></li>
                          </ul>

                          </div

                          </div>';

                        }

                        $count = $this->db->get_where('call_logs',array('invite_id'=>$activity['invite_id']))->num_rows();

                           // Before Call time with approved

                        if($activity['approved'] == 1 && date('Y-m-d H:i:s') <  date('Y-m-d H:i:s', strtotime($from_date_time)) ){

                          $status = '<div class="dropdown">
                          <button class="btn-xs btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Approved
                          <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                          <li id="cancel_'.$activity['invite_id'].'"><a href="javascript:void(0)"  onclick="confirmCancel('.$activity['invite_id'].','.$activity['invite_from'].')">Cancel</a></li>
                          <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>
                          </ul>
                          </div>';

                        }
                        elseif($activity['approved'] == 1 && date('Y-m-d H:i:s') >  date('Y-m-d H:i:s', strtotime($from_date_time)) ){
                          // After Call time with Approve


                          // After Call time with Approve  with call logs
                         if($count>0){
                           $status = '<div class="dropdown">
                           <button class="btn-xs btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Finished
                           <span class="caret"></span></button>
                           <ul class="dropdown-menu">
                           <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>
                           </ul>
                           </div>';

                           }else{ // After Call time with Approve  without call logs

                             $status = '<div class="dropdown">
                             <button class="btn-xs btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Incomplete
                             <span class="caret"></span></button>
                             <ul class="dropdown-menu">
                             <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>
                             </ul>
                             </div>';

                           }
                         }

                         if($activity['approved'] == 2) {
                           $status = '<div class="dropdown">
                           <button class="btn-xs btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Cancelled <span class="caret"></span></button>
                           <ul class="dropdown-menu">
                           <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>
                           </ul>
                           </div>';

                         }

                         echo $status.'</div>
                         </div>
                         </div>';



                         ?>

                         <?php

                       endforeach;

                         echo $links; 

                     }else{

                      echo 'No Activity';

                     }



                     ?>

                   </div>
                 </div>
               </div>
             </div>
             <!--Copy paste code ends here-->




             <!-- Delete notify modal  -->
             <div class="modal fade" id="delete_notify_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3>Confirmation</h3>
                  </div>
                  <div class="modal-body"> Are you sure? you want to delete this notification ?
                    <input type="hidden" name="" id="hidden_notify_id">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="delete_notify()">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Delete notify modal  -->




            <!--Cancel Modal -->
            <div class="modal fade" id="cancel_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3>Confirmation</h3>
                  </div>
                  <div class="modal-body"> Are you sure? you want to cancel this request ?
                    <input type="hidden" name="" id="hidden_idss">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="cancel_activity()">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="approve_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3>Confirmation</h3>
                  </div>
                  <div class="modal-body"> Are you sure? you want to approve this call?
                    <input type="hidden" name="" id="hidden_ids">
                    <input type="hidden" name="" id="user_id">
                    <input type="hidden" name="" id="channel" >
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="approve_activity()">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal -->



          <script type="text/javascript">

            $(document).ready(function(){
              $('input[name="charge_type"]').click(function(){
                var radioValue = $("input[name='charge_type']:checked"). val();
                if(radioValue == 'free'){
                  $('#mentor_charge').attr('disabled',true);
                }else{
                  $('#mentor_charge').attr('disabled',false);
                }

              });


            });

            function edit_account()
            {
              $('#edit_acc').modal('show');
            }

            function save_acount()
            {
              var bank_name = $('.bank_name').val();
              var account_type = $('.account_type').val();
              var routing = $('.routing').val();
              var beneficiary_name = $('.beneficiary_name').val();
              var account_no = $('.account_no').val();


              $.ajax({
                url : base_url+'user/save_acount',
                type: "POST",
                data: $('#accounts_form').serialize(),
                dataType: "JSON",
                success: function(data)
                {

            if(data.status == true) //if success close modal and reload ajax table
            {
              $('#edit_acc').modal('hide');
              $('#bank_name').text(bank_name);
              $('#account_type').text(account_type);
              $('#routing').text(routing);
              $('#beneficiary_name').text(beneficiary_name);
              $('#account_no').text(account_no);
            }
            else
            {
              for (var i = 0; i < data.inputerror.length; i++)
              {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                  }
                }

              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                alert('Error adding / update data');

              }
            });

            }


            function confirmCancel(id){


              $('#hidden_idss').val(id);

              $('#cancel_modal').modal('show');

            }
            function confirmDelete(id){

              $('#hidden_id').val(id);

              $('#delete_modal').modal('show');

            }

            function delete_activity()

            {

              var invite_id = $('#hidden_id').val();

              $.post('<?php echo base_url(); ?>user/delete_activity',{invite_id:invite_id},function(res){

                $('#row_'+invite_id).hide('slow');

              });

            }
            function cancel_activity()
            {

              var invite_id = $('#hidden_idss').val();
              $('#btn_'+invite_id).removeClass('btn-info').addClass('btn-danger').html('Cancelled <span class="caret"></span>');
              $('#cancel_'+invite_id).remove();
              $.post('<?php echo base_url(); ?>user/cancel_activity',{invite_id:invite_id},function(res){


              });

            }



            function confirmApprove(id,user_id){
              var channel  = getUuid();
              $('#hidden_ids').val(id);
              $('#channel').val(channel);
              $('#user_id').val(user_id);
              $('#approve_modal').modal('show');

            }

                //Support functions
                function getUuid(){
                  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                    var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
                    return v.toString(16);
                  });
                }



                function approve_activity()

                {



                 var invite_id = $('#hidden_ids').val();
                 var user_id = $('#user_id').val();
                 var user_id = $('#user_id').val();
                 var channel = $('#channel').val();



                 $.post('<?php echo base_url(); ?>user/approve_activity',{channel:channel,user_id:user_id,invite_id:invite_id},function(res){
                  var obj = jQuery.parseJSON(res);
                  if(obj.error){

                    swal({
                      title: 'Want to cancel this call?',
                      text: "Already you have a call at this time!",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, cancel it!'
                    }).then((result) => {
                      if (result.value) {
                        $('#btn_'+invite_id).removeClass('btn-info')
                        .addClass('btn-danger')
                        .html('Cancelled <span class="caret"></span>');
                        $('#cancel_'+invite_id).remove();
                        $('#btn_'+invite_id).removeClass('btn-info').addClass('btn-success');
                        $('#approve_'+invite_id).remove();
                        swal(
                          'Cancelled!',
                          'Call has been canceled successfully.',
                          'success'
                          )
                        $.post('<?php echo base_url(); ?>user/cancel_activity',{invite_id:invite_id},function(res){

                        });

                      }
                    });


                  }else{
                    $('#btn_'+invite_id).removeClass('btn-info').addClass('btn-success').html('Approved  <span class="caret"></span>');
                    $('#approve_'+invite_id).remove();
                  }
                });
               }

             </script>
             
