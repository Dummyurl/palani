<div class="subnav">
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="
			<?php echo base_url();?>list-view">List View
		</a>
	</li>
	<li>
		<a href="
		<?php echo base_url();?>calendar">Calendar View
	</a>
</li>
</ul>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="card-box">
			<div class="row">
				<div class="col-sm-6">
					<div class="confirm-events">
						<h4>Confirmed Events</h4>
						<ul class="media-list media-list-linked event-list">
							<?php if(!empty($result)): ?>
								<?php foreach ($result as $activity) : ?>
									<?php                                            $img1 = '';                                           if($activity['picture_url'] != '')                                           {                                                   $img1 = $activity['picture_url'];                                           }                                           if($activity['profile_img'] != '')                                           {                                                   $file_check = FCPATH . '/assets/images/' . $activity['profile_img'];                                                   if (file_exists($file_check)) {                                                           $img1 = base_url() . 'assets/images/'.$activity['profile_img'];                                                   }                                           }                                           $img = ($img1 !='') ? $img1 : base_url() . 'assets/images/default-avatar.png';                                           ?>
									<li class="media">
										<div class="media-left">
										<img width="47" height="47" alt="" class="img-circle" src="
											<?php echo $img; ?>">
										</div>
										<div class="media-body media-middle text-nowrap">
											<div class="event-name">
												<?php echo $activity['first_name'].' '.$activity['last_name'] ; ?>
											</div>
											<div class="event-info">
												<?php //echo $activity['mentor_personal_message']; ?>
											</div>
											<div class="event-timings">
												<span class="event-date">Date: 
													    <?php echo date('d-m-Y',strtotime($activity['invite_date'])); ?>
												</span>
												<span class="event-time">Time: 
													<?php echo date('h:i A', strtotime($activity['invite_time'])); ?>
												</span>
												<span class="event-question">Number of Questions: 0</span>
											</div>
										</div>
										<div class="media-right media-middle text-nowrap">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<img src="
												<?php echo base_url();?>assets/images/menu.png" alt="">
											</a>
											<ul class="dropdown-menu">
												<li>
													<a href="
													<?php echo base_url();?>user/deleteactivity/
													<?php echo $activity['invite_id'];?>">Delete
												</a>
											</li>
										</ul>
									</div>
								</li>
							<?php endforeach; 
							echo $link1;
							?>
						<?php else: ?>
							<li>No Confirmed Events Found</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="pending-events">
					<h4>Pending Events</h4>
					<ul class="media-list media-list-linked event-list">
						<?php if(!empty($pending_result)): ?>
							<?php foreach ($pending_result as $pending_activity) : ?>
								<?php                                            $img1 = '';                                           if($pending_activity['picture_url'] != '')                                           {                                                   $img1 = $pending_activity['picture_url'];                                           }                                           if($pending_activity['profile_img'] != '')                                           {                                                   $file_check = FCPATH . '/assets/images/' . $pending_activity['profile_img'];                                                   if (file_exists($file_check)) {                                                           $img1 = base_url() . 'assets/images/'.$pending_activity['profile_img'];                                                   }                                           }                                           $img = ($img1 !='') ? $img1 : base_url() . 'assets/images/default-avatar.png';                                           ?>
								<li class="media">
									<div class="media-left">
										<img width="47" height="47" alt="" class="img-circle" src="
										<?php echo $img; ?>">
									</div>
									<div class="media-body media-middle text-nowrap">
										<div class="event-name">
											<?php echo $pending_activity['first_name'].' '.$pending_activity['last_name'] ; ?>
										</div>
										<div class="event-info">
											<?php //echo $pending_activity['applicant_personal_mess']; ?>
										</div>
										<div class="event-timings">
											<span class="event-date">Date: 
											    <?php echo date('d-m-Y',strtotime($pending_activity['invite_date'])); ?>
											</span>
											<span class="event-time">Time: 
												<?php echo date('h:i A', strtotime($pending_activity['invite_time'])); ?>
											</span>
											<span class="event-question">Number of Questions: 0</span>
										</div>
									</div>
									<div class="media-right media-middle text-nowrap">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<img src="
											<?php echo base_url();?>assets/images/menu.png" alt="">
										</a>
										<ul class="dropdown-menu">
											<?php if($pending_activity['approved'] == 0 && $pending_activity['invite_date'] >= date('Y-m-d')){ ?>
											<li>
												<a href="
												<?php echo base_url();?>approve-user/
												<?php echo base64_encode($pending_activity['invite_id']);?>">Approve
											</a>
										</li>
										<?php } ?>
										<li>
											<a href="
											<?php echo base_url();?>user/deleteactivity/
											<?php echo $pending_activity['invite_id'];?>">Delete
										</a>
									</li>
								</ul>
							</div>
						</li>
					<?php endforeach; 

					echo $link2; ?>
				<?php else: ?>
					<li>No Pending Events Found</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div>
</div>
</div>
</div>