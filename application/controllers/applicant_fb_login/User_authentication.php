<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Include the autoloader provided in the SDK
require_once(APPPATH . '../vendor/autoload.php');

// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;


class User_Authentication extends CI_Controller
{
  function __construct() {
    parent::__construct();
		//Load user model
    $this->load->model('user_model');
    $this->facebook_app_id = $this->config->item('facebook_app_id');
    $this->facebook_app_secret = $this->config->item('facebook_app_secret');
    $this->facebook_graph_version = $this->config->item('facebook_graph_version');
  }

  Public function signup_facebook($userProfile){

    $user_type = $this->session->userdata('register_type');
    if($user_type == 'guru'){
      $role = 1;
    }else{
      $role = 0;
    }
          // Preparing data for database insertion
    $image = "http://graph.facebook.com/".$userProfile['id']."/picture?width=800";



      if(empty($userProfile['email'])){
        $this->session->set_flashdata('msg',"Your social network doesn't provide email id !");        
        redirect('signup'); 
      }
    $app_data = array(
      'type'  => $this->session->userdata('register_type'),
      'first_name' => $userProfile['first_name'],
      'last_name' => $userProfile['last_name'],
      'source' => 'facebook',
      'email' => $userProfile['email'],
      'username' => $this->generate_username($userProfile['first_name'].' '.$userProfile['last_name'], 10),
      'is_verified' => 1,
      'mobile_verified' =>0,
      'profile_updated' => 1,
      'role' => $role,
      'type' => $user_type,                  
      'created_date' => date("Y-m-d H:i:s"),
      'modified' => date("Y-m-d H:i:s")          
    );


    $this->db->insert('applicants',$app_data);
    $user_id = $this->db->insert_id(); 
    $data['reference_id'] = $user_id;
    $data['locale'] = $userProfile['locale'];
    $data['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
    $data['picture_url'] = ($image !='') ? $image : "";
    $data['oauth_provider'] = 'facebook';
    $data['oauth_uid'] = $userProfile['id'];       
    $this->db->insert('social_applicant_user',$data); 
    $session_data = array('applicant_id'=>$user_id,'role'=>$role,'type'=>$user_type);
    $this->session->set_userdata($session_data);  



    /* Blog Login */
        if($user_type == 'guru'){
            
            $this->load->library('bcrypt');        

        $results = $this->db->get_where('users',array('email'=>$userProfile['email']))->row_array();
        if(!empty($results)){

             //set user data
          $user_data = array(
              'inf_ses_id' =>$results['id'],
              'inf_ses_username' => $userProfile['first_name'].' '.$userProfile['last_name'],
              'inf_ses_email' => $userProfile['email'],
              'inf_ses_role' => 'author',
              'inf_ses_logged_in' => true,
              'inf_ses_app_key' => $this->config->item('app_key'),
          );
          $this->session->set_userdata($user_data);


      }else{


          $blog_data = array(
              'username' => $userProfile['first_name'].' '.$userProfile['last_name'], 
              'email' => $userProfile['email'],        
              'role' => 'author', 
              'status' =>1
          );
          $this->db->insert('users',$blog_data);  
          $blog_id = $this->db->insert_id();
    //set user data
          $user_data = array(
              'inf_ses_id' =>$blog_id,
              'inf_ses_username' => $blog_data['username'],
              'inf_ses_email' => $blog_data['email'],
              'inf_ses_role' => 'author',
              'inf_ses_logged_in' => true,
              'inf_ses_app_key' => $this->config->item('app_key'),
          );
          $this->session->set_userdata($user_data);
        }
        }

      /* Blog Login */ 

    redirect('welcome/profile_settings');
  }




  public function index(){

$redirectURL   = base_url().'applicant_fb_login/user_authentication'; //Callback URL
$fbPermissions = array('email');  //Optional permissions

$fb = new Facebook(array(
  'app_id' => $this->facebook_app_id,
  'app_secret' => $this->facebook_app_secret,
  'default_graph_version' => $this->facebook_graph_version,
));

$userData = array();
$helper = $fb->getRedirectLoginHelper();

      // Try to get access token
try {
 $accessToken = $helper->getAccessToken(); 

} catch(FacebookResponseException $e) { 
  $this->session->set_flashdata('msg','Graph returned an error: ' . $e->getMessage());             
  redirect('signup');  
} catch(FacebookSDKException $e) {
 $this->session->set_flashdata('msg','Facebook SDK returned an error: ' . $e->getMessage());             
 redirect('signup');    
}



if(!empty($_SESSION['facebook_access_token'])){
  $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
}else{
        // Put short-lived access token in session
  $_SESSION['facebook_access_token'] = (string) $accessToken;

          // OAuth 2.0 client handler helps to manage access tokens
  $oAuth2Client = $fb->getOAuth2Client();

        // Exchanges a short-lived access token for a long-lived one
  $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
  $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

        // Set default access token to be used in script
  $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
}

    // Getting user facebook profile info
try {
  $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,picture');
  $userProfile = $profileRequest->getGraphNode()->asArray();

} catch(FacebookResponseException $e) {
  session_destroy();        
  $this->session->set_flashdata('msg','Graph returned an error: ' . $e->getMessage());             
  redirect('signup');     

} catch(FacebookSDKException $e) {

  $this->session->set_flashdata('msg','Facebook SDK returned an error: ' . $e->getMessage());        
  redirect('signup');  
}

if(!empty($userProfile)){            
  $result = $this->db->get_where('applicants',array('email'=>$userProfile['email']))->row_array();        
  /* Check Registering or Login */
  if(!empty($this->session->userdata('register_type'))){ /* Signup */
    if(!empty($result)){
      if($result['source'] == 'facebook'){ 
        $session_data = array('applicant_id'=>$result['id'],'role'=>$result['role'],'type'=>$result['type']);
        $this->session->set_userdata($session_data); 



         /* Blog Login */
        if($result['type'] == 'guru'){
            
            $this->load->library('bcrypt');        

        $results = $this->db->get_where('users',array('email'=>$result['email']))->row_array();
        if(!empty($results)){

             //set user data
          $user_data = array(
              'inf_ses_id' =>$result['id'],
              'inf_ses_username' => $userProfile['first_name'].' '.$userProfile['last_name'],
              'inf_ses_email' => $userProfile['email'],
              'inf_ses_role' => 'author',
              'inf_ses_logged_in' => true,
              'inf_ses_app_key' => $this->config->item('app_key'),
          );
          $this->session->set_userdata($user_data);


      }else{


          $blog_data = array(
              'username' => $userProfile['first_name'].' '.$userProfile['last_name'], 
              'email' => $userProfile['email'],        
              'role' => 'author', 
              'status' =>1
          );
          $this->db->insert('users',$blog_data);  
          $blog_id = $this->db->insert_id();
    //set user data
          $user_data = array(
              'inf_ses_id' =>$blog_id,
              'inf_ses_username' => $blog_data['username'],
              'inf_ses_email' => $blog_data['email'],
              'inf_ses_role' => 'author',
              'inf_ses_logged_in' => true,
              'inf_ses_app_key' => $this->config->item('app_key'),
          );
          $this->session->set_userdata($user_data);
        }
        }

      /* Blog Login */ 

        redirect('dashboard');
      }else{
       $this->session->set_flashdata('msg','Email already registered! Try other email!');        
       redirect('signup');  
     }          
   }else{
    $this->signup_facebook($userProfile);          
  }  

}else{ /* Login */

 if(!empty($result)){
  /* Same Email Id Same source */
  if($result['source'] == 'facebook'){
    $session_data = array('applicant_id'=>$result['id'],'role'=>$result['role'],'type'=>$result['type']);
    $this->session->set_userdata($session_data);   





    /* Blog Login */
        if($result['type'] == 'guru'){
            
            $this->load->library('bcrypt');        

        $results = $this->db->get_where('users',array('email'=>$result['email']))->row_array();
        if(!empty($results)){

             //set user data
          $user_data = array(
              'inf_ses_id' =>$result['id'],
              'inf_ses_username' => $userProfile['first_name'].' '.$userProfile['last_name'],
              'inf_ses_email' => $userProfile['email'],
              'inf_ses_role' => 'author',
              'inf_ses_logged_in' => true,
              'inf_ses_app_key' => $this->config->item('app_key'),
          );
          $this->session->set_userdata($user_data);


      }else{


          $blog_data = array(
              'username' => $userProfile['first_name'].' '.$userProfile['last_name'], 
              'email' => $userProfile['email'],        
              'role' => 'author', 
              'status' =>1
          );
          $this->db->insert('users',$blog_data);  
          $blog_id = $this->db->insert_id();
    //set user data
          $user_data = array(
              'inf_ses_id' =>$blog_id,
              'inf_ses_username' => $blog_data['username'],
              'inf_ses_email' => $blog_data['email'],
              'inf_ses_role' => 'author',
              'inf_ses_logged_in' => true,
              'inf_ses_app_key' => $this->config->item('app_key'),
          );
          $this->session->set_userdata($user_data);
        }
        }

      /* Blog Login */ 







    redirect('dashboard');
  }else{ 
   /* Same Email Id but Different source */
   $this->session->set_flashdata('msg','You are not registerd Yet ! Please signup to continue!');        
   redirect('signup');      
 }

}else{
  $this->session->set_flashdata('msg','You are not registerd Yet ! Please signup to continue!');        
  redirect('signup');  
}  

}   


}else{
  $this->session->set_flashdata('msg','Wrong Username or Password!');  
  redirect('login');
}

}

	//generate a username from Full name
public function generate_username($string_name="", $rand_no = 200){
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
