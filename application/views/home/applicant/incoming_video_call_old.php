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
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/jquery.mCustomScrollbar.min.css" type="text/css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css">

  
  
  

  <script> var base_url = '<?php echo base_url(); ?>'; </script>
  <script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>
  <script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js"></script>
  <script src='<?php echo base_url()."assets/" ?>js/moment.js'></script>
  <script src="<?php echo base_url()."assets/" ?>js/bootstrap-notify.js"></script>
  <script src='<?php echo base_url()."assets/" ?>js/jquery.mCustomScrollbar.concat.min.js'></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>
  

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
#disconnected:empty{
  display: none;
}
#disconnected{
  display: inline-block;
}

</style>



<?php 

  // Session Usre Data 
$currentuser = get_userdata(); 


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

// Receiver Userdata 

$receiver_id =  base64_decode($this->uri->segment(5));
$receiver =get_all_datas($receiver_id);




$profile_imge = '';
if(isset($receiver['profile_img'])&&!empty($receiver['profile_img']))
{
  $profile_imge = $receiver['profile_img'];
}  


$social_profile_imge = '';
if(isset($receiver['picture_url'])&&!empty($receiver['picture_url']))
{
  $social_profile_imge = $receiver['picture_url'];

}  
$imge1 = '';
if($social_profile_imge != '')
{
  $imge1 = $social_profile_imge;

}
if($profile_imge != '')
{
  $file_to_check = FCPATH . '/assets/images/' . $profile_imge;
  if (file_exists($file_to_check)) {
    $imge1 = base_url() . 'assets/images/'.$profile_imge;
  }
}
$imge = ($imge1 != '') ? $imge1 : base_url() . 'assets/images/default-avatar.png';


?>

<div id="verified" style="display:none;"><?php echo $currentuser['is_verified']; ?></div>
<input type="hidden" id="sinch_username" value="<?php echo $currentuser['username']; ?>"> <!-- session user  -->
<input type="hidden" id="user_role" value="<?php echo $currentuser['role']; ?>"> 

<input type="hidden" id="channel" value="<?php echo base64_decode($this->uri->segment(4)); ?>">  
<input type="hidden" id="call_to" value="<?php echo base64_decode($this->uri->segment(3)); ?>">   <!-- to username -->

<input type="hidden" id="url" value="<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">  


<div class="container-fluid vccontainer">
  <div class="vcfullscreen">Fullscreen</div>
  <div class="vcheader">
    <div class="row">
     <!--  <div class="col-sm-4"><a href="#"><img src="images/logo-small.png" alt="SchoolGuru"></a></div> -->
     <div class="col-sm-4 text-center vchtitle">Video Call</div>
     <!-- <div class="col-sm-4 text-right vchclose"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></div> -->
   </div>
 </div>
 <div class="vcrow">
  <div class="vccol vccolsmall">
    <a href="#"><img src="<?php echo base_url();?>assets/images/presentation-icon.png" alt="Presentation"></a>
    <a href="#"><img src="<?php echo base_url();?>assets/images/whiteboard-icon.png" alt="Whiteboard"></a>
  </div>
  <div class="vccol vccollarge">

    <div class="vcvideo">
      <div align="center" id="muted_image">
        <img src="<?php echo $imge; ?>" class="img-circle img-responsive">
      </div>
      <div class="videoinner text-center">
        <div id="disconnected" class="alert alert-danger"></div>
        <video autoplay id="other0" style="display: inline;height: 98%;margin: auto;width: 100%;"></video>
      </div>
      <div class="vcopponentvideo">
       <div align="center" id="muted_image_me">
        <img src="<?php echo $img ?>" class="img-circle img-responsive">
      </div>
      <video  autoplay id="me"></video></div>
      <div class="vcactions">
        <a class="vccall" href="#" onclick="window.location.reload();">Call</a>
        <a class="vcmike" href="#">Mike</a>
        <a class="vcvideop active" href="#">Video</a>
        <a class="vcend" href="#" id="cut" onclick="window.close();">Call End</a>
      </div>

    </div>

    <!--   <div class="vcactions">
        <a class="vccall" href="#" onclick="window.location.reload();"><img src="<?php echo base_url();?>assets/images/call-vc-icon.png"></a>
        <a class="vcmike" href="#"><img src="<?php echo base_url();?>assets/images/mike-vc-icon.png"></a>
        <a class="vcend" href="#" id="cut" onclick="window.close();"><img src="<?php echo base_url();?>assets/images/end-vc-icon.png"></a>
      </div> -->

      <div class="vcmsg">         
        <!--Chat Container Starts Here-->
        <div id="chat-box" class="chat-box slimscrollleft">
         <div class="progress upload-progress hidden">
          <div class="progress-bar progress-bar-success active progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100" style="width: 100%;">
           Uploading...  
         </div>
       </div>
       <div class="chats" id="ajax"></div> <!-- chat ajax  -->
     </div>
     <!--Chat Container Ends Here-->          

   </div>   
   <div>


    <input type="hidden" name="sender_id" id="sender_id" value="<?php echo $this->session->userdata('applicant_id'); ?>"> 

    <form name="chat_form" id="chat_form" onsubmit="return false;">
      <div class="message-bar">
        <div class="message-inner">
          <a class="link attach-icon" href="#"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
          <div class="message-area">
            <input type="text" name="input_message" id="input_message" placeholder="Type message..." class="chat-input" autocomplete="off">
            <input type="file" name="userfile" id="user_file" class="hidden">             
            <input type="hidden" id="receiver_id"  name="receiver_id"> 
            <input type="hidden" id="to_user_id" value="<?php echo base64_decode($this->uri->segment(5)); ?>" name="to_user_id">   <!-- to userid   -->
            <input type="hidden" name="time" id="time" >
            <input type="hidden" name="img" id="img" value="<?php echo $img; ?>"> 
          </div>
          <a class="link btn btn-default chat-send-btn" href="javascript:void(0)" id="chat-send-btn">Send</a>
        </div>
      </div>
    </form> 
  </div>
</div>
</div>    
</div> 

<input type="hidden" name="call_id" id="call_id">
<input type="hidden" name="invite_id" id="invite_id" value="<?php echo $invite_id ?>">
<input type="hidden" name="from_time" id="from_time" value="<?php echo $from_time; ?>">
<input type="hidden" name="to_time" id="to_time" value="<?php echo $to_time; ?>">
<input type="hidden" name="date" id="date" value="<?php echo $date; ?>">
<input type="hidden" name="from_date_time" id="from_date_time" value="<?php echo $from_date_time; ?>">
<input type="hidden" name="to_date_time" id="to_date_time" value="<?php echo $to_date_time; ?>">



<script>

   // Get old images from database

                 var to_username = $('#call_to').val(); // To username 
                 var invite_id = $('#invite_id').val(); // invite id  

                 $.post('<?php echo base_url(); ?>chat/get_messages',{to_username:to_username,invite_id:invite_id},function(response){

                  if(response == 'true'){

                   swal({ 
                     title: "Oops!",
                     text: "You are not allowed to access this page !",
                     type: "error" ,
                     icon: 'error'
                   });           
                   setTimeout(function() {
                   window.location.href="<?php echo base_url();?>user/logout";
                   }, 1000);                  
                   
                    return false;                                  
                 }


                 $('.chats').html(response);  
                 $('#hidden_id').focus().addClass('hidden');    
                 $(".slimscrollleft.chats").mCustomScrollbar("update");
                 $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 
                  // Load more function 
                  $('.load-more-btn').click(function(){
                    $('.load-more-btn').html('<button class="btn btn-default">Please wait . . </button>');
                    var total = $(this).attr('total');
                    if(total>0 || total == 0 ){                        
                     load_more(total);   
                     var total = total - 1;
                     $(this).attr('total',total); 
                   }else{
                    $('.load-more-btn').html('<button class="btn btn-default">Thats all!</button>');
                  }

                });
                interval();
                });




function interval()
{
      // Call Validate here 

                setInterval(function(){

        var current_date_time = new Date(); // Current Date & time  
        var from_date_time = new Date('<?php echo $from_date_time; ?>'); // From date time 
        var to_date_time = new Date('<?php echo $to_date_time; ?>'); // To date time 

        // Before 15 mins of end time 
        // var before_fifteen_minutes = new Date('<?php echo date("Y-m-d H:i:s",strtotime("-15 minutes",strtotime($to_date_time))); ?>'); 
        var after_fifteen_minutes = new Date('<?php echo date("Y-m-d H:i:s",strtotime("+15 minutes",strtotime($to_date_time))); ?>'); 


        // console.log(before_fifteen_minutes);
         //console.log(after_fifteen_minutes);
        // console.log(current_date_time);

          if(current_date_time > to_date_time){  // Nofity before fifteen minutes             



            var diff = moment.duration(moment(after_fifteen_minutes).diff(moment(current_date_time)));
            
            var seconds = parseInt(diff.asSeconds());
            var days = parseInt(diff.asDays());  // Remaining days 
            var hours = parseInt(diff.asHours()); 
              var seconds = diff._data.seconds;
            hours = hours - days*24;  // Remaining Hours 
            var minutes = parseInt(diff.asMinutes()); 
            remainin_minutes_end = minutes - (days*24*60 + hours*60); //Remaning Minutes 

            if(remainin_minutes_end == 1){
              $('.new_call').html('This call will disconnect in 00:'+remainin_minutes_end+':'+seconds);
            }else{
              $('.new_call').html('This call will disconnect in '+remainin_minutes_end+' minutes.');
            }
            if(remainin_minutes_end == 0 && seconds < 1  ){              
              swal({ 
               title: "Oops!",
               text: "Call disconnected !",
               type: "error" ,
               icon: 'error'
             });            
             var url = $('#url').val();      
              window.open(url, '_self', ''); 
              window.close();              
            }
          }
        },1000);
}




       



                 

 // Fetching Time 
 function clock() {
  var time = new Date();

  time = time.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });
  $('#time').val(time);
  setTimeout('clock()',1000);
}
clock();


// Full screen on click 

$(".vcfullscreen").click(function(){
  $(".vcheader, .vcmsg, .vccolsmall, .message-bar").toggle();
  $(".vccollarge").toggleClass("vccollargefull");
  $(this).toggleClass("vcfullscreenalt");
  if($(".vccollarge").hasClass("vccollargefull")){
    $(".vccollarge").css('height',$(window).height());
  } else{
    $(".vccollarge").css('height','auto');
  }
});




$(".videoinner").click(function(){
  $(this).toggleClass("videoinneralt");
});
$('.attach-icon').click(function(){
  $('#user_file').click();
});

  // Onchange file upload 

  $('#user_file').change(function(e) {   
   e.preventDefault();   
   var oFile = document.getElementById("user_file").files[0]; // <input type="file" id="fileUpload" accept=".jpg,.png,.gif,.jpeg"/>
            if (oFile.size > 25097152) // 25 mb for bytes.
            {
              swal(
                'Warning!',
                'File size must under 25MB!',
                'warning'
                );

              return false;
            }
            var formData = new FormData($('#chat_form')[0]);
            $.ajax({
              url: '<?php echo base_url();?>upload/upload_files',
              type: 'POST',
              data: formData,
              beforeSend :function(){
               $('.progress').removeClass('hidden');
               $('.progress').css('display','block');
             }, 

             success: function(res) {  

              $('.progress').addClass('hidden'); 
              var obj = jQuery.parseJSON(res);
              if(obj.error){
               swal(
                'Warning!',
                obj.error,
                'warning'
                );
               $('#user_file').val('');
               return false;
             }                 
          // $("#progress-bar").width('0%');                  
          var to_username = $('#call_to').val();
          var img = $('#img').val();
          var time = $('#time').val();


          var content ='<div class="chat chat-left">'+
          '<div class="chat-avatar">'+
          '<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="">'+
          '<img alt="" src="'+img+'" class="img-responsive img-circle">'+
          '</a>'+
          '</div>'+
          '<div class="chat-body">'+
          '<div class="chat-content">'+
          '<p><img alt="" src="'+base_url+'/'+obj.img+'" class="img-responsive"></p>'+
          '<a href="'+base_url+'/'+obj.img+'" target="_blank" download>Download</a>'+
          '<span class="chat-time">'+time+'</span>'+
          '</div>'+
          '</div>'+
          '</div>';
          $('#ajax').append(content); 

          $(".slimscrollleft.chats").mCustomScrollbar("update");
          $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 


          // Get the messageClient
          var messageClient = sinchClient.getMessageClient(); 
          // Create a new Message
          var message = messageClient.newMessage(to_username,'file');
          // Send it
          messageClient.send(message); 
          $(".slimscrollleft.chats").mCustomScrollbar("update");
          $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 
          setTimeout(function() {
            $(".slimscrollleft.chats").mCustomScrollbar("update");
            $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
            $(".slimscrollleft.chats").mCustomScrollbar("update");
            $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
            $(".slimscrollleft.chats").mCustomScrollbar("update");
            $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  

          }, 3000);
          setTimeout(function() {
            $(".slimscrollleft.chats").mCustomScrollbar("update");
            $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
            $(".slimscrollleft.chats").mCustomScrollbar("update");
            $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
            $(".slimscrollleft.chats").mCustomScrollbar("update");
            $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  

          }, 1000);


        },
        error: function(data){

          alert('error');

        },
        cache: false,
        contentType: false,
        processData: false

      }); 
            return false; 



          });





  $(".chat-box.slimscrollleft").mCustomScrollbar({

    theme:"minimal"

  });     

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
     $(".slimscrollleft.chats").mCustomScrollbar("update");
     $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 
     message();
     $('#chat_form')[0].reset();
   }
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
     $(".slimscrollleft.chats").mCustomScrollbar("update");
     $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 
     message();
     $('#chat_form')[0].reset();

   }
   return false;
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

   // $('.new_call').html(message.message);
    var status = message.message;


    if(status == 'Injecting ICE candidate directly' || status == 'Call established'){        
      $('.new_call').addClass('alert').addClass('alert-success').html('Connected');
      $('.overlay').hide();
      update_log();
    }
    if(status == 'Successfully started SinchClient'){
       $('.new_call').html('Connecting...');

       $('.overlay').hide();
     }else if(status == 'Call ended'){
       $('.new_call').removeClass('alert').removeClass('alert-success').html('');
         // window.location.reload();
       }



     },onLogMxpMessage: function(message) {
      $('.new_call').html(message.message);
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

function update_log()
{
  var invite_id = $('#invite_id').val();
  var to_user_id =$('#to_user_id').val();
  var time =$('#time').val();

  $.post('<?php echo base_url(); ?>user/delete_channel',{            
   invite_id:invite_id,
   to_user_id :to_user_id,
   time :time,
 },function(res){
  $('.new_call').removeClass('alert').removeClass('alert-success').html('');  
}); 
}

function format_date( date )
{
  if (typeof date == "string")
  {
    date = new Date(date);
  }

  var year = date.getFullYear();
  var month = (1 + date.getMonth()).toString();
  month = month.length > 1 ? month : '0' + month;

  var day = date.getDate().toString();
  day = day.length > 1 ? day : '0' + day;

  return year+'-'+month+'-'+day;
}



function load_more(total){      

  var selected_user_id = $('#to_user_id').val();                  

  $.post(base_url+'user/get_old_messages',{selected_user_id:selected_user_id,total:total},function(res){  
    if(res){        
     $('.load-more-btn').html('<button class="btn btn-default" data-page="2"><i class="fa fa-refresh"></i> Load More</button>');               
     $('#ajax_old').prepend(res);
   }else{
     $('.load-more-btn').html('<button class="btn btn-default">Thats all!</button>');
   }
 }); 
}


function join_call(){


  var call_to = $('#call_to').val();
  var channel = $('#channel').val();
  var url = $('#url').val();
  var invite_id = $('#invite_id').val();
  $.post('<?php echo base_url(); ?>chat/update_channel',
  {            
    call_to:call_to,
    channel : channel,
    invite_id : invite_id,
    url:url
  },function(res){
   // console.log(res);
   $('#call_id').val(res);
 });




  $('#disconnected').html('');
  var channel = $('#channel').val();
  var remoteCalls = []; 
  var callClient = sinchClient.getCallClient();
  var groupCall = callClient.callGroup(channel);


  groupCall.addEventListener({
    onGroupRemoteCallAdded: function(call) {
    // console.log(call);
    // muting the mike here 
    $('.vcmike').click(function(){
      if($(this).hasClass('active')){
        $(this).removeClass('active');
        call.unmute();
      }else{
        $(this).addClass('active');
        call.mute();
      }
    });

    $('#disconnected').html('');
    remoteCalls.push(call);
    var callIdx = remoteCalls.indexOf(call);
    $('video#other'+callIdx).attr('src', call.incomingStreamURL);
    $('#disconnected').html('');

      // var call_id = $('#call_id').val();
      //    var to_user_id =$('#to_user_id').val();
      //    var time =$('#time').val();

      //    $.post('<?php echo base_url(); ?>user/delete_channel',{            
      //      call_id:call_id,
      //      to_user_id :to_user_id,
      //      time :time,
      //    },function(res){
      //     // console.log(res);
      //   });




      $('#cut').click(function(){
       call.hangup();
     });



    },
    onGroupLocalMediaAdded: function(stream) {


    // console.log(stream);
 // Muting the mike after connecting connected stream 

 $('.vcmike').click(function(){
  if($(this).hasClass('active')){
    $(this).removeClass('active');        
  }else{
    $(this).addClass('active');
  }
});


 $('#disconnected').html('');
 $('video#me').attr('src', window.URL.createObjectURL(stream));
 $("video#me").prop("volume", 0);

 $('.vcmike').click(function(){
  if($(this).hasClass('active')){
    $(this).removeClass('active');
    stream.getAudioTracks()[0].enabled = false; 
  }else{
    $(this).addClass('active');
    stream.getAudioTracks()[0].enabled = true; 

  }
});

 $('.vcvideop').click(function(){         
  if($(this).hasClass('active')){
    $(this).removeClass('active');                
    muting_video(1);        
  }else{
    $(this).addClass('active');        
    muting_video(0);
  }
});
},
onGroupRemoteCallRemoved: function(call) {

    //console.log(call);

    $('#disconnected').html('Call disconnected!');
    var callIdx = remoteCalls.indexOf(call);   
    remoteCalls.splice(callIdx, 1);
    $('video[id^=other]').attr('src', function(index) {
      $('video#other'+index).attr('src', (remoteCalls[index] || {}).incomingStreamURL || '');
    });   
    var invite_id = $('#invite_id').val();
    var to_user_id =$('#to_user_id').val();      
    var start_time = call.timeEstablished;
    var end_time = call.timeEnded;
    var start_time = new Date(start_time);
    var end_time = new Date(end_time);
    var start_time = start_time.toLocaleString();
    var end_time = end_time.toLocaleString();   



    $.post('<?php echo base_url() ?>user/insert_log',{
      invite_id :invite_id,
      to_user_id :to_user_id,
      start_time :start_time,
      end_time :end_time 
    },function(res){

    });
  },
});

}



/*** Set up callClient and define how to handle incoming calls ***/

var callClient = sinchClient.getCallClient();
var call;

callClient.addEventListener({
  onIncomingCall: function(incomingCall) {
    // console.log('incoming call');
    // console.log(incomingCall);    
  }
});

/*** Define listener for managing calls ***/

var callListeners = {
  onCallProgressing: function(call) {
    $('#disconnected').html('');        
    console.log('call progressing');
  },
  onCallEstablished: function(call) {    
    var callDetails = call.getDetails();
    console.log('call establish')
    console.log(callDetails);  

  },
  onCallEnded: function(call) {

    $('#disconnected').html('Call disconnected!');
    var callDetails = call.getDetails();
   // console.log('call ended');
   // console.log(callDetails);  

 }
};


setTimeout(function() {
  $('#other0').hide();
  join_call();
}, 5000);



function muting_video(status){

  if(status  == 0){
   var msg = 'ENABLE_STREAM';       

 }else{
   var msg = 'DISABLE_STREAM';
 }


 var to_username = $('#call_to').val();
 var sender_id = $('#sender_id').val();
 var sessionObj = JSON.parse(localStorage[sessionName] || '{}');
        // Get the messageClient
        var messageClient = sinchClient.getMessageClient(); 
        // Create a new Message
        var message = messageClient.newMessage(to_username, msg);
        // Send it
        messageClient.send(message);


      }


      function message()
      {
       var msg = $.trim($('#input_message').val());
       var to_username = $('#call_to').val();
       var sender_id = $('#sender_id').val();
       var sessionObj = JSON.parse(localStorage[sessionName] || '{}');
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
          // console.log(message);
        // Handle message delivery notification
      },
      onIncomingMessage: function(message) {


       if(message.direction==true){

        if( message.textBody =='ENABLE_STREAM'){              
          $('#muted_image_me').show();
          return false; 
        }
        if(message.textBody =='DISABLE_STREAM'){
         $('#muted_image_me').hide();               
         return false;
       }
     }


     if(message.direction==false){

      if( message.textBody =='ENABLE_STREAM'){
        $('#other0').hide();
        $('#muted_image').show();
        return false; 
      }
      if(message.textBody =='DISABLE_STREAM'){
       $('#muted_image').hide();
       $('#other0').show();
       return false;
     }


        var to_username = $('#call_to').val();     // sender username     

        if(to_username == message.recipientIds[0] || to_username == message.recipientIds[1]){



          $.post(base_url+'chat/get_image',{to_username:message.senderId},function(res){ 
            var obj = jQuery.parseJSON(res);
            // console.log(obj);
            var image = obj.image;
            var msg = obj.data.msg;
            var type = obj.data.type;
            var file_name = base_url+obj.data.file_path+'/'+obj.data.file_name;
            var time = message.timestamp.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });



            

            if(msg == 'file' && type == 'image' && msg !='ENABLE_STREAM' && msg !='DISABLE_STREAM'){


             var content ='<div class="chat chat-left">'+
             '<div class="chat-avatar">'+
             '<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="">'+
             '<img alt="" src="'+image+'" class="img-responsive img-circle">'+
             '</a>'+
             '</div>'+
             '<div class="chat-body">'+
             '<div class="chat-content">'+
             '<p><img alt="" src="'+file_name+'" class="img-responsive"></p>'+
             '<a href="'+file_name+'" target="_blank" download>Download</a>'+
             '<span class="chat-time">'+time+'</span>'+
             '</div>'+
             '</div>'+
             '</div>';
             $('#ajax').append(content); 

             $(".slimscrollleft.chats").mCustomScrollbar("update");
             $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 
             setTimeout(function() {
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  

            }, 3000);
             setTimeout(function() {
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  

            }, 1000);                 
           }else if(msg == 'file' && type == 'others'  && msg!='ENABLE_STREAM' && msg!='DISABLE_STREAM'){

             var content ='<div class="chat chat-left">'+
             '<div class="chat-avatar">'+
             '<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="">'+
             '<img alt="" src="'+image+'" class="img-responsive img-circle">'+
             '</a>'+
             '</div>'+
             '<div class="chat-body">'+
             '<div class="chat-content">'+
             '<p><img alt="" src="'+base_url+'assets/images/download.png" class="img-responsive"></p>'+
             '<a href="'+file_name+'" target="_blank" download>Download</a>'+
             '<span class="chat-time">'+time+'</span>'+
             '</div>'+
             '</div>'+
             '</div>';
             $('#ajax').append(content); 

             $(".slimscrollleft.chats").mCustomScrollbar("update");
             $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 
             setTimeout(function() {
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  

            }, 3000);
             setTimeout(function() {
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  

            }, 1000);                 
           }


           else{


            var content ='<div class="chat chat-left">'+
            '<div class="chat-avatar">'+
            '<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="">'+
            '<img alt="" src="'+image+'" class="img-responsive img-circle">'+
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
            $(".slimscrollleft.chats").mCustomScrollbar("update");
            $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 
            setTimeout(function() {
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  

            }, 3000);
            setTimeout(function() {
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  

            }, 1000);

          }
          $(".slimscrollleft.chats").mCustomScrollbar("update");
          $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 


        });

}else{

 $.post(base_url+'user/get_new_message_count',{selected_user:message.senderId},function(res){ 
  $('#'+message.senderId).text(res);

});
}
}

}
};
messageClient.addEventListener(myListenerObj);

 </script>

 </body>
 </html> 