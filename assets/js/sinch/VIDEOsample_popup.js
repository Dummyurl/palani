var global_username = '';
var userrole = $('#user_role').val();


/*** After successful authentication, show user interface ***/

var showUI = function() {
	$('div#call').show();
	$('form#userForm').css('display', 'none');
	$('div#userInfo').css('display', 'inline');
	$('h3#login').css('display', 'none');
	$('video').show();
	$('span#username').text(global_username);
}
showUI();

/*** If no valid session could be started, show the login interface ***/

var showLoginUI = function() {
	//$('form#userForm').css('display', 'inline');
}


//*** Set up sinchClient ***/

sinchClient = new SinchClient({
	applicationKey: 'f06ae4f2-4980-40aa-89ca-9b98d80d70c4',
	//applicationKey: '673983ab-4c30-4e13-8631-c7d4967e0de2',
	capabilities: {calling: true, video: true, messaging: true},
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
		//console.log(message);
	}
});

sinchClient.startActiveConnection();

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



/*** Create user and start sinch for that user and save session in localStorage ***/

$('button#createUser').on('click', function(event) {
	event.preventDefault();
	$('button#loginUser').attr('disabled', true);
	$('button#createUser').attr('disabled', true);
	clearError();

	var signUpObj = {};
	signUpObj.username = $('input#username').val();
	signUpObj.password = $('input#password').val();

	//Use Sinch SDK to create a new user
	sinchClient.newUser(signUpObj, function(ticket) {
		//On success, start the client
		sinchClient.start(ticket, function() {
			global_username = signUpObj.username;
			//On success, show the UI
			showUI();

			//Store session & manage in some way (optional)
			localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
		}).fail(handleError);
	}).fail(handleError);
});


/*** Login user and save session in localStorage ***/

// $(document).on('click','.startVideo', function(event) {
// 	event.preventDefault();
	
// 	 clearError();
//          if(typeof localStorage[sessionName] == 'undefined'){
//                  return false;
//          }else{
            
//              $('#outgoing_call').modal({
//                            backdrop: 'static',
//                            keyboard: false  
//              });
            
//          }

// });




$(document).on('click','.startVideo', function(event) {
	event.preventDefault();
	
	clearError();
	if(typeof localStorage[sessionName] == 'undefined'){
		return false;
	}else{

	//	newpopup = window.open('user/outgoing','newwindow','width=1200, height=600');
			 // $('#vcall').hide();
          	var username  = $('input#callUserName').val();
  			$.post(base_url+'user/get_user_pic',{username:username},function(res){  		
  				$('.cong_icon_to').html(res);
  				$('#calling').html('<h2>'+username+'</h2>');
  			});
             $('#outgoing_call').modal({
                           backdrop: 'static',
                           keyboard: false  
             });

    //          $('#call_again').hide();

    //    // Making Video call  here 
            var callClient = sinchClient.getCallClient();
            callClient.initStream().then(function() { // Directly init streams, in order to force user to accept use of media sources at a time we choose
            $('div.frame').not('#chromeFileWarning').show();
            }); 

            if(!$(this).hasClass("incall") && !$(this).hasClass("callwaiting")) {
            clearError();

            $('button').addClass('incall');

            $('video').append('<div id="title">Calling ' + $('input#callUserName').val()+'...</div>');         
           // console.log('Placing call to: ' + $('input#callUserName').val());
            call = callClient.callUser($('input#callUserName').val());
            call.addEventListener(callListeners);                                                                                                                                                                                
            }

            
            
        }

    });




/*** Define listener for managing calls ***/

var callListeners = {
	onCallProgressing: function(call) {
		$('audio#ringtone').trigger("pause");

		//Report call stats
		//$('div#callLog').append('<div id="stats">Ringing...</div>');
	},
	onCallEstablished: function(call) {
		$('video#outgoing').attr('src', call.outgoingStreamURL);
		$('video#incoming').attr('src', call.incomingStreamURL);
		$('audio#ringback').trigger("pause");
		$('audio#ringtone').trigger("pause");


		$('#outgoing_header').hide();
		$('#vcall').hide();
		$('.removable').addClass('modal-header').removeClass('modal-body');
		$('#hangout').hide();
		$('.modal-hidden').removeClass('hidden').addClass('modal-body');



		//Report call stats
		var callDetails = call.getDetails();
		//$('div#callLog').append('<div id="stats">Answered at: '+(callDetails.establishedTime && new Date(callDetails.establishedTime))+'</div>');
	},
	onCallEnded: function(call) {


		$('#outgoing_header').show();
		$('#vcall').show();
		$('.removable').removeClass('modal-header').addClass('modal-body');
		$('#hangout').show();
		$('.modal-hidden').addClass('hidden').removeClass('modal-body');




		$('audio#ringback').trigger("pause");
		$('audio#ringtone').trigger("pause");

		$('video#outgoing').attr('src', '');
		$('video#incoming').attr('src', '');

		$('button').removeClass('incall');
		$('button').removeClass('callwaiting');
		if(userrole == 0 ){
		$('#rating_modal').modal({
                           backdrop: 'static',
                           keyboard: false  
                });
	     }
         $('#incoming_alert').modal('hide');
		 $('#outgoing_call').modal('hide');
		 $('#incoming_call').modal('hide');
		 $('div#title').remove();
			$('div#stats').remove();
		//Report call stats
		var callDetails = call.getDetails();
		//$('div#callLog').append('<div id="stats">Ended: '+new Date(callDetails.endedTime)+'</div>');
		//$('div#callLog').append('<div id="stats">Duration (s): '+callDetails.duration+'</div>');
		//$('div#callLog').append('<div id="stats">End cause: '+call.getEndCause()+'</div>');
		if(call.error) {
			//$('div#callLog').append('<div id="stats">Failure message: '+call.error.message+'</div>');
			$('#incoming_alert').modal('hide');
			$('#outgoing_call').modal('hide');
			$('#incoming_call').modal('hide');
			$('div#title').remove();
			$('div#stats').remove();
		}
	}
}

/*** Set up callClient and define how to handle incoming calls ***/

var callClient = sinchClient.getCallClient();
var call;

callClient.addEventListener({
  onIncomingCall: function(incomingCall) {



  	var username  = incomingCall.fromId;
		localStorage['incomingCall'] = incomingCall;
		localStorage['fromId'] = incomingCall.fromId;
		$.post(base_url+'user/get_user_pic',{username:username},function(res){  		
			 $('.cong_icon').html(res);
		});
		$('#incoming_alert').modal('show');

    
    $('#call_from h2').html(incomingCall.fromId);
	//Play some groovy tunes 
	$('audio#ringtone').prop("currentTime",0);
	$('audio#ringtone').trigger("play");

	//Print statistics
	//$('div#callLog').append('<div id="title">Incoming call from ' + incomingCall.fromId + '</div>');
	//$('div#callLog').append('<div id="stats">Ringing...</div>');
	$('button').addClass('incall');

	//Manage the call object
    call = incomingCall;
    call.addEventListener(callListeners);
	$('button').addClass('callwaiting');

	//call.answer(); //Use to test auto answer
	//call.hangup();
  }
});


/*** Make a new data call ***/

$('button#call').click(function(event) {
    
	callClient.initStream().then(function() { // Directly init streams, in order to force user to accept use of media sources at a time we choose
		$('div.frame').not('#chromeFileWarning').show();
	}); 
	event.preventDefault();
     
	if(!$(this).hasClass("incall") && !$(this).hasClass("callwaiting")) {
		clearError();
     
		$('button').addClass('incall');

		$('video').append('<div id="title">Calling ' + $('input#callUserName').val()+'...</div>');
//                 $('#calling').modal({
//                               backdrop: 'static',
//                               keyboard: false  
//                 });
		console.log('Placing call to: ' + $('input#callUserName').val());
		call = callClient.callUser($('input#callUserName').val());

		call.addEventListener(callListeners);                                                                                                                                                                                 
	}
});

$('button#answer').click(function(event) {
    
	event.preventDefault();

	 $('#outgoing_call').modal('hide');

        $('div#title').remove();
                    $('div#stats').remove();
	if($(this).hasClass("callwaiting")) {
		clearError();
		try {
			call.answer();
			
			$('button').removeClass('callwaiting');
                        $('#incoming_alert').modal('hide');
                       
                        $('#incoming_call').modal({
                           backdrop: 'static',
                           keyboard: false  
                        });
                        $('#calling').modal('hide');
   
		}
		catch(error) {
			handleError(error);
		}
	}
});



/*** Hang up a call ***/

$('button#hangup').click(function(event) {
	event.preventDefault();
         $('div#title').remove();
	 $('div#stats').remove();
         
         $('#incoming_alert').modal('hide');
         $('#incoming_call').modal('hide');    
         $('#outgoing_call').modal('hide');
        
         
	if($(this).hasClass("incall")) {
		clearError();
		
		console.info('Will request hangup..');

		call && call.hangup();
		
	}
});

$('button#mute').click(function(event) {
	event.preventDefault();
	 $(this).attr('id','unmute');
     $('#newCall li').eq(1).removeClass('btn-danger');
	 $('#newCall li').eq(1).addClass('btn-primary');
	 //$('video#outgoing').removeAttr('muted');
	
});

$('button#unmute').click(function(event) {
	 event.preventDefault();
	 $(this).attr('id','mute');
         $('#newCall li').eq(1).removeClass('btn-primary');
	 $('#newCall li').eq(1).addClass('btn-danger');
	 //$('video#outgoing').attr('muted','true');
	
});

/*** Log out user ***/

function sinchLogout(){
	clearError();
	//Stop the sinchClient
	sinchClient.terminate();
	//Note: sinchClient object is now considered stale. Instantiate new sinchClient to reauthenticate, or reload the page.

	//Remember to destroy / unset the session info you may have stored
	delete localStorage[sessionName];
	//Reload page.
	window.location=base_url+'logout';
};


/*** Handle errors, report them and re-enable UI ***/

var handleError = function(error) {
	//Show error
	$('div.error').text(error.message);
	$('div.error').show();
}

/** Always clear errors **/
var clearError = function() {
	$('div.error').hide();
}

/** Chrome check for file - This will warn developers of using file: protocol when testing WebRTC **/
if(location.protocol == 'file:' && navigator.userAgent.toLowerCase().indexOf('chrome') > -1) {
	$('div#chromeFileWarning').show();
}

$('button').prop('disabled', false); 

