<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User_Authentication extends CI_Controller
{
    function __construct() {
		parent::__construct();
		
		// Load facebook library
		$this->load->library('facebook');
		
		//Load user model
		$this->load->model('user_model');
    }
    
    public function index(){
	    $userData = array();
		// Check if user is logged in
	    if($this->facebook->is_authenticated()){
			// Get user facebook profile details
	    $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');


        $image = "http://graph.facebook.com/".$userProfile['id']."/picture?width=800";
            // Preparing data for database insertion
            $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid'] = ($userProfile['id'] !='')? $userProfile['id']: " " ;
            $userData['register_type']  = "guru";
            $userData['first_name'] = ($userProfile['first_name'] !='')? $userProfile['first_name']: " " ;
            $userData['last_name'] = ($userProfile['last_name'] !='')? $userProfile['last_name']: " " ;
            $userData['email'] = ($userProfile['email'] !='')? $userProfile['email']: " " ;
            $userData['gender'] = ($userProfile['gender'] !='')? $userProfile['gender']: " " ;
            $userData['locale'] = ($userProfile['locale'] !='')? $userProfile['locale']: " " ;
            $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];            
            $userData['picture_url'] = ($image !='') ? $image : "";
			
            // Insert or update user data
            $userID = $this->user_model->checkUser($userData);
			
			// Check user data insert or update status
            if(!empty($userID)){
                $this->session->set_userdata(array('applicant_id'=>$userID));
                redirect(base_url().'user'."/dashboard");
            } else {
               $data['userData'] = array();
            }
			
			// Get logout URL
			$data['logoutUrl'] = $this->facebook->logout_url();
		}else{
            $fbuser = '';
			
			// Get login URL
            $data['authUrl'] =  $this->facebook->login_url();
        }
		
		// Load login & profile view
        $this->load->view('user_authentication/index',$data);
    }

	//generate a username from Full name
    function generate_username($string_name="", $rand_no = 200){
        $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
        $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part
    
        $part1 = (!empty($username_parts[0]))?substr($username_parts[0], 0,8):""; //cut first name to 8 letters
        $part2 = (!empty($username_parts[1]))?substr($username_parts[1], 0,5):""; //cut second name to 5 letters
        $part3 = ($rand_no)?rand(0, $rand_no):"";
        
        $username = $part1. str_shuffle($part2). $part3; //str_shuffle to randomly shuffle all characters 
        return $username;
    }
	
	public function logout() {
		// Remove local Facebook session
		$this->facebook->destroy_session();
		// Remove user data from session
		$this->session->unset_userdata('userData');
		// Redirect to login page
                redirect('/user_authentication');
    }
}
