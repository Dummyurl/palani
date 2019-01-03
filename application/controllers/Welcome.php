<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// SMS Gateway initalize here
require_once(APPPATH . '../vendor/autoload.php');
use Twilio\Rest\Client;

class Welcome extends CI_Controller {



  function __construct()
  {
    parent::__construct();
    $this->load->model('applicant_modal');
    $this->load->model('user_model');
    $this->load->model('setting_model','settings');
    $this->load->library('Form_validation');
    $this->timezone = $this->session->userdata('time_zone');
    if(!empty($this->timezone)){
      date_default_timezone_set($this->timezone);
    }


  }
  public function index()
  {
    $data['mentors'] = $this->user_model->get_mentors();    
    $this->load->view('home/pages/index',$data);
  }

  Public function feedback_mail(){

    if(!empty($_POST)){

      $member_headers  = "From:".$_POST['name']."<".$_POST['email']."\r\n";    
      $member_headers .= "MIME-Version: 1.0\r\n";
      $member_headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
      $member_headers .= "X-Priority: 1\r\n";  
      $html = $this->load->view('home/pages/feedback_mail','data',TRUE);
    //send email
      echo mail('leo@dreamguys.co.in', "Feedback Mail From Mentori.ng", $html, $member_headers);

    }  


  }


  Public function search_by_subject()
  {


    $data = array();
    $keyword = $this->input->post('keyword');
    $data = array();

    if(!empty($keyword)){
      $result= $this->applicant_modal->search_mentor_message($keyword);     
      if(!empty($result)){
        foreach($result as $r){
          if(!empty($r['first_name'])){
            $datas['first_name'] = !empty($r['first_name'])?$r['first_name']:'';
            $datas['last_name'] = !empty($r['last_name'])?$r['last_name']:'';
            $datas['subject'] = !empty($r['subject'])?$r['subject']:'N/A';
            $datas['course'] = !empty($r['course'])?$r['course']:'N/A';
            $datas['mentor_personal_message'] = !empty($r['mentor_personal_message'])?$r['mentor_personal_message']:'';
            $json[]=$datas;
          }
          
        }
      }
    }else{
      echo 'works';
    }
    $data['gurus']  = $json;
    echo json_encode($data);
  }
  Public function search_by_university()
  {

    $data = array();
    $keyword = $this->input->post('keyword');
    $data = array();
    if($keyword != ''){
      $data['gurus'] = $this->applicant_modal->search_mentor_university($keyword);

    }
    echo json_encode($data);
  }
  public function confirm_signup()
  {
    $this->load->view('home/pages/beforesignup');
  }
  public function save_general_feedback()
  {
    $inputs = $this->input->post();
    $sts = 1 ;
    if($this->db->insert('general_feedback',$inputs))
    {
      $sts = 0 ;
    }
    echo $sts;
  }

  public function page_404()
  {
    
    $data['heading'] = '<center>404 Page Not Found</center>';
    $data['message'] = '';
    $this->load->view('errors/html/error_404',$data);
  }

  public function search_guru()
  {

    if(!empty($_POST)){
      $keyword = $this->input->post('keyword');
    }else{
      $keyword = $this->uri->segment(2);
    }
 
    $data['gurus'] = $this->applicant_modal->search_mentor_list_view($keyword);
    $data['count'] = $this->applicant_modal->search_mentor_list_view_count($keyword);
    $data['subjects'] = $this->settings->get_subjects(); 
    $this->load->view('home/pages/search_gurus_view',$data);



  }

  public function search_guru_by_university()
  {
    $keyword = $this->input->post('keyword');
            //$this->form_validation->set_rules('keyword','Subject','required|trim');
    if($keyword != ''){
      $data['gurus'] = $this->applicant_modal->search_mentor_list_university_view($keyword);
      $data['count'] = $this->applicant_modal->search_mentor_list_university_view_count($keyword);
      $this->load->view('home/pages/search_gurus_view',$data);
    }else{
      $this->session->set_flashdata('university_error','<font style="color:red;">Please Enter University</font>');
      redirect(base_url());
    }
  }

  public function advance_search()
  {
    $fields = array('mentor_gender', 'mentor_school', 'mentor_schools_applied', 'mentor_current_year', 'mentor_extracurricular_activities', 'mentor_job_company', 'mentor_job_title', 'mentor_job_from_year', 'mentor_about','mentor_languages_speak');
    $conditions = array();
    $post_values = $this->input->post();
    foreach($fields as $field){
      if(isset($post_values[$field]) && $post_values[$field] != '') {
        $conditions[] = "`$field` LIKE '%" . $post_values[$field] . "%'";
      }
    }

    $query = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
    LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
    LEFT JOIN country_list ON country_list.country_id = mentor_details.country WHERE applicants.role=1 and applicants.profile_updated=1 and (applicants.is_verified=1 or applicants.mobile_verified=1)";

    $query1 = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,mentor_details.* FROM applicants
    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
    LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
    LEFT JOIN country_list ON country_list.country_id = mentor_details.country WHERE applicants.role=1 and applicants.profile_updated=1 and (applicants.is_verified=1 or applicants.mobile_verified=1)";

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

            //echo $query;
            $data['gurus'] = $result;
            $data['count'] = count($result1);
            $this->load->view('home/pages/search_gurus_home_view',$data);
          }

          public function search_left()
          {
           $sts = 0;
           $resultsPerPage = 5;
           $mentor['mentor_gender'] = $this->input->post('gender');
           $mentor['mentor_school'] = $this->input->post('admitted_school');
           $mentor['mentor_schools_applied'] =  $this->input->post('school_offer');
           $mentor['mentor_current_year'] =  $this->input->post('school_year');
           $mentor['mentor_personal_message'] = '';
           $keyword = $this->input->post('keyword');
           if($keyword != ''){
            $mentor['mentor_personal_message'] = $this->input->post('keyword');
          }

          $data['count'] = $this->applicant_modal->search_guru_left_home($mentor);

          $fields = array('mentor_personal_message','mentor_gender', 'mentor_school', 'mentor_schools_applied', 'mentor_current_year');
          $conditions = array();
          foreach($fields as $field){
           if(isset($mentor[$field]) && $mentor[$field] != '') {
            $conditions[] = "`$field` LIKE '%" . $mentor[$field] . "%'";
          }
        }

        $query = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
        LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
        LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
        LEFT JOIN country_list ON country_list.country_id = mentor_details.country where applicants.role=1 and applicants.profile_updated=1 and (applicants.is_verified=1 or applicants.mobile_verified=1)";

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
    }


    $query .= " LIMIT 0,5";
			 //echo $query;exit;
    $data['gurus'] = $this->db->query($query)->result_array();

    if(!empty($data['gurus'])){
     echo $this->load->view('home/pages/gurus_search_single_view',$data,TRUE);
   }else{
     echo $sts;
   }

 }

 public function search_left_applicant()
 {
   $mentor['gender'] = $this->input->post('gender');
   $mentor['admitted_school'] = $this->input->post('admitted_school');
   $mentor['school_offer'] =  $this->input->post('school_offer');
   $mentor['school_year'] =  $this->input->post('school_year');
   $data['gurus'] = $this->applicant_modal->search_guru_left_applicant($mentor);
   if(!empty($data['gurus'])){
     echo $this->load->view('home/pages/applicant_search_single_view',$data,TRUE);
   }else{
     echo 'false';
   }
 }


 public function loadmore_search_guru()
 {
   if($this->input->post('page')):
     $paged = $this->input->post('page');
     $keyword = $this->input->post('keyword');
     $mentor_personal_message = " mentor_details.mentor_personal_message like '%$keyword%'";
     $resultsPerPage = 5;
     $sql = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
     LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
     LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
     LEFT JOIN country_list ON country_list.country_id = mentor_details.country where applicants.role=1 and (applicants.is_verified=1 or applicants.mobile_verified=1) and applicants.profile_updated=1 and applicants.is_verified and $mentor_personal_message ORDER BY applicants.id ASC";

     $sql1 = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
     LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
     LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
     LEFT JOIN country_list ON country_list.country_id = mentor_details.country where applicants.role=1 and (applicants.is_verified=1 or applicants.mobile_verified=1) and applicants.profile_updated=1 and applicants.is_verified and $mentor_personal_message ORDER BY applicants.id ASC";
     if($paged > 0){
      $page_limit= $resultsPerPage * ($paged-1);
      $pagination_sql=" LIMIT  $page_limit, $resultsPerPage";
    }
    else{
      $pagination_sql=" LIMIT 0 , $resultsPerPage";
    }

    $result= $this->db->query($sql.$pagination_sql);
    $result1= $this->db->query($sql1)->result_array();
    $data['gurus'] = $result->result_array();
    $data['count'] = count($result1);
    if(count($data['gurus']) == $resultsPerPage){
      $page = $paged + 1;
      $data['loadcount'] = $page;
    }
    else{
      $data['loadcount'] = '';
    }
    if(count($data['gurus']) == 0)
    {
      echo '<center>No more Gurus</center>';
    }
           // echo $page;exit;
    if(!empty($data['gurus'])){
     echo $this->load->view('home/pages/gurus_search_list_view',$data,TRUE);
   }
 endif;

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
   echo $this->load->view('home/pages/gurus_search_list_view',$data,TRUE);
 }
endif;

}



// public function loadmore_search_guru_home()
// {

//  if($this->input->post('page')):
//    $paged = $this->input->post('page');
//    $resultsPerPage = 5;
//    $mentor['mentor_gender'] = $this->input->post('gender'); 
//    $mentor['mentor_personal_message'] = '';
//    $keyword = $this->input->post('keyword'); 

//  $mentor_personal_message = "( applicants.first_name LIKE '%$keyword%' OR applicants.last_name LIKE '%$keyword%' OR mentor_details.mentor_personal_message LIKE '%$keyword%' )";



// $query = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,mentor_details.country as country_name,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
// LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
// LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
//  where applicants.role=1 AND  $mentor_personal_message ";


//       if($paged > 0){
//         $page_limit= $resultsPerPage * ($paged-1);
//         $pagination_sql=" LIMIT  $page_limit, $resultsPerPage";
//       }
//       else{
//         $pagination_sql=" LIMIT 0 , $resultsPerPage";
//       }
// 			//echo $query.$pagination_sql;exit;
//       $data['gurus'] = $this->db->query($query.$pagination_sql)->result_array();

//       $data['count'] = count($data['gurus']);
//       if(count($data['gurus']) == $resultsPerPage){
//         $page = $paged + 1;
//         $data['loadcount'] = $page;
//       }
//       else{
//         $data['loadcount'] = '';
//       }
//       if(count($data['gurus']) == 0)
//       {
//         echo '<center>No more Gurus</center>';
//       }
//             // echo $this->db->last_query();
//             // exit;
//       if(!empty($data['gurus'])){
//        echo $this->load->view('home/pages/gurus_search_list_view',$data,TRUE);
//      }
//    endif;

//  }

public function loadmore_guru()
{
 if($this->input->post('page')):
   $paged = $this->input->post('page');
   $resultsPerPage = 5;
   $post_values['mentor_gender'] = $this->input->post('mentor_gender');
   $post_values['mentor_school'] = $this->input->post('mentor_school');
   $post_values['mentor_schools_applied'] = $this->input->post('mentor_schools_applied');
   $post_values['mentor_current_year'] = $this->input->post('mentor_current_year');
   $post_values['mentor_extracurricular_activities'] = $this->input->post('mentor_extracurricular_activities');
   $post_values['mentor_job_company'] = $this->input->post('mentor_job_company');
   $post_values['mentor_job_title'] = $this->input->post('mentor_job_title');
   $post_values['mentor_job_from_year'] = $this->input->post('mentor_job_from_year');
   $post_values['mentor_about'] = $this->input->post('mentor_about');
   $post_values['mentor_languages_speak'] = $this->input->post('mentor_languages_speak');

   $fields = array('mentor_gender', 'mentor_school', 'mentor_schools_applied', 'mentor_current_year', 'mentor_extracurricular_activities', 'mentor_job_company', 'mentor_job_title', 'mentor_job_from_year', 'mentor_about','mentor_languages_speak');
   $conditions = array();
            //$post_values = $this->input->post();
   foreach($fields as $field){
    if(isset($post_values[$field]) && $post_values[$field] != '') {
      $conditions[] = "`$field` LIKE '%" . $post_values[$field] . "%'";
    }
  }

  $query = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
  LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
  LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
  LEFT JOIN country_list ON country_list.country_id = mentor_details.country WHERE applicants.role=1 and applicants.profile_updated=1 and (applicants.is_verified=1 or applicants.mobile_verified=1)";

  if(count($conditions) > 0) {
    $operator = (count($conditions) > 1) ? ' AND ' : ' OR ';
              $query .= " AND  " . implode ($operator, $conditions); // you can change to 'OR', but I suggest to apply the filters cumulative
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
              echo '<center>No more Gurus</center>';
            }
            if(!empty($data['gurus'])){
             echo $this->load->view('home/pages/gurus_loadmore_list_view',$data,TRUE);
           }
         endif;
       }

       public function mentor_detail($username)
       {


           // $mentor_id = base64_decode($id);
        $mentor = $this->db->get_where('applicants',array('username' => $username ))->row_array();
        if(!empty($mentor)){
          $data['gurus'] = $this->applicant_modal->applicant_detail_list_view($mentor['id']);
          $data['reviews'] = $this->user_model->review_list_view($mentor['id']);
          $this->load->view('home/pages/search_gurus_detail_view',$data);
        }else{
          redirect('login');
        }
      }
      Public function profile_settings(){

        if($this->session->userdata('applicant_id')){
          $data['subject'] = $this->user_model->get_all_subjects();
          $this->load->view('home/pages/profile_settings',$data);
        }else{
          redirect('login');
        }
      }


      Public function add_mentor_course(){

         // echo '<pre>';
         // print_r($_POST['years']);
         // exit;
        $mentor_id = $this->session->userdata('applicant_id');
        $where= array('mentor_id' => $mentor_id);
        $this->db->delete('mentor_course_details',$where);

        for ($i=0; $i < count($_POST['courses']); $i++) {
          $courses = explode('|',$_POST['courses'][$i]);
          $data= array(
            'mentor_id' => $mentor_id,
            'subject_id'=> $courses[0],
            'course_id' => $courses[1],
            'years'			=> $_POST['expYears'][$courses[1]],
            'months'		=> $_POST['expMonths'][$courses[1]]
          );
          $this->db->insert('mentor_course_details',$data);
        }
        echo ($this->db->affected_rows())?true:false;
      }

      Public function add_biography(){
        $applicant_id = $this->session->userdata('applicant_id');
        $where = array('mentor_id' => $applicant_id);
        $count = $this->db->get_where('mentor_details',$where)->num_rows();
        $data['mentor_id'] = $applicant_id;
        $str = $_POST['mentor_personal_message'];

        /* Conveting link into anchor tag */ 

        // $str = preg_replace_callback('#(?:https?://\S+)|(?:www.\S+)|(?:\S+\.\S+)#', function($arr){        
        // $url = parse_url($arr[0]);       
        // return sprintf('<a href="%1$s">%1$s</a>', $arr[0]);
        // }, $str);


        $data['mentor_personal_message'] = $str;
        $data['modified_date'] = date("Y-m-d H:i:s");
        if($count == 0){
          $this->db->insert('mentor_details', $data);
        }else{
          $this->db->update('mentor_details', $data, array('mentor_id' => $applicant_id));
        }
        echo ($this->db->affected_rows())?true:false;
      }

      public function email_verification()
      {
        $id =$this->session->userdata('guru_id');
        $data['result'] = $this->user_model->get_progress_bar($id);
        $this->load->view('home/pages/guru_email_verification',$data);
      }

      public function mobile_verify()
      {
        $id =$this->session->userdata('applicant_id');
        $data['result'] = $this->user_model->get_progress_bar($id);
        $this->load->view('home/pages/guru_mobile_verification',$data);
      }

      public function verify_success()
      {
        $id =$this->session->userdata('applicant_id');
        $data['result'] = $this->user_model->get_progress_bar($id);
        $this->load->view('home/pages/guru_mobile_verification_success',$data);
      }

      public function applicant_success_signup()
      {
        $id =$this->session->userdata('applicant_id');
        $data['result'] = $this->user_model->get_progress_bar($id);
        $this->load->view('home/pages/applicant_signup_success',$data);
      }

      public function verify_mobile_code(){

        $id =$this->session->userdata('applicant_id');
        $data['result'] = $this->user_model->get_progress_bar($id);
        $this->load->view('home/pages/guru_mobile_verification_code',$data);

      }

      function smsgatewaycenter_com_Send($mobile, $sendmessage, $debug=false){
        //$getuser = array('user1' => '123456');
        //$getmobile = array('user1' => '9655105336');
        $sts = 0;
        $smsgatewaycenter_com_user = "resellerdemo"; //Your SMS Gateway Center Account Username
        $smsgatewaycenter_com_password = "resellerdemo";  //Your SMS Gateway Center Account Password
        $smsgatewaycenter_com_url = "https://www.smsgatewaycenter.com/library/send_sms_2.php?"; //SMS Gateway Center API URL
        $smsgatewaycenter_com_mask = "SCHGURU"; //Your Approved Sender Name / Mask

        global $smsgatewaycenter_com_user,$smsgatewaycenter_com_password,$smsgatewaycenter_com_url,$smsgatewaycenter_com_mask;
        $parameters = 'UserName='.$smsgatewaycenter_com_user;
        $parameters.= '&Password='.$smsgatewaycenter_com_password;
        $parameters.= '&Type=Individual';
        $parameters.= '&Language=English';
        $parameters.= '&Mask='.$smsgatewaycenter_com_mask;
        $parameters.= '&To='.urlencode($mobile);
        $parameters.= '&Message='.urlencode($sendmessage);
        $apiurl =  $smsgatewaycenter_com_url.$parameters;
        $ch = curl_init($apiurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);
        if(!empty($curl_scraped_page))
        {
          $sts =0;
        }
        echo $sts;
//        if ($debug) {
//           // echo "Response: <br><pre>" . $this->session->userdata('smsgatewaycenterotp') . "</pre><br>";
//
//        }
//        return($curl_scraped_page);
      }

      public function call(){

          // Your Account SID and Auth Token from twilio.com/console
       $AccountSid = "AC487ebf4ea5ba20aa6fca7db6c7819f95";
       $AuthToken = "2363c398b410d102f5e8b319f859cb4a";       


          // A Twilio number you own with Voice capabilities
       $twilio_number = "+13123006989";

          // Where to make a voice call (your cell phone?)
       $to_number = "+917339376390";

       $twilio = new Client($AccountSid, $AuthToken);

          // $client->account->calls->create(  
          // $to_number,
          // $twilio_number,
          // array(
          // "url" => "http://demo.twilio.com/docs/voice.xml"
          // )
          // );

       $call = $twilio->calls
       ->create( $to_number,
        $twilio_number,
        array("url" => "http://demo.twilio.com/docs/voice.xml")
      );

       print($call->sid);

     }

     public function send_otp()
     {

      $applicant_id = $this->session->userdata('applicant_id');
        // $this->db->update('mentor_details',array('mentor_phone' => ''),array('mentor_id' => $applicant_id));
        // $this->db->update('applicants',array('mobile_number' => ''),array('id' => $applicant_id));


      $name = $this->session->userdata('first_name');
      $otp =  $this->smsgatewaycenter_com_OTP();
      $mobile_number = $_POST['country_code'].$_POST['mobile_number'];
      $where  = array('mobile_number' => $mobile_number ,'id !='=>$applicant_id);
      $count = $this->db->get_where('applicants',$where)->num_rows();        
      if($count > 0){

        echo json_encode(array('status'=>false,'message'=>'Mobile number already registerd ! try other number to send OTP!'));
        exit;
      }       

      $data = array('otp' => $otp,'temp_mobile_no' =>$mobile_number);
      $where = array('id' => $applicant_id);
      $this->db->update('applicants',$data,$where);
        //$this->db->update('mentor_details',array('mentor_phone' => $mobile_number),array('mentor_id' => $applicant_id));

      $mobile_number = '+'.$mobile_number;

      $message = 'Hello '.ucfirst($name).'! Welcome to Mentori.ng! Your one time password (OTP):'.$otp;
      $AccountSid = "AC487ebf4ea5ba20aa6fca7db6c7819f95";
      $AuthToken = "2363c398b410d102f5e8b319f859cb4a";        
      $client = new Client($AccountSid, $AuthToken);



      $people = array($mobile_number => $name);
      foreach ($people as $number => $name) {
        try{
          $sms = $client->messages->create(
            $number,
            array(
              'from' => "+13123006989",
              'body' => $message              
            )
          );
          $response = array('status' =>true);
          echo json_encode(array('status'=>true,'message'=>'success'));
        }catch(Exception $error){
          echo json_encode(array('status'=>false,'message'=>'Enter valid number!'));          
        }
      }
    }

    public function send_again_otp()
    {
      error_reporting(0);
      $applicant_id = $this->session->userdata('applicant_id');
      $name = $this->session->userdata('first_name');
      $otp =  $this->smsgatewaycenter_com_OTP();
      $data = array('otp' => $otp);
      $where = array('id' => $applicant_id);
      $this->db->update('applicants',$data,$where);  
      $mobile_number = $this->db->get_where('applicants',$where)->row()->temp_mobile_no;
      $message = 'Hello '.ucfirst($name).'! Welcome to Mentori! Your one time password (OTP):'.$otp;


      $AccountSid = "AC487ebf4ea5ba20aa6fca7db6c7819f95";
      $AuthToken = "2363c398b410d102f5e8b319f859cb4a";

      $mobile_number = '+'.$mobile_number;
      $client = new Client($AccountSid, $AuthToken);
      $people = array($mobile_number => $name);
      foreach ($people as $number => $name) {
        try{
          $sms = $client->messages->create(
            $number,
            array(
              'from' => "+13123006989",
              'body' => $message              
            )
          );
          $response = array('status' =>true);
          echo json_encode(array('status'=>true,'message'=>'success'));
        }catch(Exception $error){
          echo json_encode(array('status'=>false,'message'=>'Enter valid number!'));          
        }
      }

    }

    Public function check_otp(){
      $applicant_id = $this->session->userdata('applicant_id');
      $where = array('id' => $applicant_id,'otp' =>$_POST['verification_code']);
      $count = $this->db->get_where('applicants',$where)->num_rows();
      if($count!=0){


       $where = array('id' => $applicant_id,'otp' =>$_POST['verification_code']);
       $data = $this->db->get_where('applicants',$where)->row_array();




       $this->db->where('id',$applicant_id);
       $this->db->update('applicants',array('mobile_verified'=>1,'mobile_number'=>$data['temp_mobile_no']));
       echo json_encode(array('mobile_number'=>$data['temp_mobile_no']));
     }else{
      echo '1';
    }
  }

  public function send_code()
  {
    $sts = 0;
    $id =$this->session->userdata('applicant_id');
    $verification_code = $this->input->post();
    $code = $verification_code['verification_code'];
    $otp = $this->session->userdata('smsgatewaycenterotp');
    if($otp == $code)
    {
      $this->db->where('id',$id);
      $this->db->update('applicants',array('mobile_verified'=>1));
      $sts = 0;
    }

    echo $sts;
  }

  public function smsgatewaycenter_com_OTP($length = 6, $chars = '0123456789'){
    $chars_length = (strlen($chars) - 1);
    $string = $chars{rand(0, $chars_length)};
    for ($i = 1; $i < $length; $i = strlen($string)){
      $r = $chars{rand(0, $chars_length)};
      if ($r != $string{$i - 1}) $string .=  $r;
    }
    return $string;
  }

  public function check_session()
  {
    $sts = 0;
    $id =$this->session->userdata('applicant_id');
    if($id != '' && $id > 0)
    {
      $sts=1;
    }
    echo $sts;
  }


}
