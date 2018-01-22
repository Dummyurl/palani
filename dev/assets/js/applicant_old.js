$(document).ready(function() {
     
    var global_username = '';
    var handleError = function(error) {
            $('button#createUser').prop('disabled', false);
            $('button#loginUser').prop('disabled', false);
            $('div.error').text(error.message);
            $('div.error').show();
    }
    
    var check_email_path = base_url+"user/check_email";
    $('#applicant_signup_form').bootstrapValidator({
//        live: 'disabled',        
        fields: {
            first_name: {                 
                validators: {
                    notEmpty: {
                        message: 'The First Name is required'
                    }
                }
            },
            last_name: {                
                validators: {
                    notEmpty: {
                        message: 'The Last Name is required'
                    }
                }
            },    
            email: {
                validators: {                    
                    regexp: {
                      regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                      message: 'The value is not a valid email address'
                    },
                    remote: {
                        message: 'The E-Mail is not available',
                        url: check_email_path
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The Password is required'
                    }
                    ,                    
                     callback:{
                        message: 'The password is not valid',
                        callback: function(value, password, $field){
                            if(value===''){
                                return true;
                             }

                            // Check the password strength
                            if (value.length < 8) {
                                return {
                                    valid: false,
                                    message: 'It must be more than 8 characters long'
                                };
                            }

                            // The password doesn't contain any uppercase character
                            if (value === value.toLowerCase()) {
                                return {
                                    valid: false,
                                    message: 'It must contain at least one upper case character'
                                }
                            }

                            // The password doesn't contain any uppercase character
                            if (value === value.toUpperCase()) {
                                return {
                                    valid: false,
                                    message: 'It must contain at least one lower case character'
                                }
                            }

                            // The password doesn't contain any digit
                            if (value.search(/[0-9]/) < 0) {
                                return {
                                    valid: false,
                                    message: 'It must contain at least one digit'
                                }
                            }

                            if(value.search(/[*@!#%&()^~{}]+/) < 0) {
                                return {
                                    valid: false,
                                    message: 'It must contain atleast one special character'
                                }
                            }
                            return true;
                        }               

                    },
                    identical: {
                        field: 'confirmPassword',
                        message: 'The password and its confirm are not the same'
                    } 
                }
            },
            confirm_password: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and cannot be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    }
                }
            }
             
        }
    }) .on('success.form.bv', function(e) {
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        $('.preloader').css('display','block');
                                        $('.preloader').html('<div class="loaderbar"></div>');
                                        var url = base_url+"user/save_signup";
                                        var formData = $('#applicant_signup_form').serialize(); 
                                        $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            success:function(response)
                                            {
                                                if(response == 0)
                                                {
                                            
                                                   setInterval(function(){
                                                    window.location = base_url+'welcome/applicant_success_signup';
                                                   },2000);
                                                   
                                                }
                                                else
                                                {
                                                    $('.preloader').html('');
                                                    $('.preloader').css('display','none');
                                                    $('#form-registeration-error').html("Error While Registering !");
                                                    $('#form-registeration-error').css('display','block');
                                                    $('#form-registeration-error').css('color','red');
                                                }
                                            }
                                        });
                                        
                                    });
                                    

    
        $('#applicant_login_form').bootstrapValidator({
       fields: {                
            email: {
                validators: { 
                    notEmpty: {
                        message: 'The Email is required'
                    },  
                    regexp: {
                      regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                      message: 'The value is not a valid email address'
                    } 
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The Password is required'
                    }  
                }
            }              
        }
    }) .on('success.form.bv', function(e) {
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        $('.preloader').css('display','block');
                                        $('.preloader').html('<div class="loaderbar"></div>');
                                        var url = base_url+"user/check_applicant";
                                        var formData = $('#applicant_login_form').serialize(); 
                                        $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            success:function(response)
                                            {                                                 
                                                if(response==0)
                                                {   
                                                   setInterval(function(){
                                                    window.location = base_url+"dashboard?notify=true";
                                                   },2000);
                                                }
                                                else
                                                {
                                                    $('.preloader').html('');
                                                    $('.preloader').css('display','none');
                                                    $('#applicant_login_error').html(" Wrong Credentials !");                                                    
                                                }
                                         
                                           }
                                        });

                                    });
                                    
       
    
    $('#activity_search').bind('keypress', function(e) {
                       if (e.keyCode === 13) return false;
                     });

   
     $('#applicant_forgot_password_form').bootstrapValidator({
       fields: {                
            email: {
                validators: {                    
                    regexp: {
                      regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                      message: 'The value is not a valid email address'
                    } 
                }
            }              
        }
    }) .on('success.form.bv', function(e) {
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        var url = base_url+"user/resend_password";
                                        var formData = $('#applicant_forgot_password_form').serialize(); 
                                        $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            success:function(response)
                                            {                                                 
                                                if(response==0)
                                                {   
                                                    $('#applicant_forgot_password_success').html('Password has been sent to mail Id');
                                                    $('#applicant_forgot_password_success').css('display','block');
                                                    $('#applicant_forgot_password_error').css('display','none');
                                                    setInterval(function(){ window.location = base_url; }, 1000);
                                                }
                                                else if(response==2)
                                                {   
                                                    $('#applicant_forgot_password_error').html('Error While Updating Password !');
                                                    $('#applicant_forgot_password_success').css('display','none');
                                                    $('#applicant_forgot_password_error').css('display','block');                                                    
                                                }                                                    
                                                else
                                                {
                                                    $('#applicant_forgot_password_error').html(" Invalid Email Id !");                                                    
                                                    $('#applicant_forgot_password_error').css('display','block');
                                                    $('#applicant_forgot_password_success').css('display','none');
                                                }
                                         
                                           }
                                        })

                                    });
              
                                    
      var check_username_path = base_url+"user/check_username";                              
      $('#applicant_profile_form').bootstrapValidator({
       fields: {                
            applicant_first_name: {
                validators: {                    
                    notEmpty: {
                        message: 'The First Name is required'
                    }
                }
            },         
            username: {
                validators: {                    
                    notEmpty: {
                        message: 'The User Name is required'
                    },
                remote: {
                        message: 'The Username is not available',
                        url: check_username_path
                }
                }
            },         
            applicant_last_name: {
                validators: {                    
                    notEmpty: {
                        message: 'The Last Name is required'
                    }
                }
            },
            applicant_phone: {
                validators: {                    
                    notEmpty: {
                        message: 'The Phone Number is required'
                    },
                    numeric: {
                        message:'Please enter numeric value'
                   }
                }
            }
        }
    }) .on('success.form.bv', function(e) {
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        var url = base_url+"user/update_profile";
                                        var formData = $('#applicant_profile_form').serialize(); 
                                        $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            success:function(response)
                                            {                                                 
                                                if(response==0)
                                                {   
                                                    
                                                    $("#profile_update_error").html("");
                                                    $("#profile_update_error").css("display","none");
                                                /*  $('#applicant_forgot_password_success').html('Password has been sent to mail Id');
                                                    $('#applicant_forgot_password_success').css('display','block');
                                                    $('#applicant_forgot_password_error').css('display','none'); */
                                                    setTimeout(function(){ window.location = base_url+'dashboard'; }, 1000);
                                                }
                                                else if(response==1)
                                                {
                                                 
                                                    $("#profile_update_error").html(' Error While Updating '); 
                                                    $("#profile_update_error").css("display","block");
                                                    $("#profile_update_error").fadeTo(2000, 500).slideUp(500, function(){
                                                        $("#profile_update_error").slideUp(500);
                                                    });
                                                    setInterval(function(){ location.reload(); }, 1000);
                                                    /* $('#applicant_forgot_password_error').html('Error While Updating Password !');
                                                    $('#applicant_forgot_password_success').css('display','none');
                                                    $('#applicant_forgot_password_error').css('display','block');                                                     */
                                                }                                                    
                                                
                                         
                                           }
                                        })

                                    });
                                    
    var check_exist_date =  base_url+'user/check_exist_date';                                  
    $('#schedule_form').bootstrapValidator({
       fields: {                
            contact_date: {
                validators: {                    
                    notEmpty: {
                        message: 'The Date is required'
                    }
                }
            },         
            contact_time_start: {
                validators: {                    
                    notEmpty: {
                        message: 'The Start Time is required'
                    },
                    /*remote: {
                        message: 'Guru is not available for given time.',
                        url: check_exist_date
                    }*/
                    callback:{
                        message: 'Guru is not available for given time.Please choose some other date or time.'
                    }
                }
            },
            contact_time_end: {
                validators: {                    
                    notEmpty: {
                        message: 'The End Time is required'
                    }
                }
            }
        }
    }) .on('success.form.bv', function(e) {
        
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        var $form = $(e.target);
                                        var bv = $form.data('bootstrapValidator');

                                        var url = base_url+"user/set_schedule_time";
                                        var formData = $('#schedule_form').serialize(); 
                                        var app_id = $('#app_id').val();
                                        
                                        //console.log(formData);return false;
                                        var invite = $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            beforeSend: function()
                                            {
                                               $.post(check_exist_date,{contact_date:$('#choosedate').val(),contact_time:$('#contact_time_start').val(),contact_time_end:$('#contact_time_end').val(),app_id:$('#app_id').val()},function(response_val){
                                                    if(response_val==0)
                                                    {
                                                        bv.updateStatus('contact_time_start', 'INVALID', 'callback');
                                                        invite.abort();
                                                        return false;
                                                    }
                                                });
                                              /*  $.post(base_url+'user/check_time',{past_time:$('#choosedate1').val()},function(returnvalue){
                                                    console.log(returnvalue);
                                                    if(returnvalue==0)
                                                    {
                                                        bv.updateStatus('contact_time_start', 'INVALID', 'callback');
                                                        invite.abort();
                                                        return false;
                                                    }
                                                });*/
                                            },
                                            success:function(response)
                                            {   
                                                if(response==1)
                                                {   
                                                   // $('#choosedatetime').modal('hide');
                                                    $('.contact-btn button').addClass('disabled');
                                                    //setTimeout(function(){ window.location=base_url+'user/buy/'+app_id; },1000);
                                                    setTimeout(function(){ window.location=base_url+'user/pay/'+app_id; },1000);
                                                }
                                              
                                           }
                                        })

                                    });

            $('.unique-value').focus(function(){
                var val = $(this).val();
                $(this).attr('data-current-value', val); 
            });

            $('.unique-value').change(function(){
                var val = $(this).val();
                if(val != -1)
                    $('.unique-value1 option[value="' + val + '"]').attr('disabled', 'disabled'); 

                var oldval = $(this).attr('data-current-value');
                $('.unique-value1 option[value="' + oldval + '"]').removeAttr('disabled'); 
            });        
        
            $("#results-list-view").click(function(){
                $("#results-grid-view").removeClass("active");
                $(this).addClass('active');
                var list_url = base_url +'user/gurus_list_view'; 
                $.post(list_url,function(value){
                    $('#guru-list').html(value);
                });
            });

            $("#results-grid-view").click(function(){
             $("#results-list-view").removeClass("active");
             $(this).addClass('active');
             var grid_url = base_url +'user/gurus_grid_view'; 
                $.post(grid_url,function(value){
                    $('#guru-list').html(value);
                });
            });                

            $(document).on('click','.loadmore-a',function () {
                  $(this).text('Loading...');
                  var ele = $(this).parent('div');
                  $.ajax({
                  url:  base_url +'user/loadmore_guru',
                  type: 'POST',
                  data: {
                          page:$(this).data('page'),mentor_gender:$('#mentor_gender_hidden').val(),mentor_school:$('#mentor_school_hidden').val(),mentor_schools_applied:$('#mentor_schools_applied_hidden').val(),mentor_current_year:$('#mentor_current_year_hidden').val(),mentor_extracurricular_activities:$('#mentor_extracurricular_activities_hidden').val(),mentor_job_company:$('#mentor_job_company_hidden').val(),mentor_job_title:$('#mentor_job_title_hidden').val(),mentor_job_from_year:$('#mentor_job_from_year_hidden').val(),mentor_about:$('#mentor_about_hidden').val(),mentor_languages_speak:$('#mentor_languages_speak_hidden').val()
                        },
                  success: function(response){
                       if(response){
                            ele.remove();
							$('.overlay').fadeIn(1000 , function(){
									  $(this).css("display","none");
							});
                            $("#guru-list").append(response);
                          }
                        }
               });
            });
            
            

			$(document).on('click','.loadmore-guru',function () {
                          $(this).text('Loading...');
						  //console.log('loadmore');
                          var ele = $(this).parent('div');
                          $.ajax({
                          url:  base_url +'user/loadmore_search_guru_home',
                          type: 'POST',
                          data: {
                                  keyword:$('#old_keyword').val(),page:$(this).data('page'),gender:$('#gender').val(),admitted_school:$('#admitted_school').val(),school_offer:$('#school_offer').val(),school_year:$('#school_year').val()
                                },
                          success: function(response){
                               if(response){
                                    ele.remove();
									$('.overlay').fadeIn(1000 , function(){
									  $(this).css("display","none");
									});
                                    $("#guru-list").append(response);
                                  }
                                }
                       });
            });
            
            $(document).on('click','.search-left',function(){
				
                 var gender = $('#gender').val();
                 var admitted_school = $('#admitted_school').val();
                 var school_offer = $('#school_offer').val();
                 var school_year = $('#school_year').val();
				 if(gender == '' && admitted_school == '' && school_offer == '' && school_year == '')
				 {
					 $('#search-error').html('Please select atleast one.');
					 return false;
				 }
				 $('#search-error').html('');
				 $('.overlay').fadeIn(2000 , function(){
				  $(this).css("display","none");
				 });
				 
                 $.ajax({
                   url:  base_url +'user/search_left',
                   type: 'POST',
                   data: { gender:gender,admitted_school:admitted_school,school_offer:school_offer,school_year:school_year },
                   success: function(response){
                       if(response == 0){
                           $(".widget-title").html('0 Matches for your search');
                           $("#guru-list").html('<p>Mentors not found</p>');
                       }else{
                           $("#right-search-content").html(response);
                       }
                    }
                });
            });
         
            $('.chatclick').on('click',function(){
                  var selected_user = $(this).attr('data-chat-id'); 
                  $(".chatclick").removeClass("selected");
                  $(this).addClass('selected');
                  $.post(base_url+'user/get_selected_chat',{selected_user:selected_user},function(response){
                      $('.chat-box-right').html(response);
                      $(".chat-send-btn").addClass('disabled');
                  });
            });
            
            $(document).on('click','.chatclick_search',function(){
                  var selected_user = $(this).attr('data-chat-id'); 
                  $(".chatclick").removeClass("selected");
                  $(".chatclick_search").removeClass("selected");
                  $(this).addClass('selected');
                  $.post(base_url+'user/get_selected_chat',{selected_user:selected_user},function(response){
                      $('.chat-box-right').html(response);
                      $(".chat-send-btn").addClass('disabled');
                  });
            });
            
            //$('div[class*="unread_count"]').css('display','none');
            setInterval(function(){
                $('.chatclick').each(function(){
                  var select_user = $(this).attr('data-chat-id');  
                  if(select_user > 0){
                  $.post(base_url+'user/get_new_message_count',{selected_user:select_user},function(response){
                      if(response > 0){
                        $('.unread_count'+select_user).css('display','block');
                        $('.unread_count'+select_user).html(response);
                      }else{
                        $('.unread_count'+select_user).css('display','none');
                      }
                  });
              }
                });
            },100);
    
           //$('div[class*="unread_count"]').css('display','none');
            setInterval(function(){
                $('.chatclick_search').each(function(){
                  var select_user = $(this).attr('data-chat-id');  
                  if(select_user > 0){
                  $.post(base_url+'user/get_new_message_count',{selected_user:select_user},function(response){
                      if(response > 0){
                        $('.unread_count'+select_user).css('display','block');
                        $('.unread_count'+select_user).html(response);
                      }else{
                        $('.unread_count'+select_user).css('display','none');
                      }
                  });
              }
                });
            },100);
            
            setInterval(function(){
                  var check_session = CheckSession();
                  if(check_session == 1){
                   $.get(base_url+'user/online_status',function(response){
                       if(response == 1){
                         return true;
                       }
                   });
               }
             },2000);
                                
            setInterval(function(){
                $('.chatclick').each(function(){
                  var select_user = $(this).attr('data-chat-id');  
                  $.post(base_url+'user/get_online_status',{selected_user:select_user},function(response){
                      if(response > 0){
                        $('.state'+select_user+' > .status').removeClass('away');
                        $('.state'+select_user+' > .status').addClass('online');
                      }else{
                        $('.state'+select_user+' > .status').removeClass('online');
                        $('.state'+select_user+' > .status').addClass('away');
                      }
                  });
                });
            },2000);                    
                    
            setInterval(function(){
                $('.chatclick_search').each(function(){
                  var select_user = $(this).attr('data-chat-id');  
                  $.post(base_url+'user/get_online_status',{selected_user:select_user},function(response){
                      if(response > 0){
                        $('.state'+select_user+' > .status').removeClass('away');
                        $('.state'+select_user+' > .status').addClass('online');
                      }else{
                        $('.state'+select_user+' > .status').removeClass('online');
                        $('.state'+select_user+' > .status').addClass('away');
                      }
                  });
                });
            },2000);        
            
            /*$(document).on('click','.chat-send-btn',function(){
                  var selected_user = $('#receiver_id').val();
                  var input_message = $('#input_message').val();
                  $.post(base_url+'user/send_chat',{selected_user:selected_user,input_message:input_message},function(response){
                      $('.chats').append(response);
                      $('#input_message').val('');
                      $(".chat-send-btn").addClass('disabled');
                  });
            });*/
            
            setInterval(function(){
                  var render_user = $('.selected').attr('data-chat-id');  
                  if(typeof (render_user) !== "undefined"){
                    /*$.post(base_url+'user/render_message',{selected_user:render_user},function(response){
                         $('.chats').html(response);
                    });*/
                    
                    $.post(base_url+'user/get_online_status',{selected_user:render_user},function(response){
                        if(response > 0){
                             $('.openchat'+render_user+' span').removeClass('away');
                             $('.openchat'+render_user+' span').addClass('online');
                           }else{
                             $('.openchat'+render_user+' span').removeClass('online');
                             $('.openchat'+render_user+' span').addClass('away');
                             $('.openchat'+render_user+' span').css('background-color','#e69a2a');
                           }
                    });
                                       
                  }
            },3000);
            
            $(document).on('keyup','#input_message',function(){
                 var input_message = $('#input_message').val();
                 if (input_message) {
                      $(".chat-send-btn").removeClass('disabled');
                 }
            });
         
            /*  $(document).on('keypress','#input_message',function(e){
                var code = (e.keyCode ? e.keyCode : e.which);
                if (code == 13) {
                    $(".chat-send-btn").trigger('click');
                    return false;
                }
            });*/

            $(document).on('click','#second_verify',function(){
                 $.get(base_url+'user/second_verification',function(response){
                    if(response==1)
                    {
                       $('#send_second_verify > .modal-body').html('<div style="color:green;">Please wait...</div>');
                       $('#send_second_verify > .modal-footer').html(''); 
                       setInterval(function(){
                       $('#send_second_verify > .modal-body').html('<div style="color:green;">Email was sent.Please check your mail..!</div>');
                       },3000);
                       setInterval(function(){
                        location.reload(); 
                       },7000);
                    }else{
                        $('#send_second_verify > .modal-body').html('<div style="color:#5c65be;">Error while submitting email....!Please try again.</div>');
                        $('#send_message-form-error').css('display','block');
                        setInterval(function(){
                        location.reload(); 
                       },3000);
                     }
                 });       
            });
            
            $(".redcircle").load(base_url+'user/notify_applicants', function(response) {
                if(response > 0){
                    $(".redcircle").css('display','block');
                }
            });
            $(".topnotification ul").load(base_url+'user/notify_list');
            setInterval(function(){
             $(".redcircle").load(base_url+'user/notify_applicants', function(response) {
                if(response > 0){
                    $(".redcircle").css('display','block');
                }
             });
            }, 5000);
            
            $(document).on('click',"#see_all_nofify",function(){
                window.location=base_url+'dashboard?notify=true';
            });
            
            $('.topnotification').on('click',function(){
                $.get(base_url+'user/notify_applicants_viewed', function(response) {
                   $(".redcircle").css('display','none');
                });
            });
            
			$(document).on('keyup','#activity_search',function(){
                 var search_value = $(this).val();                 
					
				 $.post(base_url+'user/search_activity_list',{search_value:search_value},function(activity_response){                     
                     $('.jlist').html(activity_response);
                 });
               
              
			});
			
            $(document).on('click','.selectday',function(){

                if($(this).parent('div').hasClass( "tmgselected"))
                {
                    $(this).parent('div').removeClass('tmgselected');
                }else{
                    $(this).parent('div').addClass('tmgselected');
                }
                var selected_count = $('.tmgselected').length;
                $('.tmgconfirmation strong').html(selected_count+' hour');
                if(selected_count == 0){
                        $('.tmgconfirmation a').addClass('disabled');
                }else{
                     $('.tmgconfirmation a').removeClass('disabled');
                }

            });
            $('.tmgconfirmation a').addClass('disabled');
            $(document).on('click','.tmgconfirmation a',function(){
                    $('.tmgconfirmation a').addClass('disabled');
                    var selected_count = $('.tmgselected').length;
                    var mentor_id = $('#mentor_id').val();
                    var session_data = [];
                $('.tmgselected a').each(function(index,value){
                 
                    session_data.push({'date_value':$(this).attr('data-date'),
                        'day_id':$(this).attr('data-day-id'),
                        'day_name':$(this).attr('data-day'),
                        'start_time':$(this).attr('data-start-time'),
                        'end_time':$(this).attr('data-end-time'),
                        'hour':'1'
                    });
                });
                var jsonOb = JSON.stringify(session_data);
               // console.log(jsonOb);
                $.post(base_url+'user/set_booked_session',{session_data:jsonOb},function(session_response){
                    console.log(session_response);
                      if(session_response == 1)
                      {
                        setTimeout(function(){ window.location=base_url+'user/pay/'+mentor_id ; },1000);
                      }
                });

            });

           //setInterval(function() {
                $.get(base_url+'user/conversation_ajax_request',function(res){
                    $('.conversation').html(res); 
                    
                $('.callbox').each(function(){
                    var username = $(this).find('#callUserName').val();
                    //var countDownDate_init = new Date("Aug 31, 2017 16:30:00");
                    var countDownDate_init = new Date($(this).find('.invite_date').val());
                    var invite_id = $(this).find('.invite_id').val();
                    var countDownDate = countDownDate_init.getTime();
                   if(countDownDate_init.getMinutes().toString().length === 1){
                        var _t = '0' + countDownDate_init.getMinutes();
                    }else{
                        var _t = countDownDate_init.getMinutes();
                        }
                    if(countDownDate_init.getHours().toString().length === 1){
                      var _h = '0' + countDownDate_init.getHours();
                    }else{
                      var _h = countDownDate_init.getHours();
                    }
                    var _time = (countDownDate_init.getHours() > 12) ? (_h-12 + ':' + _t +' PM') : (_h + ':' + _t +' AM');
                    var currentMinutes = new Date($(this).find('.invite_date').val());
                    var curr_min = currentMinutes.getHours();
                    
                    
                    var x = setInterval(function() {
                    // Get todays date and time
                    var now = new Date().getTime();
                    //console.log(now);
                    var now_date = new Date();
                    var current_m = now_date.getMonth() + 1;
                    var conv_m = countDownDate_init.getMonth() + 1;
                    var current_d = now_date.getFullYear() + '-' + current_m + '-' + now_date.getDate();
                    var conv_d = countDownDate_init.getFullYear() + '-' + conv_m + '-' + countDownDate_init.getDate();
                    
                    var distance = countDownDate - now;

                    var sixtyMinutesLater = new Date();
                    var hr = sixtyMinutesLater.getHours();
                    sixtyMinutesLater.setMinutes(sixtyMinutesLater.getMinutes() + 60);
                    
                    //console.log(curr_min + '====' + hr);
 
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    if (hours.toString().length === 1) {
                        hours = "0" + hours;
                    }
                    if (minutes.toString().length === 1) {
                        minutes = "0" + minutes;
                    }
                    if (seconds.toString().length === 1) {
                        seconds = "0" + seconds;
                    }
                    
                    if(hours > 0 || minutes > 0 || seconds > 0 ){
                       $('.conversation_start'+invite_id).html('<div class="callbtn">Remaining time for conversation - <strong id="demo"></strong></div>');
                       $('.conversation_start'+invite_id).find("#demo").html(hours + ":" + minutes + ":" + seconds); 
                    }
                   
                    if (distance < 0) {
                        if(minutes < 0 && seconds < 0 && current_d === conv_d && curr_min < hr){
                            $.post(base_url+'user/update_expire_status',{invite_id:invite_id},function(res){
                                window.location.reload();
                            });
                            $('.conversation_start'+invite_id).html('<div class="callbtn"><strong id="demo"></strong></div>');
                            $('.conversation_start'+invite_id).find("#demo").html(_time+" -EXPIRED");
                        }
                     }
                     if(minutes < 0 && seconds < 0 && current_d === conv_d && curr_min >= hr){
                        $('.conversation_start'+invite_id).html('<div class="callbtnactive"><input type="hidden" value="'+username+'" id="start_session"><a class="startVideo"  href="javacript:void(0)" data-toggle="modal" >Start Conversation</a></div>');
                      }
                    },1000);
                });
            });
       // },4000);
           
           
             $(document).on('click', '.star', function() {
                $(this).find($(".fa")).css('color','#ffc513');

                var rating = $(this).data('seq');
               // fillStars($(this).parent(), rating, 1 );
                 fillStars(rating);
                $('input[name="rating"]').val(rating);
             });

             $(document).on('click','#send_rating',function(){
                 var rating_value = $('#rating_value').val();
                 var mentor_id = $('.invite_to').val();
                 var rating_comment = $('#rating_comment').val();
                // alert(rating_value+'----'+mentor_id);
                 $.post(base_url+'user/save_rating',{rating_value:rating_value,mentor_id:mentor_id,rating_comment:rating_comment},function(result){
                    if(result == 1)
                    {
                        $('#rating_modal').modal('hide');
                    }
                 });
                 $('#rating_modal').modal('hide');
             });
 });
 
 function getSchedule()
 {
     $('#schedule_date_error').html('');
     var selected_date = $('#choosedate').val();
     var mentor_id = $('#mentor_id').val();
     if(selected_date == ''){
        $('#schedule_date_error').html('<small class="help-block" data-bv-validator="notEmpty" data-bv-for="schedule_date" data-bv-result="INVALID" style="color:red;">Date is required</small>');
        return false;
     }
     $.post(base_url+'user/get_schedule_from_date',{selected_date:selected_date,mentor_id:mentor_id},function(response){
             $('.tmgschedule').html(response);
     });
 }

 function convertDatevalue(d){
    var parts = d.toString().split(" ");
    var months = {Jan: "01",Feb: "02",Mar: "03",Apr: "04",May: "05",Jun: "06",Jul: "07",Aug: "08",Sep: "09",Oct: "10",Nov: "11",Dec: "12"};
    return parts[3]+"-"+months[parts[1]]+"-"+parts[2];
}
 
 function showVerifyModal()
 {
         $("#verify_info").modal({
           backdrop: 'static',
           keyboard: false  
         }); 
 }
 
 function showSchedule()
 {
         $("#choosedatetime").modal({
           backdrop: 'static',
           keyboard: false  
         }); 
 }

//Starts the AJAX request.
function searchSuggest() {
     var chat_user = $('#search_suggest').val();
     $.post(base_url+'user/search_chat_users',{keyword:chat_user},function(response){
         $('.chat-body-left').html(response);
     });
}
function CheckSession() {
      $.get(base_url+'welcome/check_session',function(response){
               return response;
      });
 }
 
 function delete_conversation(id)
 {
     $.post(base_url+'user/delete_conversation',{sender_id:id},function(response){
         if(response == 1)
         {
             $('.chats').html('');
         }
     });
 }
 
 function more_details(id)
 {
      $.post(base_url+'user/more_details',{invite_id:id},function(response){
             $('.moredetails').html(response);
     });
 }
 
//  function fillStarOnPercent(star, percent)
// {   var fill = 25 *  percent;
//     star.children('.cnt').css({'width' : fill +'px'});
// }

// function fillStars(parent, fullStars, percent){
//     for(var i = 1; i < 6; i++)
//     {
//         var star = parent.find('.star[data-seq="'+i+'"]');
//         if(i < fullStars)
//             fillStarOnPercent(star, 1);

//         if(i == fullStars)
//             fillStarOnPercent(star, percent);

//         if(i > fullStars)
//             fillStarOnPercent(star, 0);
//     }
// }

function fillStars(rating){

     for (var i =1; i <= 5; i++) {
       $('#st_'+i).find($(".fa")).css('color','#D3D3D3');
      
   }
   
   for (var i =1; i <= rating; i++) {
       $('#st_'+i).find($(".fa")).css('color','#ffc513');       
   }
}

function validateSearch()
{
	if($('#mentor_gender').val() == '' && $('#mentor_school').val() == '' && $('#mentor_schools_applied').val() == '' && $('#mentor_current_year').val() == '' && $('#mentor_extracurricular_activities').val() == '' && $('#mentor_job_company').val() == '' && $('#mentor_job_title').val() == '' && $('#mentor_job_from_year').val() == '' && $('#mentor_about').val() == '' && $('#mentor_languages_speak').val() == '')
	{
		$('#search-advance-error').css('display','block');
		$('#search-advance-error').html('Please select atleast one.');
		return false;
	}
}