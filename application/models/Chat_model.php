<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}




	public function get_player_id($userid){
	
		$records = array();
    	 if(!empty($userid)){
    	 	$where = array('user_id' =>$userid,'status'=>1);
    	 	$query = $this->db->get_where('one_signal_device_details',$where);
        		if($query->num_rows() >0){
          			$records = $query->row_array();         
        			}
      		}
      	return $records;
    }





}

/* End of file  */
/* Location: ./application/models/ */