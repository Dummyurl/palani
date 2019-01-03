



$(document).ready(function() {

    var maxLength = 500;
              $('#mentor_personal_message').keyup(function() {
                var length = $(this).val().length;
                var length = maxLength-length;
                $('#chars').text(length);
              });


              

 $('#mentor_profile_form').submit(function(){
    var session_app_id = $('#session_app_id').val();
    $('.bio-alert').html('');
        var bio = $('#mentor_personal_message').val();
        if(bio.length < 40){
        $('.bio-alert').html('<strong>Biography must have minimum 40 characters!</strong>');
        $('#mentor_personal_message').focus();
        return false;
        }


     $.ajax({
        url : base_url+'guru/update_profile',
        type: "POST",
        data: $('#mentor_profile_form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status == true) //if success close modal and reload ajax table
            {
                // setInterval(function(){ window.location = base_url+'user/edit_profile'; }, 1000);
                setInterval(function(){ window.location = base_url+'user/profile/'+session_app_id; }, 1000);
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');

        }
    });

     //set input/textarea/select event when change value, remove class error and remove text help block
     $("input").keyup(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
     $("textarea").keyup(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
     
     $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable

            return false;
        });





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
                message: 'Enter first name'
            },
            regexp: {
                regexp: /^[a-z\s]+$/i,
                message: 'The first name can consist of alphabetical characters and spaces only'
            }
        }
    },
    last_name: {                
        validators: {
            notEmpty: {
                message: 'Enter Last Name '
            },
            regexp: {
                regexp: /^[a-z\s]+$/i,
                message: 'The first name can consist of alphabetical characters and spaces only'
            }
        }
    },    
    email: {
        validators: {    
           notEmpty: {
            message: 'Enter valid email address'
        },                
        regexp: {
          regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
          message: 'Enter valid email address'
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
              message: 'Enter valid email address'
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




$('#applicant_profile_form').submit(function(){    
 $.ajax({
    url : base_url+'applicant/update_profile',
    type: "POST",
    data: $('#applicant_profile_form').serialize(),
    dataType: "JSON",
    success: function(data)
    {

            if(data.status == true) //if success close modal and reload ajax table
            {
                setInterval(function(){ window.location = base_url+'dashboard?notify=true'; }, 1000);
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }   

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            
        }
    });

      //set input/textarea/select event when change value, remove class error and remove text help block 
      $("input").keyup(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
      $("textarea").keyup(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
      $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

      
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

            return false;
        });



// var check_username_path = base_url+"user/check_username";                              
// $('#applicant_profile_form')
//             // Revalidate the color when it is changed
//             .change(function(e) {
//                 $('#applicant_profile_form').bootstrapValidator('revalidateField', 'country');
//             })
//             .end()
//             .bootstrapValidator({
//                 excluded: ':disabled',
//                 feedbackIcons: {               
//                     invalid: 'glyphicon glyphicon-remove',
//                     validating: 'glyphicon glyphicon-refresh'
//                 },            
//                 fields: {                
//                     applicant_first_name: {
//                         validators: {                    
//                             notEmpty: {
//                                 message: 'The First Name is required'
//                             }
//                         }
//                     },         
//                     username: {
//                         validators: {                    
//                             notEmpty: {
//                                 message: 'The User Name is required'
//                             },
//                             remote: {
//                                 message: 'The Username is not available',
//                                 url: check_username_path
//                             }
//                         }
//                     },         
//                     applicant_last_name: {
//                         validators: {                    
//                             notEmpty: {
//                                 message: 'The Last Name is required'
//                             }
//                         }
//                     },
//                     applicant_phone: {
//                         validators: {                    
//                             notEmpty: {
//                                 message: 'The Phone Number is required'
//                             },
//                             numeric: {
//                                 message:'Please enter numeric value'
//                             }
//                         }
//                     },
//                     country: {
//                         validators: {                    
//                             notEmpty: {
//                                 message: 'Select country'
//                             }
//                         }
//                     }, state: {
//                         validators: {                    
//                             notEmpty: {
//                                 message: 'Select state'
//                             }
//                         }
//                     }, city: {
//                         validators: {                    
//                             notEmpty: {
//                                 message: 'Select city'
//                             }
//                         }
//                     },

//                 }
//             }) .on('success.form.bv', function(e) {
//                                         // Prevent form submission                                        
//                                         e.preventDefault();
//                                         var url = base_url+"user/update_profile";
//                                         var formData = $('#applicant_profile_form').serialize(); 
//                                         $.ajax({
//                                             type:'POST',
//                                             url:url,
//                                             data:formData,
//                                             success:function(response)
//                                             {                                                 
//                                                 if(response==0)
//                                                 {   

//                                                     $("#profile_update_error").html("");
//                                                     $("#profile_update_error").css("display","none");
//                                                 /*  $('#applicant_forgot_password_success').html('Password has been sent to mail Id');
//                                                     $('#applicant_forgot_password_success').css('display','block');
//                                                     $('#applicant_forgot_password_error').css('display','none'); */
//                                                     setTimeout(function(){ window.location = base_url+'dashboard'; }, 1000);
//                                                 }
//                                                 else if(response==1)
//                                                 {

//                                                     $("#profile_update_error").html(' Error While Updating '); 
//                                                     $("#profile_update_error").css("display","block");
//                                                     $("#profile_update_error").fadeTo(2000, 500).slideUp(500, function(){
//                                                         $("#profile_update_error").slideUp(500);
//                                                     });
//                                                     setInterval(function(){ location.reload(); }, 1000);
//                                                     /* $('#applicant_forgot_password_error').html('Error While Updating Password !');
//                                                     $('#applicant_forgot_password_success').css('display','none');
//                                                     $('#applicant_forgot_password_error').css('display','block');                                                     */
//                                                 }                                                    


//                                             }
//                                         })

//                                     });




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
      var order_by = $('.ordering').val();
      var keyword = $('#right_top_search').val();


      $.ajax({
          url:  base_url +'user/loadmore_guru',
          type: 'POST',
          data: {
              page:$(this).data('page'),
              mentor_gender:$('#mentor_gender_hidden').val(),
              order_by:order_by,
              keyword:keyword
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

        var gender = $('#gender').val();     
        var subject = $('#subject').val();     
        var course = $('#course').val();     
        var order_by = $('.ordering').val();


        $(this).text('Loading...');
						  //console.log('loadmore');
                        var ele = $(this).parent('div');
                        $.ajax({
                          url:  base_url +'user/loadmore_search_guru_home',
                          type: 'POST',
                          data: {
                              keyword:$('#old_keyword').val(),
                              page:$(this).data('page'),
                              gender:gender,                               
                              subject_id:subject,                               
                              course_id:course,                               
                              order_by:order_by,                               
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












//     $(document).on('keyup','.right_top_search',function(){

//        var gender = $('#right_top_search').val();
//        var subject = $('#subject').val();
//        var school_offer = $('#right_top_search').val();
//        var school_year = $('#right_top_search').val();
//        var school_year = $('#right_top_search').val();
//        var order_by = $('.ordering').val();
//        var keyword = $('#right_top_search').val(); 
//        $('#search-error').html('');

//        $.ajax({
//          url:  base_url +'user/search_right',
//          type: 'POST',
//          data: {keyword:keyword},
//          beforeSend:function(){
//             $('.overlay').css("display","block");
//         },
//         success: function(response){
//             $('.overlay').css("display","none");
//     // console.log(response);

//     if(response == 0){
//      $(".widget-title").html('0 Matches for your search');
//      $("#guru-list").html('<p>Mentors not found</p>');
//  }else{
//      $("#right-search-content").html(response);
//  }
// }
// });
//    });












// $(document).on('click','.search-left',function(){

//  var gender = $('#gender').val();     
//  var subject = $('#subject').val();     
//  var course = $('#course').val();     
//  var order_by = $('.ordering').val();

//  if(gender == '' && subject == '' && course == '')
//  {
//   $('#search-error').html('Please select atleast one.');
//   return false;
// }
// $('#search-error').html('');
// $.ajax({
//    url:  base_url +'user/search_left',
//    type: 'POST',
//    data: { gender:gender,order_by:order_by,subject_id:subject,course_id:course},
//    beforeSend:function(){
//     $('.overlay').css("display","block");
// },
// success: function(response){
//     $('.overlay').css("display","none");
//     if(response == 0){
//        $(".widget-title").html('0 Matches for your search');
//        $("#guru-list").html('<p>Mentors not found</p>');
//    }else{
//        $("#right-search-content").html(response);
//    }
// }
// });
// });

$('#subject').change(function(){

  $.ajax({
      type: "POST",
      data:{'subject_id':$(this).val()},
      url: base_url+"user/get_course_by_subject",         
      beforeSend :function(){
       $("#course option:gt(0)").remove(); 
       $('#course').find("option:eq(0)").html("Please wait..");
   },                         
   success: function (data) {          
    $('#course').find("option:eq(0)").html("Select course");
    var obj=jQuery.parseJSON(data);
    $(obj).each(function(){
      var option = $('<option />');
      option.attr('value', this.course_id).text(this.course);           
      $('#course').append(option);
  });
}
});

});





// $(document).on('change','.ordering',function(){

//  var gender = $('#gender').val();     
//  var order_by = $('.ordering').val();
//  $('#search-error').html('');
//  $.ajax({
//    url:  base_url +'user/search_left',
//    type: 'POST',
//    data: { gender:gender,order_by:order_by },
//    beforeSend:function(){
//     $('.overlay').css("display","block");
// },
// success: function(response){
//     $('.overlay').css("display","none");
//     if(response == 0){
//        $(".widget-title").html('0 Matches for your search');
//        $("#guru-list").html('<p>Mentors not found</p>');
//    }else{
//        $("#right-search-content").html(response);
//    }
// }
// });
// });








$('.chatclick').on('click',function(){


                  var selected_user_id = $(this).attr('data-chat-id');  // Id 
                  var selected_name = $(this).attr('data-name');  // First & Last name 
                  var selected_user_name = $(this).attr('data-username'); // username          
                    var status = $(this).attr('data-status'); // status              
                    var total_msg = $(this).attr('data-total'); // status              

                    $('#user_selected_id').val(selected_user_id); 


                    $('#'+selected_user_name).text('');
                    $(".chatclick").removeClass("selected");
                    $(this).addClass('selected');
                    $('.openchat').html('<a href="#">'+selected_name+'<span class="status '+status+'"></span></a>');
                    $('#recipients').val(selected_user_name);
                    $('#to_user_id').val(selected_user_id);                  
                    $('#total_msg').val(total_msg);                  
                    $('#chat_box').removeClass('hidden');
                    $('.chats').html('<img src="'+base_url+'assets/images/loading.gif" class="loading">');


                    $.post(base_url+'user/get_messages',{selected_user_id:selected_user_id},function(response){                                    
                        $('.chats').html(response); 
                       // $('#hidden_id').focus().addClass('hidden'); 
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
    $('.no_message').html('');
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
        $('.no_message').html('');
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

    function message()
    {


     var msg = $.trim($('#input_message').val());
     var to_username = $('#recipients').val();

     // var sender_id = $('#sender_id').val();
     // var sessionObj = JSON.parse(localStorage[sessionName] || '{}');
     //    // Get the messageClient
     //    var messageClient = sinchClient.getMessageClient(); 
     //    // Create a new Message
     //    var message = messageClient.newMessage(to_username, msg);
     //    // Alt 1: Send it with success and fail handler
     //    messageClient.send(message);

     $.post(base_url+'chat/insert_chat',{to_username:to_username,input_message:msg},function(response){
     });





 }


   // var messageClient = sinchClient.getMessageClient();
   /* var myListenerObj = {
        onMessageDelivered: function(messageDeliveryInfo) {
          // console.log(messageDeliveryInfo);
        // Handle message delivery notification
    },
    onIncomingMessage: function(message) {


        $('.no_message').html('');

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

 if(h_url != 'messages' && h_urls !='incoming_video_call' && h_urls !='conversations' && h_urls !='conversations#'){               
     $.post(base_url+'user/get_user_name',{username:message.senderId},function(res){
        $.notify({ message: res+'<br><br>'+message.textBody},{type: 'success'});      
        $('#message_ring')[0].play();  
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
                $('#chat_id').val(obj.data.id);
                $('#user_selected_id').val(obj.data.sent_id);

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
                   '<p>'+obj.data.file_name+'</p>'+                
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
                   '<p>'+obj.data.file_name+'</p>'+
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
};*/
//messageClient.addEventListener(myListenerObj);





$(document).on('click','.chatclick_search',function(){
                  var selected_user_id = $(this).attr('data-chat-id');  // Id 
                  var selected_name = $(this).attr('data-name');  // First & Last name 
                  var selected_user_name = $(this).attr('data-username'); // username        
                    var status = $(this).attr('data-status'); // status  

                    $('#user_selected_id').val(selected_user_id);                               

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
                        //$('#hidden_id').focus().addClass('hidden');  
                        $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
                        $(".slimscrollleft.chats").mCustomScrollbar("update");                        

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
                                        // $('#notify_ring')[0].play(); 
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
                                    $('.topnotification').addClass('animate');
                                    $.get(base_url+'user/notify_applicants_viewed', function(response) {
                                     $(".redcircle").css('display','none');
                                     $('.topnotification').addClass('animate');
                                 });
                                    $('.topnotification').removeClass('animate');
                                    
                                });



                                 function append_new_message(message){
                                     $('.no_message').html('');
                                     var message = jQuery.parseJSON(message);
                                     $(message).each(function(){
                                        // console.log(this.message);
                                        // return false;

                                        if(this.message == 'file' && this.type == 'image'){


                                           var content ='<div class="chat chat-left">'+
                                           '<div class="chat-avatar">'+
                                           '<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="">'+
                                           '<img alt="" src="'+this.image+'" class="img-responsive img-circle">'+
                                           '</a>'+
                                           '</div>'+
                                           '<div class="chat-body">'+
                                           '<div class="chat-content">'+
                                           '<p><img alt="" src="'+this.file_path+'/'+this.file_name+'" class="img-responsive"></p>'+ 
                                           '<p>'+this.file_name+'</p>'+                
                                           '<a href="'+this.file_path+'/'+this.file_name+'" target="_blank" download>Download</a>'+
                                           '<span class="chat-time">'+this.time+'</span>'+
                                           '</div>'+
                                           '</div>'+
                                           '</div>';
                                           $('#ajax').append(content); 

                                           $(".slimscrollleft.chats").mCustomScrollbar("update");
                                           $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");                    
                                       }else if(this.message == 'file' && this.type == 'others'){

                                           var content ='<div class="chat chat-left">'+
                                           '<div class="chat-avatar">'+
                                           '<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="">'+
                                           '<img alt="" src="'+this.image+'" class="img-responsive img-circle">'+
                                           '</a>'+
                                           '</div>'+
                                           '<div class="chat-body">'+
                                           '<div class="chat-content">'+
                                           '<p><img alt="" src="'+base_url+'assets/images/download.png" class="img-responsive"></p>'+
                                           '<p>'+this.file_name+'</p>'+
                                           '<a href="'+this.file_name+'" target="_blank" download>Download</a>'+
                                           '<span class="chat-time">'+this.time+'</span>'+
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
                                        '<img alt="" src="'+this.image+'" class="img-responsive img-circle">'+
                                        '</a>'+
                                        '</div>'+
                                        '<div class="chat-body">'+
                                        '<div class="chat-content">'+
                                        '<p>'+this.message+'</p>'+
                                        '<span class="chat-time">'+this.time+'</span>'+
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
                                });

}


            // Check call to join every 5 seconds 
            setInterval(function(){
                var user_selected_id = $('#user_selected_id').val();
                $.post(base_url+'user/get_call',{user_selected_id:user_selected_id},function(response) {

                    var json = jQuery.parseJSON(response);

                    if(json.message){
                        append_new_message(json.message);
                    }

                    if(json.other_message){
                      var message_count = jQuery.parseJSON(json.other_message);                        
                      $(message_count).each(function(){
                        $('#'+this.username).text(this.count);
                    });
                  }



                // return false;

                if(json.status == true){
                    $('.new_call').html(json.html);                
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

                if($(this).parent('div').hasClass( "tmgselected")){
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


               var date = $(this).attr('data-date');
               var start_time = date+' '+$(this).attr('data-start-time');
               var end_time = date+' '+$(this).attr('data-end-time');

               console.log(start_time+' '+end_time);
           });




            $('.tmgconfirmation a').addClass('disabled');

            $(document).on('click','.tmgconfirmation a',function(){
                $('.tmgconfirmation a').addClass('disabled');
                var selected_count = $('.tmgselected').length;
                var mentor_id = $('#mentor_id').val();
                var hourly_rate = $('#hourly_rate').val();
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
                $('.overlay').show();
                $.post(base_url+'user/set_booked_session',{hourly_rate:hourly_rate,session_data:jsonOb,charge_type:$('#charge_type').val()},function(session_response){
                   $('.overlay').hide();
                   if(session_response == 1)
                   {
                    setTimeout(function(){ window.location=base_url+'user/pay/'+mentor_id ; },1000);
                }else{

                    swal({ 

                      title: "Success!",      
                      type: "success" ,
                      icon: 'success',
                      showConfirmButton:false,
                      html:'<p>Appoinment request sent successfully! <br>Now you can chat with our Mentor.</p><p><a href="'+base_url+'messages" class="btn btn-primary">Go to Messages</a></p>',
                  });
                    setTimeout(function() {
                        window.location.href=base_url+"messages";
                    }, 3000);



                }
            });

            });


            $.get(base_url+'user/conversation_ajax_request',function(res){
                $('.conversation').html(res);
                var i = 0;
                $('.callbox').each(function(){
                    i++;


                    var mentor_id = $('#mentor_user_id'+i).val();
                    var mentor_image = $('#mentor_image'+i).val();
                    var mentor_name = $('#mentor_name'+i).val();
                    var logged_in = $('#logged_in'+i).val();
                    if(logged_in == 0){
                        var log_class='away';
                    }else{
                        var log_class='online';
                    }




                    var mentor_username = $('#mentor_username'+i).val();

                        var username = $(this).find('#callUserName').val(); // encoded to username                         
                        var channel = $(this).find('#channel').val(); // channel name 
                        var applicant_id = $(this).find('#mentor_id').val(); // to user id 
                        var encoded_invite_id = $(this).find('#encoded_invite_id').val();  // encoded invite_id                    
                        var countDownDate_init = new Date($(this).find('.invite_date').val());  // From time  - 15 minutes time                         
                        var invite_id = $(this).find('.invite_id').val(); // Invite id 
                        var countDownDate = countDownDate_init.getTime();  // Getting  only time 




                        if(countDownDate_init.getMinutes().toString().length === 1){ // check length of minutes 
                        var _t = '0' + countDownDate_init.getMinutes(); // add zero before minutes 
                    }else{
                        var _t = countDownDate_init.getMinutes();  // two digit minutes 
                    }
                        if(countDownDate_init.getHours().toString().length === 1){ // Checking length of hours 
                        var _h = '0' + countDownDate_init.getHours(); // add zero before hour
                    }else{
                        var _h = countDownDate_init.getHours(); // Two digit hour
                    }

                        var _time = (countDownDate_init.getHours() > 12) ? (_h-12 + ':' + _t +' PM') : (_h + ':' + _t +' AM'); // AM or PM 
                        var currentMinutes = new Date($(this).find('.invite_date').val());  //   From time  - 15 minutes time                            
                        var curr_min = currentMinutes.getHours();                        
                        currentMinutes.setMinutes(currentMinutes.getMinutes() + 60); // + 1 Hour from Invire from time 

                        var sixtyMinutesLater = new Date(); // Current Date time
                        var hr = sixtyMinutesLater.getHours(); // Current Hour                         
                        sixtyMinutesLater.setMinutes(sixtyMinutesLater.getMinutes() + 60); // Current time + 1 hour 

                        
                        var x = setInterval(function() {
                        // Get todays date and time
                        var now = new Date().getTime(); // getting current time 
                        var now_date = new Date(); // current date time
                        var current_date= now_date.getDate(); // current month
                        var current_m = now_date.getMonth() + 1; // current month

                        var conv_m = countDownDate_init.getMonth() + 1;  // Getting Month from invite date 

                        var current_d = now_date.getFullYear() + '-' + current_m + '-' + now_date.getDate();  // Year + month + Date ( CURRENT )
                        var conv_d = countDownDate_init.getFullYear() + '-' + conv_m + '-' + countDownDate_init.getDate(); // Year + month + Date (From Invite Date  )                   
                        var conv_date = countDownDate_init.getDate(); // Year + month + Date (From Invite Date  )                   
                        var distance = countDownDate - now; // Subtracting time (Invite time  - Current time)                                          
                       var days = Math.floor(distance / (1000 * 60 * 60 * 24)); // Remaining days 
                       var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)); // Remaining hours 
                       var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)); // Remaining minutes 
                       var seconds = Math.floor((distance % (1000 * 60)) / 1000);  // Remaining seconds

                       if (hours.toString().length === 1) {
                        hours = "0" + hours;
                    }
                    if (minutes.toString().length === 1) {
                        minutes = "0" + minutes;
                    }
                    if (seconds.toString().length === 1) {
                        seconds = "0" + seconds;
                    }



                    if(days>0){ // More than Today 
                        if(days == 1){ // One day 
                            // $('.conversation_start'+invite_id).html('<div class="callbtn">Remaining time for the call - <strong id="demo">'+days+' Day</strong></div>');    
                            
                            $('.conversation_start'+invite_id).html('<ul>'+
                                '<li><i aria-hidden="true" class="fa fa-video-camera"></i></li>'+
                                '<li><i aria-hidden="true" class="fa fa-phone"></i></li>'+
                                '<li><a href="#" class="conv_messages"  data-chat-id="'+mentor_id+'" data-username="'+mentor_username+'" data-name="'+mentor_name+'" data-image="'+mentor_image+'" data-status="'+log_class+'"><i aria-hidden="true" class="fa fa-comments-o"></i></a></li>'+
                                '</ul>'+
                                '<div class="remainingtime">Remaining time for the call - <strong id="demo">'+days+' Day</div>');

                        }else{ //More than One day 

                            // $('.conversation_start'+invite_id).html('<div class="callbtn">Remaining time for the call - <strong id="demo">'+days+' Days</strong></div>');

                            $('.conversation_start'+invite_id).html('<ul>'+
                                '<li><i aria-hidden="true" class="fa fa-video-camera"></i></li>'+
                                '<li><i aria-hidden="true" class="fa fa-phone"></i></li>'+
                                '<li><a href="#" class="conv_messages"  data-chat-id="'+mentor_id+'" data-username="'+mentor_username+'" data-name="'+mentor_name+'" data-image="'+mentor_image+'" data-status="'+log_class+'"><i aria-hidden="true" class="fa fa-comments-o"></i></a></li>'+
                                '</ul>'+
                                '<div class="remainingtime">Remaining time for the call - <strong id="demo">'+days+' Days</div>');
                        }                    

                    }
                    else if(days < 1 && hours > 0 || minutes > 0 || seconds > 0 ){ // Only Today 
                       // $('.conversation_start'+invite_id).html('<div class="callbtn">Remaining time for conversation - <strong id="demo"></strong></div>');
                       


                       $('.conversation_start'+invite_id).html('<ul>'+
                        '<li><i aria-hidden="true" class="fa fa-video-camera"></i></li>'+
                        '<li><i aria-hidden="true" class="fa fa-phone"></i></li>'+
                        '<li><a href="#" class="conv_messages"  data-chat-id="'+mentor_id+'" data-username="'+mentor_username+'" data-name="'+mentor_name+'" data-image="'+mentor_image+'" data-status="'+log_class+'"><i aria-hidden="true" class="fa fa-comments-o"></i></a></li>'+
                        '</ul>'+
                        '<div class="remainingtime">Remaining time for the call - <strong id="demo"></div>');
                       $('.conversation_start'+invite_id).find("#demo").html(hours + ":" + minutes + ":" + seconds); 

                   }
                   else{

                     $('.conversation_start'+invite_id).html('<ul>'+
                        '<li><a href="'+base_url+'user/incoming_video_call/'+username+'/'+channel+'/'+applicant_id+'/'+encoded_invite_id+'" class="conv_videocall startVideo" userid="'+mentor_id+'"><i aria-hidden="true" class="fa fa-video-camera"></i></a></li>'+                      
                        '<li><a href="'+base_url+'user/incoming_audio_call/'+username+'/'+channel+'/'+applicant_id+'/'+encoded_invite_id+'" class="conv_audiocall startAudio" userid="'+mentor_id+'"><i aria-hidden="true" class="fa fa-phone"></i></a></li>'+
                        '<li><a href="#" class="conv_messages"  data-chat-id="'+mentor_id+'" data-username="'+mentor_username+'" data-name="'+mentor_name+'" data-image="'+mentor_image+'" data-status="'+log_class+'"><i aria-hidden="true" class="fa fa-comments-o"></i></a></li>'+
                        '</ul>'+
                        '<div class="remainingtime"><strong id="demo">Start the conversation</div>');

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





var invite_id = $(this).find('.invite_id').val();

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
                    if (hours.toString().length === 1) {
                        hours = "0" + hours;
                    }
                    if (minutes.toString().length === 1) {
                        minutes = "0" + minutes;
                    }
                    if (seconds.toString().length === 1) {
                        seconds = "0" + seconds;
                    }
                    
                    

                    if (distance < 0) {                          

                    // console.log(countDownDate_init.getMonth());                    
                        // if( (minutes < 0 && seconds < 0 && current_d === conv_d && curr_min < hr ) || (current_d > conv_d))  {
                            if( (minutes < 0 && seconds < 0 && current_d === conv_d && curr_min < hr ) || (now_date.getDate() > countDownDate_init.getDate()) || current_m > conv_m){

                                $.post(base_url+'user/update_expire_status',{invite_id:invite_id},function(res){
                                    window.location.reload();
                                });
                                $('.conversation_start'+invite_id).html('<div class="callbtn hidden"><strong id="demo"></strong></div>');
                                $('.conversation_start'+invite_id).find("#demo").html(_time+" -EXPIRED");
                            }
                        }
                        
                    },1000);






});




});




$(document).on('click','a.conv_messages',function(){



    $('.clickable').click(function(){
        $('.conv_messages_box').hide();
    });

    $(".conv_messages_box").animate({
        width: "toggle" 
    });   

    
        var selected_user_id = $(this).attr('data-chat-id');  // Id  
        var selected_name = $(this).attr('data-name');  // First & Last name 
        var selected_user_name = $(this).attr('data-username'); // username          
        var status = $(this).attr('data-status'); // status    

        $('#user_selected_id').val(selected_user_id);

        // var old_id = $('#to_user_id').val();                  
        // if(old_id==selected_user_id || old_id == 0){
        //     $(".conv_messages_box").animate({
        //         width: "toggle" 
        //         });        
        // }


        $('#'+selected_user_name).text('');
        $(".chatclick").removeClass("selected");
        $(this).addClass('selected');
        $('.openchat').html('<a href="#">'+selected_name+'<span class="status '+status+'"></span></a>');
        $('#recipients').val(selected_user_name);
        $('#to_user_id').val(selected_user_id);                  
                    // $('#total_msg').val(total_msg);                  
                    $('#chat_box').removeClass('hidden');
                    $('.chats').html('<img src="'+base_url+'assets/images/loading.gif" class="loading">');


                    $.post(base_url+'user/get_messages',{selected_user_id:selected_user_id},function(response){                                    
                        $('.chats').html(response); 

                     //   $('#hidden_id').focus().addClass('hidden'); 
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




$(document).on('click', '.star', function() {
    $(this).find($(".fa")).css('color','#ffc513');

    var rating = $(this).data('seq');
               // fillStars($(this).parent(), rating, 1 );
               fillStars(rating);
               $('input[name="rating"]').val(rating);
           });

$(document).on('click','#send_rating',function(){
   var rating_value = $('#rating_value').val();
   var mentor_id = $('#mentor_id').val();
   var rating_comment = $('#rating_comment').val();
   var invite_id = $('#invite_id').val();

   $.post(base_url+'user/save_rating',{
    rating_value:rating_value,
    invite_id:invite_id,
    mentor_id:mentor_id,
    rating_comment:rating_comment
},function(result){
    if(result == 1){
        $('#rating_modal').modal('hide');
        $('#li'+invite_id).remove();
    }
});
   $('#rating_modal').modal('hide');
});
});



function search_mentors(){

   // console.log('test');

   var gender = $('#gender').val();     
   var subject_id = $('#subject').val();     
   var course_id = $('#course').val();     
   var order_by = $('.ordering').val();
   var name = $('#right_top_search').val();
   var page_no = 1;

   // console.log(base_url);


   $.ajax({
     url:  base_url +'user/common_search',
     type: 'POST',
     data: { gender:gender,order_by:order_by,subject_id:subject_id,course_id:course_id,page_no:page_no},
     beforeSend:function(){
        $('.overlay').css("display","block");
    },
    success:function(res){
        if(res){
            var obj =jQuery.parseJSON(res);
            $('.overlay').css("display","none");                
            if(obj.mentor_list.length == 0){
                $(".widget-title").html('0 Matches for your search');
                $("#guru-list").html('<p>Mentors not found</p>');

            }else{
                var html ='';
                $(obj.mentor_list).each(function(){
                    html +='<a href="'+base_url+'mentor-profile/'+this.username+'" class="guru-list">'+
                    '<div class="row">'+
                    '<div class="col-sm-4 col-md-3 col-xs-12">'+
                    '<div class="guru-details text-center">'+                                    
                    '<div class="guru-img"><img src="'+this.profile_img+'" height="100" width="100"  class="img-circle"></div>'+
                    '<div class="guru-name">'+this.full_name+'</div>'
                    '<div class="guru-country">'+this.country+'</div>';



                    if(this.is_free!= true){ 

                        html +='<div class="price">'+
                        '<span class="currency">$</span>'+
                        '<span class="amount">'+hourly_rate+'</span>/hour'+
                        '</div>';

                    }else if(this.is_free == true){ 
                        html +='<div class="price">'+
                        '<button class="btn btn-primary btn-xs">Free</button>'+
                        '</div>';
                    }else{
                        html +='<div class="price"></div>';
                    }  

                    html +='</div>'+
                    '</div>'+
                    '<div class="col-sm-8 col-md-9 col-xs-12">'+
                    '<div class="guru-det">'+
                    '<h4 class="guru-title">'+this.personal_message+'</h4>'+
                    '<div class="subject">Courses : '+this.course+
                    '</div>'+
                    '<div class="ratings">';
                    for(var i=1; i<=5 ;i++) {
                       if(i <= this.rating_value){                                        
                        html +='<i class="fa fa-star" style="color:#ffc513 !important;"></i>';
                    }else{ 
                        html +='<i class="fa fa-star"></i>';
                    } 
                } 
                html +='<span class="rating-count">'+this.rating_value+'</span>'+
                '<span class="total-rating">('+this.rating_count+')</span>'+
                '</div>'+                            
                '<span class="read-more">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></span>'+
                '</div>'+ 
                '</div>'+
                '</div>'+
                '</a>';

            });
                $('#guru-list').html(html);
            }
        }else{
            $(".widget-title").html('0 Matches for your search');
            $("#guru-list").html('<p>Mentors not found</p>');
        }           
    }
});

}




function getSchedule(id)
{

    $('.tmgconfirmation strong').html('0'+' hour');
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
               $('.chats').html('<div class="no_message">No Record Found</div><div id="ajax"></div><input type="hidden"  id="hidden_id">');
           }
       });
    }
});

}

function delete_conversation1()
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
        var sender_id = $('#to_user_id').val();
        $.post(base_url+'user/delete_conversation',{sender_id:sender_id},function(response){
           if(response == 1)
           {
               $('.chats').html('<div class="no_message">No Record Found</div><div id="ajax"></div><input type="hidden"  id="hidden_id">');
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




// var callClient = sinchClient.getCallClient();
// var call;

// callClient.addEventListener({
//   onIncomingCall: function(incomingCall) {
//     console.log(incomingCall);
// }
// });



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