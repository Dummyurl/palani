<style type="text/css">
.success-signup .cong_icon {padding: 0 !important;}
</style>
 
<div class="modal fade bs-example-modal-lg" id="rating_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3>Rate the Mentor!</h3>
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
					<textarea id="rating_comment" class="form-control" name="rating_comment" placeholder="Comments (optional)" maxlength="150"></textarea>
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
    <div class="row">
     <?php
     $currentuser = get_userdata();  
     if($currentuser['is_verified'] == 0 && $currentuser['mobile_verified'] == 0){ ?>


      <div class="col-md-2 col-xs-6 col-sm-3 ft-list">
        <div class="footer-widget-first">
          <h4>Home</h4>

          <ul class="list-unstyled">
            <li><a href="javascript:void(0);">Dashboard</a></li>
            <li><a href="javascript:void(0);">Calendar</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-2 col-xs-6 col-sm-3">
        <div class="footer-widget-first">
          <h4>Mentors</h4>
          <ul class="list-unstyled">
            <li><a href="javascript:void(0);">Conversations</a></li>
            <li><a href="javascript:void(0);">Messages</a></li> 
          </ul>
        </div>      
      </div>
      <div class="col-md-2 col-xs-6 col-sm-3">
        <div class="footer-widget-first">
          <h4>Accounts</h4>
          <ul class="list-unstyled">
            <li><a href="javascript:void(0);">Account</a></li>
            <li><a href="javascript:void(0);">Payments</a></li>
          </ul>
        </div>      
      </div>  



    <?php }else{?>
      <div class="col-md-2 col-xs-6 col-sm-3 ft-list">
        <div class="footer-widget-first">
          <h4>Home</h4>

          <ul class="list-unstyled">
            <li><a href="<?php echo base_url(); ?>dashboard">Dashboard</a></li>
            <li><a href="<?php echo base_url(); ?>calendar">Calendar</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-2 col-xs-6 col-sm-3">
        <div class="footer-widget-first">
          <h4>Mentors</h4>
          <ul class="list-unstyled">
            <li><a href="<?php echo base_url(); ?>conversations">Conversations</a></li>
            <li><a href="<?php echo base_url(); ?>messages">Messages</a></li> 
          </ul>
        </div>      
      </div>
      <div class="col-md-2 col-xs-6 col-sm-3">
        <div class="footer-widget-first">
          <h4>Accounts</h4>
          <ul class="list-unstyled">
            <li><a href="<?php echo base_url(); ?>account">Account</a></li>
            <li><a href="<?php echo base_url(); ?>payments">Payments</a></li>
          </ul>
        </div>      
      </div>  
    <?php } ?>                

    <div class="col-md-6 col-xs-6 col-sm-3 ft-list">
      <div class="footer-widget-first">
        <h4>Download our free app</h4>
        <p>Please click the below link to download the app.</p>
        <div class="footer-form-blk">
          <form>
                               <!--  <div class="row row-vmargin-14">
                                    <div class="col-xs-7">
                                        <div class="form-group">
                                            <input type="tel" class="form-control" id="telphone" placeholder="(123) 456-7890" maxlength="14" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-xs-5">
                                        <div class="form-check">
                                            <label>
                                                <input type="radio" name="radio" checked> <span class="label-text">App for Mentee</span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label>
                                                <input type="radio" name="radio"> <span class="label-text">App for Mentors</span>
                                            </label>
                                        </div>
                                    </div>
                                  </div> -->
                                  <div class="row vertical-align">
                                   <!--  <div class="col-xs-5">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-app">send a link</button>
                                        </div>
                                      </div> -->
                                      <div class="col-xs-7">
                                        <div class="app-download">
                                          <ul class="list-unstyled list-inline">
                                            <li><a href="https://play.google.com/store/apps/details?id=com.dreamguys.mentoring&hl=en" target="_blank"><img class="img img-responsive" src="<?php echo base_url(); ?>assets/images/googleplay-icon.png"><span>Google Play</span></a></li>
                                            <!-- <li><a href="javascript:;"><img class="img img-responsive iphone-size" src="<?php echo base_url(); ?>assets/images/iphone-icon.png">App Store</a></li> -->
                                          </ul>
                                        </div>

                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>      
                            </div>      
                          </div>
                          <hr>
                          <div class="row vertical-align">
                            <div class="col-sm-6 col-xs-12 common-footer" >
                              <p class="">                        
                                <a href="<?php echo base_url(); ?>privacy-policy">Privacy policy</a><span class="divider">/</span>
                                <a href="<?php echo base_url(); ?>terms-conditions">terms&conditions</a><span class="divider"></span>
                              </p>
                              <p>© 2018 Mentori.ng. All rights reserved.</p>
                            </div>
                            <div class="col-sm-6 col-xs-12 social">
                               <ul>
                            <li><a href="https://www.facebook.com/MentoringElearning" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="https://twitter.com/Mentori_ng" target="blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href=" https://www.linkedin.com/in/mentoring-dgt-3b4080176/" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                            <li><a href="https://www.youtube.com/embed/o0uOynG5VX8" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                        </ul> 
                            </div>
                          </div>      

                        </div>
                      </footer>


                      <script>
                       var base_url = '<?php echo base_url(); ?>';
                       var segment = '<?php echo $this->uri->segment(1); ?>';
                     </script>


                     <?php 

                     if($this->uri->segment(1) != 'dashboard'){ ?>
                      <script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
                      <script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
                    <?php } ?>



                    <script src='<?php echo base_url()."assets/" ?>js/moment.js'></script>
                    <script src='<?php echo base_url()."assets/" ?>js/jquery.mCustomScrollbar.concat.min.js'></script>
                    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.form.min.js') ?>"></script>
                    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css">
                    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>
                    <script src="<?php echo base_url()."assets/" ?>js/sinch/VIDEOsample.js"></script>

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
				// $('#new_password_span').text('Enter valid password');
				$('.account-btn').attr('disabled','true');
			}

			if(!valid || !match){
				$('.account-btn').attr('disabled','true');
			}
			if(valid && match){
				$('.account-btn').removeAttr('disabled');
			}
		});


                      $('#password').on('keyup blur'),(function(){
                       var pwd = $(this).val();
                       if(pwd == ''){
                        $('#new_password_span').text('Enter valid password');
                      }

                    });

		// $('.confirm_password').blur(function(){
		// 	validate();
		// });


		function validate(){
			$.ajax({
				url:'<?php echo base_url(); ?>user/change_password',
				data:$('#change_pwd_form').serialize(),
				method:'POST',
				dataType: "JSON",
				beforeSend:function(){
					$('.overlay').show();
				},
				success: function(data)
				{
					$('.overlay').hide();
		            if(data.status == true) //if success close modal and reload ajax table
		            {
		            	$('#change_pwd_form')[0].reset();
		            	$('.note').show();
		            	$('#change_pwd').modal('hide');


		            	setTimeout(function() {
		            		$('.note').hide();
		            	}, 1000);
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
		}

		$('#change_pwd_form').submit(function(){
			$.ajax({
				url:'<?php echo base_url(); ?>user/change_password',
				data:$('#change_pwd_form').serialize(),
				method:'POST',
				dataType: "JSON",
				beforeSend:function(){
					$('.overlay').show();
				},
				success: function(data)
				{
					$('.overlay').hide();
		            if(data.status == true) //if success close modal and reload ajax table
		            {
		            	$('#change_pwd_form')[0].reset();
		            	$('.note').show();
		            	


		            	setTimeout(function() {
		            		$('.note').hide();
		            		$('#change_pwd_modal').modal('hide');
		            	}, 1000);
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
		    // $("input").keyup(function(){
		    // 	$(this).parent().parent().removeClass('has-error');
		    // 	$(this).next().empty();
		    // });

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
          var up_file_name =obj.file_name;


          var content ='<div class="chat">'+
          '<div class="chat-avatar">'+
          '<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="">'+
          '<img alt="" src="'+img+'" class="img-responsive img-circle">'+
          '</a>'+
          '</div>'+
          '<div class="chat-body">'+
          '<div class="chat-content">'+
          '<p><img alt="" src="'+base_url+'/'+image_src+'" class="img-responsive"></p>'+up_file_name+
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

   <?php if($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == 'account' || $this->uri->segment(2) =='dashboard#_=_' || $this->uri->segment(2) == 'dashboard' || $this->uri->segment(2)){ ?>


    <script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/" ?>css/chosen.css">
    <link href="<?php echo base_url()."assets/" ?>css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="<?php echo base_url()."assets/" ?>js/cropper.min.js"></script>
    <script src="<?php echo base_url()."assets/" ?>js/main.js"></script>
    
    <script src="<?php echo base_url()."assets/" ?>js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

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



<?php if($this->uri->segment(1) == 'payments'){ ?>
  <link href="<?php echo base_url()."assets/" ?>css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/dataTables.bootstrap.min.js"></script>

  <script type="text/javascript">

 //datatables
 var  table = $('#payment_table').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
        	"url": '<?php echo site_url('payments/payment_list')?>',
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





      </script>




    <?php } ?>








    <?php if($this->uri->segment(1) == 'calendar'){ ?>
     <script src="<?php echo base_url()."assets/" ?>js/jquery-ui.min.js"></script>
     <script src="<?php echo base_url()."assets/" ?>js/fullcalendar.min.js" type="text/javascript"></script>
     <script src="<?php echo base_url()."assets/" ?>js/jquery.fullcalendar.js"></script>
   <?php } ?>
   <?php if($this->uri->segment(1) == 'mentors'){ ?>     	
     <script type="text/javascript">
      
         $('#search_all_mentor').submit(function(){
          search_all_mentor(0);
              return false;
          });   

      function search_all_mentor(load_more){

        if(load_more == 0){
         $('#page_no_hidden').val(1);
       }

       var gender = $('#gender').val();
       var subject = $('#subject').val();       
       var course = $('#course').val();       
       var order_by = $('#orderby').val();
       var keyword = $('.right_top_search').val(); 
       var page = $('#page_no_hidden').val();
       /* Advance search */

      var under_college = $('#under_college').val();
      var under_major = $('#under_major').val();
      var graduate_college = $('#graduate_college').val();
      var degree = $('#degree').val();
      var city = $('#city').val();
      var state = $('#state').val();
      var country  = $('#country').val();


     //$('#search-error').html('');

     $.ajax({
       url:  base_url +'user/search_all_mentor',
       type: 'POST',
       data: {
        gender : gender,
        subject_id : subject,
        course_id : course,
        order_by : order_by,
        page : page,
        keyword : keyword,
        under_college : under_college,
        under_major : under_major,
        graduate_college : graduate_college,
        degree : degree,
        city : city,
        state : state,
        country : country

      },
      beforeSend:function(){ 
        $('.overlay').css("display","block"); 
      },
      success: function(response){
        $('.overlay').css("display","none"); 
        if(response){
          var obj = jQuery.parseJSON(response);

          var html = '';
             $(obj.data).each(function(){                
           html +='<a href="'+base_url+'mentor-profile/'+this.username+'" class="guru-list">'+
                 '<div class="row list-of-search">'+
                   '<div class="col-sm-4 col-md-3 col-xs-5">'+
                     '<div class="guru-details text-center">'+                                    
                        '<div class="guru-img">'+
                       '<img src="'+this.profile_img+'" height="100" width="100"  class="img-circle">'+
                       '</div>'+
                       '<div class="guru-name">'+this.full_name+'</div>'+
                       '<div class="guru-country">'+this.country+'</div>'+
                      '</div>'+
                   '</div>'+
                   '<div class="col-sm-8 col-md-9 col-xs-7">'+                           
                      '<div class="guru-det">'+
                        '<h4 class="guru-title">'+this.personal_message+'</h4>'+
                        '<div class="subject">Courses :'+this.course+'</div>'+
                        '<span class="read-more">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></span>'+
                      '</div>'+
                
                  '<div class="search-currency">';
                      if(this.is_free == false){                                         
                          html +='<div class="price">'+
                          '<span class="currency">$</span>'+
                          '<span class="amount">'+this.hourly_rate+'</span>/hour'+
                          '</div>';
                      } else if(this.is_free == true){ 
                        html +='<div class="price">'+
                        '<button class="btn btn-primary btn-xs">Free</button>'+
                        '</div>';
                      }
                    html +='<div class="ratings">';
                    for(var i=1; i<=5 ; i++) {
                     if(i <= this.rating_value){                                        
                      html +='<i class="fa fa-star" style="color:#ffc513 !important;"></i>';
                    }else{ 
                      html +='<i class="fa fa-star"></i>';
                    } 
                  } 

        html +='<span class="rating-count">'+this.rating_value+'</span>'+
        '<span class="total-rating">('+this.rating_count+')</span>'+
        '</div>'+ 
          '</div>'+
        '</div>'+             
        '</div>'+             
        '</a>';

      });


          if(obj.current_page_no == 1){                    
            $("#guru-list").html(html);    
          }else{
            $("#guru-list").append(html);    
          }                    
          $(".widget-title").html(obj.count+' Matches for your search');

          if(obj.count == 0){
            $('#load_more_btn').addClass('hidden');
            $('#no_more').removeClass('hidden');
            return false;
          }


          if(obj.current_page_no == 1 && obj.count < 5){
            $('page_no_hidden').val(1);
            $('#load_more_btn').addClass('hidden');
            $('#no_more').removeClass('hidden');
            return false;
          }



          if(obj.total_page > obj.current_page_no && obj.total_page !=0 ){                               
            $('#load_more_btn').removeClass('hidden');
            $('#no_more').addClass('hidden');
          }else{                                
            $('#load_more_btn').addClass('hidden');
            $('#no_more').removeClass('hidden');
          }                

        }                     
      }

    });
   }




   $('#load_more_btn').click(function(){    
     var page_no = $('#page_no_hidden').val(); 
     var current_page_no =0;

     if(page_no == 1){
      current_page_no = 2;
    }else{
      current_page_no = Number(page_no) + 1;
    }        
    $('#page_no_hidden').val(current_page_no);
    search_all_mentor(1);
  });


   search_all_mentor();

    $('#advance_search_form').submit(function(){

       var under_college = $('#under_college').val();
      var under_major = $('#under_major').val();
      var graduate_college = $('#graduate_college').val();
      var degree = $('#degree').val();
      var city = $('#city').val();
      var state = $('#state').val();
      var country  = $('#country').val();


      if(
        under_college  == '' &&
        under_major  == '' &&
        graduate_college  == '' &&
        degree  == '' &&
        city  == '' &&
        state  == '' &&
        country  == ''
        ){          
          $('#search-advance-error').html('Enter any value to search.');
        setTimeout(function() {
          $('#search-advance-error').html('');
        }, 2000);
        return false;
      }
      

      search_all_mentor();
      // $('#advance_search_form')[0].reset();
      $('#advancedsearch').modal('hide');
        return false;
    });
 </script>

 <?php  } ?>


 <?php
   if($this->uri->segment(1) == 'mentee'){ ?>
 <script type="text/javascript">
 
         $('#search_all_mentee').submit(function(){
          search_all_mentee(0);
              return false;
          });   

      function search_all_mentee(load_more){

        if(load_more == 0){
         $('#page_no_hidden').val(1);
       }

       var gender = $('#gender').val();
       var subject = $('#subject').val();       
       var course = $('#course').val();       
       var order_by = $('#orderby').val();
       var keyword = $('.right_top_search').val(); 
       var page = $('#page_no_hidden').val(); 


     /* Advance search */

      var under_college = $('#under_college').val();
      var under_major = $('#under_major').val();
      var graduate_college = $('#graduate_college').val();
      var degree = $('#degree').val();
      var city = $('#city').val();
      var state = $('#state').val();
      var country  = $('#country').val();


     //$('#search-error').html('');

     $.ajax({
       url:  base_url +'user/search_all_mentee',
       type: 'POST',
       data: {
        gender : gender,
        subject_id : subject,
        course_id : course,
        order_by : order_by,
        page : page,
        keyword : keyword,
        under_college : under_college,
        under_major : under_major,
        graduate_college : graduate_college,
        degree : degree,
        city : city,
        state : state,
        country : country

      },
      beforeSend:function(){ 
        $('.overlay').css("display","block"); 
      },
      success: function(response){
        $('.overlay').css("display","none"); 
        if(response){
          var obj = jQuery.parseJSON(response);

          var html = '';
             $(obj.data).each(function(){                
           html +='<a href="'+base_url+'mentee-profile/'+this.username+'" class="guru-list">'+
                 '<div class="row list-of-search">'+
                   '<div class="col-sm-4 col-md-3 col-xs-5">'+
                     '<div class="guru-details text-center">'+                                    
                        '<div class="guru-img">'+
                       '<img src="'+this.profile_img+'" height="100" width="100"  class="img-circle">'+
                       '</div>'+
                       '<div class="guru-name">'+this.full_name+'</div>'+
                       '<div class="guru-country">'+this.country+'</div>'+
                      '</div>'+
                   '</div>'+
                   '<div class="col-sm-8 col-md-9 col-xs-7">'+                           
                      '<div class="guru-det">'+
                        '<h4 class="guru-title">'+this.personal_message+'</h4>'+
                        '<div class="subject">Courses :'+this.course+'</div>'+
                        '<span class="read-more">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></span>'+
                      '</div>'+
                  '</div>'+                           
        '</div>'+             
        '</a>';

      });


          if(obj.current_page_no == 1){                    
            $("#guru-list").html(html);    
          }else{
            $("#guru-list").append(html);    
          }                    
          $(".widget-title").html(obj.count+' Matches for your search');

          if(obj.count == 0){
            $('#load_more_btn').addClass('hidden');
            $('#no_more').removeClass('hidden');
            return false;
          }


          if(obj.current_page_no == 1 && obj.count < 5){
            $('page_no_hidden').val(1);
            $('#load_more_btn').addClass('hidden');
            $('#no_more').removeClass('hidden');
            return false;
          }



          if(obj.total_page > obj.current_page_no && obj.total_page !=0 ){                               
            $('#load_more_btn').removeClass('hidden');
            $('#no_more').addClass('hidden');
          }else{                                
            $('#load_more_btn').addClass('hidden');
            $('#no_more').removeClass('hidden');
          }                

        }                     
      }

    });
   }




   $('#load_more_btn').click(function(){    
     var page_no = $('#page_no_hidden').val(); 
     var current_page_no =0;

     if(page_no == 1){
      current_page_no = 2;
    }else{
      current_page_no = Number(page_no) + 1;
    }        
    $('#page_no_hidden').val(current_page_no);
    search_all_mentee(1);
  });


   search_all_mentee();

$('#advance_search_form').submit(function(){

       var under_college = $('#under_college').val();
      var under_major = $('#under_major').val();
      var graduate_college = $('#graduate_college').val();
      var degree = $('#degree').val();
      var city = $('#city').val();
      var state = $('#state').val();
      var country  = $('#country').val();


      if(
        under_college  == '' &&
        under_major  == '' &&
        graduate_college  == '' &&
        degree  == '' &&
        city  == '' &&
        state  == '' &&
        country  == ''
        ){          
          $('#search-advance-error').html('Enter any value to search.');
        setTimeout(function() {
          $('#search-advance-error').html('');
        }, 2000);
        return false;
      }
      

      search_all_mentee();
      // $('#advance_search_form')[0].reset();
      $('#advancedsearch').modal('hide');
        return false;
    });



 
 </script>
 <?php  } ?>
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

</body>
</html>
