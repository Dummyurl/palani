<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model {	

	public function __construct()
	{
		parent::__construct();
		$this->type = $this->session->userdata('type');
		
	}

	Public function _get_datatables_query(){		


		$id = $this->session->userdata('applicant_id');
		switch ($this->type) {
			case 'guru':
				$sql ="SELECT 
					   p.mentor_id,
					p.payment_id,
					p.request_date,
					p.request_amount,
					p.resolved_date,
					p.status,
					a.username,
					a.first_name,
					a.last_name,
					a.profile_img,
					s.picture_url
				
				 FROM pay_request_details p 
				LEFT JOIN social_applicant_user s ON p.mentor_id = s.reference_id
				LEFT JOIN applicants a ON p.mentor_id = a.id
				 WHERE mentor_id = $id";		
				break;
			
			case 'user':
				$sql ="SELECT 
				   p.mentor_id,
					p.payment_id,
					p.request_date,
					p.request_amount,
					p.resolved_date,
					p.status,
					a.username,
					a.first_name,
					a.last_name,
					a.profile_img,
					s.picture_url
				
				 FROM pay_request_details p 
				LEFT JOIN social_applicant_user s ON p.mentor_id = s.reference_id
				LEFT JOIN applicants a ON p.mentor_id = a.id
				 WHERE mentor_id = $id";		
				break;
			case 'superadmin':
				$sql ="SELECT 
				   p.mentor_id,
					p.payment_id,
					p.request_date,
					p.request_amount,
					p.resolved_date,
					p.status,
					a.username,
					a.first_name,
					a.last_name,
					a.profile_img,
					s.picture_url
				
				 FROM pay_request_details p 
				LEFT JOIN social_applicant_user s ON p.mentor_id = s.reference_id
				LEFT JOIN applicants a ON p.mentor_id = a.id
				 WHERE status != 0 ";		
				break;
		}
		
		$columns = array('p.payment_id','p.request_date','p.request_amount','p.resolved_date','a.first_name','p.status');
		$search_value = trim($_POST['search']['value']);

		
		if($_POST['search']['value']){ 
			$sql .=" AND  (	
			p.request_amount LIKE '%$search_value%'  OR				
			p.request_date LIKE '%$search_value%' OR
			p.request_amount LIKE '%$search_value%' OR
			p.resolved_date LIKE '%$search_value%' OR
			p.status LIKE '%$search_value%' OR
			a.username LIKE '%$search_value%' OR
			a.first_name LIKE '%$search_value%' OR
			a.last_name LIKE '%$search_value%' 
				
		) ";		
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

	function get_all_payments(){

		$sql = $this->_get_datatables_query();			
		if($_POST['length'] != -1)
			$limits = $_POST['start'].','.$_POST['length'];
		$sql .=" LIMIT $limits"; 		
		return $this->db->query($sql)->result();	
	}
	
	function count_all_payment()
	{
		$sql = $this->_get_datatables_query();	
		return $this->db->query($sql)->num_rows();		
	}
	public function count_all_filtered_payment()
	{
		$sql = $this->_get_datatables_query();			
		return $this->db->query($sql)->num_rows();
	}

}

/* End of file  */
/* Location: ./application/models/ */