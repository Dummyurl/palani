<?php if($this->session->userdata('role') == 0): ?>
<div class="row">
	<div class="col-sm-8 col-xs-12">
        <div class="profile-section">			<div class="profile-top">				<div class="row">				<?php 
				$img1 = '';		
				if($gurus['picture_url'] != '')
				{
					$img1 = $gurus['picture_url'];
				}
				if($gurus['profile_img'] != '')
				{
					$file_to_check = FCPATH . '/assets/images/' . $gurus['profile_img'];
					if (file_exists($file_to_check)) {
						$img1 = base_url() . 'assets/images/'.$gurus['profile_img'];
					}
				}
					$img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';				?>
					<div class="col-md-3 col-sm-5 col-xs-12">
						<div class="img-box">							<img alt="" class="img-responsive img-circle" src="<?php echo $img; ?>" height="165" width="165">
						</div>
					</div>
					<div class="col-md-9 col-sm-7 col-xs-12">
						<div class="user-details">
							<?php $city = ($gurus['city'] != '') ? $gurus['city'] : ""; ?>
							<?php $countryname = ($gurus['country_name'] != '') ? $gurus['country_name'] : ""; ?>
							<?php $addr = 'N/A';
								if($city != '') {
									$addr = $city;
								} 
								if($countryname != '') {
									$addr = $countryname;
								} 
								if($city != '' && $countryname != '') {
									$addr = $city.', '.$countryname;
								} 
							?>
							<?php $mentor_year = 'N/A';
								if($gurus['mentor_current_year'] != '' && $gurus['mentor_current_year'] > 0) {
									if($gurus['mentor_current_year'] == 1){
									 $mentor_year ='First Year'; 
									}
									if($gurus['mentor_current_year'] == 2){
									 $mentor_year ='Second Year'; 
									}
									if($gurus['mentor_current_year'] == 3){
									 $mentor_year ='Third Year'; 
									} 
									if($gurus['mentor_current_year'] == 4){
									 $mentor_year ='Fourth Year'; 
									} 
								} 
								if($gurus['mentor_school'] != '') {
									$mentor_year = $gurus['mentor_school'];
								} 
								if($gurus['mentor_current_year'] != '' && $gurus['mentor_current_year'] > 0 && $gurus['mentor_school'] != '') {
									if($gurus['mentor_current_year'] == 1){
									 $mentor_year ='First Year'; 
									}
									if($gurus['mentor_current_year'] == 2){
									 $mentor_year ='Second Year'; 
									}
									if($gurus['mentor_current_year'] == 3){
									 $mentor_year ='Third Year'; 
									} 
									if($gurus['mentor_current_year'] == 4){
									 $mentor_year ='Fourth Year'; 
									} 
									$mentor_year = $mentor_year.', '.$gurus['mentor_school'];
								} 
						   ?>
							<?php //$school = ($current_year != '' && $gurus['mentor_school'] != '') ? ', '.$gurus['mentor_school'] : $gurus['mentor_school']; ?>
							<div class="user-name"><a><?php echo $gurus['first_name']." ".$gurus['last_name'];  ?></a></div>
							<h4 class="user-title"><a><?php echo $gurus['mentor_personal_message'] ?></a></h4>
							<div class="user-education"><i class="fa fa-graduation-cap"></i> <?php echo $mentor_year; ?></div>
							<div class="user-address"><i class="fa fa-map-marker"></i><?php echo $addr; ?></div>
							<div class="ratings">
								<?php for($i=1; $i<=5 ;$i++) {
								if($i <= $gurus['rating_value']){
								?>
									<i class="fa fa-star" style="color:#ffc513 !important;"></i>
								<?php }else{ ?>
									<i class="fa fa-star"></i>
								<?php } 
								} ?>
								<span class="rating-count"><?php echo ($gurus['rating_value'] > 0) ? $gurus['rating_value'] : '0'; ?></span>
								<span class="total-rating">(<?php echo ($gurus['rating_count'] > 0) ? $gurus['rating_count'] : '0'; ?>)</span>							</div>
						</div>
					</div>				</div>			</div>			<div class="profile-view-bottom">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">						<h6>What schools did you apply to?</h6>						<h5><?php echo ($gurus['mentor_schools_applied']) ? $gurus['mentor_schools_applied'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">						<h6>What clubs are you part of?</h6>						<h5><?php echo ($gurus['mentor_clubs']) ? $gurus['mentor_clubs'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">						<h6>What executive positions in clubs do you hold at your school?</h6>						<h5><?php echo ($gurus['mentor_executive_positions']) ? $gurus['mentor_executive_positions'] : 'N/A'; ?></h5>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 m-t-20 m-b-30">						<h4>What jobs did you hold between undergrad and B-school?</h4>						<h5 class="dsgnation"><?php echo ($gurus['mentor_job_title']) ? $gurus['mentor_job_title'] : 'N/A' ; ?><br/>
						<?php echo $gurus['mentor_job_company']; ?><br/>
						<?php echo $gurus['mentor_job_dept']; ?><br/>
						 From <?php echo date("F", mktime(0, 0, 0, $gurus['mentor_job_from_month'], 10)); ?> <?php echo $gurus['mentor_job_from_year']; ?> 
						to <?php echo date("F", mktime(0, 0, 0, $gurus['mentor_job_to_month'], 10)); ?> <?php echo $gurus['mentor_job_to_year']; ?><br/>
						<?php echo $gurus['mentor_job_location']; ?>						</h5>						<p><?php echo $gurus['mentor_job_desc']; ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 m-t-0 m-b-50">
                        <h4>Charging: $<?php echo ($gurus['mentor_charge'] != '' ) ? $gurus['mentor_charge'] : "0.00"; ?>/hour</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
                        <h6>About yourself</h6>
                        <h5><?php echo ($gurus['mentor_personal_message'] != '') ? $gurus['mentor_personal_message'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>A personal statement</h6>
                        <h5><?php echo ($gurus['mentor_personal_message'] != '') ? $gurus['mentor_personal_message'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>What was your undergrad school?</h6>
                        <h5><?php echo ($gurus['mentor_school_accepted'] != '') ? $gurus['mentor_school_accepted'] : 'N/A'; ?></h5>
					</div>
					<div class="col-xs-12 m-b-20">
                        <h4>How much research did you do for each school?</h4>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Did you read the guides, which ones?</h6>
                        <h5><?php echo ($gurus['mentor_read_guide'] != '') ? $gurus['mentor_read_guide'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Did you hire a consultant?</h6>
                        <h5><?php echo ($gurus['mentor_hire_consult'] != '') ? $gurus['mentor_hire_consult'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Did you visit schools applied to?</h6>
                        <h5><?php echo ($gurus['mentor_visit_school'] != '') ? $gurus['mentor_visit_school'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Did you take tours?</h6>
                        <h5><?php echo ($gurus['mentor_tour'] != '') ? $gurus['mentor_tour'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Other?</h6>
                        <h5><?php echo ($gurus['mentor_other_extra'] != '') ? $gurus['mentor_other_extra'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h6>What other extracurricular activities are you involved in? Were involved in undergrad?</h6>
                        <h5><?php echo ($gurus['mentor_extracurricular_activities'] != '') ? $gurus['mentor_extracurricular_activities'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>What HS did you go to?</h6>
                        <h5><?php echo ($gurus['mentor_hs'] != '') ? $gurus['mentor_hs'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Where are you from?</h6>
                        <h5><?php echo ($gurus['mentor_from'] != '') ? $gurus['mentor_from'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>What countries did you live and work in?</h6>
                        <h5><?php echo ($gurus['mentor_live_work'] != '') ? $gurus['mentor_live_work'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>What languages do you speak?</h6>
                        <h5><?php echo ($gurus['mentor_languages_speak'] != '') ? $gurus['mentor_languages_speak'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h6>You Favorite Book, Movie, Business Book, Business Publication, Business Leader, Personal Role Model</h6>
                        <h5><?php echo ($gurus['mentor_favourite'] != '') ? $gurus['mentor_favourite'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Hobbies</h6>
                        <h5><?php echo ($gurus['mentor_hobbies'] != '') ? $gurus['mentor_hobbies'] : 'N/A'; ?></h5>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h6>Quotes</h6>
                        <h5><?php echo ($gurus['mentor_quotes'] !='') ? $gurus['mentor_quotes'] : 'N/A'; ?></h5>
					</div>
				</div>
			</div>
        </div>
	</div>
	<div class="col-sm-4 col-xs-12">
        <div class="rightsidebar">
			<div class="widget guru-details-widget">
				<div class="price text-center"><sup class="currency">$</sup> <span class="amount"><?php echo ($gurus['mentor_charge']!= '') ? $gurus['mentor_charge'] : '0.00'; ?></span>/hour</div>
				<div class="contact-btn text-center">
					<button class="btn btn-primary" onclick="<?php if($applicant['is_verified'] == 1){ ?>window.location='<?php echo base_url(); ?>user/schedule_guru/<?php echo $gurus['app_id']; ?>';<?php }else{ ?>showVerifyModal();<?php } ?>" title="Contact <?php echo $gurus['first_name']; ?>"><img src="<?php echo base_url();?>assets/images/contact-icon.png"> Contact <?php echo $gurus['first_name']; ?></button>
				</div>
			</div>
            <!-- Modal -->
			<div class="modal fade bs-example-modal-lg" id="choosedatetime" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h3>Choose Date & Time</h3>
						</div>
						<form name="schedule_form" id="schedule_form">
							<input type="hidden" name="app_id" id="app_id" value="<?php echo $gurus['app_id']; ?>" >
							<div class="modal-body">
								<div class="form-group">
									<label class="control-label">Please choose date</label>
									<input type="text" id="choosedate" name="contact_date" class="form-control calicon" required>
								</div>
								<div class="form-group">
									<label class="control-label">Please choose time</label>
									<input type="text" id="choosedate1" name="contact_time" class="form-control calicon" required>
									<div id="choosedate_error"></div>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
            <!-- Modal -->			<div class="widget review-widget">				<h4>Reviews</h4>				<?php $i=1; ?>
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
						<?php $count_review = 0; if(!empty($reviews)) : ?>
						<?php foreach($reviews as $review): ?>
						<?php if(!empty($review['review'])): ?>
							<?php $count_review++; ?>
							<div class="item <?php if ($i == 1) echo 'active'; ?>">
							<div class="review-content">
							<div class="review-details">
							<span class="testimonial-caret"></span>
							<p><?php echo $review['review']; ?></p>
							</div>
							<div class="review-author"><span><?php echo $review['reviewer_name']; ?></span></div>
							</div>
							</div>
						<?php $i++; endif; endforeach;  ?>
						<?php if(!empty($reviews) && $count_review < 1): ?>
						<p>No more reviews</p>
						<?php endif; ?>
						<?php else: ?>
						<p>No more reviews</p>
						<?php endif; ?>
					</div>
                </div>
			</div>
        </div>	</div></div>
<div class="modal fade bs-example-modal-lg" id="verify_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form name="send_second_verify" id="send_second_verify">      
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3>Warning!!</h3>
				</div>
				<div class="modal-body">
					<p>Sorry!! You cannot proceed.. Please verify your email to proceed..</p>
					<p>Please <a href="#" id="second_verify">click here</a> to verify</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php else: ?>
<?php $this->load->view('home/guru/gurus_detail_view'); ?>
<?php endif; ?>