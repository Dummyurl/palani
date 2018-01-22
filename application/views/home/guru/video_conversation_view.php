<div class="row titlerow">
    <div class="col-sm-6">
    	<h2>Conversation</h2>
    </div>
    <div class="col-sm-6 text-right"></div>
</div>
  <div id="userInfo">
        <h3><span id="username"></span></h3>
  </div>
  <div class="frame">
   <div class="card-box vdscreen">
         <div id="connect_calling"></div> 
                    <video autoplay id="incoming" style="display: inline;height:1140px;" ></video>
                     <div class="opponentscreen" style="margin-bottom: 10px;">
                                    <!--Add outgoing video here-->
                     <video muted autoplay id="outgoing" style="display: inline;height:200px;" ></video>
                    </div>
                                
                                
    </div>
    
       <input type="hidden" id="callUserName" placeholder="Username (alice)" value="<?php echo $this->uri->segment(3); ?>"><br>
       <div id="callLog">
       </div>
       <div class="error">
       </div>
            <div class="vcontrols">
               <div id="call">
                <form id="newCall">
                <ul>
                    <li class="btn btn-primary"><button><img src="<?php echo base_url(); ?>assets/images/micmute-icon.png"></button></li>
    <!--                <li class="btn btn-danger"><button><img src="<?php echo base_url(); ?>assets/images/micmute-icon.png"></button></li>-->
                    <li class="btn btn-primary"><button id="call"><img src="<?php echo base_url(); ?>assets/images/videomute-icon.png"></button></li>
    <!--                <li class="btn btn-danger"><button><img src="<?php echo base_url(); ?>assets/images/videomute-icon.png"></button></li>-->
                    <li class="btn btn-danger"><button id="hangup"><img src="<?php echo base_url(); ?>assets/images/call-drop-icon.png"></button></li>
                 </ul>
                 <audio id="ringback" src='<?php echo base_url();?>assets/css/style/ringback.wav' loop></audio>
                 <audio id="ringtone" src='<?php echo base_url();?>assets/css/style/phone_ring.wav' loop></audio>
                 </form>
            </div>   
            </div>
  </div>