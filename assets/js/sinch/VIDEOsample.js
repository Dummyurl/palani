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

		if(message.message == 'Successfully started SinchClient'){
			$('.overlay').hide();
		}
		if(message.code == 4000)
		{
			var signInObj = {};
			var username  = $('#sinch_username').val();
			var password  = $('#sinch_username').val();
			if(username!=''){

				signInObj.username = $('#sinch_username').val();
				signInObj.password = $('#sinch_username').val();
				sinchClient.start(signInObj, function() {
					global_username = signInObj.username;
					localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
					//window.location = base_url+"dashboard?notify=true";
				}).fail(handleError);
			}
		}
	// console.log(message.message);
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
		// global_username = sessionObj.userId;		
		// localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
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

$(document).on('click','.startVideo', function(event) {
	event.preventDefault();
	// console.log('test');
	// return false;
	var url  = $(this).attr('href');	
	var id  = $(this).attr('userid');	

	$.post(base_url+'chat/check_status',{id:id},function(res){
		var obj = jQuery.parseJSON(res);
		if(obj.call_status == 0){
			newpopup = window.open(url,'newwindow','width=1200, height=790');		
		}else if(obj.call_status == 1){
			
			swal({ 
               title: "Oops!",
               text: "User already in call!",
               type: "error" ,
               icon: 'error'
             });  
		}
	});	
});

$(document).on('click','.startAudio', function(event) {
	event.preventDefault();
	var url  = $(this).attr('href');	
	var id  = $(this).attr('userid');	
	$.post(base_url+'chat/check_status',{id:id},function(res){
		var obj = jQuery.parseJSON(res);
		if(obj.call_status == 0){
			newpopup = window.open(url,'newwindow','width=1200, height=790');		
		}else if(obj.call_status == 1){			
			swal({ 
               title: "Oops!",
               text: "User already in call!",
               type: "error" ,
               icon: 'error'
             });     

		}
	});
});


function sinchLogout(){
	//sinchClient.terminate();	
	//Remember to destroy / unset the session info you may have stored
	//delete localStorage[sessionName];
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

