 <!DOCTYPE html>
 <html>
 <head>
  <meta charset="utf-8" />
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Conversations - Mentori</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/images/favicon.png"> 
  <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrapValidator.css" type="text/css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/responsive.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/animate.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/jquery.mCustomScrollbar.min.css" type="text/css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css"> 
  <script> var base_url = '<?php echo base_url(); ?>'; </script>
  <script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  <script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>
  <script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js"></script>
  <script src='<?php echo base_url()."assets/" ?>js/moment.js'></script>
  <script src="<?php echo base_url()."assets/" ?>js/bootstrap-notify.js"></script>
  <script src='<?php echo base_url()."assets/" ?>js/jquery.mCustomScrollbar.concat.min.js'></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>  
  <!-- Tok Box  -->
  <script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
  <!-- Polyfill for fetch API so that we can fetch the sessionId and token in IE11 -->
  <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@7/dist/polyfill.min.js" charset="utf-8"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fetch/2.0.3/fetch.min.js" charset="utf-8"></script>

  <style type="text/css">
    @media only screen and (max-width: 767px){
      .video-chat-wrapper .video-chat-blk{
        width:100%;
      }
    }
  </style>
</head>
<body>  


  <div class="overlay">
    <div id="loading-img"></div>
  </div>
  <!-- video call alert notification  -->
  <div class="new_call form-group"></div>
  <div class="notification alert alert-danger"></div>
  <audio id="ringtone" src='<?php echo base_url();?>assets/css/style/ringback.wav' loop></audio>



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

  <input type="hidden" id="call_duration" value="call_duration" >
  <input type="hidden" id="call_started_at" value="call_started_at" >
  <input type="hidden" id="call_ended_at" value="call_ended_at">
  <input type="hidden" id="sinch_username" value="<?php echo $currentuser['username']; ?>"> <!-- session user  -->
  <input type="hidden" id="user_role" value="<?php echo $currentuser['role']; ?>"> 
  <input type="hidden" id="channel" value="<?php echo base64_decode($this->uri->segment(4)); ?>">  
  <input type="hidden" id="call_to" value="<?php echo base64_decode($this->uri->segment(3)); ?>">   <!-- to username -->
  <input type="hidden" id="url" value="<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
  <section class="video-chat-wrapper">  
      <div align="center" id="muted_image">
    <img src="<?php echo $imge; ?>" class="img">
    <input type="hidden" name="" id="subscriber_image" value="<?php echo $imge ?>">
  </div>
   <div class="video-section" id="video-background"> <!-- id="video-background" -->
    <div class="video-chat-blk">
     <div class="chat-contents animated showchatbox">
      <div class="show-chat-header">
       <button class="btn-chat-close pull-right">Hide Messsage <i class="fa fa-angle-down" aria-hidden="true"></i></button>
     </div>
     <div class="show-chat-contents chat-box slimscrollleft">
       <div class="chats"></div>
     </div>
   </div>      
 
  <div id="disconnected" class="alert alert-danger"></div>                          
</div>  
</div>
</section>

<div class="video-controls hidden-xs">
  <div class="my-cam-control"> 
   <div class="sd">
    <ul class="list-unstyled list-inline text-center">
      <li>
        <a href="javascript:;" class="mikemute">
          <span>
            <img style="opacity:0.2" class="img img-responsive hidden" id="mute_audio"   src="<?php echo base_url(); ?>assets/images/microphone.png" />
            <img style="opacity:0.2" class="img img-responsive hidden" id="unmute_audio"   src="<?php echo base_url(); ?>assets/images/images/microphone.png" />
          </span></a>
      </li>
      <li><a href="javascript:;" class="vcend">
        <span>
          <img class="img img-responsive hidden" id="call_btn"  src="<?php echo base_url(); ?>assets/images/call-dark.png" onclick="update_channel()"/>
          <img class="img img-responsive hidden" id="end_btn"  src="<?php echo base_url(); ?>assets/images/images/call-dark.png" onclick="delete_channel()"/>
        </span></a></li>
      <li><a href="javascript:;" class="vcvideop" id="cut" >
        <span>
          <img class="img img-responsive hidden" id="unmute_video" src="<?php echo base_url(); ?>assets/images/facetime-button.png" />
          <img class="img img-responsive hidden" id="mute_video" src="<?php echo base_url(); ?>assets/images/images/facetime-button.png" />
        </span></a>
      </li>
    </ul>    
  </div>                                                
</div>
<!-- Chat Box Start -->
<div class="chat-option">
 <span class="chat-control text-left">
  <a data-toggle="collapse" data-target=".chat-blk" href="javascript:void(0)">
    <span class="chat-box-img">
      <img class="img img-responsive chat-icon" src="<?php echo base_url(); ?>assets/images/chat.png" />
    </span></a>
  </span>
  <div class="chat-blk collapse">
    <div class="faq-wrapper-chat">                              
      <div class="panel-group" id="chat-blk">
        <div class="panel chat-panel">
          <div class="panel-heading">
            <h3 class="panel-title">   
              <span class="chat-show-hide custom-show-hide pull-right">
                <a href="javascript:void(0)" class="show-all">Show Message</a>
              </span>                        
              <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#faq-blk" href="#faq1">
                <div class="chat-footer">
                  <div class="message-bar">
                    <div class="message-inner">
                      <div class="message-area">
                        <span><a class="link attach-icon" href="javascript:void(0)" data-toggle="modal" data-target="#drag_files"><img src="<?php echo base_url(); ?>assets/images/attachment.png" alt=""></a></span>
                        <img src="<?php echo base_url(); ?>assets/images/chat-leftarrow.png" class="img-responsive" alt="" id="close-hide"> 
                        <input type="hidden" name="sender_id" id="sender_id" value="<?php echo $this->session->userdata('applicant_id'); ?>">
                        <!-- form -->
                        <form name="chat_form" id="chat_form" onsubmit="return false;">
                          <div class="input-group v1-group">

                           <input type="text" class="form-control" placeholder="Type message..." id="input_message" autocomplete="off">
                           <input type="file" name="userfile" id="user_file" class="hidden">             
                           <input type="hidden" id="receiver_id"  name="receiver_id"> 
                           <input type="hidden" id="to_user_id" value="<?php echo base64_decode($this->uri->segment(5)); ?>" name="to_user_id">
                           <input type="hidden" name="time" id="time" >
                           <input type="hidden" name="img" id="img" value="<?php echo $img; ?>">

                           <span class="input-group-btn chat-send-ct">
                            <button class="btn btn-custom chat-send" type="submit">
                              <img src="<?php echo base_url(); ?>assets/images/send.png" class="img-responsive" ></button>
                            </span>                                                 
                          </div>
                        </form>
                        <!-- form ends -->

                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </h3>
          </div>
        </div>
      </div>                        
    </div>
  </div>                    
</div>
<!-- Chat Box end -->
</div>  
<div class="videocontrols-mob visible-xs">
    <ul>
        <li> <a href="javascript:void();"><img class="img img-responsive hidden" id="mute_audio"   src="<?php echo base_url(); ?>assets/images/videochat/mute_mob.png" /></a></li>
        <li> <a href="javascript:void();"><img class="img img-responsive hidden" id="mute_audio"   src="<?php echo base_url(); ?>assets/images/videochat/endcall_mob.png" /></a></li>
        <li> <a href="javascript:void();"><img class="img img-responsive hidden" id="mute_audio"   src="<?php echo base_url(); ?>assets/images/videochat/videocalll_mob.png" /></a></li>
         <li> <a href="javascript:void();"><img class="img img-responsive hidden" id="mute_audio"   src="<?php echo base_url(); ?>assets/images/videochat/chat_mob.png" /></a></li>
    <ul>
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
<input type="hidden" id="currentUserName" value="<?php echo $currentuser['first_name'].' '.$currentuser['last_name']; ?>">
<div class="chat-users-new">
 <div align="center" id="muted_image_me" class="muted-img">
   <img src="<?php echo $img ?>" class="img-responsive">
   <input type="hidden" name="" id="publisher_image" value="<?php echo $img ?>">
 </div>         
 <div class="chat-user-window pull-right" id="outgoing" style="height:250px;width: 350px;">
 </div>           
</div>
</div>
</div>
</div>
</div>
</section>       



<script type="text/javascript">
  $(document).ready(function () {
   // $('#mute_audio,#unmute_video,#end_btn').removeClass('hidden');
    

    $(".chat-box-img").click(function(){
     $(".chat-icon").hide(500);
   });
    $("#close-hide").click(function(){
     $(".chat-blk").collapse("hide").slow;
     $('.chat-icon').show(500);
   });
   //  $("#input_message").focus(function(){
   //   $(".chat-contents").show();
   //   $(".chat-show-hide").hide();
   // });
   $(".chat-show-hide").click(function(){
     $(".chat-contents").show();
     $(".chat-show-hide").hide();
   }); 

   $(".btn-chat-close").click(function(){
     $(".chat-contents").hide();
     $(".chat-show-hide").show();
   });
   $('.fa-angle-double-right').click(function () {
    $(this).toggleClass('fa-angle-double-right fa-angle-double-left');
  });
   $('.user-list-icon').on('click', function(event) {        
    $('.chat-user-list').toggle('show');
  });
 });

   // Get old Messages from database

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



          if(current_date_time > to_date_time){  // Nofity before fifteen minutes             



            var diff = moment.duration(moment(after_fifteen_minutes).diff(moment(current_date_time)));
            
            var seconds = parseInt(diff.asSeconds());
            var days = parseInt(diff.asDays());  // Remaining days 
            var hours = parseInt(diff.asHours()); 
            var seconds = diff._data.seconds;
            hours = hours - days*24;  // Remaining Hours 
            var minutes = parseInt(diff.asMinutes()); 
            remainin_minutes_end = minutes - (days*24*60 + hours*60); //Remaning Minutes 

            if(remainin_minutes_end < 1){
              $('.notification').html('This call will disconnect in 00:0'+remainin_minutes_end+':'+seconds);
            }else{
              $('.notification').html('This call will disconnect in '+remainin_minutes_end+' minutes.');
            }
            if(remainin_minutes_end == 0 && seconds < 1  ){              
              swal({ 
               title: "Oops!",
               text: "Call disconnected !",
               type: "error" ,
               icon: 'error'
             });     
              setTimeout(function() {
                var url = $('#url').val();      
                window.open(url, '_self', ''); 
                window.close();     
              }, 1000);       

            }
          }
        },1000);
    }




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


    // $(".video-background").click(function(){
    //   $(this).toggleClass("video-backgroundalt");
    // });
    $('.attach-icon').click(function(){
      $('#user_file').click();
    });






 // Fetching Time 
 function clock() {
  var time = new Date();

  time = time.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });
  $('#time').val(time);
  setTimeout('clock()',1000);
}
clock();




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

  $('.chat-send').click(function(){

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
    //$('.new_call').html(message.message);
    var status = message.message;


    if(status == 'Injecting ICE candidate directly' || status == 'Call established'){        
      // $('.new_call').addClass('alert').addClass('alert-success').html('Connected');
      $('.overlay').hide();
      setTimeout(function() {
        update_log();
      }, 2000);
      
    }
    if(status == 'Successfully started SinchClient'){
     // $('.new_call').html('Connecting...');

     $('.overlay').hide();
   }else if(status == 'Call ended'){
     // $('.new_call').removeClass('alert').removeClass('alert-success').html('');
         // window.location.reload();
       }



     },onLogMxpMessage: function(message) {
      // $('.new_call').html(message.message);
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

  var d = new Date(); // for now
var h = d.getHours(); // => 9
var m  = d.getMinutes(); // =>  30
var s = d.getSeconds(); // => 51


var call_ended_at = h+':'+m+':'+s;   

var invite_id = $('#invite_id').val();
var to_user_id =$('#to_user_id').val();
var time =$('#time').val();
var start_time = $('#call_started_at').val();

$.post('<?php echo base_url(); ?>user/delete_channel',{            
 invite_id:invite_id,
 to_user_id :to_user_id,
 start_time : start_time,
 end_time:call_ended_at,
 call_status : 0
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


function delete_channel(){
  var invite_id = $('#invite_id').val();
  $.post('<?php echo base_url(); ?>chat/delete_channel',{invite_id:invite_id},function(res){
    window.close();
  });
}
function update_channel(){
    $('#call_btn').addClass('hidden');
    $('#end_btn').removeClass('hidden');
  $('.new_call').html('Ringing..');
  $('audio#ringtone').trigger("play");
  $('.vccall').addClass('hidden');
  var call_to = $('#call_to').val();
  var channel = $('#channel').val();
  var invite_id = $('#invite_id').val();
  var url = $('#url').val();

  var invite_id = $('#invite_id').val();
  $.post('<?php echo base_url(); ?>chat/update_channel',
  {            
    call_to:call_to,
    channel : channel,
    invite_id : invite_id,
    url:url,
    status:1    
  },function(res){
    console.log(res);  
  });


}


function join_call(){

  //return false;
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
    var obj = jQuery.parseJSON(res);
    if(obj.error){
      swal({ 
       title: "Oops!",
       text: "User already in call!",
       type: "error" ,
       icon: 'error'
     });     

      setTimeout(function() {
        var url = $('#url').val();      
        window.open(url, '_self', ''); 
        window.close();     
      }, 2000); 
      return false;
    }

    if(obj.new_call == true){
      $('.new_call').html('Ringing...');
      $('audio#ringtone').trigger("play");
    }


// start 
    var apiKey = obj.apiKey;    
    var sessionId = obj.sessionId;   
    var token = obj.token;
    var currentUserName = $('#currentUserName').val();
    var publisherOptions = {      
      insertMode: 'append',
      width: '100%',
      height: '100%',      
      name: currentUserName,
      style: { nameDisplayMode: "on" }
    };


    var session = OT.initSession(apiKey, sessionId);
    /*Initialize the publisher*/  
    var publisher = OT.initPublisher('outgoing', publisherOptions, handleError);
    $('#muted_image_me,.vccall').addClass('hidden');
    $('.vcend,.vcvideop,.mikemute').removeClass('hidden'); 

    $('#mute_audio,#unmute_video,#end_btn').removeClass('hidden');
    
    

    var publisher_image = $('#publisher_image').val();
    // Connect to the session
    session.connect(token, function callback(error) {
      if (error) {
        handleError(error);
      } else {
    // If the connection is successful, publish the publisher to the session
    session.publish(publisher, handleError);

    // if (publisher.stream.hasVideo) {
    //   var imgData = publisher.getImgData();
    //   publisher.setStyle('backgroundImageURI', publisher_image);
    // } else {
    //   publisher.setStyle('backgroundImageURI', publisher_image);
    // }


  }
});


     // Subscribe to a newly created stream
     session.on('streamCreated', function streamCreated(event) {
      var subscriberOptions = {
        insertMode: 'append',
        width: '100%',
        height: '100%'
      };
      $('.new_call').html('');
      $('audio#ringtone').trigger("pause");
      $('#muted_image').addClass('hidden');
      $('#call_started_at').val("<?php echo date('H:i:s') ?>");
       $('#call_btn').addClass('hidden');
        $('#end_btn').removeClass('hidden');
      var subscriber_image = $('#subscriber_image').val();
      var subscriber = session.subscribe(event.stream, 'video-background', subscriberOptions, handleError);

      if (subscriber.stream.hasVideo) {
        var imgData = subscriber.getImgData();
        subscriber.setStyle('backgroundImageURI', subscriber_image);
      } else {
        subscriber.setStyle('backgroundImageURI', subscriber_image);
      }       
      /* Update Call status */
      $.post('<?php echo base_url(); ?>chat/update_call_status',{call_status:1},function(res){

      });
    });



     session.on("streamDestroyed ", function streamDestroyed (event) {
      //console.log(event);
      update_log();


      $('.vccall,#muted_image,#call_btn,#end_btn').removeClass('hidden');      
       
    });


     $('.vcvideop').click(function(){         
      if($(this).hasClass('active')){
        $(this).removeClass('active'); 
        $('#mute_video').addClass('hidden');
        $('#unmute_video').removeClass('hidden');                
        publisher.publishVideo(true);         
      }else{
        $(this).addClass('active'); 
         $('#mute_video').removeClass('hidden');
        $('#unmute_video').addClass('hidden');
        publisher.publishVideo(false);
      }
        //console.log(stream);
      });  

     $('.mikemute').click(function(){         
      if($(this).hasClass('active')){
        $('#mute_audio').removeClass('hidden');         
        $('#unmute_audio').addClass('hidden');
        $(this).removeClass('active');                 
        publisher.publishAudio(true);         
      }else{
        $('#mute_audio').addClass('hidden');
        $('#unmute_audio').removeClass('hidden');         
        $(this).addClass('active');                                
        publisher.publishAudio(false);
      }
        //console.log(stream);
      }); 

       // Stop 



      // $('#call_id').val(res);
    });



  $('#disconnected').html('');
  var channel = $('#channel').val();


  setInterval(function() {     
    var invite_id = $('#invite_id').val();
    $.post('<?php echo base_url(); ?>chat/mute_ringing',
    {           
      invite_id : invite_id    
    },function(res){      


      var obj  = jQuery.parseJSON(res);    
      if(obj.session == 1){
        $('.new_call').html('');
        $('audio#ringtone').trigger("pause");
        $('.notification').html('Call not responded!');
        $('.vccall').removeClass('hidden');
        setTimeout(function() {
          $('.notification').html('');
        }, 2000);        
      }else if(obj.session == 0 ) {
        $('.new_call').html('');
        $('audio#ringtone').trigger("pause");
        $('.notification').html('Call rejected!');
        $('.vccall').removeClass('hidden');
        setTimeout(function() {
          $('.notification').html('');
        }, 2000);        
      }        
    });
  }, 25000);

}

join_call();
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

function handleError(error){
  console.log(error);
}

</script>  
<script>
    
   
          $(".chat-show-hide").click(function(){
               if ($(window).width() < 767) {
                    $("#outgoing").hide();
              } 

  });
           $(".show-chat-header").click(function(){
               if ($(window).width() < 767) {
                    $("#outgoing").show();
              } 

  });
</script>   
</body>
</html>