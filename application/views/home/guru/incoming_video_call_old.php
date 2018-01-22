 <!DOCTYPE html>
 <html>
 <head>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Conversations - SchoolGuru</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/images/favicon.png"> 
    <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrapValidator.css" type="text/css">

    <script src="<?php echo base_url()."assets/" ?>js/jquery-1.7.1.js"></script>
    <script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">

</head>
<body>
    <div class="overlay">
        <div id="loading-img"></div>
    </div>
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
    <div class="container-fluid vccontainer">
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
                    <div id="chat-box" class="chat-box slimscrollleft">
                       <div class="chats">
                       </div>
                   </div>
               </div> <!-- Chat Contents goes here  -->
               <div>
                <div class="message-bar">
                    <div class="message-inner">         
                        <form name="chat_form" id="chat_form" >
                            <div class="message-bar">
                                <div class="message-inner">
                                    <div class="message-area">
                                        <input type="hidden" name="receiver_id" id="receiver_id" >
                                        <input type="hidden" name="time" id="time" >                                         
                                        <input type="hidden" name="img" id="img" value="<?php echo $img; ?>">                                         
                                        <input type="text" name="input_message" id="input_message" placeholder="Type message..." class="chat-input" autocomplete="off">
                                    </div>
                                    <a class="link btn btn-default chat-send-btn" href="javascript:void(0)" id="chat-send-btn">Send</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>    
        </div>
    </div>   
</div>


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
<script src="<?php echo base_url()."assets/" ?>js/sinch/VIDEOsample.js"></script>
<!-- <script src="<?php echo base_url()."assets/" ?>js/sinch/messages.js"></script> -->

<script type="text/javascript">



       var to_username = localStorage['fromId']; // opposite user name 





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







       $.post('<?php echo base_url() ?>chat/get_messages',{to_username:to_username},function(res){       
        $('.chats').html(res); 
        $('#hidden_id').focus().addClass('hidden');       

    });




       $('#receiver_id').val(localStorage['fromId']);
// Click Send button in  the chat form 
$('.chat-send-btn').click(function(){
   var time = $('#time').val();
   var img = $('#img').val();
   var input_message = $.trim($('#input_message').val());
   if(input_message!=''){
     var content ='<div class="chat">'+
     '<div class="chat-avatar">'+
     '<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">'+
     '<img  src="'+img+'" class="img-responsive img-circle">'+
     '</a>'+
     '</div>'+
     '<div class="chat-body">'+
     '<div class="chat-content">'+
     '<p>'+input_message+
     '</p>'+
     '<span class="chat-time">'+time+'</span>'+
     '</div>'+
     '</div>'+
     '</div>';
     $('#ajax').append(content);               
     $('.chat-box ').animate({scrollTop: $('.chat-box')[0].scrollHeight}, 'fast');
     message();
     $('#chat_form')[0].reset();
 }
 return false;



 return false;
});

// Submitting the chat form 
$('#chat_form').submit(function(){

    var time = $('#time').val();
    var img = $('#img').val();
    var input_message = $.trim($('#input_message').val());
    if(input_message!=''){
     var content ='<div class="chat">'+
     '<div class="chat-avatar">'+
     '<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">'+
     '<img  src="'+img+'" class="img-responsive img-circle">'+
     '</a>'+
     '</div>'+
     '<div class="chat-body">'+
     '<div class="chat-content">'+
     '<p>'+input_message+
     '</p>'+
     '<span class="chat-time">'+time+'</span>'+
     '</div>'+
     '</div>'+
     '</div>';
     $('#ajax').append(content);               
     $('.chat-box ').animate({scrollTop: $('.chat-box')[0].scrollHeight}, 'fast');
     message();
     $('#chat_form')[0].reset();

 }
 return false;
});



function message()
{
 var msg = $.trim($('#input_message').val());
 var to_username = localStorage['fromId'];
        // Get the messageClient
        var messageClient = sinchClient.getMessageClient(); 
        // Create a new Message
        var message = messageClient.newMessage(to_username, msg);
        // Send it
        messageClient.send(message);
        $.post(base_url+'chat/insert_chat',{to_username:to_username,input_message:msg},function(response){

        });

    }



    var messageClient = sinchClient.getMessageClient();
    var myListenerObj = {
        onMessageDelivered: function(messageDeliveryInfo) {
           // console.log(messageDeliveryInfo);
        // Handle message delivery notification
    },
    onIncomingMessage: function(message) {

        if(message.senderId == localStorage['fromId']){

        $.post('<?php echo base_url(); ?>chat/get_image',{to_username:message.senderId},function(res){ 

           var time = message.timestamp.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });

           var content ='<div class="chat chat-left">'+
           '<div class="chat-avatar">'+
           '<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="">'+
           '<img alt="" src="'+res+'" class="img-responsive img-circle">'+
           '</a>'+
           '</div>'+
           '<div class="chat-body">'+
           '<div class="chat-content">'+
           '<p>'+message.textBody+'</p>'+
           '<span class="chat-time">'+time+'</span>'+
           '</div>'+
           '</div>'+
           '</div>';
           $('#ajax').append(content); 
           $('.chat-box ').animate({scrollTop: $('.chat-box')[0].scrollHeight}, 'fast');
       });
    }

    }
};
messageClient.addEventListener(myListenerObj);






  // $('video#incoming').change(function(){
  //   alert();
  // });




</script>

</body>
</html>