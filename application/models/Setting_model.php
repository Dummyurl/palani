<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		error_reporting(0);
		
	}

	Public function get_subjects(){			
		return $this->db->get_where('subject',array('status'=>1))->result();	
	}

	Public function _get_datatables_query(){
		
		//echo '<pre>'; print_r($_POST); exit;
		$columns = array('subject_id','subject');
		$search_value = trim($_POST['search']['value']);
		$sql ="SELECT * FROM subject WHERE status = 1 ";		
		if($_POST['search']['value']){ 
			$sql .=" AND  (	subject LIKE '%$search_value%' ) ";		
		}
		if(isset($_POST['order'])) {			
			$orde = $columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'];
			$sql .=" ORDER BY $orde";
		}else if(isset($this->orders)){
			$orders = $this->orders;	
			$orde = key($orders).' '.$orders[key($orders)];	
			$sql .=" ORDER BY $orde";
		}
		return $sql;
	}

	

	function get_all_subjects(){

		$sql = $this->_get_datatables_query();			
		if($_POST['length'] != -1)
			$limits = $_POST['start'].','.$_POST['length'];
		$sql .=" LIMIT $limits"; 		
		return $this->db->query($sql)->result();	
	}
	
	function count_all_subject()
	{
		$sql = $this->_get_datatables_query();	
		return $this->db->query($sql)->num_rows();		
	}
	public function count_all_filtered_subjects()
	{
		$sql = $this->_get_datatables_query();			
		return $this->db->query($sql)->num_rows();
	}

	Public function _get_datatables_course(){
		
		
		$columns = array('c.course_id','c.subject_id','c.course','s.subject');
		$search_value = trim($_POST['search']['value']);
		$sql ="SELECT c.course_id,c.subject_id,c.course,s.subject FROM courses c 
LEFT JOIN subject s ON s.subject_id = c.subject_id WHERE c.status = 1 ";


		if($_POST['search']['value']){ 
			$sql .=" AND  (	s.subject LIKE '%$search_value%'  OR c.course LIKE '%$search_value%') ";		
		}


		if(isset($_POST['order'])) {			
			$orde = $columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'];
			$sql .=" ORDER BY $orde";
		}else if(isset($this->orders)){
			$orders = $this->orders;	
			$orde = key($orders).' '.$orders[key($orders)];	
			$sql .=" ORDER BY $orde";
		}
		return $sql;
	}

	

	function get_all_courses(){

		$sql = $this->_get_datatables_course();			
		if($_POST['length'] != -1)
			$limits = $_POST['start'].','.$_POST['length'];
		$sql .=" LIMIT $limits"; 		
		return $this->db->query($sql)->result();	
	}
	
	function count_all_course()
	{
		$sql = $this->_get_datatables_course();	
		return $this->db->query($sql)->num_rows();		
	}
	public function count_all_filtered_course()
	{
		$sql = $this->_get_datatables_course();			
		return $this->db->query($sql)->num_rows();
	}

}

/* End of file  */
/* Location: ./application/models/ */