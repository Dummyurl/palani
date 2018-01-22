<?php


 // Super Admin 
if($this->session->userdata('type')=='superadmin'){

	$this->load->view('home/superadmin/header'); 
	$this->load->view('home/superadmin/'.$module);
	$this->load->view('home/superadmin/footer'); 	
	exit;
}
// Other Users

if($this->session->userdata('applicant_id') != '' && $this->session->userdata('type') != ''){
	$this->load->view('home/guru/header'); 
}
$this->load->view('home/'.$theme.'/'.$module);

if($this->session->userdata('applicant_id') != '' && $this->session->userdata('type') != ''){ 
	$this->load->view('home/guru/footer'); 
}


?>
