<div class="row titlerow">
  <div class="col-sm-6">
    <h2>Today Conversations</h2>
  </div>
  <div class="col-sm-6 text-right"></div>
</div>
<div class="conversation"></div>











<!-- Outgoing POPUP -->
<!-- <div class="modal fade bs-example-modal-lg" id="outgoing_call" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="position: fixed">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
     


     <div class="modal-header" id="outgoing_header">        
        <div class="success-signup" id="signup_applicant_modal">
          <div class="cong_icon_to"><i class="fa fa-check"></i></div>
          <h2>Outgoing Call...</h2>
          <div id="calling"><h2></h2></div>
        </div>
      </div>
    
        <div class="modal-body removable  text-center">   
        <div id="vcall">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button><h3>Video call </h3>  
        </div>     
          <button type="button" id="hangout" class="btn btn-danger" data-dismiss="modal">Reject</button>
        </div>
      <div class="modal-hidden hidden">       
       <div class="frame">
         <div class="card-box vdscreen" style="min-height: 450px;">          
          <video autoplay id="incoming" style="display: inline;width:100%;"></video>
          <div class="opponentscreen" style="margin-bottom: 10px;">            
            <video  autoplay id="outgoing" style="display: inline;height:200px;"></video>
          </div>
        </div>        
        <input type="hidden" id="callUserName" placeholder="Username (alice)" value="<?php echo $this->uri->segment(3); ?>"><br>
        <div id="callLog"></div>
        <div class="error"></div>
        <div class="vcontrols" style="margin-top:25px;">
          <div id="call">
            <form id="newCall">
              <ul>
                <li class="btn btn-danger">
                  <button type="button" id="mute_mic" ><img src="<?php echo base_url(); ?>assets/images/micmute-icon.png"></button>
                </li>                            
                <li class="btn btn-success" id="call_again"><button id="call"><img src="<?php echo base_url(); ?>assets/images/video-call.png"></button></li>          
                <li class="btn btn-danger"><button id="hangup"><img src="<?php echo base_url(); ?>assets/images/call-drop-icon.png"></button></li>
              </ul>
              <audio id="ringback" src='<?php echo base_url();?>assets/css/style/ringback.wav' loop></audio>
              <audio id="ringtone" src='<?php echo base_url();?>assets/css/style/phone_ring.wav' loop></audio>
              
            </form>
          </div>   
        </div>
      </div>
    </div> 
  </div>
</div>
</div> -->

<!-- Outgoing POPUP -->

