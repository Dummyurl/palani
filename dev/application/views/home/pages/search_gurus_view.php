<?php 
    if($this->session->userdata('applicant_id') != '' && $this->session->userdata('type') != ''){
            $this->load->view('home/guru/header'); 
}else{
 ?><!DOCTYPE html>
<html lang="en">
        <head>
                <meta charset="utf-8">               
                <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
                <title>School Guru</title>
                <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.png">
                <link href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" rel="stylesheet">
                <link href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" rel="stylesheet">
                <link href="<?php echo base_url()."assets/" ?>css/cardeffect.css" rel="stylesheet">
                <link href="<?php echo base_url()."assets/" ?>css/style.css" rel="stylesheet">
                <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/dist/bootstrapValidator.css" type="text/css">
                <script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>

<style>
 #loading-img {
    background: url(<?php echo base_url(); ?>assets/css/img/loading.gif) center center no-repeat;   
    height: 100%;
    z-index: 20;
}

.overlay {
    background: #e9e9e9;
    display: none;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    opacity: 0.5;
    z-index: 999;
    overflow: auto;
    margin: auto;
}
.star {width:25px;height:25px; position:relative; float:left;}

</style>

<style>
.fa-star{color:#D3D3D3 !important;}
.gray{color:#D3D3D3;}
.yellow{color:#ffc513;}
 </style>       
	   </head>
         <body class="search-page">
		 <div class="overlay">
           <div id="loading-img"></div>
         </div>
           <section class="mainarea">
    	   <div class="container">
                <header id="header" class="horz header">
                        <nav class="navbar navbar-fixed-top bg-transparent top-nav-collapse" id="main-navbar">
                                <div class="container">
                                        <div class="navbar-header">
                                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                                                        <span class="sr-only">Toggle navigation</span>
                                                        <span class="icon-bar"></span>
                                                        <span class="icon-bar"></span>
                                                        <span class="icon-bar"></span>
                                                </button>
                                                <a href="<?php echo base_url(); ?>" class="navbar-brand"><img src="<?php echo base_url()."assets/" ?>images/logo-dark.png" alt="logo" /></a>
                                        </div>
                                        <div class="collapse navbar-collapse" id="navbar-collapse">
                                                <ul class="nav navbar-nav navbar-right top-menu">
                                                    <li><a href="<?php echo base_url()."guru"; ?>">Become a School Guru</a></li>
                                                    <li><a href="<?php echo base_url()."user"; ?>">Get help from School Guru</a></li>
                                                    <li><a href="<?php echo base_url(); ?>welcome#feedback">Feedback</a></li>
                                                    <li class="login-menu"><a href="<?php echo base_url()."login" ?>">Login</a></li>
                                                    <li class="login-menu"><a href="<?php echo base_url()."signup" ?>">Signup</a></li>
                                                </ul>
                                        </div>
                                </div>
                        </nav>
                </header>    
<section class="mainarea ">
 <div class="container">
    <?php } ?>
<div class="row">
        <div class="col-sm-3 col-xs-4 leftsidebar">
                <div class="theiaStickySidebar">
                    
                    <form action="<?php echo base_url(); ?>search-guru" method="post" class="form-inline" id="home_search">
                        <input class="form-control" value="<?php 
                        if($this->uri->segment(2)!=''){
                            echo $this->uri->segment(2);
                        }else{
                            echo set_value('keyword',$this->input->post('keyword'));     
                        }                        

                        ?>" id="old_keyword" name="keyword" type="text"> 
                        <input style="height: 40px;width: 80px;" type="submit" class="btn btn-primary" value="GO" onclick="return checkinner_validation();">
                        <div class="error_old"></div>						
                    </form>
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
                <label class="control-label">Admitted School</label>
                <input type="email" class="form-control" name="admitted_school" id="admitted_school">
            </div>
            <div class="form-group">
                <label class="control-label">School Offers Received</label>
                <input type="email" class="form-control" name="school_offer" id="school_offer">
            </div>
            <div class="form-group">
                <label class="control-label">Year of School currently in</label>
                <select class="form-control" name="school_year" id="school_year">
                    <option value="">Select Year</option>
                    <option value="1">First Year</option>
                    <option value="2">Second Year</option>
                    <option value="3">Third Year</option>
                    <option value="4">Fourth Year</option>
                    <option value="5">Fifth Year</option>
                </select>
            </div>
			<div id="search-error" style="color:red;"></div>
            <div class="search-btn">
                <button class="btn btn-primary search-left" type="button">Search</button>
            </div>

            <div class="profile-preview">
                <a class="btn btn-success btn-block" href="#" data-toggle="modal" data-target="#advancedsearch">Advanced Search</a>
            </div>
            

    </div>
    </div>
<div class="col-sm-9 col-xs-8" id="right-search-content">

        <div class="widget">
                <div class="widget-heading widget-default b-b-0 clearfix">
                        <h3 class="widget-title pull-left"><?php echo $count; ?> Matches for your search</h3>
                        <div class="sort-by pull-right">
                                <div class="form-group">
                                        <select class="select form-control ordering">
                                                <option value="">Rating</option>
                                                <option value="">Popular</option>
                                                <option value="">Latest</option>
                                        </select>
                                </div>
                        </div>
                        <div class="sort-text pull-right">
                                <span>Sort by</span>
                        </div>
<!--                        <div class="view-format pull-right">
                                <span>View</span> 
                                <div class="btn-group">
                                        <a id="results-list-view" class="btn btn-default active" href="#" title="List View"><i class="fa fa-th-list"></i></a>
                                        <a id="results-grid-view" class="btn btn-default" href="#" title="Grid View"><i class="fa fa-th"></i></a>
                                </div>
                        </div>-->
                </div>
        </div>
    <div id="guru-list">
        <input type="hidden" name="keyword" value="<?php echo set_value('keyword',$this->input->post('keyword')); ?>" id="keyword">
    <?php  if(!empty($gurus)): ?>
    <?php foreach($gurus as $guru_list):   ?>
        <a href="<?php echo base_url(); ?>guru-profile/<?php echo $guru_list['username']; ?>" class="guru-list">
                <div class="row">
                        <div class="col-sm-3 col-xs-4">
                                <div class="guru-details text-center">
                                     <?php $city = ($guru_list['city'] != '') ? $guru_list['city'] : ""; ?>
                                     <?php $countryname = ($guru_list['country_name'] != '' && $guru_list['city'] != '') ? ', '.$guru_list['country_name'] : $guru_list['country_name']; ?>
                                        <div class="guru-img"><img src="<?php echo ($guru_list['profile_img'] != '') ? base_url() . 'assets/images/'.$guru_list['profile_img'] : base_url() . 'assets/images/default-avatar.png'; ?>" height="100" width="100" alt="Guru" class="img-circle"></div>
                                        <div class="guru-name"><?php echo $guru_list['first_name']." ".$guru_list['last_name'] ; ?></div>
                                        <div class="guru-country"><?php echo $city.$countryname; ?></div>
                                        <div class="price"><span class="currency">$</span> <span class="amount"><?php echo ($guru_list['mentor_charge'] != '') ? $guru_list['mentor_charge'] : '0.00'; ?></span>/hour</div>
                                </div>
                        </div>
                        <div class="col-sm-9 col-xs-8">
                                <h4 class="guru-title"><?php echo $guru_list['mentor_personal_message']; ?></h4>
                                 <div class="ratings">
                                        <?php for($i=1; $i<=5 ;$i++) {
                                                if($i <= $guru_list['rating_value']){
                                         ?>
                                            <i class="fa fa-star" style="color:#ffc513 !important;"></i>
                                         <?php }else{ ?>
                                            <i class="fa fa-star"></i>
                                        <?php } 
                                     } ?>
                                
                                <span class="rating-count"><?php echo ($guru_list['rating_value'] > 0) ? $guru_list['rating_value'] : '0'; ?></span>
                                <span class="total-rating">(<?php echo ($guru_list['rating_count'] > 0) ? $guru_list['rating_count'] : '0'; ?>)</span>
                                </div>
                                <p><?php echo $guru_list['mentor_job_desc']; ?></p>
                                <span class="read-more">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                </div>
        </a>
        <?php endforeach; endif;  ?>
        <?php if($count > 5){ ?>
        <div class="load-more-btn text-center">
           <button class="btn btn-default loadmore-guru" data-page="5"><i class="fa fa-refresh"></i> Load More</button>
        </div>
        <?php } ?>
    </div>
    </div>
	
	<!-- Modal -->
            <div class="modal fade bs-example-modal-lg" id="advancedsearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3>Advanced Search</h3>
                  </div>
                  <form action="<?php echo base_url();?>welcome/advance_search" method="post" id="advance_search_form">
                  <input type="hidden" value="<?php echo set_value('mentor_gender',$this->input->post('mentor_gender')); ?>" id="mentor_gender_hidden">
				   <input type="hidden" value="<?php echo set_value('mentor_school',$this->input->post('mentor_school')); ?>" id="mentor_school_hidden">
				   <input type="hidden" value="<?php echo set_value('mentor_schools_applied',$this->input->post('mentor_schools_applied')); ?>" id="mentor_schools_applied_hidden">
				   <input type="hidden" value="<?php echo set_value('mentor_current_year',$this->input->post('mentor_current_year')); ?>" id="mentor_current_year_hidden">
				   <input type="hidden" value="<?php echo set_value('mentor_extracurricular_activities',$this->input->post('mentor_extracurricular_activities')); ?>" id="mentor_extracurricular_activities_hidden">
				   <input type="hidden" value="<?php echo set_value('mentor_job_company',$this->input->post('mentor_job_company')); ?>" id="mentor_job_company_hidden">
				   <input type="hidden" value="<?php echo set_value('mentor_job_title',$this->input->post('mentor_job_title')); ?>" id="mentor_job_title_hidden">
                   <input type="hidden" value="<?php echo set_value('mentor_job_from_year',$this->input->post('mentor_job_from_year')); ?>" id="mentor_job_from_year_hidden">
				   <input type="hidden" value="<?php echo set_value('mentor_about',$this->input->post('mentor_about')); ?>" id="mentor_about_hidden">
				   <input type="hidden" value="<?php echo set_value('mentor_languages_speak',$this->input->post('mentor_languages_speak')); ?>" id="mentor_languages_speak_hidden">
				   
 				 <div class="modal-body">
                            <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Gender</label>
                                <select class="form-control" name="mentor_gender" id="mentor_gender">
                                    <option value="">No Preference</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Admitted School</label>
                                <input type="text" class="form-control" name="mentor_school" id="mentor_school">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">School Offers Received</label>
                                <input type="text" class="form-control" name="mentor_schools_applied" id="mentor_schools_applied">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Year of School currently in</label>
                                <select class="form-control" name="mentor_current_year" id="mentor_current_year">
                                    <option value="">Select Year</option>
                                    <option value="1">First Year</option>
                                    <option value="2">Second Year</option>
                                    <option value="3">Third Year</option>
                                    <option value="4">Fourth Year</option>
                                    <option value="5">Fifth Year</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Extracurricular activities involved in</label>
                                <input type="text" class="form-control" name="mentor_extracurricular_activities" id="mentor_extracurricular_activities">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Prior firm / Company names</label>
                                <input type="text" class="form-control" name="mentor_job_company" id="mentor_job_company">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Prior job titles</label>
                                <input type="text" class="form-control" name="mentor_job_title" id="mentor_job_title">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Years of professional experience</label>
                                <input type="text" class="form-control" name="mentor_job_from_year" id="mentor_job_from_year">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Geography</label>
                                <input type="text" class="form-control" name="mentor_about" id="mentor_about">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Languages spoken</label>
                                <input type="text" class="form-control" name="mentor_languages_speak" id="mentor_languages_speak">
                            </div>
                        </div>
                    </div>
					<div style="color:red;" id="search-advance-error"></div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="advance_search" onclick="return validateSearch();">Search</button>
                  </div>
                    </form>
                </div>
              </div>
            </div>
            <!-- Modal -->
			
</div>
     </div>
        </section>
        </div>
        </section>
         </div>
<script> var base_url = "<?php echo base_url(); ?>" </script>
<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/dist/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/chosen.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/guru.js" type="text/javascript"></script>

<script>
(function() {
var rotate, timeline;

rotate = function() {
return $('.card:first-child').fadeOut(400, 'swing', function() {
return $('.card:first-child').appendTo('.work-img').hide();
}).fadeIn(400, 'swing');
};

timeline = setInterval(rotate, 4000);

$('body').hover(function() {
return clearInterval(timeline);
});

$('.card').click(function() {
return rotate();
});
}).call(this);
</script>
</body>
</html>