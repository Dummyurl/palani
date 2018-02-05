<?php
Class Guru extends CI_Controller
{       
 public function __construct() 
 {        
   parent::__construct();
   $this->data['theme'] = 'guru';
   $this->load->library('facebook',$this->data['theme']);       
   $this->load->library('googleplus',array('theme'=>'guru'));
   $this->load->model('user_model');
   $this->data['country_list'] = $this->user_model->get_country_list();
 }


 public function signup()
 {          
  $this->data['module'] = 'signup';
  $this->load->vars($this->data);
  $this->load->view('template');
}

public function check_email()
{
 $email = $this->input->get('email'); 
 $result = $this->db->query("SELECT * FROM `applicant` WHERE `email` = '".$email."'")->row_array();       
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
 if($this->db->insert('mentor_list',$input_values))
 {
   $sts = 0;
 }
 echo $sts;
}


public function get_google_details()
{        
  $this->googleplus->getAuthenticate();
        //$this->session->set_userdata('login',true);
        //$this->session->set_userdata('user_profile',$this->googleplus->getUserInfo());
  $userProfile = $this->googleplus->getUserInfo();         
  $userData['oauth_provider'] = 'google';
  $userData['register_type']  = $this->uri->segment(1);
  $userData['oauth_uid'] = $userProfile['id'];
  $userData['first_name'] = $userProfile['given_name'];
  $userData['last_name'] = $userProfile['family_name'];
  $userData['email'] = $userProfile['email'];
  $userData['gender'] = $userProfile['gender'];
  $userData['locale'] = $userProfile['locale'];
  $userData['profile_url'] = $userProfile['link'];
  $userData['picture_url'] = $userProfile['picture'];         
  $userID = $this->user_model->checkUser($userData);
  if($userID!='')
  {
    $this->session->set_userdata(array('applicant_id'=>$userID));
    redirect(base_url().'user'."/dashboard");
  }
}

public function login()
{
  if($this->session->userdata()['applicant_id']['id']){
    redirect('user/dashboard');
  }
  $this->data['module'] = 'login';
  $this->data['facebook_url'] = $this->facebook->login_url();  
  $this->data['google_url'] = $this->googleplus->loginURL();
  $this->load->vars($this->data);
  $this->load->view('template');
}

public function check_mentor()
{        
  $params = $this->input->post();
  $result = $this->user_model->check_mentor_login($params); 
  echo $result;
}

public function verifiy_user($verification_code)
{
 $this->data['module'] = 'verifiy_user';    
 $result = $this->user_model->verify_user($verification_code);
 if($result==0)
 {

 }
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
  $result = $this->db->query("SELECT * FROM `mentor_list` WHERE `email` = '".$email."'")->row_array();                        
  if(sizeof($result)>0)
  {
    $password  = $this->generateString();         
    $this->db->where('email',$email);  
    if($this->db->update('mentor_list',array('password'=>md5($password))))
    {
      $sts = 2 ;
    }
    $name =  $result['first_name']." ".$result['last_name'];
    $useremail=$result['email'];              
    $message=' Hi '.$name.' ,

    Thanks for contacting us ! .

    The Password is given below .

    '.$password.'                                

    Cheers ,
    Team .';                
    $this->load->helper('file');  
    $this->load->library('email');
    $this->email->set_newline("\r\n");
    $this->email->from('navaneeth.k@dreamguys.co.in','Test');
    $this->email->to($useremail);
    $this->email->subject('Hey ! '.$name.' Your Password Has been Resetted ! ');
    $this->email->message($message);
               if($this->email->send()) //mail Function*/  
               {
                 $sts = 0;                 
               }
             }
             echo $sts ;
           }

           function generateString()
           {
             return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
           }


           public function dashboard()
           {    
             if(($this->session->userdata('mentor_id')))
             {
              $mentor_id = $this->session->userdata('mentor_id');        
              $this->data['result'] = $this->user_model->get_progress_bar($mentor_id);                
              $this->data['module'] = 'dashboard';        
              $this->load->vars($this->data);
              $this->load->view('template');
            }
            else 
            {
             redirect(base_url()."guru/login");           
           }
         }

         public function update_profile()
         {
          $this->validate();    
          $profile_details = array(            
            'mentor_phone' => $_POST['mentor_phone'],
            'mentor_gender' => $_POST['mentor_gender'],
            'mentor_school' => $_POST['mentor_school'],
            'mentor_current_year' => $_POST['mentor_current_year'],
            'mentor_schools_applied' => $_POST['mentor_schools_applied'],
            'mentor_clubs' => $_POST['mentor_clubs'],
            'mentor_undergrad_school' => $_POST['mentor_undergrad_school'],
            'mentor_executive_positions' => $_POST['mentor_executive_positions'],
            'charge_type' => $_POST['charge_type'],
            'mentor_job_title' => $_POST['mentor_job_title'],
            'mentor_job_company' => $_POST['mentor_job_company'],
            'mentor_job_dept' => $_POST['mentor_job_dept'],
            'mentor_job_location' => $_POST['mentor_job_location'],
            'mentor_job_desc' => $_POST['mentor_job_desc'],
            'mentor_job_from_month' => $_POST['mentor_job_from_month'],
            'mentor_job_from_year' => $_POST['mentor_job_from_year'],
            'mentor_job_to_month' => $_POST['mentor_job_to_month'],
            'mentor_job_to_year' => $_POST['mentor_job_to_year'],
            'mentor_about' => $_POST['mentor_about'],
            'mentor_personal_message' => $_POST['mentor_personal_message'],
            'mentor_school_accepted' => $_POST['mentor_school_accepted'],
            'mentor_read_guide' => $_POST['mentor_read_guide'],
            'mentor_hire_consult' => $_POST['mentor_hire_consult'],
            'mentor_visit_school' => $_POST['mentor_visit_school'],
            'mentor_tour' => $_POST['mentor_tour'],
            'mentor_other_extra' => $_POST['mentor_other_extra'],
            'mentor_extracurricular_activities' => $_POST['mentor_extracurricular_activities'],
            'mentor_hs' => $_POST['mentor_hs'],
            'mentor_from' => $_POST['mentor_from'],
            'mentor_live_work' => $_POST['mentor_live_work'],
            'mentor_languages_speak' => $_POST['mentor_languages_speak'],
            'mentor_favourite' => $_POST['mentor_favourite'],
            'mentor_hobbies' => $_POST['mentor_hobbies'],
            'mentor_quotes' => $_POST['mentor_quotes'],
            'address_line1' => $_POST['address_line1'],
            'address_line2' => $_POST['address_line2'],
            'country' => $_POST['country'],
            'state' => $_POST['state'],
            'city' => $_POST['city'],
            'postal_code' => $_POST['postal_code']
          );

          if($_POST['charge_type'] == 'charge'){
            $profile_details +=array('mentor_charge' => $_POST['mentor_charge']);
          }else{
            $profile_details +=array('mentor_charge' => '0.00');
          }
          $mentor_id     = $this->session->userdata('applicant_id');           
          $result        = $this->user_model->update_profile($mentor_id,$profile_details);
          if($result == 0){
           $this->session->set_flashdata('success_message','Profile has been updated.'); 
         }
         echo  json_encode(array('status' => TRUE));
       }



       Public function validate()
       {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;



        if(empty($_POST['first_name'])){

          $data['inputerror'][] = 'first_name';
          $data['error_string'][] = 'Enter first name';
          $data['status'] = FALSE;
        }
        if(empty($_POST['last_name'])){

          $data['inputerror'][] = 'last_name';
          $data['error_string'][] = 'Enter last name';
          $data['status'] = FALSE;
        }
        if(empty($_POST['mentor_phone'])){

          $data['inputerror'][] = 'mentor_phone';
          $data['error_string'][] = 'Enter phone no';
          $data['status'] = FALSE;
        }
        if(empty($_POST['mentor_gender'])){

          $data['inputerror'][] = 'mentor_gender';
          $data['error_string'][] = 'Select gender';
          $data['status'] = FALSE;
        }
        if(empty($_POST['mentor_school'])){

          $data['inputerror'][] = 'mentor_school';
          $data['error_string'][] = 'Enter school';
          $data['status'] = FALSE;
        }
        if(empty($_POST['mentor_current_year'])){

          $data['inputerror'][] = 'mentor_current_year';
          $data['error_string'][] = 'Enter  year';
          $data['status'] = FALSE;
        }
        if(empty($_POST['mentor_schools_applied'])){

          $data['inputerror'][] = 'mentor_schools_applied';
          $data['error_string'][] = 'Enter applying school ';
          $data['status'] = FALSE;
        }
        if(empty($_POST['mentor_clubs'])){

          $data['inputerror'][] = 'mentor_clubs';
          $data['error_string'][] = 'Enter club ';
          $data['status'] = FALSE;
        }
        if(empty($_POST['mentor_undergrad_school'])){

          $data['inputerror'][] = 'mentor_undergrad_school';
          $data['error_string'][] = 'Enter underdergraduate school';
          $data['status'] = FALSE;
        }
        if(empty($_POST['mentor_executive_positions'])){

          $data['inputerror'][] = 'mentor_executive_positions';
          $data['error_string'][] = 'Enter executive position';
          $data['status'] = FALSE;
        }
        if(empty($_POST['mentor_charge']) && $_POST['charge_type'] == 'charge'){

          $data['inputerror'][] = 'mentor_charge';
          $data['error_string'][] = 'Enter mentor charge';
          $data['status'] = FALSE;
        }
        if(empty($_POST['address_line1'])){

          $data['inputerror'][] = 'address_line1';
          $data['error_string'][] = 'Enter address line 1';
          $data['status'] = FALSE;
        }
        if(empty($_POST['address_line2'])){

          $data['inputerror'][] = 'address_line2';
          $data['error_string'][] = 'Enter address line 2';
          $data['status'] = FALSE;
        }
        if(empty($_POST['country'])){

          $data['inputerror'][] = 'country';
          $data['error_string'][] = 'Enter country';
          $data['status'] = FALSE;
        }
        if(empty($_POST['state'])){

          $data['inputerror'][] = 'state';
          $data['error_string'][] = 'Enter state';
          $data['status'] = FALSE;
        }
        if(empty($_POST['city'])){

          $data['inputerror'][] = 'city';
          $data['error_string'][] = 'Enter city';
          $data['status'] = FALSE;
        }
        if(empty($_POST['postal_code'])){

          $data['inputerror'][] = 'postal_code';
          $data['error_string'][] = 'Enter postal code';
          $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
          echo json_encode($data);
          exit();
        }





      }

      public function update_profile_status()
      {
        $form_values = $this->input->post('formData');
        $id = $this->session->userdata('applicant_id');
        $this->db->where('id',$id);
        $update = $this->db->update('applicants',array('profile_updated'=>1));
        echo $update;
      }

      public function logout()
      {
        $applicant_id     = $this->session->userdata('applicant_id'); 
        $this->db->update('applicants',array('logged_in'=>0,'logged_by'=>'mobile'),array('id'=>$applicant_id ));
        $this->session->unset_userdata('applicant_id');
        $this->session->sess_destroy();
        redirect(base_url());
      }

    }
    ?>