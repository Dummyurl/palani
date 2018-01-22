<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function get_userdata()
{
    $ci = &get_instance();
    $ci->load->database();
    $id = $ci->session->userdata('applicant_id');
    $query = '';
    if($ci->session->userdata('role') == 1){
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

// function get_booked_class($availabe_days,$start_time,$end_time,$day_value)
// {
 
//     $class = 'ttiming';
//     if(!empty($availabe_days))
//     {
      
//        foreach ($availabe_days as $key => $value) {
//            if($value['invite_time'] == $start_time && $value['invite_end_time'] == $end_time && $value['invite_date']==date('Y-m-d', strtotime("+$day_value day"))){
//             $class = 'ttiming notavailable';
//            }
//        }
//     }
//     return $class;
// }