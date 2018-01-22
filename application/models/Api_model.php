<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model {	

	public function __construct()
	{
		parent::__construct();
		
	}


	public function get_old_chat($selected_user,$session_id,$total)
{
    $per_page = 5;  

    $query = $this->db->query("SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage, sender.id as sender_id,msg.msg, msg.chatdate,social.picture_url as socialImage,msg.id,msg.type,msg.file_name,msg.file_path,time_zone,msg.id
    from chat msg  
    LEFT  join applicants sender on msg.sent_id = sender.id
    LEFT  join social_applicant_user social on social.reference_id = msg.sent_id
    left join chat_deleted_details cd on cd.chat_id  = msg.id
    where cd.can_view = $session_id AND ((msg.recieved_id = $selected_user AND msg.sent_id = $session_id) or  (msg.recieved_id = $session_id AND msg.sent_id =  $selected_user))   ORDER BY msg.id DESC LIMIT $total,$per_page  ");
   $result = $query->result_array();   
   return $result;
   
}




// 	public function get_latest_chat($selected_user,$session_id)
// 	{
  
//     $per_page = 5;   
//     $total =  $this->get_total_chat_count($selected_user,$session_id);
//     if($total>5){
//     $total = $total-5;    
//     }else{
//         $total = 0;
//     }  



//    $this->update_counts($selected_user,$session_id);

//    $query = $this->db->query("SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage, sender.id as sender_id,msg.msg, msg.chatdate,social.picture_url as socialImage,msg.id,msg.type,msg.file_name,msg.file_path,time_zone,msg.id
//     from chat msg  
//     LEFT  join applicants sender on msg.sent_id = sender.id
//     LEFT  join social_applicant_user social on social.reference_id = msg.sent_id
//     left join chat_deleted_details cd on cd.chat_id  = msg.id
//     where cd.can_view = $session_id AND ((msg.recieved_id = $selected_user AND msg.sent_id = $session_id) or  (msg.recieved_id = $session_id AND msg.sent_id =  $selected_user))   ORDER BY msg.id ASC LIMIT $total,$per_page ");
//    $result = $query->result_array();
//    return $result;
   
// }


	public function get_last_chat($selected_user,$session_id)
	{
  
    
   
   $query = $this->db->query("SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage,msg.recieved_id,msg.sent_id,msg.msg, msg.chatdate,social.picture_url as socialImage,msg.id,msg.type,msg.file_name,msg.file_path,time_zone,msg.id
    from chat msg  
    LEFT  join applicants sender on msg.sent_id = sender.id
    LEFT  join social_applicant_user social on social.reference_id = msg.sent_id
    left join chat_deleted_details cd on cd.chat_id  = msg.id
    where cd.can_view = $session_id AND ((msg.recieved_id = $selected_user AND msg.sent_id = $session_id) or  (msg.recieved_id = $session_id AND msg.sent_id =  $selected_user))   ORDER BY msg.id DESC");
   $result = $query->row_array();
   return $result;
   
}	


public function get_latest_chat($selected_user,$session_id)
	{
  
    
   $this->update_counts($selected_user,$session_id);
   $query = $this->db->query("SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage,msg.recieved_id,msg.sent_id,msg.msg, msg.chatdate,social.picture_url as socialImage,msg.id,msg.type,msg.file_name,msg.file_path,time_zone,msg.id
    from chat msg  
    LEFT  join applicants sender on msg.sent_id = sender.id
    LEFT  join social_applicant_user social on social.reference_id = msg.sent_id
    left join chat_deleted_details cd on cd.chat_id  = msg.id
    where cd.can_view = $session_id AND ((msg.recieved_id = $selected_user AND msg.sent_id = $session_id) or  (msg.recieved_id = $session_id AND msg.sent_id =  $selected_user))   ORDER BY msg.id ASC");
   $result = $query->result_array();
   return $result;
   
}


Public function get_total_chat_count($selected_user,$session_id)
{

    $sql = "SELECT msg.id  from chat msg     
     left join chat_deleted_details cd on cd.chat_id  = msg.id
    where  cd.can_view = $session_id AND ((msg.recieved_id = $selected_user AND msg.sent_id = $session_id) or  (msg.recieved_id = $session_id AND msg.sent_id =  $selected_user))   ORDER BY msg.id DESC ";

      return  $this->db->query($sql)->num_rows(); 
     
   
}

Public function update_counts($selected_user,$session_id)
{

    $query = $this->db->query("SELECT msg.id
    from chat msg  
    LEFT  join applicants sender on msg.sent_id = sender.id
    LEFT  join social_applicant_user social on social.reference_id = msg.sent_id
    where msg.delete_sts = 0 AND  msg.read_status = 0 AND (msg.recieved_id = $session_id AND msg.sent_id =  $selected_user) ");
    $result = $query->result_array();
  
    if(!empty($result)){
        foreach ($result as $d) {            
            $this->db->update('chat',array('read_status'=>1),array('id'=>$d['id']));
        }

    }else{
        return true;
    }
   
}



	Public function get_chat_list($id,$role){

		if($role == 0){
			$query = "SELECT t2.logged_in,t2.username,t3.picture_url,t2.id as user_id,t2.first_name,t2.last_name,t2.username,t2.profile_img FROM invite t1 LEFT JOIN applicants t2 on t2.id=t1.invite_to LEFT JOIN social_applicant_user t3 ON t3.reference_id = t2.id WHERE t1.invite_from=$id GROUp BY t1.invite_to";
		}elseif($role == 1){
			$query = "SELECT t2.logged_in,t1.invite_to,t3.picture_url,t2.id as user_id,t2.first_name,t2.last_name,t2.username,t2.profile_img FROM invite t1 LEFT JOIN applicants t2 on t2.id=t1.invite_from LEFT JOIN social_applicant_user t3 ON t3.reference_id = t2.id WHERE t1.invite_to=$id GROUp BY t1.invite_from";
		}
    	$query = $this->db->query($query);
    	$result = $query->result_array();
    	return $result;
}



	Public function get_user_data_by_id($user_id){

		$data = array();
		
		$table = 'applicants';
		$where = array('id'=>$id);
		$data  = $this->get_data_by_id($table,$where);
		if(!empty($data)){
				if($data['role'] == 0) {// Appilcant data 

					$query ="SELECT applicants.id as applicant_id,applicants.first_name,applicants.last_name ,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,applicants_profile.*,s.picture_url FROM  applicants
					LEFT JOIN `applicants_profile` ON applicants.id = applicants_profile.applicant_id
					LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
					LEFT JOIN country_list ON country_list.country_id = applicants_profile.country
					WHERE applicants.id = ".$id;


				}elseif($data['role'] == 1){

					$query ="SELECT applicants.id as applicant_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,mentor_details.*,s.picture_url FROM `applicants` 
					LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
					LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
					LEFT JOIN country_list ON country_list.country_id = mentor_details.country
					WHERE applicants.id =  ".$id;

				}
				$data = $this->db->query($query)->row_array();

			}
			return $data;








		}





	Public function get_user_data(){

		$data = array();

		$id = $_POST['user_id'];
		$table = 'applicants';
		$where = array('id'=>$id);
		$data  = $this->get_data_by_id($table,$where);
		if(!empty($data)){
				if($data['role'] == 0) {// Appilcant data 

					$query ="SELECT applicants.id as applicant_id,applicants.first_name,applicants.last_name ,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,applicants_profile.*,s.picture_url FROM  applicants
					LEFT JOIN `applicants_profile` ON applicants.id = applicants_profile.applicant_id
					LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
					LEFT JOIN country_list ON country_list.country_id = applicants_profile.country
					WHERE applicants.id = ".$id;


				}elseif($data['role'] == 1){

					$query ="SELECT applicants.id as applicant_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,mentor_details.*,s.picture_url FROM `applicants` 
					LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
					LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
					LEFT JOIN country_list ON country_list.country_id = mentor_details.country
					WHERE applicants.id =  ".$id;

				}
				$data = $this->db->query($query)->row_array();

			}
			return $data;








		}



	// Get Single data by id 
		Public function get_data_by_id($table,$where)
		{
			$data = array();
			if(!empty($table) && !empty($where)){

				$data = $this->db->get_where($table,$where)->row_array();	
			}
			return $data;

		}
	// Get all data by query
		Public function get_data_by_query($query)
		{
			$data = array();
			if(!empty($query)){

				$data = $this->db->query($table,$where)->result_array();	
			}
			return $data;

		}
	// Get all data 
		Public function get_data($table,$where)
		{
			$data = array();
			if(!empty($table) && !empty($where)){

				$data = $this->db->get_where($table,$where)->result_array();	
			}
			return $data;

		}

	}

	/* End of file  */
/* Location: ./application/models/ */