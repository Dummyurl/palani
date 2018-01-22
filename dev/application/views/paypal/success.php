<?php if($this->session->userdata('applicant_id') != '' && $this->session->userdata('type') != ''){
 $this->load->view('home/guru/header'); 
} ?>

<div class="payment_details">

	<h1>Thank you. We will process your request now.</h1>
    <p>Your payment was successful, thank you for choosing SchoolGuru.</p>
    <p>&nbsp;</p>
    <p>Now you can chat with our guru &nbsp;<a href="<?php echo base_url(); ?>messages" class="btn btn-primary">Go to Messages &nbsp;<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></p>
    <p>&nbsp;</p>

	<div class="row">
		<div class="col-md-6">Transaction ID</div>
		<div class="col-md-6"><?php echo $PAYMENTINFO_0_TRANSACTIONID; ?></div>
	</div>
    
    <div class="row">
		<div class="col-md-6">Fee Amount</div>
		<div class="col-md-6"><?php echo $PAYMENTINFO_0_FEEAMT; ?></div>
	</div>
    
    <div class="row">
		<div class="col-md-6">Amount Paid</div>
		<div class="col-md-6">$<?php echo $PAYMENTINFO_0_AMT.' '.$PAYMENTINFO_0_CURRENCYCODE; ?></div>
	</div>
    
    <div class="row">
		<div class="col-md-6">Payment Status</div>
		<div class="col-md-6"><?php echo $PAYMENTINFO_0_ACK; ?></div>
	</div>
    
</div>

<?php if($this->session->userdata('applicant_id') != '' && $this->session->userdata('type') != ''){
    $this->load->view('home/guru/footer');
} ?>
