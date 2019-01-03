<?php


if(!function_exists('send_button')){

   function decline_call($data){



    $one_signal_app_id = '868610fb-0809-4c8e-982e-647db54a8a50';    
    $one_signal_reset_key = 'ZmZmMmNhOWYtMjllZC00MjQ1LWJjMzEtYzdhMDI4NzgyNDg2';

    $message = $data['message'];
    $user_id = $data['user_id'];
    $include_player_ids = $data['include_player_ids'];
    $include_player_id =  array($include_player_ids);  

    $heading = array(
     "en" => $data['additional_data']['from_name']
 );


    $content = array("en" => "$message");                


    $fields = array(
        'app_id' => $one_signal_app_id,
        'data' => array('type'=>'decline'),                        
        'include_player_ids' => $include_player_id,
        'contents' => $content,
        'headings' => $heading                                      
    );

    if(empty($include_player_ids)){
        unset($fields['include_player_ids']);
    }      

    $fields = json_encode($fields);
         // print_r($fields); exit;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
        'Authorization: Basic '.$one_signal_reset_key));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
}



if(!function_exists('send_button')){

   function send_button($data){

    $one_signal_app_id = '868610fb-0809-4c8e-982e-647db54a8a50';    
    $one_signal_reset_key = 'ZmZmMmNhOWYtMjllZC00MjQ1LWJjMzEtYzdhMDI4NzgyNDg2';
    $message = $data['message'];
    $user_id = $data['user_id'];
    $include_player_ids = $data['include_player_ids'];
    $include_player_id =  array($include_player_ids);  

    $heading = array(
     "en" => $data['additional_data']['from_name']
 );


    $content = array("en" => "$message");    

    $fields = array(
        'app_id' => $one_signal_app_id,
        'data' => $data['additional_data'],                        
        'include_player_ids' => $include_player_id,
        'contents' => $content,
        'headings' => $heading,
        'buttons' => $data['button'],
        'action' => "like-button"
             // 'priority' => 10
             // 'included_segments' => array('Active Users')
    );

    if(empty($include_player_ids)){
        unset($fields['include_player_ids']);
    }      

    $fields = json_encode($fields);
         // print_r($fields); exit;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
        'Authorization: Basic '.$one_signal_reset_key));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
}
if(!function_exists('send_message')){

   function send_message($data){

    $one_signal_app_id = '868610fb-0809-4c8e-982e-647db54a8a50';    
    $one_signal_reset_key = 'ZmZmMmNhOWYtMjllZC00MjQ1LWJjMzEtYzdhMDI4NzgyNDg2';
    $message = $data['message'];
    $user_id = $data['user_id'];
    $include_player_ids = $data['include_player_ids'];
    $include_player_id =  array($include_player_ids);  

    $heading = array(
     "en" => $data['additional_data']['from_name']
 );


    $content = array("en" => "$message");       
    $fields = array(
        'app_id' => $one_signal_app_id,
        'data' => $data['additional_data'],                        
        'include_player_ids' => $include_player_id,
        'contents' => $content,
        'headings' => $heading
    );

    if(empty($include_player_ids)){
        unset($fields['include_player_ids']);
    }      

    $fields = json_encode($fields);
         // print_r($fields); exit;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
        'Authorization: Basic '.$one_signal_reset_key));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
}









function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
{
    $sets = array();
    if(strpos($available_sets, 'l') !== false)
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
    if(strpos($available_sets, 'u') !== false)
        $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
    if(strpos($available_sets, 'd') !== false)
        $sets[] = '23456789';
    if(strpos($available_sets, 's') !== false)
        $sets[] = '!@#$%&*?';

    $all = '';
    $password = '';
    foreach($sets as $set)
    {
        $password .= $set[array_rand(str_split($set))];
        $all .= $set;
    }

    $all = str_split($all);
    for($i = 0; $i < $length - count($sets); $i++)
        $password .= $all[array_rand($all)];

    $password = str_shuffle($password);

    if(!$add_dashes)
        return $password;

    $dash_len = floor(sqrt($length));
    $dash_str = '';
    while(strlen($password) > $dash_len)
    {
        $dash_str .= substr($password, 0, $dash_len) . '-';
        $password = substr($password, $dash_len);
    }
    $dash_str .= $password;
    return $dash_str;
}

function get_userdata()
{
    $ci = &get_instance();
    $ci->load->database();
    $id = $ci->session->userdata('applicant_id');
    $query = '';    
    $query = $ci->db->query("SELECT applicants.id as user_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.mobile_verified,applicants.role,mentor_details.country,mentor_details.*,s.picture_url FROM `applicants` 
        LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
        LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id        
        WHERE applicants.id =  '$id' ")->row_array();        
    
    return $query;    
}


function get_userdata_by_id($email)
{
    $ci = &get_instance();
    $ci->load->database();    
    $query = '';    
    $query = $ci->db->query("SELECT applicants.id as user_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.mobile_verified,applicants.role,mentor_details.country,mentor_details.*,s.picture_url FROM `applicants` 
        LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
        LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id        
        WHERE applicants.email =  '$email' ")->row_array();        
    
    return $query;    
}

function get_all_datas($id)
{
    $ci = &get_instance();
    $ci->load->database();    
    $query = '';
    if($ci->session->userdata('role') == 0){
        $query = $ci->db->query("SELECT applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,mentor_details.*,s.picture_url FROM `applicants` 
            LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
            LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
            LEFT JOIN country_list ON country_list.country_id = mentor_details.country
            WHERE applicants.id =  ".$id)->row_array();        
    }else{

       $query = $ci->db->query(" SELECT applicants.first_name,applicants.last_name ,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,applicants_profile.*,s.picture_url FROM  applicants
        LEFT JOIN `applicants_profile` ON applicants.id = applicants_profile.applicant_id
        LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
        LEFT JOIN country_list ON country_list.country_id = applicants_profile.country
        WHERE applicants.id = ".$id)->row_array();        

   }
   return $query;    
}

function getDay($day)
{
    $days = ['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7];

    $today = new \DateTime();
    $today->setISODate((int)$today->format('o'), (int)$today->format('W'), $days[ucfirst($day)]);
    return $today;
}
