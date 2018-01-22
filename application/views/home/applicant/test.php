    <section class="mainarea">     
        <div class="container">

         <div class="frame">
             <div class="card-box vdscreen" style="min-height: 450px;">

                <video autoplay id="incoming" style="display: inline;width:100%;"></video>
                <div class="opponentscreen" style="margin-bottom: 10px;">
                    <!--Add outgoing video here-->
                    <video muted autoplay id="outgoing" style="display: inline;height:200px;"></video>
                </div>


            </div>
            <?php //print_r($today_conversation[0]['username']); ?>
            <!-- <input type="hidden" id="callUserName" placeholder="Username (alice)" value="<?php echo $today_conversation[0]['username']; ?>"><br> -->
            <div id="callLog" class="text-center">
            </div>
            <div class="error">
            </div>
            <div class="vcontrols" style="margin-top: 25px;">
                <div id="call">
                    <form id="newCall">
                        <ul>
                            <li class="btn btn-primary"><button><img src="<?php echo base_url(); ?>assets/images/micmute-icon.png"></button></li>
                            <!--                <li class="btn btn-danger"><button><img src="<?php echo base_url(); ?>assets/images/micmute-icon.png"></button></li>-->
                             <li class="btn btn-success" id="call_again"><button ><img src="<?php echo base_url(); ?>assets/images/video-call.png"></button></li>
                            <!--                <li class="btn btn-danger"><button><img src="<?php echo base_url(); ?>assets/images/videomute-icon.png"></button></li>-->
                            <li class="btn btn-danger"><button id="hangup" type="button"><img src="<?php echo base_url(); ?>assets/images/call-drop-icon.png"></button></li>
                        </ul>
                        <audio id="ringback" src='<?php echo base_url();?>assets/css/style/ringback.wav' loop></audio>
                        <audio id="ringtone" src='<?php echo base_url();?>assets/css/style/phone_ring.wav' loop></audio>
                    </form>
                </div>   
            </div>
        </div>

    </div>
</section>