<div class="row">
	<div class="col-sm-8 col-xs-12">
		<div class="profile-section">
			<div class="profile-top">
				<div class="row">
					<?php 
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
					$img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';					?>
					<div class="col-md-3 col-sm-5 col-xs-12">
						<div class="img-box">
							<img alt="" class="img-responsive img-circle" src="<?php echo $img; ?>">
						</div>
					</div>
					<div class="col-md-9 col-sm-7 col-xs-12">
						<div class="user-details">
							<?php $countryname = ($gurus['country'] != '') ? $gurus['country'] : ""; ?>							
							<div class="user-name"><a><?php echo $gurus['first_name']." ".$gurus['last_name'];  ?></a></div>
							<h4 class="user-title"><a><?php echo $gurus['mentor_personal_message'] ?></a></h4>
							<div class="user-address"><i class="fa fa-map-marker"></i><?php echo $countryname; ?></div>

							<div class="subject">Courses : 

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
		</div>
	</div>
	<div class="col-sm-4 col-xs-12">
		<div class="rightsidebar">
			<div class="widget guru-details-widget">
				<div class="contact-btn text-center">
					<button class="btn btn-primary"  title="Contact <?php echo $gurus['first_name']; ?>" data-target="#send_message" data-toggle="modal"> Send Message</button>
				</div>
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
				<!-- Modal -->
			</div>
		</div>
	</div>
</div>
<div class="profile-view-bottom">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h6>Gender</h6>
			<h5><?php 
			if($gurus['mentor_gender']==1){echo  'Male';}
			elseif($gurus['mentor_gender']==2){echo  'Female';}
			else{ echo 'N/A' ; }  ?></h5>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h6>Date of birth</h6>
			<h5><?php 
			echo ($gurus['dob']!='1970-01-01' && $gurus['dob']!='0000-00-00' && !empty($gurus['dob'])) ? date('d-m-Y',strtotime($gurus['dob'])) : 'N/A'; ?></h5>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h6>Where did you hear about us??</h6>
			<h5><?php echo ($gurus['where_you_heard']) ? $gurus['where_you_heard'] : 'N/A'; ?></h5>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 m-t-0 m-b-50">
			<h4>Qualifications</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-md-6 col-sm-12 col-xs-12">
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
		<div class="row">
			<div class="col-sm-12 m-t-0 m-b-50">
				<h4>Contact Details</h4>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h6>Address 1</h6>
			<h5><?php echo ($gurus['address_line1'] != '') ? $gurus['address_line1'] : 'N/A'; ?></h5>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h6>Address 2</h6>
			<h5><?php echo ($gurus['address_line2'] != '') ? $gurus['address_line2'] : 'N/A'; ?></h5>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h6>City</h6>
			<h5><?php echo ($gurus['city'] != '') ? $gurus['city'] : 'N/A'; ?></h5>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h6>State</h6>
			<h5><?php echo ($gurus['state'] != '') ? $gurus['state'] : 'N/A'; ?></h5>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h6>Country</h6>
			<h5><?php echo ($gurus['country'] != '') ? $gurus['country'] : 'N/A'; ?></h5>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<h6>Postal code</h6>
			<h5><?php echo ($gurus['postal_code'] != '') ? $gurus['postal_code'] : 'N/A'; ?></h5>
		</div>
	</div>
</div>
<h3>Call Logs</h3>
<br>
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
			$date = date('d-m-Y',strtotime($c->invite_date));
			$start_time = date('Y-m-d h:i:s',strtotime($c->start_time));
			$end_time = date('Y-m-d h:i:s',strtotime($c->end_time));
			$start_date = new DateTime($end_time);	
			$since_start = $start_date->diff(new DateTime($start_time));

         				// echo $since_start->days.' days total<br>';
         				// echo $since_start->y.' years<br>';
         				// echo $since_start->m.' months<br>';
         				// echo $since_start->d.' days<br>';
         				// echo $since_start->h.' hours<br>';
         				// echo $since_start->i.' minutes<br>';
         				// echo $since_start->s.' seconds<br>';
         				// $start_time = date('d-m-Y',strtotime($c->start_time));
         				// $end_time = date('d-m-Y',strtotime($c->end_time));
			echo '<tr>
			<td>'.$date.'</td>
			<td>'.date('h:i A',strtotime($date.' '.$c->start_time)).'</td>
			<td>'.date('h:i A',strtotime($date.' '.$c->end_time)).'</td>									
			<td>'.$since_start->i.' minutes  '.$since_start->s.' seconds'.'</td>								
			</tr>';

		endforeach;
		?>
	</tbody>
</table>