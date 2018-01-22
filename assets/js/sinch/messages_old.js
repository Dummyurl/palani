

/*** Send a new message ***/

var messageClient = sinchClient.getMessageClient();

$('form#chat_form').on('submit', function(event) {
	event.preventDefault();
	clearError();

	var recipients = $('input#recipients').val();
	var input_message = $('input#input_message').val();

	//Create new sinch-message, using messageClient
	var sinchMessage = messageClient.newMessage(recipients, input_message);
	//Send the sinchMessage
	messageClient.send(sinchMessage).fail(handleError);

	  var selected_user = $('input#receiver_id').val();
	  var input_message = $('input#input_message').val();
	  $.post(base_url+'user/send_chat',{selected_user:selected_user,input_message:input_message},function(response){
	     // $('.chats').append(response);
	      $('input#input_message').val('');
	      $(".chat-send-btn").addClass('disabled');
	  });
});

$(document).on('keypress','#input_message',function(e){
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code == 13) {
        $(".chat-send-btn").trigger('click');
        return false;
    }
});

$(document).on('click','.chat-send-btn',function(event){

    event.preventDefault();
	clearError();

	var recipients = $('input#recipients').val();
	var input_message = $('input#input_message').val();
	
	//Create new sinch-message, using messageClient
	var sinchMessage = messageClient.newMessage(recipients, input_message);
	//Send the sinchMessage
	messageClient.send(sinchMessage).fail(handleError);

      var selected_user = $('input#receiver_id').val();
      var input_message = $('input#input_message').val();
      $.post(base_url+'user/send_chat',{selected_user:selected_user,input_message:input_message},function(response){
        // $('.chats').append(response);
          $('input#input_message').val('');
          $(".chat-send-btn").prop('disabled', true);
      });
});


$('form#newRecipient').on('submit', function(event) {
	event.preventDefault();
	$('form#chat_form').show();
	$('input#input_message').focus();
});

/*** Handle incoming messages ***/

var eventListener = {
	onIncomingMessage: function(message) {
		
		//$('.chats').prepend('<div class="msgRow" id="'+message.messageId+'"></div><div class="clearfix"></div>');

		/*$('div.msgRow#'+message.messageId)
			.attr('class', global_username == message.senderId ? 'me' : 'other')
			.append([
				'<div id="from">'+message.senderId+' <span>'+message.timestamp.toLocaleTimeString()+(global_username == message.senderId ? ',' : '')+'</span></div>', 
				'<div id="pointer"></div>',
				'<div id="textBody">'+message.textBody+'</div>',
				'<div class="recipients"></div>'
			]);*/
       $('div.chats')
			.attr('class', global_username == message.senderId ? 'me' : 'other')
			.append([
				'<div class="chat">'+
                    '<div class="chat-avatar">'+
                    '<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="">'+
                    '<img alt="" src="'+$('.topprfpic img').attr('src')+'" class="img-responsive img-circle">'+
                    '</a>'+
                    '</div>'+
                    '<div class="chat-body">'+
                    '<div class="chat-content">'+
                    '<p>'+message.textBody+'</p>'+
                    '<span class="chat-time">'+message.timestamp.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true })+'</span>'+
                    '</div>'+
                    '</div>'+
                '</div>'
			]);
           if(global_username != message.senderId){
					$.notify({
						// options
						message: message.senderId+'<br><br>'+message.textBody 
					},{
						// settings
						type: 'success'
					});	
	       }
	}
}

messageClient.addEventListener(eventListener);


/*** Handle delivery receipts ***/ 

var eventListenerDelivery = {
	onMessageDelivered: function(messageDeliveryInfo) {
		//$('div#'+messageDeliveryInfo.messageId+' div.recipients').append(messageDeliveryInfo.recipientId + ' ');
		$('div#'+messageDeliveryInfo.messageId+' div.recipients').append('<img style="width:10px;margin-top:10px;" src="'+base_url+'assets/css/style/delivered_green.png" title="'+messageDeliveryInfo.recipientId+'">');
	}
}

messageClient.addEventListener(eventListenerDelivery);

