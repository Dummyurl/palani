<div class="spa_conversations">
    <h3>Scheduled Conversations</h3>
    <table id="datatable" class="table table-striped">
        <thead>
            <tr>
                <th>Guru Name</th>
                <th>Applicant Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<div class="row">
 <div class="col-sm-6 spa_gurulist">
     <h4>List of Gurus</h4>
     <ul class="media-list media-list-linked event-list">
        <?php

        foreach($gurus as $g): 
               
         if($g->mentor_profile_img!=''){ // Getting profile image from applicant table for mentor 
            $mentor_img = $g->mentor_profile_img;
            $file_to_check = FCPATH . '/assets/images/' . $mentor_img;
            if (file_exists($file_to_check)) {
              $mentor_img = base_url() . 'assets/images/'.$mentor_img;
            }

            $mentor_img = ($mentor_img != '') ? $mentor_img : base_url() . 'assets/images/default-avatar.png';

          }else if($g->mentor_picture!=''){ // Getting profile image from social table for mentor 
            $mentor_img = $g->mentor_picture;
          }else{
             $mentor_img = base_url() . 'assets/images/default-avatar.png';
          }  
            ?>   

            <li class="media">
                <div class="media-left"><img width="47" height="47" alt="" class="img-circle" src="<?php echo $mentor_img;  ?>"></div>
                <div class="media-body media-middle">
                    <div class="event-name"><?php echo $g->name; ?></div>
                    <div class="event-timings">
                        <?php
                        $mentor_job_desc =   $g->mentor_job_desc;
                        echo ($mentor_job_desc!= '') ? $mentor_job_desc: 'N/A' ;
                        ?></div>
                    </div>
                    <div class="media-right media-middle text-nowrap">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>assets/images/menu.png" alt=""></a>
                        <ul class="dropdown-menu">
                              <li><a href="<?php echo base_url().'gurus-profile/'.$g->username; ?>">View</a></li>
                        </ul>												
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>



    <div class="col-sm-6 spa_applist">

     <h4>List of Applicants</h4>

     <ul class="media-list media-list-linked event-list">

        <?php

        foreach($users as $u): 


            if($u->applicant_profile_img!=''){ // Getting profile image from applicant table for mentor 
                $applicant_img = $u->applicant_profile_img;
                $file_to_check = FCPATH . '/assets/images/' . $applicant_img;
                if (file_exists($file_to_check)) {
                    $applicant_img = base_url() . 'assets/images/'.$applicant_img;
                }

                $applicant_img = ($applicant_img != '') ? $applicant_img : base_url() . 'assets/images/default-avatar.png';

          }else if($u->applicant_picture!=''){ // Getting profile image from social table for mentor 
            $applicant_img = $u->applicant_picture;
          }else{
            $applicant_img = base_url() . 'assets/images/default-avatar.png';
          }  




                        // Images  from applicant table
        //     $profile_img = '';
        //     if(isset($u->profile_img) && !empty($u->profile_img))
        //     {
        //         $profile_img = $u->profile_img;

        //     } 

        //                 // Images  from social app table

        //     $social_profile_img = '';
           
        //     $img1 = '';
        //     if($g->picture_url != '')
        //     {
        //      $img1 = $g->picture_url;

        //  }


        //  if($profile_img != '')
        //  {
        //     $file_to_check = FCPATH . '/assets/images/' . $profile_img;
        //     if (file_exists($file_to_check)) {
        //         $img1 = base_url() . 'assets/images/'.$profile_img;
        //     }
        // }
        //                  // Default Image 
        // $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';           

        ?>   

        <li class="media">
            <div class="media-left"><img width="47" height="47" alt="" class="img-circle" src="<?php echo $applicant_img;  ?>"></div>
            <div class="media-body media-middle">
                <div class="event-name"><?php echo $u->name; ?></div>
                <div class="event-timings">
                    <?php
                    $applicant_personal_mess =   $g->applicant_personal_mess;
                    echo ($applicant_personal_mess!= '') ? $applicant_personal_mess: 'N/A' ;
                    ?></div>
                </div>
                <div class="media-right media-middle text-nowrap">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>assets/images/menu.png" alt=""></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url().'applicants-profile/'.$u->username; ?>">View</a></li>
                    </ul>                                               
                </div>
            </li>
        <?php endforeach; ?>



    </ul>

</div>
</div>
</div>
</section>

