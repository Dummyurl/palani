<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class Api extends REST_Controller {

    function __construct()
    {
     parent::__construct();     
     $this->load->model('api_model','api');
 }






 Public function video_call_post()
 {

    $empty = new stdClass();
    $result = new stdClass();

    if(empty($_POST['invite_id'])){

        $result->success = false;
        $result->code = 400;        
        $result->message = 'Invite id missing';        
        
    }
    elseif(empty($_POST['from_id'])){
        $result->success = false;
        $result->code = 400;        
        $result->message = 'From id missing';
        
    }else{


    $datas  = $this->db->get_where('invite',array('invite_id' => $_POST['invite_id']))->row_array();

    // echo '<pre>';
    // print_r($datas);
    // exit;

    if(!empty($datas)){

        if($datas['invite_from'] != $_POST['from_id']){

            $call_from = $datas['invite_from'];
            $call_to = $datas['invite_to'];


        }elseif($datas['invite_to'] != $_POST['from_id'])
            $call_from = $datas['invite_to'];
            $call_to = $datas['invite_from'];

        }

        $channel = $datas['channel'];
        $invite_id = $_POST['invite_id'];             
         $data = array(
            'call_from' =>$call_to,
            'call_to' =>$call_from,            
            'invite_id' =>$invite_id,
            'status' =>1,
            'start_by' =>$call_from,
            'channel' =>$channel
        );
        $this->db->insert('call_details',$data);

        // $user = $this->get_all_data($_POST['from_id']); // From user details 



        //      if($datas['invite_from'] == $_POST['from_id']){

        //     $call_from = $datas['invite_from'];
        //     $call_to = $datas['invite_to'];


        // }elseif($datas['invite_to'] == $_POST['from_id']){
        //     $call_from = $datas['invite_to'];
        //     $call_to = $datas['invite_from'];

        // }




        // $caller_name = $user->first_name.' '.$user->last_name;
        // $data['recieved_id'] =$call_to;
        // $data['sent_id'] = $call_from;
        // $data['msg'] = 'Call from '.$caller_name;
        // $data['from_name'] = $caller_name;
        // $data['type'] = 'video';    
        // $res = $this->send_push_notification($data);





        $result->success = true;
        $result->code = 200;        
         // $result->message = $res;
         $result->message = 'Call triggered';

    }
    $this->set_response($result, REST_Controller::HTTP_CREATED);

        
 }


Public function send_push_notification($datas){
    
    $this->load->model('chat_model','chat');
    $data = $this->chat->get_player_id($datas['recieved_id']);



    if(!empty($data)){
        
        $additional_data['from_name'] = $datas['from_name'];        
        $additional_data['from_user_id'] = $datas['sent_id'];
        $additional_data['to_user_id'] = $datas['recieved_id']; 
        $additional_data['from_username'] = $this->get_users_name($datas['sent_id']);                
        $additional_data['to_username'] = $this->get_users_name($datas['recieved_id']);              
        $additional_data['from_profile_image'] = $this->get_user_image($datas['sent_id']);              
        $additional_data['to_profile_image'] = $this->get_user_image($datas['recieved_id']);                
        $additional_data['type'] = $datas['type'];             

        $push_data['user_id'] = $datas['recieved_id'];
        $push_data['message'] = $datas['msg'];
        $push_data['include_player_ids'] = $data['device_id'];
        $push_data['additional_data'] = $additional_data;       
        return send_message($push_data);
            
    }

}



Public function get_user_image($id)
{
    $query = "SELECT app.profile_img,social.picture_url
    from  applicants app 
    LEFT join social_applicant_user social on social.reference_id = app.id where app.id = $id";

    $data =  $this->db->query($query)->row_array();

    if(!empty($data['profile_img']) && empty($data['picture_url'])){
        //$img = 'assets/images/'.$data['profile_img'];
        $img = $data['profile_img'];
    }else if(!empty($data['picture_url']) && empty($data['profile_img'])){
        $img = $data['picture_url'];
    }else{
        //$img ='assets/images/default-avatar.png';        
        $img ='default-avatar.png';        
    }
    //return base_url().$img;
    return $img;
    
}

Public function get_all_data($id)
{
    $query = "SELECT * from  applicants where id = $id";
    return  $this->db->query($query)->row();  
}
Public function get_users_name($id)
{
    $query = "SELECT username from  applicants where id = $id";
    return  $this->db->query($query)->row()->username;  
}
Public function get_full_name($id)
{
    $query = "SELECT CONCAT(first_name,' ',last_name) as full_name from  applicants where id = $id";
    return  $this->db->query($query)->row()->full_name;  
}




 public function login_post()
 {
    //error_reporting(1);
    $username = $this->post('email');
    $password = $this->post('password');
    $player_id = $this->post('player_id');
    $empty = new stdClass();
    $result = new stdClass();

    if(empty($player_id)){

        $result->success = false;
        $result->code = 400;
        $result->data = $empty;
        $result->message = 'Player id missing';
    }else{

       $query = $this->db->query("SELECT * FROM `applicants` WHERE `email` = '".$username."'  AND `password` = '".MD5($password)."' AND `delete_sts` = 0 ;")->row_array();

       if(!empty($query))
       {
        $this->db->update('applicants',array('logged_in'=>1),array('id'=>$query['id']));

        $player_data = $this->db->get_where('one_signal_device_details',array('user_id'=>$query['id']))->row();
        if(!empty($player_data)){
            $this->db->update('one_signal_device_details',array('device_id'=>$player_id),array('user_id'=>$query['id']));
        }else{
            $this->db->insert('one_signal_device_details',array('device_id'=>$player_id,'user_id'=>$query['id']));
        }

        $query = $this->db->query("SELECT id,first_name,last_name,username,email,role,type,mobile_number,logged_in FROM `applicants` WHERE `email` = '".$username."'  AND `password` = '".MD5($password)."' AND `delete_sts` = 0 ;")->row_array();
        $query['profile_img'] = $this->get_user_image($query['id']);       
        $result->success = true;
        $result->code = 200;
        $result->data = $query;
        $result->message = 'Loggedin Successfully';
    }else{
        $result->success = false;
        $result->code = 400;
        $result->data = $empty;
        $result->message = 'Invalid Username or Password';
    }

}
$this->set_response($result, REST_Controller::HTTP_CREATED);
}

public function conversation_list_today_post()
{
    $user_id = $this->post('user_id');
    $query = $this->db->query("SELECT * FROM `applicants` WHERE `id` = '".$user_id."'")->row_array();
    if(!empty($query))
    {
        if($query['role'] == 0){
            $this->db->select('t1.channel,t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.mentor_personal_message,COUNT(t4.rating) as rating_count,ROUND(AVG(t4.rating)) as rating_value');
            $this->db->from('invite t1');
            $this->db->where('t1.invite_from',$user_id);
            $this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
            $this->db->where('t1.approved',1);
            $this->db->where('t1.from_date_time >=',date('Y-m-d H:i:s'));
            $this->db->join('applicants t2','t2.id=t1.invite_to','left');
            $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
            $this->db->join('review_ratings t4','t4.user_id=t1.invite_to','left');
            $this->db->order_by('t1.from_date_time','asc');
            $this->db->group_by('t1.invite_id');
            $res = $this->db->get()->result_array();
            $day_result = $res;
        }
        if($query['role'] == 1){
            $this->db->select('t1.channel,t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img');
            $this->db->from('invite t1');
            $this->db->where('t1.invite_to',$user_id);
            $this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
            $this->db->where('t1.approved',1);
            $this->db->where('t1.from_date_time >=',date('Y-m-d H:i:s'));
            $this->db->join('applicants t2','t2.id=t1.invite_from','left');
            $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
            $this->db->order_by('t1.invite_id','desc');
            $res = $this->db->get()->result_array();

            $day_result = $res;
        }
        $resultSet = $day_result;

        $result = new stdClass();

        $result->success = true;
        $result->code = 200;
        $result->data = $resultSet;

        $this->set_response($result, REST_Controller::HTTP_CREATED);

    }else{
        $result = new stdClass();
        $result1 = new stdClass();
        $result->success = false;
        $result->code = 400;
        $result->data = $result1;
        $result->message = 'User does not exist';
        $this->set_response($result, REST_Controller::HTTP_CREATED);
    }

}

public function conversation_list_week_post()
{

    $monday = strtotime("today");
    $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
    $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
    $this_week_sd = date("Y-m-d",$monday);
    $this_week_ed = date("Y-m-d",$sunday);

    $dt = date("Y-m-d");
    $end = date( "Y-m-d", strtotime( "$dt +6 days" ) );

    $user_id = $this->post('user_id');
    $query = $this->db->query("SELECT * FROM `applicants` WHERE `id` = '".$user_id."'")->row_array();
    if(!empty($query))
    {
        if($query['role'] == 0){
            $this->db->select('t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.mentor_personal_message,COUNT(t4.rating) as rating_count,ROUND(AVG(t4.rating)) as rating_value');
            $this->db->from('invite t1');
            $this->db->where('t1.invite_from',$user_id);
            $this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
            $this->db->where('t1.approved',1);
            $this->db->where("t1.invite_date BETWEEN '$dt' AND '$end'");
            $this->db->join('applicants t2','t2.id=t1.invite_to','left');
            $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
            $this->db->join('review_ratings t4','t4.user_id=t1.invite_to','left');
            $this->db->order_by('t1.invite_id','desc');
            $this->db->group_by('t1.invite_id');
            $res = $this->db->get()->result_array();
            $week_result = $res;
        }
        if($query['role'] == 1){
            $this->db->select('t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img');
            $this->db->from('invite t1');
            $this->db->where('t1.invite_to',$user_id);
            $this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
            $this->db->where('t1.approved',1);
            $this->db->where("t1.invite_date BETWEEN '$dt' AND '$end'");
            $this->db->join('applicants t2','t2.id=t1.invite_from','left');
            $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
            $this->db->order_by('t1.invite_id','desc');
            $res = $this->db->get()->result_array();

            $week_result = $res;
        }
        $resultSet = $week_result;

        $result = new stdClass();

        $result->success = true;
        $result->code = 200;
        $result->data = $resultSet;

        $this->set_response($result, REST_Controller::HTTP_CREATED);

    }else{
        $result = new stdClass();
        $result1 = new stdClass();
        $result->success = false;
        $result->code = 400;
        $result->data = $result1;
        $result->message = 'User does not exist';
        $this->set_response($result, REST_Controller::HTTP_CREATED);
    }

}

public function conversation_list_month_post()
{
  $dt = date("Y-m-d");
  $end = date( "Y-m-d", strtotime( "$dt +30 days" ) );

  $user_id = $this->post('user_id');
  $query = $this->db->query("SELECT * FROM `applicants` WHERE `id` = '".$user_id."'")->row_array();
  if(!empty($query))
  {
    if($query['role'] == 0){
        $this->db->select('t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.mentor_personal_message,COUNT(t4.rating) as rating_count,ROUND(AVG(t4.rating)) as rating_value');
        $this->db->from('invite t1');
        $this->db->where('t1.invite_from',$user_id);
        $this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
        $this->db->where('t1.approved',1);
        $this->db->where("t1.invite_date BETWEEN '$dt' AND '$end'");
        $this->db->join('applicants t2','t2.id=t1.invite_to','left');
        $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
        $this->db->join('review_ratings t4','t4.user_id=t1.invite_to','left');
        $this->db->order_by('t1.invite_id','desc');
        $this->db->group_by('t1.invite_id');
        $res = $this->db->get()->result_array();
        $month_result = $res;
    }
    if($query['role'] == 1){
        $this->db->select('t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img');
        $this->db->from('invite t1');
        $this->db->where('t1.invite_to',$user_id);
        $this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
        $this->db->where('t1.approved',1);
        $this->db->where("t1.invite_date BETWEEN '$dt' AND '$end'");
        $this->db->join('applicants t2','t2.id=t1.invite_from','left');
        $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
        $this->db->order_by('t1.invite_id','desc');
        $res = $this->db->get()->result_array();

        $month_result = $res;
    }
    $resultSet = $month_result;

    $result = new stdClass();

    $result->success = true;
    $result->code = 200;
    $result->data = $resultSet;

    $this->set_response($result, REST_Controller::HTTP_CREATED);

}else{
    $result = new stdClass();
    $result1 = new stdClass();
    $result->success = false;
    $result->code = 400;
    $result->data = $result1;
    $result->message = 'User does not exist';
    $this->set_response($result, REST_Controller::HTTP_CREATED);
}

}

public function call_status_post()
{
    $data['status'] = $this->post('status');
    $data['invite_id'] = $this->post('invite_id');
    $st_time = $this->post('start_time');
    $end = $this->post('end_time');

    $start_seconds = $st_time / 1000;
    $end_seconds = $end / 1000;

//               $to_time = strtotime($st_time);
//               $from_time = strtotime($end);
//               $duration = round(abs($to_time - $from_time) / 60,2);

    $data['invite_date'] = date('Y-m-d',$start_seconds);
    $data['start_time'] = date("H:i:s", $start_seconds);
    $data['end_time'] = date("H:i:s", $end_seconds);

    if($this->db->insert('call_logs',$data)){
       $this->db->where('invite_id',$data['invite_id']);
       $this->db->update('invite',array('current_status'=>1));

   }
   $result = new stdClass();

   $result->success = true;
   $result->code = 200;

   $this->set_response($result, REST_Controller::HTTP_CREATED);

}

public function call_list_today_post()
{
    $user_id = $this->post('user_id');
    $query = $this->db->query("SELECT * FROM `applicants` WHERE `id` = '".$user_id."'")->row_array();
    if(!empty($query))
    {
        if($query['role'] == 0){
            $this->db->select('t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.mentor_personal_message,COUNT(t4.rating) as rating_count,ROUND(AVG(t4.rating)) as rating_value,IF(t5.start_time IS NULL," ",ROUND(UNIX_TIMESTAMP(t5.start_time) * 1000)) as start_time,IF(t5.end_time IS NULL," ",ROUND(UNIX_TIMESTAMP(t5.end_time) * 1000)) as end_time,IF(t5.end_time IS NULL," ",UNIX_TIMESTAMP(t5.end_time) - UNIX_TIMESTAMP(t5.start_time)) AS duration');
            $this->db->from('invite t1');
            $this->db->where('t1.invite_from',$user_id);
            $this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
            $this->db->where('t1.approved',1);
            $this->db->where('t1.invite_date',date('Y-m-d'));
            $this->db->join('applicants t2','t2.id=t1.invite_to','left');
            $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
            $this->db->join('review_ratings t4','t4.user_id=t1.invite_to','left');
            $this->db->join('call_logs t5','t5.invite_id=t1.invite_id','left');
            $this->db->order_by('t1.invite_id','desc');
            $this->db->group_by('t1.invite_id');
            $res = $this->db->get()->result_array();
            $day_result = $res;
        }
        if($query['role'] == 1){
            $this->db->select('t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,IF(t5.start_time IS NULL," ",ROUND(UNIX_TIMESTAMP(t5.start_time) * 1000)) as start_time,IF(t5.end_time IS NULL," ",ROUND(UNIX_TIMESTAMP(t5.end_time) * 1000)) as end_time,IF(t5.end_time IS NULL," ",UNIX_TIMESTAMP(t5.end_time) - UNIX_TIMESTAMP(t5.start_time)) AS duration');
            $this->db->from('invite t1');
            $this->db->where('t1.invite_to',$user_id);
            $this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
            $this->db->where('t1.approved',1);
            $this->db->where('t1.invite_date',date('Y-m-d'));
            $this->db->join('applicants t2','t2.id=t1.invite_from','left');
            $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
            $this->db->join('call_logs t5','t5.invite_id=t1.invite_id','left');
            $this->db->order_by('t1.invite_id','desc');
            $res = $this->db->get()->result_array();

            $day_result = $res;
        }
        $resultSet = $day_result;
        
        $result = new stdClass();

        $result->success = true;
        $result->code = 200;
        $result->data = $resultSet;

        $this->set_response($result, REST_Controller::HTTP_CREATED);
        
    }else{
        $result = new stdClass();
        $result1 = new stdClass();
        $result->success = false;
        $result->code = 400;
        $result->data = $result1;
        $result->message = 'User does not exist';
        $this->set_response($result, REST_Controller::HTTP_CREATED);
    }

}

public function call_list_week_post()
{

    $monday = strtotime("today");
    $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
    $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
    $this_week_sd = date("Y-m-d",$monday);
    $this_week_ed = date("Y-m-d",$sunday);

    $dt = date("Y-m-d");
    $end = date( "Y-m-d", strtotime('-6 days', strtotime($dt)) );

    $user_id = $this->post('user_id');
    $query = $this->db->query("SELECT * FROM `applicants` WHERE `id` = '".$user_id."'")->row_array();
    if(!empty($query))
    {
        if($query['role'] == 0){
            $this->db->select('t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.mentor_personal_message,COUNT(t4.rating) as rating_count,ROUND(AVG(t4.rating)) as rating_value,IF(t5.start_time IS NULL," ",ROUND(UNIX_TIMESTAMP(t5.start_time) * 1000)) as start_time,IF(t5.end_time IS NULL," ",ROUND(UNIX_TIMESTAMP(t5.end_time) * 1000)) as end_time,IF(t5.end_time IS NULL," ",UNIX_TIMESTAMP(t5.end_time) - UNIX_TIMESTAMP(t5.start_time)) AS duration');
            $this->db->from('invite t1');
            $this->db->where('t1.invite_from',$user_id);
            $this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
            $this->db->where('t1.approved',1);
            $this->db->where("t1.invite_date BETWEEN '$end' AND '$dt'");
            $this->db->join('applicants t2','t2.id=t1.invite_to','left');
            $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
            $this->db->join('review_ratings t4','t4.user_id=t1.invite_to','left');
            $this->db->join('call_logs t5','t5.invite_id=t1.invite_id','left');
            $this->db->order_by('t1.invite_id','desc');
            $this->db->group_by('t1.invite_id');
            $res = $this->db->get()->result_array();
            $week_result = $res;
        }
        if($query['role'] == 1){
            $this->db->select('t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,IF(t5.start_time IS NULL," ",ROUND(UNIX_TIMESTAMP(t5.start_time) * 1000)) as start_time,IF(t5.end_time IS NULL," ",ROUND(UNIX_TIMESTAMP(t5.end_time) * 1000)) as end_time,IF(t5.end_time IS NULL," ",UNIX_TIMESTAMP(t5.end_time) - UNIX_TIMESTAMP(t5.start_time)) AS duration');
            $this->db->from('invite t1');
            $this->db->where('t1.invite_to',$user_id);
            $this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
            $this->db->where('t1.approved',1);
            $this->db->where("t1.invite_date BETWEEN '$end' AND '$dt'");
            $this->db->join('applicants t2','t2.id=t1.invite_from','left');
            $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
            $this->db->join('call_logs t5','t5.invite_id=t1.invite_id','left');
            $this->db->order_by('t1.invite_id','desc');
            $res = $this->db->get()->result_array();

            $week_result = $res;
        }
        $resultSet = $week_result;
        
        $result = new stdClass();

        $result->success = true;
        $result->code = 200;
        $result->data = $resultSet;

        $this->set_response($result, REST_Controller::HTTP_CREATED);
        
    }else{
        $result = new stdClass();
        $result1 = new stdClass();
        $result->success = false;
        $result->code = 400;
        $result->data = $result1;
        $result->message = 'User does not exist';
        $this->set_response($result, REST_Controller::HTTP_CREATED);
    }

}

public function call_list_month_post()
{
  $dt = date("Y-m-d");
  $end = date("Y-m-d", strtotime('-30 days', strtotime($dt)));
		//echo $end.'===='.$dt; exit;
  $user_id = $this->post('user_id');
  $query = $this->db->query("SELECT * FROM `applicants` WHERE `id` = '".$user_id."'")->row_array();
  if(!empty($query))
  {
    if($query['role'] == 0){
        $this->db->select('t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.mentor_personal_message,COUNT(t4.rating) as rating_count,ROUND(AVG(t4.rating)) as rating_value,IF(t5.start_time IS NULL," ",ROUND(UNIX_TIMESTAMP(t5.start_time) * 1000)) as start_time,IF(t5.end_time IS NULL," ",ROUND(UNIX_TIMESTAMP(t5.end_time) * 1000)) as end_time,IF(t5.end_time IS NULL," ",UNIX_TIMESTAMP(t5.end_time) - UNIX_TIMESTAMP(t5.start_time)) AS duration');
        $this->db->from('invite t1');
        $this->db->where('t1.invite_from',$user_id);
        $this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
        $this->db->where('t1.approved',1);
        $this->db->where("t1.invite_date BETWEEN '$end' AND '$dt'");
        $this->db->join('applicants t2','t2.id=t1.invite_to','left');
        $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
        $this->db->join('review_ratings t4','t4.user_id=t1.invite_to','left');
        $this->db->join('call_logs t5','t5.invite_id=t1.invite_id','left');
        $this->db->order_by('t1.invite_id','desc');
        $this->db->group_by('t1.invite_id');
        $res = $this->db->get()->result_array();
        $month_result = $res;
    }
    if($query['role'] == 1){
        $this->db->select('t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,IF(t5.start_time IS NULL," ",ROUND(UNIX_TIMESTAMP(t5.start_time) * 1000)) as start_time,IF(t5.end_time IS NULL," ",ROUND(UNIX_TIMESTAMP(t5.end_time) * 1000)) as end_time,IF(t5.end_time IS NULL," ",UNIX_TIMESTAMP(t5.end_time) - UNIX_TIMESTAMP(t5.start_time)) AS duration');
        $this->db->from('invite t1');
        $this->db->where('t1.invite_to',$user_id);
        $this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
        $this->db->where('t1.approved',1);
        $this->db->where("t1.invite_date BETWEEN '$end' AND '$dt'");
        $this->db->join('applicants t2','t2.id=t1.invite_from','left');
        $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
        $this->db->join('call_logs t5','t5.invite_id=t1.invite_id','left');
        $this->db->order_by('t1.invite_id','desc');
        $res = $this->db->get()->result_array();

        $month_result = $res;
    }
    $resultSet = $month_result;

    $result = new stdClass();

    $result->success = true;
    $result->code = 200;
    $result->data = $resultSet;

    $this->set_response($result, REST_Controller::HTTP_CREATED);

}else{
    $result = new stdClass();
    $result1 = new stdClass();
    $result->success = false;
    $result->code = 400;
    $result->data = $result1;
    $result->message = 'User does not exist';
    $this->set_response($result, REST_Controller::HTTP_CREATED);
}

}

public function push_notify_post()
{
  $target = $this->post('reg_id');
  $data = array('body' 	=> 'You have a call with Guru',
     'title'	=> 'Time for Call',
     'icon'	=> 'myicon',/*Default Icon*/
     'sound' => 'mySound'/*Default sound*/
 );
  $return = $this->sendFCMMessage($data,$target);	

  $result = new stdClass();
  $result->success = $return;
  $result->code = 200;		
  $this->set_response($result, REST_Controller::HTTP_CREATED);		
}


	/* Example Parameter $data = array('from'=>'Lhe.io','title'=>'FCM Push Notifications');
	$target = 'single token id or topic name';
	or
	$target = array('token1','token2','...'); // up to 1000 in one request for group sending
	*/
	public function sendFCMMessage($data,$target){
		ob_start();
	   //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
	   //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AAAA83YswzY:APA91bFUoWdqC_AEyNvhhiIv1Zy4y9toz-HabJc5N05LTJ6iggVoBqccpT3fMdvogHsrfLHeyoNlrU-xgGpzHEh518YWZTY4rBYKipAPxMxY2hNa3Ic7nlFc5dVtKB3AJDnzPk2vUjKG';

        $fields = array();
        $fields['data'] = $data;
        if(is_array($target)){
          $fields['registration_ids'] = $target;
      }else{
          $fields['to'] = $target;
      }
	   //header with content_type api key
      $headers = array(
          'Content-Type:application/json',
          'Authorization:key='.$server_key
      );
	   //CURL request to route notification to FCM connection server (provided by Google)			
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
      $result = curl_exec($ch);
      if ($result === FALSE) {
          die('Oops! FCM Send Error: ' . curl_error($ch));
      }
      curl_close($ch);
      ob_end_flush();
      return $result;
  }




/*
*
* Date : 21-12-2017 
*Author : Boominathan
*
*/

 // Getting users for chat 

Public function users_post(){
    $user_data = $this->validate_user();

    if(!empty($user_data)){

        $id = $_POST['user_id'];
        $data = $this->api->get_chat_list($id,$user_data['role']);
        if(!empty($data)){            

            foreach($data as $d){

                if(!empty($d['profile_img']) && empty($d['picture_url'])){
                    $img = base_url() . 'assets/images/'.$d['profile_img'];                    

                }else if (!empty($d['profile_img']) && !empty($d['picture_url'])){
                    $img = base_url() . 'assets/images/'.$d['profile_img'];

                }else if (empty($d['profile_img']) && !empty($d['picture_url'])){
                    $img = base_url() . 'assets/images/'.$d['picture_url'];                    
                }else{
                    $img = base_url() . 'assets/images/default-avatar.png';
                }
                $response['logged_in'] = $d['logged_in'];
                $response['sinch_username'] = $d['username'];
                $response['profile_pic'] = $img;
                $response['user_id'] = $d['user_id'];
                $response['name'] = $d['first_name'].' '.$d['last_name'];
                $datas[]=$response;
            }
            $this->set_response($datas, REST_Controller::HTTP_OK);     
        }else{

         $this->response([
            'status' => FALSE,
            'message' => 'No users!'
        ], REST_Controller::HTTP_NOT_FOUND);

     }

 }


}


Public function conversations_post()
{


   $user_data = $this->validate_user();


   if(!empty($_POST['selected_user_id'])){
    if(empty($_POST['time_zone'])){
     $this->response([
        'status' => FALSE,
        'message' => 'time zone missing!'
    ], REST_Controller::HTTP_NOT_FOUND);
 }

 $session_id = $user_data['applicant_id'];
 $selected_user = $_POST['selected_user_id'];
 $time_zone = $_POST['time_zone'];
 $latest_chat= $this->api->get_latest_chat($selected_user,$session_id);     

 if(!empty($latest_chat)){
    foreach($latest_chat as $key => $currentuser) : 

        $from_timezone = $currentuser['time_zone'];
        $date_time = $currentuser['chatdate'];
        $date_time  = $this->converToTz($date_time,$time_zone,$from_timezone);

        $response['chat_time'] = date('Y-m-d H:i:s',strtotime($date_time));
        $type = $currentuser['type'];        
        $attachment_file = ($currentuser['file_path'])?($currentuser['file_path'].'/'.$currentuser['file_name']):'';        
        $message = $currentuser['msg'];                
        $response['chat_from']= $currentuser['sent_id'];  
        $response['chat_to']= $currentuser['recieved_id'];          
        $response['from_user_name']= $this->get_user_name($currentuser['sent_id']);  
        $response['to_user_name']= $this->get_user_name($currentuser['recieved_id']);  
        $response['profile_from_image']= $this->get_user_image($currentuser['sent_id']);  
        $response['profile_to_image']= $this->get_user_image($currentuser['recieved_id']);  

        if($message!='file' || $message!='ENABLE_STREAM' || $message!='DISABLE_STREAM'){
            $response['content']= ($message)?$message:''; 
            $datas[]=$response;    
        }
        
    endforeach;
    $json['messages'] = $datas;
    $this->set_response($json, REST_Controller::HTTP_OK);  


}else{
 $this->response([
    'status' => FALSE,
    'message' => 'No messages!'
], REST_Controller::HTTP_NOT_FOUND);
}



}else{
 $this->response([
    'status' => FALSE,
    'message' => 'Selected user id missing!'
], REST_Controller::HTTP_NOT_FOUND);

} 


}

Public function get_user_name($id){
    $where = array('id'=>$id);
    $data =  $this->db->get_where('applicants',$where)->row_array();
    if(!empty($data)){
        return $name = $data['first_name'].' '.$data['last_name'];
    }
}









// Read old Conversation 

// Public function old_conversations_post()
// {


//  $user_data = $this->validate_user();

//  if(!empty($_POST['selected_user_id'])){

//     if(empty($_POST['page_no'])){
//         $total = 0;
//     }else{
//         $total = $_POST['page_no'];
//     }

//     if(empty($_POST['time_zone'])){
//        $this->response([
//         'status' => FALSE,
//         'message' => 'time zone missing!'
//     ], REST_Controller::HTTP_NOT_FOUND);
//    }


//    $total = $total * 5;

//    $session_id = $user_data['id'];
//    $selected_user = $_POST['selected_user_id'];
//    $time_zone = $_POST['time_zone'];
//    $latest_chat= $this->api->get_old_chat($selected_user,$session_id,$total);   




//    if(!empty($latest_chat)){
//     foreach($latest_chat as $key => $currentuser) : 

//         $response['class_name'] =($currentuser['sender_id'] != $session_id) ? 'chat-left' : '';
//         $response['user_image'] = ($currentuser['senderImage']!= '') ? base_url().'assets/images/'.$currentuser['senderImage']: base_url().'assets/images/default-avatar.png';

//         if(!empty($user_data['senderImage']) && empty($user_data['socialImage'])){
//             $img = base_url() . 'assets/images/'.$d['profile_img'];                    

//         }else if (!empty($user_data['senderImage']) && !empty($user_data['socialImage'])){
//             $img = base_url() . 'assets/images/'.$d['profile_img'];

//         }else if (empty($user_data['senderImage']) && !empty($user_data['socialImage'])){
//             $img = base_url() . 'assets/images/'.$d['picture_url'];                    
//         }else{
//             $img = base_url() . 'assets/images/default-avatar.png';
//         }


//         $from_timezone = $currentuser['time_zone'];
//         $date_time = $currentuser['chatdate'];
//         $date_time  = $this->converToTz($date_time,$time_zone,$from_timezone);
//         $response['time'] = date('h:i a',strtotime($date_time));
//         $type = $currentuser['type'];        
//         $attachment_file = ($currentuser['file_path'])?($currentuser['file_path'].'/'.$currentuser['file_name']):'';        
//         $message = $currentuser['msg'];
//         $response['type']  =  ($type)?$type:'normal';          
//         $response['attachment_file']= ($attachment_file)?base_url().$attachment_file:'';
//         $response['message']= ($message)?$message:'';  
//         $response['sender_profile_pic']= $img;  

//         $datas[]=$response;
//     endforeach;
//     $json['messages'] = $datas;
//     // $json['page'] = ($page)?$page:0;
//     $this->set_response($json, REST_Controller::HTTP_OK);  


// }else{
//    $this->response([
//     'status' => FALSE,
//     'message' => 'No messages!'
// ], REST_Controller::HTTP_NOT_FOUND);
// }



// }else{
//    $this->response([
//     'status' => FALSE,
//     'message' => 'Selected user id missing!'
// ], REST_Controller::HTTP_NOT_FOUND);

// } 


// }


// Read Converations 
// Public function conversations_post()
// {


//  $user_data = $this->validate_user();


//  if(!empty($_POST['selected_user_id'])){
//     if(empty($_POST['time_zone'])){
//        $this->response([
//         'status' => FALSE,
//         'message' => 'time zone missing!'
//     ], REST_Controller::HTTP_NOT_FOUND);
//    }

//    $session_id = $user_data['applicant_id'];
//    $selected_user = $_POST['selected_user_id'];
//    $time_zone = $_POST['time_zone'];
//    $latest_chat= $this->api->get_latest_chat($selected_user,$session_id);  
//    $total_chat= $this->api->get_total_chat_count($selected_user,$session_id); 

//    $page =0;
//    if($total_chat>5){
//     $total_chat = $total_chat - 5;
//     $page = $total_chat / 5;
//     $page = ceil($page);
//     $page--;
// }


// if(!empty($latest_chat)){
//     foreach($latest_chat as $key => $currentuser) : 

//         $response['class_name'] =($currentuser['sender_id'] != $session_id) ? 'chat-left' : '';
//         $response['user_image'] = ($currentuser['senderImage']!= '') ? base_url().'assets/images/'.$currentuser['senderImage']: base_url().'assets/images/default-avatar.png';

//         if(!empty($user_data['senderImage']) && empty($user_data['socialImage'])){
//             $img = base_url() . 'assets/images/'.$d['profile_img'];                    

//         }else if (!empty($user_data['senderImage']) && !empty($user_data['socialImage'])){
//             $img = base_url() . 'assets/images/'.$d['profile_img'];

//         }else if (empty($user_data['senderImage']) && !empty($user_data['socialImage'])){
//             $img = base_url() . 'assets/images/'.$d['picture_url'];                    
//         }else{
//             $img = base_url() . 'assets/images/default-avatar.png';
//         }


//         $from_timezone = $currentuser['time_zone'];
//         $date_time = $currentuser['chatdate'];
//         $date_time  = $this->converToTz($date_time,$time_zone,$from_timezone);
//         $response['time'] = date('h:i a',strtotime($date_time));
//         $type = $currentuser['type'];        
//         $attachment_file = ($currentuser['file_path'])?($currentuser['file_path'].'/'.$currentuser['file_name']):'';        
//         $message = $currentuser['msg'];
//         $response['type']  =  ($type)?$type:'normal';          
//         $response['attachment_file']= ($attachment_file)?base_url().$attachment_file:'';
//         $response['message']= ($message)?$message:'';  
//         $response['sender_profile_pic']= $img;  

//         $datas[]=$response;
//     endforeach;
//     $json['messages'] = $datas;
//     $json['no_of_pages'] = ($page)?$page:0;
//     $this->set_response($json, REST_Controller::HTTP_OK);  


// }else{
//    $this->response([
//     'status' => FALSE,
//     'message' => 'No messages!'
// ], REST_Controller::HTTP_NOT_FOUND);
// }



// }else{
//    $this->response([
//     'status' => FALSE,
//     'message' => 'Selected user id missing!'
// ], REST_Controller::HTTP_NOT_FOUND);

// } 


// }

// Send Message 

Public function send_message_post()
{
 $user_data = $this->validate_user();

 if(!empty($_POST['selected_user_id'])){    
     if(empty($_POST['time_zone'])){
         $this->response([
            'status' => FALSE,
            'message' => 'time zone missing!'
        ], REST_Controller::HTTP_NOT_FOUND);

     } 
     if(empty($_POST['message'])){
         $this->response([
            'status' => FALSE,
            'message' => 'Message missing!'
        ], REST_Controller::HTTP_NOT_FOUND);

     }

 //if(empty($_FILES['upload_file'])){
     $this->normal_message($user_data);    
// }elseif(!empty($_FILES['upload_file'])){
//     $this->upload_file_message($user_data);
// }
     $time_zone = $_POST['time_zone'];
     $last_chat= $this->api->get_last_chat($_POST['selected_user_id'],$user_data['applicant_id']); 

     $from_timezone = $last_chat['time_zone'];
     $date_time = $last_chat['chatdate'];
     $date_time  = $this->converToTz($date_time,$time_zone,$from_timezone);

     $response['chat_time'] = date('Y-m-d H:i:s',strtotime($date_time));       

     $message = $last_chat['msg'];        
     $response['content']= ($message)?$message:'';          
     $response['chat_from']= $last_chat['sent_id'];  
     $response['chat_to']= $last_chat['recieved_id'];          
     $response['from_user_name']= $this->get_user_name($last_chat['sent_id']);  
     $response['to_user_name']= $this->get_user_name($last_chat['recieved_id']);  
     $response['profile_from_image']= $this->get_user_image($last_chat['sent_id']);  
     $response['profile_to_image']= $this->get_user_image($last_chat['recieved_id']); 
     $this->set_response($response, REST_Controller::HTTP_OK); 






 }else{

     $this->response([
        'status' => FALSE,
        'message' => 'Selected user id missing!'
    ], REST_Controller::HTTP_NOT_FOUND);

 }
}


Public function upload_file_message($user_data){


    $user_id = $user_data['applicant_id'];       
    $data['sent_id'] =  $user_data['applicant_id'];
    $data['recieved_id']= $_POST['selected_user_id'];
    $data['time_zone'] =  $_POST['time_zone'];
    $data['chatdate'] = date('Y-m-d H:i:s',strtotime($_POST['date_time']));


    $path = "msg_uploads/".$user_id;
    if(!is_dir($path)){
        mkdir($path);
    }

    $target_file =$path . basename($_FILES["upload_file"]["name"]);
    $file_type = pathinfo($target_file,PATHINFO_EXTENSION);

    if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif" ){
        $type = 'others';
    }else{
        $type = 'image';
    }


    $config['upload_path']   = './'.$path;
    $config['allowed_types'] = '*';     
    $this->load->library('upload',$config);

    if($this->upload->do_upload('upload_file')){           


        $file_name=$this->upload->data('file_name');        
        $datas = array(
            'recieved_id' =>$data['recieved_id'],
            'sent_id' =>  $data['sent_id'],
            'msg' =>'file',
            'file_name'=>$file_name,        
            'chatdate' => $data['chatdate'],
            'type' =>$type,                
            'time_zone' =>$data['time_zone'],
            'file_path' => $path                
        );          

        $result = $this->db->insert('chat',$datas);
        $chat_id = $this->db->insert_id();
        $users = array($data['recieved_id'],$data['sent_id']);
        for ($i=0; $i <2 ; $i++) { 
            $dat = array('chat_id' =>$chat_id ,'can_view'=>$users[$i]);
            $this->db->insert('chat_deleted_details',$dat);
        }


        $response = array('img'=>base_url().$path.'/'.$file_name,'type'=>$type ,'message'=>'File uploaded successfully!');
        $this->set_response($response, REST_Controller::HTTP_OK);


    }else{
       $this->response([
        'status' => FALSE,
        'message' => $this->upload->display_errors()
    ], REST_Controller::HTTP_NOT_FOUND);            
   }


}


Public function normal_message($user_data){

    $time_zone = $_POST['time_zone'];
    $from_timezone = date_default_timezone_get();
    $date_time = date('Y-m-d H:i:s');
    $date_time  = $this->converToTz($date_time,$time_zone,$from_timezone);
    $data['sent_id'] =  $user_data['applicant_id'];
    $data['recieved_id']= $_POST['selected_user_id'];
    $data['time_zone'] =  $_POST['time_zone'];
    $data['chatdate'] = $date_time;
    $data['msg'] = $_POST['message'];

    

    if($_POST['message']=='ENABLE_STREAM' || $_POST['message'] =='DISABLE_STREAM'){ // Video stram messages neglected

         $this->set_response([
        'status' => TRUE,
        'message' => 'Message saved successfully!'
    ], REST_Controller::HTTP_OK);  

     }else{

    $result = $this->db->insert('chat',$data);        
    $chat_id = $this->db->insert_id();
    $users = array($data['recieved_id'],$data['sent_id']);
        for ($i=0; $i <2 ; $i++) { 
        $datas = array('chat_id' =>$chat_id ,'can_view'=>$users[$i]);
        $this->db->insert('chat_deleted_details',$datas);
        }
    

    $this->set_response([
        'status' => TRUE,
        'message' => 'Message saved successfully!'
    ], REST_Controller::HTTP_OK);  
    }
}

Public  function converToTz($time="",$toTz='',$fromTz='')
{           
   $date = new DateTime($time, new DateTimeZone($fromTz));
   $date->setTimezone(new DateTimeZone($toTz));
   $time= $date->format('Y-m-d H:i:s');
   return $time;

}


    // Vaidating the user 
Public function validate_user()
{
    if(!empty($_POST['user_id'])){        
        $user = $this->api->get_user_data();
        if(!empty($user)){                        
            return $user;
            //$this->set_response($user, REST_Controller::HTTP_OK); 

        }else{                        
            $this->response([
                'status' => FALSE,
                'message' => 'User id not valid!'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }else{

        $this->response([
            'status' => FALSE,
            'message' => 'User id missing!'
        ], REST_Controller::HTTP_NOT_FOUND);
        
    }

}




}
