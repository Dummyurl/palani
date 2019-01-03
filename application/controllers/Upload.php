<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->time_zone = $this->session->userdata('time_zone');
		date_default_timezone_set($this->time_zone);		
	}





	// public function upload_filess()
	// {

	// 	$user_id = $this->session->userdata('applicant_id');		

	// 	$target_dir = "msg_uploads/".$user_id;
	// 	if(!is_dir($target_dir)){
	// 		mkdir($target_dir);
	// 	}

	// 	$target_file =$target_dir . basename($_FILES["userfile"]["name"]);
	// 	$file_type = pathinfo($target_file,PATHINFO_EXTENSION);

	// 	if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file)) {
	// 		$data['status'] =  "The file ". basename( $_FILES["userfile"]["name"]). " has been uploaded.";
	// 	} else {
	// 		$data['error'] =  $_FILES['userfile']['error'];
	// 	}		

	// 	echo json_encode($data);
	// }
	public function upload_files()
	{

		ob_flush();
		$user_id = $this->session->userdata('applicant_id');		

		$path = "msg_uploads/".$user_id;
		if(!is_dir($path)){
			mkdir($path);
		}

		$target_file =$path . basename($_FILES["userfile"]["name"]);
		$file_type = pathinfo($target_file,PATHINFO_EXTENSION);

		if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif" ){
			$type = 'others';
		}else{
			$type = 'image';
		}


		$config['upload_path']   = './'.$path;
		$config['allowed_types'] = '*';		
		$this->load->library('upload',$config);

		if($this->upload->do_upload('userfile')){			

			
			$file_name=$this->upload->data('file_name');		
			$data = array(
				'recieved_id' =>$_POST['to_user_id'],
				'sent_id' => $this->session->userdata('applicant_id'),
				'msg' =>'file',
				'file_name'=>$file_name,		
				'chatdate' => date('Y-m-d H:i:s'),
				'type' =>$type,
				'read_status' =>0,
				'time_zone' =>$this->session->userdata('time_zone'),
				'file_path' => $path				
			);			

			$result = $this->db->insert('chat',$data);
			$chat_id = $this->db->insert_id();
			$users = array($data['recieved_id'],$data['sent_id']);
			for ($i=0; $i <2 ; $i++) { 
				$datas = array('chat_id' =>$chat_id ,'can_view'=>$users[$i]);
				$this->db->insert('chat_deleted_details',$datas);
			}

			echo  json_encode(array('img'=>$path.'/'.$file_name,'type'=>$type,'file_name' => $file_name));
		}else{
			echo  json_encode(array('error'=>$this->upload->display_errors()));
		}
	}
	Public function delete_uploaded_files()
	{
		$token=$this->input->post('token');		
		$data=$this->db->get_where('chat',array('token'=>$token))->row();
		$can_view = $this->session->userdata('applicant_id');
		$chat_id = $data->id;
		$this->db->delete('chat_deleted_details',array('chat_id'=>$chat_id,'can_view'=>$can_view));
		echo json_encode(array('deleted'=>true));
		
	}

}

/* End of file  */
/* Location: ./application/controllers/ */