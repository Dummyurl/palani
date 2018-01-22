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
                                                    window.location = base_url+"dashboard";
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
                                                    $('#let_us_know').modal('hide');                                               
                                                }
                                                else
                                                {
                                                    $('#feedback-form-error').html("Error While Submitting Feedback !");
                                                    $('#feedback-form-error').css('display','block');
                                                }
                                            }
                                        })
                                        

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
$('#applicant_profile_form')
.find('[name="country"]')
.chosen()
            // Revalidate the color when it is changed
            .change(function(e) {
                $('#applicant_profile_form').bootstrapValidator('revalidateField', 'country');
            })
            .end()
            .bootstrapValidator({
                excluded: ':disabled',
                feedbackIcons: {               
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },            
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
                    },
                    country: {
                        validators: {                    
                            notEmpty: {
                                message: 'Select country'
                            }
                        }
                    }, state: {
                        validators: {                    
                            notEmpty: {
                                message: 'Select state'
                            }
                        }
                    }, city: {
                        validators: {                    
                            notEmpty: {
                                message: 'Select city'
                            }
                        }
                    },

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
          beforeSend:function(){
            $('.overlay').css("display","block");
        },
        success: function(response){
            $('.overlay').css("display","none");
            if(response){
                ele.remove();            
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
                              beforeSend:function(){
                                $('.overlay').css("display","block");
                            },
                            success: function(response){
                              $('.overlay').css("display","none");
                              if(response){
                                ele.remove();                             
                                $("#guru-list").append(response);
                            }
                        }
                    });
                      });




    $(document).on('keyup','.right_top_search',function(){

     var gender = $('#right_top_search').val();
     var admitted_school = $('#right_top_search').val();
     var school_offer = $('#right_top_search').val();
     var school_year = $('#right_top_search').val();
     var school_year = $('#right_top_search').val();
     var order_by = $('.ordering').val();
     var keyword = $('#right_top_search').val();

  //    if(gender == '' && admitted_school == '' && school_offer == '' && school_year == '')
  //    {
  //     $('#search-error').html('Please select atleast one.');
  //     return false;
  // }
  $('#search-error').html('');
  $.ajax({
   url:  base_url +'user/search_right',
   type: 'POST',
   data: { gender:gender,admitted_school:admitted_school,school_offer:school_offer,school_year:school_year,order_by:order_by,keyword:keyword},
   beforeSend:function(){
    $('.overlay').css("display","block");
},
success: function(response){
    $('.overlay').css("display","none");
    // console.log(response);

    if(response == 0){
       $(".widget-title").html('0 Matches for your search');
       $("#guru-list").html('<p>Mentors not found</p>');
   }else{
       $("#right-search-content").html(response);
   }
}
});
});




    $(document).on('click','.search-left',function(){

     var gender = $('#gender').val();
     var admitted_school = $('#admitted_school').val();
     var school_offer = $('#school_offer').val();
     var school_year = $('#school_year').val();
     var school_year = $('#school_year').val();
     var order_by = $('.ordering').val();

     if(gender == '' && admitted_school == '' && school_offer == '' && school_year == '')
     {
      $('#search-error').html('Please select atleast one.');
      return false;
  }
  $('#search-error').html('');
  $.ajax({
   url:  base_url +'user/search_left',
   type: 'POST',
   data: { gender:gender,admitted_school:admitted_school,school_offer:school_offer,school_year:school_year,order_by:order_by},
   beforeSend:function(){
    $('.overlay').css("display","block");
},
success: function(response){
    $('.overlay').css("display","none");
    if(response == 0){
       $(".widget-title").html('0 Matches for your search');
       $("#guru-list").html('<p>Mentors not found</p>');
   }else{
       $("#right-search-content").html(response);
   }
}
});
});


    $(document).on('change','.ordering',function(){

     var gender = $('#gender').val();
     var admitted_school = $('#admitted_school').val();
     var school_offer = $('#school_offer').val();
     var school_year = $('#school_year').val();
     var school_year = $('#school_year').val();
     var order_by = $('.ordering').val();

  //    if(gender == '' && admitted_school == '' && school_offer == '' && school_year == '')
  //    {
  //     $('#search-error').html('Please select atleast one.');
  //     return false;
  // }
  $('#search-error').html('');
  $.ajax({
   url:  base_url +'user/search_left',
   type: 'POST',
   data: { gender:gender,admitted_school:admitted_school,school_offer:school_offer,school_year:school_year,order_by:order_by},
   beforeSend:function(){
    $('.overlay').css("display","block");
},
success: function(response){
    $('.overlay').css("display","none");
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

                  var selected_user_id = $(this).attr('data-chat-id');  // Id 
                  var selected_name = $(this).attr('data-name');  // First & Last name 
                  var selected_user_name = $(this).attr('data-username'); // username          
                    var status = $(this).attr('data-status'); // status              
                    var total_msg = $(this).attr('data-total'); // status              


                    $('#'+selected_user_name).text('');
                    $(".chatclick").removeClass("selected");
                    $(this).addClass('selected');
                    $('.openchat').html('<a href="#">'+selected_name+'<span class="status '+status+'"></span></a>');
                    $('#recipients').val(selected_user_name);
                    $('#receiver_id').val(selected_user_id);                  
                    $('#total_msg').val(total_msg);                  
                    $('#chat_box').removeClass('hidden');
                    $('.chats').html('<img src="'+base_url+'assets/images/loading.gif" class="loading">');


                    $.post(base_url+'user/get_messages',{selected_user_id:selected_user_id},function(response){                                    
                        $('.chats').html(response); 

                        $('#hidden_id').focus().addClass('hidden'); 
                        $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
                        $(".slimscrollleft.chats").mCustomScrollbar("update");    
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


                        $('.progress .progress-bar').css("width",function() {
                            return $(this).attr("aria-valuenow") + "%";
                        });


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


                    });
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



//     sinchClient = new SinchClient({
//     applicationKey: 'f06ae4f2-4980-40aa-89ca-9b98d80d70c4',
//     capabilities: {calling: true, video: true, messaging: true},
//     supportActiveConnection: true,
//     onLogMessage: function(message) {
//         if(message.code == 4000)
//         {
//             var signInObj = {};
//             signInObj.username = $('#sinch_username').val();
//             signInObj.password = $('#sinch_username').val();
//             sinchClient.start(signInObj, function() {
//                     global_username = signInObj.username;
//                     localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
//                     //window.location = base_url+"dashboard?notify=true";
//             }).fail(handleError);
//         }
//         //console.log(message);
//     }
// });

// sinchClient.startActiveConnection();
function load_more(total){      

    var selected_user_id = $('#receiver_id').val();                  

    $.post(base_url+'user/get_old_messages',{selected_user_id:selected_user_id,total:total},function(res){  
        if(res){        
         $('.load-more-btn').html('<button class="btn btn-default" data-page="2"><i class="fa fa-refresh"></i> Load More</button>');               
         $('#ajax_old').prepend(res);
     }else{
         $('.load-more-btn').html('<button class="btn btn-default">Thats all!</button>');
     }
 }); 
}

function message()
{


   var msg = $.trim($('#input_message').val());
   var to_username = $('#recipients').val();
   var sender_id = $('#sender_id').val();
   var sessionObj = JSON.parse(localStorage[sessionName] || '{}');
        // Get the messageClient
        var messageClient = sinchClient.getMessageClient(); 
        // Create a new Message
        var message = messageClient.newMessage(to_username, msg);
        // Alt 1: Send it with success and fail handler
        messageClient.send(message);

       $.post(base_url+'chat/insert_chat',{to_username:to_username,input_message:msg},function(response){
        });





}


// function  handleSuccess(to_username,msg){

//    $.post(base_url+'chat/insert_chat',{to_username:to_username,input_message:msg},function(response){

//    });
// }
// function  handleFail(to_username,msg){
//         // Get the messageClient
//         var messageClient = sinchClient.getMessageClient(); 
//         // Create a new Message
//         var message = messageClient.newMessage(to_username, msg);
//         // Alt 1: Send it with success and fail handler
//         messageClient.send(message, handleSuccess, handleFail)
//         // Alt 2: Send it and append handlers using the promise returned
//         messageClient.send(message)
//         .then(handleSuccess(to_username,msg))    
//         .fail(handleFail(to_username,msg));    
//         $.post(base_url+'chat/insert_chat',{to_username:to_username,input_message:msg},function(response){

//         });
//     }

    var messageClient = sinchClient.getMessageClient();
    var myListenerObj = {
        onMessageDelivered: function(messageDeliveryInfo) {
          // console.log(messageDeliveryInfo);
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


   var h_url = $('#uri_segment').val();
   var h_urls = $('#uri_segments').val();

   if(h_url != 'messages' && h_urls !='incoming_video_call'){                    
    $.notify({                    
        message: message.senderId+'<br><br>'+message.textBody 
    },{                    
        type: 'success'
    });                
}

        var to_username = $('#recipients').val();     // sender username     
        if(to_username == message.recipientIds[0] || to_username == message.recipientIds[1]){



            $.post(base_url+'chat/get_image',{to_username:message.senderId},function(res){ 
                var obj = jQuery.parseJSON(res);
                var image = obj.image;
                var msg = obj.data.msg;
                var type = obj.data.type;
                var file_name = base_url+obj.data.file_path+'/'+obj.data.file_name;
                var time = message.timestamp.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });
                if(msg == 'file' && type == 'image'){


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
             }else if(msg == 'file' && type == 'others'){

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





$(document).on('click','.chatclick_search',function(){
                  var selected_user_id = $(this).attr('data-chat-id');  // Id 
                  var selected_name = $(this).attr('data-name');  // First & Last name 
                  var selected_user_name = $(this).attr('data-username'); // username        
                    var status = $(this).attr('data-status'); // status                                

                    $('#'+selected_user_name).text('');
                    $(".chatclick_search").removeClass("selected");
                    $(this).addClass('selected');
                    $('.openchat').html('<a href="#">'+selected_name+'<span class="status '+status+'"></span></a>');
                    $('#recipients').val(selected_user_name);
                    $('#receiver_id').val(selected_user_id);
                    
                    $('#chat_box').removeClass('hidden');
                    $('.chats').html('<img src="'+base_url+'assets/images/loading.gif" class="loading">')
                    $.post(base_url+'user/get_messages',{selected_user_id:selected_user_id},function(response){                                    
                        $('.chats').html(response); 
                        $('#hidden_id').focus().addClass('hidden');  
                        $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
                        $(".slimscrollleft.chats").mCustomScrollbar("update");    
                      //   setTimeout(function() {
                      //     $(".slimscrollleft.chats").mCustomScrollbar("update");
                      //     $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
                      //     $(".slimscrollleft.chats").mCustomScrollbar("update");
                      //     $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
                      //     $(".slimscrollleft.chats").mCustomScrollbar("update");
                      //     $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  

                      // }, 3000);
                      //    setTimeout(function() {
                      //     $(".slimscrollleft.chats").mCustomScrollbar("update");
                      //     $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
                      //     $(".slimscrollleft.chats").mCustomScrollbar("update");
                      //     $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
                      //     $(".slimscrollleft.chats").mCustomScrollbar("update");
                      //     $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  

                      // }, 1000);

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



                  });
                });


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




             // Notification 

                                  // Onload Count over bell 
                                  $(".redcircle").load(base_url+'user/notify_applicants', function(response) {
                                    if(response > 0){
                                        $(".redcircle").css('display','block');
                                        $('.topnotification').addClass('animate');
                                        setTimeout(function() {
                                            $('.topnotification').removeClass('animate');
                                        }, 2000);
                                    }
                                });
                                  $(".topnotification ul").load(base_url+'user/notify_list');  

                                // count over bell every 5 seconds 

                                setInterval(function(){
                                   $(".redcircle").load(base_url+'user/notify_applicants', function(response) {
                                    if(response > 0){
                                        $(".redcircle").css('display','block');
                                        $(".topnotification ul").load(base_url+'user/notify_list');
                                        $('.topnotification').addClass('animate');
                                    }                                                             
                                    setTimeout(function() {
                                       $('.topnotification').removeClass('animate');
                                   }, 2000);
                                });
                               }, 5000);


                                 // redirect to dashboard onclick notificaiton msg 
                                 $(document).on('click',"#see_all_nofify",function(){
                                  window.location=base_url+'dashboard';

                              });

                                 $('.topnotification').on('click',function(){
                                    $.get(base_url+'user/notify_applicants_viewed', function(response) {
                                       $(".redcircle").css('display','none');
                                       $('.topnotification').addClass('animate');
                                   });
                                    
                                });






            // Check call to join every 5 seconds 
            setInterval(function(){
             $.get(base_url+'user/get_call', function(response) {

                if(response){
                    $('.new_call').html(response);                
                    $('audio#ringtone').trigger("play");
                    $('.join').click(function(){
                        var url  = $(this).attr('href');    
                        var call_id  = $(this).attr('call_id');    

                        newpopup = window.open(url,'newwindow','width=1200, height=1200');

                        $.post(base_url+'user/attend_call_status',{call_id:call_id},function(res){

                        }); 
                        $('.new_call').html('');                
                        $('audio#ringtone').trigger("pause");
                        return false;
                    }); 

                    $('.reject').click(function(){
                        $('.new_call').html('');                
                        $('audio#ringtone').trigger("pause");
                        var call_id = $(this).attr('id');
                        $.post(base_url+'user/set_call_status',{call_id:call_id},function(res){

                        })                   

                    }); 


                }else{
                   $('.new_call').html('');                
                   $('audio#ringtone').trigger("pause");

               }


           });
         }, 5000);


            

            
            
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
                        'time_zone':$(this).attr('data-timezone'),
                        'hour':'1'
                    });
                });
                var jsonOb = JSON.stringify(session_data);
               // console.log(jsonOb);
               $.post(base_url+'user/set_booked_session',{session_data:jsonOb},function(session_response){
               // console.log(session_response);
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
                    var channel = $(this).find('#channel').val();
                    var mentor_id = $(this).find('#mentor_id').val();

                    //var countDownDate_init = new Date("Aug 31, 2017 16:30:00");
                    var countDownDate_init = new Date($(this).find('.invite_date').val()); // From time 
                    var invite_id = $(this).find('.invite_id').val(); // ID

                    var countDownDate = countDownDate_init.getTime(); // Splitting from_time from datetime 

                    if(countDownDate_init.getMinutes().toString().length === 1){ // if minutes in one digit add 0 before 

                        var _t = '0' + countDownDate_init.getMinutes();
                    }else{
                        var _t = countDownDate_init.getMinutes(); 
                    }

                    if(countDownDate_init.getHours().toString().length === 1){ // if hours  in one digit add 0 before 
                      var _h = '0' + countDownDate_init.getHours();
                  }else{
                      var _h = countDownDate_init.getHours();
                  }
                  // console.log(_time);


                  var _time = (countDownDate_init.getHours() > 12) ? (_h-12 + ':' + _t +' PM') : (_h + ':' + _t +' AM'); // setting am pm for from_time 
                  var currentMinutes = new Date($(this).find('.invite_date').val()); 
                  var curr_min = currentMinutes.getHours(); // getting from time hour 


                  var x = setInterval(function() {
                    // Get todays date and time
                    var now = new Date().getTime(); // current time 
                    //console.log(now);
                    var now_date = new Date(); // current date 
                    var current_m = now_date.getMonth() + 1;  // current month                    
                    var conv_m = countDownDate_init.getMonth() + 1; // getting from time month                          
                    var current_d = now_date.getFullYear() + '-' + current_m + '-' + now_date.getDate(); // Current date 
                    var conv_d = countDownDate_init.getFullYear() + '-' + conv_m + '-' + countDownDate_init.getDate(); // from time Date 
                    var distance = countDownDate - now; // Distance between from time date and today date 


                    var sixtyMinutesLater = new Date(); // current date time 
                    var hr = sixtyMinutesLater.getHours();  // Current hour 
                    sixtyMinutesLater.setMinutes(sixtyMinutesLater.getMinutes() + 60);    // Current + one hour 
                    

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


                   if(minutes < 0 && seconds < 0 && current_d === conv_d && curr_min >= hr){
                    $('.conversation_start'+invite_id).html('<div class="callbtnactive"><input type="hidden" value="'+username+'" id="start_session"><a class="startVideo" href="'+base_url+'user/incoming_video_call/'+username+'/'+channel+'/'+mentor_id+'" >Start Conversation</a></div>');

                }
            },1000);





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
              var currentMinutes = new Date($(this).find('.invite_date_real').val());
              var curr_min = currentMinutes.getHours();



              var y = setInterval(function() {
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


                    // console.log((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
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

            },1000);





              var _time = (countDownDate_init.getHours() > 12) ? (_h-12 + ':' + _t +' PM') : (_h + ':' + _t +' AM');
              var currentMinutes = new Date($(this).find('.invite_to_end_time').val());
              var curr_min = currentMinutes.getHours();


              

              var z = setInterval(function() {
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
                    


                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);


                    // console.log((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    if (hours.toString().length === 1) {
                        hours = "0" + hours;
                    }

                    if (minutes.toString().length === 1) {
                        minutes = "0" + minutes;
                    }
                    if (seconds.toString().length === 1) {
                        seconds = "0" + seconds;
                    }



                    




                     // console.log(minutes+''+seconds);

                     // if(minutes<=-45 &&  minutes>=-49){
                     //     var balance = minutes - parseInt(-65);                     
                     //    $('.new_call').html('Your current call will end in '+balance+' minutes! &nbsp;');


                     //   }

                     //     if(minutes<=-50 &&  minutes>=-54){
                     //       var balance = minutes - parseInt(-65);                     
                     //    $('.new_call').html('Your current call will end in '+balance+' minutes! &nbsp;');

                     //   }

                     //   if(minutes<=-55 &&  minutes>=-59){
                     //       var balance = minutes - parseInt(-65);                     
                     //    $('.new_call').html('Your current call will end in '+balance+' minutes! &nbsp;');

                     //    // clearInterval(z);
                     //   }

                //      if(minutes < 0 && seconds < 0 && current_d === conv_d && curr_min === hr){

                //         //console.log(minutes);                   
                //             $.notify({                                                
                //             message: 'Your current call will end in 15 minutes!'
                //             },{                    
                //             type: 'success'
                //             }); 
                //             clearInterval(z);
                // }



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

function getSchedule(id)
{
    // console.log(id);
    if(id!=''){
        if(id == 1){
          var selected_date =  $('#pre_date').val();
      }else if(id == 2){
        var selected_date =  $('#next_date').val();
    }
}else{
    var selected_date = $('#choosedate').val();   
    if(selected_date == ''){
        $('#schedule_date_error').html('<small class="help-block" data-bv-validator="notEmpty" data-bv-for="schedule_date" data-bv-result="INVALID" style="color:red;">Date is required</small>');
        return false;
    }  

}

$('#schedule_date_error').html('');

var mentor_id = $('#mentor_id').val();




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

function delete_conversation()
{
    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
      if (result.value) {
        swal(
          'Deleted!',
          'Your file has been deleted.',
          'success'
          );
        $('.chats').html('<img src="'+base_url+'assets/images/loading.gif" class="loading">');
        var sender_id = $('#receiver_id').val();
        $.post(base_url+'user/delete_conversation',{sender_id:sender_id},function(response){
         if(response == 1)
         {
             $('.chats').html('');
         }
     });
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