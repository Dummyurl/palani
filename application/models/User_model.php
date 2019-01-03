<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model{
	function __construct() {
		//$this->tableName = 'users';
		$this->primaryKey = 'id';
	}


    Public function get_mentors(){

        $sql ="SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
        LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
        LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
        LEFT JOIN country_list ON country_list.country_id = mentor_details.country where applicants.role=1 ORDER BY rating_value DESC LIMIT 4";
        return $this->db->query($sql)->result_array();
    }


    Public function common_search($page_no,$per_page){


      $data = json_decode( file_get_contents( 'php://input' ), true );
      if(empty($data)){
          $data = $this->input->post();
      }


      /* SQL */
      $sql = "SELECT applicants.id as user_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,mentor_details.country,mentor_details.charge_type,mentor_details.mentor_personal_message,mentor_details.mentor_charge,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
      LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
      LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id        
      where  applicants.role=1";


      /* Filter by male */

      if(!empty($data['gender'])){      
        $sql .= " AND mentor_details.mentor_gender = '".$data['gender']."'";     
    }


    $where = array();

    if(!empty($data['subject_id'])){
      $where += array('subject_id'=>$data['subject_id']);  
  }
  if(!empty($data['course_id'])){
      $where += array('course_id'=>$data['course_id']);  
  }


  if(!empty($where)){
      $mentor_ids = $this->db->select('mentor_id')->get_where('mentor_course_details',$where)->result_array();  

      if(!empty($mentor_ids)){
        foreach($mentor_ids as $m){
          $m_ids[]=$m['mentor_id'];
      }
  }
}

if(!empty($m_ids)){
  $m_ids =implode(',',$m_ids);
     // $m_ids =array_unique($m_ids);

  $sql .= ' AND applicants.id IN ('.$m_ids.') ';      
}else{
  if(!empty($_POST['subject_id']) || !empty($_POST['course_id'])){
    $sql .= ' AND applicants.id=27000 ';
}else{
    $sql .= '';    
}
}

/* Name Search */

if(!empty($data['name'])){

  $user_name = $data['name'];
  $sql .=" AND (`applicants`.`first_name` LIKE '%$user_name%' ESCAPE '!' OR `applicants`.`last_name` LIKE '%$user_name%' )  ";
}



if(empty($data['order_by'])){
    $sql .=" ORDER BY applicants.id DESC ";
}
if(!empty($data['order_by'])){

    if($data['order_by'] == 'Rating'){
        $sql .=" ORDER BY rating_value DESC ";
    }
    if($data['order_by'] == 'Popular'){
        $sql .=" ORDER BY rating_count DESC ";
    }
    if($data['order_by'] == 'Latest'){
        $sql .=" ORDER BY applicants.id DESC ";
    }
    if($data['order_by'] == 'Free'){
        $sql .=" AND mentor_details.charge_type = 'free' ";
    }
}



/* SQL ENDS */

if($page_no > 0){
  $page_limit= $per_page * ($page_no-1);
  $sql .=" LIMIT  $page_limit, $per_page";
}else{
  $sql .=" LIMIT 0 , $per_page";
}

echo $sql;
exit;
return  $this->db->query($sql)->result_array();
}

public function common_search_count()
{
    $data = json_decode( file_get_contents( 'php://input' ), true );
    if(empty($data)){
        $data = $this->input->post();
    }

    /* SQL */
    $sql = "SELECT applicants.id as user_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,mentor_details.country,mentor_details.charge_type,mentor_details.mentor_personal_message,mentor_details.mentor_charge,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
    LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id        
    where  applicants.role='1'";


    /* Filter by male */


    if(!empty($data['gender'])){      
        $sql .= " AND mentor_details.mentor_gender = '".$data['gender']."'";     
    }



    $where = array();

    if(!empty($data['subject_id'])){
        $where += array('subject_id'=>$data['subject_id']);  
    }
    if(!empty($data['course_id'])){
        $where += array('course_id'=>$data['course_id']);  
    }


    if(!empty($where)){
        $mentor_ids = $this->db->select('mentor_id')->get_where('mentor_course_details',$where)->result_array();  

        if(!empty($mentor_ids)){
            foreach($mentor_ids as $m){
                $m_ids[]=$m['mentor_id'];
            }
        }
    }

    if(!empty($m_ids)){
        $m_ids =implode(',',$m_ids);
        $sql .= ' AND applicants.id IN ('.$m_ids.') ';      
    }else{
        if(!empty($_POST['subject_id']) || !empty($_POST['course_id'])){
            $sql .= ' AND applicants.id=27000 ';
        }else{
            $sql .= '';    
        }
    }


    /* Name Search */

    if(!empty($data['name'])){

        $user_name = $data['name'];
        $sql .=" AND (`applicants`.`first_name` LIKE '%$user_name%' ESCAPE '!' OR `applicants`.`last_name` LIKE '%$user_name%' )";
    }

    /* SQL ENDS */
    return $this->db->query($sql)->num_rows();;
}



Public function get_all_subjects(){
    $where = array('status'=>1);
    return $this->db->order_by('subject','asc')->get_where('subject',$where)->result();
}

Public function get_all_notification($applicant_id){


 if($this->session->userdata('role') == 0){

    $query = "SELECT * FROM notifications n WHERE mentee_view = '1' AND (n.notification_id = '$applicant_id' OR n.user_id = '$applicant_id') ORDER BY n.notify_id DESC";
}else{
   $query = "SELECT * FROM notifications n WHERE mentor_view = '1' AND (n.notification_id = '$applicant_id' OR n.user_id = '$applicant_id') ORDER BY n.notify_id DESC";

}
return   $this->db->query($query)->result_array();
}
Public function get_notification_mentee($applicant_id){

  $query = "SELECT * FROM notifications n WHERE mentee_view = '1' AND (n.notification_id = '$applicant_id' OR n.user_id = '$applicant_id') ORDER BY n.notify_id DESC LIMIT 5;";
  return   $this->db->query($query)->result_array();
}
Public function get_notification_mentor($applicant_id){

  $query = "SELECT * FROM notifications n WHERE mentor_view = '1' AND (n.notification_id = '$applicant_id' OR n.user_id = '$applicant_id') ORDER BY n.notify_id DESC LIMIT 5;";
  return   $this->db->query($query)->result_array();
}


Public function get_rating($applicant_id)
{
    $query = "SELECT (select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
    LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
    where applicants.role=1 and applicants.id = $applicant_id ";
    return $this->db->query($query)->row();
}


Public function get_payment_by_id()
{
    $invite_id = base64_decode($this->uri->segment(3));
    $sql = "SELECT p.*,a.delete_sts, a.username as user_name,a.profile_img ,CONCAT(a.first_name,' ',a.last_name) AS user_name,s.picture_url FROM applicants a
    LEFT JOIN payments p ON a.id = p.user_id
    LEFT JOIN social_applicant_user s ON s.reference_id = p.mentor_id 
    WHERE p.invite_id = '$invite_id'";
    return $this->db->query($sql)->result_array();
}

private function _get_datatables_query_g()
{


 $user_id = $this->session->userdata('applicant_id');

 $columns = array(
    'a.first_name',
    'a.created_date',
    'p.payment_gross',
    'p.payment_id',
    'a.delete_sts'
);


 $search_value = trim($_POST['search']['value']);

 if(strpos($search_value,'-')){
    $search_value = date('Y-m-d',strtotime($search_value));
}else if(strpos($search_value,':')){
    $search_value = date('h:i:s',strtotime($search_value));
}


// $sql ="SELECT a.*,p.user_id,p.payment_date,p.payment_status,SUM(payment_gross) as earned,COUNT(p.payment_id)as calls,a.delete_sts,p.payment_id, a.username as applicant_user_name,a.profile_img as applicant_profile_img,CONCAT(a.first_name,' ',a.last_name) AS applicant_name,s.picture_url as applicant_picture,i.invite_id,i.approved,i.invite_date,i.invite_time,i.invite_end_time,i.time_zone
// FROM applicants a
// LEFT JOIN payments p ON a.id = p.user_id
// LEFT JOIN social_applicant_user s ON s.reference_id = p.user_id
// LEFT JOIN invite i ON i.invite_id = p.invite_id
// WHERE a.role = '0' AND p.mentor_id = '$user_id' AND p.payment_status = '1'";


$sql ="SELECT a.id,p.payment_date,p.per_hour_charge,p.mentor_id,p.role_type,p.payable_charge,p.payment_id,p.invoice_no,p.remarks,p.payment_status,p.payment_gross,p.handling_charge,p.transaction_type,a.delete_sts, a.username as applicant_user_name,a.profile_img as applicant_profile_img,CONCAT(a.first_name,' ',a.last_name) AS applicant_name,s.picture_url as applicant_picture,i.invite_id,i.approved,i.invite_date,i.invite_time,i.invite_end_time,i.time_zone
FROM applicants a
LEFT JOIN payments p ON a.id = p.user_id
LEFT JOIN invite i ON i.invite_id = p.invite_id
LEFT JOIN social_applicant_user s ON s.reference_id = p.mentor_id 
WHERE a.role = 0 AND p.mentor_id = '$user_id' AND p.payment_status = '1'";



if($search_value == 'Completed'){
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
       OR p.payment_date LIKE '%$search_value%'
       OR a.delete_sts LIKE '%$search_value%'
       OR p.payment_gross LIKE '%$search_value%'
       OR p.payment_id LIKE '%$search_value%'
       OR p.user_id LIKE '%$search_value%'

   ) ";

}
}

// $sql .=" GROUP BY i.invite_id ";

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
function get_datatables_g()
{
    $sql = $this->_get_datatables_query_g();
    if($_POST['length'] != -1)
        $limits = $_POST['start'].','.$_POST['length'];
    $sql .=" LIMIT $limits";
    return $this->db->query($sql)->result();
}

function count_filtered_g()
{
    $sql = $this->_get_datatables_query_g();
    return $this->db->query($sql)->num_rows();
}
public function count_all_g()
{
    $sql = $this->_get_datatables_query_g();
    return $this->db->query($sql)->num_rows();
}



Public function get_account_details()
{
    $data = '';
    $id = $this->session->userdata('applicant_id');
    $where = array('applicant_id' =>$id);
    $data =  $this->db->get_where('account_details',$where)->row();
    return $data;
}

Public function get_total_earned()
{
    $where = array(
       'mentor_id'=>$this->session->userdata('applicant_id'),
       'payment_status'=>1,
       'transaction_type'=>'CREDIT',
       'role_type' => 'mentor'
   );
    return $this->db->select('SUM(payable_charge) as earned_amount')->get_where('payments',$where)->row_array();
    
}
Public function get_total_requested()
{
    $where = array('mentor_id'=>$this->session->userdata('applicant_id'),'status'=>1);
    return $this->db->select('SUM(request_amount) as request_amount')->get_where('pay_request_details',$where)->row_array();
    
}
Public function get_total_paid()
{
    $where = array('mentor_id'=>$this->session->userdata('applicant_id'),'status'=>2);
    return $this->db->select('SUM(request_amount) as paid_amount')->get_where('pay_request_details',$where)->row_array();
    
}


Public function get_applicant_details()
{

    $id = $this->session->userdata('applicant_id');
    return $this->db->query("SELECT a.*,SUM(payment_gross) as earned,COUNT(p.payment_id) as calls,a.created_date,a.delete_sts,
        a.username as applicant_user_name,
        a.profile_img as applicant_profile_img,
        CONCAT(a.first_name,' ',a.last_name) AS applicant_name,
        s.picture_url as applicant_picture
        FROM applicants a
        LEFT JOIN payments p ON a.id = p.user_id
        LEFT JOIN social_applicant_user s ON s.reference_id = p.user_id
        WHERE  a.id = '$id' ")->row();
}



public function checkUser($data = array())
{
    if($this->session->userdata('register_type')=="user"){
        $role = 0;
        $type = 'user';
    }else{
        $role = 1;
        $type = 'guru';
    }

    $this->tableName = 'social_applicant_user';
    $check_query = $this->db->query("SELECT * FROM `applicants` WHERE `email` = '".$data['email']."' ")->row_array();

    if(empty($check_query['id']))
    {
        $userData['first_name'] = $data['first_name'];
        $userData['last_name'] = $data['last_name'];
        $userData['username'] = $this->generate_username($userData['first_name'].' '.$userData['last_name'], 10);
        $userData['email'] = $data['email'];
        $userData['role'] = $role;
        $userData['type'] =$type;
        $userData['mobile_verified'] =0;
        $userData['is_verified'] = 1;
        $userData['password'] = md5($this->generateString());
        $userData['verification_code']  = $this->generateMailString();
        $data['modified'] = date("Y-m-d H:i:s");
        $this->db->insert('applicants',$userData);
        $data['reference_id'] = $this->db->insert_id();
        $userData['id'] = $this->db->insert_id();
        $this->mail_template($userData,$userData['verification_code'],$data['register_type']);
    }
    else
    {
        $userData['modified'] = date("Y-m-d H:i:s");
        $this->db->where('email',$data['email']);
        $this->db->update('applicants',$userData);
        $data['reference_id'] = $check_query['id'];
        $userData['role'] = $role;
        $userData['type'] =$type;
        $userData['id'] =$check_query['id'];
        $userData['mobile_verified'] =$check_query['mobile_verified'];
    }


    // $this->db->select($this->primaryKey);
    // $this->db->from($this->tableName);
    $this->db->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid']));
    $prevQuery = $this->db->get('social_applicant_user');
    $prevCheck = $prevQuery->num_rows();

    if($prevCheck > 0)
    {
        $prevResult = $prevQuery->row_array();
        $data['modified'] = date("Y-m-d H:i:s");
        // if(isset($data['register_type'])){unset($data['register_type']);}
        // $update = $this->db->update('social_applicant_user',$data,array('id'=>$prevResult['id']));                    
        $userID = $data['reference_id'];
    }
    else
    {
        $data['created'] = date("Y-m-d H:i:s");
        $data['modified'] = date("Y-m-d H:i:s");
        if(isset($data['register_type'])){unset($data['register_type']);}
        $insert = $this->db->insert('social_applicant_user',$data);                    
        $userID = $data['reference_id'];
    }
    $user_role['id'] = $userID;

    return $userData;
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

    function generateString()
    {
       return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
   }

   function generateMailString()
   {
       return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 15);
   }

   public function get_progress_bar($mentor_id)
   {

    $sql = "SELECT 
    applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.role,applicants.type,applicants.profile_img,applicants.is_verified,applicants.profile_updated,applicants.mobile_number,
    social_applicant_user.picture_url,COUNT(review_ratings.rating) as rating_count,ROUND(AVG(review_ratings.rating)) as rating_value,mentor_details.* FROM `applicants`
    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
    LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
    LEFT JOIN review_ratings ON review_ratings.user_id = applicants.id    
    WHERE applicants.id=$mentor_id";

    $query = $this->db->query($sql)->row_array();        
    return $query;
}

public function applicant_list_view()
{

    $query = $this->db->query(" SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.role,applicants.profile_img,applicants.is_verified,social_applicant_user.picture_url,applicants_profile.*,mentor_details.* FROM applicants
        LEFT JOIN `applicants_profile` ON applicants.id = applicants_profile.applicant_id
        LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
        LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id        
        where applicants.role=0  ORDER BY applicants.id DESC LIMIT 0,5")->result_array();
    return $query;
}

public function applicant_list_view_count()
{

    $query = $this->db->query("SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.role,applicants.profile_img,applicants.is_verified,social_applicant_user.picture_url,applicants_profile.*,mentor_details.* FROM applicants
        LEFT JOIN `applicants_profile` ON applicants.id = applicants_profile.applicant_id
        LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
        LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id        
        where applicants.role=0  ORDER BY applicants.id DESC")->result_array();

    return count($query);
}

public function gurus_detail_list_view($id)
{
   $query = $this->db->query(" SELECT  applicants.id AS app_id,applicants.first_name,applicants.username,applicants.last_name,applicants.email,applicants.role,applicants.profile_img,applicants.is_verified,mentor_details.country,social_applicant_user.picture_url,mentor_details.*
    FROM applicants
    LEFT JOIN `applicants_profile` ON applicants.id = applicants_profile.applicant_id
    LEFT JOIN `social_applicant_user` ON social_applicant_user.reference_id = applicants.id
    LEFT JOIN `mentor_details` ON applicants.id = mentor_details.mentor_id
    WHERE applicants.id=$id ")->row_array();
   return $query;
}

public function verify_user($verification_code)
{
    $sts = 1 ;
    $check_query = $this->db->query("SELECT * FROM `applicants` WHERE `verification_code` = '".$verification_code."' AND is_verified = 1 ")->row_array();
    if(isset($check_query['id'])&&!empty($check_query['id']))
    {
        $this->db->where('verification_code',$verification_code);
        if($this->db->update('applicants',array('is_verified'=>0)))
        {
            $sts = 0;
        }
    }
    return $sts;
}

public function verify_success($id)
{
    $sts = 0 ;
    $check_query = $this->db->query("SELECT * FROM `applicants` WHERE `id` = '".$id."'")->row_array();
    if(isset($check_query['id'])&&!empty($check_query['id']))
    {
        $this->db->where('id',$id);
        if($this->db->update('applicants',array('is_verified'=>1)))
        {
            $sts = 1;
        }
    }
    return $sts;
}

public function check_mentor_login($params)
{
    $this->load->library('bcrypt');
    $sts = 1;
    $query = $this->db->query("SELECT * FROM `applicants` WHERE `email` = '".$params['email']."'  AND `password` = '".MD5($params['password'])."' AND `delete_sts` = 0 ;")->row_array();        
    if(sizeof($query)>0)
    {
        $this->session->set_userdata(array('applicant_id'=>$query['id'],'role'=>$query['role'],'first_name' => $query['first_name'],'last_name' => $query['last_name']));
        $applicant_id     = $this->session->userdata('applicant_id');
        $this->db->update('applicants',array('logged_in'=>1,'logged_by'=>'web'),array('id'=>$applicant_id ));


        /* Blog Login */
        $result = $this->db->get_where('users',array('email'=>$params['email']))->row_array();
        if(!empty($result)){

             //set user data
          $user_data = array(
              'inf_ses_id' =>$result['id'],
              'inf_ses_username' => $result['username'],
              'inf_ses_email' => $result['email'],
              'inf_ses_role' => 'author',
              'inf_ses_logged_in' => true,
              'inf_ses_app_key' => $this->config->item('app_key'),
          );
          $this->session->set_userdata($user_data);


      }else{


          $blog_data = array(
              'username' => $query['username'], 
              'email' => $query['email'], 
              'password' => $this->bcrypt->hash_password($params['password']),
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

      /* Blog Login */


      $sts = 0;
  }
  return $sts;
}

public function update_profile($mentor_id,$profile_details)
{   

    // echo '<pre>'; print_r($_POST);
    $sts = 1 ;
    $user_profile['first_name']  = $_POST['first_name'];
    $user_profile['last_name']   = $_POST['last_name'];
    $user_profile['profile_updated']       = 1;

    $this->db->where('id',$mentor_id);
    if($this->db->update('applicants',$user_profile)){
        $check_profile_exist = $this->db->query(" SELECT * FROM `mentor_details` WHERE `mentor_id` =  ".$mentor_id)->row_array();

        $profile_details['mentor_id'] = $mentor_id;
        if(isset($check_profile_exist['id'])&&!empty($check_profile_exist['id'])){
            $profile_details['modified_date'] = date("Y-m-d h:m:s");
            $this->db->where('mentor_id',$mentor_id);
            if($this->db->update('mentor_details',$profile_details))
            {
                $sts = 0 ;
            }
        }
        else
        {
            if($this->db->insert('mentor_details',$profile_details))
            {
                $sts = 0 ;
            }
        }
    }
    return $sts;
}

public function mail_template($userdata,$verification_code,$type)
{
 $url = base_url()."login";
 $message= '<table width="600" cellpadding="0" cellspacing="0" align="center">
 <tr>
 <td style="padding:50px 50px 50px 50px; border:1px solid #bfc0cd; border-radius:20px;">
 <table width="100%" cellpadding="0" cellspacing="0" align="center">
 <tr>
 <td>
 <p style="margin:0; padding:0;"><a href="'.base_url().'" target="_blank"><img src="'.base_url().'assets/images/mentori-logo-emailtemplate.png" /></a></p>
 <h1 style="font-family:Arial, Helvetica, sans-serif; font-size:36px; color:#000; font-weight:bold; margin:50px 0 10px 0; padding:0;">Hi '.$userdata['first_name'].',</h1>
 <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#808080; font-weight:normal; margin:0 0 30px 0; padding:0;">Thank you for choosing <span style="font-weight:bold; color:#78bd34;">Mentori</span></h2>
 <p style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#808080; font-weight:normal; margin:0; padding:0;">Please click the below link to check your account.</p>
 <p style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#ffffff; font-weight:normal; margin:15px 0 0 0; padding:0;"><a href="'.$url.'" style="color:#ffffff; padding:12px 25px 12px 25px; background:#78bd34; display:inline-block; text-decoration:none; border-radius:8px;">Go to Mentori</a></p>
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
 $member_headers  = "From: Mentori".'info@mentori.ng'."\r\n";
 $member_headers .= "Reply-To: ".'info@mentori.ng'."\r\n";
 $member_headers .= "MIME-Version: 1.0\r\n";
 $member_headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
 $member_headers .= "X-Priority: 1\r\n";

                //send email
 if(mail($userdata['email'], "Thank you for Registering!", $message, $member_headers))
 {
     $sts = 0;
 }
}

public function get_country_list()
{
    $query = $this->db->get('country_list');
    $result = $query->result_array();
    return $result;
}

public function review_list_view($id)
{
    $where  = array('r.user_id'=>$id);
    return  $this->db
    ->join('applicants a ','a.id = r.reviewer_id')
    ->get_where('review_ratings r',$where)
    ->result_array();
}
public function review_list_view_admin($id)
{
    $where  = array('r.user_id'=>$id);
    return  $this->db
    ->join('applicants a ','a.id = r.reviewer_id')
    ->get_where('review_ratings r',$where)
    ->result_array();
}

public function get_dashboard_activity($id,$limit,$current_page)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.username,t2.last_name,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_to',$id);
    $this->db->where('t1.delete_sts',0);
    $this->db->join('applicants t2','t2.id=t1.invite_from','left');
    $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_from','left');
    $this->db->order_by('t1.invite_id','desc');
    $this->db->limit($limit,$current_page);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}

public function get_dashboard_activity_search($id,$keyword)
{
    if(!empty($keyword)){
        $query = $this->db->query("select t1.time_zone,t1.invite_id,t1.message,t1.invite_date,t1.invite_time,t3.picture_url,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t1.approved from invite t1 left join applicants t2 on t2.id=t1.invite_from LEFT JOIN social_applicant_user t3 ON t3.reference_id = t2.id where t1.delete_sts = 0 AND t1.invite_to='$id' AND ((t2.first_name like '%$keyword%') OR (t1.invite_date like '%$keyword%') OR (t1.invite_time like '%$keyword%') OR (t2.last_name like '%$keyword%') OR (CONCAT(t2.first_name,' ',t2.last_name) like '%$keyword%')) order by t1.invite_id desc");
    }else{
       $query = $this->db->query("select t1.invite_id,t1.message,t1.invite_date,t1.invite_time,t3.picture_url,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t1.approved from invite t1 left join applicants t2 on t2.id=t1.invite_from LEFT JOIN social_applicant_user t3 ON t3.reference_id = t2.id where t1.invite_to='$id' order by t1.invite_id desc");
   }
   $result = $query->result_array();
   return $result;
}

public function get_chat_list($id)
{
    $query = $this->db->query("select t2.logged_in,t1.invite_id,t1.message,t1.invite_date,t1.invite_time,t1.invite_to,t3.picture_url,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img from invite t1 left join applicants t2 on t2.id=t1.invite_from LEFT JOIN social_applicant_user t3 ON t3.reference_id = t2.id where t1.invite_to=$id group by t1.invite_from");
    $result = $query->result_array();

    return $result;
}

public function get_chat_list_search($id,$keyword)
{
 $query = $this->db->query("select t2.logged_in,t2.username,t1.invite_id,t1.message,t1.invite_date,t1.invite_time,t3.picture_url,t2.id as app_id,t2.first_name,t2.last_name,t2.profile_img from invite t1 left join applicants t2 on t2.id=t1.invite_from LEFT JOIN social_applicant_user t3 ON t3.reference_id = t2.id where t1.invite_to='$id' and((t2.first_name like '%$keyword%') OR (t2.last_name like '%$keyword%') OR (CONCAT(t2.first_name,' ',t2.last_name) like '%$keyword%')) group by t1.invite_from");
 $result = $query->result_array();
 return $result;
}

public function get_latest_chat($selected_user,$session_id)
{
        // $query = $this->db->query("select DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage, sender.id as sender_id, CONCAT(receiver.first_name,' ',receiver.last_name) as receiverName, receiver.profile_img as receiverImage, receiver.id as receiver_id, receiver.username, msg.msg, msg.chatdate
        //           from chat msg inner join applicants sender on msg.sent_id = sender.id
        //           inner join applicants receiver on msg.recieved_id = receiver.id WHERE (msg.recieved_id=$session_id and msg.sent_id=$selected_user and msg.delete_sts=0) OR (msg.recieved_id=$selected_user and msg.sent_id=$session_id and msg.delete_sts=0) ");



   $query = $this->db->query("SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage, sender.id as sender_id,msg.msg, msg.chatdate,social.picture_url as socialImage,msg.id as id,msg.file_name,msg.file_path
    from chat msg
    LEFT  join applicants sender on msg.sent_id = sender.id
    LEFT  join social_applicant_user social on social.reference_id = msg.sent_id
    where (msg.recieved_id = $selected_user AND msg.sent_id = $session_id) or  (msg.recieved_id = $session_id AND msg.sent_id =  $selected_user) AND msg.delete_sts = 0 ORDER BY msg.id ASC ");

   $result = $query->result_array();
   return $result;
}

public function get_unread_chat_count($selected_user,$session_id)
{
    $query = $this->db->query("select DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage, sender.id as sender_id, CONCAT(receiver.first_name,' ',receiver.last_name) as receiverName, receiver.profile_img as receiverImage, receiver.id as receiver_id, receiver.username, msg.msg, msg.chatdate
      from chat msg inner join applicants sender on msg.sent_id = sender.id
      inner join applicants receiver on msg.recieved_id = receiver.id WHERE msg.recieved_id=$selected_user and msg.sent_id=$session_id and msg.read_status=0 and msg.delete_sts=0");
    $result = $query->result_array();
    return $result;
}

public function unread_to_read_count($selected_user,$session_id)
{
    $this->db->where('recieved_id',$session_id);
    $this->db->where('sent_id',$selected_user);
    $this->db->update('chat',array('read_status'=>1));
    return true;
}

    //insert transaction data
public function insertTransaction($data = array()){
    $insert = $this->db->insert('payments',$data);
    return $insert?true:false;
}

public function calendar_list_confirmed_view_count($id)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.username,t2.last_name,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_to',$id);
    $this->db->where('t1.approved',1);
    $this->db->where('t1.current_status',0);
    $this->db->where('t1.delete_sts',0);
    $this->db->join('applicants t2','t2.id=t1.invite_from','left');
    $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_from','left');
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}
public function calendar_list_confirmed_view($id,$limit,$current_page)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.username,t2.last_name,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_to',$id);
    $this->db->where('t1.approved',1);
    $this->db->where('t1.current_status',0);
    $this->db->where('t1.delete_sts',0);
    $this->db->join('applicants t2','t2.id=t1.invite_from','left');
    $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_from','left');
    $this->db->limit($limit,$current_page);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}

public function calendar_list_applicant_view($id)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.username,t2.last_name,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_to',$id);
    $this->db->where('t1.delete_sts',0);
    $this->db->where('t1.approved !=',2);
    $this->db->join('applicants t2','t2.id=t1.invite_from','left');
    $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_from','left');
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}

public function calendar_available_view($id)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.*,t4.picture_url,,t5.time_start,t5.time_end');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_to',$id);
    $this->db->where('t1.approved',1);
    $this->db->where('t1.current_status',0);
    $this->db->where('t1.delete_sts',0);
    $this->db->join('applicants t2','t2.id=t1.invite_from','left');
    $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_from','left');
    $this->db->join('appointment_schedule t5','t5.mentor_id=t1.invite_to','left');
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}

public function calendar_available_time($id)
{
    $this->db->select('*');
    $this->db->from('appointment_schedule');
    $this->db->where('mentor_id',$id);
    $query = $this->db->get();
    $result = $query->result_array();

    return $result;
}

public function more_details_view($invite_id,$id)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_id',$invite_id);
    $this->db->join('applicants t2','t2.id=t1.invite_from','left');
    $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_from','left');
    $query = $this->db->get();
    $result = $query->row_array();
    return $result;
}

public function calendar_list_pending_view($id,$limit,$current_page)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_to',$id);
    $this->db->where('t1.approved',0);
    $this->db->where('t1.current_status',0);
    $this->db->where('t1.delete_sts',0);
    $this->db->join('applicants t2','t2.id=t1.invite_from','left');
    $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_from','left');
    $this->db->limit($limit,$current_page);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}
public function calendar_list_pending_view_count($id)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_to',$id);
    $this->db->where('t1.approved',0);
    $this->db->where('t1.current_status',0);
    $this->db->where('t1.delete_sts',0);
    $this->db->join('applicants t2','t2.id=t1.invite_from','left');
    $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_from','left');
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}

public function get_today_conversation($id,$date)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_to',$id);
    $this->db->where('t1.approved !=',2);
    $this->db->where('t1.current_status',0);
    $this->db->where('t1.invite_date',$date);
    $this->db->join('applicants t2','t2.id=t1.invite_from','left');
    $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_from','left');
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}

public function get_conversation_data($id)
{
 $this->db->select('t1.*,t2.id as app_id,t2.call_status,t2.first_name,t2.last_name,t2.username,t2.profile_img,t2.logged_in,t3.*,t4.picture_url');
 $this->db->from('invite t1');
 $this->db->where('t1.invite_to',$id);        
 $this->db->where('t1.approved',1);
 $this->db->where('t1.current_status',0);
 $this->db->where('t1.read_status',0);
 $this->db->where('t1.delete_sts',0);        
 $this->db->join('applicants t2','t2.id=t1.invite_from','left');
 $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
 $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_from','left');
 $this->db->order_by('t1.from_date_time','asc');
 $query = $this->db->get();
 $result = $query->result_array();
 return $result;
}


Public function get_user_data()
{
    $id = $this->session->userdata('search_id');
    return $this->db->get_where('applicants',array('id' => $id))->row();
}

Public function get_user_det($id)
{

    return $this->db->get_where('applicants',array('id' => $id))->row();
}

Public function call_logs($mentor_id){
    $data=array();
    $applicant_id = $this->session->userdata('applicant_id');
    if(!empty($applicant_id)){

        if($this->session->userdata('type') == 'superadmin'){

            $sql = "SELECT * FROM `call_logs` WHERE (from_id = $mentor_id OR to_id = $mentor_id) ORDER BY log_id DESC";

        }else{
            $sql = "SELECT * FROM `call_logs` WHERE (from_id = $mentor_id AND to_id = $applicant_id) OR (from_id = $applicant_id AND to_id = $mentor_id)  ORDER BY log_id DESC";
        }
        $data = $this->db->query($sql)->result();
    }  
    
    return $data;
}

}
