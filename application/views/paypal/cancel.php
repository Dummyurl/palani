<?php if($this->session->userdata('applicant_id') != '' && $this->session->userdata('type') != ''){
 $this->load->view('home/guru/header'); 
} ?>
<div class="row">
    <div class="col-md-12">
    	<p>Dear Member,<br />We are sorry! Your last transaction was cancelled.</p>
    	<p><?php echo $this->session->userdata('curl_error_msg'); ?></p>
    </div>
</div>
<?php if($this->session->userdata('applicant_id') != '' && $this->session->userdata('type') != ''){
    $this->load->view('home/guru/footer');
    
} ?>
