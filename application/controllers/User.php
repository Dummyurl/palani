<?php

// error_reporting(1);
require_once(APPPATH . '../vendor/stripe/stripe-php/init.php');
require_once(APPPATH . '../vendor/autoload.php');

use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\Session;
use OpenTok\Role;


Class User extends CI_Controller
{
	private $currency = 'USD';
	private $ec_action = 'Sale';
	var $submit_btn = '';
	var $button_path = '';
	public function __construct()
	{
		parent::__construct();
    
    $this->load->model('setting_model','settings');

   /* tok Box api */
   $this->apiKey = $this->config->item('apiKey');
   $this->apiSecret = $this->config->item('apiSecret');
   $this->stripe_secret_key = $this->config->item('stripe_secret_key');

   $this->data['theme'] = 'applicant';
   $array['theme'] = 'applicant';
   $this->load->library('facebook',$this->data['theme']);
   $this->load->library('googleplus',$array);
   $this->load->library('bcrypt');
   $this->load->model('applicant_modal');
   $this->load->model('user_model');
   $this->load->model('dashboard_model','dashboard'); // Dashboard Model
   $this->data['country_list'] = $this->user_model->get_country_list();

   $paypal_details = array(
   	'API_username' => 'dineshbabu_api1.g2tsolutions.com',
   	'API_signature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AC.ogLYMNmV.hSoD5YnrVT8EscUx',
   	'API_password' => 'YMN74DUFP3BTPCMG'
   );
   $this->load->library('paypal_ec', $paypal_details);
   $this->load->library('Form_validation');
   $this->timezone = $this->session->userdata('time_zone');
   if(!empty($this->timezone)){
   	date_default_timezone_set($this->timezone);
   }

 }

 Public function delete_profile_image(){
  $id = $this->session->userdata('applicant_id');
  $result = $this->db->get_where('applicants',array('id'=>$id))->row_array();
  if(empty($result['profile_img'])){
    $data = array('status' => false);
  }else{
    $this->db->update('applicants',array('profile_img'=>''),array('id'=>$id));
    $data = array('status' => TRUE,'image_url'=>base_url() . 'assets/images/default-avatar.png');
  }
  echo json_encode($data);  

}


public function upload_avatar(){

  if(!empty($_POST['slim'])){

    $output = json_decode($_POST['slim'][0], TRUE);
    if(isset($output) && isset($output['output']) && isset($output['output']['image'])){

      $file = $output['output']['image'];
      $file_name = $output['input']['name'];

      if(isset($file)){
        /* Check jpeg file */
        if(stripos($file, 'data:image/jpeg;base64,') === 0)
        {
          $img = base64_decode(str_replace('data:image/jpeg;base64,', '', $file));            
        }/* Check png file */
        else if(stripos($file, 'data:image/png;base64,') === 0)
        {
          $img = base64_decode(str_replace('data:image/png;base64,', '', $file));           
        }
        else /* error */
        {
          $result =  array('error' => 'Non-image file');
        }
        $result = file_put_contents('assets/images/' . $file_name, $img);

        if($result == FALSE){
          $result =  array('error' => 'Failed to write to file, may not have permission');
        }else{
          $result = array('image_url' =>$file_name);
        }

        if(isset($result['image_url'])){
          $id = $this->session->userdata('applicant_id');
          $this->db->update('applicants',array('profile_img'=>$result['image_url']),array('id'=>$id));
        }
        echo json_encode($result);

      }
    }
  }
}

Public function faq(){
  $this->load->view('faq');
}


Public function comments(){
  $this->load->view('test');
}

Public function get_email_status(){
  $id = $this->session->userdata('applicant_id');
  $where = array('is_verified' => 1,'id' => $id);
  $status = $this->db->get_where('applicants',$where)->num_rows();
  echo json_encode(array('status'=>$status));
}

Public function change_password()
{
  $this->validate_password();
  $data = array('password' =>md5($_POST['password']));
  $where = array('id' => $this->session->userdata('applicant_id'));
  $this->db->update('applicants',$data,$where);
  echo json_encode(array('status'=>true));
}

Public function get_user_name(){
  $data = $this->db->select('first_name,last_name')
  ->get_where('applicants',array('username'=>$_POST['username']))
  ->row_array();
  echo $data['first_name'].' '.$data['last_name'];
}

Public function validate_password()
{

  // error_reporting(1);
  $data = array();
  $data['error_string'] = array();
  $data['inputerror'] = array();
  $data['status'] = TRUE;



  if(empty($_POST['current_password'])){

    $data['inputerror'][] = 'current_password';
    $data['error_string'][] = 'Enter current password';
    $data['status'] = FALSE;
  }
  if(!empty($_POST['current_password'])){

    $where = array('password' => md5($_POST['current_password']),'id' => $this->session->userdata('applicant_id'));
    $count = $this->db->get_where('applicants',$where)->num_rows();
    if($count == 0){
      $data['inputerror'][] = 'current_password';
      $data['error_string'][] = 'Password mismatched! Please try again!';
      $data['status'] = FALSE;
    }
  }


  if(empty($_POST['password'])){

    $data['inputerror'][] = 'password';
    $data['error_string'][] = 'Enter new password';
    $data['status'] = FALSE;
  }


  if(empty($_POST['confirm_password'])){

    $data['inputerror'][] = 'confirm_password';
    $data['error_string'][] = 'Enter confirm password';
    $data['status'] = FALSE;
  }
  elseif(!empty($_POST['password']) && !empty($_POST['confirm_password'])){
    if($_POST['password'] != $_POST['confirm_password']){

      $data['inputerror'][] = 'confirm_password';
      $data['error_string'][] = 'Password does not match';
      $data['status'] = FALSE;

    }
  }

  $where = array('id' => $this->session->userdata('applicant_id'));
  $user =  $this->db->get_where('applicants',$where)->row_array();

  if($user['password'] == md5($_POST['password'])){

    $data['inputerror'][] = 'password';
    $data['error_string'][] = 'You cant use your old password as new password';
    $data['status'] = FALSE;

  }





  if($data['status'] === FALSE)
  {
    echo json_encode($data);
    exit();
  }





}





public function page_404()
{
 $data['heading'] = '<center>404 Page Not Found</center>';
 $data['message'] = '';
 $this->load->view('errors/html/error_404',$data);
}


public function signup_applicant()
{

  $this->session->set_userdata(array('register_type'=>'user'));
  $this->data['theme'] = 'applicant';
  $this->data['module'] = 'signup';
  $this->data['facebook_url'] = $this->facebook->login_url();
  $this->data['google_url'] = $this->googleplus->signupURL();
  $this->load->vars($this->data);
  $this->load->view('template');
}

public function signup_guru()
{

 if($this->session->userdata('type') != '' || $this->session->userdata('applicant_id') !='')
 {
  redirect('dashboard');
}else{

  $this->session->set_userdata(array('register_type'=>'guru'));
  $this->data['theme'] = 'guru';
  $this->data['module'] = 'signup';
  $this->data['facebook_url'] = $this->facebook->login_url();
  $this->data['google_url'] = $this->googleplus->signupURL();  
  $this->load->vars($this->data);
  $this->load->view('template');
}

}

public function check_email()
{
	$email = $this->input->get('email');
	$result = $this->db->query("SELECT * FROM `applicants` WHERE `email` = '".$email."'")->row_array();
	$isAvailable = true;
	if(count($result)>0){
		$isAvailable = false;
	}
	echo json_encode(array('valid' => $isAvailable));
}

public function check_useremail()
{
	$email = $this->input->post('email');
	$result = $this->db->query("SELECT * FROM `applicants` WHERE `email` = '".$email."'")->row_array();
	$isAvailable = true;
	if(sizeof($result)>0)
	{
		$isAvailable = false;
	}
	echo json_encode(array('valid' => $isAvailable));
}

public function save_signup()
{

	$input_values = $this->input->post();
	$sts = 1;
	if(isset($input_values['signup_type']))
	{
		unset($input_values['signup_type']);
	}
	if(isset($input_values['confirm_password']))
	{
		unset($input_values['confirm_password']);
	}




	if(isset($input_values['password']))
	{
		$input_values['password'] = md5($input_values['password']);
	}
  $input_values['email'] = htmlentities($input_values['email']);
  $input_values['is_verified'] = 0;
  $input_values['username'] = $this->generate_username($input_values['first_name'].' '.$input_values['last_name'], 10);
  if($this->db->insert('applicants',$input_values))
  {
    $insert_id = $this->db->insert_id();

    $this->session->set_userdata('applicant_id',$insert_id);
    $this->session->set_userdata('type',$input_values['type']);
    $this->session->set_userdata('role',$input_values['role']);
    $this->session->set_userdata('first_name',$input_values['first_name']);
    $this->session->set_userdata('last_name',$input_values['last_name']);

    $member_headers  = "From: Mentori".'<info@mentori.ng>'."\r\n";
    $member_headers .= "Reply-To: ".'info@mentori.ng'."\r\n";   
    $member_headers .= "MIME-Version: 1.0\r\n";
    $member_headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
    $member_headers .= "X-Priority: 1\r\n";
    $data['result'] = $this->user_model->get_progress_bar($insert_id);
    $html = $this->load->view('home/pages/guru_email_verification',$data,TRUE);

                //send email
    mail($input_values['email'], "Thank you for Registering !", $html, $member_headers);
    $sts = 0;
  }
  echo $sts;
}

public function save_signup_guru()
{

	$input_values = $this->input->post();
	$sts = 1;
	if(isset($input_values['signup_type']))
	{
		unset($input_values['signup_type']);
	}
	if(isset($input_values['confirm_password']))
	{
		unset($input_values['confirm_password']);
	}
	if(isset($input_values['password']))
	{
		$input_values['password'] = md5($input_values['password']);
	}

 $input_values['email'] = htmlentities($input_values['email']);
 $input_values['is_verified'] = 0;
 $input_values['username'] = $this->generate_username($input_values['first_name'].' '.$input_values['last_name'], 10);
 if($this->db->insert('applicants',$input_values))
 {
  $insert_id = $this->db->insert_id();

  $this->session->set_userdata('applicant_id',$insert_id);
  $this->session->set_userdata('type',$input_values['type']);
  $this->session->set_userdata('role',$input_values['role']);
  $this->session->set_userdata('first_name',$input_values['first_name']);
  $this->session->set_userdata('last_name',$input_values['last_name']);
  $this->session->set_userdata('email',$input_values['email']);



  /* Blog User Register */
  if($input_values['type'] == 'guru'){

      $blog_data = array(
      'username' => $input_values['username'], 
      'email' => $input_values['email'], 
      'password' => $this->bcrypt->hash_password($_POST['password']),
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
  /* Blog User Register */

  $member_headers  = "From: Mentori".'<info@mentori.ng>'."\r\n";
  $member_headers .= "Reply-To: ".'info@mentori.ng'."\r\n";
  $member_headers .= "MIME-Version: 1.0\r\n";
  $member_headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
  $member_headers .= "X-Priority: 1\r\n";
  $data['result'] = $this->user_model->get_progress_bar($insert_id);
  $html = $this->load->view('home/pages/guru_email_verification',$data,TRUE);

                //send email
  @mail($input_values['email'], "Thank you for Registering!", $html, $member_headers);
  $sts = 0;
}
echo $sts;
}

Public function update_mentor_profile()
{


  if(!empty($_POST['dob'])){
    $dob = str_replace('/', '-', $_POST['dob']);
    $dob = date('Y-m-d',strtotime($dob));
  }else{
    $dob = '0000-00-00';
  }
  if(!empty($_POST['mentor_gender'])){
    $gender = $_POST['mentor_gender'];
  }else{
    $gender = 0;
  }
  if(!empty($_POST['where_you_heard'])){
    $where_you_heard = $_POST['where_you_heard'];
  }else{
    $where_you_heard = "";
  }
  if(!empty($_POST['charge_type'])){
    $charge_type = $_POST['charge_type'];
  }else{
    $charge_type = "";
  }
  if(!empty($_POST['hourly_rate'])){
    $hourly_rate = $_POST['hourly_rate'];
  }else{
    $hourly_rate = "";
  }

  $data =  array(
    'dob'=> $dob,
    'mentor_gender' =>$gender,
    'where_you_heard' =>$where_you_heard,
    'charge_type' =>$charge_type,
    'hourly_rate' =>$hourly_rate,
    'under_college' =>$_POST['under_college'],
    'under_major' =>$_POST['under_major'],
    'graduate_college' =>$_POST['graduate_college'],
    'degree' =>$_POST['degree'],
    'address_line1' =>htmlentities($_POST['address_line1']),
    'address_line2' =>htmlentities($_POST['address_line2']),
    'city' =>$_POST['city'],
    'state' =>$_POST['state'],
    'country' =>$_POST['country'],
    'mentor_id' => $this->session->userdata('applicant_id')
  );
  $where = array(  'mentor_id' => $this->session->userdata('applicant_id'));
  $result = $this->db->get_where('mentor_details',$where)->row();
  if(!empty($result)){
    $this->db->update('mentor_details',$data,$where);
  }else{
    $this->db->insert('mentor_details',$data);
  }

  $result = $this->db->get_where('applicants',array('is_verified'=>1,'id'=>$this->session->userdata('applicant_id')))->num_rows();

  echo json_encode(array('is_verified'=>$result));


  // echo '1';


}

Public function update_new_email(){
  $user_id = $this->session->userdata('applicant_id');
  $this->db->update('applicants',array('email'=>$_POST['email']),array('id'=>$user_id));
  $this->resend_email();
}
Public function resend_email(){

  $user_id = $this->session->userdata('applicant_id');

  $member_headers  = "From: Mentori".'<info@mentori.ng>'."\r\n";
  // $member_headers .= "Reply-To: ".'info@mentori.ng'."\r\n";
  $member_headers .= "MIME-Version: 1.0\r\n";
  $member_headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
  $member_headers .= "X-Priority: 1\r\n";
  $data['result'] = $this->user_model->get_progress_bar($user_id);
  $html = $this->load->view('home/pages/guru_email_verification',$data,TRUE);
    //send email
  echo mail($data['result']['email'], "Thank you for Registering!", $html, $member_headers);
  // $sts = 0;
  // echo $sts;
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


      Public function signup_google($userProfile){

        $user_type = $this->session->userdata('register_type');
        if($user_type == 'guru'){
          $role = 1;
        }else{
          $role = 0;
        }
        $app_data = array(
          'type'  => $this->session->userdata('register_type'),
          'first_name' => $userProfile['given_name'],
          'last_name' => $userProfile['family_name'],
          'source' => 'google',
          'email' => $userProfile['email'],
          'username' => $this->generate_username($userProfile['given_name'].' '.$userProfile['family_name'], 10),
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
        $data['profile_url'] = ($userProfile['link'] != '') ? $userProfile['link'] : '';
        $data['picture_url'] = ($userProfile['picture'] != '') ? $userProfile['picture'] : '';
        $data['oauth_provider'] = 'google';
        $data['first_name'] = $userProfile['given_name'];
        $data['last_name'] = $userProfile['family_name'];
        $data['created_date'] = date("Y-m-d H:i:s");
        $data['modified'] = date("Y-m-d H:i:s");

        $this->db->insert('social_applicant_user',$data); 
        $session_data = array('applicant_id'=>$user_id,'role'=>$role,'type'=>$user_type);
        $this->session->set_userdata($session_data);    
        redirect('welcome/profile_settings');
      }



      public function get_google_details()
      {
       $this->googleplus->getAuthenticate();
       $userProfile = $this->googleplus->getUserInfo();   

       $result = $this->db->get_where('applicants',array('email'=>$userProfile['email']))->row_array();        
       /* Check Registering or Login */
       if(!empty($this->session->userdata('register_type'))){ /* Signup */
        if(!empty($result)){

         $this->session->set_flashdata('msg','Email already registered.  If you want to create a account with new email id, please logout of your social networking sites in your browser and try to signup.');        
         redirect('signup');   

       }else{
        $this->signup_google($userProfile);          
      }  

    }else{ /* Login */

     if(!empty($result)){
      /* Same Email Id Same source */
      if($result['source'] == 'google'){
        $session_data = array('applicant_id'=>$result['id'],'role'=>$result['role'],'type'=>$result['type']);
        $this->session->set_userdata($session_data);   
        redirect('dashboard');
      }else{ 
       /* Same Email Id but Different source */
       $this->session->set_flashdata('msg','You are not registered Yet ! Please signup to continue!');        
       redirect('signup');      
     }

   }else{
    $this->session->set_flashdata('msg','You are not registered Yet ! Please signup to continue!');        
    redirect('signup');  
  }  

}   

}

public function login()
{

  $this->session->set_userdata(array('register_type'=>''));    
  if($this->session->userdata('type') != '' || $this->session->userdata('applicant_id'))
  {
    redirect('dashboard');
  }
  $this->data['module'] = 'login';
  $this->data['facebook_url'] = $this->facebook->login_url();
  $this->data['google_url'] = $this->googleplus->loginURL();
  $this->load->vars($this->data);
  $this->load->view('template');
}

public function check_applicant()
{
 $params = $this->input->post();
 $result = $this->applicant_modal->check_applicant_login($params);
 echo $result;
}

public function forgot_password()
{
 $this->data['module'] = 'forgot-password';
 $this->load->vars($this->data);
 $this->load->view('template');
}



public function resend_password()
{
 $sts = 1 ;
 $email = $this->input->post('email');
 $result = $this->db->query("SELECT * FROM `applicants` WHERE `email` = '".$email."' ORDER BY id DESC ")->row_array();
 if(sizeof($result)>0)
 {
  $password  = generateStrongPassword();
  $this->db->where('email',$email);
  if(!$this->db->update('applicants',array('password'=>md5($password))))
  {
   $sts = 2 ;
 }
 $name =  $result['first_name']." ".$result['last_name'];
 $useremail=$result['email'];

 $data['result'] = $result;
 $data['password'] = $password;
 $message = $this->load->view('home/pages/reset_password_view',$data,TRUE);

 $to = $useremail;
 $subject = 'Hey! '.$name.' Your Password has been Resetted ! ';
 $headers = "MIME-Version: 1.0" . "\r\n";
 $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
 $headers .= "From: Mentori Admin <info@mentori.ng>";

 if(mail($to,$subject,$message,$headers)){
  $sts = 0;
}


 // $this->load->helper('file');
 // $config = Array(
 //   'protocol' => 'smtp',
 //   'smtp_host' => 'ssl://smtp.googlemail.com',
 //   'smtp_port' => 465,
 //   'smtp_user' => 'boominathan@dreamguys.co.in',
 //   'smtp_pass' => 'dreams99',
 //   'mailtype' => 'html',
 //   'charset' => 'iso-8859-1',
 //   'wordwrap' => TRUE
 // );
 // $this->load->library('email');
 // $this->email->initialize($config);
 // $this->email->set_newline("\r\n");
 // $this->email->set_crlf("\r\n");
 // $this->email->from('boominathan@dreamguys.co.in','SchoolGuru');
 // $this->email->to($useremail);
 // $this->email->subject('Hey! '.$name.' Your Password Has been Resetted ! ');
 // $this->email->message($message);


 //               if($this->email->send()) //mail Function*/
 //               {
 //               	$sts = 0;
 //               }
}
echo $sts ;
}

function generateString()
{
  return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
}

public function invoice()
{

//  if($this->session->userdata('type') == 'user' ){
   $this->data['payments'] = $this->applicant_modal->get_payment_by_id();
   $this->load->view('home/applicant/pdf',$this->data);
 // }else if($this->session->userdata('type') == 'guru' ){
 //   $this->data['payment_details'] = $this->user_model->get_payment_by_id();
 //    // echo '<pre>'; print_r($this->data);
 //   $this->load->view('home/guru/pdf',$this->data);
 // }



}

public function dashboard()
{

  if($this->session->userdata('applicant_id') != ''){
   if($this->session->userdata('type') != '' ){

    $this->data['title'] = 'Dashboard';
    $applicant_id = $this->session->userdata('applicant_id');
        
                // USER Dashboard
    if($this->session->userdata('type') == 'user' ){
                  // Pagination
     $total_rows = count($this->applicant_modal->get_dashboard_activity($applicant_id,'',''));
     $limit = 10;
     $uri_segment = 2;
     $current_page = $this->uri->segment($uri_segment, 0);
                  // pagination
     $this->load->library('pagination');
     $config = array();
     $config['base_url'] = base_url().'dashboard';
     $config['total_rows'] = $total_rows;
     $config['per_page'] = $limit;
     $config['uri_segment'] = $uri_segment;
     $config['full_tag_open'] = '<ul class="pagination pull-right">';
     $config['full_tag_close'] = '</ul>';
     $config['first_link'] = 'First';
     $config['last_link'] = 'Last';
     $config['first_tag_open'] = '<li>';
     $config['first_tag_close'] = '</li>';
     $config['prev_link'] = '&laquo';
     $config['prev_tag_open'] = '<li class="prev">';
     $config['prev_tag_close'] = '</li>';
     $config['next_link'] = '&raquo';
     $config['next_tag_open'] = '<li>';
     $config['next_tag_close'] = '</li>';
     $config['last_tag_open'] = '<li>';
     $config['last_tag_close'] = '</li>';
     $config['cur_tag_open'] = '<li class="active"><a href="#">';
     $config['cur_tag_close'] = '</a></li>';
     $config['num_tag_open'] = '<li>';
     $config['num_tag_close'] = '</li>';

     $this->pagination->initialize($config);
     $this->data['links'] = $this->pagination->create_links();

     $this->data['result'] = $this->user_model->get_progress_bar($applicant_id);
     $this->data['activity_list'] = $this->applicant_modal->get_dashboard_activity($applicant_id,$limit,$current_page);
     $this->data['applicant'] =  $this->applicant_modal->get_applicant_details();
     $this->data['account'] =  $this->applicant_modal->get_account_details();
     $this->data['notification'] = $this->user_model->get_notification_mentee($applicant_id);

     $this->data['earned'] =  $this->applicant_modal->get_total_earned(); 
     $this->data['requested'] =  $this->user_model->get_total_requested(); 
     $this->data['paid'] =  $this->user_model->get_total_paid();


               } // GURU Dashboard
               elseif($this->session->userdata('type') == 'guru' ){
                  // Pagination
                $total_rows = count($this->user_model->get_dashboard_activity($applicant_id,'',''));
                $limit = 10;
                $uri_segment = 2;
                $current_page = $this->uri->segment($uri_segment, 0);
                  // pagination
                $this->load->library('pagination');
                $config = array();
                $config['base_url'] = base_url().'dashboard';
                $config['total_rows'] = $total_rows;
                $config['per_page'] = $limit;
                $config['uri_segment'] = $uri_segment;
                $config['full_tag_open'] = '<ul class="pagination pull-right">';
                $config['full_tag_close'] = '</ul>';
                $config['first_link'] = 'First';
                $config['last_link'] = 'Last';
                $config['first_tag_open'] = '<li>';
                $config['first_tag_close'] = '</li>';
                $config['prev_link'] = '&laquo';
                $config['prev_tag_open'] = '<li class="prev">';
                $config['prev_tag_close'] = '</li>';
                $config['next_link'] = '&raquo';
                $config['next_tag_open'] = '<li>';
                $config['next_tag_close'] = '</li>';
                $config['last_tag_open'] = '<li>';
                $config['last_tag_close'] = '</li>';
                $config['cur_tag_open'] = '<li class="active"><a href="#">';
                $config['cur_tag_close'] = '</a></li>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';

                $this->pagination->initialize($config);
                $this->data['links'] = $this->pagination->create_links();


                $this->data['result'] = $this->user_model->get_progress_bar($applicant_id);
                $this->data['activity_list'] = $this->user_model->get_dashboard_activity($applicant_id,$limit,$current_page);
                $this->data['applicant'] =  $this->user_model->get_applicant_details();
                $this->data['account'] =  $this->user_model->get_account_details();
                $this->data['rating'] = $this->user_model->get_rating($applicant_id);
                $this->data['notification'] = $this->user_model->get_notification_mentee($applicant_id);
                
                $this->data['earned'] =  $this->user_model->get_total_earned(); 
                $this->data['requested'] =  $this->user_model->get_total_requested(); 
                $this->data['paid'] =  $this->user_model->get_total_paid();  

                // echo '<pre>';print_r($this->data); exit;
              }
               // Super Admin Dashboard
              elseif($this->session->userdata('type') == 'superadmin' ){
                $this->data['gurus'] = $this->dashboard->get_gurus();
                $this->data['users'] = $this->dashboard->get_users();
              }


          //     echo '<pre>';print_r($this->data); exit;
              
              $this->data['module'] = 'dashboard';
              $this->load->vars($this->data);
              $this->load->view('template');

            }else{
              redirect('signup');
            }
          }
          else
          {
            redirect(base_url()."login");
          }
        }

        public function schedule_timings()
        {				            
          $this->data['title'] = 'Schedule timing';
          if($this->session->userdata('applicant_id') != ''){
           if($this->session->userdata('type') != '' ){

            $applicant_id = $this->session->userdata('applicant_id');

            if($this->session->userdata('type') == 'guru' ){
             $this->data['result'] = $this->applicant_modal->get_progress_bar($applicant_id);
             $theme = 'guru';
             $this->data['theme']=$theme;
             $this->data['module'] = 'schedule_timings';
             $this->load->vars($this->data);
             $this->load->view('template');
           }else{
            redirect(base_url()."login");
          }
        }else{
          redirect(base_url()."login");
          //redirect('user/login_confirmation');
        }
      }
      else
      {
        redirect(base_url()."login");
      }
    }

    public function account()
    {



     $this->data['title']='Account';
     
     if($this->session->userdata('type') != '' ){
      $applicant_id = $this->session->userdata('applicant_id');
      if($this->session->userdata('type') == 'user' ){
        $this->data['result'] = $this->applicant_modal->get_progress_bar($applicant_id);
        $this->data['account'] =  $this->user_model->get_account_details();
        $this->data['earned'] =  $this->applicant_modal->get_total_earned(); 
        $this->data['requested'] =  $this->user_model->get_total_requested(); 
        $this->data['paid'] =  $this->user_model->get_total_paid();

        $theme = 'applicant';
        $this->data['theme']=$theme;
        $this->data['module'] = 'account';
        $this->load->vars($this->data);
        $this->load->view('template');
      }
      else if($this->session->userdata('type') == 'guru' ){

        $this->data['result'] = $this->applicant_modal->get_progress_bar($applicant_id);
        $this->data['account'] =  $this->user_model->get_account_details();
        $this->data['earned'] =  $this->user_model->get_total_earned(); 
        $this->data['requested'] =  $this->user_model->get_total_requested(); 
        $this->data['paid'] =  $this->user_model->get_total_paid();          
        $theme = 'guru';
        $this->data['theme']=$theme;
        $this->data['module'] = 'account';
        $this->load->vars($this->data);
        $this->load->view('template');

      }
      else{
        redirect(base_url()."login");
      }
    }else{
      // redirect('user/login_confirmation');
      redirect(base_url()."login");
    }
  }
  

  Public function request_amount(){

    $result = array();
    $mentor_id = $this->session->userdata('applicant_id');


    if($this->session->userdata('type') == 'guru'){
      $where = array('mentor_id' => $mentor_id,'payment_status'=>1);
    }else{
      $where = array('user_id' => $mentor_id,'payment_status'=>1);
    }
    /* Check Total amount */
    
    $total = $this->db->select('SUM(payment_gross) as total')->get_where('payments',$where)->row_array();
    
    if(!empty($total)){  /* Total Present */

      $overall_total =  $total['total'];

      /* Get Paid amount */
      $where = array('mentor_id'=>$this->session->userdata('applicant_id'),'status'=>2);
      $paid  =  $this->db
      ->select('SUM(request_amount) as paid')
      ->get_where('pay_request_details',$where)
      ->row_array();


      /* Get Request amount */
      $where = array('mentor_id'=>$this->session->userdata('applicant_id'),'status'=>1);
      $request_amount  =  $this->db
      ->select('SUM(request_amount) as request_amount')
      ->get_where('pay_request_details',$where)
      ->row_array();



      if(!empty($request_amount)){
        $requested_amount =  (!empty($request_amount['request_amount'])?$request_amount['request_amount']:'0.00'); 
        $paid =  (!empty($paid['paid'])?$paid['paid']:'0.00'); 


        $current_paid_amount = $paid + $requested_amount;


        /* Already paid with newly request */
        $balance = $overall_total - $current_paid_amount;
        if($balance == 0){
          if($this->session->userdata('type') == 'guru'){
            $result = array('status' => false,'message'=>'There is no balance in your account!');
          }else{
            $result = array('status' => false,'message'=>'There is no paid amount!');
          }
        }
        elseif($balance < $_POST['request_amount']){

          $result = array('status' => false,'message'=>'You can request below $'.$balance);

        }else{

          $data = array(
            'mentor_id'=>$this->session->userdata('applicant_id'),
            'status'=>1,
            'request_amount'=>$_POST['request_amount'],
            'request_date'=>date('Y-m-d'),
            'timezone' => date_default_timezone_get(),
            'description' =>$_POST['description']
          );
          $this->db->insert('pay_request_details',$data);
          $result = array('status' => true,'message'=>'Request made successfully!');
        }

      }
    }else{
      $result = array('status' => false,'message'=>'There is no balance in your account!');
    }

    echo json_encode($result);






  }

        // Privacy Policy


  Public function privacy_policy()
  {
    if($this->session->userdata('role') == 0){
      $theme = 'applicant';
    }else{
      $theme = 'guru';
    }

    $this->data['title']='Privacy Policy';
    $this->data['theme']=$theme;
    $this->data['module'] = 'privacy_policy';
    $this->load->vars($this->data);
    $this->load->view('template');
  }
  Public function terms_conditions()
  {
    if($this->session->userdata('role') == 0){
      $theme = 'applicant';
    }elseif($this->session->userdata('role') == 1){
      $theme = 'guru';
    }

    $this->data['title']='Terms & Condition';
    $this->data['theme']=$theme;
    $this->data['module'] = 'terms_conditions';
    $this->load->vars($this->data);
    $this->load->view('template');

  }

  Public function profile_edit()
  {
    $applicant_id = $this->session->userdata('applicant_id');
    $this->data['result'] = $this->user_model->get_progress_bar($applicant_id);
    $this->data['activity_list'] = $this->user_model->get_dashboard_activity($applicant_id);
    $this->data['module'] = 'profile_edit';
    $this->load->vars($this->data);
    $this->load->view('template');
  }




  Public function get_all_payments()
  {


    $list = $this->dashboard->get_datatables();
    $data = array();
    $no = $_POST['start'];
    $i = 1;
    foreach ($list as $g) {
     $row = array();



     if(!empty($g->mentor_profile_img) && empty($g->mentor_picture) ||  !empty($g->mentor_profile_img) && !empty($g->mentor_picture)){

      $mentor_img = $g->mentor_profile_img;
      $file_to_check = FCPATH . '/assets/images/' . $mentor_img;
      if (file_exists($file_to_check)) {
        $mentor_img = base_url() . 'assets/images/'.$mentor_img;
      }else{
        $mentor_img = base_url() . 'assets/images/default-avatar.png';
      }
    }else if(empty($g->mentor_profile_img) && !empty($g->mentor_picture)){
      $mentor_img = $g->mentor_picture;
    }else{
      $mentor_img = base_url() . 'assets/images/default-avatar.png';
    }


    if(!empty($g->applicant_profile_img) && empty($g->applicant_picture) ||  !empty($g->applicant_profile_img) && !empty($g->applicant_picture)){

      $applicant_img = $g->applicant_profile_img;
      $file_to_check = FCPATH . '/assets/images/' . $applicant_img;
      if (file_exists($file_to_check)) {
        $applicant_img = base_url() . 'assets/images/'.$applicant_img;
      }else{
        $applicant_img = base_url() . 'assets/images/default-avatar.png';
      }
    }else if(empty($g->applicant_profile_img) && !empty($g->applicant_picture)){
      $applicant_img = $g->applicant_picture;
    }else{
      $applicant_img = base_url() . 'assets/images/default-avatar.png';
    }

    $row[] = '<a href="'.base_url().'mentor-profile/'.$g->mentor_user_name.'"><img src="'.$mentor_img.'" class="img-circle" height="40" width="40"> '.$g->mentor_name.'</a>';
    $row[] = '<a href="'.base_url().'mentee-profile/'.$g->applicant_user_name.'"><img src="'.$applicant_img.'" class="img-circle" height="40" width="40"> '.$g->applicant_name.'</a>';
    $row[] = date('d-m-Y',strtotime($g->invite_date));
    $row[] = date('h:i A',strtotime($g->invite_time));
    $row[] = date('h:i A',strtotime($g->invite_end_time));

    $from_date_time =  $g->invite_date.' '.$g->invite_time;
    $from_timezone =$g->time_zone;
    $to_timezone = $this->session->userdata('time_zone');
    $from_date_time  = $this->converToTz($from_date_time,$to_timezone,$from_timezone);
    $from_time  = date('h:i a',strtotime($from_date_time));


            // Time crossed witout approved
    if($g->approved == 0 && date('Y-m-d H:i:s') >  date('Y-m-d H:i:s', strtotime($from_date_time . ' +1 hour'))) {
      $row[] ='<span class="label label-danger">Cancelled</span>';
    }elseif($g->approved == 0 && date('Y-m-d H:i:s') <  date('Y-m-d H:i:s', strtotime($from_date_time . ' +1 hour'))) {
      $row[] = '<span class="label label-warning">Pending</span>';
          }          // Before Call time with approved
          else if($g->approved == 1 && date('Y-m-d H:i:s') <  date('Y-m-d H:i:s', strtotime($from_date_time)) ){
            $row[]='<span class="label label-success">Approved</span>';
          }
         else if($g->approved == 1 && date('Y-m-d H:i:s') >  date('Y-m-d H:i:s', strtotime($from_date_time))){// After Call time with Approved
          $count = $this->db->get_where('call_logs',array('invite_id'=>$g->invite_id))->num_rows();
                if($count>0){// After Call time with Approve  with call logs
                  $row[] = '<span class="label label-default">Finished</span>';
                }else{// After Call time with Approve  without call logs
                  $row[] = '<span class="label label-warning">Incomplete</span>';
                }
              }
              else{
                $row[] = '<span class="label label-danger">Cancelled</span>';
              }
              $row[] = '$'.$g->payment_gross;
              $data[] = $row;
            }
            $output = array(
             "draw" => $_POST['draw'],
             "recordsTotal" => $this->dashboard->count_all(),
             "recordsFiltered" => $this->dashboard->count_filtered(),
             "data" => $data,
           );
                //output to json format
            echo json_encode($output);
          }






          public function login_confirmation($id = '',$role='',$type='')
          {   

            redirect(base_url()."login");         
          //  if($id != '')
          //  {
          //   $this->applicant_modal->set_user_type($id,$role,$type);
          //   $this->session->set_userdata('type',$type);
          //   $this->session->set_userdata('role',$role);
          //   redirect('dashboard');
          // }

          // $this->data['module'] = 'login_confirmation';
          // $this->load->vars($this->data);
          // $this->load->view('template');
          }

          public function email_verification_success($appid)
          {
           $id = base64_decode($appid);
           if($id > 0 )
           {
            $verify_email = $this->user_model->verify_success($id);
            if($verify_email == true)
            {
             $data['result'] = $this->user_model->get_progress_bar($id);
             $this->load->view('home/pages/email_verification_success',$data);
           }
         }
       }

       public function verifiy_user($verification_code)
       {
         $this->data['module'] = 'verifiy_user';
         $result = $this->applicant_modal->verify_user($verification_code);
         if($result==0)
         {

         }
       }

       public function mail_template($useremail,$verification_code)
       {
         $url = base_url()."user/verifiy_user/".$verification_code;
         $message= '<table width="600" cellpadding="0" cellspacing="0" align="center">
         <tr>
         <td style="padding:50px 50px 50px 50px; border:1px solid #bfc0cd; border-radius:20px;">
         <table width="100%" cellpadding="0" cellspacing="0" align="center">
         <tr>
         <td>
         <p style="margin:0; padding:0;"><a href="'.base_url().'" target="_blank"><img src="'.base_url().'assets/images/schoolguru-logo-emailtemplate.png" /></a></p>
         <p style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#808080; font-weight:normal; margin:40px 0 20px 0; padding:0;">We have received a request to reset the password for this email address. Click the button below to reset it.</p>
         <p style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#ffffff; font-weight:normal; margin:15px 0 0 0; padding:0;"><a href="#" style="color:#ffffff; padding:12px 25px 12px 25px; background:#5c65be; display:inline-block; text-decoration:none; border-radius:8px;">Reset Password</a></p>
         <p style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#808080; font-weight:normal; margin:50px 0 0 0; padding:0;">If you didnt request this, you can ignore this email. Your password wont change until you create a new password.</p>
         </td>
         </tr>
         </table>
         </td>
         </tr>
         <tr>
         <td align="center">
         <p style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#808080; font-weight:normal; line-height:24px; margin:40px 0 40px 0; padding:0;">&copy; 2017 All rights reserved by <a href="https://www.dreamguys.co.in/display/schoolguru/" target="_blank" style="color:#808080; text-decoration:none;">schoolguru.com</a><br />
         <a href="#" target="_blank" style="color:#808080; text-decoration:none;">Privacy Policy</a> and <a href="#" target="_blank" style="color:#808080; text-decoration:none;">Terms & Conditions</a></p>
         </td>
         </tr>
         </table>';
         $this->load->helper('file');
         $this->load->library('email');
         $this->email->set_newline("\r\n");
         $this->email->from('info@mentori.ng','Mentori');
         $this->email->to($useremail);
         $this->email->subject('Hey! '.$name.' Your Password Has been Resetted ! ');
         $this->email->message($message);
               if($this->email->send()) //mail Function*/
               {
               	$sts = 0;
               }
             }

             public function update_profile()
             {
              $applicant_id     = $this->session->userdata('applicant_id');
              $profile_details  = $this->input->post();
              $result           = $this->applicant_modal->update_profile($applicant_id,$profile_details);
              if($result == 0){
               $this->session->set_flashdata('success_message','Profile has been updated.');
             }
             echo $result;
           }

           public function logout()
           {
           	$applicant_id     = $this->session->userdata('applicant_id');
           	$this->db->update('applicants',array('logged_in'=>0,'logged_by'=>'mobile'),array('id'=>$applicant_id ));
           	$this->session->unset_userdata(array('applicant_id','first_name','last_name','fb_access_token'));
           	$this->session->sess_destroy();
            @session_start();
            session_destroy();            
            redirect(base_url());
          }

          public function calendar()
          {
            if($this->session->userdata('applicant_id') == ''){
             redirect('login');
           }
           $this->data['module'] = 'calendar';
           $id = $this->session->userdata('applicant_id');

           if($this->session->userdata('role') == 0){
             $this->data['theme'] = 'applicant';
             $this->data['result'] = $this->applicant_modal->calendar_list_confirmed_view($id,'','');
             $this->data['pending_result'] = $this->applicant_modal->calendar_list_pending_view($id,'','');
           }elseif($this->session->userdata('role') == 1){
             $this->data['theme'] = 'guru';
             $this->data['result'] = $this->user_model->calendar_list_confirmed_view($id,'','');
             $this->data['pending_result'] = $this->user_model->calendar_list_pending_view($id,'','');
           }
           $this->load->vars($this->data);
           $this->load->view('template');
         }


         Public function set_user()
         {
          if(isset($_POST['search_id'])!=''){
           $data = array('search_id' => $_POST['search_id']);
         }else{
           $data = array('search_id'=>'');
         }

         $this->session->set_userdata( $data );
         echo true;

       }

       Public function get_all_users()
       {
        $datas = $this->db->get_where('applicants',array('delete_sts'=>0 , 'role !='=>2))->result();


        foreach($datas as $g){

         if($g->role==0){
          $role =' (Mentee)';
        }else{
          $role =' (Mentor)';
        }

        $data['value']=$g->id;
        $data['label']=$g->first_name.' '.$g->last_name.$role;

        $test[]=$data;

      }
      echo json_encode($test);
    }

    public function schedule_guru($id = ''){

      if($this->session->userdata('applicant_id') == ''){
       redirect('login');
     } 
     $id= $this->uri->segment(3);
     $this->data['title'] = 'Available timing';
     $this->data['module'] = 'guru_available_calendar';
     if($this->session->userdata('role') == 0){
       $this->data['theme'] = 'applicant';
       $this->data['result'] =  $this->applicant_modal->calendar_available_time($id);
       $this->data['gurus'] = $this->applicant_modal->applicant_detail_list_view($id);
       $this->data['available_data'] = $this->applicant_modal->get_guru_available_data($id);
       $this->data['selected_date'] = date('Y-m-d');
     }else{
       $this->data['theme'] = 'guru';
       $this->data['result'] = $this->user_model->calendar_available_time($id);
     }
     $this->load->vars($this->data);
     $this->load->view('template');
   }

   public function today_conversation()
   {

    $from_date_time = $_POST['date'];
    $from_timezone = $this->session->userdata('time_zone');
    $to_timezone = ($_POST['timezone'])?$_POST['timezone']:date_default_timezone_get();
    $from_date_time  = $this->converToTz($from_date_time,$to_timezone,$from_timezone);
    $date = date('Y-m-d',strtotime($from_date_time));
    $view = 0;
    $id = $this->session->userdata('applicant_id');           	

    if($this->session->userdata('role') == 0){
     $data['today_conversation'] = $this->applicant_modal->get_today_conversation($id,$date);
   }
   elseif($this->session->userdata('role') == 1){
     $data['today_conversation'] = $this->user_model->get_today_conversation($id,$date);
   }else{


     $user = $this->user_model->get_user_data();

     if($user->role == 0){
      $data['today_conversation'] = $this->applicant_modal->get_today_conversation($user->id,$date);
    }else if($user->role == 1){
      $data['today_conversation'] = $this->user_model->get_today_conversation($user->id,$date);
    }
  }

  if(!empty($data['today_conversation'])){
   $view = $this->load->view('home/pages/today_conversation_view',$data);
 }
 echo $view;
}

Public function search_array($array, $term)
{
  $data = array();
  foreach ($array AS $key => $value) {
    if (stristr($value, $term) === FALSE) {
      continue;
    } else {
      $data[] =$key;
    }
  }
  return $data;
}


Public function get_user()
{

  error_reporting(1);
  if(!empty($_POST['user_name'])){


   $user_name = trim($_POST['user_name']);

          if($this->session->userdata('role')==0){ // Applicant          

            $sql = "SELECT a.first_name,a.last_name, a.profile_img, s.picture_url, a.username,m.city,m.state,m.country   FROM applicants a
            LEFT JOIN `social_applicant_user` `s` ON `s`.`reference_id` = `a`.`id`
            LEFT  JOIN `mentor_details` `m` ON `m`.`mentor_id` = `a`.`id`  
            LEFT JOIN mentor_course_details ON mentor_course_details.mentor_id = m.mentor_id
            LEFT JOIN courses ON courses.course_id = mentor_course_details.course_id
            LEFT JOIN subject ON subject.subject_id = mentor_course_details.subject_id         
            WHERE a.role = 1  AND 
            (
            a.first_name LIKE '%$user_name%' OR
            a.last_name LIKE '%$user_name%'  OR
            courses.course LIKE '%$user_name%' OR
            subject.subject LIKE '%$user_name%'
          ) GROUP BY a.id ORDER BY `first_name` ASC  LIMIT 5";              

          $data  = $this->db->query($sql)->result_array();
             // echo $this->db->last_query();

          if(!empty($data)){           

            foreach ($data as $currentuser) {
             $profile_img = '';

             if(isset($currentuser['profile_img'])&&!empty($currentuser['profile_img'])){
              $profile_img = $currentuser['profile_img'];
            }
            $social_profile_img = '';
            if(isset($currentuser['picture_url'])&&!empty($currentuser['picture_url'])){
              $social_profile_img = $currentuser['picture_url'];
            }
            $img1 = '';
            if($social_profile_img != ''){
              $img1 = $social_profile_img;
            }
            if($profile_img != ''){
              $file_to_check = FCPATH . '/assets/images/' . $profile_img;
              if (file_exists($file_to_check)) {
               $img1 = base_url() . 'assets/images/'.$profile_img;
             }
           }
           $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';                  


           $html .='<a href="'.base_url().'mentor-profile/'.$currentuser['username'].'">
           <div class="display_box" align="left">
           <div class="userimage">
           <img src="'.$img.'" class="img-circle img-reponsive"/>
           </div>
           <div class="name">'.$currentuser['first_name'].' '.$currentuser['last_name'].'</div>
           </div>
           </a>';

         }
       }
     }else if($this->session->userdata('role')==1){


      $sql="SELECT a.first_name,a.last_name, a.profile_img, s.picture_url, a.username,m.city,m.state,m.country   FROM applicants a
      LEFT JOIN `social_applicant_user` `s` ON `s`.`reference_id` = `a`.`id`
      LEFT  JOIN `mentor_details` `m` ON `m`.`mentor_id` = `a`.`id`  
      LEFT JOIN mentor_course_details ON mentor_course_details.mentor_id = m.mentor_id
      LEFT JOIN courses ON courses.course_id = mentor_course_details.course_id
      LEFT JOIN subject ON subject.subject_id = mentor_course_details.subject_id         
      WHERE a.role = 0  AND 
      (
      a.first_name LIKE '%$user_name%' OR
      a.last_name LIKE '%$user_name%'  OR
      courses.course LIKE '%$user_name%' OR
      subject.subject LIKE '%$user_name%'
    ) GROUP BY a.id ORDER BY `first_name` ASC  LIMIT 5";   	

    $data  = $this->db->query($sql)->result_array();
           //echo $this->db->last_query();

    if(!empty($data)){
      $html ='';




      foreach ($data as $currentuser) {
       $profile_img = '';

       if(isset($currentuser['profile_img'])&&!empty($currentuser['profile_img'])){
        $profile_img = $currentuser['profile_img'];
      }
      $social_profile_img = '';
      if(isset($currentuser['picture_url'])&&!empty($currentuser['picture_url'])){
        $social_profile_img = $currentuser['picture_url'];
      }
      $img1 = '';
      if($social_profile_img != ''){
        $img1 = $social_profile_img;
      }
      if($profile_img != ''){
        $file_to_check = FCPATH . '/assets/images/' . $profile_img;
        if (file_exists($file_to_check)) {
         $img1 = base_url() . 'assets/images/'.$profile_img;
       }
     }
     $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';





           //if($val == 'first_name' || $val == 'last_name' || $val == 'username'){


     $html .='<a href="'.base_url().'mentee-profile/'.$currentuser['username'].'">
     <div class="display_box" align="left">
     <div class="userimage">
     <img src="'.$img.'" class="img-circle img-reponsive"/>
     </div>
     <div class="name">'.$currentuser['first_name'].' '.$currentuser['last_name'].'</div>
     </div>
     </a>';        
   }
 }


}

if(isset($html)){
 echo $html;
}else{
 return false;
}

}
}

public function list_view()
{
 if($this->session->userdata('applicant_id') == '')
 {
  redirect('login');
}


$this->data['theme'] = 'applicant';
$this->data['module'] = 'calendar_list_view';
$id = $this->session->userdata('applicant_id');
if($this->session->userdata('role') == 0){

          // Pagination

  $total_rows = count($this->applicant_modal->calendar_list_confirmed_view_count($id));
  $limit = 5;
  $uri_segment = 2;
  $current_page = $this->uri->segment($uri_segment, 0);
          // pagination
  $this->load->library('pagination');
  $config = array();
  $config['base_url'] = base_url().'list-view';
  $config['total_rows'] = $total_rows;
  $config['per_page'] = $limit;
  $config['uri_segment'] = $uri_segment;
  $config['full_tag_open'] = '<ul class="pagination pull-right">';
  $config['full_tag_close'] = '</ul>';
  $config['first_link'] = 'First';
  $config['last_link'] = 'Last';
  $config['first_tag_open'] = '<li>';
  $config['first_tag_close'] = '</li>';
  $config['prev_link'] = '&laquo';
  $config['prev_tag_open'] = '<li class="prev">';
  $config['prev_tag_close'] = '</li>';
  $config['next_link'] = '&raquo';
  $config['next_tag_open'] = '<li>';
  $config['next_tag_close'] = '</li>';
  $config['last_tag_open'] = '<li>';
  $config['last_tag_close'] = '</li>';
  $config['cur_tag_open'] = '<li class="active"><a href="#">';
  $config['cur_tag_close'] = '</a></li>';
  $config['num_tag_open'] = '<li>';
  $config['num_tag_close'] = '</li>';
  $this->pagination->initialize($config);
  $this->data['link1'] = $this->pagination->create_links();

          // Pagination 2

  $total_rowss = count($this->applicant_modal->calendar_list_pending_view_count($id));
  $limits = 5;
  $uri_segments = 3;
  $current_pages = $this->uri->segment($uri_segments, 0);
          // pagination
  $this->load->library('pagination');
  $configs = array();
  $configs['base_url'] = base_url().'list-view/con';
  $configs['total_rows'] = $total_rowss;
  $configs['per_page'] = $limits;
  $configs['uri_segment'] = $uri_segments;
  $configs['full_tag_open'] = '<ul class="pagination pull-right">';
  $configs['full_tag_close'] = '</ul>';
  $configs['first_link'] = 'First';
  $configs['last_link'] = 'Last';
  $configs['first_tag_open'] = '<li>';
  $configs['first_tag_close'] = '</li>';
  $configs['prev_link'] = '&laquo';
  $configs['prev_tag_open'] = '<li class="prev">';
  $configs['prev_tag_close'] = '</li>';
  $configs['next_link'] = '&raquo';
  $configs['next_tag_open'] = '<li>';
  $configs['next_tag_close'] = '</li>';
  $configs['last_tag_open'] = '<li>';
  $configs['last_tag_close'] = '</li>';
  $configs['cur_tag_open'] = '<li class="active"><a href="#">';
  $configs['cur_tag_close'] = '</a></li>';
  $configs['num_tag_open'] = '<li>';
  $configs['num_tag_close'] = '</li>';
  $this->pagination->initialize($configs);
  $this->data['link2'] = $this->pagination->create_links();



  $this->data['theme'] = 'applicant';
  $this->data['result'] = $this->applicant_modal->calendar_list_confirmed_view($id,$limit,$current_page);
  $this->data['pending_result'] = $this->applicant_modal->calendar_list_pending_view($id,$limits,$current_pages);

        // echo '<pre>';
        // print_r($this->data['pending_result']);
        // exit;
}else{



         // Pagination

  $total_rows = count($this->user_model->calendar_list_confirmed_view_count($id));
  $limit = 5;
  $uri_segment = 2;
  $current_page = $this->uri->segment($uri_segment, 0);
          // pagination
  $this->load->library('pagination');
  $config = array();
  $config['base_url'] = base_url().'list-view';
  $config['total_rows'] = $total_rows;
  $config['per_page'] = $limit;
  $config['uri_segment'] = $uri_segment;
  $config['full_tag_open'] = '<ul class="pagination pull-right">';
  $config['full_tag_close'] = '</ul>';
  $config['first_link'] = 'First';
  $config['last_link'] = 'Last';
  $config['first_tag_open'] = '<li>';
  $config['first_tag_close'] = '</li>';
  $config['prev_link'] = '&laquo';
  $config['prev_tag_open'] = '<li class="prev">';
  $config['prev_tag_close'] = '</li>';
  $config['next_link'] = '&raquo';
  $config['next_tag_open'] = '<li>';
  $config['next_tag_close'] = '</li>';
  $config['last_tag_open'] = '<li>';
  $config['last_tag_close'] = '</li>';
  $config['cur_tag_open'] = '<li class="active"><a href="#">';
  $config['cur_tag_close'] = '</a></li>';
  $config['num_tag_open'] = '<li>';
  $config['num_tag_close'] = '</li>';
  $this->pagination->initialize($config);
  $this->data['link1'] = $this->pagination->create_links();

          // Pagination 2

  $total_rowss = count($this->user_model->calendar_list_pending_view_count($id));
  $limits = 5;
  $uri_segments = 3;
  $current_pages = $this->uri->segment($uri_segments, 0);
          // pagination
  $this->load->library('pagination');
  $configs = array();
  $configs['base_url'] = base_url().'list-view/con';
  $configs['total_rows'] = $total_rowss;
  $configs['per_page'] = $limits;
  $configs['uri_segment'] = $uri_segments;
  $configs['full_tag_open'] = '<ul class="pagination pull-right">';
  $configs['full_tag_close'] = '</ul>';
  $configs['first_link'] = 'First';
  $configs['last_link'] = 'Last';
  $configs['first_tag_open'] = '<li>';
  $configs['first_tag_close'] = '</li>';
  $configs['prev_link'] = '&laquo';
  $configs['prev_tag_open'] = '<li class="prev">';
  $configs['prev_tag_close'] = '</li>';
  $configs['next_link'] = '&raquo';
  $configs['next_tag_open'] = '<li>';
  $configs['next_tag_close'] = '</li>';
  $configs['last_tag_open'] = '<li>';
  $configs['last_tag_close'] = '</li>';
  $configs['cur_tag_open'] = '<li class="active"><a href="#">';
  $configs['cur_tag_close'] = '</a></li>';
  $configs['num_tag_open'] = '<li>';
  $configs['num_tag_close'] = '</li>';
  $this->pagination->initialize($configs);
  $this->data['link2'] = $this->pagination->create_links();


  $this->data['theme'] = 'guru';
  $this->data['result'] = $this->user_model->calendar_list_confirmed_view($id,$limit,$current_page);
  $this->data['pending_result'] = $this->user_model->calendar_list_pending_view($id,$limit,$current_page);
}
$this->load->vars($this->data);
$this->load->view('template');
}


Public  function converToTz($time="",$toTz='',$fromTz='')
{
  if(!empty($fromTz)){
   $date = new DateTime($time, new DateTimeZone($fromTz));
   $date->setTimezone(new DateTimeZone($toTz));
   $time= $date->format('Y-m-d H:i:s');
   return $time;
 }

}

public function render_calendar_view()
{
 $id = $this->session->userdata('applicant_id');
 if($this->session->userdata('role') == 0){
  $result = $this->applicant_modal->calendar_list_guru_view($id);
  foreach($result as $record){


   $from_date_time =  $record['invite_date'].' '.$record['invite_time'];
   $to_date_time =  $record['invite_date'].' '.$record['invite_end_time'];
   $from_timezone =$record['time_zone'];
   $to_timezone = $this->session->userdata('time_zone');



   $from_date_time  = $this->converToTz($from_date_time,$to_timezone,$from_timezone);
   $to_date_time  = $this->converToTz($to_date_time,$to_timezone,$from_timezone);

   $from_time  = date('h:i a',strtotime($from_date_time));
   $to_time  = date('h:i a',strtotime($to_date_time));



   $start_time = date('g:i a',strtotime($from_time));
   $end_time = date('g:i a',strtotime($to_time));

   $title = $start_time.'-'.$end_time.' '.$record['first_name'].' '.$record['last_name'];


   if($record['subject'] != ''){
    $title = $record['subject'];
  }
  if($record['new_title'] != ''){
    $title = $record['new_title'];
  }


         // setting color here

  if($record['approved'] == 0 && date('Y-m-d') > $record['invite_date']) {
            $color = '#d9534f'; // Cancelled
          }else{
            $color = '#5bc0de'; // Pending
          }
          if($record['approved'] == 1) {
          $color = '#5cb85c';  // Approved
        }

        if($record['approved'] == 2) {
          $color = '#d9534f'; // Cancelled
        }




        $event_array[] = array(
         'id' => $record['invite_id'],
         'user_id' => $record['invite_to'],
         'title' => $title,
         'start' =>  $from_date_time,
         'end' => $to_date_time,
         'color' => $color,
         'timezone' =>$from_timezone
       );
      }
    }elseif($this->session->userdata('role') == 1){
     $result = $this->user_model->calendar_list_applicant_view($id);
     foreach($result as $record){


      $from_date_time =  $record['invite_date'].' '.$record['invite_time'];
      $to_date_time =  $record['invite_date'].' '.$record['invite_end_time'];
      $from_timezone =$record['time_zone'];

      $to_timezone = $this->session->userdata('time_zone');



      $from_date_time  = $this->converToTz($from_date_time,$to_timezone,$from_timezone);
      $to_date_time  = $this->converToTz($to_date_time,$to_timezone,$from_timezone);

      $from_time  = date('h:i a',strtotime($from_date_time));
      $to_time  = date('h:i a',strtotime($to_date_time));



      $start_time = date('g:i a',strtotime($from_time));
      $end_time = date('g:i a',strtotime($to_time));


        //$title = 'You have a discussion with '.$record['first_name'].' '.$record['last_name'];
       // $start_time = date('g a',strtotime($record['invite_time']));
       // $end_time = date('g a',strtotime($record['invite_end_time']));
      $title = $start_time.'-'.$end_time.' '.$record['first_name'].' '.$record['last_name'];

      if($record['subject'] != ''){
       $title = $record['subject'];
     }
     if($record['new_title_2'] != ''){
       $title = $record['new_title_2'];
     }


         // setting color here
     if($record['approved'] == 0 && date('Y-m-d') > $record['invite_date']) {
            $color = '#d9534f'; // Cancelled
          }else{
            $color = '#5bc0de'; // Pending
          }
          if($record['approved'] == 1) {
          $color = '#5cb85c';  // Approved
        }

        if($record['approved'] == 2) {
          $color = '#d9534f'; // Cancelled
        }


        $event_array[] = array(
         'id' => $record['invite_id'],
         'user_id' => $record['invite_to'],
         'title' => $title,
        //   'start' =>  date('Y-m-dTG:i:sz',strtotime($from_date_time)),
        // 'end' =>date('Y-m-dTG:i:sz',strtotime($to_date_time)),
         'start' =>  $from_date_time,
         'end' => $to_date_time,
         'color' => $color,
         'timezone' =>$from_timezone
       );


      }
    }elseif($this->session->userdata('role') == 2){

       if($this->session->userdata('search_id')!=''){ // Session values  present

       	$user = $this->user_model->get_user_data();

                if($user->role == 0){ // Users

                	$result = $this->applicant_modal->calendar_list_guru_view($user->id);
                	foreach($result as $record){

                		$start_time = date('g a',strtotime($record['invite_time']));
                		$end_time = date('g a',strtotime($record['invite_end_time']));
                		$title = $start_time.'-'.$end_time.' '.$record['first_name'].' '.$record['last_name'];

                        // setting color here
                    if($record['approved'] == 0 && date('Y-m-d') > $record['invite_date']) {
                        $color = '#d9534f'; // Cancelled
                      }else{
                        $color = '#5bc0de'; // Pending
                      }

                      if($record['approved'] == 1) {
                        $color = '#5cb85c';  // Approved
                      }
                      $event_array[] = array(
                       'id' => $record['invite_id'],
                       'user_id' => $record['invite_to'],
                       'title' => $title,
                       'start' => date($record['invite_date'].' '.$record['invite_time']),
                       'end' => date($record['invite_date'].' '.$record['invite_end_time']),
                       'color' =>$color
                     );
                    }

                }elseif($user->role == 1){  // gurus


                	$result = $this->user_model->calendar_list_applicant_view($user->id);
                	foreach($result as $record){
                  // $title = $user->first_name.' '.$user->last_name.' have a discussion with '.$record['first_name'].' '.$record['last_name'];
                		$start_time = date('g a',strtotime($record['invite_time']));
                		$end_time = date('g a',strtotime($record['invite_end_time']));
                		$title = $start_time.'-'.$end_time.' '.$record['first_name'].' '.$record['last_name'];
                 //  if($record['subject'] != ''){
                 //   $title = $record['subject'];
                 // }
                 // if($record['new_title_2'] != ''){
                 //   $title = $record['new_title_2'];
                 // }

                 // setting color here
                		if($record['approved'] == 0 && date('Y-m-d') > $record['invite_date']) {
                  $color = '#d9534f'; // Cancelled
                }else{
                  $color = '#5bc0de'; // Pending
                }

                if($record['approved'] == 1) {
          $color = '#5cb85c';  // Approved
        }

        if($record['approved'] == 2) {
          $color = '#d9534f'; // Cancelled
        }




        $event_array[] = array(
         'id' => $record['invite_id'],
         'user_id' => $record['invite_to'],
         'title' => $title,
         'start' => date($record['invite_date'].' '.$record['invite_time']),
         'end' => date($record['invite_date'].' '.$record['invite_end_time']),
         'color' =>$color
       );
      }


    }else{
     $event_array[] = array(
      'id' =>0,
      'user_id' => 0,
      'title' => 0,
      'start' => '2015-06-06 01:00:00',
      'end' => '2015-06-06 02:00:00'
    );

   }
 }else{
   $event_array[] = array(
    'id' =>0,
    'user_id' => 0,
    'title' => 0,
    'start' => '2015-06-06 01:00:00',
    'end' => '2015-06-06 02:00:00'
  );
 }

}
if(!empty($event_array)){
       // $this->session->set_userdata(array('search_id'=>''));
	echo json_encode($event_array);
}

}


public function update_event_name()
{
	$sts = 0;
	$event_title = $this->input->post('event_title');
	$invite_id = $this->input->post('invite_id');
	$this->db->where('invite_id',$invite_id);
	if($this->session->userdata('role') == 0){
		if($this->db->update('invite',array('new_title'=>$event_title)))
		{
			$sts = 1;
		}
	}else{
		if($this->db->update('invite',array('new_title_2'=>$event_title)))
		{
			$sts = 1;
		}
	}
	echo $sts;
}

public function delete_event()
{
	$sts = 0;
	$invite_id = $this->input->post('invite_id');
	$this->db->where('invite_id',$invite_id);
	if($this->db->update('invite',array('delete_sts'=>1)))
	{
		$sts = 1;
	}
	echo $sts;
}



public function gurus()
{
  if(empty($this->session->userdata('applicant_id'))){
    redirect('login');
  }
  
  $this->data['module'] = 'gurus_list_view';
  if($this->session->userdata('role') == 0){
    $this->data['theme'] = 'applicant';
    $this->data['gurus'] = $this->applicant_modal->mentor_list_view();
    $this->data['count'] = $this->applicant_modal->mentor_list_view_count();
    $this->data['subjects'] = $this->settings->get_subjects();    
  }else{
    $this->data['theme'] = 'guru';
    $this->data['gurus'] = $this->user_model->applicant_list_view();
    $this->data['count'] = $this->user_model->applicant_list_view_count();
    $this->data['count'] = $this->user_model->applicant_list_view_count();
    $this->data['subjects'] = $this->settings->get_subjects();
  }

  // echo '<pre>'; print_r($this->data);exit;
  $this->load->vars($this->data);
  $this->load->view('template');
}

// public function gurus_detail($username)
// {

//   if($this->session->userdata('applicant_id') == '')
//   {
//     redirect('login');
//   }
//   $sess_id  = $this->session->userdata('applicant_id');
//   $mentor = $this->db->get_where('applicants',array('username' => $username ))->row_array();



//   if(!empty($mentor)){

//     $this->session->set_userdata('pay_to',$mentor['id']);

//     $this->data['module'] = 'gurus_detail_view';
//     $this->data['title'] = 'Profile';

//     if($this->session->userdata('role') == 0){
//      $this->data['theme'] = 'applicant';
//      $this->data['gurus'] = $this->applicant_modal->applicant_detail_list_view($mentor['id']);
//      $this->data['applicant'] = $this->applicant_modal->get_progress_bar($sess_id);
//      $this->data['reviews'] = $this->user_model->review_list_view($mentor['id']);
//      $this->data['call_logs'] = $this->user_model->call_logs($mentor['id']);
//    }else if($this->session->userdata('role') == 1){
//      $this->data['theme'] = 'guru';
//      $this->data['gurus'] = $this->user_model->gurus_detail_list_view($mentor['id']);
//      $this->data['applicant'] = $this->user_model->get_progress_bar($sess_id);
//      $this->data['reviews'] = $this->user_model->review_list_view($mentor['id']);
//      $this->data['call_logs'] = $this->user_model->call_logs($mentor['id']);
//    }else{

//      $role = $mentor['role'];
//      if($role == 0){
//       $this->data['module'] = 'applicant_profile_view';
//       $this->data['gurus'] = $this->applicant_modal->applicant_detail_list_view($mentor['id']);
//       $this->data['applicant'] = $this->applicant_modal->get_progress_bar($sess_id);
//       $this->data['reviews'] = $this->user_model->review_list_view($mentor['id']);
//       $this->data['call_logs'] = $this->user_model->call_logs($mentor['id']);
//     }else{
//       $this->data['module'] = 'mentor_profile_view';
//       $this->data['gurus'] = $this->user_model->gurus_detail_list_view($mentor['id']);
//       $this->data['applicant'] = $this->user_model->get_progress_bar($sess_id);
//       $this->data['reviews'] = $this->user_model->review_list_view($mentor['id']);
//       $this->data['call_logs'] = $this->user_model->call_logs($mentor['id']);
//     }

//   }

//   $this->load->vars($this->data);
//   $this->load->view('template');
// }else{
//   $this->page_404();
// }

// }
public function gurus_detail($username)
{


  $mentor = $this->db->get_where('applicants',array('username' => $username ))->row_array();



  if(!empty($mentor)){

    $this->session->set_userdata('pay_to',$mentor['id']);

    $this->data['module'] = 'gurus_detail_view';
    $this->data['title'] = 'Profile';


    if(empty($this->session->userdata('applicant_id')) || $this->session->userdata('applicant_id') != 1){

      if($mentor['role'] == 1){
       $this->data['theme'] = 'applicant';
       $this->data['gurus'] = $this->applicant_modal->applicant_detail_list_view($mentor['id']);     
       $this->data['reviews'] = $this->user_model->review_list_view($mentor['id']);
       $this->data['call_logs'] = $this->user_model->call_logs($mentor['id']);
     }else if($mentor['role'] == 0){
       $this->data['theme'] = 'guru';
       $this->data['gurus'] = $this->user_model->gurus_detail_list_view($mentor['id']);     
       $this->data['reviews'] = $this->user_model->review_list_view($mentor['id']);
       $this->data['call_logs'] = $this->user_model->call_logs($mentor['id']);
     }
   }else{

    $role = $mentor['role'];
    if($role == 0){
      $this->data['module'] = 'applicant_profile_view';
      $this->data['gurus'] = $this->applicant_modal->applicant_detail_list_view($mentor['id']);      
      $this->data['reviews'] = $this->user_model->review_list_view($mentor['id']);
      $this->data['call_logs'] = $this->user_model->call_logs($mentor['id']);
    }else{
      $this->data['module'] = 'mentor_profile_view';
      $this->data['gurus'] = $this->user_model->gurus_detail_list_view($mentor['id']);
      // $this->data['applicant'] = $this->user_model->get_progress_bar($sess_id);
      $this->data['reviews'] = $this->user_model->review_list_view($mentor['id']);
      $this->data['call_logs'] = $this->user_model->call_logs($mentor['id']);
    }

  }



  $this->load->vars($this->data);
  $this->load->view('template');
}else{
  $this->page_404();
}

}


Public function search_all_mentor(){

  // echo '<pre>';
  // print_r($_POST);
  // exit;



 if(!empty($_POST['subject_id'])){    
  $where = " WHERE  c.subject_id = ".$_POST['subject_id']; 
}

if(!empty($_POST['course_id'])){    
  $where .= " AND c.course_id = ".$_POST['course_id'];
}

if(!empty($where)){  

  $sqls = "SELECT a.id FROM applicants a
  LEFT JOIN mentor_details m ON m.mentor_id = a.id
  LEFT JOIN mentor_course_details c ON m.mentor_id = c.mentor_id ".$where." AND a.role = '1' ";
  $mentor_ids = $this->db->query($sqls)->result_array();

  if(!empty($mentor_ids)){
    foreach($mentor_ids as $m){
      $m_ids[]=$m['id'];
    }
  }
}


if(!empty($m_ids)){
  $m_ids = array_unique($m_ids);
  $m_ids =implode(',',$m_ids);
  $course_where = 'WHERE applicants.id IN ('.$m_ids.') AND ';      
}else{

 if(!empty($_POST['subject_id']) || !empty($_POST['subject_id'])){
  $course_where = 'WHERE applicants.id=27000 AND ';
}else{
  $course_where = 'WHERE';    
}
}




$gender = $_POST['gender'];
$keyword = $_POST['keyword'];

$query = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,mentor_details.country,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
LEFT JOIN mentor_course_details ON mentor_course_details.mentor_id = mentor_details.mentor_id 
LEFT JOIN courses ON courses.course_id = mentor_course_details.course_id
LEFT JOIN subject ON subject.subject_id = mentor_course_details.subject_id
LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
$course_where applicants.role=1   ";

$advance_key="";

if(!empty($_POST['under_college'])){
  $advance_key .= "mentor_details.under_college LIKE '%$_POST[under_college]%' ";
}
if(!empty($_POST['under_major'])){
  if(!empty($advance_key)){
    $advance_key .= 'OR ';
  }
  $advance_key .= " mentor_details.under_major LIKE '%$_POST[under_major]%' ";
}
if(!empty($_POST['graduate_college'])){
  if(!empty($advance_key)){
    $advance_key .= 'OR ';
  }
  $advance_key .= " mentor_details.graduate_college LIKE '%$_POST[graduate_college]%' ";
}
if(!empty($_POST['degree'])){
  if(!empty($advance_key)){
    $advance_key .= 'OR ';
  }
  $advance_key .= " mentor_details.degree LIKE '%$_POST[degree]%' ";
}
if(!empty($_POST['city'])){
  if(!empty($advance_key)){
    $advance_key .= 'OR ';
  }
  $advance_key .= " mentor_details.city LIKE '%$_POST[city]%' ";
}
if(!empty($_POST['state'])){
  if(!empty($advance_key)){
    $advance_key .= 'OR ';
  }
  $advance_key .= " mentor_details.state LIKE '%$_POST[state]%' ";
}
if(!empty($_POST['country'])){
  if(!empty($advance_key)){
    $advance_key .= 'OR ';
  }
  $advance_key .= " mentor_details.country LIKE '%$_POST[country]%' ";
}





if(!empty($keyword)){
  $query .=  "AND  (`applicants`.`first_name` LIKE '%$keyword%'  OR `applicants`.`last_name` LIKE '%$keyword%' OR courses.course like '%$keyword%' OR subject.subject like '%$keyword%') ";
}
if(!empty($advance_key)){
  $query .=  "AND  (".$advance_key.") ";
}

if(!empty($gender)) {   
  $query .=  " AND `mentor_gender` LIKE '%" . $gender . "%'";
}


$query .="GROUP BY applicants.id ";

if(!empty($_POST['order_by'])){

 if($_POST['order_by'] == 'Rating'){
  $query .=" ORDER BY rating_value DESC ";
}
if($_POST['order_by'] == 'Popular'){
  $query .=" ORDER BY rating_count DESC ";
}
if($_POST['order_by'] == 'Latest'){
  $query .=" ORDER BY app_id DESC ";
}

if($_POST['order_by'] == 'Free'){
  $query .=" AND mentor_details.charge_type = 'free' ";
}
}



$data['count'] = $this->db->query($query)->num_rows();

$paged = $_POST['page'];
$resultsPerPage = 5;

if($paged > 0){
  $page_limit= $resultsPerPage * ($paged-1);
  $query .=" LIMIT  $page_limit, $resultsPerPage";
}

else{
  $query .=" LIMIT 0 , $resultsPerPage";
}

$result =  $this->db->query($query)->result_array();

$mentor = array();
$datas = array();

if(!empty($result)){

  foreach ($result as $l) {
    $mentor['user_id']=!empty($l['app_id'])?$l['app_id']:'';
    $mentor['full_name']=$l['first_name'].' '.$l['last_name'];
    $mentor['username']=!empty($l['username'])?$l['username']:'';
    $mentor['profile_img']=$this->get_user_image($l['app_id']);
    $mentor['email']=!empty($l['email'])?$l['email']:'';
    $mentor['country']=!empty($l['country'])?$l['country']:'';
    $mentor['personal_message'] = !empty($l['mentor_personal_message'])?$l['mentor_personal_message']:'';

    if($l['charge_type'] == 'charge' ){ 
      $mentor['is_free']=false;                            
      $mentor['hourly_rate']=$l['hourly_rate'];                                            
    }else{  
      $mentor['is_free']=true;                    
      $mentor['hourly_rate']='0.00';                                                   
    }

    $mentor['course'] = $this->get_course_details($l['app_id']);
    $mentor['rating_count']=!empty($l['rating_count'])?$l['rating_count']:'0';
    $mentor['rating_value']=!empty($l['rating_value'])?$l['rating_value']:'0';
    $datas[]=$mentor;
  }
}


$data['current_page_no']= $_POST['page'];
$data['total_page']= ceil($data['count']/$resultsPerPage);
$data['data']= $datas;

echo json_encode($data);



}

Public function search_all_mentee(){

  // echo '<pre>';
  // print_r($_POST);
  // exit;



 if(!empty($_POST['subject_id'])){    
  $where = " WHERE  c.subject_id = ".$_POST['subject_id']; 
}

if(!empty($_POST['course_id'])){    
  $where .= " AND c.course_id = ".$_POST['course_id'];
}

if(!empty($where)){  

  $sqls = "SELECT a.id FROM applicants a
  LEFT JOIN mentor_details m ON m.mentor_id = a.id
  LEFT JOIN mentor_course_details c ON m.mentor_id = c.mentor_id ".$where." AND a.role = '0' ";
  $mentor_ids = $this->db->query($sqls)->result_array();

  if(!empty($mentor_ids)){
    foreach($mentor_ids as $m){
      $m_ids[]=$m['id'];
    }
  }
}


if(!empty($m_ids)){
  $m_ids = array_unique($m_ids);
  $m_ids =implode(',',$m_ids);
  $course_where = 'WHERE applicants.id IN ('.$m_ids.') AND ';      
}else{

 if(!empty($_POST['subject_id']) || !empty($_POST['subject_id'])){
  $course_where = 'WHERE applicants.id=27000 AND ';
}else{
  $course_where = 'WHERE';    
}
}




$gender = $_POST['gender'];
$keyword = $_POST['keyword'];

$query = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,mentor_details.country,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
LEFT JOIN mentor_course_details ON mentor_course_details.mentor_id = mentor_details.mentor_id 
LEFT JOIN courses ON courses.course_id = mentor_course_details.course_id
LEFT JOIN subject ON subject.subject_id = mentor_course_details.subject_id
LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
$course_where applicants.role=0   ";


$advance_key="";

if(!empty($_POST['under_college'])){
  $advance_key .= "mentor_details.under_college LIKE '%$_POST[under_college]%' ";
}
if(!empty($_POST['under_major'])){
  if(!empty($advance_key)){
    $advance_key .= 'OR ';
  }
  $advance_key .= " mentor_details.under_major LIKE '%$_POST[under_major]%' ";
}
if(!empty($_POST['graduate_college'])){
  if(!empty($advance_key)){
    $advance_key .= 'OR ';
  }
  $advance_key .= " mentor_details.graduate_college LIKE '%$_POST[graduate_college]%' ";
}
if(!empty($_POST['degree'])){
  if(!empty($advance_key)){
    $advance_key .= 'OR ';
  }
  $advance_key .= " mentor_details.degree LIKE '%$_POST[degree]%' ";
}
if(!empty($_POST['city'])){
  if(!empty($advance_key)){
    $advance_key .= 'OR ';
  }
  $advance_key .= " mentor_details.city LIKE '%$_POST[city]%' ";
}
if(!empty($_POST['state'])){
  if(!empty($advance_key)){
    $advance_key .= 'OR ';
  }
  $advance_key .= " mentor_details.state LIKE '%$_POST[state]%' ";
}
if(!empty($_POST['country'])){
  if(!empty($advance_key)){
    $advance_key .= 'OR ';
  }
  $advance_key .= " mentor_details.country LIKE '%$_POST[country]%' ";
}





if(!empty($keyword)){
  $query .=  "AND  (`applicants`.`first_name` LIKE '%$keyword%'  OR `applicants`.`last_name` LIKE '%$keyword%' OR courses.course like '%$keyword%' OR subject.subject like '%$keyword%') ";
}
if(!empty($advance_key)){
  $query .=  "AND  (".$advance_key.") ";
}


$query .="GROUP BY applicants.id ";

if(!empty($_POST['order_by'])){

 if($_POST['order_by'] == 'Rating'){
  $query .=" ORDER BY rating_value DESC ";
}
if($_POST['order_by'] == 'Popular'){
  $query .=" ORDER BY rating_count DESC ";
}
if($_POST['order_by'] == 'Latest'){
  $query .=" ORDER BY app_id DESC ";
}

if($_POST['order_by'] == 'Free'){
  $query .=" AND mentor_details.charge_type = 'free' ";
}
}



$data['count'] = $this->db->query($query)->num_rows();

$paged = $_POST['page'];
$resultsPerPage = 5;

if($paged > 0){
  $page_limit= $resultsPerPage * ($paged-1);
  $query .=" LIMIT  $page_limit, $resultsPerPage";
}

else{
  $query .=" LIMIT 0 , $resultsPerPage";
}

$result =  $this->db->query($query)->result_array();

$mentor = array();
$datas = array();

if(!empty($result)){

  foreach ($result as $l) {
    $mentor['user_id']=!empty($l['app_id'])?$l['app_id']:'';
    $mentor['full_name']=$l['first_name'].' '.$l['last_name'];
    $mentor['username']=!empty($l['username'])?$l['username']:'';
    $mentor['profile_img']=$this->get_user_image($l['app_id']);
    $mentor['email']=!empty($l['email'])?$l['email']:'';
    $mentor['country']=!empty($l['country'])?$l['country']:'';
    $mentor['personal_message'] = !empty($l['mentor_personal_message'])?$l['mentor_personal_message']:'';

    if($l['charge_type'] == 'charge' ){ 
      $mentor['is_free']=false;                            
      $mentor['hourly_rate']=$l['hourly_rate'];                                            
    }else{  
      $mentor['is_free']=true;                    
      $mentor['hourly_rate']='0.00';                                                   
    }

    $mentor['course'] = $this->get_course_details($l['app_id']);
    $mentor['rating_count']=!empty($l['rating_count'])?$l['rating_count']:'0';
    $mentor['rating_value']=!empty($l['rating_value'])?$l['rating_value']:'0';
    $datas[]=$mentor;
  }
}


$data['current_page_no']= $_POST['page'];
$data['total_page']= ceil($data['count']/$resultsPerPage);
$data['data']= $datas;

echo json_encode($data);



}

public function search_right()
{



  if(!empty($_POST['keyword'])){  /*Guru name search here */
    $user_name = $_POST['keyword'];
    $query = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
    LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
    LEFT JOIN country_list ON country_list.country_id = mentor_details.country where applicants.role=1     
    AND  (`applicants`.`first_name` LIKE '%$user_name%' ESCAPE '!' OR `applicants`.`last_name` LIKE '%$user_name%' ) ORDER BY applicants.first_name LIMIT 5 ";



    $query1 = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
    LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
    LEFT JOIN country_list ON country_list.country_id = mentor_details.country where applicants.role=1 AND (`applicants`.`first_name` LIKE '%$user_name%' ESCAPE '!'   OR `applicants`.`last_name` LIKE '%$user_name%' ) ";



  }
  else{ /* Without search */
    $query = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
    LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
    LEFT JOIN country_list ON country_list.country_id = mentor_details.country where applicants.role=1 ORDER BY applicants.first_name";

    $query1 = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
    LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
    LEFT JOIN country_list ON country_list.country_id = mentor_details.country where applicants.role=1 ORDER BY applicants.first_name  ";

  }

  $data['gurus'] = $this->db->query($query)->result_array();



  $data['count'] = $this->db->query($query1)->num_rows();

  if(!empty($data['gurus'])){
    echo $this->load->view('home/applicant/gurus_search_single_view',$data,TRUE);
  }else{
    echo $sts;
  }

}

public function get_course_by_subject(){
  $where = array('subject_id' => $_POST['subject_id']);
  $data = $this->db->select('course,course_id')->get_where('courses',$where)->result();
  echo json_encode($data);

}

public function search_left()
{

  if(!empty($_POST['subject_id'])){
    // $where += array('subject_id'=>$_POST['subject_id']); 
    $where = "WHERE a.role = '1' AND  c.subject_id = ".$_POST['subject_id']; 
  }else{
    $where = "WHERE a.role = '1' "; 
  }

  if(!empty($_POST['course_id'])){
    // $where += array('course_id'=>$_POST['course_id']);  
    $where .= " AND c.course_id = ".$_POST['course_id'];
  }

  if(!empty($where)){
   // $mentor_ids = $this->db->select('mentor_id')->get_where('mentor_course_details',$where)->result_array();  

    $sqls = "SELECT a.id FROM applicants a
    LEFT JOIN mentor_details m ON m.mentor_id = a.id
    LEFT JOIN mentor_course_details c ON m.mentor_id = c.mentor_id ".$where;
    $mentor_ids = $this->db->query($sqls)->result_array();

    if(!empty($mentor_ids)){
      foreach($mentor_ids as $m){
        $m_ids[]=$m['id'];
      }
    }
  }



  if(!empty($m_ids)){
    $m_ids =implode(',',$m_ids);
    $wheres = 'WHERE applicants.id IN ('.$m_ids.') AND ';      
  }else{

   if(!empty($_POST['subject_id']) || !empty($_POST['subject_id'])){
    $wheres = 'WHERE applicants.id=27000 AND ';
  }else{
    $wheres = 'WHERE';    
  }



}


$sts = 0;
$resultsPerPage = 5;
$gender = $this->input->post('gender');

$query = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,mentor_details.country,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
$wheres applicants.role=1 ";

if(!empty($gender)) {		
  $query .=  " AND `mentor_gender` LIKE '%" . $gender . "%'";
}

if(!empty($_POST['order_by'])){

 if($_POST['order_by'] == 'Rating'){
  $query .=" ORDER BY rating_value DESC ";
}
if($_POST['order_by'] == 'Popular'){
  $query .=" ORDER BY rating_count DESC ";
}
if($_POST['order_by'] == 'Latest'){
  $query .=" ORDER BY app_id DESC ";
}

if($_POST['order_by'] == 'Free'){
  $query .=" AND mentor_details.charge_type = 'free' ";
}
}

$data['count'] = $this->db->query($query)->num_rows();
$query .= " LIMIT 0,5";

       // echo $query; exit;
$data['gurus'] = $this->db->query($query)->result_array();


if(!empty($data['gurus'])){
 echo $this->load->view('home/applicant/gurus_search_single_view',$data,TRUE);
}else{
 echo $sts;
}

}

public function gurus_list_view()
{
 if($this->session->userdata('applicant_id') == '')
 {
  redirect('login');
}
if($this->session->userdata('role') == 0){
  $data['theme'] = 'applicant';
  $data['gurus'] = $this->applicant_modal->mentor_list_view();
}else{
  $data['theme'] = 'guru';
  $data['gurus'] = $this->user_model->applicant_list_view();
}
$list_view = $this->load->view('home/'.$data['theme'].'/gurus_ajax_list_view',$data);
echo $list_view;
}

public function gurus_grid_view()
{
	if($this->session->userdata('applicant_id') == '')
	{
		redirect('login');
	}
	if($this->session->userdata('role') == 0){
		$data['theme'] = 'applicant';
		$data['gurus'] = $this->applicant_modal->mentor_list_view();
	}else{
		$data['theme'] = 'guru';
		$data['gurus'] = $this->user_model->applicant_list_view();
	}
	$grid_view = $this->load->view('home/'.$data['theme'].'/gurus_ajax_grid_view',$data);
	echo $grid_view;
}

public function loadmore_guru()
{


	if($this->input->post('page')):
		$paged = $this->input->post('page');
		$resultsPerPage = 5;
		$post_values['mentor_gender'] = $this->input->post('mentor_gender');

		$fields = array('mentor_gender');
		$conditions = array();
            //$post_values = $this->input->post();
		foreach($fields as $field){
			if(isset($post_values[$field]) && $post_values[$field] != '') {
				$conditions[] = "`$field` LIKE '%" . $post_values[$field] . "%'";
			}
		}

		$query = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,mentor_details.country as country_name,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
    LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id        
    where applicants.role=1";

    if(count($conditions) > 0) {
     $operator = (count($conditions) > 1) ? ' AND ' : ' OR ';
              $query .= " AND  " . implode ($operator, $conditions); // you can change to 'OR', but I suggest to apply the filters cumulative
            }


            if(!empty($_POST['order_by'])){

             if($_POST['order_by'] == 'Rating'){
              $query .=" ORDER BY rating_value DESC ";
            }
            if($_POST['order_by'] == 'Popular'){
              $query .=" ORDER BY rating_count DESC ";
            }
            if($_POST['order_by'] == 'Latest'){
              $query .=" ORDER BY app_id DESC ";
            }

            if($_POST['order_by'] == 'Free'){
              $query .=" AND mentor_details.charge_type = 'free' ";
            }
          }



          if($paged > 0){
           $page_limit= $resultsPerPage * ($paged-1);
           $pagination_sql=" LIMIT  $page_limit, $resultsPerPage";
         }
         else{
           $pagination_sql=" LIMIT 0 , $resultsPerPage";
         }
           //echo $query.$pagination_sql;exit;
         $result= $this->db->query($query.$pagination_sql);
         $data['gurus'] = $result->result_array();
         if(count($data['gurus']) == $resultsPerPage){
           $page = $paged + 1;
           $data['loadcount'] = $page;
         }
         else{
           $data['loadcount'] = '';
         }
         if(count($data['gurus']) == 0)
         {
           echo '<center>No more Mentors</center>';
         }
         if(!empty($data['gurus'])){
           echo $this->load->view('home/applicant/gurus_loadmore_list_view',$data,TRUE);
         }
       endif;
     }

     Public function get_user_image($id)
     {
      $query = "SELECT app.profile_img,social.picture_url
      from  applicants app 
      LEFT join social_applicant_user social on social.reference_id = app.id where app.id = $id";


      $data =  $this->db->query($query)->row_array();
      if(!empty($data['profile_img'])){
        $img = base_url().'assets/images/'.$data['profile_img'];
      }else if(!empty($data['picture_url']) && empty($data['profile_img'])){
        $img = $data['picture_url'];
      }else{    
        $img =base_url().'assets/images/default-avatar.png';        
      }  
      return $img;

    }

    Public function get_course_details($mentor_id){
      $where  = array('m.mentor_id'=>$mentor_id);
      $courses = $this->db
      ->select('c.course')                                                
      ->join('courses c','c.course_id = m.course_id','left')
      ->join('subject s','s.subject_id = c.subject_id','left')
      ->get_where('mentor_course_details m',$where)
      ->result_array(); 
      $subs=array();
      if(!empty($courses)){
        foreach($courses as $s){
          $subs[]=$s['course'];
        }
        $course = implode(',',$subs);

      }else{
        $course = '';
      }
      return  $course;
    }
    Public function common_search(){

      $data = json_decode( file_get_contents( 'php://input' ), true );
      if(empty($data)){
        $data = $this->input->post();
      }

      $page_no = !empty($data['page_no'])?$data['page_no']:1;
      $per_page = 5;
      /* Validation Ends */
      $list = $this->user_model->common_search($page_no,$per_page);

      // echo $this->db->last_query();

      if(!empty($list)){

        error_reporting(1);

        $mentor = array();
        $datas = array();


        foreach ($list as $l) {
          $mentor['user_id']=!empty($l['user_id'])?$l['user_id']:'';
          $mentor['full_name']=$l['first_name'].' '.$l['last_name'];
          $mentor['username']=!empty($l['username'])?$l['username']:'';
          $mentor['profile_img']=$this->get_user_image($l['user_id']);
          $mentor['email']=!empty($l['email'])?$l['email']:'';
          $mentor['country']=!empty($l['country'])?$l['country']:'';
          $mentor['personal_message'] = !empty($l['mentor_personal_message'])?$l['mentor_personal_message']:'';

          if($l['charge_type'] == 'charge' ){ 
            $mentor['is_free']=false;                            
            $mentor['hourly_rate']=$l['hourly_rate'];                                            
          }else{  
            $mentor['is_free']=true;                    
            $mentor['hourly_rate']='0.00';                                                   
          }

          $mentor['course'] = $this->get_course_details($l['user_id']);
          $mentor['rating_count']=!empty($l['rating_count'])?$l['rating_count']:'0';
          $mentor['rating_value']=!empty($l['rating_value'])?$l['rating_value']:'0';
          $datas[]=$mentor;
        }
        

        $total_mentors = $this->user_model->common_search_count();
        $total_pages = $total_mentors / $per_page;  
        $total_pages = ceil($total_pages);


        if($total_pages  ==  0 ){
          $total_pages = 1;
        }

        $response = array('mentor_list' => $datas,'total_mentors' => (string)$total_mentors,'total_pages' => (string) $total_pages ,'current_page' => (string)$page_no);

        echo json_encode($response);


      }
    }


    public function loadmore_search_guru_home()
    {

     if(!empty($_POST['subject_id'])){
    // $where += array('subject_id'=>$_POST['subject_id']); 
      $where = "WHERE a.role = '1' AND  c.subject_id = ".$_POST['subject_id']; 
    }else{
      $where = "WHERE a.role = '1' "; 
    }

    if(!empty($_POST['course_id'])){
    // $where += array('course_id'=>$_POST['course_id']);  
      $where .= " AND c.course_id = ".$_POST['course_id'];
    }


    if(!empty($where)){
   // $mentor_ids = $this->db->select('mentor_id')->get_where('mentor_course_details',$where)->result_array();  

      $sqls = "SELECT a.id FROM applicants a
      LEFT JOIN mentor_details m ON m.mentor_id = a.id
      LEFT JOIN mentor_course_details c ON m.mentor_id = c.mentor_id ".$where;
      $mentor_ids = $this->db->query($sqls)->result_array();

      if(!empty($mentor_ids)){
        foreach($mentor_ids as $m){
          $m_ids[]=$m['id'];
        }
      }
    }

    if($this->input->post('page')):

      $paged = $this->input->post('page');
      $resultsPerPage = 5;
      $mentor['mentor_gender'] = $this->input->post('gender');    

      $mentor['mentor_personal_message'] = '';
      $keyword = $this->input->post('keyword');

      $mentor_personal_message = "( applicants.first_name LIKE '%$keyword%' OR applicants.last_name LIKE '%$keyword%' OR mentor_details.mentor_personal_message LIKE '%$keyword%' )";

      $query = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,mentor_details.country,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
      LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
      LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
      where applicants.role=1 AND  $mentor_personal_message ";

      if(!empty($m_ids)){
        $m_ids =implode(',',$m_ids);
        $query .= 'AND applicants.id IN ('.$m_ids.') ';      
      }

      if($paged > 0){
       $page_limit= $resultsPerPage * ($paged-1);
       $pagination_sql=" LIMIT  $page_limit, $resultsPerPage";
     }
     else{
       $pagination_sql=" LIMIT 0 , $resultsPerPage";
     }


     $data['gurus'] = $this->db->query($query.$pagination_sql)->result_array();

     $data['count'] = count($data['gurus']);
     if(count($data['gurus']) == $resultsPerPage){
       $page = $paged + 1;
       $data['loadcount'] = $page;
     }
     else{
       $data['loadcount'] = '';
     }
     if(count($data['gurus']) == 0)
     {
       echo '<center>No more Mentors</center>';
     }
           // echo $page;exit;
     if(!empty($data['gurus'])){
       echo $this->load->view('home/applicant/gurus_search_list_view',$data,TRUE);
     }
   endif;

 }









 public function loadmore_applicant()
 {



   if($this->input->post('page')):
    $paged = $this->input->post('page');
    $resultsPerPage = 5;
    $sql = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.role,applicants.profile_img,social_applicant_user.picture_url,applicants_profile.*,mentor_details.* FROM   applicants
    LEFT JOIN `applicants_profile` ON applicants.id = applicants_profile.applicant_id
    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
    LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id    
    where applicants.role=0  ORDER BY applicants.id DESC";

    if($paged > 0){
     $page_limit= $resultsPerPage * ($paged-1);
     $pagination_sql=" LIMIT  $page_limit, $resultsPerPage";
   }
   else{
     $pagination_sql=" LIMIT 0 , $resultsPerPage";
   }

   $result= $this->db->query($sql.$pagination_sql);
   $data['gurus'] = $result->result_array();
   if(count($data['gurus']) == $resultsPerPage){
     $page = $paged + 1;
     $data['loadcount'] = $page;
   }
   else{
     $data['loadcount'] = '';
   }
   if(count($data['gurus']) == 0)
   {
     echo '<center>No more Applicants</center>';
   }

   if(!empty($data['gurus'])){
     echo $this->load->view('home/guru/gurus_loadmore_list_view',$data);
   }

 endif;
}

public function edit_profile()
{
  if($this->session->userdata('applicant_id') == '')
  {
    redirect('login');
  }

  $this->data['title'] = 'Profile';
  $id = $this->session->userdata('applicant_id');
  $this->data['module'] = 'edit_profile';
  
  if($this->session->userdata('role') == 0){
    $this->data['theme'] = 'applicant';    
  }else if($this->session->userdata('role') == 1){
    $this->data['theme'] = 'guru';
    
  }
  $this->data['gurus'] = $this->user_model->get_progress_bar($id);
  $this->data['result'] = $this->user_model->get_progress_bar($id); 
  // echo '<pre>';
  // print_r($this->data);
  // exit; 
  $this->load->vars($this->data);
  $this->load->view('template');
}

public function edit_course()
{


  $this->data['title'] = 'Edit Course';
  $id = $this->session->userdata('applicant_id');
  $this->data['module'] = 'edit_course';
  
  if($this->session->userdata('role') == 0){
    $this->data['theme'] = 'applicant';    
  }else if($this->session->userdata('role') == 1){
    $this->data['theme'] = 'guru';    
  }else{
    redirect('login');
  }
  $this->data['subject'] = $this->user_model->get_all_subjects();  
  $this->data['result'] = $this->user_model->get_progress_bar($id); 
   // echo '<pre>';
   // print_r($this->data);
   // exit; 
  $this->load->vars($this->data);
  $this->load->view('template');

}

public function profile($id = '')
{
	if($this->session->userdata('applicant_id') == '')
	{
		redirect('login');
	}




	$id = $this->session->userdata('applicant_id');
  $this->data['module'] = 'guru_profile';
  $this->data['title'] = 'Profile';
  if($this->session->userdata('role') == 0){
    $this->data['theme'] = 'applicant';
    $this->data['gurus'] = $this->user_model->get_progress_bar($id);
  }else if($this->session->userdata('role') == 1){
    $this->data['theme'] = 'guru';
    $this->data['gurus'] = $this->user_model->get_progress_bar($id);
    $this->data['result'] = $this->user_model->get_progress_bar($id);
  }else if($this->session->userdata('role') == 2){
    $this->data['module'] = 'profile';
    $this->data['gurus'] = $this->user_model->get_progress_bar($id);
  }


  // echo '<pre>'; print_r($this->data);

  $this->load->vars($this->data);
  $this->load->view('template');
}

public function check_username()
{
	$username = $this->input->get('username');
	$id = $this->session->userdata('applicant_id');
	$result = $this->db->query("SELECT * FROM `applicants` WHERE `username` = '".$username."' and `id` != '".$id."'")->row_array();
	$isAvailable = true;
	if(sizeof($result)>0)
	{
		$isAvailable = false;
	}
	echo json_encode(array('valid' => $isAvailable));
}




public function messages($id = '')
{
	if($this->session->userdata('applicant_id') == '')
	{
		redirect('login');
	}

	$id = $this->session->userdata('applicant_id');
	$this->data['module'] = 'messages_view';
	if($this->session->userdata('role') == 0){
		$this->data['theme'] = 'applicant';
		$this->data['gurus'] = $this->applicant_modal->get_progress_bar($id);
		$this->data['mentor_details'] = $this->user_model->get_progress_bar($id);
		$this->data['activity_list'] = $this->applicant_modal->get_chat_list($id);
	}else{
		$this->data['theme'] = 'guru';
		$this->data['gurus'] = $this->user_model->get_progress_bar($id);
		$this->data['applicant_details'] = $this->applicant_modal->get_progress_bar($id);
		$this->data['activity_list'] = $this->user_model->get_chat_list($id);
	}

  // echo '<pre>';
  // print_r($this->data);
  // exit;

	$this->load->vars($this->data);
	$this->load->view('template');
}



public function get_selected_chat()
{
	$selected_user = $this->input->post('selected_user');
	$session_id = $this->session->userdata('applicant_id');
	$data['latest_chat'] = $this->applicant_modal->get_latest_chat($selected_user,$session_id);
	$this->applicant_modal->unread_to_read_count($selected_user,$session_id);
	$data['receiver'] = $this->applicant_modal->get_receiver_data($selected_user);
	echo $this->load->view('home/applicant/chat_detail_view',$data,TRUE);
}





public function get_old_messages()
{
  // echo '<pre>';
  // print_r($_POST);
  // exit;
	if($_POST['total']<0){
		return false;
	}
	$total = $_POST['total'];
	$total = $total * 5;
	$this->load->model('applicant_modal');
	$session_id = $this->session->userdata('applicant_id');
	$selected_user = $_POST['selected_user_id'];
	$latest_chat= $this->applicant_modal->get_old_chat($selected_user,$session_id,$total);



  // echo $this->db->last_query();
  // exit;
	$html ='';
	if(isset($latest_chat)!=''){
		foreach($latest_chat as $key => $currentuser) :

			$class_name =($currentuser['sender_id'] != $session_id) ? 'chat-left' : '';
			$user_image = ($currentuser['senderImage']!= '') ? base_url().'assets/images/'.$currentuser['senderImage']: base_url().'assets/images/default-avatar.png';


			if($currentuser['senderImage']!=''){
				$img =  base_url().'assets/images/'.$currentuser['senderImage'];
			}elseif($currentuser['socialImage']!=''){
				$img = $currentuser['socialImage'];
			}else{
				$img = base_url().'assets/images/default-avatar.png';
			}


			$time_zone = $this->session->userdata('time_zone');
			$from_timezone = $currentuser['time_zone'];
			$date_time = $currentuser['chatdate'];
			$date_time  = $this->converToTz($date_time,$time_zone,$from_timezone);
			$time = date('d-m-Y h:i a',strtotime($date_time));


			if($currentuser['type'] == 'image'){

				$html .='<div class="chat '.$class_name.'">
				<div class="chat-avatar">
				<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
				<img  src="'.$img.'" class="img-responsive img-circle">
				</a>
				</div>
				<div class="chat-body">
				<div class="chat-content">
				<p><img alt="" src="'.base_url().$currentuser['file_path'].'/'.$currentuser['file_name'].'" class="img-responsive"></p>
				<a href="'.base_url().$currentuser['file_path'].'/'.$currentuser['file_name'].'" target="_blank" download>Download</a>
				<span class="chat-time">'.$time.'</span>
				</div>
				</div>
				</div>';

			}else if($currentuser['type'] == 'others'){

				$html .='<div class="chat '.$class_name.'">
				<div class="chat-avatar">
				<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
				<img  src="'.$img.'" class="img-responsive img-circle">
				</a>
				</div>
				<div class="chat-body">
				<div class="chat-content">
				<p><img alt="" src="'.base_url().'assets/images/download.png" class="img-responsive"></p>
				<a href="'.base_url().$currentuser['file_path'].'/'.$currentuser['file_name'].'" target="_blank" download>Download</a>
				<span class="chat-time">'.$time.'</span>
				</div>
				</div>
				</div>';


			}else{

				$html .='<div class="chat '.$class_name.'">
				<div class="chat-avatar">
				<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
				<img  src="'.$img.'" class="img-responsive img-circle">
				</a>
				</div>
				<div class="chat-body">
				<div class="chat-content">
				<p>
				'.$currentuser['msg'].'
				</p>
				<span class="chat-time">'.$time.'</span>
				</div>
				</div>
				</div>';

			}




		endforeach;
		$html .='<div id="ajax"></div><input type="hidden"  id="hidden_id">';

	}

	echo $html;

}



public function get_messages()
{

	$this->load->model('applicant_modal');
	$session_id = $this->session->userdata('applicant_id');
	$selected_user = $_POST['selected_user_id'];
	$latest_chat= $this->applicant_modal->get_latest_chat($selected_user,$session_id);
  $total_chat= $this->applicant_modal->get_total_chat_count($selected_user,$session_id);
  $last_message_id= $this->applicant_modal->get_last_message_id($selected_user,$session_id);


  if($total_chat>5){
    $total_chat = $total_chat - 5;
    $page = $total_chat / 5;
    $page = ceil($page);
    $page--;
  }



  // echo $this->db->last_query();
  // exit;

  if(count($latest_chat)>4){

    $html ='<div class="load-more-btn text-center" total="'.$page.'">
    <button class="btn btn-default" data-page="2"><i class="fa fa-refresh"></i> Load More</button>
    </div><div id="ajax_old" class="ajax_old"></div>';
  }else{
    $html ='';
  }



  if(!empty($latest_chat)){
    foreach($latest_chat as $key => $currentuser) :


     $class_name =($currentuser['sender_id'] != $session_id) ? 'chat-left' : '';
     $user_image = ($currentuser['senderImage']!= '') ? base_url().'assets/images/'.$currentuser['senderImage']: base_url().'assets/images/default-avatar.png';


     if($currentuser['senderImage']!=''){
      $img =  base_url().'assets/images/'.$currentuser['senderImage'];
    }elseif($currentuser['socialImage']!=''){
      $img = $currentuser['socialImage'];
    }else{
      $img = base_url().'assets/images/default-avatar.png';
    }


    $time_zone = $this->session->userdata('time_zone');
    $from_timezone = $currentuser['time_zone'];
    $date_time = $currentuser['chatdate'];
    $date_time  = $this->converToTz($date_time,$time_zone,$from_timezone);
    $time = date('d-m-Y h:i a',strtotime($date_time));


    if($currentuser['type'] == 'image'){

      $html .='<div class="chat '.$class_name.'">
      <div class="chat-avatar">
      <a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
      <img  src="'.$img.'" class="img-responsive img-circle">
      </a>
      </div>
      <div class="chat-body">
      <div class="chat-content">
      <p><img alt="" src="'.base_url().$currentuser['file_path'].'/'.$currentuser['file_name'].'" class="img-responsive"></p>
      <p>'.$currentuser['file_name'].'</p>
      <a href="'.base_url().$currentuser['file_path'].'/'.$currentuser['file_name'].'" target="_blank" download>Download</a>
      <span class="chat-time">'.$time.'</span>
      </div>
      </div>
      </div>';

    }else if($currentuser['type'] == 'others'){

      $html .='<div class="chat '.$class_name.'">
      <div class="chat-avatar">
      <a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
      <img  src="'.$img.'" class="img-responsive img-circle">
      </a>
      </div>
      <div class="chat-body">
      <div class="chat-content">
      <p><img alt="" src="'.base_url().'assets/images/download.png" class="img-responsive"></p>
      <p>'.$currentuser['file_name'].'</p>
      <a href="'.base_url().$currentuser['file_path'].'/'.$currentuser['file_name'].'" target="_blank" download class="chat-time">Download</a>
      <span class="chat-time">'.$time.'</span>
      </div>
      </div>
      </div>';


    }
    else if($currentuser['msg']=='ENABLE_STREAM' || $currentuser['msg']=='DISABLE_STREAM'){


    }else{
      $html .='<div class="chat '.$class_name.'">
      <div class="chat-avatar">
      <a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
      <img  src="'.$img.'" class="img-responsive img-circle">
      </a>
      </div>
      <div class="chat-body">
      <div class="chat-content">
      <p>
      '.$currentuser['msg'].'
      </p>
      <span class="chat-time">'.$time.'</span>
      </div>
      </div>
      </div>';

    }




  endforeach;


}
$html .='<div id="ajax"></div><input type="hidden"  id="hidden_id" value="">';

if($total_chat == 0){
  $html .='<div class="no_message">No Record Found</div>';
}


echo $html;

}




public function get_guru_selected_chat()
{
	$selected_user = $this->input->post('selected_user');
	$session_id = $this->session->userdata('applicant_id');
	$data['latest_chat'] = $this->user_model->get_latest_chat($selected_user,$session_id);
	$this->user_model->unread_to_read_count($selected_user,$session_id);
	$data['receiver'] = $this->applicant_modal->get_receiver_data($selected_user);
	echo $this->load->view('home/guru/chat_detail_view',$data);
}

public function get_new_message_count()
{
	$selected_user = $this->get_user_id();
	$session_id = $this->session->userdata('applicant_id');
	$data = $this->applicant_modal->get_unread_chat_count($selected_user,$session_id);
	echo count($data);
}


Public function get_user_id()
{
	$where = array('username' => $_POST['selected_user']);
	return $this->db->get_where('applicants',$where)->row()->id;
}


public function get_guru_message_count()
{
	$selected_user = $this->input->post('selected_user');
	$session_id = $this->session->userdata('applicant_id');
	$data = $this->user_model->get_unread_chat_count($selected_user,$session_id);
	echo count($data);
}

public function render_message()
{
	$selected_user = $this->input->post('selected_user');
	$session_id = $this->session->userdata('applicant_id');
	$data['latest_chat'] = $this->applicant_modal->get_render_chat($selected_user,$session_id);
	echo $this->load->view('home/applicant/render_chat_view',$data);

}

public function send_chat()
{
	$selected_user = $this->input->post('selected_user');
	$input_message = $this->input->post('input_message');
	$session_id = $this->session->userdata('applicant_id');
	$data['recieved_id'] = $selected_user;
	$data['sent_id'] = $session_id;
	$data['username'] = '';
	$data['chatdate'] = date('Y-m-d H:i:s');
	$data['msg'] = $input_message;
	if($this->db->insert('chat',$data)){
		$insert_id = $this->db->insert_id();
		$inserted_data = $this->db->get_where('chat',array('id'=>$insert_id))->row_array();
		$current_user = $this->applicant_modal->get_receiver_data($session_id);
		$profileimg = ($current_user['profile_img'] != '') ? base_url().'assets/images/'.$current_user['profile_img']: base_url().'assets/images/avatar.png';
		echo '<div class="chat">
		<div class="chat-avatar">
		<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
		<img alt="June Lane" src="'.$profileimg.'" class="img-responsive img-circle">
		</a>
		</div>
		<div class="chat-body">
		<div class="chat-content">
		<p>'.$input_message.'</p>
		<span class="chat-time">'.$inserted_data['chatdate'].'</span>
		</div>
		</div>
		</div>';
	}
}

Public function get_user_pic()
{
	@$data = $this->db->get_where('applicants',array('username'=>$_POST['username']))->row();
	@$img = $data->profile_img;
	if(!empty($img)){


		$file_to_check = FCPATH . '/assets/images/' . $img;

		if (file_exists($file_to_check)) {
			$img = base_url() . 'assets/images/'.$img;
		}

		$img = ($img != '') ? $img : base_url() . 'assets/images/default-avatar.png';
		echo '<img width="100" height="100" alt="" class="img-circle" src="'.$img.'">';

	}else{
		@$img = $this->db->get_where('social_applicant_user',array('username'=>$_POST['username']))->row()->picture_url;

		$img = ($img != '') ? $img : base_url() . 'assets/images/default-avatar.png';
		echo '<img width="100" height="100" alt="" class="img-circle" src="'.$img.'">';

	}




}

public function conversations()
{
	if($this->session->userdata('applicant_id') == '')
	{
		redirect('login');
	}
	$id = $this->session->userdata('applicant_id');
	$this->data['module'] = 'conversation_view';
	if($this->session->userdata('role') == 0){
		$this->data['theme'] = 'applicant';
		$this->data['today_conversation'] = $this->applicant_modal->get_conversation_data($id);
	}else{
		$this->data['theme'] = 'guru';
		$this->data['today_conversation'] = $this->user_model->get_conversation_data($id);
	}
	$this->load->vars($this->data);
	$this->load->view('template');
}

public function conversation_ajax_request()
{
	$view = 'No More Conversation';
	$id = $this->session->userdata('applicant_id');
	if($this->session->userdata('role') == 1){
		$data['today_conversation'] = $this->user_model->get_conversation_data($id);
		$view = $this->load->view('home/guru/conversation_ajax_view',$data,TRUE);
	}else{
		$data['today_conversation'] = $this->applicant_modal->get_conversation_data($id);
		$view = $this->load->view('home/applicant/conversation_ajax_view',$data,TRUE);
	}
	echo $view; 
}

Public function update_payment(){

  /* Get Invoice id */


  $invoice = $this->db->order_by('invoice_id','desc')->limit(1)->get('payments')->row_array();
  if(empty($invoice)){
    $invoice_id = 0;   
  }else{
    $invoice_id = $invoice['invoice_id'];    
  }
  $invoice_id++;
  $invoice_no = 'I0000'.$invoice_id;

  $where = array('invite_id'=>$_POST['invite_id'],'payment_status'=>0);
  $data = $this->db->get_where('payments',$where)->row();

  if($data->payment_gross!=0){ 


    $amount = $data->payment_gross * 100;
    if(!empty($data)){
        
      \Stripe\Stripe::setApiKey($this->stripe_secret_key);

      $charge = \Stripe\Charge::create(array(
          "amount" =>$amount, // $15.00 this time
          "currency" => "usd",
          "customer" =>$data->stripe_customer_id
        ));
      $data =  json_encode($charge);
      $data =  json_decode($data);

      $update_data = array(
        'payment_status' => $data->paid,
        'txn_id' => $data->balance_transaction,
        'amount' => $data->amount,
        'source_id' => $data->id,        
        'invoice_id' => $invoice_id,
        'invoice_no' => $invoice_no,
        'remarks' => 'Call Charge'        
      );
      $wheres=array('invite_id'=>$_POST['invite_id'],'payment_status'=>0,'transaction_type' => 'CREDIT','role_type'=>'mentee');
      $this->db->update('payments',$update_data,$wheres);



      $update_data1 = array(
        'payment_status' => $data->paid,
        'txn_id' => $data->balance_transaction,
        'amount' => $data->amount,
        'source_id' => $data->id,        
        'invoice_id' => $invoice_id,
        'invoice_no' => $invoice_no,
        'remarks' => 'Handling Charge For #'.$invoice_no        
      );

      
      $wher=array('invite_id'=>$_POST['invite_id'],'payment_status'=>0,'transaction_type' => 'DEBIT','role_type'=>'mentor');

      $this->db->update('payments',$update_data1,$wher);
       $update_d = array(
        'payment_status' => $data->paid,
        'txn_id' => $data->balance_transaction,
        'amount' => $data->amount,
        'source_id' => $data->id,        
        'invoice_id' => $invoice_id,
        'invoice_no' => $invoice_no,
        'remarks' => 'After Commission Charge For #'.$invoice_no        
      );
      
      $whe=array('invite_id'=>$_POST['invite_id'],'payment_status'=>0,'transaction_type' => 'CREDIT','role_type'=>'mentor');

      return $this->db->update('payments',$update_d,$whe);


    }  else{
      return true;
    }
  }else{


   $update_data = array('payment_status' => 1 );
   return  $this->db->update('payments',$update_data,$where);

 }

}

Public function get_names($id){
  $where = array('id'=>$id);
  return $this->db->get_where('applicants',$where)->row_array();
}



Public function generate_session_id(){

  /* Generate a Session Id  */
  $opentok = new OpenTok($this->apiKey, $this->apiSecret);
        // An automatically archived session:
  $sessionOptions = array(
        // 'archiveMode' => ArchiveMode::ALWAYS,
    'mediaMode' => MediaMode::ROUTED
  );
  $new_session = $opentok->createSession($sessionOptions);
        // Store this sessionId in the database for later use
  return  $new_session->getSessionId();
}



Public function old_card_details()
{



  $where = array(
    'card_id' => $_POST['card_id']);
  $card = $this->db->get_where('card_details',$where)->row();


  $datas = array(
    'card' => $card->card,
    'user_id' => $this->session->userdata('applicant_id'),
    'customer_id' => $card->customer_id
  );
  $this->db->insert('card_details',$datas);


              // Sending notification to mentor
  $app_id = $this->session->userdata('pay_to');
  $app_data = $this->get_names($app_id);
  $pay_details =$this->session->userdata('payment_details');
  $current_user_id = $this->session->userdata('applicant_id');
  $user_data  = $this->get_names($current_user_id);

  foreach ($pay_details as $key => $value) {
   $invitedata['from_date_time'] = $value->date_value.' '.$value->start_time;
   $invitedata['to_date_time'] = $value->date_value.' '.$value->end_time;
   $invitedata['invite_from'] = $this->session->userdata('applicant_id');
   $invitedata['invite_to'] = $this->session->userdata('pay_to');   
   $invitedata['invite_date'] = $value->date_value;
   $invitedata['invite_time'] = $value->start_time;
   $invitedata['invite_end_time'] = $value->end_time;
   $invitedata['paid'] = 0;
   $invitedata['time_zone'] = $value->time_zone;
   $invitedata['session_id'] = $this->generate_session_id();


   /* Amount calcaulation */


                // Payment Details
   $mentor_id_1 = $this->session->userdata('pay_to');
   $wh = array('mentor_id'=>$mentor_id_1);
   $amount = $this->db->get_where('mentor_details',$wh)->row_array();

       // $gst = $this->session->userdata('tax_percentage');

   $per_hour_charge =  $amount['hourly_rate'];
   $tax_amount = ($per_hour_charge * GST)/100;       
   $tax_amount = number_format($tax_amount,2);
   $total_amount = $per_hour_charge + $tax_amount;
   $total_amount =number_format($total_amount,2);
   $invitedata['per_hour_charge'] = $per_hour_charge;
   $invitedata['tax_percentage'] = GST;        
   $invitedata['tax_amount'] = $tax_amount;
   $invitedata['total_hours_charge'] = $total_amount;

   /* Amount calcaulation */


   $this->db->insert('invite',$invitedata);
   $insert_id = $this->db->insert_id();

   $mentor_id_1 = $this->session->userdata('pay_to');
   $where = array('mentor_id'=>$mentor_id_1);
   $amount = $this->db->get_where('mentor_details',$where)->row_array();
   $per_hour_charge = $amount['hourly_rate'];
   $handling_charge = ( $per_hour_charge * 20 )  / 100;
  
    $payable_charge = $per_hour_charge - $handling_charge;
   
      // Payment Details
   $data = array(
     'user_id' => $this->session->userdata('applicant_id'),
     'mentor_id' => $this->session->userdata('pay_to'),
     'payment_status' => 0,
     'payment_gross' => $total_amount,
     'payment_date' => date('Y-m-d H:i:s'),
     'currency_code' => 'USD',
     'source' =>'stripe',
     'stripe_customer_id' => $card->customer_id,
     'invite_id' => $insert_id,
     'transaction_type'=>'CREDIT',
     'per_hour_charge' => $per_hour_charge,
     'role_type' => 'mentee'
   );
   $this->db->insert('payments',$data);


   $data = array(
     'user_id' => $this->session->userdata('applicant_id'),
     'mentor_id' => $this->session->userdata('pay_to'),
     'payment_status' => 0,
     'payment_gross' => $total_amount,
     'payment_date' => date('Y-m-d H:i:s'),
     'currency_code' => 'USD',
     'source' =>'stripe',
     'stripe_customer_id' => $card->customer_id,
     'invite_id' => $insert_id,
     'transaction_type'=>'DEBIT',
     'per_hour_charge' => $per_hour_charge,
     'handling_charge' => $handling_charge,
     'role_type' => 'mentor'
   );
   $this->db->insert('payments',$data);


     $data = array(
     'user_id' => $this->session->userdata('applicant_id'),
     'mentor_id' => $this->session->userdata('pay_to'),
     'payment_status' => 0,
     'payment_gross' => $total_amount,
     'payment_date' => date('Y-m-d H:i:s'),
     'currency_code' => 'USD',
     'source' =>'stripe',
     'stripe_customer_id' => $card->customer_id,
     'invite_id' => $insert_id,
     'transaction_type'=>'CREDIT',
     'per_hour_charge' => $per_hour_charge,
     'handling_charge' => $handling_charge,
     'payable_charge' => $payable_charge,
     'role_type' => 'mentor'
   );
   $this->db->insert('payments',$data);





   // $payment_id = $this->db->insert_id();








   $notify_data['mentor_message'] = "You have a call request from <a href='".base_url()."mentor-profile/".$user_data['username']."'>".$user_data['first_name']." ".$user_data['last_name'].'</a>';
   $notify_data['mentee_message'] = "You request a call to <a href='".base_url()."mentee-profile/".$app_data['username']."'>".$app_data['first_name']." ".$app_data['last_name'].'</a>';

   $notify_data['mentor_view'] = 1;
   $notify_data['mentee_view'] = 1;
   $notify_data['user_id'] = $invitedata['invite_to'];
   $notify_data['notification_id'] = $this->session->userdata('applicant_id');   
   $notify_data['read'] = 0;
   $notify_data['invite_id'] = $insert_id;
   $notify_data['created_date'] = date('Y-m-d H:i:s');
   $notify_data['time_zone'] = date_default_timezone_get();
   $response =   $this->db->insert('notifications',$notify_data);


 }

 echo json_encode(array('status' => 200, 'success' => 'Card details stored completed.'));
}



Public function add_card_details(){

  $card_last_digits = substr($_POST['card_number'], -4);
  try {    

    \Stripe\Stripe::setApiKey($this->stripe_secret_key);

    $user = get_userdata();

            // Create a Customer:
    $customer = \Stripe\Customer::create(array(
      "email" => $user['email'],      
      "source" => $this->input->post('access_token')
    ));

    if ($customer) {
      $datas = array(
        'type' => $_POST['type'],
        'card' => $card_last_digits,
        'user_id' => $this->session->userdata('applicant_id'),
        'customer_id' => $customer->id
      );
      $this->db->insert('card_details',$datas);




              // Sending notification to mentor
      $app_id = $this->session->userdata('pay_to');
      $app_data = $this->user_model->gurus_detail_list_view($app_id);
      $pay_details =$this->session->userdata('payment_details');

      foreach ($pay_details as $key => $value) {
       $invitedata['from_date_time'] = $value->date_value.' '.$value->start_time;
       $invitedata['to_date_time'] = $value->date_value.' '.$value->end_time;
       $invitedata['invite_from'] = $this->session->userdata('applicant_id');
       $invitedata['invite_to'] = $this->session->userdata('pay_to');
       $invitedata['message'] = 'You have new invitation request from '.$app_data['first_name'].' '.$app_data['last_name'];
       $invitedata['invite_date'] = $value->date_value;
       $invitedata['invite_time'] = $value->start_time;
       $invitedata['invite_end_time'] = $value->end_time;
       $invitedata['paid'] = 0;
       $invitedata['time_zone'] = $value->time_zone;
       $invitedata['session_id'] = $this->generate_session_id();

       /* Amount calcaulation */


                // Payment Details
       $mentor_id_1 = $this->session->userdata('pay_to');
       $where = array('mentor_id'=>$mentor_id_1);
       $amount = $this->db->get_where('mentor_details',$where)->row_array();

       // $gst = $this->session->userdata('tax_percentage');

       $per_hour_charge =  $amount['hourly_rate'];
       $tax_amount = ($per_hour_charge * GST)/100;       
       $tax_amount = number_format($tax_amount,2);
       $total_amount = $per_hour_charge + $tax_amount;
       $total_amount =number_format($total_amount,2);

       $invitedata['per_hour_charge'] = $per_hour_charge;
       $invitedata['tax_percentage'] = GST;        
       $invitedata['tax_amount'] = $tax_amount;
       $invitedata['total_hours_charge'] = $total_amount;

       /* Amount calcaulation */
       
       $this->db->insert('invite',$invitedata);
       $insert_id = $this->db->insert_id();




       // Store the Payment details

       $data = array(
         'user_id' => $this->session->userdata('applicant_id'),
         'mentor_id' => $this->session->userdata('pay_to'),
         'payment_status' => 0,
         'payment_gross' => $total_amount,
         'payment_date' => date('Y-m-d H:i:s'),
         'currency_code' => 'USD',
         'source' =>'stripe',
         'stripe_token' =>$_POST['access_token'],
         'stripe_customer_id' => $customer->id,
         'card_last_digits' => $card_last_digits,
         'invite_id' => $insert_id,
         'transaction_type'=>'CREDIT',
         'per_hour_charge' => $per_hour_charge,
         'role_type' => 'mentee'
       );
       $this->db->insert('payments',$data);


       $handling_charge = ( $per_hour_charge * 20 )  / 100;


       $payable_charge = $per_hour_charge - $handling_charge;

       $data = array(
         'user_id' => $this->session->userdata('applicant_id'),
         'mentor_id' => $this->session->userdata('pay_to'),
         'payment_status' => 0,
         'payment_gross' => $total_amount,
         'payment_date' => date('Y-m-d H:i:s'),
         'currency_code' => 'USD',
         'source' =>'stripe',
         'stripe_token' =>$_POST['access_token'],
         'stripe_customer_id' => $customer->id,
         'card_last_digits' => $card_last_digits,
         'invite_id' => $insert_id,
         'transaction_type'=>'DEBIT',
         'per_hour_charge' => $per_hour_charge,
         'handling_charge' => $handling_charge,
         'role_type' => 'mentor'
       );
       $this->db->insert('payments',$data);

  $data = array(
         'user_id' => $this->session->userdata('applicant_id'),
         'mentor_id' => $this->session->userdata('pay_to'),
         'payment_status' => 0,
         'payment_gross' => $total_amount,
         'payment_date' => date('Y-m-d H:i:s'),
         'currency_code' => 'USD',
         'source' =>'stripe',
         'stripe_token' =>$_POST['access_token'],
         'stripe_customer_id' => $customer->id,
         'card_last_digits' => $card_last_digits,
         'invite_id' => $insert_id,
         'transaction_type'=>'CREDIT',
         'per_hour_charge' => $per_hour_charge,
         'handling_charge' => $handling_charge,
         'payable_charge' => $payable_charge,
         'role_type' => 'mentor'
       );
       $this->db->insert('payments',$data);




       $current_user_id = $this->session->userdata('applicant_id');
       $user_data  = $this->get_names($current_user_id);



       $notify_data['user_id'] = $invitedata['invite_to'];
       $notify_data['notification_id'] = $this->session->userdata('applicant_id');       
       $notify_data['read'] = 0;
       $notify_data['invite_id'] = $insert_id;
       $notify_data['created_date'] = date('Y-m-d H:i:s');
       $notify_data['time_zone'] = date_default_timezone_get();
       $notify_data['mentor_message'] = "You have a call request from <a href='".base_url()."mentor-profile/".$app_data['username']."'>".$app_data['first_name'].' '.$app_data['last_name'].'</a>';
       $notify_data['mentee_message'] = "You request a call to <a href='".base_url()."mentee-profile/".$user_data['username']."'>".$user_data['first_name']." ".$user_data['last_name'];



       $notify_data['mentor_view'] = 1;
       $notify_data['mentee_view'] = 1;


       $response =   $this->db->insert('notifications',$notify_data);

     }

     echo json_encode(array('status' => 200, 'success' => 'Card details stored completed.'));
     exit();
   } else {
     echo json_encode(array('status' => 500, 'error' => 'Something went wrong. Try after some time.'));
     exit();
   }

 } catch (Stripe_CardError $e) {
  echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
  exit();
} catch (Stripe_InvalidRequestError $e) {
            // Invalid parameters were supplied to Stripe's API
  echo json_encode(array('status' => 500, 'error' => $e->getMessage()));
  exit();
} catch (Stripe_AuthenticationError $e) {
            // Authentication with Stripe's API failed
  echo json_encode(array('status' => 500, 'error' => AUTHENTICATION_STRIPE_FAILED));
  exit();
} catch (Stripe_ApiConnectionError $e) {
            // Network communication with Stripe failed
  echo json_encode(array('status' => 500, 'error' => NETWORK_STRIPE_FAILED));
  exit();
} catch (Stripe_Error $e) {
            // Display a very generic error to the user, and maybe send
  echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
  exit();
} catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
  echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
  exit();
}

}


 // STRIPE PAYMENT PROCESS

// public function process(){


//   $card_last_digits = substr($_POST['card_number'], -4);
//   try {

//     \Stripe\Stripe::setApiKey('sk_test_8w0QeeKXNWn3hqKRNXzBtwRd');

//     $user = get_userdata();

//             // Create a Customer:
//     $customer = \Stripe\Customer::create(array(
//       "email" => $user['email'],
//       "source" => $this->input->post('access_token'),
//     ));

//             // Charge the Customer instead of the card:
//     $charge = \Stripe\Charge::create(array(
//       "amount" => $this->input->post('amount').'00',
//       "currency" => "USD",
//       "customer" => $customer->id,
//       "description" => $user['first_name'].' '.$user['last_name']
//     ));





//               // Sending notification to mentor
//     $app_id = $this->session->userdata('pay_to');
//     $app_data = $this->user_model->gurus_detail_list_view($app_id);
//     $pay_details =$this->session->userdata('payment_details');

//     foreach ($pay_details as $key => $value) {
//      $invitedata['from_date_time'] = $value->date_value.' '.$value->start_time;
//      $invitedata['to_date_time'] = $value->date_value.' '.$value->end_time;
//      $invitedata['invite_from'] = $this->session->userdata('applicant_id');
//      $invitedata['invite_to'] = $this->session->userdata('pay_to');
//      $invitedata['message'] = 'You have new invitation request from '.$app_data['first_name'].' '.$app_data['last_name'];
//      $invitedata['invite_date'] = $value->date_value;
//      $invitedata['invite_time'] = $value->start_time;
//      $invitedata['invite_end_time'] = $value->end_time;
//      $invitedata['paid'] = 1;
//      $invitedata['time_zone'] = $value->time_zone;
//      $this->db->insert('invite',$invitedata);
//      $insert_id = $this->db->insert_id();

//       // Store the Payment details
//      $data = array(
//        'txn_id' => $charge->id,
//        'user_id' => $this->session->userdata('applicant_id'),
//        'mentor_id' => $this->session->userdata('pay_to'),
//        'payment_status' => 1,
//        'payment_gross' => $this->input->post('amount'),
//        'payment_date' => date('Y-m-d H:i:s'),
//        'currency_code' => 'USD',
//        'source' =>'stripe',
//        'stripe_token' =>$_POST['access_token'],
//        'stripe_customer_id' => $customer->id,
//        'card_last_digits' => $card_last_digits,
//        'invite_id' => $insert_id
//      );
//      $this->db->insert('payments',$data);


//      $notify_data['user_id'] = $invitedata['invite_to'];
//      $notify_data['notification_id'] = $this->session->userdata('applicant_id');
//      $notify_data['text'] = $app_data['first_name'].' '.$app_data['last_name'].' invited you with premium';
//      $notify_data['read'] = 0;
//      $notify_data['invite_id'] = $insert_id;
//      $notify_data['created_date'] = date('Y-m-d H:i:s');
//      $notify_data['time_zone'] = date_default_timezone_get();
//      $response =   $this->db->insert('notifications',$notify_data);
//    }

//    if ($response) {
//      echo json_encode(array('status' => 200, 'success' => 'Payment successfully completed.'));
//      exit();
//    } else {
//      echo json_encode(array('status' => 500, 'error' => 'Something went wrong. Try after some time.'));
//      exit();
//    }

//  } catch (Stripe_CardError $e) {
//   echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
//   exit();
// } catch (Stripe_InvalidRequestError $e) {
//             // Invalid parameters were supplied to Stripe's API
//   echo json_encode(array('status' => 500, 'error' => $e->getMessage()));
//   exit();
// } catch (Stripe_AuthenticationError $e) {
//             // Authentication with Stripe's API failed
//   echo json_encode(array('status' => 500, 'error' => AUTHENTICATION_STRIPE_FAILED));
//   exit();
// } catch (Stripe_ApiConnectionError $e) {
//             // Network communication with Stripe failed
//   echo json_encode(array('status' => 500, 'error' => NETWORK_STRIPE_FAILED));
//   exit();
// } catch (Stripe_Error $e) {
//             // Display a very generic error to the user, and maybe send
//   echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
//   exit();
// } catch (Exception $e) {
//             // Something else happened, completely unrelated to Stripe
//   echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
//   exit();
// }
// }




Public function pay_using_stripe()
{
	$pay_details =$this->session->userdata('payment_details');
	$mentor_id = base64_decode($this->uri->segment(3));
	$this->session->set_userdata('pay_to',$mentor_id);
	$this->session->set_userdata('payment_details',$pay_details);
	$product = $this->user_model->get_progress_bar($mentor_id);
	$pay_details =$this->session->userdata('payment_details');
	$hour = 0;
	foreach ($pay_details as $key => $value) {
		$hour++;
	}
  $this->data['product'] = $product;
  $this->data['title'] = "Stripe Payment";
  $this->data['amount'] = $product['hourly_rate'] * $hour;
  $this->data['module'] = 'stripe';
  $this->load->vars($this->data);
  $this->load->view('template');

}

public function buy($id) {


	if($this->session->userdata('applicant_id') == '')
	{
		redirect('login');
	}
	$product = $this->user_model->get_progress_bar($id);

	$this->paypal_auto_form($product);

}

public function button($value)
{
		// changes the default caption of the submit button
	$this->submit_btn = form_submit('pp_submit', $value);
}

public function paypal_auto_form($product)
{

	$pay_details =$this->session->userdata('payment_details');
	$hour = 0;
	foreach ($pay_details as $key => $value) {
		$hour++;
	}

	$to_buy = array(
		'desc' => 'SchoolGuru Invitation',
		'currency' => $this->currency,
		'type' => $this->ec_action,
		'return_URL' => site_url('user/back'),
		'cancel_URL' => site_url('user/back'),
		'shipping_amount' => $product['mentor_charge'] * $hour,
		'mentor_id' => $product['app_id'],
		'get_shipping' => true);

	foreach($this->product as $p) {
		$product = array(
			'first_name' => $p['first_name'],
			'last_name' => $p['first_name'],
			'email' => $p['email'],
			'amount' => $p['mentor_charge'],
			'mentor_id' => $p['app_id'],
			'username' => $p['username']);

		$to_buy['products'][] = $product;
	}

                // enquire Paypal API for token
	$set_ec_return = $this->paypal_ec->set_ec($to_buy);

	if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
		$this->session->set_userdata('pay_to',$to_buy['mentor_id']);
		$this->session->set_userdata('payment_details',$pay_details);

			// redirect to Paypal
		$this->paypal_ec->redirect_to_paypal($set_ec_return['TOKEN']);

	} else {
		$this->_error($set_ec_return);
	}
}

	/* -------------------------------------------------------------------------------------------------
	* a sample back function that handles
	* --------------------------------------------------------------------------------------------------
	*/
	function back() {



		$token = $_GET['token'];
		$payer_id = $_GET['PayerID'];
		$get_ec_return = $this->paypal_ec->get_ec($token);
		if (isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {
			// in $get_ec_return array
			$ec_details = array(
				'token' => $token,
				'payer_id' => $payer_id,
				'mentor_id' => $this->session->userdata('pay_to'),
				'currency' => $this->currency,
				'amount' => $get_ec_return['PAYMENTREQUEST_0_AMT'],
				'IPN_URL' => site_url('user/ipn'),
				'type' => $this->ec_action);

			// DoExpressCheckoutPayment
			$do_ec_return = $this->paypal_ec->do_ec($ec_details);
			if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {
				//echo "\nGetExpressCheckoutDetails Data\n" . print_r($get_ec_return, true);exit;
				//echo "\n\nDoExpressCheckoutPayment Data\n" . print_r($ec_details, true);exit;
				$app_id = $this->session->userdata('applicant_id');
				$app_data = $this->user_model->gurus_detail_list_view($app_id);
				$pay_details =$this->session->userdata('payment_details');
				$mentor_detail_result = $this->applicant_modal->applicant_detail_list_view($this->session->userdata('pay_to'));
				foreach ($pay_details as $key => $value) {

					$paydata['user_id'] = $this->session->userdata('applicant_id');
					$paydata['mentor_id'] = $this->session->userdata('pay_to');
					$paydata['txn_id'] = $do_ec_return['PAYMENTINFO_0_TRANSACTIONID'];
					$paydata['payment_gross'] = $mentor_detail_result['mentor_charge'];
					$paydata['currency_code'] = $this->currency;
					$paydata['payer_email'] = $get_ec_return['EMAIL'];
					$paydata['payment_status'] = $do_ec_return['ec_status'];
          $paydata['source'] ='paypal';
          $paydata['paypal_token'] =$token;


          if($this->db->insert('payments',$paydata)){
            $payment_id = $this->db->insert_id();
            $invitedata['from_date_time'] = $value->date_value.' '.$value->start_time;
            $invitedata['to_date_time'] = $value->date_value.' '.$value->end_time;
            $invitedata['invite_from'] = $this->session->userdata('applicant_id');
            $invitedata['invite_to'] = $this->session->userdata('pay_to');
            $invitedata['message'] = 'You have new invitation request from '.$app_data['first_name'].' '.$app_data['last_name'];
            $invitedata['invite_date'] = $value->date_value;
            $invitedata['invite_time'] = $value->start_time;
            $invitedata['invite_end_time'] = $value->end_time;
            $invitedata['paid'] = $do_ec_return['ec_status'];
            $invitedata['time_zone'] = $value->time_zone;


            $this->db->insert('invite',$invitedata);
            $insert_id = $this->db->insert_id();
            $new_data = array('invite_id' => $insert_id);
            $wheree = array('payment_id' => $payment_id);
            $this->db->update('payments',$new_data,$wheree);
            $notify_data['user_id'] = $invitedata['invite_to'];
            $notify_data['notification_id'] = $this->session->userdata('applicant_id');
            $notify_data['text'] = $app_data['first_name'].' '.$app_data['last_name'].' invited you with premium';
            $notify_data['read'] = 0;
            $notify_data['invite_id'] = $insert_id;
            $notify_data['created_date'] = date('Y-m-d H:i:s');
            $notify_data['time_zone'] = date_default_timezone_get();
            $this->db->insert('notifications',$notify_data);

          }
        }
        $data['result'] = $this->user_model->get_progress_bar($this->session->userdata('pay_to'));
        $data['invite_id'] = $insert_id;
        $message = $this->load->view('home/pages/applicant_send_invite_view',$data,TRUE);

        $this->load->helper('file');
        $config = Array(
         'protocol' => 'mail',
         'smtp_host' => 'ssl://smtp.googlemail.com',
         'smtp_port' => 465,
         'smtp_user' => 'dinesh@dreamguys.co.in',
         'smtp_pass' => 'Dreams99',
         'mailtype' => 'html',
         'charset' => 'iso-8859-1',
         'wordwrap' => TRUE
       );
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");
        $this->email->from('dinesh@dreamguys.co.in','SchoolGuru');
        $this->email->to($data['result']['email']);
        $this->email->subject('Hey! '.$data['result']['first_name'].' You have been invited from Applicant!');
        $this->email->message($message);
        $this->email->send();

        $this->load->view('paypal/success', $do_ec_return);

      } else {
        $this->_error($do_ec_return);
      }
    } else {
     $this->_error($get_ec_return);
   }
 }


 function ipn() {
  $logfile = 'ipnlog/' . uniqid() . '.html';
  $logdata = "<pre>\r\n" . print_r($_POST, true) . '</pre>';
  file_put_contents($logfile, $logdata);
}

function _error($ecd) {
  $this->load->view('paypal/cancel', $ecd);
}

public function send_invite_to_applicant()
{

 $current_user_id = $this->session->userdata('applicant_id');
 $user_data  = $this->get_names($_POST['invite_id']);



 $sts = 1;
 $formdata = $this->input->post();
 $invitedata['invite_from'] = $this->session->userdata('applicant_id');
 $invitedata['invite_to'] = $formdata['invite_id'];

 $guru = $this->user_model->get_progress_bar($invitedata['invite_from']);
 $notify_data['user_id'] = $invitedata['invite_to'];
 $notify_data['notification_id'] = $this->session->userdata('applicant_id');
 // $notify_data['text'] = $guru['first_name'].' '.$guru['last_name'].' invited you through mail!';
 $notify_data['read'] = 0;
 $notify_data['created_date'] = date('Y-m-d H:i:s');
 $notify_data['time_zone'] = date_default_timezone_get();

 $notify_data['mentor_message'] ='You invited through mail to <a href="'.base_url().'mentee-profile/'.$user_data['username'].'" class="notification_link">'.$user_data['first_name'].' '.$user_data['last_name'].'</a>';



 $notify_data['mentee_message'] = 'You have a invite mail from <a href="'.base_url().'mentor-profile/'.$guru['username'].'" class="notification_link">'.$guru['first_name'].' '.$guru['last_name'].'</a>';

 // $notify_data['mentor_message'] = "You have a call request from <a href='".base_url()."mentee-profile/".$user_data['username']."'>".$user_data['first_name']." ".$user_data['last_name']."</a>";
 //   $notify_data['mentee_message'] = "You request a call to <a href='".base_url()."mentor-profile/".$app_data['username']."'>".$app_data['first_name']." ".$app_data['last_name']."</a>";




 $notify_data['mentor_view'] = 1;
 $notify_data['mentee_view'] =1;


 $this->db->insert('notifications',$notify_data);
 $data['result'] = $this->applicant_modal->get_progress_bar($invitedata['invite_to']);

 $data['invite_id'] = $invitedata['invite_from'];
 $data['username'] = $guru['username'];
 $data['message'] = $_POST['invite_message'];

 $message = $this->load->view('home/pages/guru_send_invite_view',$data,TRUE);
 $this->load->helper('file');
 $config = Array(
   'protocol' => 'mail',
   'smtp_host' => 'ssl://smtp.googlemail.com',
   'smtp_port' => 465,
   'smtp_user' => 'boominathan@dreamguys.co.in',
   'smtp_pass' => 'dreams99',
   'mailtype' => 'html',
   'charset' => 'iso-8859-1',
   'wordwrap' => TRUE
 );
 $this->load->library('email');
 $this->email->initialize($config);
 $this->email->set_newline("\r\n");
 $this->email->set_crlf("\r\n");
 $this->email->from('info@mentori.ng','Mentori');
 $this->email->to($data['result']['email']);
 $this->email->subject('Hey! '.$data['result']['first_name'].' You have a message from  the Mentor '.$guru['first_name'].' '.$guru['last_name'].'! ');
 $this->email->message($message);
                if($this->email->send()) //mail Function*/
                {
                	$sts = 0;
                }

                echo $sts;
              }

            //   public function second_verification()
            //   {
            //    $sts = 0;
            //    $id = $this->session->userdata('applicant_id');
            //    $qry = $this->db->get_where('applicants',array('id'=>$id));
            //    $result= $qry->row_array();
            //    if(!empty($result)){
            //     $data['result'] = $result;
            //     $data['result']['app_id'] = $result['id'];
            //     $message = $this->load->view('home/pages/guru_email_verification',$data,TRUE);
            //     $this->load->helper('file');
            //     $config = Array(
            //      'protocol' => 'mail',
            //      'smtp_host' => 'ssl://smtp.googlemail.com',
            //      'smtp_port' => 465,
            //      'smtp_user' => 'boominathan@dreamguys.co.in',
            //      'smtp_pass' => 'Dreams99',
            //      'mailtype' => 'html',
            //      'charset' => 'iso-8859-1',
            //      'wordwrap' => TRUE
            //    );
            //     $this->load->library('email');
            //     $this->email->initialize($config);
            //     $this->email->set_newline("\r\n");
            //     $this->email->set_crlf("\r\n");
            //     $this->email->from('boominathan@dreamguys.co.in','SchoolGuru');
            //     $this->email->to($result['email']);
            //     $this->email->subject('Email verification for your SchoolGuru account');
            //     $this->email->message($message);
            //     if($this->email->send()) //mail Function*/
            //     {
            //     	$sts = 1;
            //     }
            //   }
            //   echo $sts;
            // }

              public function invite_success($id)
              {
               $app_id = base64_decode($id);
               $qry = $this->db->get_where('invite',array('invite_id'=>$app_id))->row_array();
               if(!empty($qry)){
                $this->db->where('invite_id',$app_id);
                $this->db->update('invite',array('read_status'=>1));
                redirect('dashboard?notify=true');
              }else{
                redirect('login');
              }

            }

            public function approve_event($id)
            {
             $app_id = base64_decode($id);
             $qry = $this->db->get_where('invite',array('invite_id'=>$app_id))->row_array();
             if(!empty($qry)){
              $this->db->where('invite_id',$app_id);
              if($this->db->update('invite',array('approved'=>1)))
              {
               $this->db->where('invite_id',$app_id);
               $this->db->update('notifications',array('read'=>1));
             }
             redirect('dashboard?notify=true');
           }else{
            redirect('login');
          }
        }

        public function cancel_event($id)
        {
         $app_id = base64_decode($id);
         $qry = $this->db->get_where('invite',array('invite_id'=>$app_id))->row_array();
         if(!empty($qry)){
          $applicant = $this->user_model->get_progress_bar($qry['invite_from']);
          $mentor = $this->applicant_modal->get_progress_bar($qry['invite_to']);

          $this->db->where('invite_id',$app_id);
          if($this->db->update('invite',array('approved'=>2)))
          {

           $message= '<table width="600" cellpadding="0" cellspacing="0" align="center">
           <tr>
           <td style="padding:50px 50px 50px 50px; border:1px solid #bfc0cd; border-radius:20px;">
           <table width="100%" cellpadding="0" cellspacing="0" align="center">
           <tr>
           <td>
           <p style="margin:0; padding:0;"><a href="'.base_url().'" target="_blank"><img src="'.base_url().'assets/images/schoolguru-logo-emailtemplate.png" /></a></p>
           <h1 style="font-family:Arial, Helvetica, sans-serif; font-size:36px; color:#000; font-weight:bold; margin:50px 0 10px 0; padding:0;">Hi '.$applicant['first_name'].' '.$applicant['last_name'].',</h1>
           <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#808080; font-weight:normal; margin:0 0 30px 0; padding:0;">Thank you for choosing <span style="font-weight:bold; color:#5c65be;">SchoolGuru</span></h2>
           <p style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#808080; font-weight:normal; margin:0; padding:0;">Your Booking has been cancelled by '.$mentor['first_name'].' '.$mentor['last_name'].'.</p>
           <p style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#808080; font-weight:normal; margin:0; padding:0;">We will revert the paid amount shortly. Please choose some other guru.</p>
           <p style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#ffffff; font-weight:normal; margin:15px 0 0 0; padding:0;"><a href="'.base_url().'" style="color:#ffffff; padding:12px 25px 12px 25px; background:#5c65be; display:inline-block; text-decoration:none; border-radius:8px;">Go to SchoolGuru</a></p>

           </td>
           </tr>
           </table>
           </td>
           </tr>
           <tr>
           <td align="center">
           <p style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#808080; font-weight:normal; line-height:24px; margin:40px 0 40px 0; padding:0;">&copy; 2017 All rights reserved by <a href="'.base_url().'" target="_blank" style="color:#808080; text-decoration:none;">mentori.ng</a><br />
           <a href="#" target="_blank" style="color:#808080; text-decoration:none;">Privacy Policy</a> and <a href="#" target="_blank" style="color:#808080; text-decoration:none;">Terms & Conditions</a></p>
           </td>
           </tr>
           </table>';
           $member_headers  = "From:".'info@mentori.ng'."\r\n";
           $member_headers .= "Reply-To: ".'info@school-guru.com'."\r\n";
           $member_headers .= "MIME-Version: 1.0\r\n";
           $member_headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
           $member_headers .= "X-Priority: 1\r\n";

                //send email
           if(mail($applicant['email'], "Booking Cancelled!", $message, $member_headers))
           {
            $sts = 0;
          }

        }
        redirect('dashboard?notify=true');
      }else{
        redirect('login');
      }
    }

    public function profile_load()
    {
     $id = $this->session->userdata('applicant_id');
     $qry = $this->db->get_where('applicants',array('id'=>$id));
     $result= $qry->row_array();
     if(!empty($result)){
      echo json_encode($result);
    }else{
      echo '0';
    }
  }

  public function newcrop()
  {
   $this->db->where('id',$this->session->userdata('applicant_id'));
   $data = $this->db->get('applicants')->row_array();
   if($data['profile_img'] != ''){
    $url = base_url().'assets/images/'.$data['profile_img'];
  }else{
    $url = base_url().'assets/images/default-avatar.png';
  }
  echo $url;
}

public function advance_search_guru()
{

 if($this->session->userdata('applicant_id') == '')
 {
  redirect('login');
}




$fields = array('mentor_job_title','mentor_gender', 'mentor_school', 'mentor_schools_applied', 'mentor_current_year', 'mentor_extracurricular_activities', 'mentor_job_company', 'mentor_job_title', 'mentor_job_from_year', 'mentor_about','mentor_languages_speak');
$conditions = array();
if(!empty($_POST)){
  $post_values = $this->input->post();
  foreach($fields as $field){
    if(isset($post_values[$field]) && $post_values[$field] != '') {
     $conditions[] = "`$field` LIKE '%" . $post_values[$field] . "%'";
   }
 }
}elseif(!empty($this->uri->segment(3))){
  $search_val = $this->uri->segment(3);
  foreach($fields as $field){
    if(!empty($search_val)) {
     $conditions[] = "`$field` LIKE '%" .$search_val. "%'";
   }
 }
}



$query = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
LEFT JOIN country_list ON country_list.country_id = mentor_details.country WHERE applicants.role=1 and applicants.profile_updated=1 and applicants.is_verified=1";

$query1 = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.email,applicants.username,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
LEFT JOIN country_list ON country_list.country_id = mentor_details.country WHERE applicants.role=1 and applicants.profile_updated=1 and applicants.is_verified=1";

if(count($conditions) > 0) {
  $operator = (count($conditions) > 1) ? ' AND ' : ' OR ';
              $query .= " AND  " . implode ($operator, $conditions); // you can change to 'OR', but I suggest to apply the filters cumulative
            }
            if(count($conditions) > 0) {
             $operator = (count($conditions) > 1) ? ' AND ' : ' OR ';
              $query1 .= " AND  " . implode ($operator, $conditions); // you can change to 'OR', but I suggest to apply the filters cumulative
            }
            $query .= " LIMIT 0,5";

            $result = $this->db->query($query)->result_array();
            $result1 = $this->db->query($query1)->result_array();

            $this->data['module'] = 'gurus_list_view';
            $this->data['theme'] = 'applicant';
            $this->data['gurus'] = $result;
            $this->data['count'] = count($result1);
            $this->load->vars($this->data);
            $this->load->view('template');

          }

          public function notify_applicants()
          {

           $app_id = $this->session->userdata('applicant_id');
           $this->db->where('user_id',$app_id);
           $this->db->where('read',0);
           $qry = $this->db->get('notifications')->result_array();
           echo count($qry);
         }

         public function notify_list()
         {
           $app_id = $this->session->userdata('applicant_id');
           $this->db->where('user_id',$app_id);
           $this->db->where('read',0);
           $this->db->limit(6,0);
           $this->db->order_by('notify_id','desc');
           $qry = $this->db->get('notifications')->result_array();

            //echo $this->db->last_query();
            // echo '<pre>';
            // print_r($qry);
            // exit;
           $notify_list = '<li><h3>Notifications</h3></li><li role="separator" class="divider"></li>';


           if($this->session->userdata('role') == 0){

            if(!empty($qry)){
             foreach($qry as $notify)
             {
              $user = $this->db->get_where('applicants',array('id' => $notify['notification_id']))->row_array();
              $notify_list .= '<li><a href="'.base_url().'dashboard">'.$notify['mentee_message'].'</a></li><li role="separator" class="divider"></li>';
            }

            $notify_list .= '<li class="text-center jnotify">
            <a href="'.base_url().'dashboard" id="see_all_nofify">See All Notifications <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></li>';
          }else{
           $notify_list .= '<li><a href="#">No more notifications</a></li>';
         }


       }else if($this->session->userdata('role') == 1){



        if(!empty($qry)){
         foreach($qry as $notify)
         {
          $user = $this->db->get_where('applicants',array('id' => $notify['notification_id']))->row_array();
          $notify_list .= '<li><a href="'.base_url().'dashboard">'.$notify['mentor_message'].'</a></li><li role="separator" class="divider"></li>';
        }
        $notify_list .= '<li class="text-center jnotify">
        <a href="'.base_url().'dashboard" id="see_all_nofify">See All Notifications <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></li>';
      }else{
       $notify_list .= '<li><a href="#">No more notifications</a></li>';
     }




   }





   echo $notify_list;
 }

 Public function delete_mentor_notification(){
  echo $this->db->update('notifications',array('mentor_view'=>0),array('notify_id' => $_POST['notify_id']));
} Public function delete_mentee_notification(){
  echo $this->db->update('notifications',array('mentee_view'=>0),array('notify_id' => $_POST['notify_id']));
}



Public function time_elapsed_string($datetime, $full = false) {
  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);

  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;

  $string = array(
    'y' => 'year',
    'm' => 'month',
    'w' => 'week',
    'd' => 'day',
    'h' => 'hour',
    'i' => 'minute',
    's' => 'second',
  );
  foreach ($string as $k => &$v) {
    if ($diff->$k) {
      $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    } else {
      unset($string[$k]);
    }
  }

  if (!$full) $string = array_slice($string, 0, 1);
  return $string ? implode(', ', $string) . ' ago' : 'just now';
}

Public function get_all_notification(){


  $html ='';
  $applicant_id = $this->session->userdata('applicant_id');

  if($this->session->userdata('role') == 1){

    $notification = $this->user_model->get_all_notification($applicant_id);
    if(!empty($notification)){

      foreach($notification as $notify ){

        $user_id = $notify['user_id'];
        $session_id = $this->session->userdata('applicant_id');
        if($session_id == $user_id){
          $user = $this->db->get_where('applicants',array('id' =>$notify['notification_id'] ))->row_array();
          $msg = 'Call request accepted by '. $user['first_name'].' '.$user['last_name'];
        }else{
          $user = $this->db->get_where('applicants',array('id' =>$notify['user_id'] ))->row_array();
          $msg = 'You requested call to '. $user['first_name'].' '.$user['last_name'];
        }

        if(!empty($user['profile_img'])){
          $profile_img = base_url() . 'assets/images/'.$user['profile_img'];
        }else{
          $profile_img = base_url() . 'assets/images/default-avatar.png';
        }

        $time = $this->time_elapsed_string($notify['created_date']);

        $html .='<div class="msgrow" id="note_'.$notify['notify_id'].'">
        <div class="msgimg"><img class="img-circle" src="'.$profile_img.'" height="40" width="40"></div>
        <div class="msgcontent">
        <h3><a href="#">'.$user['first_name'].' '.$user ['last_name'].' <span>'.$time.'</span></a></h3>
        <p><a href="#">'.$msg.'</a></p>
        </div>
        <div class="msgdelete"><a href="#" onclick="delete_notification('.$notify['notify_id'].')"><img src="'.base_url().'mentori_assets/img/delete-icon.png"></a></div>
        </div>';

      }
    }
  }else{

    $notification = $this->user_model->get_all_notification($applicant_id);    
    if(!empty($notification)){
      foreach($notification as $notify ){
       $user_id = $notify['user_id'];
       $session_id = $this->session->userdata('applicant_id');
       if($session_id == $user_id){
        $user = $this->db->get_where('applicants',array('id' =>$notify['notification_id'] ))->row_array();
        $msg = 'Call request accpeted by '. $user['first_name'].' '.$user['last_name'];
      }else{
        $user = $this->db->get_where('applicants',array('id' =>$notify['user_id'] ))->row_array();
        $msg = 'You requested call to '. $user['first_name'].' '.$user['last_name'];
      }

      if(!empty($user['profile_img'])){
        $profile_img = base_url() . 'assets/images/'.$user['profile_img'];
      }else{
        $profile_img = base_url() . 'assets/images/default-avatar.png';
      }

      $time = $this->time_elapsed_string($notify['created_date']);

      $html .='<div class="msgrow" id="note_'.$notify['notify_id'].'">
      <div class="msgimg"><img class="img-circle" src="'.$profile_img.'" height="40" width="40"></div>
      <div class="msgcontent">
      <h3><a href="#">'.$user['first_name'].' '.$user ['last_name'].' <span>'.$time.'</span></a></h3>
      <p><a href="#">'.$msg.'</a></p>
      </div>
      <div class="msgdelete"><a href="#" onclick="delete_notification('.$notify['notify_id'].')"><img src="'.base_url().'mentori_assets/img/delete-icon.png"></a></div>
      </div>';

    }
  }

}

echo $html;

}

public function deleteactivity($id)
{
 $app_id = base64_decode($id);
 $qry = $this->db->get_where('invite',array('invite_id'=>$app_id))->row_array();
 $data['delete_sts'] = 1;
 if(!empty($qry)){
  if($qry['approved'] == 1)
  {
   $data['approved'] = 2;
 }
}
$this->db->where('invite_id',$id);
if($this->db->update('invite',$data))
{
  $this->db->where('invite_id',$id);
  $this->db->delete('notifications');

  $applicant = $this->user_model->get_progress_bar($qry['invite_from']);
  $mentor = $this->applicant_modal->get_progress_bar($qry['invite_to']);
  $message= '<table width="600" cellpadding="0" cellspacing="0" align="center">
  <tr>
  <td style="padding:50px 50px 50px 50px; border:1px solid #bfc0cd; border-radius:20px;">
  <table width="100%" cellpadding="0" cellspacing="0" align="center">
  <tr>
  <td>
  <p style="margin:0; padding:0;"><a href="'.base_url().'" target="_blank"><img src="'.base_url().'assets/images/schoolguru-logo-emailtemplate.png" /></a></p>
  <h1 style="font-family:Arial, Helvetica, sans-serif; font-size:36px; color:#000; font-weight:bold; margin:50px 0 10px 0; padding:0;">Hi '.$applicant['first_name'].' '.$applicant['last_name'].',</h1>
  <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#808080; font-weight:normal; margin:0 0 30px 0; padding:0;">Thank you for choosing <span style="font-weight:bold; color:#5c65be;">SchoolGuru</span></h2>
  <p style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#808080; font-weight:normal; margin:0; padding:0;">Your Booking has been cancelled by '.$mentor['first_name'].' '.$mentor['last_name'].'.</p>
  <p style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#808080; font-weight:normal; margin:0; padding:0;">We will revert the paid amount shortly. Please choose some other guru.</p>
  <p style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#ffffff; font-weight:normal; margin:15px 0 0 0; padding:0;"><a href="'.base_url().'" style="color:#ffffff; padding:12px 25px 12px 25px; background:#5c65be; display:inline-block; text-decoration:none; border-radius:8px;">Go to SchoolGuru</a></p>

  </td>
  </tr>
  </table>
  </td>
  </tr>
  <tr>
  <td align="center">
  <p style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#808080; font-weight:normal; line-height:24px; margin:40px 0 40px 0; padding:0;">&copy; 2017 All rights reserved by <a href="'.base_url().'" target="_blank" style="color:#808080; text-decoration:none;">schoolguru.com</a><br />
  <a href="#" target="_blank" style="color:#808080; text-decoration:none;">Privacy Policy</a> and <a href="#" target="_blank" style="color:#808080; text-decoration:none;">Terms & Conditions</a></p>
  </td>
  </tr>
  </table>';
  $member_headers  = "From:".'info@school-guru.com'."\r\n";
  $member_headers .= "Reply-To: ".'info@school-guru.com'."\r\n";
  $member_headers .= "MIME-Version: 1.0\r\n";
  $member_headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
  $member_headers .= "X-Priority: 1\r\n";

                //send email
  if(mail($applicant['email'], "Booking Cancelled!", $message, $member_headers))
  {
   $sts = 0;
 }

 redirect('dashboard?notify=true');
}
}


public function search_activity_list()
{

 $search_key = $this->input->post('search_value');
 $applicant_id = $this->session->userdata('applicant_id');
 if($this->session->userdata('type') == 'user' || $this->session->userdata('role') == 0){
  $location = 'applicant';
  $data['result'] = $this->applicant_modal->get_progress_bar($applicant_id);
  $data['activity_list'] = $this->applicant_modal->get_dashboard_activity_search($applicant_id,$search_key);
}else{
  $location = 'guru';
  $data['result'] = $this->user_model->get_progress_bar($applicant_id);
  $data['activity_list'] = $this->user_model->get_dashboard_activity_search($applicant_id,$search_key);
}
echo $this->load->view('home/'.$location.'/dashboard_activity_search_list',$data,TRUE);
}

public function deleteactivity_applicant($id)
{
 $this->db->where('invite_id',$id);
 if($this->db->update('invite',array('delete_sts'=>1)))
 {
  $this->db->where('invite_id',$id);
  $this->db->delete('notifications');
  redirect('dashboard?notify=true');
}
}

public function online_status()
{
 $sts = 0;
 $app_id = $this->session->userdata('applicant_id');
 $date = date('Y-m-d H:i:s');
 $sql = "UPDATE applicants SET last_update_timestamp='$date' WHERE id=$app_id";
 if($this->db->query($sql)){
  $sts = 1;
}
echo $sts;
}

public function get_online_status()
{
 $sts = 0;
 $selected_user = $this->input->post('selected_user');
 $query = $this->db->query("SELECT * FROM applicants WHERE id=$selected_user and DATE(last_update_timestamp)=CURDATE() and TIMESTAMPDIFF(MINUTE, last_update_timestamp, NOW()) > 10")->row_array();
 if(!empty($query))
 {
  $sts = 1;
}
echo $sts;
}

public function search_chat_users()
{
 $id = $this->session->userdata('applicant_id');
 $keyword = $this->input->post('keyword');
 if($keyword != ''){
//               $sql = "select t1.invite_id,t1.message,t1.invite_date,t1.invite_time,t2.id as app_id,t2.first_name,t2.last_name,t2.profile_img from invite t1 left join applicants t2 on t2.id=t1.invite_from where t2.first_name like '%$keyword%' OR t2.last_name like '%$keyword%' OR CONCAT(t2.first_name,' ',t2.last_name) like '%$keyword%' and t1.invite_to='$id' group by t1.invite_from";
//               echo $sql;exit;
  $data['activity_list'] = $this->applicant_modal->get_chat_list_search($id,$keyword);
}else{
  $data['activity_list'] = $this->applicant_modal->get_chat_list($id);
}
echo $this->load->view('home/applicant/search_chat_list',$data,TRUE);
}

public function search_chat_users_guru()
{
 $id = $this->session->userdata('applicant_id');
 $keyword = $this->input->post('keyword');
 if($keyword != ''){
  $data['activity_list'] = $this->user_model->get_chat_list_search($id,$keyword);
}else{
  $data['activity_list'] = $this->user_model->get_chat_list($id);
}
echo $this->load->view('home/guru/search_chat_list',$data,TRUE);
}

public function notify_applicants_viewed()
{
 $id = $this->session->userdata('applicant_id');
 $this->db->where('user_id',$id);
 $update = $this->db->update('notifications',array('read'=>1));
 echo $update;
}

public function delete_conversation()
{


 $selected_user = $this->input->post('sender_id');
 $session_id = $this->session->userdata('applicant_id');


 $data = $this->applicant_modal->deletable_chats($selected_user,$session_id);
 if(!empty($data)){
  foreach ($data as $d) {
   $this->db->delete('chat_deleted_details',array('chat_id'=>$d['id'],'can_view'=>$session_id));
 }
}
    // echo $this->db->last_query();
echo '1';
}

public function more_details()
{
 $invite_id = $this->input->post('invite_id');
 $id = $this->session->userdata('applicant_id');
 if($this->session->userdata('role') == 0){
  $title = 'Mentor';
  $userdata = $this->applicant_modal->more_details_view($invite_id,$id);
}else{
  $title = 'Applicant';
  $userdata = $this->user_model->more_details_view($invite_id,$id);
}
if(!empty($userdata)){
  echo '<p>'.$title.' Details:</p><p>'.$title.' Name: '.$userdata['first_name'].' '.$userdata['last_name'].' </p>'.
  '<p>Date: '.$userdata['invite_date'].'</p>'.
  '<p>Start Time: '.date("g:i a", strtotime($userdata['invite_time'])).'</p>'.
  '<p>End Time: '.date("g:i a", strtotime($userdata['invite_end_time'])).'</p>';
}else{
  echo '';
}

}

public function set_schedule_time()
{
 $sts =1;
 $form_values = $this->input->post();
 $this->session->set_userdata('schedule_date',$form_values['contact_date']);
 $this->session->set_userdata('schedule_time_start',$form_values['contact_time_start']);
 $this->session->set_userdata('schedule_time_end',$form_values['contact_time_end']);
 echo $sts;
}

public function get_username()
{
 $email = $this->input->post('email');
 $query = $this->db->get_where('applicants',array('email'=>$email))->row_array();
 if(!empty($query)){
  echo $query['username'];
}
}

public function meetings($username = '')
{
 if($this->session->userdata('applicant_id') == '')
 {
  redirect('login');
}
$id = $this->session->userdata('applicant_id');
$this->data['module'] = 'video_conversation_view';
if($this->session->userdata('role') == 0){
  $this->data['theme'] = 'applicant';
  $this->data['today_conversation'] = $this->applicant_modal->get_conversation_data($id);
}else{
  $this->data['theme'] = 'guru';
  $this->data['today_conversation'] = $this->user_model->get_conversation_data($id);
}
$this->load->vars($this->data);
$this->load->view('template');
}

public function check_exist_date()
{
 $sts = 1;
 $date = $this->input->post('contact_date');
 $time = $this->input->post('contact_time');
 $end_time = $this->input->post('contact_time_end');
 $mentor_id = $this->input->post('app_id');
           //$gmtime = date('H:i:s',strtotime($time));
 $this->db->select('*');
 $this->db->from('invite');
 $this->db->where('invite_date',$date);
 $this->db->where('invite_time',$time);
 $this->db->where('invite_to',$mentor_id);
            //$this->db->where('approved',1);
 $query = $this->db->get()->row_array();
 if(!empty($query))
 {
  $sts = 0;
}
echo $sts;
}

public function update_expire_status()
{
 $invite_id = $this->input->post('invite_id');
 $this->db->where('invite_id',$invite_id);
 $return = $this->db->update('invite',array('read_status'=>1));
 echo $return;
}

public function pay($id)
{


 if($this->session->userdata('applicant_id') == '')
 {
  redirect('login'); 
}
$this->data['title'] = 'Payment Details';
$this->data['product'] = $this->user_model->get_progress_bar($id);
$this->data['module'] = 'payment_detail_view';
$this->data['theme'] = 'applicant';
$this->load->vars($this->data);
$this->load->view('template');
}

public function check_time()
{
 $sts = 1;
 $time = $this->input->post('past_time');
 $date = date('g:i',strtotime($time));
 $now = date('g:i');
 if($date < $now) {
  $sts = 1;
}
echo $sts;
}

public function render_available_time()
{
 $id = $this->session->userdata('applicant_id');
 if($this->session->userdata('role') == 0){
  $result = $this->applicant_modal->calendar_available_view($id);
  foreach($result as $record){
   $title = 'Booked';
   if($record['subject'] != ''){
    $title = $record['subject'];
  }
  if($record['new_title'] != ''){
    $title = $record['new_title'];
  }
  $event_array[] = array(
    'id' => $record['invite_id'],
    'user_id' => $record['invite_to'],
    'title' => $title,
    'start' => date($record['invite_date'].' '.$record['invite_time']),
    'end' => date($record['invite_date'].' '.$record['invite_end_time'])
  );
}
}else{
  $result = $this->user_model->calendar_available_view($id);
  foreach($result as $record){
   $title = 'You have a discussion with '.$record['first_name'].' '.$record['last_name'];
   if($record['subject'] != ''){
    $title = $record['subject'];
  }
  if($record['new_title_2'] != ''){
    $title = $record['new_title_2'];
  }
  $event_array[] = array(
    'id' => $record['invite_id'],
    'user_id' => $record['invite_to'],
    'title' => $title,
    'start' => date($record['invite_date'].' '.$record['invite_time']),
    'end' => date($record['invite_date'].' '.$record['invite_end_time'])
  );
}
}

echo json_encode($event_array);
}

public function guru_available_time()
{
 $mentor_id = $this->input->post('mentor_id');
 $query = $this->db->query("select min(time_start) as min_time,max(time_end) as max_time from appointment_schedule where mentor_id=$mentor_id group by mentor_id")->row_array();
 echo json_encode($query);
}

function schedule_list()
{
 $id = $this->session->userdata('applicant_id');
 $selected_value = $this->input->post('selected_value');
 $selected_day = $this->input->post('selected_day');
 $this->db->where('mentor_id',$id);
 $this->db->where('days_id',$selected_value);
 $this->db->where('day_name',$selected_day);
 $result = $this->db->get('appointment_schedule')->result_array();
 $data['available_time'] = $result;
 $view = $this->load->view('home/guru/guru_available_ajax_view',$data,TRUE);
 echo $view;

}

function add_schedule_time()
{

 $rangeArray=array();
  $time_zone =  $this->session->userdata('time_zone'); // Getting Timezone
  $sts = 0;

  $time_start = $this->input->post('from_time');
  $time_end = $this->input->post('to_time');
  $data['days_id'] = $this->input->post('selected_value');
  $data['day_name'] = $this->input->post('selected_day');

  $explode_start_time = explode(':',$time_start);
  $explode_end_time = explode(':',$time_end);

  $range = range($explode_start_time[0],$explode_end_time[0]);




  $rangeArray = array();
  $from = '';
  $to = '';
  foreach ($range as $key => $value) {
  	if(strlen($value) < 2)
  	{
  		if($range[$key+1] != ''){
  			$time = "0".$value.':00:00'.'-'.$range[$key+1].':00:00';
  		}
  	}else{
  		if($range[$key+1] != ''){
  			$time = $value.':00:00'.'-'.$range[$key+1].':00:00';
  		}
  	}
  	array_push($rangeArray,$time);
  }


  array_pop($rangeArray);


      //$json_data=array($rangeArray);
  $data['mentor_id'] = $this->session->userdata('applicant_id');
  $data['time_start'] = $time_start;
  $data['time_end'] = $time_end;

  $data['time_zone'] = $time_zone;


  $where = array('mentor_id' => $this->session->userdata('applicant_id'),'day_name'=>$_POST['selected_day']);
  $da = $this->db->get_where('appointment_schedule',$where)->result_array();

  if(!empty($da)){

  	foreach($da as $d){
  		$old_datas[] = (json_decode($d['available']));
  	}

  }
  //  $old_datas = array_map('current', $old_datas);
  $good_time = array();
  if(!empty($old_datas)){
    foreach ($old_datas as $mytime) {
     if(!empty($mytime)){
      foreach ($mytime as $mynewtime) {
        $good_time[] = $mynewtime;
      }
    }
  }
}

   // echo '<pre>';print_r($good_time);
   // echo '<pre>';print_r($old_datas);

for ($i=0; $i <count($good_time) ; $i++) {

  $old_times =str_replace(':','',$good_time);
  $old_times =str_replace('-','',$old_times);
}



for ($i=0; $i <count($rangeArray) ; $i++) {

  $new_times =str_replace(':','',$rangeArray);
  $new_times =str_replace('-','',$new_times);
}


if(!empty($good_time)){
   $key =array_keys(array_diff($new_times,$old_times)); // not matched data keys
   $insert_data = array();
   for ($j=0; $j <count($key) ; $j++) {
    $keys =  $key[$j];
    array_push($insert_data,$rangeArray[$keys]);
  }

}else{

  $insert_data = $rangeArray;
}
$data['available'] = json_encode($insert_data);
if($this->db->insert('appointment_schedule',$data)){
 $sts = 1;
}
echo $sts;

}

public function delete_schedule_time($value='')
{
	$sts = 0;
	$id = $this->input->post('delete_value');

	$this->db->where('appointment_id',$id);
	if($this->db->delete('appointment_schedule')){
		$sts = 1;
	}
	echo $sts;
}

public function check_schedule_start_time()
{
	$sts = 1;
	$mentor_id = $this->session->userdata('applicant_id');
	$day_id = $this->input->post('day_value');
	$from_time = $this->input->post('from_time');
	$this->db->where('time_start',$from_time);
	$this->db->where('mentor_id',$mentor_id);
	$this->db->where('days_id',$day_id);
	$result = $this->db->get('appointment_schedule')->row_array();
	if(!empty($result)){
		$sts = 0;
	}
	echo $sts;
}


public function check_schedule_to_time()
{
	$sts = 1;
	$mentor_id = $this->session->userdata('applicant_id');
	$day_id = $this->input->post('day_value');
	$to_time = $this->input->post('to_time');
	$this->db->where('time_end',$to_time);
	$this->db->where('mentor_id',$mentor_id);
	$this->db->where('days_id',$day_id);
	$result = $this->db->get('appointment_schedule')->row_array();
	if(!empty($result)){
		$sts = 0;
	}
	echo $sts;
}

public function remove_options()
{
	$id = $this->session->userdata('applicant_id');
	$selected_value = $this->input->post('selected_value');
	$selected_day = $this->input->post('selected_day');
	$this->db->where('mentor_id',$id);
	$this->db->where('days_id',$selected_value);
	$this->db->where('day_name',$selected_day);
	$result = $this->db->get('appointment_schedule')->result_array();
	echo json_encode($result);
}

public function set_booked_session()
{

  // echo '<pre>'; print_r($_POST); exit;

  if($_POST['charge_type'] == 'free' || trim($_POST['hourly_rate']) == '' ){

    $session_data =  json_decode($this->input->post('session_data'));
    $this->session->set_userdata('payment_details',$session_data);
    $this->request_free_call();
    echo '2';

  }else{
    $sts = 1;
    $session_data =  json_decode($this->input->post('session_data'));
    $this->session->set_userdata('payment_details',$session_data);
    echo $sts;
  }

}
Public function  request_free_call()
{
 $data = array(
   'user_id' => $this->session->userdata('applicant_id'),
   'mentor_id' => $this->session->userdata('pay_to'),
   'payment_status' => 0,
   'payment_gross' => 0,
   'payment_date' => date('Y-m-d H:i:s'),
   'currency_code' => 'USD'
 );
 $this->db->insert('payments',$data);
 $payment_id = $this->db->insert_id();

              // Sending notification to mentor
 $app_id = $this->session->userdata('pay_to');
 $app_data = $this->user_model->gurus_detail_list_view($app_id);
 $pay_details =$this->session->userdata('payment_details');

 foreach ($pay_details as $key => $value) {
   $invitedata['from_date_time'] = $value->date_value.' '.$value->start_time;
   $invitedata['to_date_time'] = $value->date_value.' '.$value->end_time;
   $invitedata['invite_from'] = $this->session->userdata('applicant_id');
   $invitedata['invite_to'] = $this->session->userdata('pay_to');
   $invitedata['message'] = 'You have new invitation request from '.$app_data['first_name'].' '.$app_data['last_name'];
   $invitedata['invite_date'] = $value->date_value;
   $invitedata['invite_time'] = $value->start_time;
   $invitedata['invite_end_time'] = $value->end_time;
   $invitedata['paid'] = 0;
   $invitedata['time_zone'] = $value->time_zone;
   $invitedata['session_id'] = $this->generate_session_id();

   $this->db->insert('invite',$invitedata);
   $insert_id = $this->db->insert_id();

   $new_data = array('invite_id' => $insert_id);
   $wheree = array('payment_id' => $payment_id);
   $this->db->update('payments',$new_data,$wheree);


   $current_user_id = $this->session->userdata('applicant_id');
   $user_data  = $this->get_names($current_user_id);

   $notify_data['user_id'] = $invitedata['invite_to'];
   $notify_data['notification_id'] = $this->session->userdata('applicant_id');   
   $notify_data['read'] = 0;
   $notify_data['invite_id'] = $insert_id;
   $notify_data['created_date'] = date('Y-m-d H:i:s');
   $notify_data['time_zone'] = date_default_timezone_get();
   $notify_data['mentor_view'] = 1;
   $notify_data['mentee_view'] = 1;
   $notify_data['mentor_message'] = "You have a call request from ".$user_data['first_name'].' '.$user_data['last_name'];
   $notify_data['mentee_message'] = "You request a call to ".$app_data['first_name'].' '.$app_data['last_name'];

   $response =   $this->db->insert('notifications',$notify_data);
 }
}

public function get_schedule_from_date()
{

	$selected_date = $this->input->post('selected_date');
	$id = $this->input->post('mentor_id');

	$data['result'] =  $this->applicant_modal->calendar_available_time_ajax($id,$selected_date);
	$data['gurus'] = $this->applicant_modal->applicant_detail_list_view($id);
	$data['available_data'] = $this->applicant_modal->get_guru_available_data_ajax($id,$selected_date);
	$data['selected_date'] = $selected_date;
	echo $this->load->view('home/applicant/guru_weekly_view',$data,TRUE);
}

public function save_rating()
{
	$sts = 1;
	$session_id = $this->session->userdata('applicant_id');
  $mentor_id = $this->input->post('mentor_id');
  $invite_id = $this->input->post('invite_id');
  $rating = $this->input->post('rating_value');
  $rating_comment = $this->input->post('rating_comment');
  $mentor_details = $this->user_model->get_progress_bar($mentor_id);

  $data['invite_id'] = $invite_id;
  $data['user_id'] = $mentor_id;
  $data['reviewer_id'] = $session_id;
  $data['rating'] = $rating;
  $data['helpful'] = 1;
  $data['review'] = $rating_comment;
  $data['reviewer_name'] = $mentor_details['first_name'].' '.$mentor_details['last_name'];

  $this->db->insert('review_ratings',$data);
  echo $sts;
}

public function validate_to_time(){
	$to_time = $this->input->post('to_time');

}

public function incoming_video_call()
{
	if($this->session->userdata('applicant_id') == '')
	{
		redirect('login');
	}
  $where = array('invite_id' => base64_decode($this->uri->segment(6)));
  $record = $this->db->get_where('invite',$where)->row_array();

  $from_date_time =  $record['invite_date'].' '.$record['invite_time'];
  $to_date_time =  $record['invite_date'].' '.$record['invite_end_time'];
  $from_timezone =$record['time_zone'];
  $to_timezone = $this->session->userdata('time_zone');
  $from_date_time = $this->converToTz($from_date_time,$to_timezone,$from_timezone);
  $to_date_time = $this->converToTz($to_date_time,$to_timezone,$from_timezone);
  $data['from_date_time']  = $from_date_time;
  $data['to_date_time']  = $to_date_time;
  $data['from_time']  = date('H:i:s',strtotime($from_date_time));
  $data['to_time']  = date('H:i:s',strtotime($to_date_time));
  $data['date']  = date('Y-m-d',strtotime($from_date_time));
  $data['timezone']  = $record['time_zone'];
  $data['invite_id']  = $record['invite_id'];
  // echo '<pre>';print_r($data);exit;
  $this->load->view('home/applicant/incoming_video_call',$data);
}
public function incoming_audio_call()
{
  if($this->session->userdata('applicant_id') == '')
  {
    redirect('login');
  }
  $where = array('invite_id' => base64_decode($this->uri->segment(6)));
  $record = $this->db->get_where('invite',$where)->row_array();

  $from_date_time =  $record['invite_date'].' '.$record['invite_time'];
  $to_date_time =  $record['invite_date'].' '.$record['invite_end_time'];
  $from_timezone =$record['time_zone'];
  $to_timezone = $this->session->userdata('time_zone');
  $from_date_time = $this->converToTz($from_date_time,$to_timezone,$from_timezone);
  $to_date_time = $this->converToTz($to_date_time,$to_timezone,$from_timezone);
  $data['from_date_time']  = $from_date_time;
  $data['to_date_time']  = $to_date_time;
  $data['from_time']  = date('H:i:s',strtotime($from_date_time));
  $data['to_time']  = date('H:i:s',strtotime($to_date_time));
  $data['date']  = date('Y-m-d',strtotime($from_date_time));
  $data['timezone']  = $record['time_zone'];
  $data['invite_id']  = $record['invite_id'];
  $this->load->view('home/applicant/incoming_audio_call',$data);
}



public function outgoing()
{
	if($this->session->userdata('applicant_id') == '')
	{
		redirect('login');
	}
	$id = $this->session->userdata('applicant_id');
	if($this->session->userdata('role') == 0){
		$theme = 'applicant';
		$data['today_conversation'] = $this->applicant_modal->get_conversation_data($id);
	}else{
		$theme = 'guru';
		$data['today_conversation'] = $this->user_model->get_conversation_data($id);
	}
	$this->load->view('home/'.$theme.'/outgoing_call_view',$data);
}





public function incoming()
{
	if($this->session->userdata('applicant_id') == '')
	{
		redirect('login');
	}
	$id = $this->session->userdata('applicant_id');
	if($this->session->userdata('role') == 0){
		$theme = 'applicant';
		$data['today_conversation'] = $this->applicant_modal->get_conversation_data($id);
	}else{
		$theme = 'guru';
		$data['today_conversation'] = $this->user_model->get_conversation_data($id);
	}
	$this->load->view('home/'.$theme.'/incoming_call_view',$data);
}



Public function delete_activity()
{
	echo $this->db->update('invite',array('delete_sts'=>1),array('invite_id'=>$_POST['invite_id']));
}
Public function cancel_activity()
{
	echo $this->db->update('invite',array('approved'=>2,'cancelled' =>1 ),array('invite_id'=>$_POST['invite_id']));
}


Public function check_invites(){
  $where = array('invite_id' => $_POST['invite_id']);
  $result = $this->db->get_where('invite',$where)->row();
  if(!empty($result)){
    $wheres = array(
      'from_date_time' => $result->from_date_time,
      'to_date_time' => $result->to_date_time,
      'invite_to' => $this->session->userdata('applicant_id'),
      'approved' => 1
    );
    return $this->db->get_where('invite',$wheres)->num_rows();
  }else{
    return 0;
  }
}

Public function approve_activity()
{
  $check = $this->check_invites();
  if($check === 0){
    $this->db->update('invite',array('approved'=>1,'channel'=>$_POST['channel']),array('invite_id'=>$_POST['invite_id']));
    $session_id = $this->session->userdata('applicant_id');
    $guru = $this->user_model->get_user_det($session_id);
    $text =  $guru->first_name.' '.$guru->last_name.' approved your request ';



    $mentee_id = $this->db->select('invite_from')->get_where('invite',array('invite_id'=>$_POST['invite_id']))->row_array();
    
    
    $user_data = $this->get_names($mentee_id['invite_from']);

    $data = array(
      'mentor_message' => 'You approved call request from '.$user_data['first_name'].' '.$user_data['last_name'],
      'mentee_message' => 'Call request accepted by '.$guru->first_name.' '.$guru->last_name,
      'mentor_view' => 1,
      'mentee_view' => 1,
      'user_id' => $this->session->userdata('applicant_id'),
      'notification_id' => $_POST['user_id'],       
      'invite_id' =>$_POST['invite_id'],
      'read' =>0,
      'created_date' => date('Y-m-d H:i:s'),
      'time_zone' => date_default_timezone_get()
    );
    $this->db->insert('notifications',$data);
    echo json_encode(array('success' => true));
  }else{
    echo json_encode(array('error' => true));
  }


}



Public function set_timezone()
{
	if(isset($_REQUEST['timezone'])){
		$array = array('time_zone' => $_REQUEST['timezone'],
	);
		$this->session->set_userdata( $array );
		echo json_encode($array);



	}
}




Public function check_new_message(){  


  $user_selected_id = $_POST['user_selected_id'];
  $recieved_id = $this->session->userdata('applicant_id');
  $where = array('recieved_id' =>$recieved_id,'read_status' => 0 ,'sent_id' =>$user_selected_id);
  $result = $this->db->order_by('id','desc')->get_where('chat',$where)->result_array();

  $messages=array();
  if(!empty($result)){
    foreach ($result as $r) {
      $sql = "SELECT a.id,a.profile_img as senderImage, social.picture_url as socialImage
      from applicants a  
      LEFT  join social_applicant_user social on social.reference_id = a.id
      where a.id = ".$r['sent_id'];

      $data = $this->db->query($sql)->row_array();
      if($data['senderImage']!=''){
        $img =  base_url().'assets/images/'.$data['senderImage'];
      }elseif($data['socialImage']!=''){
        $img = $data['socialImage'];
      }else{
        $img = base_url().'assets/images/default-avatar.png';
      }

      $msg['image'] =  $img;
      $msg['type'] = $r['type'];
      $msg['file_path'] = $r['file_path'];
      $msg['file_name'] = $r['file_name'];
      $msg['read_status'] = $r['read_status'];
      $msg['message'] = $r['msg'];
      $msg['time'] = date('h:i A',strtotime($r['chatdate']));
      $messages[] = $msg;      
    }
  }

  $where = array('recieved_id' =>$recieved_id,'read_status' => 0 ,'sent_id' =>$user_selected_id);
  $this->db->update('chat',array('read_status'=>1),$where);

  return  json_encode($messages);
}


Public function get_message_counts(){
  $user_selected_id = $_POST['user_selected_id'];
  $where = array();  
  if(!empty($_POST['selected_user_id'])){
    $where += array('c.sent_id !=' =>$user_selected_id);
  }  
  $recieved_id = $this->session->userdata('applicant_id');
  $where += array('c.recieved_id' =>$recieved_id,'c.read_status' => 0);
  $data = $this->db
  ->select('a.username,COUNT(c.id) as count')
  ->join('applicants a ','a.id = c.sent_id','left')
  ->group_by('c.sent_id')
  ->get_where('chat c',$where)->result();
  return json_encode($data);


}


Public function get_call()
{

  // error_reporting(1);  

  $dat['message'] = $this->check_new_message();  
  $dat['other_message'] = $this->get_message_counts();  
  $user_id = $this->session->userdata('applicant_id');
  $where = array('call_to'=>$user_id,'status'=>1);
  $result =  $this->db->get_where('call_details',$where)->row();
  $dat['html'] = '';
  $dat['status'] = false;
  if(!empty($result) && $result->status == 1){


    $sql = "SELECT a.first_name,a.last_name,a.profile_img,s.picture_url,a.username FROM  applicants a LEFT JOIN  social_applicant_user s ON a.id = s.reference_id WHERE a.id = '$result->call_from'";
    $data = $this->db->query($sql)->row_array();


    $username = base64_encode($data['username']);
    $channel = base64_encode($result->channel);
    $call_from = base64_encode($result->call_from);
    $invite_id = base64_encode($result->invite_id);

    if($result->type == 'audio'){
      $type = 'incoming_audio_call';
    }else{
      $type = 'incoming_video_call';
    }


    $profile_img = '';
    if(isset($data['profile_img']) && !empty($data['profile_img'])){

     $profile_img = $data['profile_img'];
   }

   $social_profile_img = '';
   if(isset($data['picture_url'])&&!empty($data['picture_url'])){
     $social_profile_img = $data['picture_url'];
   }

   $img1 = '';
   if($social_profile_img != ''){
     $img1 = $social_profile_img;
   }
   if($profile_img != ''){
     $file_to_check = FCPATH . '/assets/images/' . $profile_img;
     if (file_exists($file_to_check)) {
      $img1 = base_url() . 'assets/images/'.$profile_img;
    }
  }
  $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';



  $html ='<div class="new-call-overlay form-group">
  <div class="new_call_notify">
  <div class="ajax_span">
  <div class="new-call-img">
  <img src="'.$img.'" class="img-circle img-responsive new-call-animation">
  </div>
  <div>
  <p>'.$data['first_name'].' '.$data['last_name'].' Calling you .. </p>
  <a class="btn btn-success join" href="'.base_url().'user/'.$type.'/'.$username.'/'.$channel.'/'.$call_from.'/'.$invite_id.'" call_id="'.$result->call_id.'">Join </a>
  <button class="btn btn-danger reject" id="'.$result->call_id.'">Reject</button>

  </div>
  </div>
  </div>
  </div>';



  // $html='<div class="ajax_span">
  // <div class="col-md-3">
  // <img src="'.$img.'" class="img-circle img-responsive">
  // </div>
  // <div class="col-md-6">
  // '.$data['first_name'].' '.$data['last_name'].' Calling you .. <br>
  // <a class="btn btn-success join" href="'.base_url().'user/'.$type.'/'.$username.'/'.$channel.'/'.$call_from.'/'.$invite_id.'" call_id="'.$result->call_id.'">Join </a>
  // <button class="btn btn-danger reject" id="'.$result->call_id.'">Reject</button>

  // </div>
  // </div>';


  $dat['html'] = $html;
  $dat['status'] = true;
}
echo json_encode($dat);
}

Public function set_call_status()
{
	echo $this->db->update('call_details',array('status'=>0),array('call_id'=>$_POST['call_id']));
}
Public function attend_call_status()
{
	echo $this->db->update('call_details',array('status'=>2),array('call_id'=>$_POST['call_id']));
}

Public function delete_channel()
{
 $this->insert_log();
 $where = array('invite_id'=>$_POST['invite_id']);
 $this->db->delete('call_details',$where);

 $id = $this->session->userdata('applicant_id');
 echo $this->db->update('applicants',array('call_status'=>$_POST['call_status']),array('id'=>$id));


}

Public function insert_log(){


  $where = array('invite_id'=>$_POST['invite_id']);
  $invite = $this->db->get_where('invite',$where)->row_array();
  $data['start_time'] =  date('H:i:s',strtotime($_POST['start_time']));
  $data['end_time'] =  date('H:i:s',strtotime($_POST['end_time']));
  $data['time_zone'] = date_default_timezone_get();
  $data['invite_id'] = $_POST['invite_id'];
  $data['invite_date'] = $invite['invite_date'];
  $data['to_id']= $_POST['to_user_id'];
  $data['from_id']= $this->session->userdata('applicant_id');
  $this->db->insert('call_logs',$data);
  $id =   $this->db->insert_id();
  $this->update_payment();
  echo $id;

}





 // Get Individual Applicant Payment Details

Public function get_applicant_payment()
{
	$list = $this->applicant_modal->get_datatables_a();
	$data = array();
	$no = $_POST['start'];
	$i = 1;
	foreach ($list as $g) {
		$row = array();


      if($g->applicant_profile_img!=''){ // Getting profile image from applicant table for applicant
      	$applicant_img = $g->applicant_profile_img;
      	$file_to_check = FCPATH . '/assets/images/' . $applicant_img;
      	if (file_exists($file_to_check)) {
      		$applicant_img = base_url() . 'assets/images/'.$applicant_img;
      	}

      	$applicant_img = ($applicant_img != '') ? $applicant_img : base_url() . 'assets/images/default-avatar.png';

          }else if($g->applicant_picture!=''){ // Getting profile image from social table for applicant
          	$applicant_img = $g->applicant_picture;
          }else{
          	$applicant_img = base_url() . 'assets/images/default-avatar.png';
          }

          $user_id = base64_encode($g->id);
          $row[] = '<a href="'.base_url().'mentor-profile/'.$g->applicant_user_name.'"><img src="'.$applicant_img.'" class="img-circle" height="40" width="40"> '.$g->applicant_name.'</a>';

          $row[] = '<span class="spa_greytext" >'.date('d-m-Y',strtotime($g->payment_date)).'</span>';
          $row[] = date('h:i A',strtotime($g->invite_time));
          $row[] = date('h:i A',strtotime($g->invite_end_time));           
          $row[] =(!empty($g->payment_gross))?'<strong>$'.number_format($g->payment_gross,2).'</strong>':'<strong>$0.00</strong>';

          $from_date_time =  $g->invite_date.' '.$g->invite_time;
          $from_timezone =$g->time_zone;
          $to_timezone = $this->session->userdata('time_zone');
          $from_date_time  = $this->converToTz($from_date_time,$to_timezone,$from_timezone);
          $from_time  = date('h:i a',strtotime($from_date_time));


         


          //             // Time crossed witout approved
          // if($g->approved == 0 && date('Y-m-d H:i:s') >  date('Y-m-d H:i:s', strtotime($from_date_time . ' +1 hour'))) {
          //   $row[] ='<span class="label label-danger">Cancelled</span>';
          // }elseif($g->approved == 0 && date('Y-m-d H:i:s') <  date('Y-m-d H:i:s', strtotime($from_date_time . ' +1 hour'))) {
          //   $row[] = '<span class="label label-warning">Pending</span>';
          // }elseif($g->approved == 1 && date('Y-m-d H:i:s') <  date('Y-m-d H:i:s', strtotime($from_date_time)) ){
          //   $row[]='<span class="label label-success">Approved</span>';
          // }elseif($g->approved == 1 && date('Y-m-d H:i:s') >  date('Y-m-d H:i:s', strtotime($from_date_time))){
          //  // After Call time with Approved

          //   $count = $this->db->get_where('call_logs',array('invite_id'=>$g->invite_id))->num_rows();

          //             if($count>0){ // After Call time with Approve  with call logs
          //               $row[] = '<span class="label label-default">Finished</span>';
          //             }else{  // After Call time with Approve  without call logs
          //               $row[] = '<span class="label label-warning">Incomplete</span>';
          //             }

          //     }elseif($g->approved == 2 && date('Y-m-d H:i:s') >  date('Y-m-d H:i:s', strtotime($from_date_time))){ // After Call time with Approved

          //       $row[] = '<span class="label label-danger">Cancelled</span>';

          //     }else{

          //       $row[] = '<span class="label label-danger">Cancelled</span>';
          //     }



          $payment_id = base64_encode($g->payment_id);
          $payment_date = base64_encode($g->payment_date);


          if($g->payment_gross != 0){
             $row[]=$g->remarks;
            $row[] = '<a class="btn btn-primary btn-xs" href="'.base_url().'user/invoice/'.$payment_id.'"><i class="fa fa-download"></i><small> Invoice</small></a>';  
          }else{
             $row[]='Free Call';
            $row[] = '<a class="btn btn-warning btn-xs" href="javascript:void(0);" disabled="true"><i class="fa fa-flag"></i><small> Free</small></a>';
          }

          

          $data[] = $row;
        }

        $output = array(
         "draw" => $_POST['draw'],
         "recordsTotal" => $this->applicant_modal->count_all_a(),
         "recordsFiltered" => $this->applicant_modal->count_filtered_a(),
         "data" => $data,
       );
                //output to json format
        echo json_encode($output);
      }
      Public function account_validate()
      {

        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if(empty(trim($_POST['bank_name']))){
          $data['inputerror'][] = 'bank_name';
          $data['error_string'][] = 'Enter bank name';
          $data['status'] = FALSE;
        }
        if(empty(trim($_POST['account_type']))){
          $data['inputerror'][] = 'account_type';
          $data['error_string'][] = 'Enter account type';
          $data['status'] = FALSE;
        }
        if(empty(trim($_POST['routing']))){
          $data['inputerror'][] = 'routing';
          $data['error_string'][] = 'Enter routing';
          $data['status'] = FALSE;
        }
        if(empty(trim($_POST['beneficiary_name']))){
          $data['inputerror'][] = 'beneficiary_name';
          $data['error_string'][] = 'Enter beneficiary name';
          $data['status'] = FALSE;
        }
        if(empty(trim($_POST['account_no']))){
          $data['inputerror'][] = 'account_no';
          $data['error_string'][] = 'Enter account no';
          $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
          echo json_encode($data);
          exit();
        }

      }


      Public function save_acount()
      {

        $this->account_validate();
        $where = array('applicant_id'=>$this->session->userdata('applicant_id'));
        $result = $this->db->get_where('account_details',$where)->row();

        $data = array(
          'bank_name' => ($_POST['bank_name'])?$_POST['bank_name']:'',
          'account_type' => ($_POST['account_type'])?$_POST['account_type']:'',
          'routing' => ($_POST['routing'])?$_POST['routing']:'',
          'beneficiary_name' => ($_POST['beneficiary_name'])?$_POST['beneficiary_name']:'',
          'account_no' => ($_POST['account_no'])?$_POST['account_no']:'',
          'applicant_id' => $this->session->userdata('applicant_id')
        );

        if(!empty($result)){
          $result =   $this->db->update('account_details',$data,$where);
        }else{
          $result =   $this->db->insert('account_details',$data);
        }
        echo json_encode(array('status' => $result));

      }

       // Get Individual Gurus Payment Details

      Public function get_gurus_payment()
      {
       $list = $this->user_model->get_datatables_g();
       $data = array();
       $no = $_POST['start'];
       $i = 1;
       foreach ($list as $g) {
        $row = array();


      if($g->applicant_profile_img!=''){ // Getting profile image from applicant table for applicant
      	$applicant_img = $g->applicant_profile_img;
      	$file_to_check = FCPATH . '/assets/images/' . $applicant_img;
      	if (file_exists($file_to_check)) {
      		$applicant_img = base_url() . 'assets/images/'.$applicant_img;
      	}

      	$applicant_img = ($applicant_img != '') ? $applicant_img : base_url() . 'assets/images/default-avatar.png';

          }else if($g->applicant_picture!=''){ // Getting profile image from social table for applicant
          	$applicant_img = $g->applicant_picture;
          }else{
          	$applicant_img = base_url() . 'assets/images/default-avatar.png';
          }

          $user_id = base64_encode($g->id);
          $row[] = '<a href="'.base_url().'mentee-profile/'.$g->applicant_user_name.'"><img src="'.$applicant_img.'" class="img-circle" height="40" width="40"> '.$g->applicant_name.'</a>';


          $row[] = '<span class="spa_greytext" >'.date('d-m-Y',strtotime($g->payment_date)).'</span>';
          $row[] = date('h:i A',strtotime($g->invite_time));
          $row[] = date('h:i A',strtotime($g->invite_end_time));

          if($g->transaction_type == 'CREDIT' && $g->role_type == 'mentee'){
            $row[] =($g->per_hour_charge)?'<strong>+ $'.number_format($g->per_hour_charge,2).'</strong>':'<strong>$0.00</strong>';
            $print_btn = 0;
          }elseif($g->transaction_type == 'DEBIT'){
            $row[] =($g->handling_charge)?'<strong>- $'.number_format($g->handling_charge,2).'</strong>':'<strong>$0.00</strong>';
            $print_btn = 0;
          }elseif($g->transaction_type == 'CREDIT' && $g->role_type == 'mentor'){
            $row[] =($g->payable_charge)?'<strong>+ $'.number_format($g->payable_charge,2).'</strong>':'<strong>$0.00</strong>';
            $print_btn = 1;
          }

           if($g->payment_gross != 0){
             $row[]=$g->remarks;            
          }else{
            $print_btn = 0;
             $row[]='Free Call';         
          }


   
          


                    
          $invite_id = base64_encode($g->invite_id);
          $payment_id = base64_encode($g->payment_id);

         
          if($print_btn === 1){
            $row[] = '<a class="btn btn-primary btn-xs" href="'.base_url().'user/invoice/'.$payment_id.'"><i class="fa fa-download"></i><small> Invoice</small></a>'; 
          }else{
            $row[]='';
          }

          $data[] = $row;
        }

        $output = array(
         "draw" => $_POST['draw'],
         "recordsTotal" => $this->user_model->count_all_g(),
         "recordsFiltered" => $this->user_model->count_filtered_g(),
         "data" => $data,
       );
                //output to json format
        echo json_encode($output);
      }

      Public function update_notify()
      {
       $where = array('user_id'=>$this->session->userdata('applicant_id'));
       $data = array('read'=>2);
       return  $this->db->update('notifications',$data,$where);
     }



   }
   ?>
