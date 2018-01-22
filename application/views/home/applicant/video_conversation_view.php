<!--<div class="row titlerow">
    <div class="col-sm-6">
    	<h2>Conversation</h2>
    </div>
    <div class="col-sm-6 text-right"></div>
</div>
 <div class="card-box vdscreen">
                                <div class="vdscreenleft">
                                    <div id="userInfo">
					<h3><span id="username"></span></h3>
					<button id="logOut">Logout</button>
				      </div>
                                    <p><img src="<?php echo base_url();?>assets/images/videolargeimg.jpg"></p>
                                    <p><img src="<?php echo base_url();?>assets/images/videosmallimg.jpg"></p>
                                    <div class="vcontrols">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-comments" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-video-camera" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-microphone" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-volume-up" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-power-off" aria-hidden="true"></i></a></li>                            
                                        </ul>
                                    </div>
                                    
                                </div>
                                <div class="vdscreenright">
                                    <img src="<?php echo base_url();?>assets/images/whiteboard.jpg">
                                 <div class="frame">
                                     
                                        <div id="call">
                                            <form id="newCall">
                                                <input type="hidden" id="callUserName" placeholder="Username (alice)" value="<?php echo $this->uri->segment(3); ?>"><br>
                                                <button id="call">Call</button>
                                                <button id="hangup">Hangup</button>
                                                <button id="answer">Answer</button>
                                                <button id="logOut">Close</button>
												
                                                <audio id="ringback" src='<?php echo base_url();?>assets/css/style/ringback.wav' loop></audio>
                                                <audio id="ringtone" src='<?php echo base_url();?>assets/css/style/phone_ring.wav' loop></audio>
                                            </form>
                                        </div>
                                        <div class="clearfix"><br></div>
                            
                                        <video id="outgoing" autoplay muted></video>
                                        <video id="incoming" autoplay></video>
                            
                                        <div id="callLog">
                                        </div>
                                        <div class="error">
                                        </div>
                                    </div>
                                </div>
                            </div>-->


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
                    <video autoplay id="incoming" style="display: inline;height:1140px;"></video>
                    <div class="opponentscreen" style="margin-bottom: 10px;">
                                    <!--Add outgoing video here-->
                          <video muted autoplay id="outgoing" style="display: inline;height:200px;"></video>
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