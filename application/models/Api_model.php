<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model {	

	public function __construct()
	{
		parent::__construct();
		
	}


public function get_guru_available_data($id,$time_zone,$date)
{

	date_default_timezone_set($time_zone);
    $date = date('Y-m-d',strtotime($date));    
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t2.id',$id);
    $this->db->where('t1.invite_date',$date);        
    $this->db->where('t1.approved',1);
    $this->db->join('applicants t2','t2.id=t1.invite_to','left');
    $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_to','left');
 	return $this->db->get()->result_array();
    
}




	Public function get_available_times($user_id,$day_id){
		$where = array('mentor_id'=>$user_id,'days_id'=>$day_id);
		return $this->db
					->get_where('appointment_schedule',$where)
					->result_array();
	}


	/* Get mentor list */
	public function get_profile_data($user_id){

		$data = array();
		$sql = "SELECT applicants.mobile_number,applicants.role,me.graduate_college,me.under_major,me.under_college,me.mentor_gender as gender,me.dob,applicants.id as user_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,me.country,me.city,me.state,me.postal_code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,me.* FROM applicants
		LEFT JOIN mentor_details me ON me.mentor_id = applicants.id
		LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id        
		where applicants.id = $user_id";
		$data = $this->db->query($sql)->row_array();
		return $data;

	}




	/* Get mentor list */
	public function get_mentor_list(){
		$data = array();
		$sql = "SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,mentor_details.country as country_name,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
		LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
		LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id        
		where applicants.is_verified=1 and applicants.profile_updated=1 and applicants.role=1 ORDER BY applicants.id ASC LIMIT 0,5";
		$data = $this->db->query($sql)->result_array();
		return $data;

	}



	

	public function mentor_list_view($page_no,$per_page)
	{


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
			if($data['gender'] == 'male'){
				$gender = 1;
			}else{
				$gender = 2;

			}
			$sql .= " AND mentor_details.mentor_gender = '$gender' ";
		}


		// $where = array();

		// if(!empty($data['subject_id'])){
		// 	$where += array('subject_id'=>$data['subject_id']);  
		// }
		// if(!empty($data['course_id'])){
		// 	$where += array('course_id'=>$data['course_id']);  
		// }


		// if(!empty($where)){
		// 	$mentor_ids = $this->db->select('mentor_id')->get_where('mentor_course_details',$where)->result_array();  

		// 	if(!empty($mentor_ids)){
		// 		foreach($mentor_ids as $m){
		// 			$m_ids[]=$m['mentor_id'];
		// 		}
		// 	}
		// }



		 if(!empty($data['subject_id'])){
    // $where += array('subject_id'=>$_POST['subject_id']); 
    $where = "WHERE a.role = '1' AND  c.subject_id = ".$data['subject_id']; 
  }else{
      $where = "WHERE a.role = '1' "; 
  }

  if(!empty($data['course_id'])){
    // $where += array('course_id'=>$_POST['course_id']);  
    $where .= " AND c.course_id = ".$data['course_id'];
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
			$sql .= ' AND applicants.id IN ('.$m_ids.') ';      
		}else{
			if(!empty($data['subject_id']) || !empty($data['course_id'])){
				$sql .= ' AND applicants.id=27000 ';
			}else{
				$sql .= '';    
			}
		}





		/* Name Search */

		if(!empty($data['name'])){

			$user_name = $data['name'];
			$sql .=" AND (`applicants`.`first_name` LIKE '%$user_name%' ESCAPE '!' OR `applicants`.`last_name` LIKE '%$user_name%' ) ORDER BY applicants.first_name ";
		}



		/* SQL ENDS */

		if($page_no > 0){
			$page_limit= $per_page * ($page_no-1);
			$sql .=" LIMIT  $page_limit, $per_page";
		}else{
			$sql .=" LIMIT 0 , $per_page";
		}

	

		return  $this->db->query($sql)->result_array();

	}

	public function mentor_list_view_count()
	{
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
			if($data['gender'] == 'male'){
				$gender = 1;
			}else{
				$gender = 2;

			}
			$sql .= " AND mentor_details.mentor_gender = '$gender' ";
		}


		
		 if(!empty($data['subject_id'])){
    // $where += array('subject_id'=>$_POST['subject_id']); 
    $where = "WHERE a.role = '1' AND  c.subject_id = ".$data['subject_id']; 
  }else{
      $where = "WHERE a.role = '1' "; 
  }

  if(!empty($data['course_id'])){
    // $where += array('course_id'=>$_POST['course_id']);  
    $where .= " AND c.course_id = ".$data['course_id'];
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
			$sql .=" AND (`applicants`.`first_name` LIKE '%$user_name%' ESCAPE '!' OR `applicants`.`last_name` LIKE '%$user_name%' ) ORDER BY applicants.first_name ";
		}





		/* SQL ENDS */
		return $this->db->query($sql)->num_rows();;
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


	public function get_latest_chat_new($selected_user,$session_id,$page_no,$per_page)
	{


		$this->update_counts($selected_user,$session_id);
		$sql = "SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage,msg.recieved_id,msg.sent_id,msg.msg, msg.chatdate,social.picture_url as socialImage,msg.id,msg.type,msg.file_name,msg.file_path,time_zone,msg.id
			from chat msg  
			LEFT  join applicants sender on msg.sent_id = sender.id
			LEFT  join social_applicant_user social on social.reference_id = msg.sent_id
			left join chat_deleted_details cd on cd.chat_id  = msg.id
			where cd.can_view = $session_id AND ((msg.recieved_id = $selected_user AND msg.sent_id = $session_id) or  (msg.recieved_id = $session_id AND msg.sent_id =  $selected_user))   ORDER BY msg.id ASC ";

		if($page_no > 0){
			$page_limit= $per_page * ($page_no-1);
			$sql .=" LIMIT  $page_limit, $per_page";
		}else{
			$sql .=" LIMIT 0 , $per_page";
		}

		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;

	}
	public function get_latest_chat_counts($selected_user,$session_id)
	{		
		$sql = "SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage,msg.recieved_id,msg.sent_id,msg.msg, msg.chatdate,social.picture_url as socialImage,msg.id,msg.type,msg.file_name,msg.file_path,time_zone,msg.id
			from chat msg  
			LEFT  join applicants sender on msg.sent_id = sender.id
			LEFT  join social_applicant_user social on social.reference_id = msg.sent_id
			left join chat_deleted_details cd on cd.chat_id  = msg.id
			where cd.can_view = $session_id AND ((msg.recieved_id = $selected_user AND msg.sent_id = $session_id) or  (msg.recieved_id = $session_id AND msg.sent_id =  $selected_user))   ORDER BY msg.id ASC ";	

		return  $this->db->query($sql)->num_rows();				

	}

	Public function get_call_log_today($user_id,$page_no,$per_page){

		$date = date('Y-m-d');
       
        $sql ="SELECT t1.invite_id, t1.invite_date, t1.invite_time, ADDTIME(t1.invite_time, '01:00:00') AS invite_expire, t1.current_status, t2.id AS app_id, t2.first_name, t2.last_name, t2.username, t2.profile_img, t3.mentor_personal_message,(SELECT COUNT(rating)  FROM review_ratings  WHERE user_id= '$user_id') AS rating_count,
        (SELECT  ROUND(AVG(rating))  FROM review_ratings  WHERE user_id= '$user_id') AS rating_value
        ,t5.start_time,t5.end_time 
        FROM invite t1
        LEFT JOIN applicants t2 ON t2.id=t1.invite_from
        LEFT JOIN mentor_details t3 ON t3.mentor_id=t1.invite_from
        LEFT JOIN call_logs t5 ON t5.invite_id=t1.invite_id
        WHERE t1.invite_from = '$user_id' AND t1.delete_sts =0 AND t1.approved = 1 AND t1.invite_date = '$date' AND t5.start_time != '' AND t5.from_id = '$user_id'
       ORDER BY t5.log_id DESC "; 
    	

    	return $this->db->query($sql)->resul_array();
	}

	Public function get_call_log_today_count($user_id){

 		$date = date('Y-m-d');  
       $sql ="SELECT t1.invite_id, t1.invite_date, t1.invite_time, ADDTIME(t1.invite_time, '01:00:00') AS invite_expire, t1.current_status, t2.id AS app_id, t2.first_name, t2.last_name, t2.username, t2.profile_img, t3.mentor_personal_message,(SELECT COUNT(rating)  FROM review_ratings  WHERE user_id= '$user_id') AS rating_count,
        (SELECT  ROUND(AVG(rating))  FROM review_ratings  WHERE user_id= '$user_id') AS rating_value
        ,t5.start_time,t5.end_time 
        FROM invite t1
        LEFT JOIN applicants t2 ON t2.id=t1.invite_from
        LEFT JOIN mentor_details t3 ON t3.mentor_id=t1.invite_from
        LEFT JOIN call_logs t5 ON t5.invite_id=t1.invite_id
        WHERE t1.invite_from = '$user_id' AND t1.delete_sts =0 AND t1.approved = 1 AND t1.invite_date = '$date' AND t5.start_time != '' AND t5.from_id = '$user_id'
       ORDER BY t5.log_id DESC "; 


 

    	return $this->db->query($sql)->num_rows();
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
			$datas = json_decode( file_get_contents( 'php://input' ), true );
			if(empty($datas)){
				$datas = $this->input->post();
			}

			$id = $datas['user_id'];
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