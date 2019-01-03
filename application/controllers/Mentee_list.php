<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mentee_list extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->model('applicant_model','applicant');
	}

	public function index()
	{
		$this->data['module'] = 'applicants';        
		$this->load->vars($this->data);
		$this->load->view('template');
	}

	Public function get_applicants()
	{
		$list = $this->applicant->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $g) {
			$row = array();             


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

    
    $user_id = base64_encode($g->id);          
    $row[] = '<a  href="'.base_url().'mentee-profile/'.$g->applicant_user_name.'" ><img src="'.$applicant_img.'" class="img-circle" height="40" width="40"> '.$g->applicant_name.'</a>';

    
    // $row[] = '<span class="spa_greytext" >'.date('d-m-Y',strtotime($g->created_date)).'</span>';
    $row[] =$g->calls;   
      $amount = $this->db->select('SUM(payment_gross) as amount')->get_where('payments',array('user_id'=>$g->id,'payment_status'=>1))->row_array();
    $row[] =  (!empty($amount)?'$'.number_format($amount['amount'],2):'0.00'); 

          if($g->delete_sts == 0){ // Active 
          	$row[] = '<span class="label label-success">Active</span>'; 
          } else if($g->delete_sts == 1){ // Inactive 
          	$row[] = '<span class="label label-danger">Inactive</span>';
          }                        
          $row[] = '<a class="btn btn-info" href="'.base_url().'mentee_list/mentee_details/'.$user_id.'"><i class="fa fa-eye" aria-hidden="true"></i></a>';         

          $data[] = $row;
        }

        $output = array(
         "draw" => $_POST['draw'],
         "recordsTotal" => $this->applicant->count_all(),
         "recordsFiltered" => $this->applicant->count_filtered(),
         "data" => $data,
       );
                //output to json format
        echo json_encode($output);
      }

      Public function mentee_details()
      {
        $this->data['applicant'] =  $this->applicant->get_applicant_details();
        $this->data['earned'] =  $this->applicant->get_total_earned(); 
        $this->data['requested'] =  $this->applicant->get_total_requested(); 
        $this->data['paid'] =  $this->applicant->get_total_paid();
        $this->data['module'] = 'applicant_details';        
        $this->load->vars($this->data);
        $this->load->view('template');

       // echo '<pre>'; print_r($this->data['applicant']);
      }


  // Get Individual Applicant Payment Details 

      Public function get_applicant_payment()
      {
        $list = $this->applicant->get_datatables_a();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $g) {
         $row = array();             


 			 if($g->profile_img!=''){ // Getting profile image from applicant table for applicant 
        $applicant_img = $g->profile_img;
        $file_to_check = FCPATH . '/assets/images/' . $applicant_img;
        if (file_exists($file_to_check)) {
           $applicant_img = base_url() . 'assets/images/'.$applicant_img;
        }else{
          $applicant_img = base_url() . 'assets/images/default-avatar.png';
        }                

          }else if($g->picture_url!=''){ // Getting profile image from social table for applicant 
            $applicant_img = $g->picture_url;
          }else{
            $applicant_img = base_url() . 'assets/images/default-avatar.png';
          }  


        $user_id = base64_encode($g->id);          
        $row[] = '<a  href="'.base_url().'mentor-profile/'.$g->username.'" ><img src="'.$applicant_img.'" class="img-circle" height="40" width="40"> '.$g->first_name.' '.$g->last_name.'</a>';

        $row[] = date('d-m-Y',strtotime($g->invite_date));
        $row[] = date('h:i A',strtotime($g->invite_time)).' -  '.date('h:i A',strtotime($g->invite_end_time));
        $row[] ='$'.$g->payment_gross;

        if($g->payment_status == 1){ // Success 
          $row[] = '<span class="label label-success">Completed</span>'; 
          } else if($g->payment_status == 2){ // Cancel 
           $row[] = '<span class="label label-danger">Cancelled</span>';
          } else{ // Pending 
            $row[] = '<span class="label label-info">Pending</span>';
          }    

          $data[] = $row;
        }

        $output = array(
         "draw" => $_POST['draw'],
         "recordsTotal" => $this->applicant->count_all_a(),
         "recordsFiltered" => $this->applicant->count_filtered_a(),
         "data" => $data,
       );
                //output to json format
        echo json_encode($output);
      }



      Public function update_profile()
      {

        $this->validate();
        $this->load->model('applicant_modal');

          // echo '<pre>';
          // print_r($_POST);
          // exit;    

        $applicant_id     = $this->session->userdata('applicant_id'); 
              $profile_data=array(                  
                  'applicant_phone' => $_POST['applicant_phone'],
                  'applicant_personal_mess' => $_POST['applicant_personal_mess'],
                  'applicant_school_apply' => $_POST['applicant_school_apply'],
                  'applicant_school_apply_sts' => $_POST['applicant_school_apply_sts'],
                  'applicant_out_of_conversation' => $_POST['applicant_out_of_conversation'],
                  'applicant_out_of_conversation_sts' => $_POST['applicant_out_of_conversation_sts'],
                  'applicant_extracurricular' => $_POST['applicant_extracurricular'],
                  'applicant_extracurricular_sts' => $_POST['applicant_extracurricular_sts'],
                  'applicant_hs' => $_POST['applicant_hs'],
                  'applicant_hs_sts' => $_POST['applicant_hs_sts'],
                  'applicant_from' => $_POST['applicant_from'],
                  'applicant_from_sts' => $_POST['applicant_from_sts'],
                  'applicant_live_and_work' => $_POST['applicant_live_and_work'],
                  'applicant_live_and_work_sts' => $_POST['applicant_live_and_work_sts'],
                  'applicant_language_speak' => $_POST['applicant_language_speak'],
                  'applicant_language_speak_sts' => $_POST['applicant_language_speak_sts'],
                  'applicant_favourites' => $_POST['applicant_favourites'],
                  'applicant_favourites_sts' => $_POST['applicant_favourites_sts'],
                  'applicant_hobbies' => $_POST['applicant_hobbies'],
                  'applicant_hobbies_sts' => $_POST['applicant_hobbies_sts'],
                  'applicant_quotes' => $_POST['applicant_quotes'],
                  'applicant_quotes_sts' => $_POST['applicant_quotes_sts'],
                  'address_line1' => $_POST['address_line1'],
                  'address_line2' => $_POST['address_line2'],
                  'country' => $_POST['country'],
                  'state' => $_POST['state'],
                  'city' => $_POST['city'],
                  'postal_code'    => $_POST['postal_code'],
            );
            $result = $this->applicant_modal->update_profile($applicant_id,$profile_data);
            if($result == 0){
              $this->session->set_flashdata('success_message','Profile has been updated.'); 
             }
             echo json_encode(array('status'=>TRUE));
      }



      Public function validate()
       {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if(empty($_POST['applicant_first_name'])){

          $data['inputerror'][] = 'applicant_first_name';
          $data['error_string'][] = 'Enter first name';
          $data['status'] = FALSE;
        }
        if(empty($_POST['applicant_last_name'])){

          $data['inputerror'][] = 'applicant_last_name';
          $data['error_string'][] = 'Enter last name';
          $data['status'] = FALSE;
        }
        if(empty($_POST['applicant_phone'])){

          $data['inputerror'][] = 'applicant_phone';
          $data['error_string'][] = 'Enter phone no';
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


    }

    /* End of file  */
/* Location: ./application/controllers/ */