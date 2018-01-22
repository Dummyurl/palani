<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Google_user_authentication extends CI_Controller
{
    function __construct() {
        parent::__construct();
        // Load user model
        $this->load->model('user');
    }
    
    public function index(){         
        // Include the google api php libraries
        include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
        include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
        
        // Google Project API Credentials
        $clientId = '81591662579-5o9s5snj301lsdjjfv7e5fqckmfkmq7f.apps.googleusercontent.com';
        $clientSecret = 'khsVJx100osdizmfHrnoHpeS';
        $redirectUrl = base_url() . 'google_user_authentication/';
        
        // Google Client Configuration
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to codexworld.com');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);

        if (isset($_REQUEST['code'])) {
            $gClient->authenticate();
            $this->session->set_userdata('token', $gClient->getAccessToken());
            redirect($redirectUrl);
        }

        $token = $this->session->userdata('token');
        if (!empty($token)) {
            $gClient->setAccessToken($token);
        }

        if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();
            // Preparing data for database insertion
            $userData['oauth_provider'] = 'google';
            $userData['oauth_uid'] = $userProfile['id'];
            $userData['register_type']  = $this->session->userdata('google_user_type');
            $userData['first_name'] = $userProfile['given_name'];
            $userData['last_name'] = $userProfile['family_name'];
			$userData['username'] = $this->generate_username($userData['first_name'].' '.$userData['last_name'], 10);
            $userData['email'] = $userProfile['email'];
            $userData['gender'] = $userProfile['gender'];
            $userData['locale'] = $userProfile['locale'];
            $userData['profile_url'] = $userProfile['link'];
            $userData['picture_url'] = $userProfile['picture'];
            // Insert or update user data
            $userID = $this->user_model->checkUser($userData);
            if(!empty($userID)){
                $data['userData'] = $userData;
                $this->session->set_userdata(array('applicant_id'=>$userID['id'],'role'=>$userID['role'],'type'=>$userID['type']));
                $this->session->set_userdata('userData',$userData);
                print_r('');
            } else {
               $data['userData'] = array();
            }
        } else {
            $data['authUrl'] = $gClient->createAuthUrl();
        }
        $this->load->view('google_user_authentication/index',$data);
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
        $this->session->unset_userdata('token');
        $this->session->unset_userdata('userData');
        $this->session->sess_destroy();
        redirect('/google_user_authentication');
    }
}