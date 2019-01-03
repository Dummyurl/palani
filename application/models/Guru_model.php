<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guru_model extends CI_Model {

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
		a.username as mentor_user_name,		
		a.profile_img as mentor_profile_img,
		CONCAT(a.first_name,' ',a.last_name) AS mentor_name,		
		s.picture_url as mentor_picture 	
		FROM applicants a 
		LEFT JOIN payments p ON a.id = p.mentor_id	 	
		LEFT JOIN social_applicant_user s ON s.reference_id = p.mentor_id  	
		WHERE a.role = 1 ";



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


	Public function get_total_earned()
{
	$id = base64_decode($this->uri->segment(3));
    $where = array('mentor_id'=>$id,'payment_status'=>1);
    return $this->db->select('SUM(payment_gross) as earned_amount')->get_where('payments',$where)->row_array();
    
}
Public function get_total_requested()
{
	$id = base64_decode($this->uri->segment(3));
    $where = array('mentor_id'=>$id,'status'=>1);
    return $this->db->select('SUM(request_amount) as request_amount')->get_where('pay_request_details',$where)->row_array();
    
}
Public function get_total_paid()
{
	$id = base64_decode($this->uri->segment(3));
    $where = array('mentor_id'=>$id,'status'=>2);
    return $this->db->select('SUM(request_amount) as paid_amount')->get_where('pay_request_details',$where)->row_array();
    
}

	Public function get_guru_details()
	{

		$id = base64_decode($this->uri->segment(3));
		return $this->db->query("SELECT a.*,COUNT(p.payment_id)	as calls,a.created_date,a.delete_sts,	 
		a.username as mentor_user_name,		
		a.profile_img as mentor_profile_img,
		CONCAT(a.first_name,' ',a.last_name) AS mentor_name,		
		s.picture_url as mentor_picture 	
		FROM applicants a 
		LEFT JOIN payments p ON a.id = p.mentor_id	 	
		LEFT JOIN social_applicant_user s ON s.reference_id = p.mentor_id  	
		WHERE a.role = 1 AND a.id = '$id' ")->row();
	}


	private function _get_datatables_query_g()
	{	

		$columns = array(
					'i.invite_time',
					'i.invite_end_time',
					'p.payment_gross',
					'a.first_name',
					'a.last_name'	,
		);


		$search_value = trim($_POST['search']['value']);

		if(strpos($search_value,'-')){
			$search_value = date('Y-m-d',strtotime($search_value));
		}else if(strpos($search_value,':')){
			$search_value = date('h:i:s',strtotime($search_value));
		}


			$sql ="SELECT 
			a.id,
			a.username,
			i.invite_date,
			i.invite_time,
			i.invite_end_time,
			p.payment_gross,
			a.first_name,
			a.last_name,
			a.profile_img,
			s.picture_url,
			p.payment_status 
			FROM payments p 
			LEFT JOIN invite i ON i.invite_id = p.invite_id
			LEFT JOIN applicants a ON a.id = i.invite_from
			LEFT JOIN social_applicant_user  s ON a.id = s.reference_id
			WHERE i.invite_to = '$_POST[user_id]' ";



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
						 i.invite_time  LIKE '%$search_value%' 
						OR i.invite_end_time LIKE '%$search_value%' 
						OR p.payment_gross LIKE '%$search_value%' 
						OR a.first_name LIKE '%$search_value%' 
						OR a.last_name LIKE '%$search_value%' 
						OR a.profile_img LIKE '%$search_value%' 
						OR s.picture_url LIKE '%$search_value%' 		 	
												
				 ) ";	
					
			} 		
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
	function get_datatables_g()
	{
		$sql = $this->_get_datatables_query_g();			
		if($_POST['length'] != -1)
			$limits = $_POST['start'].','.$_POST['length'];
		$sql .=" LIMIT $limits";		
		return $this->db->query($sql)->result();	
	}
	
	function count_filtered_g()
	{
		$sql = $this->_get_datatables_query_g();	
		return $this->db->query($sql)->num_rows();		
	}
	public function count_all_g()
	{
		$sql = $this->_get_datatables_query_g();			
		return $this->db->query($sql)->num_rows();
	}

}

/* End of file  */
/* Location: ./application/models/ */