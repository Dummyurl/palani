 <!DOCTYPE html>
 <html>
 <head>
  <meta charset="utf-8" />
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Conversations - SchoolGuru</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/images/favicon.png"> 
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


    <!-- video call alert notification  -->
            
            <div class="new_call form-group"></div>
            <style type="text/css">
            .new_call{
             background: #f6f6f6;
             border-radius: 6px;
             position: fixed;
             right: 34px;
             z-index: 10000;
             top: 91px;
             display: block;    
             border: 1px solid #e9e9e9;
             padding: 19px 82px 30px 63px;
         }
         .new_call:empty{
            display: none;
         }
        </style>



  <?php $currentuser = get_userdata(); 


  $profile_img = '';
  if(isset($currentuser['profile_img'])&&!empty($currentuser['profile_img']))
  {
    $profile_img = $currentuser['profile_img'];
  }  
  $social_profile_img = '';
  if(isset($currentuser['picture_url'])&&!empty($currentuser['picture_url']))
  {
    $social_profile_img = $currentuser['picture_url'];

  }  
  $img1 = '';
  if($social_profile_img != '')
  {
    $img1 = $social_profile_img;

  }
  if($profile_img != '')
  {
    $file_to_check = FCPATH . '/assets/images/' . $profile_img;
    if (file_exists($file_to_check)) {
      $img1 = base_url() . 'assets/images/'.$profile_img;
    }
  }
  $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
  ?>


  <div id="verified" style="display:none;"><?php echo $currentuser['is_verified']; ?></div>
  <input type="hidden" id="sinch_username" value="<?php echo $currentuser['username']; ?>">
  <input type="hidden" id="user_role" value="<?php echo $currentuser['role']; ?>"> 

  <input type="hidden" id="channel" value="<?php echo base64_decode($this->uri->segment(4)); ?>">  
  <input type="hidden" id="call_to" value="<?php echo base64_decode($this->uri->segment(3)); ?>">  
  <input type="hidden" id="url" value="<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">  


  <div class="container-fluid vccontainer">
    <div class="vcheader">
      <div class="row">
        <div class="col-sm-4"><a href="#"><img src="images/logo-small.png" alt="SchoolGuru"></a></div>
        <div class="col-sm-4 text-center vchtitle">Video Call</div>
        <div class="col-sm-4 text-right vchclose"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></div>
      </div>
    </div>
    <div class="vcrow">
      <div class="vccol vccolsmall">
        <a href="#"><img src="<?php echo base_url();?>assets/images/presentation-icon.png" alt="Presentation"></a>
        <a href="#"><img src="<?php echo base_url();?>assets/images/whiteboard-icon.png" alt="Whiteboard"></a>
      </div>
      <div class="vccol vccollarge">

        <div class="vcvideo">
         <video autoplay id="other0" style="display: inline;height: 98%;margin: auto;width: 100%;"></video>
         <div class="vcopponentvideo"><video  autoplay id="me"></video></div>
       </div>

       <div class="vcactions">
        <a class="vccall" href="#" onclick="join_call()"><img src="<?php echo base_url();?>assets/images/call-vc-icon.png"></a>
        <a class="vcmike" href="#"><img src="<?php echo base_url();?>assets/images/mike-vc-icon.png"></a>
        <a class="vcend" href="#" id="cut" onclick="window.close();"><img src="<?php echo base_url();?>assets/images/end-vc-icon.png"></a>

      </div>
      <div class="vcmsg">         

        <!--Chat Container Starts Here-->

        <div id="chat-box" class="chat-box slimscrollleft">
          <div class="chats">
            <div class="chat">
              <div class="chat-avatar">
                <a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
                  <img alt="June Lane" src="images/avatar.png" class="img-responsive img-circle">
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
                  <img alt="Edward Fletcher" src="images/avatar.png" class="img-responsive img-circle">
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
                  <img alt="June Lane" src="images/avatar.png" class="img-responsive img-circle">
                </a>
              </div>
              <div class="chat-body">
                <div class="chat-content">
                  <p>
                    Where?
                  </p>
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
                  <img alt="Edward Fletcher" src="images/avatar.png" class="img-responsive img-circle">
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
                  <img alt="June Lane" src="images/avatar.png" class="img-responsive img-circle">
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

        <!--Chat Container Ends Here-->          

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

<input type="text" name="call_id" id="call_id">


<script type="text/javascript">

  function clock() {
    var time = new Date();

    time = time.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });
    $('#time').val(time);
    setTimeout('clock()',1000);
  }
  clock();
</script>   



<script> var base_url = '<?php echo base_url(); ?>'; </script>
<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src='<?php echo base_url()."assets/" ?>js/moment.js'></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap-notify.js"></script>



<script type="text/javascript">

  var call_to = $('#call_to').val();
  var channel = $('#channel').val();
  var url = $('#url').val();
    $.post('<?php echo base_url(); ?>chat/update_channel',
        {            
            call_to:call_to,
            channel : channel,
            url:url
        },function(res){
             console.log(res);
             $('#call_id').cal(res);
    });

    $('.overlay').show();
    sinchClient = new SinchClient({
      applicationKey: 'f06ae4f2-4980-40aa-89ca-9b98d80d70c4',

      capabilities: {calling: true, video: true, messaging: true, multiCall: true},
      supportActiveConnection: true,
      onLogMessage: function(message) {
        if(message.code == 4000)
        {
          var signInObj = {};
          signInObj.username = $('#sinch_username').val();
          signInObj.password = $('#sinch_username').val();
          sinchClient.start(signInObj, function() {
            global_username = signInObj.username;
            localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
                    //window.location = base_url+"dashboard?notify=true";
                  }).fail(handleError);
        }
        $('.new_call').html(message.message);
        var status = message.message;


        if(status == 'Injecting ICE candidate directly' || status == 'Call established' || status == 'Generated extra candidate for Proxy Relay'){
          $('.new_call').html('');
          $('.overlay').hide();
        }
        if(status == 'Successfully started SinchClient'){
           $('.overlay').hide();
        }else if(status == 'Call ended'){

         // window.location.reload();
        }



      },onLogMxpMessage: function(message) {
       // console.log(message);
     }
   });

    if(typeof localStorage[sessionName] == 'undefined'){
      sinchClient.startActiveConnection();
    }


    /*** Name of session, can be anything. ***/

    var sessionName = 'sinchSessionVIDEO-' + sinchClient.applicationKey;

    /*** Check for valid session. NOTE: Deactivated by default to allow multiple browser-tabs with different users. ***/

    var sessionObj = JSON.parse(localStorage[sessionName] || '{}');
    if(sessionObj.userId) { 
      sinchClient.start(sessionObj)
      .then(function() {
        global_username = sessionObj.userId;
        showUI();
        localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
      })
      .fail(function() {

      });
    }
    else {
      var signUpObj = {};
      signUpObj.username = $('#sinch_username').val();
      signUpObj.password = $('#sinch_username').val();
      sinchClient.newUser(signUpObj, function(ticket) {
        sinchClient.start(ticket, function() {
          global_username = signUpObj.username;
          localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
        }).fail(handleError);
      }).fail(handleError);
    }






    function join_call()
    {

      var channel = $('#channel').val();

//channel = window.location.hash; //Get channel from the URL hash
var remoteCalls = []; //Track a number of incoming calls. For more calls - edit the HTML

console.log('Will join channel: ', channel);
//Get callClient, start it and then join the group
var callClient = sinchClient.getCallClient();

var groupCall = callClient.callGroup(channel);

groupCall.addEventListener({
  onGroupRemoteCallAdded: function(call) {
    remoteCalls.push(call);
    var callIdx = remoteCalls.indexOf(call);
    $('video#other'+callIdx).attr('src', call.incomingStreamURL);

    $('#cut').click(function(){
     call.hangup();
      window.close();
   //  window.location.reload();
   });


  },
  onGroupLocalMediaAdded: function(stream) {
    $('video#me').attr('src', window.URL.createObjectURL(stream));
    $("video#me").prop("volume", 0);


    var call_id = $('#call_id').val();
 
    $.post('<?php echo base_url(); ?>user/delete_channel',
        {            
            call_id:call_id
         
        },function(res){
             console.log(res);
    });


  },
  onGroupRemoteCallRemoved: function(call) {
      window.top.close();
    var callIdx = remoteCalls.indexOf(call);
    remoteCalls.splice(callIdx, 1);

    $('video[id^=other]').attr('src', function(index) {
      $('video#other'+index).attr('src', (remoteCalls[index] || {}).incomingStreamURL || '');
    });
  },
});

}



/*** Set up callClient and define how to handle incoming calls ***/

var callClient = sinchClient.getCallClient();
var call;

callClient.addEventListener({
  onIncomingCall: function(incomingCall) {
     $('.overlay').show();
  //Manage the call object
  call = incomingCall;
  call.addEventListener(callListeners);
  call.answer(); //Use to test auto answer  
}
});

/*** Define listener for managing calls ***/

var callListeners = {
  onCallProgressing: function(call) {




  },
  onCallEstablished: function(call) {
    $('video#outgoing').attr('src', call.outgoingStreamURL);
    $('video#incoming').attr('src', call.incomingStreamURL);
    $('audio#ringback').trigger("pause");
    $('audio#ringtone').trigger("pause");


    var callDetails = call.getDetails();
  //  console.log(callDetails);
  },
  onCallEnded: function(call) {
   window.close();

   // console.log(call);
    //Report call stats
    var callDetails = call.getDetails();
    //console.log(callDetails);

  }
};


setTimeout(function() {
  join_call();
}, 5000);





</script>

</body>
</html>