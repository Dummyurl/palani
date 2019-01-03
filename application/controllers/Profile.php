<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Profile_model','profile');
	}

	/*PROFILE PAGE */
	public function index()
	{
		
		$data['profile'] = $this->profile->get_profile_data();
		$data['title'] = 'Profile';	
		render_page('profile',$data);
	}

	/*EDIT PAGE */
	public function edit(){
		$data['profile'] = $this->profile->get_profile_data();
		$data['title'] = 'Edit Profile';		
		render_page('edit_profile',$data);
	}

	/*UPLOAD PROFILE IMAGE */
	Public function upload_profile_img(){
		
		$path = "uploads/";
		if(!is_dir($path)){
			mkdir($path);
		}
		$target_file =$path . basename($_FILES["file"]["name"]);
		$file_type = pathinfo($target_file,PATHINFO_EXTENSION);
		if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif" ){
			$type = 'others';
		}else{
			$type = 'image';
		}

		$config['upload_path']   = './'.$path;
		$config['allowed_types'] = '*';     
		$this->load->library('upload',$config);

		if($this->upload->do_upload('file')){  
			$file_name=$this->upload->data('file_name');  
		}
		$data = array('profile_img' => $file_name);
		$this->db->update('login_details',$data,array('login_id'=>$this->session->userdata('login_id')));
		
		echo json_encode($data);

	}

}

/* End of file  */
/* Location: ./application/controllers/ */