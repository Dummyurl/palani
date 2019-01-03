<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '../vendor/autoload.php');

use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\Session;
use OpenTok\Role;


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
		
		 /* tok Box api */
    $this->apiKey = $this->config->item('apiKey');
    $this->apiSecret = $this->config->item('apiSecret');


    // $this->apiKey = '46148072';
    // $this->apiSecret = '3b85429caab05729ad0476754be53f49de087f88';


		error_reporting(0);
	}

	Public function test(){
		echo  $this->apiKey;
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
			</div><div id="ajax_old" class="ajax_old"></div>';  
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


				$time_zone = $this->session->userdata('time_zone');
				$from_timezone = $currentuser['time_zone'];
				$date_time = $currentuser['chatdate'];
				$date_time  = $this->converToTz($date_time,$time_zone,$from_timezone);
				$time = date('d-m-Y h:i a',strtotime($date_time));


				if($currentuser['type'] == 'image'){

					$html .='<div class="chat '.$class_name.'">
					<div class="chat-avatar">
					<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
					<img  src="'.$img.'" class="img-responsive img-circle" title="'.$currentuser['senderName'].'">
					</a>
					</div>
					<div class="chat-body">
					<div class="chat-content">
					<p><img alt="" src="'.base_url().$currentuser['file_path'].'/'.$currentuser['file_name'].'" class="img-responsive"></p>
					<p>'.$currentuser['file_name'].'</p>
					<a href="'.base_url().$currentuser['file_path'].'/'.$currentuser['file_name'].'" target="_blank" download>Download</a>
					<span class="chat-time">'.$time.'</span>
					</div>
					</div>
					</div>';

				}else if($currentuser['type'] == 'others'){

					$html .='<div class="chat '.$class_name.'">
					<div class="chat-avatar">
					<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
					<img  src="'.$img.'" class="img-responsive img-circle" title="'.$currentuser['senderName'].'">
					</a>
					</div>
					<div class="chat-body">
					<div class="chat-content">
					<p><img alt="" src="'.base_url().'assets/images/download.png" class="img-responsive"></p>
					<p>'.$currentuser['file_name'].'</p>
					<a href="'.base_url().$currentuser['file_path'].'/'.$currentuser['file_name'].'" target="_blank" download class="chat-time">Download</a>
					<span class="chat-time">'.$time.'</span>
					</div>
					</div>
					</div>';


				}
				else if($currentuser['msg']=='ENABLE_STREAM' || $currentuser['msg']=='DISABLE_STREAM'){


				}else{
					$html .='<div class="chat '.$class_name.'">
					<div class="chat-avatar">
					<a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
					<img  src="'.$img.'" class="img-responsive img-circle" title="'.$currentuser['senderName'].'">
					</a>
					</div>
					<div class="chat-body">
					<div class="chat-content">
					<p>
					'.$currentuser['msg'].'
					</p>
					<span class="chat-time">'.$time.'</span>
					</div>
					</div>
					</div>';

				}


			endforeach;
      $html .='<div id="ajax" class="new_ajax"></div><input type="hidden"  id="hidden_id">'; //id="hidden_id"
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

	//error_reporting(1);
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
		$additional_data['date_time'] = date('Y-m-d H:i:s');
		$additional_data['time_zone'] = date_default_timezone_get();			

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
	$this->db->update('chat',array('read_status'=>1),array('id'=>$msg['data']->id));
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


Public function check_status(){
	
	$result = $this->db->get_where('applicants',array('id'=>$_POST['id']))->row_array();
	echo json_encode(array('call_status' => $result['call_status']));
}
Public function update_call_status(){

	$id = $this->session->userdata('applicant_id');
	$this->db->update('applicants',array('call_status'=>$_POST['call_status']),array('id'=>$id));
}

Public function delete_channel(){

	$id = $this->session->userdata('applicant_id');
	$this->db->update('applicants',array('call_status'=>$_POST['call_status']),array('id'=>$id));


		$where = array('invite_id' => $_POST['invite_id']);							
		echo $this->db->delete('call_details',$where);
}

Public function update_channel()
{



	$where = array('username' => $_POST['call_to']);
	$user =  $this->db->get_where('applicants',$where)->row_array();

	if($user['call_status'] == 1){
		echo json_encode(array('error'=>'Already in call!'));
		exit;
	}		

	$invite_id = $_POST['invite_id'];
	$call_to = $user['id'];
	$channel = $_POST['channel'];
	// $call_from = 8;		
	$call_from = $this->session->userdata('applicant_id');	

	$this->make_call_notify($call_from,$call_to,$invite_id);	



	$sql = "SELECT * FROM call_details c WHERE  ((c.call_from = $call_from AND c.call_to = $call_to) OR (c.call_to = $call_from AND c.call_from = $call_to))";

	$datas = $this->db->query($sql)->row();



	if(empty($datas)){
		$data = array(
			'call_from' =>$call_from,
			'call_to' =>$call_to,
			'url' =>$_POST['url'],
			'invite_id' =>$invite_id,
			'status' =>1,
			'start_by' =>$call_from,
			'channel' =>$_POST['channel']
		);
		if(!empty($_POST['type'])){
			$data +=array('type' => 'audio');
		}
		
		$this->db->insert('call_details',$data);
		$this->db->insert_id();

		$caller_name = $this->session->userdata('first_name').' '.$this->session->userdata('last_name');	
		$data['recieved_id'] =$call_to;
		$data['sent_id'] = $call_from;
		$data['msg'] = 'Call from '.$caller_name;
		$data['from_name'] = $caller_name;
		$data['type'] = 'video';	
		$status = true; 

	}else{

		if($_POST['status'] == 1){			
			$this->db->update('call_details',array('status'=>1),array('invite_id'=>$_POST['invite_id']));		
		}else{
			if($datas->call_to == $this->session->userdata('applicant_id')){
			$where = array(
				'invite_id' => $_POST['invite_id']
			);							
			$this->db->delete('call_details',$where);
			$status = false;
		}

		}
	}

	/* Generate token */
	$response = $this->get_token($_POST['invite_id'],$status);
	echo json_encode($response);		

}

Public function make_call_notify($call_from,$call_to,$invite_id){


	$type = 'video';
	if(!empty($_POST['type'])){
		$type = $_POST['type'];
	}

	$opentok = new OpenTok($this->apiKey, $this->apiSecret);
		$additional_data = array();	
		$result = $this->db->get_where('invite',array('invite_id'=>$invite_id))->row_array();
		if(!empty($result)){
			$sessionId =$result['session_id'];
			if(empty($sessionId)){
				$sessionId = $this->generate_session_id();
				$this->db->update('invite',array('session_id'=>$sessionId),array('invite_id'=>$invite_id));
			}

			$connectionMetaData = json_encode(array('invite_id'=>$datas['invite_id']));
		// Replace with the correct session ID:
			$my_token = $opentok->generateToken($sessionId,array('expireTime' => time()+(7 * 24 * 60 * 60), 'data' =>  $connectionMetaData));
			$additional_data += array('apiKey' => $this->apiKey,'sessionId' =>$sessionId , 'token' => $my_token);
		}

			$data = $this->chat->get_player_id($call_to);
		$additional_data  +=	array(
			'from_name' => $this->get_full_name($call_from),        
			'from_user_id' => $call_from,			
			'from_username' => $this->get_users_name($call_from),                			
			'from_profile_image' => $this->get_user_image($call_from),           
			'type' => $type,
			'invite_id' => $invite_id
		);          

		$push_data['button'] = array(
			array('id'=>'answer','title'=>'Call From '.$additional_data['from_name'].'','text'=>'Answer','icon'=>""),
			array('id'=>'decline','title'=>'Call From '.$additional_data['from_name'].'','text'=>'Decline','icon'=>"")
		);  


		$push_data['user_id'] = $call_from;
		$push_data['message'] = 'Notification';
		$push_data['include_player_ids'] = $data['device_id'];
		$push_data['additional_data'] = $additional_data; 	
		$result = send_button($push_data); 

}
Public function get_users_name($id)
{
	$query = "SELECT username from  applicants where id = $id";
	return  $this->db->query($query)->row()->username;  
}

Public function get_token($invite_id,$status){


	$opentok = new OpenTok($this->apiKey, $this->apiSecret);
	$response = array();
	$data = $this->db->get_where('invite',array('invite_id'=>$invite_id))->row_array();
	if(!empty($data)){
		$sessionId =$data['session_id'];
		$connectionMetaData = json_encode(array('invite_id'=>$invite_id));
		// Replace with the correct session ID:
		$my_token = $opentok->generateToken($sessionId,array('expireTime' => time()+(7 * 24 * 60 * 60), 'data' =>  $connectionMetaData));
		$response = array('apiKey' => $this->apiKey,'sessionId' =>$sessionId , 'token' => $my_token,'new_call'=>$status);
	}

	return $response;
	

}




Public function mute_ringing(){

	$data = $this->db->order_by('call_id','desc')
	->get_where('call_details',array('invite_id'=>$_POST['invite_id']))
	->row_array();

	/* If notification present */
	if(!empty($data)){
		/*check call attended */
		if($data['status'] == 1){

			$where = array('invite_id' => $_POST['invite_id']);							
			$this->db->delete('call_details',$where);
			$result =  json_encode(array('session' =>1 ));			 /* Call not responded*/

		}elseif($data['status'] == 2){

			$where = array('invite_id' => $_POST['invite_id']);							
			$this->db->delete('call_details',$where);
			$result =  json_encode(array('session' =>2 ));			// Call attended 

		}
		else{
			$result =  json_encode(array('session' =>0)); // Call Rejected 
		}
	}
	echo $result;
}

}

/* End of file  */
/* Location: ./application/controllers/ */