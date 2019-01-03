<?php
class Applicant_modal extends CI_Model
{

    Public function get_payment_by_id()
    {
        $payment_id = base64_decode($this->uri->segment(3));
        //$payment_date = base64_decode($this->uri->segment(4));


        $sql = "SELECT a.*,i.*,p.per_hour_charge,i.tax_percentage,i.tax_amount,p.payment_date,p.payment_id,p.invoice_no,p.payment_status,payment_gross as earned,a.delete_sts, a.username as guru_user_name,a.profile_img ,CONCAT(a.first_name,' ',a.last_name) AS guru_name,s.picture_url FROM applicants a 
        LEFT JOIN payments p ON a.id = p.mentor_id 
        LEFT JOIN invite i ON i.invite_id = p.invite_id         
        LEFT JOIN social_applicant_user s ON s.reference_id = p.mentor_id WHERE payment_id = '$payment_id'";
        return $this->db->query($sql)->row_array();
    }


  Public function get_total_earned()
{
    $where = array('user_id'=>$this->session->userdata('applicant_id'),'payment_status'=>1,'transaction_type'=>'CREDIT','role_type'=>'mentee');
    return $this->db->select('SUM(payment_gross) as earned_amount')->get_where('payments',$where)->row_array();
    
}

    // Applicant Account

    private function _get_datatables_query_a()
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

        $sql ="SELECT a.id,p.payment_date,p.mentor_id,p.payment_id,p.invoice_no,p.remarks,p.payment_status,p.payment_gross,p.handling_charge,p.transaction_type,a.delete_sts, a.username as applicant_user_name,a.profile_img as applicant_profile_img,CONCAT(a.first_name,' ',a.last_name) AS applicant_name,s.picture_url as applicant_picture,i.invite_id,i.approved,i.invite_date,i.invite_time,i.invite_end_time,i.time_zone
        FROM applicants a
        LEFT JOIN payments p ON a.id = p.mentor_id
        LEFT JOIN invite i ON i.invite_id = p.invite_id
        LEFT JOIN social_applicant_user s ON s.reference_id = p.mentor_id WHERE a.role = '1' AND p.user_id = '$user_id' AND p.payment_status = '1' AND p.transaction_type = 'CREDIT' AND p.role_type = 'mentee'";


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

 //$sql .=" GROUP BY i.invite_id ";

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
function get_datatables_a()
{
    $sql = $this->_get_datatables_query_a();
    if($_POST['length'] != -1)
        $limits = $_POST['start'].','.$_POST['length'];
    $sql .=" LIMIT $limits";
    return $this->db->query($sql)->result();
}

function count_filtered_a()
{
    $sql = $this->_get_datatables_query_a();
    return $this->db->query($sql)->num_rows();
}
public function count_all_a()
{
    $sql = $this->_get_datatables_query_a();
    return $this->db->query($sql)->num_rows();
}








public function check_applicant_login($params)
{
    $sts = 1;
    $query = $this->db->query("SELECT * FROM applicants WHERE email = '".$params['email']."'  AND password = '".MD5($params['password'])."' AND delete_sts = 0 ;")->row_array();
        //echo $this->db->last_query();
    if(sizeof($query)>0)
    {
        $this->session->set_userdata(array('applicant_id'=>$query['id'],'role'=>$query['role'],'type'=>$query['type'],'first_name' => $query['first_name'],'last_name' => $query['last_name']));
        $applicant_id     = $this->session->userdata('applicant_id');
        $this->db->update('applicants',array('logged_in'=>1,'logged_by'=>'web'),array('id'=>$applicant_id ));
        $sts = 0;


         /* Blog Login */
        if($query['type'] == 'guru'){
            
            $this->load->library('bcrypt');        

        $result = $this->db->get_where('users',array('email'=>$params['email']))->row_array();
        if(!empty($result)){

             //set user data
          $user_data = array(
              'inf_ses_id' =>$result['id'],
              'inf_ses_username' => $query['first_name'].' '.$query['last_name'],
              'inf_ses_email' => $result['email'],
              'inf_ses_role' => 'author',
              'inf_ses_logged_in' => true,
              'inf_ses_app_key' => $this->config->item('app_key'),
          );
          $this->session->set_userdata($user_data);


      }else{


          $blog_data = array(
              'username' => $query['first_name'].' '.$query['last_name'], 
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
      }else if($query['type'] == 'user'){
            
            $this->load->library('bcrypt');        

        $result = $this->db->get_where('users',array('email'=>$params['email']))->row_array();
        if(!empty($result)){

             //set user data
          $user_data = array(
              'inf_ses_id' =>$result['id'],
              'inf_ses_username' => $query['first_name'].' '.$query['last_name'],
              'inf_ses_email' => $result['email'],
              'inf_ses_role' => 'user',
              'inf_ses_logged_in' => true,
              'inf_ses_app_key' => $this->config->item('app_key'),
          );
          $this->session->set_userdata($user_data);


      }else{


          $blog_data = array(
              'username' => $query['first_name'].' '.$query['last_name'], 
              'email' => $query['email'], 
              'password' => $this->bcrypt->hash_password($params['password']),
              'role' => 'user', 
              'status' =>1
          );
          $this->db->insert('users',$blog_data);  
          $blog_id = $this->db->insert_id();
    //set user data
          $user_data = array(
              'inf_ses_id' =>$blog_id,
              'inf_ses_username' => $blog_data['username'],
              'inf_ses_email' => $blog_data['email'],
              'inf_ses_role' => 'user',
              'inf_ses_logged_in' => true,
              'inf_ses_app_key' => $this->config->item('app_key'),
          );
          $this->session->set_userdata($user_data);
        }
        }else if($query['type'] == 'superadmin'){

          $user_data = array(
              'inf_ses_id' =>1,
              'inf_ses_username' =>'admin',
              'inf_ses_email' => 'superadmin@admin.com',
              'inf_ses_role' => 'admin',
              'inf_ses_logged_in' => true,
              'inf_ses_app_key' => $this->config->item('app_key'),
          );

           $this->session->set_userdata($user_data);
        }
      /* Blog Login */


    }
    return $sts;
}




Public function get_account_details()
{
    $data = '';
    $id = $this->session->userdata('applicant_id');
    $where = array('applicant_id' =>$id);
    $data =  $this->db->get_where('account_details',$where)->row();
    return $data;
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



public function get_progress_bar($applicant_id)
{

  $sql = "SELECT
  c.country as country_name,s.statename as state_name,ct.city as city_name,
  applicants_profile.city as city_id,applicants_profile.state as state_id,applicants_profile.country as country_id,
  applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.role,applicants.type,applicants.profile_img,applicants.is_verified,applicants.profile_updated,
  social_applicant_user.picture_url,COUNT(review_ratings.rating) as rating_count,ROUND(AVG(review_ratings.rating)) as rating_value,
  applicants_profile.* FROM applicants
  LEFT JOIN applicants_profile ON applicants_profile.applicant_id = applicants.id
  LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id
  LEFT JOIN review_ratings ON review_ratings.user_id = applicants.id
  LEFT JOIN country c ON c.countryid = applicants_profile.country
  LEFT JOIN state s ON s.id = applicants_profile.state
  LEFT JOIN city ct ON ct.id = applicants_profile.city
  WHERE applicants.id=$applicant_id";

  $query = $this->db->query($sql)->row_array();
        // $query = $this->db->query(" SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.profile_updated,applicants.mobile_verified,applicants.role,country_list.country_name,country_list.code,social_applicant_user.picture_url,applicants_profile.* FROM  applicants
        //     LEFT JOIN applicants_profile ON applicants.id = applicants_profile.applicant_id LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id LEFT JOIN country_list ON country_list.country_id = applicants_profile.country WHERE applicants.id = ".$applicant_id)->row_array();
  return $query;
}

public function mentor_list_view()
{
    $query = $this->db->query("SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,mentor_details.country as country_name,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
        LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
        LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id        
        where  applicants.role=1 ORDER BY applicants.id DESC LIMIT 0,5")->result_array();
    // echo $this->db->last_query();

    return $query;
}

public function mentor_list_view_count()
{
    $query = $this->db->query("SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,mentor_details.country as country_name,social_applicant_user.picture_url,mentor_details.* FROM applicants
        LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
        LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id        
        where  applicants.role=1")->result_array();
    return count($query);
}

public function applicant_detail_list_view($id)
{

    $query = $this->db->query("SELECT mentor_details.dob,mentor_details.mentor_gender,mentor_details.under_college,
        mentor_details.under_major,mentor_details.graduate_college,mentor_details.degree,
        mentor_details.city,mentor_details.state,mentor_details.address_line1,mentor_details.address_line2,applicants.id as app_id,applicants.id,applicants.first_name,applicants.username,applicants.last_name,applicants.email,applicants.profile_img,applicants.is_verified,mentor_details.charge_type,mentor_details.country,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
        LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
        LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id   where applicants.id=$id")->row_array();    
    return $query;
}


public function verify_user($verification_code)
{
    $sts = 1 ;
    $check_query = $this->db->query("SELECT * FROM applicants WHERE verification_code = '".$verification_code."' AND is_verified = 1 ")->row_array();
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

public function update_profile($applicant_id,$profile_details)
{

    $profile_details['address_line1'] = htmlentities($profile_details['address_line1']);
    $profile_details['address_line2'] = htmlentities($profile_details['address_line2']);
    $sts = 1 ;
    $user_profile['first_name']  = $_POST['applicant_first_name'];
    $user_profile['last_name']   = $_POST['applicant_last_name'];
    $this->db->where('id',$applicant_id);
    if($this->db->update('applicants',$user_profile))
    {

        $check_profile_exist = $this->db->query(" SELECT * FROM mentor_details WHERE mentor_id =  ".$applicant_id)->row_array();
        $profile_details['applicant_id'] = $applicant_id;
        if(isset($check_profile_exist['id'])&&!empty($check_profile_exist['id']))
        {
            $profile_details['modified_date'] = date("Y-m-d h:m:s");
            $this->db->where('mentor_id',$applicant_id);
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

public function set_user_type($id,$role,$type)
{
    $this->db->where('id',$id);
    if($this->db->update('applicants',array('role'=>$role,'type'=>$type)))
    {
        return true;
    }
}

public function get_dashboard_activity($id,$limit,$current_page)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.username,t2.last_name,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_from',$id);
    $this->db->where('t1.delete_sts',0);
    $this->db->join('applicants t2','t2.id=t1.invite_to','left');
    $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_to','left');
    $this->db->order_by('t1.invite_id','desc');
    $this->db->limit($limit,$current_page);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}

public function get_dashboard_activity_search($id,$keyword)
{
  if(!empty($keyword)){
    $query = $this->db->query("select t1.*,t1.invite_id,t1.message,t1.invite_date,t1.invite_time,t3.picture_url,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t4.mentor_personal_message,t1.approved from invite t1
       left join applicants t2 on t2.id=t1.invite_to
       LEFT JOIN mentor_details t4 ON t4.mentor_id = t2.id
       LEFT JOIN social_applicant_user t3 ON t3.reference_id = t2.id where t1.delete_sts = 0 AND t1.invite_from=$id AND ((t2.first_name like '%$keyword%') OR (t1.invite_date like '%$keyword%') OR (t1.invite_time like '%$keyword%') OR (t4.mentor_personal_message like '%$keyword%') OR (t2.last_name like '%$keyword%') OR (CONCAT(t2.first_name,' ',t2.last_name) like '%$keyword%') ) order by t1.invite_id desc");
}else{
 $query = $this->db->query("select t1.invite_id,t1.message,t1.invite_date,t1.invite_time,t3.picture_url,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t1.approved from invite t1 left join applicants t2 on t2.id=t1.invite_to LEFT JOIN social_applicant_user t3 ON t3.reference_id = t2.id where t1.invite_from=$id AND t1.delete_sts = 0  order by t1.invite_id desc");
}
$result = $query->result_array();
return $result;
}


public function get_chat_list($id)
{
    $query = $this->db->query("select t2.logged_in,t2.username,t1.invite_id,t1.message,t1.invite_date,t1.invite_time,t3.picture_url,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img from invite t1 left join applicants t2 on t2.id=t1.invite_to
        LEFT JOIN social_applicant_user t3 ON t3.reference_id = t2.id
        where t1.invite_from=$id group by t1.invite_to");
    $result = $query->result_array();
    return $result;
}

public function get_chat_list_search($id,$keyword)
{
 $query = $this->db->query("select t2.logged_in,t2.username,t1.invite_id,t1.message,t1.invite_date,t1.invite_time,t3.picture_url,t2.id as app_id,t2.first_name,t2.last_name,t2.profile_img from invite t1 left join applicants t2 on t2.id=t1.invite_to LEFT JOIN social_applicant_user t3 ON t3.reference_id = t2.id where t1.invite_from=$id and ((t2.first_name like '%$keyword%') OR (t2.last_name like '%$keyword%') OR (CONCAT(t2.first_name,' ',t2.last_name) like '%$keyword%')) group by t1.invite_to");
 $result = $query->result_array();
 return $result;
}


public function get_old_chat($selected_user,$session_id,$total)
{
    $per_page = 5;

    $query = $this->db->query("SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage, sender.id as sender_id,msg.msg, msg.chatdate,social.picture_url as socialImage,msg.id,msg.type,msg.file_name,msg.file_path,time_zone,msg.id
        from chat msg
        LEFT  join applicants sender on msg.sent_id = sender.id
        LEFT  join social_applicant_user social on social.reference_id = msg.sent_id
        left join chat_deleted_details cd on cd.chat_id  = msg.id
        where cd.can_view = $session_id AND ((msg.recieved_id = $selected_user AND msg.sent_id = $session_id) or  (msg.recieved_id = $session_id AND msg.sent_id =  $selected_user))   ORDER BY msg.id ASC LIMIT $total,$per_page  ");
    $result = $query->result_array();
    return $result;

}



// Public function get_old_chat_count($selected_user,$session_id)
// {

//     $sql = "SELECT msg.id  from chat msg
//     where  ((msg.recieved_id = $selected_user AND msg.sent_id = $session_id) or  (msg.recieved_id = $session_id AND msg.sent_id =  $selected_user))   ORDER BY msg.id DESC ";
//       return  $this->db->query($sql)->num_rows();


// }




Public function deletable_chats($selected_user,$session_id)
{
   $query = $this->db->query("SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage, sender.id as sender_id,msg.msg, msg.chatdate,social.picture_url as socialImage,msg.id,msg.type,msg.file_name,msg.file_path,time_zone,msg.id
    from chat msg
    LEFT  join applicants sender on msg.sent_id = sender.id
    LEFT  join social_applicant_user social on social.reference_id = msg.sent_id
    left join chat_deleted_details cd on cd.chat_id  = msg.id
    where cd.can_view = $session_id AND ((msg.recieved_id = $selected_user AND msg.sent_id = $session_id) or  (msg.recieved_id = $session_id AND msg.sent_id =  $selected_user))");
   $result = $query->result_array();
   return $result;
}


public function get_latest_chat($selected_user,$session_id)
{

    $per_page = 5;
    $total =  $this->get_total_chat_count($selected_user,$session_id);
    if($total>5){
        $total = $total-5;
    }else{
        $total = 0;
    }

    $this->update_counts($selected_user,$session_id);

    $query = $this->db->query("SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage, sender.id as sender_id,msg.msg, msg.chatdate,social.picture_url as socialImage,msg.id,msg.type,msg.file_name,msg.file_path,time_zone,msg.id
        from chat msg
        LEFT  join applicants sender on msg.sent_id = sender.id
        LEFT  join social_applicant_user social on social.reference_id = msg.sent_id
        left join chat_deleted_details cd on cd.chat_id  = msg.id
        where cd.can_view = $session_id AND ((msg.recieved_id = $selected_user AND msg.sent_id = $session_id) or  (msg.recieved_id = $session_id AND msg.sent_id =  $selected_user))   ORDER BY msg.id ASC LIMIT $total,$per_page ");
    $result = $query->result_array();
    return $result;

}
Public function get_last_message_id($selected_user,$session_id)
{



    $sql = "SELECT msg.id  from chat msg
    left join chat_deleted_details cd on cd.chat_id  = msg.id
    where  cd.can_view = $session_id AND ((msg.recieved_id = $selected_user AND msg.sent_id = $session_id) or  (msg.recieved_id = $session_id AND msg.sent_id =  $selected_user))   ORDER BY msg.id DESC ";

    $data =   $this->db->query($sql)->row_array();


    if(!empty($data['id'])){
        return $data['id'];
    }else{
        return 0;
    }


}Public function get_total_chat_count($selected_user,$session_id)
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

public function get_render_chat($selected_user,$session_id)
{
    $query = $this->db->query("select DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage, sender.id as sender_id, CONCAT(receiver.first_name,' ',receiver.last_name) as receiverName, receiver.profile_img as receiverImage, receiver.id as receiver_id, receiver.username,msg.msg, msg.chatdate
      from chat msg inner join applicants sender on msg.sent_id = sender.id
      inner join applicants receiver on msg.recieved_id = receiver.id WHERE (msg.recieved_id=$session_id and msg.sent_id=$selected_user and msg.delete_sts=0) OR (msg.recieved_id=$selected_user and msg.sent_id=$session_id and msg.delete_sts=0)");
    $result = $query->result_array();
    return $result;
}

public function get_unread_chat_count($selected_user,$session_id)
{
    $query = $this->db->query("select DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage, sender.id as sender_id, CONCAT(receiver.first_name,' ',receiver.last_name) as receiverName, receiver.profile_img as receiverImage, receiver.id as receiver_id, receiver.username,msg.msg, msg.chatdate
      from chat msg inner join applicants sender on msg.sent_id = sender.id
      inner join applicants receiver on msg.recieved_id = receiver.id WHERE msg.recieved_id=$session_id and msg.sent_id=$selected_user and msg.read_status=0 and msg.delete_sts=0 ");
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

public function get_receiver_data($id)
{
    $this->db->select("CONCAT(first_name,' ',last_name) as chat_name, id as receiver_id,profile_img,username");
    $this->db->from('applicants');
    $this->db->where('id',$id);
    $query = $this->db->get();
    $result = $query->row_array();
    return $result;
}

public function get_reciever_chat($id)
{
    $this->db->select('t1.*,t2.first_name,t2.last_name,t2.profile_img,t3.*');
    $this->db->from('chat t1');
    $this->db->where('t1.recieved_id',$id);
    $this->db->join('applicants t2','t2.id=t1.recieved_id','left');
    $this->db->join('mentor_details t3','t3.mentor_id=t1.recieved_id','left');
        //$this->db->group_by('t1.sent_id');
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}



public function search_mentor_message($keyword)
{

 $mentor_personal_message = "( applicants.first_name like '%$keyword%'  OR applicants.last_name like '%$keyword%'  OR mentor_details.mentor_personal_message like '%$keyword%'
 OR courses.course like '%$keyword%' OR subject.subject like '%$keyword%' )";

 return $this->db->query("SELECT first_name, last_name, course ,mentor_details.mentor_personal_message,subject from applicants LEFT JOIN mentor_details ON applicants.id = mentor_details.mentor_id LEFT JOIN mentor_course_details ON mentor_course_details.mentor_id = mentor_details.mentor_id 
    LEFT JOIN courses ON courses.course_id = mentor_course_details.course_id
    LEFT JOIN subject ON subject.subject_id = mentor_course_details.subject_id
    WHERE  $mentor_personal_message AND applicants.role = '1' group by mentor_details.mentor_id LIMIT 0,5")->result_array();  
       // echo $this->db->last_query();   exit;


}
public function search_mentor_university($keyword)
{
    if($keyword != '')
    {
     $mentor_school = " mentor_details.mentor_school like '%$keyword%'";

     $query = $this->db->query("SELECT mentor_school from mentor_details WHERE  $mentor_school group by mentor_school LIMIT 0,5")->result_array();
     return $query;
 }
}



public function search_mentor_list_view($keyword)
{
    
    if($keyword != ''){

        $mentor_personal_message = "(applicants.first_name LIKE '%$keyword%' OR applicants.last_name LIKE '%$keyword%' OR mentor_details.mentor_personal_message LIKE '%$keyword%')";                

        $query = $this->db->query("SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,mentor_details.country as country_name,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
            LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
            LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id        
            WHERE  applicants.role=1 AND  $mentor_personal_message group by applicants.id LIMIT 0,5")->result_array();
    }else{
   
        
        $query = $this->db->query("SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,mentor_details.country as country_name,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
            LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
            LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id        
            WHERE  applicants.role=1  group by applicants.id LIMIT 0,5")->result_array();           
       
    }

     return $query;
}

public function search_mentor_list_view_count($keyword)
{
 $mentor_personal_message = "( applicants.first_name LIKE '%$keyword%' OR applicants.last_name LIKE '%$keyword%' OR mentor_details.mentor_personal_message LIKE '%$keyword%' )";
 $query = $this->db->query("SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,mentor_details.country as country_name,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
            LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
            LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id        
            WHERE  applicants.role=1 AND  $mentor_personal_message group by applicants.id")->num_rows();
 return $query;
}


public function search_mentor_list_university_view($keyword)
{
    if($keyword != '')
    {

     $mentor_school = " mentor_details.mentor_school like '%$keyword%'";
     $mentor_current_year = " OR mentor_details.mentor_current_year like '%$keyword%'";
     $mentor_schools_applied = " OR mentor_details.mentor_schools_applied like '%$keyword%'";
     $mentor_undergrad_school = " OR mentor_details.mentor_undergrad_school like '%$keyword%'";
     $mentor_job_title = " OR mentor_details.mentor_job_title like '%$keyword%'";
     $mentor_job_company = " OR mentor_details.mentor_job_company like '%$keyword%'";
     $mentor_job_dept = " OR mentor_details.mentor_job_dept like '%$keyword%'";
     $mentor_job_location = " OR mentor_details.mentor_job_location like '%$keyword%'";
     $mentor_job_desc = " OR mentor_details.mentor_job_desc like '%$keyword%'";
     $mentor_from = " OR mentor_details.mentor_from like '%$keyword%'";
     $mentor_live_work = " OR mentor_details.mentor_live_work like '%$keyword%'";

     $query = $this->db->query("SELECT DISTINCT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
        LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
        LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id
        LEFT JOIN country_list ON country_list.country_id = mentor_details.country where applicants.role=1 and applicants.is_verified=1 and applicants.profile_updated=1 and
        ($mentor_school $mentor_current_year $mentor_schools_applied
        $mentor_undergrad_school $mentor_job_title $mentor_job_company $mentor_job_dept $mentor_job_location $mentor_job_desc $mentor_job_desc
        $mentor_from $mentor_live_work) LIMIT 0,5")->result_array();
     return $query;
 }
}

public function search_mentor_list_university_view_count($keyword)
{
 if($keyword != '')
 {

     $mentor_school = " mentor_details.mentor_school like '%$keyword%'";
     $mentor_current_year = " OR mentor_details.mentor_current_year like '%$keyword%'";
     $mentor_schools_applied = " OR mentor_details.mentor_schools_applied like '%$keyword%'";
     $mentor_undergrad_school = " OR mentor_details.mentor_undergrad_school like '%$keyword%'";
     $mentor_job_title = " OR mentor_details.mentor_job_title like '%$keyword%'";
     $mentor_job_company = " OR mentor_details.mentor_job_company like '%$keyword%'";
     $mentor_job_dept = " OR mentor_details.mentor_job_dept like '%$keyword%'";
     $mentor_job_location = " OR mentor_details.mentor_job_location like '%$keyword%'";
     $mentor_job_desc = " OR mentor_details.mentor_job_desc like '%$keyword%'";
     $mentor_from = " OR mentor_details.mentor_from like '%$keyword%'";
     $mentor_live_work = " OR mentor_details.mentor_live_work like '%$keyword%'";

     $query = $this->db->query("SELECT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,mentor_details.* FROM applicants
        LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
        LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id
        LEFT JOIN country_list ON country_list.country_id = mentor_details.country where applicants.role=1 and applicants.is_verified=1 and applicants.profile_updated=1 and
        ($mentor_school $mentor_current_year $mentor_schools_applied
        $mentor_undergrad_school $mentor_job_title $mentor_job_company $mentor_job_dept $mentor_job_location $mentor_job_desc $mentor_job_desc
        $mentor_from $mentor_live_work)")->result_array();
     return count($query);
 }
}

public function search_guru_left($mentor)
{

   $fields = array('mentor_personal_message','mentor_gender', 'mentor_school', 'mentor_schools_applied', 'mentor_current_year');
   $conditions = array();
   foreach($fields as $field){
    if(isset($mentor[$field]) && $mentor[$field] != '') {
        $conditions[] = "$field LIKE '%" . $mentor[$field] . "%'";
    }
}

$query = "SELECT DISTINCT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.email,applicants.username,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id
LEFT JOIN country_list ON country_list.country_id = mentor_details.country where applicants.role=1 and applicants.profile_updated=1 and applicants.is_verified=1";

if(count($conditions) > 0) {
    $operator = (count($conditions) > 1) ? ' AND ' : ' OR ';
            $query .= " AND  " . implode ($operator, $conditions); // you can change to 'OR', but I suggest to apply the filters cumulative
        }

         //echo $query;exit;
        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function search_guru_left_home($mentor)
    {

       $fields = array('mentor_personal_message','mentor_gender', 'mentor_school', 'mentor_schools_applied', 'mentor_current_year');
       $conditions = array();
       foreach($fields as $field){
        if(isset($mentor[$field]) && $mentor[$field] != '') {
            $conditions[] = "$field LIKE '%" . $mentor[$field] . "%'";
        }
    }

    $query = "SELECT DISTINCT applicants.id as app_id,applicants.first_name,applicants.last_name,applicants.email,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,(select COUNT(rating) from review_ratings where user_id=applicants.id) as rating_count,(select ROUND(AVG(rating)) from review_ratings where user_id=applicants.id) as rating_value,mentor_details.* FROM applicants
    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
    LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id
    LEFT JOIN country_list ON country_list.country_id = mentor_details.country where applicants.role=1 and applicants.profile_updated=1 and applicants.is_verified=1";

    if(count($conditions) > 0) {
        $operator = (count($conditions) > 1) ? ' AND ' : ' OR ';
            $query .= " AND  " . implode ($operator, $conditions); // you can change to 'OR', but I suggest to apply the filters cumulative
        }

         //echo $query;exit;
        $result = $this->db->query($query)->result_array();
        return count($result);
    }

    public function search_guru_left_applicant($mentor)
    {
      $gender = $mentor['gender'];
      $admitted_school = $mentor['admitted_school'];
      $school_offer = $mentor['school_offer'];
      $school_year = $mentor['school_year'];
      $mentor_gender = '';
      if($gender > 0){
        $mentor_gender = " OR applicants_profile.mentor_gender like '%$gender%'";
    }
    $mentor_school = '';
    if($admitted_school != ''){
        $mentor_school = " OR applicants_profile.mentor_school like '%$admitted_school%'";
    }
    $mentor_schools_applied = '';
    if($school_offer != ''){
        $mentor_schools_applied = " OR applicants_profile.mentor_schools_applied like '%$school_offer%'";
    }
    $mentor_current_year = '';
    if($school_year != ''){
        $mentor_current_year = "applicants_profile.mentor_current_year like '%$school_year%'";
    }


    $query = $this->db->query("SELECT applicants.id as app_id,applicants.first_name,applicants.last_name ,applicants.email,applicants.role,applicants.profile_img,applicants.is_verified,country_list.country_name,country_list.code,social_applicant_user.picture_url,applicants_profile.* FROM   applicants
        LEFT JOIN applicants_profile ON applicants.id = applicants_profile.applicant_id
        LEFT JOIN social_applicant_user ON social_applicant_user.reference_id = applicants.id
        LEFT JOIN country_list ON country_list.country_id = applicants_profile.country
        where applicants.role=0 and applicants.is_verified=1 and applicants.profile_updated=1 and
        ($mentor_current_year $mentor_gender $mentor_school $mentor_schools_applied) LIMIT 0,5")->result_array();

    return $query;
}

public function calendar_list_confirmed_view($id,$limit,$current_page)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.username,t2.last_name,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_from',$id);
    $this->db->where('t1.approved',1);
    $this->db->where('t1.current_status',0);
    $this->db->where('t1.delete_sts',0);
    $this->db->join('applicants t2','t2.id=t1.invite_to','left');
    $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_to','left');
    $this->db->limit($limit,$current_page);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}

public function calendar_list_confirmed_view_count($id)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.username,t2.last_name,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_from',$id);
    $this->db->where('t1.approved',1);
    $this->db->where('t1.current_status',0);
    $this->db->where('t1.delete_sts',0);
    $this->db->join('applicants t2','t2.id=t1.invite_to','left');
    $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_to','left');
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}



public function calendar_list_guru_view($id)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.username,t2.last_name,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_from',$id);
    $this->db->where('t1.approved !=',2);
    $this->db->where('t1.current_status',0);
    $this->db->where('t1.delete_sts',0);
    $this->db->join('applicants t2','t2.id=t1.invite_to','left');
    $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_to','left');
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}


public function calendar_list_pending_view($id,$limit,$current_page)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_from',$id);
    $this->db->where('t1.approved',0);
    $this->db->where('t1.current_status',0);
    $this->db->join('applicants t2','t2.id=t1.invite_to','left');
    $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_to','left');
    $this->db->limit($limit,$current_page);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}
public function calendar_list_pending_view_count($id)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_from',$id);
    $this->db->where('t1.approved',0);
    $this->db->where('t1.current_status',0);
    $this->db->join('applicants t2','t2.id=t1.invite_to','left');
    $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_to','left');
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}

public function calendar_available_view($id)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_from',$id);
    $this->db->where('t1.approved',1);
    $this->db->where('t1.current_status',0);
    $this->db->join('applicants t2','t2.id=t1.invite_to','left');
    $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_to','left');
        //$this->db->join('appointment_schedule t5','t5.mentor_id=t1.invite_to','inner');
    $query = $this->db->get();
    $result = $query->result_array();

    return $result;
}

public function get_guru_available_data($id)
{


    $dt = date('Y-m-d', strtotime("+0 day"));
    $end = date('Y-m-d', strtotime("+6 day"));
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t2.id',$id);
    $this->db->where('t1.invite_date BETWEEN "'.$dt.'" AND "'.$end.'"');
    $this->db->where('t1.approved',1);
    $this->db->where('t1.current_status',0);
    $this->db->join('applicants t2','t2.id=t1.invite_to','left');
    $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_to','left');

    $query = $this->db->get();
    $result = $query->result_array();

    return $result;
}

public function get_guru_available_data_ajax($id,$selected_date)
{

    $dt = $selected_date;
    $end = date('Y-m-d', strtotime($dt. '+6 day'));

    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t2.id',$id);
    $this->db->where('t1.invite_date BETWEEN "'.$dt.'" AND "'.$end.'"');
        //$this->db->where('t1.approved',1);
    $this->db->where('t1.current_status',0);
    $this->db->join('applicants t2','t2.id=t1.invite_to','left');
    $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_to','left');

    $query = $this->db->get();
    $result = $query->result_array();

    return $result;
}


public function calendar_available_time($id)
{
    $this->db->select('*');
    $this->db->from('appointment_schedule');
    $this->db->where('mentor_id',$id);
    $this->db->order_by('time_start','asc');
    $query = $this->db->get();
    $result = $query->result_array();

    return $result;
}

public function calendar_available_time_ajax($id,$selected_date)
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
    $this->db->join('applicants t2','t2.id=t1.invite_to','left');
    $this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_to','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_to','left');
    $query = $this->db->get();
    $result = $query->row_array();
    return $result;
}

public function get_today_conversation($id,$date)
{
    $this->db->select('t1.*,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_from',$id);
    $this->db->where('t1.approved !=',2); // Modified
    $this->db->where('t1.current_status',0);
    $this->db->where('t1.invite_date',$date);
    $this->db->join('applicants t2','t2.id=t1.invite_to','left');
    $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_to','left');
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}

public function get_conversation_data($id)
{
    $this->db->select('t1.*,t2.id as app_id,t2.call_status,t2.first_name,t2.last_name,t2.username,t2.profile_img,t2.logged_in,t3.*,t4.picture_url');
    $this->db->from('invite t1');
    $this->db->where('t1.invite_from',$id);
    $this->db->where('t1.approved',1);
    $this->db->where('t1.current_status',0);
    $this->db->where('t1.read_status',0);
    $this->db->where('t1.delete_sts',0);
    // $this->db->where('t1.invite_date',date('Y-m-d'));
    $this->db->join('applicants t2','t2.id=t1.invite_to','left');
    $this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
    $this->db->join('social_applicant_user t4','t4.reference_id=t1.invite_to','left');
    $this->db->order_by('t1.from_date_time','asc');
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
}

}
?>
