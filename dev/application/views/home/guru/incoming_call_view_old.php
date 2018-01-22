 <!DOCTYPE html>
 <html>
 <head>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Conversations - SchoolGuru</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?><?php echo base_url();?>assets/images/favicon.png"> 
    <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/dist/bootstrapValidator.css" type="text/css">

    <script src="<?php echo base_url()."assets/" ?>js/jquery-1.7.1.js"></script>
    <script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">

</head>
<body>
    <div class="overlay">
        <div id="loading-img"></div>
    </div>
    <?php $currentuser = get_userdata(); ?>
    <div id="verified" style="display:none;"><?php echo $currentuser['is_verified']; ?></div>
    <input type="hidden" id="sinch_username" value="<?php echo $currentuser['username']; ?>">
    <input type="hidden" id="user_role" value="<?php echo $currentuser['role']; ?>">   
    <div class="container vccontainer">
        <div class="vcheader">
            <div class="row">
                <div class="col-sm-4"><a href="#"><img src="<?php echo base_url();?>assets/images/logo-small.png" alt="SchoolGuru"></a></div>
                <div class="col-sm-4 text-center vchtitle">Video Call</div>
                <div class="col-sm-4 text-right vchclose"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></div>
            </div>
        </div> 
        <div class="vcrow">
            <div class="vccol brdrright">
                <div class="vcboardhrz">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#presentation" aria-controls="home" role="tab" data-toggle="tab"><img src="<?php echo base_url();?>assets/images/presentation-icon.png" alt="Presentation"> Presentation</a></li>
                        <li role="presentation"><a href="#whiteboard" aria-controls="profile" role="tab" data-toggle="tab"><img src="<?php echo base_url();?>assets/images/whiteboard-icon.png" alt="Whiteboard"> Whiteboard</a></li>
                    </ul>
                    <div class="vcbclose"><a href="videocall-new-window2.html"><i class="fa fa-times" aria-hidden="true"></i></a></div>
                </div>
                <div class="vcboardstage">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="presentation"><img src="<?php echo base_url();?>assets/images/diagram.jpg" class="img-responsive"></div>
                        <div role="tabpanel" class="tab-pane" id="whiteboard"><img src="<?php echo base_url();?>assets/images/diagram2.jpg" class="img-responsive"></div>
                    </div>                  
                </div>
            </div>
            <div class="vccol">
                <div class="vcvideo">
                    <video autoplay id="incoming" style="display: inline;width:100%;"></video>
                    <div class="vcopponentvideo">
                        <video  autoplay id="outgoing"></video>
                    </div>
                </div>
                <div class="vcactions">
                    <a class="vccall" href="#"><img src="<?php echo base_url();?>assets/images/call-vc-icon.png"></a>
                    <a class="vcmike" href="#"><img src="<?php echo base_url();?>assets/images/mike-vc-icon.png"></a>
                    <a class="vcend" href="#" id="hangup"  onclick="window.top.close()"><img src="<?php echo base_url();?>assets/images/end-vc-icon.png"></a>
                </div>
                <div class="vcmsg">
                    <!--Chat Container Starts Here-->
                    <div id="chat-box" class="chat-box slimscrollleft">
                        <div class="chats">
                          <div class="chat">
                            <div class="chat-avatar">
                              <a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
                                <img alt="June Lane" src="<?php echo base_url();?>assets/images/avatar.png" class="img-responsive img-circle">
                            </a>
                        </div>
                        <div class="chat-body">
                          <div class="chat-content">
                            <p>
                              Hello. What can I do for you?
                          </p>
                          <span class="chat-time">8:30 am</span>
                      </div>
                  </div>
              </div>
              <div class="chat chat-left">
                <div class="chat-avatar">
                  <a title="" data-placement="left" href="#" data-toggle="tooltip" class="avatar" data-original-title="Edward Fletcher">
                    <img alt="Edward Fletcher" src="<?php echo base_url();?>assets/images/avatar.png" class="img-responsive img-circle">
                </a>
            </div>
            <div class="chat-body">
              <div class="chat-content">
                <p>
                  I'm just looking around.
              </p>
              <p>Will you tell me something about yourself? </p>
              <span class="chat-time">8:35 am</span>
          </div>
          <div class="chat-content">
            <p>
              Are you there? That time!
          </p>
          <span class="chat-time">8:40 am</span>
      </div>
  </div>
</div>
<div class="chat">
    <div class="chat-avatar">
      <a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
        <img alt="June Lane" src="<?php echo base_url();?>assets/images/avatar.png" class="img-responsive img-circle">
    </a>
</div>
<div class="chat-body">
  <div class="chat-content">
    <p>  Where?     </p>
    <span class="chat-time">8:35 am</span>
</div>
<div class="chat-content">
    <p>
      OK, my name is Limingqiang. I like singing, playing basketballand so on.
  </p>
  <span class="chat-time">8:42 am</span>
</div>
</div>
</div>
<div class="chat chat-left">
    <div class="chat-avatar">
      <a title="" data-placement="left" href="#" data-toggle="tooltip" class="avatar" data-original-title="Edward Fletcher">
        <img alt="Edward Fletcher" src="<?php echo base_url();?>assets/images/avatar.png" class="img-responsive img-circle">
    </a>
</div>
<div class="chat-body">
  <div class="chat-content">
    <p>You wait for notice.</p>
</div>
<div class="chat-content">
    <p>Consectetuorem ipsum dolor sit?</p>
    <span class="chat-time">8:50 am</span>
</div>
<div class="chat-content">
    <p>OK?</p>
    <span class="chat-time">8:55 am</span>
</div>
</div>
</div>
<div class="chat">
    <div class="chat-avatar">
      <a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
        <img alt="June Lane" src="<?php echo base_url();?>assets/images/avatar.png" class="img-responsive img-circle">
    </a>
</div>
<div class="chat-body">
  <div class="chat-content">
    <p>OK!</p>
    <span class="chat-time">9:00 am</span>
</div>
</div>
</div>
</div>
</div>                          
</div>
<div>
    <div class="message-bar">
        <div class="message-inner">
            <div class="message-area"><input type="text" placeholder="Type message..." class="chat-input"></div>
            <a class="link btn btn-default chat-send-btn" href="#">Send</a>
        </div>
    </div>
</div>    
</div>
</div>   
</div>



  <!--   <section class="mainarea">        
        <div class="container">
           <div class="frame">
               <div class="card-box vdscreen" style="min-height: 450px;">
                <video autoplay id="incoming" style="display: inline;width:100%;"></video>
                <div class="opponentscreen" style="margin-bottom: 10px;">
                    
                    <video  autoplay id="outgoing" style="display: inline;height:200px;"></video>
                </div>
            </div>            
            <div id="callLog" class="text-center">
            </div>
            <div class="error">
            </div>
            <div class="vcontrols" style="margin-top: 25px;">
                <div id="call">
                    <form id="newCall">
                        <ul>
                            <li class="btn btn-primary"><button><img src="<?php echo base_url(); ?>assets/<?php echo base_url();?>assets/images/micmute-icon.png"></button></li>
                            <li class="btn btn-success" id="call_again"><button ><img src="<?php echo base_url(); ?>assets/<?php echo base_url();?>assets/images/video-call.png"></button></li>                          
                            <li class="btn btn-danger"><button id="hangup" type="button" onclick="window.top.close()"><img src="<?php echo base_url(); ?>assets/<?php echo base_url();?>assets/images/call-drop-icon.png"></button></li>
                        </ul>
                        <audio id="ringback" src='<?php echo base_url();?>assets/css/style/ringback.wav' loop></audio>
                        <audio id="ringtone" src='<?php echo base_url();?>assets/css/style/phone_ring.wav' loop></audio>
                    </form>
                </div>   
            </div>
        </div>

    </div>
</section> -->


<script> var base_url = '<?php echo base_url(); ?>'; </script>
<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src='<?php echo base_url()."assets/" ?>js/moment.js'></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap-notify.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/sinch/VIDEOsample.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/sinch/messages.js"></script>

<script type="text/javascript">


  $('.overlay').fadeIn(8000 , function(){
    $(this).css("display","none");
    $('#call_again').hide();

    // Making Video call  here 
    var callClient = sinchClient.getCallClient();
            callClient.initStream().then(function() { // Directly init streams, in order to force user to accept use of media sources at a time we choose
                $('div.frame').not('#chromeFileWarning').show();
            }); 

            var outgoing =localStorage['outgoing'];
            var incoming =localStorage['incoming'];

    //       $('#outgoing_header').hide();
    // $('#vcall').show();
    // $('.removable').removeClass('modal-body').addClass('modal-header');
    // $('#hangout').hide();
    // $('.modal-hidden').removeClass('hidden').addClass('modal-body');
    
    $('video#outgoing').attr('src',outgoing);
    $('video#outgoing')[0].play();
    $('video#incoming').attr('src',incoming);
    $('video#incoming')[0].play();
    $('audio#ringback').trigger("pause");
    $('audio#ringtone').trigger("pause");
    //$('div#callLog').html('<div id="stats">Connected...</div>');
    //Report call stats



});

  // $('video#incoming').change(function(){
  //   alert();
  // });




</script>

</body>
</html>