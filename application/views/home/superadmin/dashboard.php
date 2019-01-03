
<div class="spa_conversations">
    <h3>Scheduled Conversations</h3>
    <div class="table-responsive">
		<table id="datatable" class="table table-striped">
			<thead>
				<tr>
					<th>Mentor Name</th>
					<th>Mentee Name</th>
					<th>Date</th>
					<th>From Time</th>
					<th>To Time</th>
					<th>Status</th>
					<!-- <th>Amount</th> -->
				</tr>
			</thead>
			<tbody></tbody>
		</table>
    </div>
</div>
<div class="row">
 <div class="col-sm-6 spa_gurulist">
     <h4>List of Mentors</h4>
     <ul class="media-list media-list-linked event-list">
        <?php

        foreach($gurus as $g): 
               
         if($g->profile_img!=''){ // Getting profile image from applicant table for mentor 
            $mentor_img = $g->profile_img;
            $file_to_check = FCPATH . '/assets/images/' . $mentor_img;
            if (file_exists($file_to_check)) {
              $mentor_img = base_url() . 'assets/images/'.$mentor_img;
            }

            $mentor_img = ($mentor_img != '') ? $mentor_img : base_url() . 'assets/images/default-avatar.png';

          }else if($g->picture_url!=''){ // Getting profile image from social table for mentor 
            $mentor_img = $g->picture_url;
          }else{
             $mentor_img = base_url() . 'assets/images/default-avatar.png';
          }  
            ?>   

            <li class="media">
                <div class="media-left"><img width="47" height="47" alt="" class="img-circle" src="<?php echo $mentor_img;  ?>"></div>
                <div class="media-body media-middle">
                    <div class="event-name"><?php echo $g->name; ?></div>              
                    </div>
                    <div class="media-right media-middle text-nowrap">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>assets/images/menu1.png" alt=""></a>
                        <ul class="dropdown-menu">
                              <li><a href="<?php echo base_url().'mentor-profile/'.$g->username; ?>">View</a></li>
                        </ul>												
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>



    <div class="col-sm-6 spa_applist">

     <h4>List of Mentees</h4>

     <ul class="media-list media-list-linked event-list">

        <?php

        foreach($users as $u): 


            if($u->profile_img!=''){ // Getting profile image from applicant table for mentor 
                $applicant_img = $u->profile_img;
                $file_to_check = FCPATH . '/assets/images/' . $applicant_img;
                if (file_exists($file_to_check)) {
                    $applicant_img = base_url() . 'assets/images/'.$applicant_img;
                }

                $applicant_img = ($applicant_img != '') ? $applicant_img : base_url() . 'assets/images/default-avatar.png';

          }else if($u->picture_url!=''){ // Getting profile image from social table for mentor 
            $applicant_img = $u->picture_url;
          }else{
            $applicant_img = base_url() . 'assets/images/default-avatar.png';
          }  
   

        ?>   

        <li class="media">
            <div class="media-left"><img width="47" height="47" alt="" class="img-circle" src="<?php echo $applicant_img;  ?>"></div>
            <div class="media-body media-middle">
                <div class="event-name"><?php echo $u->name; ?></div>               
                </div>
                <div class="media-right media-middle text-nowrap">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>assets/images/menu1.png" alt=""></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url().'mentee-profile/'.$u->username; ?>">View</a></li>
                    </ul>                                               
                </div>
            </li>
        <?php endforeach; ?>



    </ul>

</div>
</div>
</div>
</section>

