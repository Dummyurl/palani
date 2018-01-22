<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Up extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('up');
	}

	Public function upload_updates()
	{
		
		$config['upload_path']          = 'mpdf';
		$config['allowed_types']        = '*';	

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('upload_file')){			
			$data['error'] = $this->upload->display_errors();
		}else{
			$data = array('upload_data' => $this->upload->data());
			
		}
		echo json_encode($data);
	}



}

/* End of file  */
/* Location: ./application/controllers/ */