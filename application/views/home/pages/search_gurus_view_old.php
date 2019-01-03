<?php
if($this->session->userdata('applicant_id') != '' && $this->session->userdata('type') != ''){
	$this->load->view('home/guru/header');
}else{
	?>
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
		<link href="<?php echo base_url()."assets/" ?>css/style.css" rel="stylesheet">
	</head>
	<body>
		<div class="overlay">
			<div id="loading-img"></div>
		</div>
		<header>
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-4"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>mentori_assets/img/logo.png" alt="Mentori.ng"></a></div>
					<div class="col-xs-8 mainnav">
						<ul>
							<li><a href="<?php echo base_url()."signup_mentor"; ?>">Become a Mentor</a></li>
							<li><a href="<?php echo base_url()."signup_mentee"; ?>">Become a Mentee</a></li>
							<li><a href="<?php echo base_url()."login" ?>">Login</a></li>
							<li><a href="<?php echo base_url()."signup" ?>">Register</a></li>
						</ul>
					</div>
				</div>
			</div>
		</header>
	<?php } ?>

	<section class="mainarea">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-xs-4 leftsidebar">
					<div class="theiaStickySidebar">
						<form action="<?php echo base_url(); ?>search-mentor" method="post" class="form-inline" id="home_search">
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
							<div id="search-error" style="color:red;"></div>
							<div class="search-btn">
								<button class="btn btn-primary search-left" type="button">Search</button>
							</div>									
						</div>
					</div>
					<div class="col-sm-8 col-md-9 col-xs-12">
						<input class="pull-left form-control right_top_search" name="right_top_search" id="right_top_search" type="text" placeholder="Enter the mentor name " />
						<div id="right-search-content">
							<div class="widget">
								<div class="widget-heading widget-default b-b-0 clearfix">
									<h3 class="widget-title pull-left"><?php echo $count; ?> Matches for your search</h3>
									<div class="sort-by pull-right">
										<div class="form-group">
											<select class="select form-control ordering" >
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
							<div id="guru-list">
								<input type="hidden" name="keyword" value="<?php echo set_value('keyword',$this->input->post('keyword')); ?>" id="keyword">
								<?php  if(!empty($gurus)): ?>
									<?php foreach($gurus as $guru_list):   ?>
										<a href="<?php echo base_url(); ?>mentor-profile/<?php echo $guru_list['username']; ?>" class="guru-list">
											<div class="row">
												<div class="col-sm-4 col-md-3 col-xs-12">
													<div class="guru-details text-center">
														

														<div class="guru-img">


															<?php 


															$img1 = '';
															if($guru_list['picture_url'] != '') {
																$img1 = $guru_list['picture_url'];
															}
															if($guru_list['profile_img'] != ''){
																$file_to_check = FCPATH . '/assets/images/' . $guru_list['profile_img'];
																if (file_exists($file_to_check)) {
																	$img1 = base_url() . 'assets/images/'.$guru_list['profile_img'];
																}
															}
															$img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';



															?>

															<img src="<?php echo $img; ?>" height="100" width="100" alt="Guru" class="img-circle">
														</div>

														<div class="guru-name"><?php echo $guru_list['first_name']." ".$guru_list['last_name'] ; ?></div>
														<div class="guru-country"><?php echo $guru_list['country_name']; ?></div>
														<?php 

														

														if($guru_list['charge_type'] == 'charge'){ 
															?>
															<div class="price">
																<span class="currency">$</span>
																<span class="amount"><?php echo ($guru_list['hourly_rate'] != '') ? $guru_list['hourly_rate'] : '0.00'; ?></span>/hour
															</div>
														<?php  }elseif($guru_list['charge_type'] == 'free'){?>
															<div class="price">
																<button class="btn btn-primary btn-xs">Free</button>
															</div>
														<?php }else{ 

															echo 'N/A';
														}
														?>

													</div>
												</div>
												<div class="col-sm-8 col-md-9 col-xs-12">
													<div class="guru-det">
														<h4 class="guru-title"><?php echo $guru_list['mentor_personal_message']; ?></h4>
														<div class="subject">Courses : 

															<?php 
															$where  = array('mentor_id'=>$guru_list['mentor_id']);
															$courses = $this->db
															->select('c.course')                                                
															->join('courses c','c.course_id = m.course_id')
															->join('subject s','s.subject_id = c.subject_id')
															->get_where('mentor_course_details m',$where)
															->result_array(); 
															$subs=array();
															if(!empty($courses)){
																foreach($courses as $s){
																	$subs[]=$s['course'];
																}
																$course = implode(',',$subs);

															}else{
																$course = '-';
															}
															echo $course;
															?>
														</div>
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
											</div>
										</a>
									<?php endforeach; endif;  ?>
									<?php if($count > 5){ ?>
										<div class="load-more-btn text-center">
											<button class="btn btn-default loadmore-guru" data-page="2"><i class="fa fa-refresh"></i> Load More</button>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>				
					</div>
				</div>
			</section>





			<script> var base_url = "<?php echo base_url(); ?>" </script>
			<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js"></script>
			<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js"></script>
			<script src="<?php echo base_url()."assets/" ?>js/bootstrapValidator.js" type="text/javascript"></script>
			<script src="<?php echo base_url()."assets/" ?>js/chosen.js"></script>
			   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css">
   				<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>

			<script src="<?php echo base_url()."assets/" ?>js/guru.js" type="text/javascript"></script>
			<script>
				$(document).on('keyup','.right_top_search',function(){
					var gender = $('#right_top_search').val();				
					var order_by = $('.ordering').val();
					var keyword = $('#right_top_search').val();  
					$('#search-error').html('');
					$.ajax({
						url:  base_url +'user/search_right',
						type: 'POST',
						data: { gender:gender,order_by:order_by,keyword:keyword},
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
			</script>
		</body>
		</html>
