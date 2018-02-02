<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('chat_model','chat');
		$this->load->model('applicant_modal');
		$this->timezone = $this->session->userdata('time_zone');
		if(!empty($this->timezone)){
			date_default_timezone_set($this->timezone);
		}
		error_reporting(0);
	}



	Public  function converToTz($time="",$toTz='',$fromTz='')
	{           
		$date = new DateTime($time, new DateTimeZone($fromTz));
		$date->setTimezone(new DateTimeZone($toTz));
		$time= $date->format('Y-m-d H:i:s');
		return $time;

	}


	Public function validate()
	{
		$invite = $this->db->get_where('invite',array('invite_id'=>$_POST['invite_id']))->row_array();
		$from_timezone = $invite['time_zone'];
		$date_time = $invite['invite_date'].' '.$invite['invite_end_time'];
		$date_time  = $this->converToTz($date_time,$this->timezone,$from_timezone);		
		$date_time  = date("Y-m-d H:i:s",strtotime("+15 minutes",strtotime($date_time)));
		 
		if(date('Y-m-d H:i:s') > $date_time){
			echo 'true';
			exit;
		}
	}


	public function get_messages()
	{
		$this->validate();
		$this->load->model('applicant_modal');
		$session_id = $this->session->userdata('applicant_id');
		$selected_user = $this->get_user_id();
		$latest_chat= $this->applicant_modal->get_latest_chat($selected_user,$session_id); 
		$total_chat= $this->applicant_modal->get_total_chat_count($selected_user,$session_id);  

		if($total_chat>5){
			$total_chat = $total_chat - 5;
			$page = $total_chat / 5;
			$page = ceil($page);
			$page--;
		} 

		if(count($latest_chat)>4){
		$html ='<div class="load-more-btn text-center" total="'.@$page.'">
		<button class="btn btn-default" data-page="2"><i class="fa fa-refresh"></i> Load More</button>
		</div><div id="ajax_old"></div>';  
		}else{
			$html ='';
		}

		if(isset($latest_chat)!=''){
			foreach($latest_chat as $key => $currentuser) : 

				$class_name =($currentuser['sender_id'] != $session_id) ? 'chat-left' : '';
				$user_image = ($currentuser['senderImage']!= '') ? base_url().'assets/images/'.$currentuser['senderImage']: base_url().'assets/images/default-avatar.png';


				if($currentuser['senderImage']!=''){
					$img =  base_url().'assets/images/'.$currentuser['senderImage'];
				}elseif($currentuser['socialImage']!=''){
					$img = $currentuser['socialImage'];
				}else{
					$img = base_url().'assets/images/default-avatar.png';
				}
			
				
				$from_timezone = $currentuser['time_zone'];
				$date_time  = $this->converToTz($currentuser['chatdate'],$this->timezone,$from_timezone);        
				$time = date('h:i a',strtotime($date_time));
				$html .='<div class="chat '.$class_name.'">
				<div class="chat-avatar">
				<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
				<img  src="'.$img.'" class="img-responsive img-circle">
				</a>
				</div>
				<div class="chat-body">
				<div class="chat-content">
				<p>'.$currentuser['msg'].'</p>
				<span class="chat-time" >'.$time.'</span>
				</div>
				</div>
				</div>';
			endforeach;
      $html .='<div id="ajax"></div><input type="text"  id="hidden_id">'; //id="hidden_id"
  }
  echo $html;

}


Public function get_user_id()
{
	$where = array('username' => $_POST['to_username']);
	return $this->db->get_where('applicants',$where)->row()->id;	
}



Public function insert_chat()
{	
	$session_id = $this->session->userdata('applicant_id');
	$data['recieved_id'] =$this->get_user_id();
	$data['sent_id'] = $this->session->userdata('applicant_id');
	$data['time_zone'] = $this->session->userdata('time_zone');
	$data['chatdate'] = date('Y-m-d H:i:s');
	$data['msg'] = $_POST['input_message'];
	$result = $this->db->insert('chat',$data);
	$chat_id = $this->db->insert_id();
	$users = array($data['recieved_id'],$data['sent_id']);
	for ($i=0; $i <2 ; $i++) { 
		$datas = array('chat_id' =>$chat_id ,'can_view'=>$users[$i]);
		$this->db->insert('chat_deleted_details',$datas);
	}

	$data['type'] = 'message';
	$data['from_name'] = $this->get_full_name($session_id);

	 $res = $this->send_push_notification($data);	
	 print_r($res);
	//echo  $result;


}


Public function send_push_notification($datas){
	
	$data = $this->chat->get_player_id($datas['recieved_id']);
	if(!empty($data)){
		
		$additional_data['from_name'] = $datas['from_name'];
		
		$additional_data['from_user_id'] = $datas['sent_id'];
		$additional_data['to_user_id'] = $datas['recieved_id'];	
		$additional_data['from_username'] = $this->get_user_name($datas['sent_id']);				
		$additional_data['to_username'] = $this->get_user_name($datas['recieved_id']);				
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
Public function get_user_name($id)
{
    $query = "SELECT username from  applicants where id = $id";
    return  $this->db->query($query)->row()->username;  
}
Public function get_full_name($id)
{
    $query = "SELECT CONCAT(first_name,' ',last_name) as full_name from  applicants where id = $id";
    return  $this->db->query($query)->row()->full_name;  
}

Public function get_image()
{

	$sql = "SELECT a.id,a.profile_img as senderImage, social.picture_url as socialImage
	from applicants a  
	LEFT  join social_applicant_user social on social.reference_id = a.id
	where a.username = '$_POST[to_username]' ";


	$data = $this->db->query($sql)->row_array();

	if($data['senderImage']!=''){
		$img =  base_url().'assets/images/'.$data['senderImage'];
	}elseif($data['socialImage']!=''){
		$img = $data['socialImage'];
	}else{
		$img = base_url().'assets/images/default-avatar.png';
	}

	$msg['image'] =  $img;
	$msg['data'] = $this->db->order_by('id','desc')->get_where('chat',array('sent_id'=>$data['id']))->row();
	echo json_encode($msg);


}

Public function new_chat()
{
	$id = $this->session->userdata('applicant_id');
	$this->data['module'] = 'new_chat';
	if($this->session->userdata('role') == 0){
		$this->data['theme'] = 'applicant';
	}else{
		$this->data['theme'] = 'guru';
	}
	$this->load->vars($this->data);
	$this->load->view('template'); 
}


Public function update_channel()
{




	$where = array('username' => $_POST['call_to']);
	$call_to =  $this->db->get_where('applicants',$where)->row()->id;
	$channel = $_POST['channel'];
	$call_from = $this->session->userdata('applicant_id');		

	$sql = "SELECT * FROM call_details c WHERE c.channel = '$channel' AND  ((c.call_from = $call_from AND c.call_to = $call_to) OR (c.call_to = $call_from AND c.call_from = $call_to))";

	$datas = $this->db->query($sql)->row();



	if(empty($datas)){
		$data = array(
			'call_from' =>$call_from,
			'call_to' =>$call_to,
			'url' =>$_POST['url'],
			'invite_id' =>$_POST['invite_id'],
			'status' =>1,
			'start_by' =>$this->session->userdata('applicant_id'),
			'channel' =>$_POST['channel']
		);
		if(!empty($_POST['type'])){
			$data +=array('type' => 'audio');
		}
		
		 $this->db->insert('call_details',$data);
		 $this->db->insert_id();


	
	$caller_name = $this->session->userdata('first_name').' '.$this->session->userdata('last_name');
	// $userdata= $this->get_all_data($call_from);
	// $call_to_name  = $userdata->first_name.' '.$userdata->last_name;
	$data['recieved_id'] =$call_to;
	$data['sent_id'] = $call_from;
	$data['msg'] = 'Call from '.$caller_name;
	$data['from_name'] = $caller_name;
	$data['type'] = 'video';	
	$res = $this->send_push_notification($data);
	print_r($res);

	}else{

		if($datas->call_to == $this->session->userdata('applicant_id')){
			$where = array(
				'invite_id' => $_POST['invite_id']
			);							
			$this->db->delete('call_details',$where);
		}


			// if($datas->call_to == $this->session->userdata('applicant_id')){
			// 	$data = array(	'status' =>2);
			// 	$where = array(
			// 		'call_to' =>$this->session->userdata('applicant_id'),
			// 		'call_from' =>$call_to,
			// 		'channel' =>$channel
			// 	);
			// 	// echo $this->db->update('call_details',$data,$where);
			// 	echo $this->db->delete('call_details',$where);


			// }else{

			// 	//$data = array(	'status' =>1);
			// 	$where = array(
			// 		'call_from' =>$this->session->userdata('applicant_id'),
			// 		'call_to' =>$call_to,
			// 		'channel' =>$channel
			// 	);
			// 	echo $this->db->delete('call_details',$where);

			// }





	}

}




}

/* End of file  */
/* Location: ./application/controllers/ */