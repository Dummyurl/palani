<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}
	Public function get_profile_data(){
		$where = array('login_id'=>$this->session->userdata('login_id'));
		return $this->db->get_where('login_details',$where)->row_array();
	}

}

/* End of file Profile_model.php */
/* Location: ./application/models/Profile_model.php */
