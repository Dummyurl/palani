             
<div class="row titlerow">
 <div class="col-sm-6">
     <h2><?php echo $guru->mentor_name; ?></h2>
 </div>
 <div class="col-sm-6 text-right"><a class="btn btn-default" onclick="history.back();"><i aria-hidden="true" class="fa fa-angle-left"></i> Back</a></div>
</div>

<?php 
            if($guru->mentor_profile_img!=''){ // Getting profile image from applicant table for mentor 

                $mentor_img = $guru->mentor_profile_img;
                $file_to_check = FCPATH . '/assets/images/' . $mentor_img;
                if (file_exists($file_to_check)) {
                    $mentor_img = base_url() . 'assets/images/'.$mentor_img;
                }
                $mentor_img = ($mentor_img != '') ? $mentor_img : base_url() . 'assets/images/default-avatar.png';

          }else if($guru->mentor_picture!=''){ // Getting profile image from social table for mentor 
            $mentor_img = $guru->mentor_picture;
        }else{
            $mentor_img = base_url() . 'assets/images/default-avatar.png';
        }  


          if($guru->delete_sts == 0){ // Active 
            $status = '<span class="label label-success">Active</span>'; 
          } else if($guru->delete_sts == 1){ // Inactive 
            $status= '<span class="label label-danger">Inactive</span>';
        }  

        ?>

        <div class="row titlerow">
         <div class="col-sm-5">
             <div class="row">
                 <div class="col-md-6"><img src="<?php echo $mentor_img; ?>" class="img-responsive img-circle"></div>
                 <div class="col-md-6">
                     <p><span class="spa_greytext">Member Since:</span><br><?php  echo date('d-m-Y',strtotime($guru->created_date)); ?></p>
                     <p><span class="spa_greytext">Total Calls:</span><br><?php echo ($guru->calls)?$guru->calls:0; ?></p>
                     <p><span class="spa_greytext">Account Status:</span><br><?php echo $status; ?></p>
                 </div>
             </div>
         </div>
         <div class="col-sm-7">
             <div class="row">
                 <div class="col-sm-4 spa_earned"><span>$<?php echo ($guru->earned)?$guru->earned:'0.00'; ?></span>Earned</div>
                 <div class="col-sm-4 spa_paid"><span>$4,000</span>Paid</div>
                 <div class="col-sm-4 spa_balance"><span>$2,800</span>Balance</div>
                 <div class="col-lg-12 spa_paynow"><a class="btn btn-primary">Pay Now</a></div>
             </div>
         </div>
     </div>        

     <input type="hidden" name="user_id" id="user_id" value="<?php echo base64_decode($this->uri->segment(3)); ?>">
     <div class="spa_conversations">
        <table id="datatable" class="table table-striped" >
            <thead>
                <tr>
                    <th>Applicant Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Duration</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td><a href="#"><img src="<?php echo base_url(); ?>assets/images/profilepic1.png"> Sophia Amalia</a></td>
                    <td><span class="spa_greytext">13/06/2017</span></td>
                    <td>12:00 AM</td>
                    <td>2 hours</td>
                    <td><strong>$24.00</strong></td>
                    <td><span class="label label-success">Completed</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</section>