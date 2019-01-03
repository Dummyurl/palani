		<div class="row titlerow">
			<div class="col-sm-6 col-xs-8">
				<h2><?php echo $guru->mentor_name; ?></h2>
			</div>
			<div class="col-sm-6 col-xs-4 text-right"><a class="btn btn-default" onclick="history.back();"><i aria-hidden="true" class="fa fa-angle-left"></i> Back</a></div>
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
		  				<p><span class="spa_greytext">Total Calls:</span><br><?php echo ($guru->calls)?$guru->calls:0; ?></p>
		  				<p><span class="spa_greytext">Account Status:</span><br><?php echo $status; ?></p>
		  			</div>
		  		</div>
		  	</div>

		  	<?php

		  	$total_earned = (!empty($earned['earned_amount'])?$earned['earned_amount']:'0.00');
		  	if($total_earned == '0.00'){
		  		$class_name = 'btn btn-default';
		  	}else{
		  		$class_name = 'btn btn-primary request_btn';
		  	}  
		  	
		  	$requested_amt = (!empty($requested['request_amount'])?$requested['request_amount']:'0.00');
		  	if($requested_amt > 0){
		  		$total_earned = $total_earned - $requested_amt;
		  	}             

		  	$paid_amt = $paid['paid_amount'];
		  	$paid_amt = (!empty($paid['paid_amount'])?$paid['paid_amount']:'0.00');               
		  	$balance_amt = $total_earned - $paid_amt;



		  	?>
		  	<div class="col-sm-7">
		  		<div class="row">
		  			<div class="col-sm-6 col-md-4 spa_earned"><span>$<?php echo $paid_amt; ?></span>Earned</div>
		  			<div class="col-sm-6 col-md-4 spa_paid"><span>$<?php echo $requested_amt; ?></span>Requested</div>
		  			<div class="col-sm-6 col-md-4 spa_balance"><span>$<?php echo $balance_amt.'.00'; ?></span>Balance</div>                  
		  		</div>
		  	</div>
		  </div>	


		  <input type="hidden" name="user_id" id="user_id" value="<?php echo base64_decode($this->uri->segment(3)); ?>">
		  <div class="spa_conversations">			 <div class="table-responsive">
		  	<table id="datatable" class="table table-striped" >
		  		<thead>
		  			<tr>
		  				<th>Mentee Name</th>
		  				<th>Date</th>
		  				<th>Time</th>							
		  				<th>Amount</th>
		  				<th>Status</th>
		  			</tr>
		  		</thead>
		  		
		  	</table>
		  </div>		</div>
		</div>
	</section>