<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}


	private function _get_datatables_query()
	{
		

		$columns = array(
			'payment_id',
			'user_id',
			'mentor_id',
			'payment_gross',
			'currency_code',
			'payer_email',
			'payment_status',
			'payment_date',
		);


		$search_value = trim($_POST['search']['value']);

		if(strpos($search_value,'-')){
			$search_value = date('Y-m-d',strtotime($search_value));
		}else if(strpos($search_value,':')){
			$search_value = date('h:i:s',strtotime($search_value));
		}


		$sql ="SELECT p.*,		
		a.username as mentor_user_name,
		a1.username as applicant_user_name,
		a.profile_img as mentor_profile_img,a1.profile_img as applicant_profile_img,
		CONCAT(a.first_name,' ',a.last_name) AS mentor_name,
		CONCAT(a1.first_name,' ',a1.last_name) AS applicant_name,
		s.picture_url as mentor_picture,
		s1.picture_url as applicant_picture,
		i.approved,i.invite_date,i.invite_time,i.invite_end_time,i.time_zone
		FROM payments p
		LEFT JOIN applicants a ON a.id = p.mentor_id
		LEFT JOIN applicants a1 ON a1.id = p.user_id
		LEFT JOIN social_applicant_user s ON s.reference_id = a.id
		LEFT JOIN social_applicant_user s1 ON s1.reference_id = a1.id
		LEFT JOIN invite i ON i.invite_id = p.invite_id		
		WHERE p.payment_id != ''  ";



		if($search_value == 'Approved'){
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
					OR a1.first_name LIKE '%$search_value%'
					OR a1.last_name LIKE '%$search_value%'
					OR payment_id LIKE '%$search_value%' 
					OR user_id LIKE '%$search_value%'
					OR mentor_id LIKE '%$search_value%'
					OR txn_id LIKE '%$search_value%'
					OR payment_gross LIKE '%$search_value%'
					OR currency_code LIKE '%$search_value%'
					OR payer_email LIKE '%$search_value%'
					OR payment_status LIKE '%$search_value%'
					OR payment_date LIKE '%$search_value%'
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



	Public function get_gurus()
	{
		
		return $this->db->query("SELECT CONCAT(a.first_name,' ',a.last_name) AS name,
			m.mentor_job_title,s.picture_url, a.profile_img,a.id,a.username
			FROM applicants a
			LEFT JOIN mentor_details m ON m.mentor_id = a.id
			LEFT JOIN social_applicant_user s ON s.reference_id = a.id
			WHERE a.delete_sts = 0 AND a.role = 1
			ORDER BY a.id DESC
			LIMIT 5 ")->result();
	}
	Public function get_users()
	{
		return $this->db->query("SELECT CONCAT(a.first_name,' ',a.last_name) AS name,
			m.applicant_personal_mess,s.picture_url, a.profile_img,a.id,a.username
			FROM applicants a
			LEFT JOIN applicants_profile m ON m.applicant_id = a.id
			LEFT JOIN social_applicant_user s ON s.reference_id = a.id
			WHERE a.delete_sts = 0 AND a.role = 0
			ORDER BY a.id DESC
			LIMIT 5 ")->result();
	}

	




}

/* End of file  */
/* Location: ./application/models/ */