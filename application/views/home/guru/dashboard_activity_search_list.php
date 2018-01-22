 <?php if(!empty($activity_list)): 
 function converToTz($time="",$toTz='',$fromTz='')
 {           
  $date = new DateTime($time, new DateTimeZone($fromTz));
  $date->setTimezone(new DateTimeZone($toTz));
  $time= $date->format('Y-m-d H:i:s');
  return $time;
}
?>
<?php foreach($activity_list as $activity): ?>
  <?php 
  $img1 = '';
  if($activity['picture_url'] != ''){
    $img1 = $activity['picture_url'];
  }
  if($activity['profile_img'] != '')
  {
    $file_check = FCPATH . '/assets/images/' . $activity['profile_img'];
    if (file_exists($file_check)) {
      $img1 = base_url() . 'assets/images/'.$activity['profile_img'];
    }
  }
  $img = ($img1 !='') ? $img1 : base_url() . 'assets/images/default-avatar.png';
  ?>
  <div class="row" id="row_<?php echo $activity['invite_id'];?>">
    <div class="col-sm-6">
      <div class="jprfpic"><a href="<?php echo base_url();?>view-user/<?php echo $activity['username']; ?>"><img src="<?php echo $img; ?>" class="img-circle" height="40" width="40"></a></div>
      <div class="jprfname">
        <h3><a href="<?php echo base_url();?>view-user/<?php echo $activity['username']; ?>"><?php echo $activity['first_name'].' '.$activity['last_name']; ?></a></h3>
        <h4><?php //echo $activity['applicant_personal_mess']; ?></h4>
      </div>
    </div>
    <?php  

    $from_date_time =  $activity['invite_date'].' '.$activity['invite_time'];
    $from_timezone =$activity['time_zone'];                         
    $to_timezone = $this->session->userdata('time_zone');
    $from_date_time  = converToTz($from_date_time,$to_timezone,$from_timezone);
    $from_time  = date('h:i a',strtotime($from_date_time));
    ?>
    <div class="col-sm-2 text-left"><p>Date: <?php echo date('d-m-Y', strtotime($from_date_time)); ?></p></div>
    <div class="col-sm-2 text-left"><p>Time: <?php echo date('h:i A', strtotime($from_time)); ?></p></div>
    <div class="col-sm-2 text-left">
      <?php

 if($activity['approved'] == 0 && date('Y-m-d H:i:s') >  date('Y-m-d H:i:s', strtotime($from_date_time . ' +1 hour'))) { 

                            $status = '<div class="dropdown">

                            <button class="btn-xs btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Cancelled <span class="caret"></span></button>  

                            <ul class="dropdown-menu">     


                            <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>                                    

                            <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->                                     

                            </ul>                          

                            </div>'; 

                          }else{

                            $status = '<div class="dropdown">

                            <button class="btn-xs btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Pending

                            <span class="caret"></span></button>

                            <ul class="dropdown-menu">                              

                            <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>      
                            <li><a href="javascript:void(0)"  onclick="confirmCancel('.$activity['invite_id'].','.$activity['invite_from'].')">Cancel</a></li>                                 

                            <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->   
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
                             <li><a href="javascript:void(0)"  onclick="confirmCancel('.$activity['invite_id'].','.$activity['invite_from'].')">Cancel</a></li>                           
                             <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>                                    
                             <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->                                     
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
                             <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->                                     
                             </ul>
                             </div>';                                

                           }else{ // After Call time with Approve  without call logs 

                             $status = '<div class="dropdown">
                             <button class="btn-xs btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Incomplete
                             <span class="caret"></span></button>
                             <ul class="dropdown-menu">                                         
                             <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>                                    
                             <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->                                     
                             </ul>
                             </div>';

                           }
                         }

                         if($activity['approved'] == 2) { 
                           $status = '<div class="dropdown">
                           <button class="btn-xs btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$activity['invite_id'].'">Cancelled <span class="caret"></span></button>  
                           <ul class="dropdown-menu">     
                                                  <li><a href="'.base_url().'view-user/'.$activity['username'].'" >View</a></li>      
                           <!--<li><a href="javascript:void(0)" onclick="confirmDelete('.$activity['invite_id'].')">Delete</a></li>      -->                                      
                           </ul>                          
                           </div>'; 

                         }

                         echo $status;

     ?>

   </div>
 </div>
 <?php 
endforeach;
endif;
?> 
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
      <div class="modal-body">
      	Are you sure you want to approve this call?
        <input type="hidden" name="" id="hidden_ids">
        <input type="hidden" name="" id="user_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="approve_activity()">Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3>Confirmation</h3>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this detail?
        <input type="hidden" name="" id="hidden_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="delete_activity()">Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
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
</div>
<script type="text/javascript">
  function confirmCancel(id){
    $('#hidden_idss').val(id);
    $('#cancel_modal').modal('show');
  }
  function cancel_activity()
  {

    var invite_id = $('#hidden_idss').val();
    $('#btn_'+invite_id).removeClass('btn-info').addClass('btn-danger').html('Cancelled <span class="caret"></span>');
    $.post('<?php echo base_url(); ?>user/cancel_activity',{invite_id:invite_id},function(res){

    });

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



  function confirmApprove(id,user_id){

    $('#hidden_ids').val(id);
    $('#user_id').val(user_id);

    $('#approve_modal').modal('show');

  }


  function approve_activity()

  {



   var invite_id = $('#hidden_ids').val();
   var user_id = $('#user_id').val();
   var user_id = $('#user_id').val();

   $('#btn_'+invite_id).removeClass('btn-info').addClass('btn-success').html('Approved  <span class="caret"></span>');



   $('#approve_'+invite_id).remove();

   $.post('<?php echo base_url(); ?>user/approve_activity',{user_id:user_id,invite_id:invite_id},function(res){



   });



 }

</script>