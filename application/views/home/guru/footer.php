	<!-- Video call Popup Here  -->
	<!--<div class="modal fade bs-example-modal-lg" id="incoming_call" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="position: relative !important;">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3>Video call</h3>
				</div>
				<div class="modal-body">
					<div class="frame">
						<div class="card-box vdscreen" style="min-height: 450px;">
							<video autoplay id="incoming" style="display: inline;width:100%;"></video>
							<div class="opponentscreen" style="margin-bottom: 10px;">
								<video muted autoplay id="outgoing" style="display: inline;height:200px;"></video>
							</div>
						</div>
						<input type="hidden" id="callUserName" placeholder="Username (alice)" value="<?php echo $this->uri->segment(3); ?>"><br>
						<div id="callLog"></div>
						<div class="error"></div>
						<div class="vcontrols" style="margin-top: 25px;">
							<div id="call">
								<form id="newCall">
									<ul>
										<li class="btn btn-danger">
											<button id="mute_mic" type="button"><img src="<?php echo base_url(); ?>assets/images/micmute-icon.png"></button>
										</li>
										<li class="btn btn-success" id="call_again">
											<button id="call"><img src="<?php echo base_url(); ?>assets/images/video-call.png"></button>
										</li>
										<li class="btn btn-danger">
											<button id="hangup"><img src="<?php echo base_url(); ?>assets/images/call-drop-icon.png"></button>
										</li>
									</ul>
									<audio id="ringback" src='<?php echo base_url();?>assets/css/style/ringback.wav' loop></audio>
									<audio id="ringtone" src='<?php echo base_url();?>assets/css/style/phone_ring.wav' loop></audio>
								</form>
							</div>   
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
-->

<!-- Video call Popup Ends Here  -->

<style type="text/css">
.success-signup .cong_icon {padding: 0 !important;}
</style>
<!-- Ringing Popup here  -->
<div class="modal fade" id="incoming_alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="success-signup" id="signup_applicant_modal">
					<div class="cong_icon"><i class="fa fa-check"></i></div>
					<h2>Incoming Call!</h2>
					<div id="call_from"><h2></h2></div>
				</div>
			</div>
			<form id="newCall">
				<div class="modal-body text-center">
					<button type="button" id="answer" class="btn btn-success" >Answer</button>
					<button type="button" id="hangout" class="btn btn-default" data-dismiss="modal">Reject</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade bs-example-modal-lg" id="rating_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3>Rate the Guru!</h3>
			</div>
			<div class="modal-body">
				<div class="rating text-center" data-calc="4.7" style="margin-bottom: 30px;">
					<a href="javascript:void(0)" class="star" id="st_1" data-seq="1"><i class="fa fa-star" style="font-size:30px;"></i></a>
					<a href="javascript:void(0)" class="star" id="st_2" data-seq="2"><i class="fa fa-star" style="font-size:30px;"></i></a>
					<a href="javascript:void(0)" class="star" id="st_3" data-seq="3"><i class="fa fa-star" style="font-size:30px;"></i></a>
					<a href="javascript:void(0)" class="star" id="st_4" data-seq="4"><i class="fa fa-star" style="font-size:30px;"></i></a>
					<a href="javascript:void(0)" class="star" id="st_5" data-seq="5"><i class="fa fa-star" style="font-size:30px;"></i></a>
				</div>
				<div class="text-center" style="margin-bottom: 30px;">
					<textarea id="rating_comment" class="form-control" name="rating_comment" placeholder="Comments (optional)"></textarea> 
				</div>
				<div class="text-center">
					<input type="hidden" name="rating" id="rating_value" />
					<input type="hidden" name="invite_id" id="invite_id" />
					<input type="hidden" name="mentor_id" id="mentor_id" />
					<button type="button" id="send_rating" class="btn btn-success text-center" >Submit</button>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</section>
<footer>
	<div class="container">
		<div class="thoughts">
			Thoughts on our application?<br>
			<a href="javascript:void(0);" data-target="#let_us_know" data-toggle="modal">Let us know!</a>
		</div>
		©2017 <a href="<?php echo base_url(); ?>login">School Guru</a>. All rights reserved. <a href="<?php echo base_url(); ?>privacy-policy">Privacy Policy</a> and <a href="<?php echo base_url(); ?>terms-conditions">Terms & Conditions</a>.
	</div>    
</footer>

<!-- Let us know  -->
<div class="modal fade bs-example-modal-md" id="let_us_know" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3>Share your thoughts</h3>
			</div>
			<form id="general_feedback">
				<div class="modal-body">   
					<div class="form-group">
						<label class="control-label">Name</label>
						<input type="text" name="feedbacker_name" id="feedbacker_name" class="form-control" required>
					</div>
					<div class="form-group">
						<label class="control-label">Email</label>
						<input type="email" name="feedbacker_email" id="feedbacker_email" class="form-control" required>
					</div>
					<div class="form-group">
						<label class="control-label">Comments</label>
						<textarea class="form-control" name="feedbacker_comment" id="feedbacker_comment"  rows="6" required></textarea>
					</div>
				</div>
				<div class="modal-footer text-right">
					<button class="btn btn-primary" type="submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Let us know  -->

<div class="sidebar-overlay" data-reff="#sidebar"></div>
<script> 
	var base_url = '<?php echo base_url(); ?>'; 
	var segment = '<?php echo $this->uri->segment(1); ?>'; 
</script>
<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src='<?php echo base_url()."assets/" ?>js/moment.js'></script>
<script src='<?php echo base_url()."assets/" ?>js/jquery.mCustomScrollbar.concat.min.js'></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.form.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>


<script src="<?php echo base_url()."assets/" ?>js/jquery.password-validation.js" type="text/javascript"></script>		
<script>
	$(document).ready(function() {

		$('.note').hide();
		$("#password").passwordValidation({"confirmField": "#confirm_password"}, function(element, valid, match, failedCases) {
			$("#errors").html("<pre>" + failedCases.join("\n") + "</pre>");
			if(valid){	
				$('.account-btn').attr('disabled','false');
				$('.account-btn').removeAttr('disabled');
			}
			if(!valid){					
				$('.account-btn').attr('disabled','true');				
			}

			if(!valid || !match){							
				$('.account-btn').attr('disabled','true');				
			}
			if(valid && match){							
				$('.account-btn').removeAttr('disabled');
			}
		});

		$('#change_pwd_form').submit(function(){
			$.ajax({
				url:'<?php echo base_url(); ?>user/change_password',
				data:$('#change_pwd_form').serialize(),
				method:'POST',
				dataType: "JSON",
				success: function(data)
				{

		            if(data.status == true) //if success close modal and reload ajax table
		            {
		            	$('#change_pwd_form')[0].reset();
		            	$('.note').show();
		            	setTimeout(function() {
		            		$('.note').hide();
		            		$('#change_pwd').modal('hide');
		            	}, 2000);
		            }
		            else
		            {
		            	for (var i = 0; i < data.inputerror.length; i++) 
		            	{
		                    $('[name="'+data.inputerror[i]+'"]').next().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
		                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
		                }
		            }   
		             //set input/textarea/select event when change value, remove class error and remove text help block 
		             $("input").keyup(function(){
		             	$(this).parent().parent().removeClass('has-error');
		             	$(this).next().empty();
		             });


		         },
		         error: function (jqXHR, textStatus, errorThrown)
		         {
		         	alert('Error adding / update data');
        	 //set input/textarea/select event when change value, remove class error and remove text help block 
        	 $("input").keyup(function(){
        	 	$(this).parent().parent().removeClass('has-error');
        	 	$(this).next().empty();
        	 });


        	}
        });
			return false;
		});

		    //set input/textarea/select event when change value, remove class error and remove text help block 
		    $("input").keyup(function(){
		    	$(this).parent().parent().removeClass('has-error');
		    	$(this).next().empty();
		    });

		});
	</script>









	<script type="text/javascript">
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
          var to_username = $('#recipients').val();
          var img = $('#img').val();
          var time = $('#time').val();
          if(obj.type == 'image'){
          	var image_src = obj.img;
          }else{
          	var image_src ='assets/images/download.png';
          }


          var content ='<div class="chat">'+
          '<div class="chat-avatar">'+
          '<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="">'+
          '<img alt="" src="'+img+'" class="img-responsive img-circle">'+
          '</a>'+
          '</div>'+
          '<div class="chat-body">'+
          '<div class="chat-content">'+
          '<p><img alt="" src="'+base_url+'/'+image_src+'" class="img-responsive"></p>'+
          '<a href="'+base_url+'/'+obj.img+'" target="_blank" download>Download</a>'+
          '<span class="chat-time">'+time+'</span>'+
          '</div>'+
          '</div>'+
          '</div>';
          $('#ajax').append(content); 
          $('#user_file').val('');

          $(".slimscrollleft.chats").mCustomScrollbar("update");
          $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 


          // Get the messageClient
          var messageClient = sinchClient.getMessageClient(); 
          // Create a new Message
          var message = messageClient.newMessage(to_username,'file');
          // Send it
          messageClient.send(message); 
          setTimeout(function() {
          	$(".slimscrollleft.chats").mCustomScrollbar("update");
          	$(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 
          }, 3000);

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

		$('#mute_mic').click(function(){
			if($(this).parent('li').hasClass("btn-success")){
				$(this).parent('li').removeClass("btn-success").addClass('btn-danger');
				$('#incoming').prop('muted', true);   
      // console.log('muted');
  }else{
  	$(this).parent('li').removeClass("btn-danger").addClass('btn-success');
  	$('#incoming').prop('muted', false);        
      // console.log('unmuted');
  }
});  
		(function($){
			$(window).on("load",function(){
				$(".chat-box-right .chat-box.slimscrollleft, .chat-box-left .chat-user-list.slimscrollleft").mCustomScrollbar({
					theme:"minimal"
				});			
			});
		})(jQuery);
	</script>

	<input type="hidden" id="role" value="<?php echo $this->session->userdata('role'); ?>">
	<!-- <script src="<?php echo base_url()."assets/" ?>js/chosen.js"></script> -->
	<?php if($this->uri->segment(1) == 'dashboard' || $this->uri->segment(2) =='dashboard#_=_' || $this->uri->segment(2) == 'dashboard' || $this->uri->segment(2)){ ?> 
	<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/dataTables.bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/" ?>css/chosen.css">
	<link href="<?php echo base_url()."assets/" ?>css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
	<script src="<?php echo base_url()."assets/" ?>js/cropper.min.js"></script>
	<script src="<?php echo base_url()."assets/" ?>js/main.js"></script>
	<script src="<?php echo base_url()."assets/" ?>js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$('#mentor_job_from_year').datetimepicker({        
			maxDate: moment().subtract(0, 'y'),
			format: "YYYY"      
		});
		$('#mentor_job_to_year').datetimepicker({
			format: "YYYY"   
		});
		$("#mentor_job_from_year").on("dp.change", function (e) {      
			$('#mentor_job_to_year').data("DateTimePicker").minDate(e.date);
		});
		$("#mentor_job_to_year").on("dp.change", function (e) {
			$('#mentor_job_from_year').data("DateTimePicker").maxDate(e.date);           
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){


			$('#call_log').DataTable();
			var role = $('#role').val();
			if(role == 0){
				var url = "<?php echo site_url('user/get_applicant_payment')?>";
			}else{
				var url = "<?php echo site_url('user/get_gurus_payment')?>";
			}

 //datatables
 var  table = $('#datatable').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
        	"url": url,
        	"type": "POST"         
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable            
        },
        ],

    });


});       
</script>
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
  // setTimeout(function(){
  //   window.location=base_url+'mentors';
  // },7000);
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

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jstz-1.0.4.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var tz = jstz.determine();
		var timezone = tz.name();
		$.post('<?php echo base_url(); ?>user/set_timezone',{timezone:timezone},function(res){
        // console.log(res);
    })      
	});

</script>
<script src="<?php echo base_url()."assets/" ?>js/app.js" type="text/javascript"></script>


<!-- <link rel="manifest" href="<?php echo base_url(); ?>assets/manifest.json">
  <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
  <script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(["init", {
      appId: "1d5db295-0136-46a2-bcb0-5bcceca841ae",
      autoRegister: false,
      notifyButton: {
        enable: true /* Set to false to hide */
      }
    }]);
  </script>

  <script>

            function subscribe() {
                // OneSignal.push(["registerForPushNotifications"]);
                OneSignal.push(["registerForPushNotifications"]);
                event.preventDefault();
            }
            function unsubscribe(){
                OneSignal.setSubscription(true);
            }

              var OneSignal = OneSignal || [];
            OneSignal.push(function() {
                /* These examples are all valid */
                // Occurs when the user's subscription changes to a new value.
                OneSignal.on('subscriptionChange', function (isSubscribed) {
                    console.log("The user's subscription state is now:", isSubscribed);
                    OneSignal.sendTag("user_id","4444", function(tagsSent)
                    {
                        // Callback called when tags have finished sending
                        console.log("Tags have finished sending!");
                    });
                });

                var isPushSupported = OneSignal.isPushNotificationsSupported();
                if (isPushSupported)
                {
                    // Push notifications are supported
                    OneSignal.isPushNotificationsEnabled().then(function(isEnabled)
                    {
                        if (isEnabled)
                        {
                            console.log("Push notifications are enabled!");

                        } else {
                            OneSignal.showHttpPrompt();
                            console.log("Push notifications are not enabled yet.");
                        }
                    });

                } else {
                    console.log("Push notifications are not supported.");
                }
            });
        </script>
    -->
</body>
</html>