<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <title>Mentori.ng</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/images/favicon.png">
  <link href="<?php echo base_url();?>mentori_assets/css/bootstrap.css" rel="stylesheet">
  <link href="<?php echo base_url();?>mentori_assets/css/animate.css" rel="stylesheet">
  <link href="<?php echo base_url();?>mentori_assets/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>mentori_assets/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url()."assets/" ?>css/search.css" rel="stylesheet">
  <link href="<?php echo base_url()."assets/" ?>css/style.css" rel="stylesheet">
</head>
<body>
  <div class="overlay">
    <div id="loading-img"></div>
  </div>
    <header class="header admin-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-3 mob-menu">
                        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>mentori_assets/img/logo_1.png" alt="Mentori.ng" class="img-responsive">
                        </a>
                        <div class="hamburger navbar-toggle collapsed mob-icon-menu img-responsive visible-xs" data-toggle="slide-collapse" data-target="#slide-navbar-collapse" aria-expanded="false">
                          <div class="burger-main">
                            <div class="burger-inner">
                              <span class="top"></span>
                              <span class="mid"></span>
                              <span class="bot"></span>
                            </div>
                          </div>
                        </div> 
                </div>
                <div class="col-md-8 col-sm-9 mainnav nav-mobile-menu">
                    <div class="collapse navbar-collapse" id="slide-navbar-collapse">    
                        <ul>
                            <?php if(empty($this->session->userdata('applicant_id'))){?>

                            <li><a href="<?php echo base_url()."signup_mentor"; ?>">Become a Mentor</a></li>
                            <li><a href="<?php echo base_url()."signup_mentee"; ?>">Become a Mentee</a></li>
                            <!-- <li><a href="#feedback">Feedback</a></li> -->
                            <li><a href="<?php echo base_url()."login" ?>">Login</a></li>
                            <li><a href="<?php echo base_url()."signup" ?>">Register</a></li>
                            <?php }else{

                                echo '<li><a href="'.base_url().'dashboard">Dashboard</a></li>
                                      <li><a href="'.base_url().'user/logout">Logout</a></li>';

                            } ?>
                        </ul>
                     </div>
                </div>
            </div>    
        </div>
    </header>
  <?php //} ?>

  <section class="mainarea search-mainarea">
    <div class="container">
     <div class="row">
      <div class="col-sm-4 col-md-3 col-xs-12">
        <div class="theiaStickySidebar leftsidebar">
          <h3 class="filter-title">Filters</h3>
          <div class="form-group">
            <label class="control-label">Gender</label>
            <select class="form-control" name="gender" id="gender">
              <option value="">No Preference</option>
              <option value="1">Male</option>
              <option value="2">Female</option>
            </select>
          </div>
          <div class="form-group">
            <label class="control-label">Subject</label>
            <select class="form-control" name="subject" id="subject">
              <option value="">--Select--</option>   
              <?php foreach($subjects as $s){
                echo '<option value="'.$s->subject_id.'">'.$s->subject.'</option>';
              } ?>                             
            </select> 
          </div>
          <div class="form-group">
            <label class="control-label">Course</label>
            <select class="form-control" name="course" id="course">
              <option value="">--Select--</option>                                                       
            </select> 
          </div>          
          <div style="color:red;" id="search-error"></div>
          <div class="search-btn">
            <button class="btn btn-primary" type="button" onclick="search_all_mentor(0)">Search</button> <!-- search-left -->
          </div>
        </div>
      </div>
      <div class="col-sm-8 col-md-9 col-xs-12">
        <div class="rightsidebar">
        <form id="search_all_mentor">
        <div class="row">
          <div class="col-md-12 mentor-search">
            <div class="input-group">
              <input class="pull-left form-control right_top_search"  name="right_top_search"  type="text" placeholder="Search by course or mentor name " value="<?php
              if($this->uri->segment(2)!=''){
                echo $this->uri->segment(2);
                }else{
                  echo set_value('keyword',$this->input->post('keyword'));
                }

                ?>" />
                <span class="input-group-addon">
                  <button type="submit">Search</button>
                </span>
              </div>        
            </div>
          </div>
          </form>
          <div class="row">
            <div class="col-md-12 mentor-sort-by">
              <h3 class="widget-title pull-left"></h3>
              <div class="widget mentor-sort-widget pull-right">
                <div class="widget-heading widget-default b-b-0 clearfix">

                  <div class="sort-by pull-right">
                    <div class="form-group">
                      <select class="select form-control" id="orderby" onchange="search_all_mentor(0)"> <!-- ordering -->
                        <option value="">--Select--</option>
                        <option value="Rating">Rating</option>
                        <option value="Popular">Popular</option>
                        <option value="Latest">Latest</option>
                        <option value="Free">Free</option>
                      </select>
                    </div>
                  </div>
                  <div class="sort-text pull-right">
                    <span>Sort by</span>
                  </div>
                </div>
              </div>
              <input type="hidden" name="page" id="page_no_hidden" value="1" >
            </div>
          </div>    



          <div id="guru-list"></div>        
        <div class="load-more-btn text-center hidden" id="load_more_btn">
         <button class="btn btn-default" ><i class="fa fa-refresh"></i> Load More</button>
       </div>
       <div id="no_more" align="center" >No more mentors.</div>
        </div>
     </div>
   </div>

   <script> var base_url = "<?php echo base_url(); ?>" </script>
   <script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js"></script>
   <script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js"></script>
   <script type="text/javascript">

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
        keyword : keyword
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
           html +='<a href="'+base_url+'mentor-profile/'+this.username+'" class="guru-list col-md-12">'+
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


      var Closed = false;

      $('.hamburger').click(function () {
        if (Closed == true) {
          $(this).removeClass('open');
          $(this).addClass('closed');
          Closed = false;
        } else {               
          $(this).removeClass('closed');
          $(this).addClass('open');
          Closed = true;
        }
      });

  </script>
    <script>
        $('[data-toggle="slide-collapse"]').on('click', function() {
          $navMenuCont = $($(this).data('target'));
          $navMenuCont.animate({
            'width': 'toggle'
          }, 350);
          $(".menu-overlay").fadeIn(500);

        });
        $(".menu-overlay").click(function(event) {
          $(".navbar-toggle").trigger("click");
          $(".menu-overlay").fadeOut(500);
        });
  </script>