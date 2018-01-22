$(document).ready(function() {




    $('#search_by_subject1').submit(function(){
     var keyword =  $('#subject_keyword').val();       
     if(keyword==''){        
      $('.subject_error').html('<font style="color:red;">Please Enter Subject</font>');
      setTimeout(function() {
       $('.help-block').html('');
   }, 3000);
      return false;
  }


}); $('#search_by_university1').submit(function(){
 var keyword =  $('#keyword').val();       
 if(keyword==''){        
  $('.university_error').html('<font style="color:red;">Please Enter University</font>');
  setTimeout(function() {
   $('.help-block').html('');
}, 3000);
  return false;
}


});

$('#subject_keyword,#keyword').blur(function(){

    setTimeout(function() {
       $('.keyword_result').html('');
       $('.keyword_result').css('display','none');
   }, 100);
    
});

$( "#subject_keyword" ).keyup(function(){   
    var  keyword =  $.trim($(this).val());  
    if(keyword!=''){
        $.ajax({
            type: "POST",
            url: base_url+'welcome/search_by_subject',
            data: 'keyword='+keyword,                                
            success: function(data)
            {
                                    // console.log(data);
                                    if(data){
                                        var obj = jQuery.parseJSON(data);
                                        var names = ''
                                        $(obj.gurus).each(function(){
                                            names +='<a href="'+base_url+'search-guru/'+keyword+'">'+this.mentor_personal_message+'</a>';
                                        });
                                        $('.keyword_result').css('display','block');
                                        $('.keyword_result').html(names);

                                    }else{
                                        $('.keyword_result').html('');
                                        $('.keyword_result').css('display','none');
                                    }
                                    
                                }
                            });
    }else{
       $('.keyword_result').html('');
       $('.keyword_result').css('display','none');
   }   
});


$( "#keyword" ).keyup(function(){   
    var  keyword =  $.trim($(this).val());  
    if(keyword!=''){
        $.ajax({
            type: "POST",
            url: base_url+'welcome/search_by_university',
            data: 'keyword='+keyword,                                
            success: function(data)
            {
                                    // console.log(data);
                                    if(data){
                                        var obj = jQuery.parseJSON(data);
                                        var names = ''
                                        $(obj.gurus).each(function(){
                                            names +='<a href="'+base_url+'search-guru/'+keyword+'">'+this.mentor_school+'</a>';
                                        });
                                        $('.keyword_result').css('display','block');
                                        $('.keyword_result').html(names);

                                    }else{
                                        $('.keyword_result').html('');
                                        $('.keyword_result').css('display','none');
                                    }
                                    
                                }
                            });
    }else{
       $('.keyword_result').html('');
       $('.keyword_result').css('display','none');
   }   
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
    fields: {  

        first_name: {                 
            validators: {
                notEmpty: {
                    message: 'Enter first name'
                }
            }
        },
        last_name: {                
            validators: {
                notEmpty: {
                    message: 'Enter last name'
                }
            }
        },    
        
        email: {
            validators: {                    
                regexp: {
                  regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                  message: 'Enter valid email address'
              },
              remote: {
                message: 'Email already registered',
                url: check_email_path
            }
        }
    },
    password: {
        validators: {
            notEmpty: {
                message: 'The Password is required'
            },                    
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
                                                    window.location = base_url+'welcome/mobile_verify';
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
                                                if(response==0){   
                                                    $('#guru_login_error').html("");
                                                }
                                                else{
                                                    $('#guru_login_error').html(" Wrong Credentials !");                                                    
                                                }
                                            }
                                        });

                                    });


$('#mentor_profile_form').submit(function(){    
 $.ajax({
    url : base_url+'guru/update_profile',
    type: "POST",
    data: $('#mentor_profile_form').serialize(),
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
// $('#mentor_profile_form')
// .find('[name="country"]')
// .chosen()
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
//                     email: {
//                         validators: {                    
//                             regexp: {
//                               regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
//                               message: 'The value is not a valid email address'
//                           } 
//                       }
//                   },
//                   mentor_phone: {
//                     validators: {
//                         notEmpty: {
//                             message: 'The Phone Number is required'
//                         },
//                         numeric: {
//                             message:'Please enter numeric value'
//                         }
//                     }
//                 },
//                 username: {                
//                     validators: {
//                         notEmpty: {
//                             message: 'The username is required'
//                         },
//                         remote: {
//                             message: 'The Username is not available',
//                             url: check_username_path
//                         }
//                     }
//                 },    
//                 mentor_gender: {
//                     validators: {
//                         notEmpty: {
//                             message: 'The Gender is required'
//                         }
//                     }
//                 }
//                 ,
//                 mentor_school: {
//                     validators: {
//                         notEmpty: {
//                             message: 'The School is required'
//                         }
//                     }
//                 }  
//                 ,
//                 mentor_current_year: {
//                     validators: {
//                         notEmpty: {
//                             message: 'The Year is required'
//                         }
//                     }
//                 }
//                 ,
//                 mentor_schools_applied: {
//                     validators: {
//                         notEmpty: {
//                             message: 'The Schools Applied is required'
//                         }
//                     }
//                 },
//                 mentor_clubs: {
//                     validators: {
//                         notEmpty: {
//                             message: 'The Part of Clubs is required'
//                         }
//                     }
//                 }
//                 ,
//                 mentor_executive_positions: {
//                     validators: {
//                         notEmpty: {
//                             message: 'The Positions in clubs is required'
//                         }
//                     }
//                 },
//                 mentor_charge: {
//                     validators: {
//                         notEmpty: {
//                             message: 'The Mentor Charge is required'
//                         },
//                         numeric: {
//                             message:'Please enter numeric value'
//                         }
//                     }
//                 },  
//                 mentor_undergrad_school: {
//                     validators: {
//                         notEmpty: {
//                             message: 'The Undergrad School is required'
//                         }
//                     }
//                 },
//                 address_line1: {
//                     validators: {
//                         notEmpty: {
//                             message: 'The Address Line1 is required'
//                         }
//                     }
//                 },                                
//                 postal_code: {
//                     validators: {
//                         notEmpty: {
//                             message: 'The Postal Code is required'
//                         }
//                     }
//                 },
//                 country: {
//                     validators: {                    
//                         notEmpty: {
//                             message: 'Select country'
//                         }
//                     }
//                 }, state: {
//                     validators: {                    
//                         notEmpty: {
//                             message: 'Select state'
//                         }
//                     }
//                 }, city: {
//                     validators: {                    
//                         notEmpty: {
//                             message: 'Select city'
//                         }
//                     }
//                 }
//             }
//         }) .on('success.form.bv', function(e) {
//                                         // Prevent form submission                                        
//                                         e.preventDefault();
//                                         var url = base_url+"guru/update_profile";
//                                         var formData = $('#mentor_profile_form').serialize(); 

//                                         $.ajax({
//                                             type:'POST',
//                                             url:url,
//                                             data:formData,
//                                             success:function(response)
//                                             {                                                 
//                                                 if(response==0)
//                                                 {   
//                                                     $.post(base_url+'guru/update_profile_status',{formData:formData},function(res){
//                                                           //$('#verified').text('1');
//                                                           setInterval(function(){ window.location = base_url+'dashboard'; }, 1000);
//                                                       });
//                                                     $("#profile_update_error").html("");
//                                                     $("#profile_update_error").css("display","none");
//                                                 }
//                                                 else
//                                                 {
//                                                     $("#profile_update_error").html(' Error While Updating '); 
//                                                     //setTimeout(function(){ window.location = base_url+'dashboard'; }, 1000);
//                                                 }

//                                             }
//                                         })

//                                     });

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


                                                // if(response==0)
                                                // {
                                                //     $('#send_messages_form > .modal-body').html('<div style="color:#5c65be;">Please Wait....</div>');
                                                //     $('#send_messages_form > .modal-footer').html(''); 
                                                //     setInterval(function(){
                                                //         $('#send_messages_form > .modal-body').html('<div style="color:green;">Email was sent!</div>');
                                                //     },3000);
                                                //     setInterval(function(){
                                                //      location.reload(); 
                                                //  },7000);
                                                // }
                                                // else
                                                // {
                                                //     $('#send_message-form-error').html('<div style="color:#5c65be;">Error while submitting email....!</div>');
                                                //     $('#send_message-form-error').css('display','block');

                                                // }
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

    for(var i=0; i<=23; i++){
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
         // console.log(validate);
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

  for(var i=1; i<=23; i++){

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
//if(time!='00:00:00'){
    select_html += '<option value="24:00:00">12:00 am</option>';     
//}

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
        country_code: {                 
            validators: {                
                notEmpty: {
                    message: 'Select country code '
                }
            }
        },
        mobile_number: {                 
            validators: {
                stringLength: {
                    min: 10,
                    max: 15,
                    message: 'Mobile number should be more than 10 digit and maximum 15 digit'
                },
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

                                                if(response=='0')
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
                                        var url = base_url+"welcome/check_otp";
                                        var formData = $('#mobile_verify_code_form').serialize(); 
                                        $.ajax({
                                            type:'POST',
                                            url:url,
                                            data:formData,
                                            success:function(response)
                                            {
                                             //   console.log(response);
                                             if(response == '0'){
                                               $('#mobile_first_verify_code').css("display","none");
                                               $('#mobile_first_verify_success').css("display","block");
                                               setTimeout(function(){
                                                  window.location= base_url+'dashboard';
                                              },2000);
                                           }else{
                                               swal({
                                                  title: 'Oops!',
                                                  text: "Wrong OTP you entered!",
                                                  type: 'warning',
                                                  showCancelButton: true,
                                                  confirmButtonColor: '#3085d6',
                                                  cancelButtonColor: '#d33',
                                                  confirmButtonText: 'Send again OTP!',                                                  
                                                  confirmButtonClass: 'btn btn-success',
                                                  cancelButtonText: 'No will try again!',
                                                  cancelButtonClass: 'btn btn-danger',
                                                  buttonsStyling: false,
                                                  reverseButtons: true
                                              }).then((result) => {
                                                  if (result.value) {

                                                    swal(
                                                      'Success!',
                                                      'OTP sent to your mobile number.',
                                                      'success'
                                                      )
                                                    $('.verify').attr('disabled',false);
                                                    $.get(base_url+'welcome/send_again_otp',function(res){

                                                    });


                                                }else if(result.dismiss === 'cancel'){
                                                    $('.verify').attr('disabled',false);

                                                } 
                                            })
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



// function redirection()
// {
//     window.location.href = base_url+'dashboard';
// }

// $('#mobile_verify_form').submit(function(){

//     return false;
// });

    // Chat functios start here 

    $(document).on('click','.search-left',function(){

        var gender = $('#gender').val();
        var admitted_school = $('#admitted_school').val();
        var school_offer = $('#school_offer').val();
        var school_year = $('#school_year').val();
        var order_by = $('.ordering').val();
        if(gender == '' && admitted_school == '' && school_offer == '' && school_year == '')
        {
            $('#search-error').html('Please select atleast one.');
            return false;
        }
        $('#search-error').html('');      
        $.ajax({
          url:  base_url +'welcome/search_left',
          type: 'POST',
          data: { keyword:$('#old_keyword').val(),gender:gender,admitted_school:admitted_school,school_offer:school_offer,school_year:school_year,order_by:order_by },
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
   url:  base_url +'welcome/search_left',
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




    $('.chatclick').on('click',function(){
                  var selected_user_id = $(this).attr('data-chat-id');  // Id 
                  var selected_name = $(this).attr('data-name');  // First & Last name 
                  var selected_user_name = $(this).attr('data-username'); // username     
                  var status = $(this).attr('data-status'); // status                 


                  $('#'+selected_user_name).text('');
                  $(".chatclick").removeClass("selected");
                  $(this).addClass('selected');
                  $('.openchat').html('<a href="#">'+selected_name+'<span class="status '+status+'"></span></a>');
                  $('#recipients').val(selected_user_name);
                  $('#receiver_id').val(selected_user_id);                  
                  $('#chat_box').removeClass('hidden');
                  $('.chats').html('<img src="'+base_url+'assets/images/loading.gif" class="loading">')
                  $.post(base_url+'user/get_messages',{selected_user_id:selected_user_id},function(response){                                    
                    $('.chats').html(response); 
                    $('#hidden_id').focus().addClass('hidden'); 

                    $(".slimscrollleft.chats").mCustomScrollbar("update");
                    $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 
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


// sinchClient = new SinchClient({
//     applicationKey: 'f06ae4f2-4980-40aa-89ca-9b98d80d70c4',
//     //applicationKey: '673983ab-4c30-4e13-8631-c7d4967e0de2',
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
   var sender_id = $('#sender_id').val();
   var sessionObj = JSON.parse(localStorage[sessionName] || '{}');


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
                    $(".slimscrollleft.chats").mCustomScrollbar("update");
                    $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 

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



$(document).on('keyup','#activity_search',function(){
   var search_value = $(this).val();

   $.post(base_url+'user/search_activity_list',{search_value:search_value},function(activity_response){
     $('.jlist').html(activity_response);
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
                                   $('.topnotification').addClass('animate');
                                   $.get(base_url+'user/notify_applicants_viewed', function(response) {
                                       $(".redcircle").css('display','none');
                                       $('.topnotification').addClass('animate');
                                   });
                                   $('.topnotification').removeClass('animate');
                               });

                                 setInterval(function(){


                                     $.get(base_url+'user/get_call', function(response) {
                                        var json = jQuery.parseJSON(response);
                                        if(json.status){
                                            $('.new_call').html(json.html);                 
                                            $('audio#ringtone').trigger("play");
                                            $('.join').click(function(){
                                                var url  = $(this).attr('href');    
                                                var call_id  = $(this).attr('call_id');    

                                                newpopup = window.open(url,'newwindow','width=1200, height=1200');
                                                $.post(base_url+'user/attend_call_status',{call_id:call_id},function(res){

                                                }) 
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


                                        }


                                    });
                                 }, 5000);

                                 

                                 $.get(base_url+'user/conversation_ajax_request',function(res){
                                    $('.conversation').html(res);

                                    var i = 0;
                                    $('.callbox').each(function(){


                                        i++;

                                        var applicant_user_id = $('#applicant_user_id'+i).val();
                                        var applicant_image = $('#applicant_image'+i).val();
                                        var applicant_name = $('#applicant_name'+i).val();
                                        var logged_in = $('#logged_in'+i).val();
                                        if(logged_in == 0){
                                            var log_class='away';
                                        }else{
                                            var log_class='online';
                                        }
                                        var applicant_username = $('#applicant_username'+i).val();
                        var username = $(this).find('#callUserName').val(); // encoded to username                         
                        var channel = $(this).find('#channel').val(); // channel name 
                        var applicant_id = $(this).find('#applicant_id').val(); // to user id 
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

                        
                        //var x = setInterval(function() {
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
                                '<li><a href="#" class="conv_messages"  data-chat-id="'+applicant_user_id+'" data-username="'+applicant_username+'" data-name="'+applicant_name+'" data-image="'+applicant_image+'" data-status="'+log_class+'"><i aria-hidden="true" class="fa fa-comments-o"></i></a></li>'+
                                '</ul>'+
                                '<div class="remainingtime">Remaining time for the call - <strong id="demo">'+days+' Day</div>');

                        }else{ //More than One day 

                            // $('.conversation_start'+invite_id).html('<div class="callbtn">Remaining time for the call - <strong id="demo">'+days+' Days</strong></div>');

                            $('.conversation_start'+invite_id).html('<ul>'+
                                '<li><i aria-hidden="true" class="fa fa-video-camera"></i></li>'+
                                '<li><i aria-hidden="true" class="fa fa-phone"></i></li>'+
                                '<li><a href="#" class="conv_messages"  data-chat-id="'+applicant_user_id+'" data-username="'+applicant_username+'" data-name="'+applicant_name+'" data-image="'+applicant_image+'" data-status="'+log_class+'"><i aria-hidden="true" class="fa fa-comments-o"></i></a></li>'+
                                '</ul>'+
                                '<div class="remainingtime">Remaining time for the call - <strong id="demo">'+days+' Days</div>');
                        }                    

                    }
                    else if(days < 1 && hours > 0 || minutes > 0 || seconds > 0 ){ // Only Today 
                       // $('.conversation_start'+invite_id).html('<div class="callbtn">Remaining time for conversation - <strong id="demo"></strong></div>');
                       


                       $('.conversation_start'+invite_id).html('<ul>'+
                        '<li><i aria-hidden="true" class="fa fa-video-camera"></i></li>'+
                        '<li><i aria-hidden="true" class="fa fa-phone"></i></li>'+
                        '<li><a href="#" class="conv_messages"  data-chat-id="'+applicant_user_id+'" data-username="'+applicant_username+'" data-name="'+applicant_name+'" data-image="'+applicant_image+'" data-status="'+log_class+'"><i aria-hidden="true" class="fa fa-comments-o"></i></a></li>'+
                        '</ul>'+
                        '<div class="remainingtime">Remaining time for the call - <strong id="demo"></div>');
                       $('.conversation_start'+invite_id).find("#demo").html(hours + ":" + minutes + ":" + seconds); 

                   }
                   else{
                        // else if(days < 1 && minutes < 0 && seconds < 0 && current_d == conv_d && curr_min >= hr){
                       // $('.conversation_start'+invite_id).html('<div class="callbtnactive"><input type="hidden" value="'+username+'" id="start_session"><a href="'+base_url+'user/incoming_video_call/'+username+'/'+channel+'/'+applicant_id+'/'+encoded_invite_id+'"  class="startVideo" >Start Conversation</a></div>');


                       $('.conversation_start'+invite_id).html('<ul>'+
                        '<li><a href="'+base_url+'user/incoming_video_call/'+username+'/'+channel+'/'+applicant_id+'/'+encoded_invite_id+'" class="conv_videocall startVideo"><i aria-hidden="true" class="fa fa-video-camera"></i></a></li>'+
                        '<li><a href="'+base_url+'user/incoming_audio_call/'+username+'/'+channel+'/'+applicant_id+'/'+encoded_invite_id+'" class="conv_audiocall startAudio"><i aria-hidden="true" class="fa fa-phone"></i></a></li>'+
                        '<li><a href="#" class="conv_messages"  data-chat-id="'+applicant_user_id+'" data-username="'+applicant_username+'" data-name="'+applicant_name+'" data-image="'+applicant_image+'" data-status="'+log_class+'"><i aria-hidden="true" class="fa fa-comments-o"></i></a></li>'+
                        '</ul>'+
                        '<div class="remainingtime"><strong id="demo">Start the conversation</div>');
                       
                       



                   }


               //},1000);




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
                        // if( (minutes < 0 && seconds < 0 && current_d === conv_d && curr_min < hr ) || (current_d > conv_d))  {
                            if( (minutes < 0 && seconds < 0 && current_d === conv_d && curr_min < hr ) || (now_date.getDate() > countDownDate_init.getDate())) {
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
});

$(document).on('click','a.conv_messages',function(){


   $(".conv_messages_box").animate({
    width: "toggle" 
});   


        var selected_user_id = $(this).attr('data-chat-id');  // Id 
        var selected_name = $(this).attr('data-name');  // First & Last name 
        var selected_user_name = $(this).attr('data-username'); // username          
        var status = $(this).attr('data-status'); // status    

        // var old_id = $('#to_user_id').val();                  
        // if(old_id==selected_user_id || old_id == 0){
        //     $(".conv_messages_box").animate({
        //         width: "toggle" 
        //         });        
        // }

        

        var selected_user_id = $(this).attr('data-chat-id');  // Id 
        var selected_name = $(this).attr('data-name');  // First & Last name 
        var selected_user_name = $(this).attr('data-username'); // username          
        var status = $(this).attr('data-status'); // status    
        var old_id = $('#to_user_id').val();                  
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
     // $('.error_old').html('<font style="color:red;">Please Enter Subject</font>');
     swal("Warning!",'Please Enter Subject', "error");
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

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}




