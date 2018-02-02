<div class="row">
	<div class="col-sm-8 col-xs-12">
        <div class="profile-section">			<div class="profile-top">				<div class="row">					<?php 
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
						<div class="img-box">							<img alt="" class="img-responsive img-circle" src="<?php echo $img; ?>">
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
								if($country != '') {
									$addr = $countryname;
								} 
								if($city != '' && $countryname != '') {
									$addr = $city.', '.$countryname;
								} 
							?>
							<div class="user-name"><a><?php echo $gurus['first_name']." ".$gurus['last_name'];  ?></a></div>
							<div class="user-address"><i class="fa fa-map-marker"></i><?php echo $addr; ?></div>
							<div class="subjects"><i class="fa fa-flask"></i> Subjects: <?php echo ($gurus['applicant_language_speak'] !='') ? $gurus['applicant_language_speak'] :'N/A' ; ?></div>
						</div>
                    </div>				</div>			</div>
        </div>
	</div>
	<div class="col-sm-4 col-xs-12">
        <div class="rightsidebar">			<div class="widget guru-details-widget">
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
        </div>	</div>
</div>
<div class="profile-view-bottom">
	<div class="row">
		<div class="col-xs-12">			<h6>A personal statement</h6>			<h5><?php echo ($gurus['applicant_personal_mess']!= '') ? $gurus['applicant_personal_mess']: 'N/A' ; ?></h5>
		</div>
	</div>
	<div class="row">    
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">			<h6>Schools wanting to apply to?</h6>			<h5><?php echo ($gurus['applicant_school_apply']!= '' && $gurus['applicant_school_apply_sts'] == 'Y') ? $gurus['applicant_school_apply']: 'N/A' ; ?></h5>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">			<h6>What do you want to get out of the conversation?</h6>			<h5><?php echo ($gurus['applicant_out_of_conversation']!= '' && $gurus['applicant_out_of_conversation_sts'] == 'Y') ? $gurus['applicant_out_of_conversation']: 'N/A' ; ?></h5>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">			<h6>What other extracurricular activities are you involved in at your college?</h6>			<h5><?php echo ($gurus['applicant_extracurricular']!= '' && $gurus['applicant_extracurricular_sts'] == 'Y') ? $gurus['applicant_extracurricular']: 'N/A' ; ?></h5>
		</div>
	</div>
	<div class="row">    
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">			<h6>What HS did you go to?</h6>			<h5><?php echo ($gurus['applicant_hs']!= '' && $gurus['applicant_hs_sts'] == 'Y') ? $gurus['applicant_hs']: 'N/A' ; ?></h5>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">			<h6>Where are you from?</h6>			<h5><?php echo ($gurus['applicant_from']!= '' && $gurus['applicant_from_sts'] == 'Y') ? $gurus['applicant_from']: 'N/A' ; ?></h5>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">			<h6>What countries did you live and work in?</h6>			<h5><?php echo ($gurus['applicant_live_and_work']!= '' && $gurus['applicant_live_and_work_sts'] == 'Y') ? $gurus['applicant_live_and_work']: 'N/A' ; ?></h5>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">			<h6>What languages do you speak?</h6>			<h5><?php echo ($gurus['applicant_language_speak']!= '' && $gurus['applicant_language_speak_sts'] == 'Y') ? $gurus['applicant_language_speak']: 'N/A' ; ?></h5>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">			<h6>Your Favorite Book, Movie, Business Book, Business Publication, Business Leader, Personal Role Model</h6>			<h5><?php echo ($gurus['applicant_favourites']!= '' && $gurus['applicant_favourites_sts'] == 'Y') ? $gurus['applicant_favourites']: 'N/A' ; ?></h5>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">			<h6>Hobbies</h6>			<h5><?php echo ($gurus['applicant_hobbies']!= '' && $gurus['applicant_hobbies_sts'] == 'Y') ? $gurus['applicant_hobbies']: 'N/A' ; ?></h5>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">			<h6>Quotes</h6>			<h5><?php echo ($gurus['applicant_quotes']!= '' && $gurus['applicant_quotes_sts'] == 'Y') ? $gurus['applicant_quotes']: 'N/A' ; ?></h5>
		</div>
	</div>
</div>

<h3>Call Logs</h3> <br>
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