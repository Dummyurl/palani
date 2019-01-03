	<div class="container search-details-view">
	<div class="row">
		<div class="col-sm-8 col-xs-12">
			<div class="profile-section">
				<div class="profile-top">
					<div class="row">
						<?php 
						$img1 = '';		
						if($gurus['picture_url'] != ''){
							$img1 = $gurus['picture_url'];
						}
						if($gurus['profile_img'] != ''){
							$file_to_check = FCPATH . '/assets/images/' . $gurus['profile_img'];
							if (file_exists($file_to_check)) {
								$img1 = base_url() . 'assets/images/'.$gurus['profile_img'];
							}
						}
						$img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';		
						?>
						<div class="col-md-3 col-sm-5 col-xs-12">
							<div class="img-box">							
								<img alt="" class="img-responsive img-circle" src="<?php echo $img; ?>" height="165" width="165">
							</div>
						</div>
						<div class="col-md-9 col-sm-7 col-xs-12">
							<div class="user-details">
								<?php $city = ($gurus['city'] != '') ? $gurus['city'] : ""; ?>
								<?php $countryname = ($gurus['country'] != '') ? $gurus['country'] : ""; ?>
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
								<div class="user-name">
									<h2><?php echo $gurus['first_name']." ".$gurus['last_name'];  ?></h2>,
									<div class="user-address"><i class="fa fa-map-marker"></i><?php echo $addr; ?></div>
								</div>									
								<div class="subject"><strong>Courses : </strong>

									<?php 
									$where  = array('mentor_id'=>$gurus['mentor_id']);
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
								
								
									
							</div>
						</div>

					</div>
				</div>						
				<div class="profile-view-bottom">
						<div class="row">						
							<div class="search-detail-title">
								<h3>Biography</h3>
							</div>	
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">								
								<?php echo '<h5>'.$gurus['mentor_personal_message'].'</h5>' ?>
							</div>
						</div>
						<div class="row">
							<div class="search-detail-title">
								<h3>Qualification</h3>
							</div>	
							<div class="col-md-6 col-sm-12 col-xs-12">
								<h6>Undergraduate college</h6>
								<h5><?php echo ($gurus['under_college'] != '') ? $gurus['under_college'] : 'N/A'; ?></h5>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<h6>Undergraduate major</h6>
								<h5><?php echo ($gurus['under_major'] != '') ? $gurus['under_major'] : 'N/A'; ?></h5>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<h6>Graduate college1?</h6>
								<h5><?php echo ($gurus['graduate_college'] != '') ? $gurus['graduate_college'] : 'N/A'; ?></h5>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<h6>Type of degree </h6>
								<h5><?php echo ($gurus['degree'] != '') ? $gurus['degree'] : 'N/A'; ?></h5>
							</div>
						</div>				
				</div>		
			</div>
		</div>

			<div class="col-sm-4 col-xs-12">
		<div class="rightsidebar">
			<div class="widget guru-details-widget">
				<div class="contact-btn text-center">
					<button class="btn btn-primary"  title="Contact <?php echo $gurus['first_name']; ?>" data-target="#send_message" data-toggle="modal"> Send Message</button>
				</div>				
			</div>
		</div>
	</div>

<!-- 		<div class="col-sm-4 col-xs-12">
			<div class="rightsidebar">
				<div class="widget guru-details-widget">
					<?php 
					if($gurus['charge_type'] == 'charge' && !empty($gurus['hourly_rate'])){ ?>
						<div class="price"><span class="currency">$</span> <span class="amount"><?php echo ($gurus['hourly_rate']!= '') ? $gurus['hourly_rate'] : '0.00'; ?></span><span>/hour</span></div>

					<?php }elseif($gurus['charge_type'] == 'free'){
						echo '<div class="price">
						<button class="btn btn-default ">FREE</button></h1>
						</div>';
					}
					if($gurus['charge_type'] == 'charge' && !empty($gurus['hourly_rate']) || $gurus['charge_type'] == 'free'){ ?>						
						<div class="contact-btn">
							<button class="btn btn-primary" onclick="<?php if($gurus['charge_type'] == 'charge' || $gurus['charge_type'] == 'free'){ ?>window.location='<?php echo base_url(); ?>user/schedule_mentor/<?php echo $gurus['app_id']; ?>';<?php }else{ ?>showVerifyModal();<?php } ?>" title="Contact <?php echo $gurus['first_name']; ?>"><img src="<?php echo base_url();?>assets/images/contact-icon.png"> Contact <?php echo $gurus['first_name']; ?></button>
						</div>
					<?php } ?>
				</div>

				<div class="widget review-widget">
					<h4>Reviews</h4>				
					<?php $i=1; ?>
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
											<div class="review-author"><span><?php echo $review['first_name'].' '.$review['last_name']; ?></span></div>
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
					</div>
				</div>
 -->

			</div>
		</div>
		<?php if(!empty($call_logs)){?>
		<div class="container call-log-table">
			<h3>Call Logs</h3> <br>
			<div class="table-responsive">
				<table class="table table-striped" id="call_log">
					<thead>
						<tr>
							<th>Date</th>
							<th>Start time</th>
							<th>End time</th>
							<th>Total time</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach($call_logs as $c): 		
							// echo '<pre>'; print_r($call_logs); exit;		
							$date = date('d-m-Y',strtotime($c->invite_date));
							$start_time = date('Y-m-d h:i:s',strtotime($c->start_time));
							$end_time = date('Y-m-d h:i:s',strtotime($c->end_time));
							$start_date = new DateTime($end_time);	
							$since_start = $start_date->diff(new DateTime($start_time));
							echo '<tr>
							<td>'.$date.'</td>
							<td>'.date('h:i A',strtotime($date.' '.$c->start_time)).'</td>
							<td>'.date('h:i A',strtotime($date.' '.$c->end_time)).'</td>									
							<td>'.$since_start->i.' mins  '.$since_start->s.' seconds'.'</td>								
							</tr>';

						endforeach;
						?>
					</tbody>
				</table>
			</div>	
		</div>		

	<?php } ?>
		<!-- Modal  -->	
	<div class="modal fade bs-example-modal-lg" id="send_message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3>Send Message</h3>
				</div>
				<form name="send_messages_form" id="send_messages_form">
					<input type="hidden" name="invite_id" id="invite_id" value="<?php echo $gurus['app_id']; ?>">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Subject <span style="color:red;">*</span></label>
									<input type="text" name="subject" id="subject" class="form-control" value="" required />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Message <span style="color:red;">*</span></label>
												<textarea class="form-control" id="invite_message" name="invite_message" value="" required></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="submit" class="btn btn-primary">Send</button>
								</div>
							</form>
						</div>
					</div>
				</div>
		<!-- Modal ends  -->	
				<script>
					$(".container").removeClass("dashboard-container");
				</script>