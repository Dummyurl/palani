<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();		
	}
	public function check_login(){
		$result = $this->check_username();
		if(count($result)==0){
			$response = array('invalid_username' => 1 ,'error' => 'Enter valid username or email');
		}else{
			$password = md5(trim($_POST['password']));
			$result = $this->check_password($_POST['user_name'],$password);
			if(count($result) == 0){
				$response = array('invalid_password'=>1,'error' => 'Enter valid username or email');	
			}else{
				$this->session->set_userdata($result);
				$this->db->update('login_details',array('online_status'=>1),array('login_id'=>$this->session->userdata('login_id')));
				$this->get_default_language_data();
				$this->get_default_company_data();
				$this->get_default_theme_data();
				$this->get_default_localize_data();
				$response = $result;	
			}						
		}	
		return json($response);

	}
	public function check_username(){
		$this->db->where('user_name',$_POST['user_name']);
		$this->db->or_where('email',$_POST['user_name']);
		return $this->db->get('login_details')->row_array();
	}
	public function check_password($user_name,$password){
		$this->db->select('login_id,user_name,email,type,sinch_username,first_name,last_name,profile_img');
		$this->db->where('password',$password);
		$this->db->where('user_name',$user_name);
		$this->db->or_where('email',$_POST['user_name']);
		return $this->db->get('login_details')->row_array();
	}

	/*Gettings Default Language Data*/
	Public function get_default_language_data(){

		$default_lang = $this->session->userdata('default_lang');	

		if(empty($default_lang)){ /*Default language is empty */
			$where = array('l.lang_id'=>1);
		}else{
			$where = array('l.status'=>1,'l.lang_id'=>$default_lang); /*Default Language selected*/
		}	

		$output = $this->db
		->select('l.lang,l.lang_id,lb.label_key,lb.label_value')
		->join('label_details lb','lb.lang_id = l.lang_id')
		->get_where('lang_details l',$where)
		->result_array();

		$this->session->set_userdata(array('label_data'=>$output));	
	}
	/*Gettings Default Company Data*/
	Public function get_default_company_data(){

		$where = array('status'=>1);
		$output = $this->db->get_where('company_details',$where)->row_array();
		$this->session->set_userdata($output);	
	}
	/*Gettings Default Theme Data*/
	Public function get_default_theme_data(){

		$where = array('status'=>1);
		$output = $this->db->get_where('theme_details',$where)->row_array();
		$this->session->set_userdata($output);	
	}
	/*Gettings Default Theme Data*/
	Public function get_default_localize_data(){

		$where = array('status'=>1);
		$output = $this->db->get_where('localization_details',$where)->row_array();
		$this->session->set_userdata($output);	
	}

}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */