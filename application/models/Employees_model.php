<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees_model extends CI_Model {

	public function insert_employees($data){
		return insert('login_details',$data);
	}
	public function update_employees($data){
		$where = array('login_id' => $_POST['login_id']);
		$this->db->update('login_details',$data,$where);
		return $where;
	}
	public function check_exist_email(){
		$where = array('status' => 1 ,'email' => $_POST['email']);
		if(!empty($_POST['login_id'])){
			$where +=array('login_id !='=>$_POST['login_id']);
		}
		return $this->db->get_where('login_details',$where)->num_rows();
	}

	 // Fetch records
	public function getData($count_or_record,$limit) {   

		$this->db->select('d.designation_name,d.designation_id,dp.department_id,dp.department_name,
			l.first_name,l.last_name,l.employee_id,l.email,l.phone_number,l.joining_date,l.company,l.login_id');
		$this->db->where('l.status',1);

		if(!empty($_POST['employee_id'])){
			$this->db->where('l.employee_id',$_POST['employee_id']);
		}		
		if(!empty($_POST['designation'])){
			$this->db->where('d.designation_id',$_POST['designation']);
		}
		
		if(!empty($_POST['employee_name'])){
			$this->db->like('l.first_name',$_POST['employee_name']);
			$this->db->or_like('l.last_name',$_POST['employee_name']);
		}


		$this->db->join('designation_details d','d.designation_id = l.designation_id');
		$this->db->join('department_details dp','d.department_id = dp.department_id');
		
		if(!empty($_POST['pageno'])){
			$rowno = $_POST['pageno'];	
		}else{
			$rowno = 0;
		}

		if($count_or_record == 1){
		$page = $_POST['pageno'];
			if($page>=1){
				$page = $page - 1 ;
			}		
			$page =  ($page * $limit);
		}

		if($count_or_record == 1){
			$this->db->limit($limit,$page);
			$this->db->order_by('l.login_id','desc');
			return $this->db->get('login_details l')->result_array(); 
		} else{
			return $this->db->get('login_details l')->num_rows(); 
		}
	}

	public function get_designation_names(){
		$this->db->select('d.designation_name,d.designation_id');   
		$this->db->join('designation_details d','d.designation_id = l.designation_id');    		
		$this->db->order_by('l.login_id','desc');
		$this->db->group_by('l.designation_id');
		$this->db->where('l.status',1);
		return $this->db->get('login_details l')->result_array();

	}
  // Select total records
	public function getrecordCount() {
		$this->db->select('count(*) as allcount');		
		$this->db->where('l.status',1);
		
		if(!empty($_POST['employee_id'])){
			$this->db->where('l.employee_id',$_POST['employee_id']);
		}		
		if(!empty($_POST['designation_id'])){
			$this->db->where('d.designation_id',$_POST['designation_id']);
		}
		
		if(!empty($_POST['employee_name'])){
			$this->db->where('l.first_name',$_POST['employee_name']);
			$this->db->or_where('l.last_name',$_POST['employee_name']);
		}

		$this->db->join('designation_details d','d.designation_id = l.designation_id');
		$query = $this->db->get('login_details l');
		$result = $query->result_array(); 
		return $result[0]['allcount'];
	}
	public function get_employee_by_id(){
		$where = array('login_id' => $_POST['login_id']);
		return $this->db->select('decrypted,department_id,designation_id,login_id,first_name,last_name,user_name,email,employee_id,joining_date,phone_number,company')->get_where('login_details',$where)->row_array();
	}
	public function get_designation_by_id($department_id){
		$where = array('department_id' => $department_id);
		return $this->db->select('designation_id,designation_name')->get_where('designation_details',$where)->result_array();
	}
		public function get_department_by_id($department_id){
		$where = array('department_id' => $department_id);
		return $this->db->select('designation_id,designation_name')->get_where('designation_details',$where)->result_array();
	}
	
	private function _get_datatables_query()
	{
		$columns = array(
			'first_name',
			'last_name',
			'user_name',
			'email',
			'employee_id',
			'joining_date',
			'phone_number',
			'company'
		);
		$search_value = (!empty($_POST['search']['value']))?trim($_POST['search']['value']):'';
		$login_id = $this->session->userdata('login_id');
		$sql ="SELECT * FROM login_details  WHERE login_id !=  $login_id ";
		if(!empty($search_value)){ 
			$sql .=" AND ( 
			first_name LIKE '%$search_value%',
			last_name LIKE '%$search_value%',
			user_name LIKE '%$search_value%',
			email LIKE '%$search_value%',
			employee_id LIKE '%$search_value%',
			joining_date LIKE '%$search_value%',
			phone_number LIKE '%$search_value%',
			company LIKE '%$search_value%'
		) ";		
	} 				
	$sql .=" ORDER BY login_id DESC";
	return $sql;
}
public function get_all_employees()
{
	$sql = $this->_get_datatables_query();			
		// if($_POST['length'] != -1)
		// 	$limits = $_POST['start'].','.$_POST['length'];
		// $sql .=" LIMIT $limits"; 		
	$sql .=" LIMIT 10"; 		
	return $this->db->query($sql)->result();	
}	
public function count_filtered()
{
	$sql = $this->_get_datatables_query();	
	return $this->db->query($sql)->num_rows();		
}
public function count_all()
{
	$sql = $this->_get_datatables_query();			
	return $this->db->query($sql)->num_rows();
}
public function change_role()
{
	$where = array('login_id' => $_POST['login_id']);
	$data = array('designation_id' => $_POST['designation_id']);
	return $this->db->update('login_details',$data,$where);
}
public function delete_employee()
{
	$where = array('login_id' => $_POST['login_id']);
	$data = array('status' => 0);
	return $this->db->update('login_details',$data,$where);
}

}

/* End of file Employees_model.php */
/* Location: ./application/models/Employees_model.php */