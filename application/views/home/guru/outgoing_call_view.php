<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php 
		$title = 'SchoolGuru';
		if($this->uri->segment(1) == 'dashboard'){
			$title = 'Dashboard';
		}
		if($this->uri->segment(1) == 'calendar'){
			$title = 'Calendar';
		}
		if($this->uri->segment(1) == 'mentors'){
			$title = 'Guru';
		}
		if($this->uri->segment(1) == 'applicants'){
			$title = 'Applicants';
		}
		if($this->uri->segment(1) == 'messages'){
			$title = 'Messages';
		}
		if($this->uri->segment(1) == 'conversations'){
			$title = 'Conversations';
		}
		?>
		<title><?php echo $title; ?> - SchoolGuru</title>
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.png"> 
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrapValidator.css" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>
		<?php if($this->uri->segment(1) == 'dashboard' || $this->uri->segment(2) =='dashboard#_=_' || $this->uri->segment(2) == 'dashboard'){ ?>
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/cropper.min.css">
		<?php } ?>
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap-datetimepicker.min.css" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" type="text/css">		<?php if($this->uri->segment(1) == 'calendar'){ ?>		<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/fullcalendar.min.css" type="text/css">		<?php } ?>		<?php if($this->uri->segment(2) == 'schedule_guru'){ ?>		<?php } ?>
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
    <input type="hidden" id="callUserName" placeholder="Username (alice)" value="<?php echo $today_conversation[0]['username']; ?>">
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
				<div>					<div class="message-bar">
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
		<!--  <section class="mainarea">    
			<div class="container">
				<div class="frame">
             <div class="card-box vdscreen" style="min-height: 450px;">
                <video autoplay id="incoming" style="display: inline;width:100%;"></video>
                <div class="opponentscreen" style="margin-bottom: 10px;">                    
                    <video muted autoplay id="outgoing" style="display: inline;height:200px;"></video>
                </div>
            </div>            
            <br>
            <div id="callLog" class="text-center">
            </div>
            <div class="error">
            </div>
            <div class="vcontrols" style="margin-top: 25px;">
                <div id="call">
                    <form id="newCall">
                        <ul>
                            <li class="btn btn-primary"><button><img src="<?php echo base_url(); ?>assets/images/micmute-icon.png"></button></li>
                            <li class="btn btn-success" id="call_again"><button ><img src="<?php echo base_url(); ?>assets/images/video-call.png"></button></li>
                            <li class="btn btn-danger">
                            <button id="hangup" type="button"><img src="<?php echo base_url(); ?>assets/images/call-drop-icon.png"></button></li>
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
<?php if($this->uri->segment(1) == 'dashboard' || $this->uri->segment(2) =='dashboard#_=_' || $this->uri->segment(2) == 'dashboard'){ ?> 
<script src="<?php echo base_url()."assets/" ?>js/cropper.min.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/main.js"></script>
<?php } ?>
<?php if($this->uri->segment(2) == 'schedule_guru'){ ?>
<?php } ?>
<?php if($this->uri->segment(1) == 'calendar'){ ?>
<script src="<?php echo base_url()."assets/" ?>js/jquery-ui.min.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/jquery.fullcalendar.js"></script>
<?php } ?>
<?php if($this->uri->segment(1) == 'mentors' || $this->uri->segment(1) == 'applicants'){ ?>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/jshashtable-2.1_src.js"></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/jquery.numberformatter-1.2.3.js"></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/tmpl.js"></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/jquery.dependClass-0.1.js"></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/draggable-0.1.js"></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/jquery.slider.js"></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/theia-sticky-sidebar.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/select2.min.js"></script>-->
<script>
    if( $("#price-input").length > 0) {
        $("#price-input").each(function() {
            var vSLider = $(this).slider({
                from: 10,
                to: 500,
                smooth: true, 
                step: 1,
                dimension: '&nbsp;$',
            }); 
        });
    }
</script>
<script>
    if( $("#age-input").length > 0) {
        $("#age-input").each(function() {
            var vSLider = $(this).slider({
                from: 21,
                to: 50,
                smooth: true, 
                step: 1,
                dimension: '&nbsp;',
            }); 
        });
    }
    $('.leftsidebar').theiaStickySidebar({
        additionalMarginTop: 30
    });
</script>
<?php } ?>
<script src="<?php echo base_url()."assets/" ?>js/bootstrapValidator.js" type="text/javascript"></script>
<?php if($this->session->userdata('role') == 1){ ?>
<script src="<?php echo base_url()."assets/" ?>js/guru.js" type="text/javascript"></script>
<?php } ?>
<?php if($this->session->userdata('role') == 0){ ?>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/applicant.js" type="text/javascript"></script>
<script> 
    $(function () {
        $('#choosedate').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD',
            minDate:new Date()
        }).on('dp.change', function(e) {
			// Revalidate the date field
			$(this).closest('form').bootstrapValidator('revalidateField', $(this).prop('name'));
		});
        $('#choosedate1').datetimepicker({
            useCurrent: false,
            format: 'HH:mm'
        }).on('dp.change', function(e) {
			// Revalidate the date field
			$(this).closest('form').bootstrapValidator('revalidateField', $(this).prop('name'));
		});
    });
</script>
<?php } ?>
<?php if($this->input->get('token') != ''){ ?>
<script>
    setTimeout(function(){
        window.location=base_url+'mentors';
    },7000);
</script>
<?php } ?>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap-notify.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/sinch/VIDEOsample.js"></script>
<!-- <script src="<?php echo base_url()."assets/" ?>js/sinch/messages.js"></script> -->
<script type="text/javascript">
    $('.radioBtn a').on('click', function(e){
        var sel = $(this).data('title');
        var append_id = $(this).data('value');
        $('#'+append_id).val(sel);
    //$("'#"+$(this).data('value')+"'").val(sel);
    if(sel==='N'){
        $(this).removeClass('notActive').addClass('active');    
        $(this).siblings('.Visible').removeClass('active').addClass('notActive ');
    }
    if(sel==='Y')
    {
        $(this).removeClass('notActive').addClass('active');    
        $(this).siblings('.Invisible').removeClass('active').addClass('notActive ');
    }
});
    function redirectCall()
    {
     setTimeout(function(){
       window.location=base_url+'user/meetings';
   },2000);
 }
</script>
<script type="text/javascript">
  $('.overlay').fadeIn(8000 , function(){
    $(this).css("display","none");
    $('#call_again').hide();
    // Making Video call  here 
		var callClient = sinchClient.getCallClient();
		callClient.initStream().then(function() { // Directly init streams, in order to force user to accept use of media sources at a time we choose
		$('div.frame').not('#chromeFileWarning').show();
		}); 
		if(!$(this).hasClass("incall") && !$(this).hasClass("callwaiting")) {
		clearError();
		$('button').addClass('incall');
		$('video').append('<div id="title">Calling ' + $('input#callUserName').val()+'...</div>');         
		console.log('Placing call to: ' + $('input#callUserName').val());
		call = callClient.callUser($('input#callUserName').val());
		call.addEventListener(callListeners);
		}
});
var to_username = $('input#callUserName').val();
  $.post('<?php echo base_url() ?>chat/get_messages',{to_username:to_username},function(res){       
        $('.chats').html(res); 
        $('#hidden_id').focus().addClass('hidden');       
    });
$('#receiver_id').val(to_username);
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
 var to_username = $('input#callUserName').val();
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
        if(message.senderId == $('input#callUserName').val()){
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
</script>
</body>
</html>