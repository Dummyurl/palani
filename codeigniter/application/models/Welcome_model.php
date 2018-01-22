<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}
	Public function insert($data)
	{

		 $this->db->insert('test',$data);
		 return $this->db->insert_id();
	}

	Public function get_data()
	{
		return $this->db->select('id')
						->get('test')
						->result_array();
	}

}

/* End of file  */
/* Location: ./application/models/ */