<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Applicant_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	private function _get_datatables_query()
	{
		

		$columns = array(
			'a.first_name',			
			'a.created_date',
			'p.payment_gross',
			'p.payment_id',
			'a.delete_sts'			
		);


		$search_value = trim($_POST['search']['value']);

		if(strpos($search_value,'-')){
			$search_value = date('Y-m-d',strtotime($search_value));
		}else if(strpos($search_value,':')){
			$search_value = date('h:i:s',strtotime($search_value));
		}


		$sql ="SELECT a.*,SUM(payment_gross) as earned,COUNT(p.payment_id)	as calls,a.created_date,a.delete_sts,	 
		a.username as applicant_user_name,		
		a.profile_img as applicant_profile_img,
		CONCAT(a.first_name,' ',a.last_name) AS applicant_name,		
		s.picture_url as applicant_picture 	
		FROM applicants a 
		LEFT JOIN payments p ON a.id = p.user_id	 	
		LEFT JOIN social_applicant_user s ON s.reference_id = a.id
		WHERE a.role = 0 ";



		if($search_value == 'Active'){
			$sql .='AND a.delete_sts = 0 ';
		}
		elseif($search_value == 'Inactive'){
			$sql .='AND a.delete_sts = 1 ';
		}
		else{

			if($_POST['search']['value']){ 


				 $sql .=" AND (
				 	a.first_name LIKE '%$search_value%'				 		
					OR a.last_name LIKE '%$search_value%'														
					OR a.created_date LIKE '%$search_value%'									
					OR a.delete_sts LIKE '%$search_value%'									
					OR p.payment_gross LIKE '%$search_value%'	
					OR p.payment_id LIKE '%$search_value%' 
					OR p.mentor_id LIKE '%$search_value%'
												
				 ) ";	
					
			} 		
		}

		$sql .=" GROUP BY a.id ";

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
	function get_datatables()
	{
		$sql = $this->_get_datatables_query();			
		if($_POST['length'] != -1)
			$limits = $_POST['start'].','.$_POST['length'];
		$sql .=" LIMIT $limits";		
		return $this->db->query($sql)->result();	
	}


	
	function count_filtered()
	{
		$sql = $this->_get_datatables_query();	
		return $this->db->query($sql)->num_rows();		
	}
	public function count_all()
	{
		$sql = $this->_get_datatables_query();			
		return $this->db->query($sql)->num_rows();
	}

	
	Public function get_applicant_details()
	{

		$id = base64_decode($this->uri->segment(3));
		return $this->db->query("SELECT a.*,SUM(payment_gross) as earned,COUNT(p.payment_id) as calls,a.created_date,a.delete_sts,	 
		a.username as applicant_user_name,		
		a.profile_img as applicant_profile_img,
		CONCAT(a.first_name,' ',a.last_name) AS applicant_name,		
		s.picture_url as applicant_picture 	
		FROM applicants a 
		LEFT JOIN payments p ON a.id = p.user_id	 	
		LEFT JOIN social_applicant_user s ON s.reference_id = p.user_id  	
		WHERE  a.id = '$id' ")->row();
	}


	private function _get_datatables_query_a()
	{	

		$columns = array(
			'a.first_name',			
			'a.created_date',
			'p.payment_gross',
			'p.payment_id',
			'a.delete_sts'			
		);


		$search_value = trim($_POST['search']['value']);

		if(strpos($search_value,'-')){
			$search_value = date('Y-m-d',strtotime($search_value));
		}else if(strpos($search_value,':')){
			$search_value = date('h:i:s',strtotime($search_value));
		}


		$sql ="SELECT a.*,p.payment_date,p.payment_status,SUM(payment_gross) as earned,COUNT(p.payment_id)as calls,a.delete_sts, a.username as applicant_user_name,a.profile_img as applicant_profile_img,CONCAT(a.first_name,' ',a.last_name) AS applicant_name,s.picture_url as applicant_picture FROM applicants a LEFT JOIN payments p ON a.id = p.mentor_id LEFT JOIN social_applicant_user s ON s.reference_id = p.mentor_id WHERE a.role = '1' AND p.user_id = '$_POST[user_id]' ";



		if($search_value == 'Completed'){
			$sql .='AND p.payment_status = 1 ';
		}
		elseif($search_value == 'Cancelled'){
			$sql .='AND p.payment_status = 2 ';
		}
		elseif($search_value == 'Pending'){
			$sql .='AND p.payment_status = 3 ';
		}else{

			if($_POST['search']['value']){ 


				 $sql .=" AND (
				 	a.first_name LIKE '%$search_value%'				 		
					OR a.last_name LIKE '%$search_value%'														
					OR p.payment_date LIKE '%$search_value%'									
					OR a.delete_sts LIKE '%$search_value%'									
					OR p.payment_gross LIKE '%$search_value%'	
					OR p.payment_id LIKE '%$search_value%' 
					OR p.user_id LIKE '%$search_value%'
												
				 ) ";	
					
			} 		
		}

		$sql .=" GROUP BY p.payment_date ";

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
	function get_datatables_a()
	{
		$sql = $this->_get_datatables_query_a();			
		if($_POST['length'] != -1)
			$limits = $_POST['start'].','.$_POST['length'];
		$sql .=" LIMIT $limits";		
		return $this->db->query($sql)->result();	
	}
	
	function count_filtered_a()
	{
		$sql = $this->_get_datatables_query_a();	
		return $this->db->query($sql)->num_rows();		
	}
	public function count_all_a()
	{
		$sql = $this->_get_datatables_query_a();			
		return $this->db->query($sql)->num_rows();
	}

}

/* End of file  */
/* Location: ./application/models/ */