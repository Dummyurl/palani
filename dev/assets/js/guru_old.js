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
        fields: {  
            
            first_name: {                 
                validators: {
                    notEmpty: {
                        message: 'The first name is required and cannot be empty'
                    }
                }
            },
            last_name: {                
                validators: {
                    notEmpty: {
                        message: 'The last name is required and cannot be empty'
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
                    },                    
                     callback:{
                        message: 'The Password is not valid',
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
                        },
                    identical: {
                        field: 'confirmPassword',
                        message: 'The password and its confirm are not the same'
                    }                

                    }

                }
            },
            confirm_password: {
                validators: {
                    notEmpty: {
                        message: 'The Confirm Password is required'
                    },
                    identical: {
                        field: 'password',
                        message: 'The Password and its confirm are not the same'
                    }
                }
            }              
        }
    }) .on('success.form.bv', function(e) {
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        $('.preloader').css('display','block');
                                        $('.preloader').html('<div class="loaderbar"></div>');
                                        var url = base_url + "user/save_signup_guru";
                                        var formData = $('#applicant_signup_form').serialize(); 
                                        $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            success:function(response)
                                            {
                                                if(response==0)
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
                                    
                                    
    
        $('#general_feedback').bootstrapValidator({
        fields: {
            feedbacker_name: {                 
                validators: {
                    notEmpty: {
                        message: 'The name is required and cannot be empty'
                    }
                }
            },
            feedbacker_email: {  
                validators: {                    
                    regexp: {
                      regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                      message: 'The value is not a valid email address'
                    } 
                }
            },
            feedbacker_comment: {                 
                validators: {
                    notEmpty: {
                        message: 'The Comment is required and cannot be empty'
                    }
                }
            }
             
        }
    }) .on('success.form.bv', function(e) {
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        var url = base_url+"welcome/save_general_feedback";;
                                        var formData = $('#general_feedback').serialize(); 
                                        $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            success:function(response)
                                            {
                                                if(response==0)
                                                {
                                                    $('#feedback-form-success').html(" Thanks ! We have recieved your Feedback ...");
                                                    $('#feedback-form-success').css('display','block');                                                    
                                                    $('#general_feedback').data('bootstrapValidator').resetForm(true);                                                
                                                }
                                                else
                                                {
                                                    $('#feedback-form-error').html("Error While Submitting Feedback !");
                                                    $('#feedback-form-error').css('display','block');
                                                }
                                            }
                                        })
                                        

                                    });
    

    // Validate the form manually
    $('#validateBtn').click(function() {
        $('#defaultForm').bootstrapValidator('validate');
    });

    $('#resetBtn').click(function() {
        $('#defaultForm').data('bootstrapValidator').resetForm(true);
    });
    
    
    
       $('#guru_forgot_password_form').bootstrapValidator({
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
                                        var url = base_url+"guru/resend_password";
                                        var formData = $('#guru_forgot_password_form').serialize(); 
                                        $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            success:function(response)
                                            {                                                 
                                                if(response==0)
                                                {   
                                                    $('#guru_forgot_password_success').html('Password has been sent to mail Id');
                                                    $('#guru_forgot_password_success').css('display','block');
                                                    $('#guru_forgot_password_error').css('display','none');
                                                    setInterval(function(){ window.location = base_url; }, 3000);
                                                }
                                                else if(response==2)
                                                {   
                                                    $('#guru_forgot_password_error').html('Error While Updating Password !');
                                                    $('#guru_forgot_password_success').css('display','none');
                                                    $('#guru_forgot_password_error').css('display','block');                                                    
                                                }                                                    
                                                else
                                                {
                                                    $('#guru_forgot_password_error').html(" Invalid Email Id !");                                                    
                                                    $('#guru_forgot_password_error').css('display','block');
                                                    $('#guru_forgot_password_success').css('display','none');
                                                }
                                         
                                           }
                                        })

                                    });
                                    

    
       $('#guru_login_form').bootstrapValidator({
       fields: {                
            email: {
                validators: {                    
                     notEmpty: {
                        message: ''
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
                        message: 'The password is required and cannot be empty'
                    }
                    ,
                    
                     callback:{
                        message: 'The password is not valid',
                         callback: function(value, password, $field){
                            if(value===''){
                                return true;
                             }

                            
                            return true;
                        }              

                    }
                        
            }              
        }
    }
    }).on('success.form.bv', function(e) {
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        var url = base_url+"guru/check_mentor";
                                        var formData = $('#guru_login_form').serialize(); 
                                        $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            success:function(response)
                                            {                                                 
                                                if(response==0)
                                                {   
                                                    $('#guru_login_error').html("");
                                                   
                                                }
                                                else
                                                {
                                                    $('#guru_login_error').html(" Wrong Credentials !");                                                    
                                                }
                                         
                                           }
                                        });

                                    });

    

    var check_username_path = base_url+"user/check_username";
    $('#mentor_profile_form').bootstrapValidator({
       fields: {                
            email: {
                validators: {                    
                    regexp: {
                      regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                      message: 'The value is not a valid email address'
                    } 
                }
            },
            mentor_phone: {
                validators: {
                    notEmpty: {
                        message: 'The Phone Number is required'
                    },
                    numeric: {
                        message:'Please enter numeric value'
                   }
                }
            },
           username: {                
                validators: {
                    notEmpty: {
                        message: 'The username is required'
                    },
                remote: {
                        message: 'The Username is not available',
                        url: check_username_path
                }
                }
            },    
            mentor_gender: {
                validators: {
                    notEmpty: {
                        message: 'The Gender is required'
                    }
                }
            }
            ,
            mentor_school: {
                validators: {
                    notEmpty: {
                        message: 'The School is required'
                    }
                }
            }  
            ,
            mentor_current_year: {
                validators: {
                    notEmpty: {
                        message: 'The Year is required'
                    }
                }
            }
            ,
            mentor_schools_applied: {
                validators: {
                    notEmpty: {
                        message: 'The Schools Applied is required'
                    }
                }
            },
            mentor_clubs: {
                validators: {
                    notEmpty: {
                        message: 'The Part of Clubs is required'
                    }
                }
            }
            ,
            mentor_executive_positions: {
                validators: {
                    notEmpty: {
                        message: 'The Positions in clubs is required'
                    }
                }
            },
             mentor_charge: {
                validators: {
                    notEmpty: {
                        message: 'The Mentor Charge is required'
                    },
                    numeric: {
                        message:'Please enter numeric value'
                   }
                }
            },  
            mentor_undergrad_school: {
                validators: {
                    notEmpty: {
                        message: 'The Undergrad School is required'
                    }
                }
            },
             address_line1: {
                validators: {
                    notEmpty: {
                        message: 'The Address Line1 is required'
                    }
                }
            },
             city: {
                validators: {
                    notEmpty: {
                        message: 'The City is required'
                    }
                }
            },
            state: {
                validators: {
                    notEmpty: {
                        message: 'The State is required'
                    }
                }
            },
             country: {
                validators: {
                    notEmpty: {
                        message: 'The Country is required'
                    }
                }
            },
             postal_code: {
                validators: {
                    notEmpty: {
                        message: 'The Postal Code is required'
                    }
                }
            }
        }
    }) .on('success.form.bv', function(e) {
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        var url = base_url+"guru/update_profile";
                                        var formData = $('#mentor_profile_form').serialize(); 
                                     
                                        $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            success:function(response)
                                            {                                                 
                                                if(response==0)
                                                {   
                                                    $.post(base_url+'guru/update_profile_status',{formData:formData},function(res){
                                                          //$('#verified').text('1');
                                                          setInterval(function(){ window.location = base_url+'dashboard'; }, 1000);
                                                    });
                                                    $("#profile_update_error").html("");
                                                    $("#profile_update_error").css("display","none");
                                                }
                                                else
                                                {
                                                    $("#profile_update_error").html(' Error While Updating '); 
                                                    //setTimeout(function(){ window.location = base_url+'dashboard'; }, 1000);
                                                }
                                         
                                           }
                                        })

                                    });

//$('#send_message button').on("click",function(){
//    alert('hii');
//});
//    

 $('#send_messages_form').bootstrapValidator({
        fields: {
            subject: {                 
                validators: {
                    notEmpty: {
                        message: 'The subject is required'
                    }
                }
            },
            invite_message: {  
                validators: {                    
                    notEmpty: {
                        message: 'The message is required'
                    }
                }
            }
             
        }
    }) .on('success.form.bv', function(e) {
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        var url = base_url+"user/send_invite_to_applicant";
                                        var formData = $('#send_messages_form').serialize(); 
                                        $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            success:function(response)
                                            {
                                                
                                                if(response==0)
                                                {
                                                    $('#send_messages_form > .modal-body').html('<div style="color:#5c65be;">Please Wait....</div>');
                                                    $('#send_messages_form > .modal-footer').html(''); 
                                                    setInterval(function(){
                                                    $('#send_messages_form > .modal-body').html('<div style="color:green;">Email was sent.Please check your mail..!</div>');
                                                    },3000);
                                                    setInterval(function(){
                                                     location.reload(); 
                                                    },7000);
                                                }
                                                else
                                                {
                                                    $('#send_message-form-error').html('<div style="color:#5c65be;">Error while submitting email....!</div>');
                                                    $('#send_message-form-error').css('display','block');
                                                 
                                                }
                                            }
                                        });
                                        
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

                    $(document).on('click','.loadmore',function () {
                      $(this).text('Loading...');
                        var ele = $(this).parent('li');
                            $.ajax({
                          url: 'loadmore',
                          type: 'POST',
                          data: {
                                  page:$(this).data('page'),
                                },
                          success: function(response){
                               if(response){
                                 ele.hide();
                                    $(".news_list").append(response);
                                  }
                                }
                       });
                    });

                    var percent = $('.progress-bar').attr('aria-valuenow');
                    var verify = $('#verified').text();
                    if(percent < 20 ||verify == 0)
                    {
                        $('.topprfpic').html('<div class="inactiveprofile">Inactive</div>');
                        $('.mainnav ul li a').addClass('inactive-menu'); 
                    }


                   $(document).on('click','.loadmore_search',function () {
                        
                          $(this).text('Loading...');
                          var ele = $(this).parent('div');
                          $.ajax({
                          url:  base_url +'welcome/loadmore_guru',
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

                    $(document).on('click','.loadmore-g',function () {
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
                          var ele = $(this).parent('div');
                          $.ajax({
                          url:  base_url +'welcome/loadmore_search_guru_home',
                          type: 'POST',
                          data: {
                                  page:$(this).data('page'),keyword:$('#old_keyword').val(),gender:$('#gender').val(),admitted_school:$('#admitted_school').val(),school_offer:$('#school_offer').val(),school_year:$('#school_year').val()
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
                          url:  base_url +'welcome/search_left',
                          type: 'POST',
                          data: { keyword:$('#old_keyword').val(),gender:gender,admitted_school:admitted_school,school_offer:school_offer,school_year:school_year },
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
                   
                   
                    $(document).on('click','.search-left-applicant',function(){
                        var gender = $('#gender').val();
                        var admitted_school = $('#admitted_school').val();
                        var school_offer = $('#school_offer').val();
                        var school_year = $('#school_year').val();
                        $.ajax({
                          url:  base_url +'welcome/search_left_applicant',
                          type: 'POST',
                          data: { gender:gender,admitted_school:admitted_school,school_offer:school_offer,school_year:school_year },
                          success: function(response){
                                if(response !== 'false'){
                                 $("#right-search-content").html(response);
                                 //$(".widget-title").html('0 Matches for your search');
                             }else{
                                 $(".widget-title").html('0 Matches for your search');
                                 $("#guru-list").html('');
                             }
                           }
                       });
                   });

                    $('#activity_search').bind('keypress', function(e) {
                       if (e.keyCode === 13) return false;
                     });

                    
                    $(document).on('click','.loadmore-applicant',function () {
                          $(this).text('Loading...');
                          var ele = $(this).parent('div');
                          $.ajax({
                          url:  base_url +'user/loadmore_applicant',
                          type: 'POST',
                          data: {
                                  page:$(this).data('page')
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
                   
              
              $(document).on('click','.timingsnav li a',function(){
                    var selected_value = $(this).attr('data-day-value');
                    var append_html = $(this).attr('data-append-value');
                    var selected_day = $(this).text();

                    $('#id_value').val(append_html);
                    $('#day_value').val(selected_value);
                    $('#day_name').val(selected_day);
                    var select_html  = '<option value="">Select Time</option>';

                    for(var i=6; i<=23; i++){
                    var nexttime =  i;
                    if(nexttime.toString().length == 1){
                        nexttime = '0'+ nexttime;
                    }
                    var timeval = nexttime+':00:00';
                    var timeString = nexttime+':00:00';
                    var H = +timeString.substr(0, 2);
                    var h = H % 12 || 12;
                    if(h.toString().length < 2){
                        h = '0'+h;
                    }
                    var ampm = H < 12 ? " am" : " pm";
                    timeString = h + timeString.substr(2, 3) + ampm;
                    select_html += '<option value="'+timeval+'">'+timeString+'</option>';
                   
                  }

                    $('#from_time').html(select_html);
                    $('#to_time').html(select_html);
                   

                    $.post(base_url+'user/schedule_list',{selected_value:selected_value,selected_day:selected_day},function(result){
                        $('#'+append_html).html(result);
                       
                    });
                   
                    
                    $.post(base_url+'user/remove_options',{selected_value:selected_value,selected_day:selected_day},function(response){
                        var result = JSON.parse(response);
                        $(result).each(function(index,value){
                              var remove  = range(parseInt(value.time_start),parseInt(value.time_end),10);
                            
                              var validate = 0;
                              $(remove).each(function(i,ivalue){
                                if(ivalue != parseInt(value.time_end)){
                                if(ivalue.toString().length == 1)
                                {
                                     validate = '0'+ivalue+':00:00';
                                }else{
                                     validate = ivalue+':00:00';
                                }
                                }
                                 console.log(validate);
                                $('#from_time option[value="'+validate+'"]').remove();
                                $('#to_time option[value="'+validate+'"]').remove();
                              });    
                             
                        });
                    
                    });

              });
			  
               $(document).on('change','#from_time',function(){
				   
						var time = $(this).val();
                        var time_digit = parseInt(time);

						var select_html  = '<option value="">Select Time</option>';

                        for(var i=6; i<=23; i++){

                            var nexttime =  parseInt(i);
                            if(nexttime.toString().length < 2){
                                nexttime = '0'+ parseInt(nexttime);
                            }
                            var timeval = nexttime+':00:00';
                            var timeString = nexttime+':00:00';
                            var H = +timeString.substr(0, 2);
                            var h = H % 12 || 12;
                            var ampm = H < 12 ? " am" : " pm";
                            timeString = h + timeString.substr(2, 3) + ampm;
    						if(time_digit != i && time_digit < i){
                             select_html += '<option value="'+timeval+'">'+timeString+'</option>';
    						}
					
                    }
						$('#to_time').html(select_html);
					
              }); 
			  
              $(document).on('click','.delete_schedule',function(){
                var delete_value = $(this).attr('data-delete-val');
                var append_html = $('#id_value').val();
                var c = confirm('Are you sure to delete?');
                if(c){
                        $.post(base_url+'user/delete_schedule_time',{delete_value:delete_value},function(res){
                             if(res == 1){
                               $('#'+append_html+'_link').click();
                             }
                        });
                }
              }); 

$("#tsunday_link").click();

$('#mobile_verify_form').bootstrapValidator({
        fields: {
            mobile_number: {                 
                validators: {
                    notEmpty: {
                        message: 'The Mobile Number is required'
                    }
                }
            }
        }
    }) .on('success.form.bv', function(e) {
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        var url = base_url+"welcome/send_otp";
                                        var formData = $('#mobile_verify_form').serialize(); 
                                        $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            success:function(response)
                                            {
                                                if(response==0)
                                                {
                                                   $('#mobile_first_verify').css("display","none");
                                                   $('#mobile_first_verify_code').css("display","block");
                                                }
                                                else
                                                {
                                                    $('#error_msg').html("Error While Submitting Mobile Number !");
                                                    $('#error_msg').css('display','block');
                                                }
                                            }
                                        })
                                        

            });

var check_from_time = base_url+'user/check_schedule_start_time';
var check_to_time = base_url+'user/check_schedule_end_time';
$('#schedule_mentor_form').bootstrapValidator({
        fields: {
            from_time: {                 
                validators: {
                    notEmpty: {
                        message: 'The From Time is required'
                    },
                    callback:{
                        message: 'The From Time is required'
                    }
            }
            },
            to_time: {                 
                validators: {
                    notEmpty: {
                        message: 'The To Time is required'
                    },
                    callback:{
                        message: 'The To Time is required'
                    }
                }
            }
        }
    }).on('success.form.bv', function(e) {
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        var $form = $(e.target);
                                        var bv = $form.data('bootstrapValidator');

                                        var url =base_url+'user/add_schedule_time';
                                        var selected_value = $('#day_value').val();
                                        var append_html = $('#id_value').val();
                                        var selected_day = $('#day_name').val();
                                        var from_time = $('#from_time').val();
                                        var to_time = $('#to_time').val();
                                        if(from_time == ''){
                                              bv.updateStatus('from_time', 'INVALID', 'callback');
                                              return false;
                                        }
                                        if(to_time == ''){
                                               bv.updateStatus('to_time', 'INVALID', 'callback');
                                              return false;
                                        }
                                        var shedule = $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:{selected_value:selected_value,selected_day:selected_day,from_time:from_time,to_time:to_time},
                                           
                                            success:function(response)
                                            {
                                                //console.log(response);

                                                if(response==1)
                                                {
                                                $('#'+append_html+'_link').click();
                                                   $('.tadd').prop('disabled', false);
                                                   $('#from_time option[value="'+from_time+'"]').attr('disabled',true);
                                                   $('#to_time option[value="'+to_time+'"]').attr('disabled',true);
                                                   $('#from_time').val('');
                                                   $('#to_time').val('');
                                                }
                                               
                                            }
                                        });
                                        

            });


$('#mobile_verify_code_form').bootstrapValidator({
        fields: {
            verification_code: {                 
                validators: {
                    notEmpty: {
                        message: 'The Verification Code is required'
                    }
                }
            }
        }
    }) .on('success.form.bv', function(e) {
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        var url = base_url+"welcome/send_code";
                                        var formData = $('#mobile_verify_code_form').serialize(); 
                                        $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            success:function(response)
                                            {
                                                if(response==0)
                                                {
                                                    $('#mobile_first_verify_code').css("display","none");
                                                    $('#mobile_first_verify_success').css("display","block");
//                                                   setTimeout(function(){
//                                                       window.location= base_url+'welcome/verify_success';
//                                                   },1000);
                                                }
                                                else
                                                {
                                                    $('#error_msg').html("Error While Submitting Code !");
                                                    $('#error_msg').css('display','block');
                                                }
                                            }
                                        });
                                        
                              });
                              
                              
   $('#search_by_subject').bootstrapValidator({
        fields: {
            keyword: {                 
                validators: {
                    notEmpty: {
                        message: 'The Subject is required'
                    }
                }
            }
        }
    }) .on('success.form.bv', function(e) {
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        $('#search_by_subject').submit(); 
                                       
                              });
               
    
    $('#search_by_university').bootstrapValidator({
        fields: {
            keyword_university: {                 
                validators: {
                    notEmpty: {
                        message: 'The University is required'
                    }
                }
            }
        }
    }) .on('success.form.bv', function(e) {
                                        // Prevent form submission                                        
                                        e.preventDefault();
                                        $('#search_by_university').submit(); 
                                       
                              });
                              
                              
                               $('.chatclick').on('click',function(){
                                var selected_user = $(this).attr('data-chat-id');    
                                $(".chatclick").removeClass("selected");
                                $(this).addClass('selected');
                                $.post(base_url+'user/get_guru_selected_chat',{selected_user:selected_user},function(response){
                                    $('.chat-box-right').html(response);
                                    $(".chat-send-btn").addClass('disabled');
                                });
                              });
                              
                               $(document).on('click','.chatclick_search',function(){
                                var selected_user = $(this).attr('data-chat-id');    
                                $(".chatclick").removeClass("selected");
                                $(".chatclick_search").removeClass("selected");
                                $(this).addClass('selected');
                                $.post(base_url+'user/get_guru_selected_chat',{selected_user:selected_user},function(response){
                                    $('.chat-box-right').html(response);
                                    $(".chat-send-btn").addClass('disabled');
                                });
                              });
                              
                              //$('div[class*="unread_count"]').css('display','none');
                                setInterval(function(){
                                    $('.chatclick').each(function(){
                                      var select_user = $(this).attr('data-chat-id');  
                                      if(select_user > 0){
                                      $.post(base_url+'user/get_guru_message_count',{selected_user:select_user},function(response){
                                          if(response > 0){
                                            $('.unread_count'+select_user).css('display','block');
                                            $('.unread_count'+select_user).html(response);
                                          }else{
                                            $('.unread_count'+select_user).css('display','none');
                                          }
                                      });
                                  }
                                    });
                                },200);
                                
                                //$('div[class*="unread_count"]').css('display','none');
                                setInterval(function(){
                                    $('.chatclick_search').each(function(){
                                      var select_user = $(this).attr('data-chat-id');  
                                      if(select_user > 0){
                                      $.post(base_url+'user/get_guru_message_count',{selected_user:select_user},function(response){
                                          if(response > 0){
                                            $('.unread_count'+select_user).css('display','block');
                                            $('.unread_count'+select_user).html(response);
                                          }else{
                                            $('.unread_count'+select_user).css('display','none');
                                          }
                                      });
                                  }
                                    });
                                },200);
                                
            
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
                                       if(select_user > 0){ 
                                      $.post(base_url+'user/get_online_status',{selected_user:select_user},function(response){
                                           if(response > 0){
                                                $('.state'+select_user+' > .status').removeClass('away');
                                                $('.state'+select_user+' > .status').addClass('online');
                                                $('.openchat'+select_user+' > .status').removeClass('away');
                                                $('.openchat'+select_user+' > .status').addClass('online');
                                              }else{
                                                $('.state'+select_user+' > .status').removeClass('online');
                                                $('.state'+select_user+' > .status').addClass('away');
                                              }
                                      });
                                    }
                                    });
                                
                                },2000);
                                
                                setInterval(function(){
                                    $('.chatclick_search').each(function(){
                                      var select_user = $(this).attr('data-chat-id');  
                                       if(select_user > 0){
                                      $.post(base_url+'user/get_online_status',{selected_user:select_user},function(response){
                                           if(response > 0){
                                                $('.state'+select_user+' > .status').removeClass('away');
                                                $('.state'+select_user+' > .status').addClass('online');
                                                $('.openchat'+select_user+' > .status').removeClass('away');
                                                $('.openchat'+select_user+' > .status').addClass('online');
                                              }else{
                                                $('.state'+select_user+' > .status').removeClass('online');
                                                $('.state'+select_user+' > .status').addClass('away');
                                              }
                                      });
                                  }
                                    });
                                },2000);
                                
/*
                            $(document).on('click','.chat-send-btn',function(){
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
                                      }); */
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
                             },6000);
            
                              $(document).on('keyup','#input_message',function(){
                                   var input_message = $('#input_message').val();
                                   if (input_message) {
                                        $(".chat-send-btn").removeClass('disabled');
                                   }
                              });
                              
                              /* $(document).on('keypress','#input_message',function(e){
                                    var code = (e.keyCode ? e.keyCode : e.which);
                                    if (code == 13) {
                                        $(".chat-send-btn").trigger('click');
                                        return false;
                                    }
                                });*/
                   
				              $(document).on('keyup','#activity_search',function(){
									var search_value = $(this).val();
										
									 $.post(base_url+'user/search_activity_list',{search_value:search_value},function(activity_response){
										 $('.jlist').html(activity_response);
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
                           
             
               // Update the count down every 1 second
               //var x = setInterval(function() {
                
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
                    currentMinutes.setMinutes(currentMinutes.getMinutes() + 60);
					
					
					var sixtyMinutesLater = new Date();
                    var hr = sixtyMinutesLater.getHours();
                    sixtyMinutesLater.setMinutes(sixtyMinutesLater.getMinutes() + 60);
					
					//console.log(currentMinutes.getTime() + '=======' + hr);
					
                    var x = setInterval(function() {
                    // Get todays date and time
                    var now = new Date().getTime();
                    var now_date = new Date();
                    var current_m = now_date.getMonth() + 1;
                    var conv_m = countDownDate_init.getMonth() + 1;
                    var current_d = now_date.getFullYear() + '-' + current_m + '-' + now_date.getDate();
                    var conv_d = countDownDate_init.getFullYear() + '-' + conv_m + '-' + countDownDate_init.getDate();
                    
                    var distance = countDownDate - now;
                    
                   // console.log(curr_min + '====' + hr);
 
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
                        if(minutes < 0 && seconds < 0 && current_d == conv_d && curr_min < hr){
                             $.post(base_url+'user/update_expire_status',{invite_id:invite_id},function(res){
                                
                             });
                            $('.conversation_start'+invite_id).html('<div class="callbtn"><strong id="demo"></strong></div>');
                            $('.conversation_start'+invite_id).find("#demo").html(_time+" -EXPIRED");
                            setTimeout(function(){
                                window.location.reload();
                            },1000)
                        }
                     }
                     if(minutes < 0 && seconds < 0 && current_d == conv_d && curr_min >= hr){
                        $('.conversation_start'+invite_id).html('<div class="callbtnactive"><input type="hidden" value="'+username+'" id="start_session"><a class="startVideo" href="javacript:void(0)" data-toggle="modal" >Start Conversation</a></div>');
                      }
                      
                    },1000);
                    
                });
            });
             
		
	 
});

function showModal(id) {
      $(".modal").modal('hide');
      alert(id);
      $("#" + id).modal({
        backdrop: 'static',
        keyboard: false  // to prevent closing with Esc button (if you want this too)
    });
    
}

function show_mobile_modal()
{
    $(".modal").modal('hide');
    $("#verifymobile").modal({
           backdrop: 'static',
           keyboard: false  
    }); 
}

function showMobileData()
{
    $(".success-signup").css('display','none');
    $("#mobile_first_verify").css('display','block');
   
}

function check_mobile(mobile)
{
    if(mobile !== '')
    {
        $('#error_msg').html('');
    }
}

function check_code(code)
{
    if(code !== '')
    {
        $('#error_msg_code').html('');
    }
}


function send_otp()
{
    var mobile_number = $('#mobile_number').val();
    if(mobile_number == '')
    {
        $('#error_msg').html('Please Enter Mobile Number');
        return false;
    }
    $.post(base_url + 'user/send_otp',{mobile_number:mobile_number},function(response){
         $(".modal").modal('hide');
         $("#verify_code").modal({
           backdrop: 'static',
           keyboard: false  
         }); 
    });
    
}

function send_code()
{
    var verification_code = $('#verification_code').val();
    if(verification_code == '')
    {
        $('#error_msg_code').html('Please Enter Verification Code');
        return false;
    }
    $.post(base_url + 'user/send_code',{verification_code:verification_code},function(response){
         $(".modal").modal('hide');
         $("#verify_success").modal({
           backdrop: 'static',
           keyboard: false  
         }); 
    });
    
}

//Starts the AJAX request.
function searchSuggest() {
     var chat_user = $('#search_suggest').val();
     $.post(base_url+'user/search_chat_users_guru',{keyword:chat_user},function(response){
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
 
 function checkinner_validation()
 {
	
     var search_value= $('#old_keyword').val();     
     if(search_value=='')
     {
         $('.error_old').html('<font style="color:red;">Please Enter Subject</font>');
         return false;
     }
	 $('.overlay').fadeIn(3000 , function(){  
		 $(this).css('display','none'); 
	 }); 
	 //return false;
	 return true;
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

function range(start, end)
{
    var numbers = [];
    for (; start <= end; start++)
    {
        numbers.push(start);
    }
    return numbers;
}