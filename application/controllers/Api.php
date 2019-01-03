<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require_once(APPPATH . '../vendor/stripe/stripe-php/init.php');

require_once(APPPATH . '../vendor/autoload.php');

use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\Session;
use OpenTok\Role;


class Api extends REST_Controller {

	function __construct()
	{
		parent::__construct();     
		$this->load->model('api_model','api');		
		/* tok Box api */
		$this->apiKey = $this->config->item('apiKey');
    $this->apiSecret = $this->config->item('apiSecret');
    /* Stripe Key*/
		$this->stripe_secret_key = $this->config->item('stripe_secret_key');

	}

  Public function rate_mentor_post(){

    $datas = json_decode( file_get_contents( 'php://input' ), true );
    if(empty($datas)){
      $datas = $this->input->post();
    }

    if(empty($datas['user_id'])){
      $this->response([
        'code' => 400,
        'status' => FALSE,
        'message' => 'User id missing!'       
      ], REST_Controller::HTTP_OK);
    }
    $where = array('id'=>$datas['user_id']);
    $ch = $this->db->get_where('applicants',$where)->row_array();
    if(empty($ch)){
      $this->response([
        'code' => 400,
        'status' => FALSE,
        'message' => 'Invalid User id!'       
      ], REST_Controller::HTTP_OK);
    }
    if(empty($datas['invite_id'])){
      $this->response([
        'code' => 400,
        'status' => FALSE,
        'message' => 'Invite id missing!'       
      ], REST_Controller::HTTP_OK);
    }

    /* Checking  valid invite */
    $where = array('invite_id' => $datas['invite_id']);
    $result = $this->db->get_where('invite',$where)->row_array();

    if(count($result)== 0){   
     $this->response([
      'code' => 400,
      'status' => FALSE,
      'message' => 'Invalid invite id !'       
    ], REST_Controller::HTTP_OK);
   }elseif($result['invite_from'] != $datas['user_id']){

    $this->response([
      'code' => 400,
      'status' => FALSE,
      'message' => 'You dont have permission to rate this call!'       
    ], REST_Controller::HTTP_OK);

  }elseif($result['approved'] == 0){
    $this->response([
      'code' => 400,
      'status' => FALSE,
      'message' => 'Call not approved yet!'       
    ], REST_Controller::HTTP_OK);
  }



  $res= $this->db->get_where('call_logs',$where)->row_array();


  if(empty($res)){

    $this->response([
      'code' => 400,
      'status' => FALSE,
      'message' => 'Call not finished yet!'       
    ], REST_Controller::HTTP_OK);

  }else{


    if(empty($datas['rating'])){
      $this->response([
        'code' => 400,
        'status' => FALSE,
        'message' => 'Rating count missing!'       
      ], REST_Controller::HTTP_OK);
    }

    $review = (!empty($datas['review'])?$datas['review']:'');



    $count = $this->db->get_where('review_ratings',$where)->num_rows();
    if($count!=0){
      $this->response([
        'code' => 400,
        'status' => FALSE,
        'message' => 'Rating already made for this call!'       
      ], REST_Controller::HTTP_OK);

    }else{
      $data_new = array(
        'invite_id' => $datas['invite_id'], 
        'reviewer_id' => $datas['user_id'], 
        'user_id' => $result['invite_to'],
        'review' => $review,
        'rating' => $datas['rating'],
        'reviewer_name' => $this->get_user_name($result['invite_to']),

      );
      $this->db->insert('review_ratings',$data_new);

      $this->response([
        'code' => 200,
        'status' => TRUE,
        'message' => 'Rating successfully made for this call!'       
      ], REST_Controller::HTTP_OK);




    }


  }




}




Public function get_all_booking_post(){


  $datas = json_decode( file_get_contents( 'php://input' ), true );
  if(empty($datas)){
   $datas = $this->input->post();
 }


 if(empty($datas['user_id'])){
   $this->response([
    'code' => 400,
    'status' => FALSE,
    'message' => 'User id missing!'				
  ], REST_Controller::HTTP_OK);
 }
 if(empty($datas['page_no'])){ /* Missing Page no */

   $this->response([
    'code' => 400,
    'status' => FALSE,                
    'message' => 'Page no missing!'			
  ], REST_Controller::HTTP_OK);
 }
 $page_no = !empty($datas['page_no'])?$datas['page_no']:1;	
 $per_page = 5;
 $where = array('id'=>$datas['user_id']);
 $data = $this->db->get_where('applicants',$where)->row_array();

 if(!empty($data)){

   if($data['role'] == 0){
    $wheres  = "invite_from = $data[id]";
  }elseif($data['role'] == 1){
    $wheres  = "invite_to = $data[id]";
  }

  $sql1 = "SELECT * FROM `invite` WHERE $wheres ORDER BY from_date_time DESC";
  $sql='';

  if($page_no > 0){
    $page_limit= $per_page * ($page_no-1);
    $sql .=" LIMIT  $page_limit, $per_page";
  }else{
    $sql .=" LIMIT 0 , $per_page";

  }  





  $result= $this->db->query($sql1.$sql)->result_array();
  $total_booking= $this->db->query($sql1)->num_rows();	

  $total_pages = $total_booking / $per_page;  
  $total_pages = ceil($total_pages);



  $response=array();
  $all_data=array();

  if(!empty($result)){
    $message='Data fetched successfully';

    foreach($result as $res){				
     $invite['invite_id'] = $res['invite_id'];

     if($data['role'] == 0){					
      $invite['user_id'] = $res['invite_to'];
      $invite['user_name'] = $this->get_full_name($res['invite_to']);
      $invite['profile_img'] = $this->get_user_image($res['invite_to']);		

    }elseif($data['role'] == 1){
      $invite['user_id'] = $res['invite_from'];
      $invite['user_name'] = $this->get_full_name($res['invite_from']);
      $invite['profile_img'] = $this->get_user_image($res['invite_from']);
    }

    $from_date = date('d-m-Y',strtotime($res['from_date_time']));
    $from_time = date('h:i A',strtotime($res['from_date_time']));
    $from_date_time = $res['from_date_time'];

    $invite['booked_date'] = $from_date;
    $invite['booked_time'] =  $from_time;

    $status = $this->get_status($res);
    $invite['current_status'] = $status['status'];
    $invite['can_rate'] = false;
    if($data['role'] == 0){
      $invite['can_rate'] = $status['can_rate'];
    }
    $all_data[]=$invite;
  }


}
else{
  $message='No Data';

}



$response['total_pages'] = $total_pages;
$response['page_no'] = $page_no;
$response['total_booking'] = $total_booking;
$response['bookings'] = $all_data;




$this->response([
  'code' => 200,
  'status' => TRUE,
  'message' => $message,
  'data' => $response
], REST_Controller::HTTP_OK); 		

}else{

 $this->response([
  'code' => 400,
  'status' => FALSE,
  'message' => 'Invalid user id!',				
], REST_Controller::HTTP_OK);
}

}


Public function get_status($data){   	
  date_default_timezone_set('Asia/kolkata');
  $from_date = date('d-m-Y',strtotime($data['from_date_time']));
  $from_time = date('h:i A',strtotime($data['from_date_time']));
  $from_date_time = $data['from_date_time'];

  $result['status'] =  0;
  $result['can_rate'] =  false;



  if($data['approved'] == 0 && date('Y-m-d H:i:s') >  date('Y-m-d H:i:s', strtotime($from_date_time . ' +1 hour'))) {

					$result['status'] =  2; // Cancelled time up 

				}else{

					$result['status'] = 0; // Pending

				}

				$count = $this->db->get_where('call_logs',array('invite_id'=>$data['invite_id']))->num_rows();

                           // Before Call time with approved

				if($data['approved'] == 1 && date('Y-m-d H:i:s') <  date('Y-m-d H:i:s', strtotime($from_date_time)) ){

                       $result['status'] =  1; // Approved

                     }
                     elseif($data['approved'] == 1 && date('Y-m-d H:i:s') >  date('Y-m-d H:i:s', strtotime($from_date_time)) ){
                          // After Call time with Approve


                          // After Call time with Approve  with call logs
                      if($count>0){
                         $result['status'] =  3; // Finished

                         $rating_count = $this->db->get_where('review_ratings',array('invite_id'=>$data['invite_id']))->num_rows();
                         if($rating_count == 0){
                         	$result['can_rate'] =true; 
                         }

                           }else{ // After Call time with Approve  without call logs

                             $result['status'] =  4; // Incomplete

                           }
                         }

                         if($data['approved'] == 2) {
                           $result['status'] =  2; // Cancelled

                         }


                         return $result;
                       }


                       Public function cancel_booking_post()
                       {

                        $datas = json_decode( file_get_contents( 'php://input' ), true );
                        if(empty($datas)){
                          $datas = $this->input->post();
                        }           
                        $this->check_invites_cancel($datas);


                        if(empty($datas['user_id'])){
                          $this->response([
                            'code' => 400,
                            'status' => FALSE,
                            'message' => 'User id missing!',                      
                          ], REST_Controller::HTTP_OK);

                        }

                        $data = $this->db->get_where('applicants',array('id'=>$datas['user_id']))->row_array();
                        if(empty($data)){
                          $this->response([
                            'code' => 400,
                            'status' => FALSE,
                            'message' => 'Invalid user id!',                      
                          ], REST_Controller::HTTP_OK);

                        }else{

                          if($data['role'] == 0){
                            $this->response([
                              'code' => 400,
                              'status' => FALSE,
                              'message' => 'Login as mentor to cancel this request!',                      
                            ], REST_Controller::HTTP_OK);

                          }

                        }

                        $invite = $this->db->get_where('invite',array('invite_id'=>$datas['invite_id']))->row_array();  

                        if($invite['invite_to'] != $datas['user_id']){

                          $this->response([
                            'code' => 400,
                            'status' => FALSE,
                            'message' => 'You dont have permission to cancel this request!',                   
                          ], REST_Controller::HTTP_OK);
                        }

                        $this->db->update('invite',array('approved'=>2,'channel'=>'channel'),array('invite_id'=>$datas['invite_id']));


                        $mentor_name =  $data['first_name'].' '.$data['last_name'];
                        $mentee_name = $this->get_user_name($invite['invite_from']);

                        $insert = array(
                          'mentor_message' => 'You cancelled call request from '.$mentee_name,
                          'mentee_message' => 'Call request cancelled by '.$mentor_name,
                          'mentor_view' => 1,
                          'mentee_view' => 1,
                          'user_id' => $invite['invite_from'],
                          'notification_id' => $invite['invite_to'],       
                          'invite_id' =>$invite['invite_id'],
                          'read' =>0,
                          'created_date' => date('Y-m-d H:i:s'),
                          'time_zone' => date_default_timezone_get()
                        );
                        $this->db->insert('notifications',$insert);

                        $this->response([
                          'code' => 200,
                          'status' => TRUE,
                          'message' => 'Request cancelled successfully!',                    
                        ], REST_Controller::HTTP_OK);
                      }


                      Public function check_invites_cancel($data){

                        if(empty($data['invite_id'])){

                          $this->response([
                            'code' => 400,
                            'status' => FALSE,
                            'message' => 'Invite id missing !'                    
                          ], REST_Controller::HTTP_OK);

                        }

                        $where = array('invite_id' => $data['invite_id']);
                        $result = $this->db->get_where('invite',$where)->row();
                        if(!empty($result)){
                          $wheres = array(
                            'from_date_time' => $result->from_date_time,
                            'to_date_time' => $result->to_date_time,
                            'invite_to' => $data['user_id'],
                            'approved' => 2
                          );
                          $count = $this->db->get_where('invite',$wheres)->num_rows();
                          if($count != 0){
                            $this->response([
                              'code' => 400,
                              'status' => FALSE,
                              'message' => 'Already call cancelled on this request !'                        
                            ], REST_Controller::HTTP_OK);

                          }

                        }else{

                          $this->response([
                            'code' => 400,
                            'status' => FALSE,
                            'message' => 'Invalid invite id!'                     
                          ], REST_Controller::HTTP_OK);

                        }
                      }




                      Public function approve_booking_post()
                      {

                        $datas = json_decode( file_get_contents( 'php://input' ), true );
                        if(empty($datas)){
                         $datas = $this->input->post();
                       }		
                       $this->check_invites($datas);


                       if(empty($datas['user_id'])){
                         $this->response([
                          'code' => 400,
                          'status' => FALSE,
                          'message' => 'User id missing!',				
                        ], REST_Controller::HTTP_OK);

                       }

                       $data = $this->db->get_where('applicants',array('id'=>$datas['user_id']))->row_array();
                       if(empty($data)){
                         $this->response([
                          'code' => 400,
                          'status' => FALSE,
                          'message' => 'Invalid user id!',				
                        ], REST_Controller::HTTP_OK);

                       }else{

                         if($data['role'] == 0){
                          $this->response([
                           'code' => 400,
                           'status' => FALSE,
                           'message' => 'Login as mentor to approve this request!',				
                         ], REST_Controller::HTTP_OK);

                        }

                      }

                      $invite = $this->db->get_where('invite',array('invite_id'=>$datas['invite_id']))->row_array();  

                      if($invite['invite_to'] != $datas['user_id']){

                       $this->response([
                         'code' => 400,
                         'status' => FALSE,
                         'message' => 'You dont have permission to approve this request!',				
                       ], REST_Controller::HTTP_OK);
                     }

                     $this->db->update('invite',array('approved'=>1,'channel'=>'channel'),array('invite_id'=>$datas['invite_id']));


                     $mentor_name =  $data['first_name'].' '.$data['last_name'];
                     $mentee_name = $this->get_user_name($invite['invite_from']);

                     $insert = array(
                       'mentor_message' => 'You approved call request from '.$mentee_name,
                       'mentee_message' => 'Call request accepted by '.$mentor_name,
                       'mentor_view' => 1,
                       'mentee_view' => 1,
                       'user_id' => $invite['invite_from'],
                       'notification_id' => $invite['invite_to'],       
                       'invite_id' =>$invite['invite_id'],
                       'read' =>0,
                       'created_date' => date('Y-m-d H:i:s'),
                       'time_zone' => date_default_timezone_get()
                     );
                     $this->db->insert('notifications',$insert);

                     $this->response([
                       'code' => 200,
                       'status' => TRUE,
                       'message' => 'Request Approved successfully!',				
                     ], REST_Controller::HTTP_OK);
                   }

                   Public function check_invites($data){

                    if(empty($data['invite_id'])){

                     $this->response([
                      'code' => 400,
                      'status' => FALSE,
                      'message' => 'Invite id missing !'				
                    ], REST_Controller::HTTP_OK);

                   }

                   $where = array('invite_id' => $data['invite_id']);
                   $result = $this->db->get_where('invite',$where)->row();
                   if(!empty($result)){
                     $wheres = array(
                      'from_date_time' => $result->from_date_time,
                      'to_date_time' => $result->to_date_time,
                      'invite_to' => $data['user_id'],
                      'approved' => 1
                    );
                     $count = $this->db->get_where('invite',$wheres)->num_rows();
                     if($count != 0){
                      $this->response([
                       'code' => 400,
                       'status' => FALSE,
                       'message' => 'Already call approved on this request !'				
                     ], REST_Controller::HTTP_OK);

                    }

                  }else{

                   $this->response([
                    'code' => 400,
                    'status' => FALSE,
                    'message' => 'Invalid invite id!'				
                  ], REST_Controller::HTTP_OK);

                 }
               }

               Public function forgot_password_post()
               {		

                $datas = json_decode( file_get_contents( 'php://input' ), true );
                if(empty($datas)){
                 $datas = $this->input->post();
               }
               $email = $datas['email'];

               if(empty($email)){
                 $this->response([
                  'code' => 400,
                  'status' => FALSE,
                  'message' => 'Email id missing!'				
                ], REST_Controller::HTTP_OK);
               }

               $result = $this->db->query("SELECT * FROM `applicants` WHERE `email` = '".$email."' ORDER BY id DESC ")->row_array();
               if(sizeof($result)>0){
                 $password  = generateStrongPassword();
                 $this->db->where('email',$email);
                 $this->db->update('applicants',array('password'=>md5($password)));		

                 $name =  $result['first_name']." ".$result['last_name'];
                 $useremail=$result['email'];

                 $data['result'] = $result;
                 $data['password'] = $password;
                 $message = $this->load->view('home/pages/reset_password_view',$data,TRUE);

                 $to = $useremail;
                 $subject = 'Hey! '.$name.' Your Password has been Resetted ! ';
                 $headers = "MIME-Version: 1.0" . "\r\n";
                 $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                 $headers .= "From: Mentori Admin <info@mentori.ng>";

                 if(mail($to,$subject,$message,$headers)){

                  $this->response([
                   'code' => 200,
                   'status' => TRUE,
                   'message' => 'Your Password has been Resetted! Check your mail!'					
                 ], REST_Controller::HTTP_OK);				
                }
              }else{

               $this->response([
                'code' => 400,
                'status' => FALSE,
                'message' => 'Invalid email id!'				
              ], REST_Controller::HTTP_OK);

             }
           }


           Public function generate_session_id(){

            /* Generate a Session Id  */
            $opentok = new OpenTok($this->apiKey, $this->apiSecret);
        // An automatically archived session:
            $sessionOptions = array(
        // 'archiveMode' => ArchiveMode::ALWAYS,
             'mediaMode' => MediaMode::ROUTED
           );
            $new_session = $opentok->createSession($sessionOptions);
        // Store this sessionId in the database for later use
            return  $new_session->getSessionId();
          }




          /* Call From User 1 */
          Public function make_call_post(){

		// error_reporting(1);
            /*Input */
            $datas = json_decode( file_get_contents( 'php://input' ), true );
            if(empty($datas)){
             $datas = $this->input->post();
           }

           if(empty($datas['sender_id'])){
             $this->response([
              'code' => 400,
              'status' => FALSE,
              'message' => 'Sender id missing!',
              'data' => new stdClass()
            ], REST_Controller::HTTP_NOT_FOUND);
           }
           elseif(!empty($datas['sender_id'])){
             $call_status = $this->db->get_where('applicants',array('id'=>$datas['sender_id']))->row()->call_status;
             if($call_status == 1){
              $this->response([
               'code' => 400,
               'status' => FALSE,
               'message' => 'You are already in call !',
               'data' => new stdClass()
             ], REST_Controller::HTTP_NOT_FOUND);

            }
          }


          if(empty($datas['receiver_id'])){
           $this->response([
            'code' => 400,
            'status' => FALSE,
            'message' => 'Receiver id missing!',
            'data' => new stdClass()
          ], REST_Controller::HTTP_NOT_FOUND);
         }
         elseif(!empty($datas['receiver_id'])){
           $call_status = $this->db->get_where('applicants',array('id'=>$datas['receiver_id']))->row()->call_status;
           if($call_status == 1){
            $this->response([
             'code' => 400,
             'status' => FALSE,
             'message' => 'User already in call !',
             'data' => new stdClass()
           ], REST_Controller::HTTP_NOT_FOUND);

          }
        }

        if(empty($datas['type'])){
         $this->response([
          'code' => 400,
          'status' => FALSE,
          'message' => 'Type is missing!',
          'data' => new stdClass()
        ], REST_Controller::HTTP_NOT_FOUND);
       }if(empty($datas['invite_id'])){
         $this->response([
          'code' => 400,
          'status' => FALSE,
          'message' => 'Invite id missing!',
          'data' => new stdClass()
        ], REST_Controller::HTTP_NOT_FOUND);
       }



       $opentok = new OpenTok($this->apiKey, $this->apiSecret);
       $additional_data = array();	
       $result = $this->db->get_where('invite',array('invite_id'=>$datas['invite_id']))->row_array();
       if(!empty($result)){
         $sessionId =$result['session_id'];
         if(empty($sessionId)){
          $sessionId = $this->generate_session_id();
          $this->db->update('invite',array('session_id'=>$sessionId),array('invite_id'=>$datas['invite_id']));
        }

        $connectionMetaData = json_encode(array('invite_id'=>$datas['invite_id']));
		// Replace with the correct session ID:
        $my_token = $opentok->generateToken($sessionId,array('expireTime' => time()+(7 * 24 * 60 * 60), 'data' =>  $connectionMetaData));
        $additional_data += array('apiKey' => $this->apiKey,'sessionId' =>$sessionId , 'token' => $my_token);
      }else{

       $this->response([
        'code' => 400,
        'status' => FALSE,
        'message' => 'Invalid invite id!',
        'data' => new stdClass()
      ], REST_Controller::HTTP_NOT_FOUND);

     }

     /* Trigger the notification for web */
     $call = $this->db->get_where('call_details',array('invite_id'=>$datas['invite_id']))->row_array();
     if(!empty($call)){
       $this->db->delete('call_details',array('invite_id'=>$datas['invite_id']));
     }
     $data = array(
       'call_from' =>$datas['sender_id'],
       'call_to' =>$datas['receiver_id'],			
       'invite_id' =>$datas['invite_id'],
       'status' =>1,
       'channel' => base64_encode('test'),
       'start_by' =>$datas['sender_id'],
       'type' => $datas['type']			
     );	

     $this->db->insert('call_details',$data);


     /* Send push notification */

     $this->load->model('chat_model','chat');
     $data = $this->chat->get_player_id($datas['receiver_id']);
     $additional_data  +=	array(
       'from_name' => $this->get_full_name($datas['sender_id']),        
       'from_user_id' => $datas['sender_id'],			
       'from_username' => $this->get_users_name($datas['sender_id']),                			
       'from_profile_image' => $this->get_user_image($datas['sender_id']),           
       'type' => $datas['type'],
       'invite_id' => $datas['invite_id']
     );          

     $push_data['button'] = array(
       array('id'=>'answer','title'=>'Call From '.$additional_data['from_name'].'','text'=>'Answer','icon'=>""),
       array('id'=>'decline','title'=>'Call From '.$additional_data['from_name'].'','text'=>'Decline','icon'=>"")
     );  


     $push_data['user_id'] = $datas['sender_id'];
     $push_data['message'] = 'Notification';
     $push_data['include_player_ids'] = $data['device_id'];
     $push_data['additional_data'] = $additional_data;  
     send_button($push_data); 


     $this->response([
       'code' => 200,
       'status' => TRUE,
       'message' => 'New call made successfully!',
       'data' => $additional_data,
     ], REST_Controller::HTTP_OK); 



   }



   Public function update_call_status(){


    $datas = json_decode( file_get_contents( 'php://input' ), true );
    if(empty($datas)){
     $datas = $this->input->post();
   }



   if(empty($datas['sender_id'])){
     $this->response([
      'code' => 400,
      'status' => FALSE,
      'message' => 'Sender id missing!',
      'data' => new stdClass()
    ], REST_Controller::HTTP_NOT_FOUND);
   }


   if(empty($datas['receiver_id'])){
     $this->response([
      'code' => 400,
      'status' => FALSE,
      'message' => 'Receiver id missing!',
      'data' => new stdClass()
    ], REST_Controller::HTTP_NOT_FOUND);
   }
   if(empty($datas['status'])){
     $this->response([
      'code' => 400,
      'status' => FALSE,
      'message' => 'Status missing!',
      'data' => new stdClass()
    ], REST_Controller::HTTP_NOT_FOUND);
   }

   $data = $this->db->get_where('applicants',array('id'=>$datas['sender_id']))->row_array();
   if(empty($data)){
     $this->response([
      'code' => 400,
      'status' => FALSE,
      'message' => 'Invalid sender id!',				
    ], REST_Controller::HTTP_NOT_FOUND);
   }

   $data = $this->db->get_where('applicants',array('id'=>$datas['receiver_id']))->row_array();
   if(empty($data)){
     $this->response([
      'code' => 400,
      'status' => FALSE,
      'message' => 'Invalid receiver id!',				
    ], REST_Controller::HTTP_NOT_FOUND);
   }

   $this->db->update('applicants',array('call_status'=> $datas['status']),array('id' => $datas['sender_id']));
   $this->db->update('applicants',array('call_status'=> $datas['status']),array('id' => $datas['receiver_id']));

   $this->response([
     'code' => 200,
     'status' => TRUE,
     'message' => 'Call status updated successfully!'					

   ], REST_Controller::HTTP_OK); 



 }


 /* Decline Api */

 Public function decline_call_post(){

  $datas = json_decode( file_get_contents( 'php://input' ), true );
  if(empty($datas)){
   $datas = $this->input->post();
 }

 if(empty($datas['invite_id'])){
   $this->response([
    'code' => 400,
    'status' => FALSE,
    'message' => 'Invite id missing!'

  ], REST_Controller::HTTP_NOT_FOUND);
 }
 if(empty($datas['from_id'])){
   $this->response([
    'code' => 400,
    'status' => FALSE,
    'message' => 'From id missing!'

  ], REST_Controller::HTTP_NOT_FOUND);
 }
 if(empty($datas['to_id'])){
   $this->response([
    'code' => 400,
    'status' => FALSE,
    'message' => 'To id missing!'

  ], REST_Controller::HTTP_NOT_FOUND);
 }

 $call = $this->db->get_where('invite',array('invite_id'=>$datas['invite_id']))->row_array();




 if(!empty($call)){
   $this->db->delete('call_details',array('invite_id',$datas['invite_id']));	
 }else{

   $this->response([
    'code' => 400,
    'status' => FALSE,
    'message' => 'Invalid invite id!'				
  ], REST_Controller::HTTP_NOT_FOUND);
 }


		//decline_call 
 $this->load->model('chat_model','chat');
 $data = $this->chat->get_player_id($datas['to_id']);
 $additional_data['from_username'] = $this->get_users_name($datas['from_id']);                
 $additional_data['from_name'] = $this->get_full_name($datas['from_id']);                
 $additional_data['to_username'] = $this->get_users_name($datas['to_id']);  
 $push_data['user_id'] = $datas['to_id'];		
 $push_data['message'] = 'decline';		
 $push_data['include_player_ids'] = $data['device_id'];
 $push_data['additional_data'] = $additional_data;       
 $response = decline_call($push_data);



 $this->response([
   'code' => 200,
   'status' => TRUE,
   'message' => 'Call declined made successfully!'					

 ], REST_Controller::HTTP_OK); 


}




public function logout_post(){

  $datas = json_decode( file_get_contents( 'php://input' ), true );

  if(empty($datas)){
   $datas = $this->input->post();
 }

 if(empty($datas['user_id'])){
   $this->response([
    'code' => 400,
    'status' => FALSE,
    'message' => 'User id missing!'				
  ], REST_Controller::HTTP_NOT_FOUND);
 }


 $data = $this->db->get_where('applicants',array('id'=>$datas['user_id']))->row_array();

 if(!empty($data)){
   $this->db->delete('one_signal_device_details',array('user_id' => $datas['user_id']));	

   $this->response([
    'code' => 200,
    'status' => TRUE,
    'message' => 'Logged out successfully!',			
  ], REST_Controller::HTTP_OK); 

 }else{

   $this->response([
    'code' => 400,
    'status' => FALSE,
    'message' => 'Invalid user id!',				
  ], REST_Controller::HTTP_NOT_FOUND);
 }


}







/* Phase 2 */

Public function make_payment_post(){
  $response=array();
  $data = json_decode( file_get_contents( 'php://input' ), true );
  if(empty($data)){
   $data = $this->input->post();
 }
 if(empty($data['user_id'])){ /* Missing user id */

   $this->response([
    'code' => 400,
    'status' => FALSE,                
    'message' => 'User id missing!',
    'data' => $response
  ], REST_Controller::HTTP_NOT_FOUND);
 }
 if(empty($data['date'])){ /* Missing user id */

   $this->response([
    'code' => 400,
    'status' => FALSE,                
    'message' => 'Date is missing!',
    'data' => $response
  ], REST_Controller::HTTP_NOT_FOUND);
 } 

 $time_zones = array_map('strtolower',timezone_identifiers_list());

 if(!in_array(strtolower($data['time_zone']),$time_zones)){
   $this->response([
    'code' => 400,
    'status' => FALSE,                
    'message' => 'Invalid time zone!'        
  ], REST_Controller::HTTP_NOT_FOUND);

 }
}
Public function mentor_book_by_card_id_post(){  



    $response=array();
    $data = json_decode( file_get_contents( 'php://input' ), true );
    if(empty($data)){
      $data = $this->input->post();
    }




    if(empty($data['date'])){
      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Date is missing!'        
      ], REST_Controller::HTTP_NOT_FOUND);
    }




    if(empty($data['user_id'])){ /* Missing selected_user_id */

      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'User id missing!',
        'data' => $response
      ], REST_Controller::HTTP_NOT_FOUND);


    }  if(empty($data['selected_user_id'])){ /* Missing selected_user_id */

      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Selected user id missing!',
        'data' => $response
      ], REST_Controller::HTTP_NOT_FOUND);


    }

    if(!empty($data['selected_user_id'])){

      $where = array('id' => $data['selected_user_id']);
      $users  = $this->db->get_where('applicants',$where)->row_array();
      if(count($users) == 0){

        $this->response([
          'code' => 400,
          'status' => FALSE,
          'message' => 'Selected user id not valid !'            
        ], REST_Controller::HTTP_NOT_FOUND);


      }
    }

    if($data['time_zone'] == 'Asia/Calcutta'){
      $data['time_zone'] = 'Asia/kolkata';
    }

    $time_zones = array_map('strtolower',timezone_identifiers_list());


    if(!in_array(strtolower($data['time_zone']),$time_zones)){
      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Invalid time zone!'        
      ], REST_Controller::HTTP_NOT_FOUND);

    }

    if(empty($data['card_id'])){        
      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Card id missing!'         
      ], REST_Controller::HTTP_NOT_FOUND);        
    }

      $mentor_details = $this->db
                  ->join('applicants a','a.id = m.mentor_id','LEFT')
                  ->get_where('mentor_details m',array('mentor_id'=>$data['selected_user_id']))
                  ->row_array();


    if(empty($mentor_details)){

      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Selected user id is not mentor!'
      ], REST_Controller::HTTP_NOT_FOUND);

    }



    /* Getting booking data */
    if(!empty($data['bookingdata'])){

      $date = date('Y-m-d',strtotime($data['date']));
      $selected_user_id = $data['selected_user_id'];
      $user_id = $data['user_id'];
      $time_zone = $data['time_zone'];


      $results = $this->db                    
      ->get_where('applicants a',array('a.id'=>$user_id))
      ->row_array();

      $first_name = $results['first_name'];
      $last_name = $results['last_name'];

      $bookingdata = $data['bookingdata']; 




      $where = array('card_id' => $data['card_id']);
      $customer = $this->db->get_where('card_details',$where)->row();  

      if(empty($customer)){       
        $this->response([
          'code' => 400,
          'status' => FALSE,                
          'message' => 'Invalid card id!'         
        ], REST_Controller::HTTP_OK);       
      }



      foreach ($bookingdata as $key => $value) {

        $start_time = date('H:i:s',strtotime($value['from_time']));
        $end_time = date('H:i:s',strtotime($value['to_time']));

       $per_hour_charge =  $mentor_details['hourly_rate'];
            $tax_amount = ($per_hour_charge * GST)/100;       
            $tax_amount = number_format($tax_amount,2);
            $total_amount = $per_hour_charge + $tax_amount;
            $total_amount =number_format($total_amount,2);

          $invitedata = array(
            'from_date_time'=> $date.' '.$start_time,
            'to_date_time' => $date.' '.$end_time,
            'invite_from' => $user_id,
            'invite_to' => $selected_user_id,
            'message' => 'You have new invitation request from '.$first_name.' '.$last_name,
            'invite_date' => $date,
            'invite_time' => $start_time,
            'invite_end_time' => $end_time,
            'paid' => 0,
            'time_zone' => $time_zone,
          'per_hour_charge' => $per_hour_charge,
          'tax_percentage' => GST,        
          'tax_amount' => $tax_amount,
          'total_hours_charge' => $total_amount
        );

          $this->db->insert('invite',$invitedata);
          $insert_id = $this->db->insert_id();

  
          $handling_charge = ( $per_hour_charge * 20 )  / 100;
          $payable_charge = $per_hour_charge - $handling_charge;



      // Payment Details
         $data = array(
            'user_id' => $user_id,
            'mentor_id' => $selected_user_id,
            'payment_status' => 0,
            'payment_gross' => $total_amount,
            'payment_date' => date('Y-m-d H:i:s'),
            'currency_code' => 'USD',
            'source' =>'stripe',     
            'invite_id' => $insert_id,
            'currency_code' => 'USD',
            'source' =>'stripe',
                'stripe_customer_id' => $customer->customer_id,
          'card_last_digits' => $customer->card,            
            'transaction_type'=>'CREDIT',
            'per_hour_charge' => $per_hour_charge,
            'role_type' => 'mentee'
          );
          $this->db->insert('payments',$data);  

            $data = array(
            'user_id' => $user_id,
            'mentor_id' => $selected_user_id,
            'payment_status' => 0,
            'payment_gross' => $total_amount,
            'payment_date' => date('Y-m-d H:i:s'),
            'currency_code' => 'USD',
            'source' =>'stripe',     
            'invite_id' => $insert_id,
            'currency_code' => 'USD',
            'source' =>'stripe',
              'stripe_customer_id' => $customer->customer_id,
          'card_last_digits' => $customer->card,            
            'transaction_type'=>'DEBIT',
            'per_hour_charge' => $per_hour_charge,
            'handling_charge' => $handling_charge,
            'role_type' => 'mentor'
          );
          $this->db->insert('payments',$data);  

            $data = array(
            'user_id' => $user_id,
            'mentor_id' => $selected_user_id,
            'payment_status' => 0,
            'payment_gross' => $total_amount,
            'payment_date' => date('Y-m-d H:i:s'),
            'currency_code' => 'USD',
            'source' =>'stripe',     
            'invite_id' => $insert_id,
            'currency_code' => 'USD',
            'source' =>'stripe',
              'stripe_customer_id' => $customer->customer_id,
          'card_last_digits' => $customer->card,            
            'per_hour_charge' => $per_hour_charge,
            'handling_charge' => $handling_charge,
            'payable_charge' => $payable_charge,
            'role_type' => 'mentor'
          );
          $this->db->insert('payments',$data);

      
      $notify_data = array(
          'user_id' => $selected_user_id,
          'notification_id' => $user_id,
          'text' => $first_name.' '.$last_name.' invited you with premium',
          'read' => 0,
          'invite_id' => $insert_id,
          'created_date' => date('Y-m-d H:i:s'),
          'mentor_message'=> "You have a call request from <a href='".base_url()."mentor-profile/".$mentor_details['username']."'>".$mentor_details['first_name']." ".$mentor_details['last_name'].'</a>',
          'mentee_message'=> "You request a call to <a href='".base_url()."mentee-profile/".$results['username']."'>".$results['first_name']." ".$results['last_name'].'</a>',
          'mentor_view'=> 1,
          'mentee_view'=> 1,
          'time_zone' =>$time_zone
          );

          $response =   $this->db->insert('notifications',$notify_data);  


      }

      $this->response([
        'code' => 200,
        'status' => TRUE,                
        'message' => 'Booking made successfully!'      
      ], REST_Controller::HTTP_OK); 


    }

    else{

      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Booking data missing!',
        'data' => $response
      ], REST_Controller::HTTP_NOT_FOUND);

    }




  }



  Public function mentor_book_by_card_post(){ 



    $response=array();
    $data = json_decode( file_get_contents( 'php://input' ), true );
    if(empty($data)){
      $data = $this->input->post();
    }

    if(!empty($data['card_id'])){
      $this->mentor_book_by_card_id_post();
      exit;
    }


    if(empty($data['date'])){
      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Date is missing!'        
      ], REST_Controller::HTTP_NOT_FOUND);
    }




    if(empty($data['user_id'])){ /* Missing selected_user_id */

      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'User id missing!',
        'data' => $response
      ], REST_Controller::HTTP_NOT_FOUND);


    }  if(empty($data['selected_user_id'])){ /* Missing selected_user_id */

      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Selected user id missing!',
        'data' => $response
      ], REST_Controller::HTTP_NOT_FOUND);


    }

    if(!empty($data['selected_user_id'])){

      $where = array('id' => $data['selected_user_id']);
      $users  = $this->db->get_where('applicants',$where)->row_array();
      if(count($users) == 0){

        $this->response([
          'code' => 400,
          'status' => FALSE,
          'message' => 'Selected user id not valid !'            
        ], REST_Controller::HTTP_NOT_FOUND);


      }
    }

    if($data['time_zone'] == 'Asia/Calcutta'){
      $data['time_zone'] = 'Asia/kolkata';
    }

    $time_zones = array_map('strtolower',timezone_identifiers_list());


    if(!in_array(strtolower($data['time_zone']),$time_zones)){
      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Invalid time zone!'        
      ], REST_Controller::HTTP_NOT_FOUND);

    }

    if(empty($data['card_number'])){ /* Missing selected_user_id */

      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Card number missing!'           
      ], REST_Controller::HTTP_NOT_FOUND);


    }

    if(empty($data['exp_month'])){ /* Missing selected_user_id */

      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Exp month missing!'           
      ], REST_Controller::HTTP_NOT_FOUND);


    }

    if(empty($data['exp_year'])){ /* Missing selected_user_id */

      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Exp year missing!'
      ], REST_Controller::HTTP_NOT_FOUND);


    }

    if(empty($data['cvv'])){ /* Missing selected_user_id */

      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'CVV missing!'           
      ], REST_Controller::HTTP_NOT_FOUND);


    }

    if(empty($data['email'])){ /* Missing selected_user_id */

      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Email is missing!'            
      ], REST_Controller::HTTP_NOT_FOUND);


    }

    $mentor_details = $this->db
                  ->join('applicants a','a.id = m.mentor_id','LEFT')
                  ->get_where('mentor_details m',array('mentor_id'=>$data['selected_user_id']))
                  ->row_array();


    if(empty($mentor_details)){

      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Selected user id is not mentor!'
      ], REST_Controller::HTTP_NOT_FOUND);

    }


    /* Getting booking data */
    if(!empty($data['bookingdata'])){

      $date = date('Y-m-d',strtotime($data['date']));
      $selected_user_id = $data['selected_user_id'];
      $user_id = $data['user_id'];
      $time_zone = $data['time_zone'];


      $results = $this->db                    
      ->get_where('applicants a',array('a.id'=>$user_id))
      ->row_array();

      $first_name = $results['first_name'];
      $last_name = $results['last_name'];

      $bookingdata = $data['bookingdata']; 

      $card_last_digits = substr($data['card_number'], -4);


      

      try{

        \Stripe\Stripe::setApiKey($this->stripe_secret_key);
        //sk_test_8w0QeeKXNWn3hqKRNXzBtwRd

        /* Create a Token */

        $token = \Stripe\Token::create(array(
          "card" => array(
            "number" => $data['card_number'],
            "exp_month" => $data['exp_month'],
            "exp_year" => $data['exp_year'],
            "cvc" => $data['cvv']
          )
        ));

        $res =  json_encode($token);
        $result =  json_decode($res);



    // Create a Customer:
        $customer = \Stripe\Customer::create(array(
          "email" => $data['email'],      
          "source" => $result->id
        ));



        $datas = array(
          'type'=>$result->card->brand,
          'card' => $card_last_digits,
          'user_id' =>$data['user_id'],
          'customer_id' => $customer->id
        );
        $this->db->insert('card_details',$datas);  



        foreach ($bookingdata as $key => $value) {

          $start_time = date('H:i:s',strtotime($value['from_time']));
          $end_time = date('H:i:s',strtotime($value['to_time']));

            $per_hour_charge =  $mentor_details['hourly_rate'];
            $tax_amount = ($per_hour_charge * GST)/100;       
            $tax_amount = number_format($tax_amount,2);
            $total_amount = $per_hour_charge + $tax_amount;
            $total_amount =number_format($total_amount,2);

          $invitedata = array(
            'from_date_time'=> $date.' '.$start_time,
            'to_date_time' => $date.' '.$end_time,
            'invite_from' => $user_id,
            'invite_to' => $selected_user_id,
            'message' => 'You have new invitation request from '.$first_name.' '.$last_name,
            'invite_date' => $date,
            'invite_time' => $start_time,
            'invite_end_time' => $end_time,
            'paid' => 0,
            'time_zone' => $time_zone,
          'per_hour_charge' => $per_hour_charge,
          'tax_percentage' => GST,        
          'tax_amount' => $tax_amount,
          'total_hours_charge' => $total_amount
        );

          $this->db->insert('invite',$invitedata);
          $insert_id = $this->db->insert_id();




          $handling_charge = ( $per_hour_charge * 20 )  / 100;
          $payable_charge = $per_hour_charge - $handling_charge;



      // Payment Details
         $data = array(
            'user_id' => $user_id,
            'mentor_id' => $selected_user_id,
            'payment_status' => 0,
            'payment_gross' => $total_amount,
            'payment_date' => date('Y-m-d H:i:s'),
            'currency_code' => 'USD',
            'source' =>'stripe',     
            'invite_id' => $insert_id,
            'currency_code' => 'USD',
            'source' =>'stripe',
            'stripe_customer_id' => $customer->id,
            'card_last_digits' => $card_last_digits,
            'transaction_type'=>'CREDIT',
            'per_hour_charge' => $per_hour_charge,
            'role_type' => 'mentee'
          );
          $this->db->insert('payments',$data);  

            $data = array(
            'user_id' => $user_id,
            'mentor_id' => $selected_user_id,
            'payment_status' => 0,
            'payment_gross' => $total_amount,
            'payment_date' => date('Y-m-d H:i:s'),
            'currency_code' => 'USD',
            'source' =>'stripe',     
            'invite_id' => $insert_id,
            'currency_code' => 'USD',
            'source' =>'stripe',
            'stripe_customer_id' => $customer->id,
            'card_last_digits' => $card_last_digits,
            'transaction_type'=>'DEBIT',
            'per_hour_charge' => $per_hour_charge,
            'handling_charge' => $handling_charge,
            'role_type' => 'mentor'
          );
          $this->db->insert('payments',$data);  

            $data = array(
            'user_id' => $user_id,
            'mentor_id' => $selected_user_id,
            'payment_status' => 0,
            'payment_gross' => $total_amount,
            'payment_date' => date('Y-m-d H:i:s'),
            'currency_code' => 'USD',
            'source' =>'stripe',     
            'invite_id' => $insert_id,
            'currency_code' => 'USD',
            'source' =>'stripe',
            'stripe_customer_id' => $customer->id,
            'card_last_digits' => $card_last_digits,
            'per_hour_charge' => $per_hour_charge,
            'handling_charge' => $handling_charge,
            'payable_charge' => $payable_charge,
            'role_type' => 'mentor'
          );
          $this->db->insert('payments',$data);

      
      $notify_data = array(
          'user_id' => $selected_user_id,
          'notification_id' => $user_id,
          'text' => $first_name.' '.$last_name.' invited you with premium',
          'read' => 0,
          'invite_id' => $insert_id,
          'created_date' => date('Y-m-d H:i:s'),
          'mentor_message'=> "You have a call request from <a href='".base_url()."mentor-profile/".$mentor_details['username']."'>".$mentor_details['first_name']." ".$mentor_details['last_name'].'</a>',
          'mentee_message'=> "You request a call to <a href='".base_url()."mentee-profile/".$results['username']."'>".$results['first_name']." ".$results['last_name'].'</a>',
          'mentor_view'=> 1,
          'mentee_view'=> 1,
          'time_zone' =>$time_zone
          );

          $response =   $this->db->insert('notifications',$notify_data);  


        }

        $this->response([
          'code' => 200,
          'status' => TRUE,                
          'message' => 'Booking made successfully!'      
        ], REST_Controller::HTTP_OK);




      } catch (Stripe_CardError $e) {

        $this->response([
          'code' => 400,
          'status' => FALSE,                
          'message' => 'Invalid Card Details!'    
        ], REST_Controller::HTTP_OK);

      } catch (Stripe_InvalidRequestError $e) {
            // Invalid parameters were supplied to Stripe's API  
        $this->response([
          'code' => 400,
          'status' => FALSE,                
          'message' =>$e->getMessage()  
        ], REST_Controller::HTTP_OK);  
      } catch (Stripe_AuthenticationError $e) {
            // Authentication with Stripe's API failed  
        $this->response([
          'code' => 400,
          'status' => FALSE,                
          'message' => AUTHENTICATION_STRIPE_FAILED    
        ], REST_Controller::HTTP_OK);  
      } catch (Stripe_ApiConnectionError $e) {
            // Network communication with Stripe failed  
        $this->response([
          'code' => 400,
          'status' => FALSE,                
          'message' => NETWORK_STRIPE_FAILED    
        ], REST_Controller::HTTP_OK);  
      } catch (Stripe_Error $e) {
            // Display a very generic error to the user, and maybe send   
        $this->response([
          'code' => 400,
          'status' => FALSE,                
          'message' => 'Invalid Card Details!'    
        ], REST_Controller::HTTP_OK);  
      } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe   
        $this->response([
          'code' => 400,
          'status' => FALSE,                
          'message' => 'Invalid Card Details!'    
        ], REST_Controller::HTTP_OK);  
      }   


    }

    else{

      $this->response([
        'code' => 400,
        'status' => FALSE,                
        'message' => 'Booking data missing!',
        'data' => $response
      ], REST_Controller::HTTP_NOT_FOUND);

    }




  }


Public function mentor_book_appointment_post(){


  $response=array();
  $data = json_decode( file_get_contents( 'php://input' ), true );
  if(empty($data)){
   $data = $this->input->post();
 }
  // echo '<pre>';print_r($data); exit;

 if(empty($data['date'])){
   $this->response([
    'code' => 400,
    'status' => FALSE,                
    'message' => 'Date is missing!'        
  ], REST_Controller::HTTP_NOT_FOUND);
 }




 if(empty($data['user_id'])){ /* Missing selected_user_id */

   $this->response([
    'code' => 400,
    'status' => FALSE,                
    'message' => 'User id missing!',
    'data' => $response
  ], REST_Controller::HTTP_NOT_FOUND);


 }  if(empty($data['selected_user_id'])){ /* Missing selected_user_id */

   $this->response([
    'code' => 400,
    'status' => FALSE,                
    'message' => 'Selected user id missing!',
    'data' => $response
  ], REST_Controller::HTTP_NOT_FOUND);


 }

 if(!empty($data['selected_user_id'])){

   $where = array('id' => $data['selected_user_id']);
   $users  = $this->db->get_where('applicants',$where)->row_array();
   if(count($users) == 0){

    $this->response([
     'code' => 400,
     'status' => FALSE,
     'message' => 'Selected user id not valid !'            
   ], REST_Controller::HTTP_NOT_FOUND);


  }
}

if($data['time_zone'] == 'Asia/Calcutta'){
 $data['time_zone'] = 'Asia/kolkata';
}

$time_zones = array_map('strtolower',timezone_identifiers_list());


if(!in_array(strtolower($data['time_zone']),$time_zones)){
 $this->response([
  'code' => 400,
  'status' => FALSE,                
  'message' => 'Invalid time zone!'        
], REST_Controller::HTTP_NOT_FOUND);

}




/* Getting booking data */
if(!empty($data['bookingdata'])){

 $date = date('Y-m-d',strtotime($data['date']));
 $selected_user_id = $data['selected_user_id'];
 $user_id = $data['user_id'];
 $time_zone = $data['time_zone'];


 $results = $this->db                    
 ->get_where('applicants a',array('a.id'=>$user_id))
 ->row_array();

 $first_name = $results['first_name'];
 $last_name = $results['last_name'];

 $bookingdata = $data['bookingdata']; 

 foreach ($bookingdata as $key => $value) {

  $start_time = date('H:i:s',strtotime($value['from_time']));
  $end_time = date('H:i:s',strtotime($value['to_time']));

  $invitedata = array(
   'from_date_time'=> $date.' '.$start_time,
   'to_date_time' => $date.' '.$end_time,
   'invite_from' => $user_id,
   'invite_to' => $selected_user_id,
   'message' => 'You have new invitation request from '.$first_name.' '.$last_name,
   'invite_date' => $date,
   'invite_time' => $start_time,
   'invite_end_time' => $end_time,
   'paid' => 0,
   'time_zone' => $time_zone
 );

  $this->db->insert('invite',$invitedata);
  $insert_id = $this->db->insert_id();

      // Payment Details
  $data = array(
   'user_id' => $user_id,
   'mentor_id' => $selected_user_id,
   'payment_status' => 0,
   'payment_gross' => 0,
   'payment_date' => date('Y-m-d H:i:s'),
   'currency_code' => 'USD',
   'source' =>'stripe',     
   'invite_id' => $insert_id
 );
  $this->db->insert('payments',$data);
  $payment_id = $this->db->insert_id();

  $notify_data = array(
   'user_id' => $selected_user_id,
   'notification_id' => $user_id,
   'text' => $first_name.' '.$last_name.' invited you with premium',
   'read' => 0,
   'invite_id' => $insert_id,
   'created_date' => date('Y-m-d H:i:s')
 );
  $response =   $this->db->insert('notifications',$notify_data);




}

$this->response([
  'code' => 200,
  'status' => TRUE,                
  'message' => 'Booking made successfully!'      
], REST_Controller::HTTP_OK);


}else{

 $this->response([
  'code' => 400,
  'status' => FALSE,                
  'message' => 'Booking data missing!',
  'data' => $response
], REST_Controller::HTTP_NOT_FOUND);

}

}



Public function get_payment_settings_get(){
  $response = new stdClass();

  $response = $this->db->select('gateway_name,publish_key_test,publish_key_live,status')->get('payment_settings')->row_array();
  if(empty($response)){
   $this->response([
    'code' => 200,
    'status' => TRUE,                
    'message' => 'No  settings available!',
    'data' => $response
  ], REST_Controller::HTTP_OK);
 }else{

   $this->response([
    'code' => 200,
    'status' => TRUE,                
    'message' => 'Settings retrieved successfully!',
    'data' => $response
  ], REST_Controller::HTTP_OK);
 }

}

Public function get_cards_post(){

  $response=array();

  $data = json_decode( file_get_contents( 'php://input' ), true );
  if(empty($data)){
   $data = $this->input->post();
 }    
 if(empty($data['user_id'])){ /* Missing user id */
   $this->response([
    'code' => 400,
    'status' => FALSE,                
    'message' => 'User id missing!'        
  ], REST_Controller::HTTP_NOT_FOUND);
 }
 if(!empty($data['user_id'])){

   $count = $this->db->get_where('applicants',array('id'=>$data['user_id']))->num_rows();
   if($count == 0){

    $this->response([
     'code' => 400,
     'status' => FALSE,                
     'message' => 'Invalid User id!'        
   ], REST_Controller::HTTP_NOT_FOUND);

  }



}


$where = array('user_id' => $data['user_id']);
$response  = $this->db
->group_by('card')
->order_by('card_id','desc')
->select('card_id,card,type')
->get_where('card_details',$where)
->result();

if(!empty($response)){

 $this->set_response([
  'status' => TRUE,
  'code' => 200,            
  'message' => 'Cards retrieved successfully!',    
  'data'=>$response
], REST_Controller::HTTP_OK);  


}else{

 $this->set_response([
  'status' => TRUE,
  'code' => 200,            
  'message' => 'No cards!',    
  'data'=>$response
], REST_Controller::HTTP_OK);  

}
}








Public function get_subjects_get(){         
  $where = array('s.status'=>1);
    $response =  $this->db->select('s.subject_id,s.subject') //,c.course_id,c.course
                           //->join('courses c','c.subject_id = s.subject_id')
    ->get_where('subject s',$where)
    ->result_array();  

    if(empty($response)){

    	$this->response([
    		'code' => 400,
    		'status' => FALSE,                
    		'message' => 'No subjects!',
    		'data' => $response
    	], REST_Controller::HTTP_OK);
    }else{

    	$this->set_response([
    		'status' => TRUE,
    		'code' => 200,            
    		'message' => 'Subjects retrieved successfully!',
    		'data' =>$response
    	], REST_Controller::HTTP_OK);  


    }
  }



  Public function get_course_post(){    

   $response=array();
   $data = json_decode( file_get_contents( 'php://input' ), true );
   if(empty($data)){
    $data = $this->input->post();
  }




  if(empty($data['subject_id'])){ /* Missing user id */

    $this->response([
     'code' => 400,
     'status' => FALSE,                
     'message' => 'Subject id missing!',
     'data' => $response
   ], REST_Controller::HTTP_NOT_FOUND);


  }else{     
    $where = array('c.status'=>1,'c.subject_id'=>$data['subject_id']);
    $response =  $this->db->select('c.course_id,c.course')                            
    ->get_where('courses c',$where)
    ->result_array();  

    if(empty($response)){

     $this->response([
      'code' => 400,
      'status' => FALSE,                
      'message' => 'No courses!',
      'data' => $response
    ], REST_Controller::HTTP_OK);
   }else{

     $this->set_response([
      'status' => TRUE,
      'code' => 200,            
      'message' => 'Courses retrieved successfully!',
      'data' =>$response
    ], REST_Controller::HTTP_OK);  


   }
 }
}



/*Get Logged in user profile */
Public function  view_profile_post(){

	$response=array();
	$data = json_decode( file_get_contents( 'php://input' ), true );
	if(empty($data)){
		$data = $this->input->post();
	}    

	if(empty($data['user_id'])){ /* Missing user id */

		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'User id missing!',
			'data' => $response
		], REST_Controller::HTTP_NOT_FOUND);


	}


	$l = $this->api->get_profile_data($data['user_id']);

	if(empty($l)){

		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'No users!',
			'data' => $response
		], REST_Controller::HTTP_OK);
	}else{            

		$mentor['user_id']=!empty($l['user_id'])?$l['user_id']:'';
		$mentor['first_name']=!empty($l['first_name'])?$l['first_name']:'';
		$mentor['last_name']=!empty($l['last_name'])?$l['last_name']:'';
		$mentor['username']=!empty($l['username'])?$l['username']:'';
		$mentor['profile_img']=$this->get_user_image($l['user_id']);
		$mentor['email']=!empty($l['email'])?$l['email']:'';
		if(!empty($l['mobile_number']) && $l['mobile_number'] !=null){
			$mentor['mobile_number']=$l['mobile_number'];
		}else{
			$mentor['mobile_number']='';
		}  
		if(!empty($l['gender'])){

			if($l['gender'] == 1){
				$mentor['gender']='Male';
			}else{
				$mentor['gender']='Female';
			}

		}else{
			$mentor['gender']='';
		}


		$mentor['address_line1']=!empty($l['address_line1'])?$l['address_line1']:'';
		$mentor['address_line2']=!empty($l['address_line2'])?$l['address_line2']:'';
		$mentor['city']=!empty($l['city'])?$l['city']:'';
		$mentor['state']=!empty($l['state'])?$l['state']:'';
		$mentor['country']=!empty($l['country'])?$l['country']:'';
		$mentor['postal_code']=!empty($l['postal_code'])?$l['postal_code']:'';
		$mentor['under_college']=!empty($l['under_college'])?$l['under_college']:'';
		$mentor['under_major']=!empty($l['under_major'])?$l['under_major']:'';
		$mentor['graduate_college']=!empty($l['graduate_college'])?$l['graduate_college']:'';
		$mentor['type_of_degree']=!empty($l['degree'])?$l['degree']:'';
		$mentor['personal_message'] = !empty($l['mentor_personal_message'])?$l['mentor_personal_message']:'';    
		$mentor['dob']=($l['dob']!='0000-00-00' && $l['dob']!='1970-01-01' && !empty($l['dob']))?date('d-m-Y',strtotime($l['dob'])):'';



		$mentor['course'] = $this->get_course_details($l['user_id']);

		if($l['role'] == 1){

			$mentor['type'] = "mentor";
			if($l['charge_type'] == 'charge' ){ 
				$mentor['is_free']=false;                            
				$mentor['hourly_rate']=$l['hourly_rate'];                                            
			}else{ 
				$mentor['is_free']=true;                            
				$mentor['hourly_rate']='0.00';                                             
			}			

    // $mentor['rating_count']=!empty($l['rating_count'])?$l['rating_count']:'0';
    // $mentor['rating_value']=!empty($l['rating_value'])?$l['rating_value']:'0';    
		} elseif($l['role'] == 0){
			$mentor['type'] = "mentee";
		}



		$this->set_response([
			'status' => TRUE,
			'code' => 200,            
			'message' => 'User details retrieved successfully!',
			'data' =>$mentor
		], REST_Controller::HTTP_OK);  




	}
}




/* Get Available time */
Public function get_available_time_post(){

	$response=array();
	$final_result=array();

	$data = json_decode( file_get_contents( 'php://input' ), true );
	if(empty($data)){
		$data = $this->input->post();
	}    


	if($data['time_zone'] == 'Asia/Calcutta'){
		$data['time_zone'] = 'Asia/kolkata';
	}

	$time_zones = array_map('strtolower',timezone_identifiers_list());


	if(!in_array(strtolower($data['time_zone']),$time_zones)){
		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'Invalid time zone!'        
		], REST_Controller::HTTP_NOT_FOUND);

	}

	if(empty($data['user_id'])){ /* Missing user id */
		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'User id missing!'        
		], REST_Controller::HTTP_NOT_FOUND);
	}
	if(empty($data['time_zone'])){ /* Missing user id */
		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'Time zone missing!'        
		], REST_Controller::HTTP_NOT_FOUND);
	}

	if(empty($data['date'])){ /* Missing user id */
		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'Date is missing!'        
		], REST_Controller::HTTP_NOT_FOUND);
	}

	date_default_timezone_set($data['time_zone']);
	$date = date('Y-m-d',strtotime($data['date']));
	$day = date('l',strtotime($data['date']));    
	$day_id =  $this->get_day_id($day);

	$result = $this->api->get_available_times($data['user_id'],$day_id);

	
	$available_data = $this->api->get_guru_available_data($data['user_id'],$data['time_zone'],$date);
 // echo '<pre>'; print_r($result); 
 // echo '<pre>'; print_r($available_data); 
 // exit;.
	$to_timezone = $data['time_zone'];
	$final_result= array();

	foreach ($result as $key => $value) { 				 
		$explode_4 = explode(',',$value['available']);
		if(is_array($explode_4)){
			foreach ($explode_4 as $index4 => $indexvalue4) {
				$explode_single4 = explode('-', $indexvalue4);
				$rep_start4 = str_replace('["',"", $explode_single4[0]);
				$rep_end4 = str_replace('"]',"", $explode_single4[1]);
				$rep_start4 = str_replace('"',"", $rep_start4);
				$rep_end4 = str_replace('"',"", $rep_end4);


				$class =  $this->get_booked_class($available_data,$rep_start4,$rep_end4,$day_id,$to_timezone,$date); 

				if(date('Y-m-d H') <= date('Y-m-d H',strtotime($date.' '.$rep_start4))){

					$date_time = date('h:i a',strtotime($rep_start4)).' - '.date('h:i a',strtotime($rep_end4));
					$final_result[]= array(
						'date_time' => $date_time,
						'from_date_time'=>date('Y-m-d h:i a',strtotime($date.' '.$rep_start4)),
						'from_time'=>date('h:i a',strtotime($rep_start4)),
						'to_time'=>date('h:i a',strtotime($rep_end4)),
						'booked' => $class,
						'is_checked' => false					

					); 
				}

			}			
		}				
	}

	foreach($final_result as $key => $val){
		$time[$key] = $val['from_date_time'];       
	}    			
	//array_multisort($time, SORT_ASC, $final_result);




	if(!empty($final_result)){

		$this->set_response([
			'status' => TRUE,
			'code' => 200,            
			'message' => 'Available timing retrieved successfully!',    
			'data'=>$final_result
		], REST_Controller::HTTP_OK);  

	}else{

		$this->set_response([
			'status' => TRUE,
			'code' => 200,            
			'message' => 'No available time!',    
			'data'=>$final_result
		], REST_Controller::HTTP_OK);  

	}






}

public function get_booked_class($availabe_days,$start_time,$end_time,$day_value,$to_timezone,$date)
{



	
	$class = false;
	if(!empty($availabe_days))
	{
		foreach ($availabe_days as $key => $value) {

			$from_timezone = $value['time_zone'];    
			$from_time = $value['invite_date'].' '.$value['invite_time'];
			$to_time = $value['invite_date'].' '.$value['invite_end_time'];
			$from_date_time  = $this->converToTz($from_time,$to_timezone,$from_timezone);
			$to_date_time = $this->converToTz($to_time,$to_timezone,$from_timezone);        

			if( date('H:i:s',strtotime($from_time)) == date('H:i:s',strtotime($start_time))
				&& date('H:i:s',strtotime($to_time))== date('H:i:s',strtotime($end_time)) 
				&& date('Y-m-d', strtotime($from_time)) ==date('Y-m-d', strtotime($date))
				&& $value['cancelled'] == 0){
				$class =true;
		}
	}
}
return $class;
}




public function get_day_id($day){

	switch ($day) {
		case 'Sunday':
		return 1;
		break;
		case 'Sunday':
		return 1;
		break;
		case 'Monday':
		return 2;
		break;
		case 'Tuesday':
		return 3;
		break;
		case 'Wednesday':
		return 4;
		break;
		case 'Thursday':
		return 5;
		break;
		case 'Friday':
		return 6;
		break;   
		case 'Saturday':
		return 7;
		break;       

	}

}


/* Update Profile */
Public function update_profile_post(){

	$response=array();
	$data = json_decode( file_get_contents( 'php://input' ), true );
	if(empty($data)){
		$data = $this->input->post();
	}    



	if(empty($data['user_id'])){ /* Missing user id */

		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'User id missing!'        
		], REST_Controller::HTTP_NOT_FOUND);


	}else{
		$result = $this->db->get_where('applicants',array('id'=>$data['user_id']))->row_array();
		if(count($result) == 0){
			$this->response([
				'code' => 400,
				'status' => FALSE,                
				'message' => 'User id not valid!',
				'data' => new stdClass()
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	$updates = array();


	if(!empty($_FILES['profile_image'])){

		$imageFileType = strtolower(pathinfo(basename($_FILES['profile_image']['name']),PATHINFO_EXTENSION));


		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {

			$this->response([
				'code' => 400,
				'status' => FALSE,                
				'message' => 'Only jpg, jpeg,png & gif files are allowed!'            
			], REST_Controller::HTTP_NOT_FOUND);         

	}else{      
		$config['upload_path']          = './assets/images/';
		$config['allowed_types']        = '*';
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('profile_image')){
			$file =  $this->upload->display_errors();                        
		}
		else{
			$file = $this->upload->data();  
			$app['profile_img']=$file['file_name'];                      
		}
	}
}


/* Update other fields */
$user_id=$data['user_id'];

$app['first_name']=!empty($data['first_name'])?$data['first_name']:'';
$app['last_name']=!empty($data['last_name'])?$data['last_name']:'';
$this->db->update('applicants',$app,array('id'=>$user_id));



$updates['address_line1']=!empty($data['address_line1'])?$data['address_line1']:'';
$updates['address_line2']=!empty($data['address_line2'])?$data['address_line2']:'';
$updates['city']=!empty($data['city'])?$data['city']:'';
$updates['state']=!empty($data['state'])?$data['state']:'';
$updates['country']=!empty($data['country'])?$data['country']:'';
$updates['postal_code']=!empty($data['postal_code'])?$data['postal_code']:'';
$updates['under_college']=!empty($data['under_college'])?$data['under_college']:'';
$updates['under_major']=!empty($data['under_major'])?$data['under_major']:'';
$updates['graduate_college']=!empty($data['graduate_college'])?$data['graduate_college']:'';
$updates['degree']=!empty($data['degree'])?$data['degree']:'';
$updates['mentor_personal_message'] = !empty($data['mentor_personal_message'])?$data['mentor_personal_message']:'';

if(!empty($data['gender'])){

	if(strtolower($data['gender']) == 'male'){
		$updates['mentor_gender']=1;
	}elseif(strtolower($data['gender']) == 'female'){
		$updates['mentor_gender']=2;
	}

}else{
	$updates['mentor_gender']='';
}    

if($data['charge_type'] == 'charge' ){ 
	$updates['charge_type']='charge';                    
	$updates['hourly_rate']=$data['hourly_rate'];                                            
}else{  
	$updates['charge_type']='free';                    
	$updates['hourly_rate']='0.00';                                                   
}

$updates['dob']=($data['dob']!='0000-00-00')?date('Y-m-d',strtotime($data['dob'])):'';


$where = array('mentor_id' => $user_id);
$count = $this->db->get_where('mentor_details',$where)->num_rows();

if($count == 0){
	$updates['mentor_id']=$user_id;
	$this->db->insert('mentor_details',$updates);
}else{

	$this->db->update('mentor_details',$updates,array('mentor_id'=>$user_id));    
}

$image  = $this->db->get_where('applicants',array('id'=>$user_id))->row_array();
if(!empty($image['profile_img'])){
	$data +=array('profile_img' => $image['profile_img']);
}


$this->set_response([
	'status' => TRUE,
	'code' => 200,            
	'message' => 'Profile updated successfully!',
	'data'=>$data    
], REST_Controller::HTTP_OK);  



}
/* Get Mentor view profile */
Public function get_profile_post(){    

	$response=array();
	$data = json_decode( file_get_contents( 'php://input' ), true );
	if(empty($data)){
		$data = $this->input->post();
	}    

	if(empty($data['user_id'])){ /* Missing user id */

		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'User id missing!',
			'data' => $response
		], REST_Controller::HTTP_NOT_FOUND);


	}

	if(empty($data['selected_user_id'])){ /* Missing selected_user_id */

		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'Selected user id missing!',
			'data' => $response
		], REST_Controller::HTTP_NOT_FOUND);


	}





	if(!empty($data['selected_user_id'])){

		$where = array('id' => $data['selected_user_id']);
		$users  = $this->db->get_where('applicants',$where)->row_array();
		if(count($users) == 0){

			$this->response([
				'code' => 400,
				'status' => FALSE,
				'message' => 'Selected user id not valid !'            
			], REST_Controller::HTTP_NOT_FOUND);


		}
	}




	$l = $this->api->get_profile_data($data['selected_user_id']);

	if(empty($l)){

		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'No users!',
			'data' => $response
		], REST_Controller::HTTP_OK);
	}else{            

		$mentor['user_id']=!empty($l['user_id'])?$l['user_id']:'';
		$mentor['full_name']=$l['first_name'].' '.$l['last_name'];
		$mentor['username']=!empty($l['username'])?$l['username']:'';
		$mentor['profile_img']=$this->get_user_image($l['user_id']);
		$mentor['email']=!empty($l['email'])?$l['email']:'';
		if(!empty($l['mobile_number']) && $l['mobile_number'] !=null){
			$mentor['mobile_number']=$l['mobile_number'];
		}else{
			$mentor['mobile_number']='';
		}        

		$mentor['address_line1']=!empty($l['address_line1'])?$l['address_line1']:'';
		$mentor['address_line2']=!empty($l['address_line2'])?$l['address_line2']:'';
		$mentor['city']=!empty($l['city'])?$l['city']:'';
		$mentor['state']=!empty($l['state'])?$l['state']:'';
		$mentor['country']=!empty($l['country'])?$l['country']:'';
		$mentor['under_college']=!empty($l['under_college'])?$l['under_college']:'';
		$mentor['under_major']=!empty($l['under_major'])?$l['under_major']:'';
		$mentor['graduate_college']=!empty($l['graduate_college'])?$l['graduate_college']:'';
		$mentor['type_of_degree']=!empty($l['degree'])?$l['degree']:'';

		$mentor['personal_message'] = !empty($l['mentor_personal_message'])?$l['mentor_personal_message']:'';


		if(!empty($l['gender'])){

			if($l['gender'] == 1){
				$mentor['gender']='Male';
			}else{
				$mentor['gender']='Female';
			}

		}else{
			$mentor['gender']='';
		}

		// $mentor['dob']=($l['dob']!='0000-00-00')?date('d-m-Y',strtotime($l['dob'])):'';
		$mentor['dob']=($l['dob']!='0000-00-00' && $l['dob']!='1970-01-01' && !empty($l['dob']))?date('d-m-Y',strtotime($l['dob'])):'';

		if($l['charge_type'] == 'charge' ){ 
			$mentor['is_free']=false;                            
			$mentor['hourly_rate']=$l['hourly_rate'];                                            
		}else{  
			$mentor['is_free']=true;                    
			$mentor['hourly_rate']='0.00';                                                   
		}

		$mentor['course'] = $this->get_course_details($l['user_id']);
		$mentor['rating_count']=!empty($l['rating_count'])?$l['rating_count']:'0';
		$mentor['rating_value']=!empty($l['rating_value'])?$l['rating_value']:'0';

		$page_no = !empty($data['page_no'])?$data['page_no']:1;
		$per_page = 3;

		$mentor['call_logs'] =  $this->get_three_logs($data['user_id'],$data['selected_user_id'],$page_no,$per_page);






		$results = array('selected_user_profile' => $mentor);
		$this->set_response([
			'status' => TRUE,
			'code' => 200,            
			'message' => 'User details retrieved successfully!',
			'data' =>$results
		], REST_Controller::HTTP_OK);  


	}

}

public function get_three_logs($from_id,$to_id,$page_no,$per_page){



	$response = array();


	$sql = "SELECT * FROM `call_logs` WHERE (from_id = $to_id AND to_id = $from_id) OR (from_id = $from_id AND to_id = $to_id) ORDER BY log_id DESC LIMIT 3";    
	$result= $this->db->query($sql)->result_array();   
	$total_result =array();
	if(!empty($result)){
		foreach($result as $r){
			$time1 = new DateTime($r['end_time']);
			$time2 = new DateTime($r['start_time']);
			$interval = $time1->diff($time2);


			$hours = $interval->h;
			$minutes =  $interval->i;
			$seconds =  $interval->s;

			$intervals = '';
			if($hours != '00'){
				$intervals .= $hours.' hr ';
			}
			if($minutes != '00'){
				$intervals .= $minutes.' min ';
			}

			if($seconds != '00'){
				$intervals .= $seconds.' seconds';
			}else{
				$intervals .= '0 seconds';
			}




			$interval = $interval->format('%H:%M:%S');
			$datas['invite_id'] = $r['invite_id'];
			$datas['invite_date'] = date('d-m-Y',strtotime($r['invite_date']));
			$datas['start_time'] = !empty($r['start_time'])?$r['start_time']:'';
			$datas['end_time'] = !empty($r['end_time'])?$r['end_time']:'';
			$datas['duration'] = $intervals;
			$total_result[]=$datas;
		}
	}    
	return $total_result;
}


public function get_call_logs_post(){


	$response=array();
	$data = json_decode( file_get_contents( 'php://input' ), true );
	if(empty($data)){
		$data = $this->input->post();
	}    

	if(empty($data['user_id'])){ /* Missing user id */

		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'User id missing!',
			'data' => $response
		], REST_Controller::HTTP_NOT_FOUND);


	}

	if(empty($data['selected_user_id'])){ /* Missing selected_user_id */

		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'Selected user id missing!',
			'data' => $response
		], REST_Controller::HTTP_NOT_FOUND);


	}





	if(!empty($data['selected_user_id'])){

		$where = array('id' => $data['selected_user_id']);
		$users  = $this->db->get_where('applicants',$where)->row_array();
		if(count($users) == 0){

			$this->response([
				'code' => 400,
				'status' => FALSE,
				'message' => 'Selected user id not valid !'            
			], REST_Controller::HTTP_NOT_FOUND);


		}
	}

	if(empty($data['page_no'])){ /* Missing Page no */

		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'Page no missing!',
			'data' => $response
		], REST_Controller::HTTP_NOT_FOUND);


	}


	$from_id = $data['user_id'];
	$to_id = $data['selected_user_id'];
	$page_no = $data['page_no'];
	$per_page = 20;


	$sql = "SELECT * FROM `call_logs` WHERE (from_id = $to_id AND to_id = $from_id) OR (from_id = $from_id AND to_id = $to_id) ORDER BY log_id DESC";

	if($page_no > 0){
		$page_limit= $per_page * ($page_no-1);
		$sql .=" LIMIT  $page_limit, $per_page";
	}else{
		$sql .=" LIMIT 0 , $per_page";
	}
    // echo $sql;

	$result= $this->db->query($sql)->result_array();


	$total_result =array();
	if(!empty($result)){
		foreach($result as $r){
			$time1 = new DateTime($r['end_time']);
			$time2 = new DateTime($r['start_time']);
			$interval = $time1->diff($time2);
            //$interval = $interval->format('%H:%M:%S');

			$hours = $interval->h;
			$minutes =  $interval->i;
			$seconds =  $interval->s;

			$intervals = '';
			if($hours != '00'){
				$intervals .= $hours.' hr ';
			}
			if($minutes != '00'){
				$intervals .= $minutes.' min ';
			}

			if($seconds != '00'){
				$intervals .= $seconds.' seconds';
			}else{
				$intervals .= '0 seconds';
			}




			$interval = $interval->format('%H:%M:%S');
			$datas['invite_id'] = $r['invite_id'];
			$datas['invite_date'] = date('d-m-Y',strtotime($r['invite_date']));
			$datas['start_time'] = !empty($r['start_time'])?$r['start_time']:'';
			$datas['end_time'] = !empty($r['end_time'])?$r['end_time']:'';
			$datas['duration'] = $intervals;
			$total_result[]=$datas;
		}

		$response = array('call_logs' => $total_result,'pages' => $this->get_call_log_count($from_id,$to_id,$page_no,$per_page));

		$this->response([
			'status' => TRUE,
			'code' => 200,            
			'message' => 'Call logs retrieved successfully!',
			'data' =>$response
		], REST_Controller::HTTP_OK);  


	}else{


		$response = new stdClass();
		$response->call_logs = array();
		$response->pages = new stdClass();
		$this->response([
			'code' => 200,
			'status' => TRUE,                
			'message' => 'No call logs!',
			'data' => $response
		], REST_Controller::HTTP_OK);

	}


}


public function get_call_log_count($from_id,$to_id,$page_no,$per_page){



	$sql = "SELECT * FROM `call_logs` WHERE (from_id = $to_id AND to_id = $from_id) OR (from_id = $from_id AND to_id = $to_id)";
	$total_logs= $this->db->query($sql)->num_rows();

	$total_pages = $total_logs / $per_page;  
	$total_pages = ceil($total_pages);
	if($total_pages  ==  0 ){
		$total_pages = 1;
	}


	$response = array('total_logs' => (string)$total_logs,'total_pages' => (string) $total_pages ,'current_page' => (string)$page_no);
	return $response;



}


Public function mentor_list_post(){

	$data = json_decode( file_get_contents( 'php://input' ), true );
	if(empty($data)){
		$data = $this->input->post();
	}
	$response = new stdClass();

	/* Validation */

	if(empty($data['page_no'])){ /* Missing Page no */

		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'Page no missing!',
			'data' => $response
		], REST_Controller::HTTP_NOT_FOUND);


	}


	if(empty($data['user_id'])){ /* Missing user id */

		$this->response([
			'code' => 400,
			'status' => FALSE,                
			'message' => 'User id missing!',
			'data' => $response
		], REST_Controller::HTTP_NOT_FOUND);
	}else{ /* Invalid user id */

		$result = $this->db->get_where('applicants',array('id'=>$data['user_id']))->row_array();
		if(count($result) == 0){
			$this->response([
				'code' => 400,
				'status' => FALSE,                
				'message' => 'User id not valid!',
				'data' => $response
			], REST_Controller::HTTP_NOT_FOUND);

		}elseif($result['type'] == 'guru'){ /* Restrict mentor */
			$this->response([
				'code' => 400,
				'status' => FALSE,                
				'message' => 'Login as mentee to get mentor list!',
				'data' => $response
			], REST_Controller::HTTP_OK);
		}
	}



	$page_no = !empty($data['page_no'])?$data['page_no']:1;
	$per_page = 15;
	/* Validation Ends */
	$list = $this->api->mentor_list_view($page_no,$per_page);
	if(!empty($list)){

		$mentor = array();
		$datas = array();


		foreach ($list as $l) {
			$mentor['user_id']=!empty($l['user_id'])?$l['user_id']:'';
			$mentor['full_name']=$l['first_name'].' '.$l['last_name'];
			$mentor['username']=!empty($l['username'])?$l['username']:'';
			$mentor['profile_img']=$this->get_user_image($l['user_id']);
			$mentor['email']=!empty($l['email'])?$l['email']:'';
			$mentor['country']=!empty($l['country'])?$l['country']:'';
			$mentor['personal_message'] = !empty($l['mentor_personal_message'])?$l['mentor_personal_message']:'';

			if($l['charge_type'] == 'charge' ){ 
				$mentor['is_free']=false;                            
				$mentor['hourly_rate']=$l['hourly_rate'];                                            
			}else{  
				$mentor['is_free']=true;                    
				$mentor['hourly_rate']='0.00';                                                   
			}

			$mentor['course'] = $this->get_course_details($l['user_id']);
			$mentor['rating_count']=!empty($l['rating_count'])?$l['rating_count']:'0';
			$mentor['rating_value']=!empty($l['rating_value'])?$l['rating_value']:'0';
			$datas[]=$mentor;
		}
		$total_mentors = $this->api->mentor_list_view_count();
		$total_pages = $total_mentors / $per_page;  
		$total_pages = ceil($total_pages);


		if($total_pages  ==  0 ){
			$total_pages = 1;
		}
		$response = array('mentor_list' => $datas,'total_mentors' => (string)$total_mentors,'total_pages' => (string) $total_pages ,'current_page' => (string)$page_no);



		$this->set_response([
			'status' => TRUE,
			'code' => 200,            
			'message' => 'Mentors retrieved successfully!',
			'data' =>$response
		], REST_Controller::HTTP_OK);  


	}else{

		$this->set_response([
			'status' => TRUE,
			'code' => 200,            
			'message' => 'No mentors!',
			'data' =>$response
		], REST_Controller::HTTP_OK);  

	}   

}



Public function get_course_details($mentor_id){
	$where  = array('mentor_id'=>$mentor_id);
	$courses = $this->db
	->select('c.course')                                                
	->join('courses c','c.course_id = m.course_id')
	->join('subject s','s.subject_id = c.subject_id')
	->get_where('mentor_course_details m',$where)
	->result_array(); 
	$subs=array();
	if(!empty($courses)){
		foreach($courses as $s){
			$subs[]=$s['course'];
		}
		$course = implode(',',$subs);

	}else{
		$course = '';
	}
	return  $course;
}

/* Phase 2 ends */


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
			'type' => !empty($_POST['type'])?$_POST['type']:'video',
			'start_by' =>$call_from,
			'channel' =>$channel
		);
		$count = $this->db->get_where('call_details',array('invite_id' => $_POST['invite_id']))->num_rows();
		if($count == 0){
			$this->db->insert('call_details',$data);
		}else{
			$this->db->delete('call_details',array('invite_id' => $_POST['invite_id']));
			$this->db->insert('call_details',$data);
		}


		$result->success = true;
		$result->code = 200;                
		$result->message = 'Call triggered';
	}
	$this->set_response($result, REST_Controller::HTTP_CREATED);


}


Public function send_push_notification($datas){

	$this->load->model('chat_model','chat');
	$data = $this->chat->get_player_id($datas['recieved_id']);



	if(!empty($data)){

		$additional_data['date_time'] = $datas['date_time'];        
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


	if(!empty($data['picture_url'])){        
		$img = $data['picture_url'];

	}else if(!empty($data['profile_img'])){
		$img = $data['profile_img'];
	}else{        
		$img ='default-avatar.png';        
	}    
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




public function login_post(){

	$datas = json_decode( file_get_contents( 'php://input' ), true );
	if(empty($datas)){
		$datas = $this->input->post();
	}  

	$empty = new stdClass();
	$result = new stdClass();
	


	if(empty($datas['source'])){ 
		$result->success = false;
		$result->code = 400;        
		$result->message = 'Source missing';    			
		$this->set_response($result, REST_Controller::HTTP_OK);      
	}

	if(empty($datas['email'])){ 
		$result->success = false;
		$result->code = 400;       
		$result->message = 'Email id missing';    			
		$this->set_response($result, REST_Controller::HTTP_OK);      
	}

	if(empty($datas['player_id'])){ 
		$result->success = false;
		$result->code = 400;      
		$result->message = 'Player id  missing';    			
		$this->set_response($result, REST_Controller::HTTP_OK);      
	}

	$password = '';
	if($datas['source'] === 'normal'){

		if(empty($datas['password'])){ 
			$result->success = false;
			$result->code = 400;        
			$result->message = 'Password missing';    			
			$this->set_response($result, REST_Controller::HTTP_OK);      
		}
		$password = $datas['password'];	
	}  	


	$username = $datas['email'];			
	$player_id = $datas['player_id'];
	$source = $datas['source'];

	$this->check_login($username,$password,$player_id,$source);
	
}

Public function check_login($username,$password,$player_id,$source){

	$empty = new stdClass();
	$result = new stdClass();


	if($source == 'normal'){

		$sql = "SELECT id,first_name,last_name,username,email,role,type,mobile_number,logged_in,source FROM applicants WHERE email = '".$username."'  AND password = '".MD5($password)."' AND delete_sts = 0 ;";
	}else{

		$sql = "SELECT id,first_name,last_name,username,email,role,type,mobile_number,logged_in,source FROM applicants WHERE email = '".$username."'  AND source = '".$source."'";
	}

	$query = $this->db->query($sql)->row_array();

	if(!empty($query)){

		$this->db->update('applicants',array('logged_in'=>1),array('id'=>$query['id']));
		$player_data = $this->db->get_where('one_signal_device_details',array('user_id'=>$query['id']))->row();
		if(!empty($player_data)){
			$this->db->update('one_signal_device_details',array('device_id'=>$player_id),array('user_id'=>$query['id']));
		}else{
			$this->db->insert('one_signal_device_details',array('device_id'=>$player_id,'user_id'=>$query['id']));
		}


		$query['id'] = !empty($query['id'])?$query['id']:'';
		$query['first_name'] = !empty($query['first_name'])?$query['first_name']:'';
		$query['last_name'] = !empty($query['last_name'])?$query['last_name']:'';
		$query['username'] = !empty($query['username'])?$query['username']:'';
		$query['email'] = !empty($query['email'])?$query['email']:'';
		$query['role'] = !empty($query['role'])?$query['role']:'';
		$query['type'] = !empty($query['type'])?$query['type']:'';
		$query['mobile_number'] = !empty($query['mobile_number'])?$query['mobile_number']:'';
		$query['logged_in'] = !empty($query['logged_in'])?$query['logged_in']:'';		

		// if($query['source'] == 'facebook' || $query['source'] == 'google'){
		// 	$query['profile_img'] = '';   
		// }else{
		// 	$query['profile_img'] = $this->get_user_image($query['id']);   	
		// }
		$query['profile_img'] = $this->get_user_image($query['id']);  
		

		$result->success = true;
		$result->code = 200;
		$result->data = $query;
		$result->message = 'Loggedin Successfully';
	}else{


		$result->success = false;
		$result->code = 400;
		$result->data = $empty;
		if($source == 'normal'){
			$result->message = 'Invalid email id or password';	
		}else{
			$result->message = 'You are not registered yet';
		}		
		
	}
	
	$this->set_response($result, REST_Controller::HTTP_CREATED);
}

public function conversation_list_today_post()
{




	$response=array();
	$data = json_decode( file_get_contents( 'php://input' ), true );
	if(empty($data)){
		$data = $this->input->post();
	}

	$user_id = $data['user_id'];
	$query = $this->db->query("SELECT * FROM applicants WHERE id = '".$user_id."'")->row_array();
	if(!empty($query))
	{
		if(empty($data['time_zone'])){
			$this->response([
				'status' => FALSE,
				'message' => 'time zone missing!'
			], REST_Controller::HTTP_NOT_FOUND);
		}

		$time_zone = $data['time_zone'];
		date_default_timezone_set($time_zone);

		if($query['role'] == 0){
			$this->db->select('t1.channel,t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.mentor_personal_message,COUNT(t4.rating) as rating_count,IFNULL(ROUND(AVG(t4.rating)),0) as rating_value');

			$this->db->from('invite t1');
			$this->db->where('t1.invite_from',$user_id);
			$this->db->where('t1.delete_sts',0);                
			$this->db->where('t1.approved',1);
			$this->db->where('t1.from_date_time >=',date('Y-m-d H'));
			$this->db->where('t1.invite_date <=',date('Y-m-d'));
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
			$this->db->where('t1.from_date_time >=',date('Y-m-d H'));
			$this->db->where('t1.invite_date <=',date('Y-m-d'));
			$this->db->join('applicants t2','t2.id=t1.invite_from','left');
			$this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
			$this->db->order_by('t1.from_date_time','asc');
			$res = $this->db->get()->result_array();

			$day_result = $res;
		}
		$resultSet = $day_result;

		if(!empty($day_result)){

			foreach($day_result as $d){
				$results['channel'] = !empty($d['channel'])?$d['channel']:'';
				$results['invite_id'] = !empty($d['invite_id'])?$d['invite_id']:'';
				$results['invite_date'] = !empty($d['invite_date'])?$d['invite_date']:'';
				$results['invite_time'] = !empty($d['invite_time'])?$d['invite_time']:'';
				$results['invite_expire'] = !empty($d['invite_expire'])?$d['invite_expire']:'';
				$results['current_status'] = !empty($d['current_status'])?$d['current_status']:'';
				$results['app_id'] = !empty($d['app_id'])?$d['app_id']:'';
				$results['first_name'] = !empty($d['first_name'])?$d['first_name']:'';
				$results['last_name'] = !empty($d['last_name'])?$d['last_name']:'';
				$results['username'] = !empty($d['username'])?$d['username']:'';
				$results['profile_img'] = !empty($d['profile_img'])?$d['profile_img']:'';
				$results['mentor_personal_message'] = !empty($d['mentor_personal_message'])?$d['mentor_personal_message']:'';
				$results['rating_count'] = !empty($d['rating_count'])?$d['rating_count']:'0';
				$results['rating_value'] = !empty($d['rating_value'])?$d['rating_value']:'0';
				$datas[]=$results;

			}    

		}else{
			$datas = array();
		}


		$result = new stdClass();

		$result->success = true;
		$result->code = 200;
		$result->data = $datas;
		$result->message = 'Conversation list retrieved successfully!' ;

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


	$data = json_decode( file_get_contents( 'php://input' ), true );
	$user_id = $data['user_id'];
	$query = $this->db->query("SELECT * FROM applicants WHERE id = '".$user_id."'")->row_array();
	if(!empty($query))
	{
		if(empty($data['time_zone'])){
			$this->response([
				'status' => FALSE,
				'message' => 'time zone missing!'
			], REST_Controller::HTTP_NOT_FOUND);
		}

		$time_zone = $data['time_zone'];
		date_default_timezone_set($time_zone);

		$monday = strtotime("today");
		$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
		$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
		$this_week_sd = date("Y-m-d",$monday);
		$this_week_ed = date("Y-m-d",$sunday);

		$dt = date("Y-m-d H");
		$dts = date("Y-m-d");
		$end = date( "Y-m-d", strtotime( "$dts +6 days" ) );

		if($query['role'] == 0){
			$this->db->select('t1.channel,t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.mentor_personal_message,COUNT(t4.rating) as rating_count,IFNULL(ROUND(AVG(t4.rating)),0) as rating_value');

        // $this->db->select('t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.mentor_personal_message,COUNT(t4.rating) as rating_count,IFNULL(ROUND(AVG(t4.rating)),0) as rating_value');
			$this->db->from('invite t1');
			$this->db->where('t1.invite_from',$user_id);
			$this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
			$this->db->where('t1.approved',1);
            // $this->db->where("t1.invite_date BETWEEN '$dt' AND '$end'");
			$this->db->where('t1.from_date_time >=',$dt);
			$this->db->where('t1.invite_date <=',$end);
			$this->db->join('applicants t2','t2.id=t1.invite_to','left');
			$this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
			$this->db->join('review_ratings t4','t4.user_id=t1.invite_to','left');
			$this->db->order_by('t1.from_date_time','asc');
			$this->db->group_by('t1.invite_id');
			$res = $this->db->get()->result_array();
			$week_result = $res;
		}
		if($query['role'] == 1){
        // $this->db->select('t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img');
			$this->db->select('t1.channel,t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img');
			$this->db->from('invite t1');
			$this->db->where('t1.invite_to',$user_id);
			$this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
			$this->db->where('t1.approved',1);
            // $this->db->where("t1.invite_date BETWEEN '$dt' AND '$end'");
			$this->db->where('t1.from_date_time >=',$dt);
			$this->db->where('t1.invite_date <=',$end);
			$this->db->join('applicants t2','t2.id=t1.invite_from','left');
			$this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
			$this->db->order_by('t1.from_date_time','asc');
			$res = $this->db->get()->result_array();

			$week_result = $res;
		}
		$resultSet = $week_result;

		if(!empty($week_result)){

			foreach($week_result as $d){
				$results['channel'] = !empty($d['channel'])?$d['channel']:'';
				$results['invite_id'] = !empty($d['invite_id'])?$d['invite_id']:'';
				$results['invite_date'] = !empty($d['invite_date'])?$d['invite_date']:'';
				$results['invite_time'] = !empty($d['invite_time'])?$d['invite_time']:'';
				$results['invite_expire'] = !empty($d['invite_expire'])?$d['invite_expire']:'';
				$results['current_status'] = !empty($d['current_status'])?$d['current_status']:'';
				$results['app_id'] = !empty($d['app_id'])?$d['app_id']:'';
				$results['first_name'] = !empty($d['first_name'])?$d['first_name']:'';
				$results['last_name'] = !empty($d['last_name'])?$d['last_name']:'';
				$results['username'] = !empty($d['username'])?$d['username']:'';
				$results['profile_img'] = !empty($d['profile_img'])?$d['profile_img']:'';
				$results['mentor_personal_message'] = !empty($d['mentor_personal_message'])?$d['mentor_personal_message']:'';
				$results['rating_count'] = !empty($d['rating_count'])?$d['rating_count']:'0';
				$results['rating_value'] = !empty($d['rating_value'])?$d['rating_value']:'0';
				$datas[]=$results;

			}    

		}else{
			$datas = array();
		}


		$result = new stdClass();

		$result->success = true;
		$result->code = 200;
		$result->data = $datas;
		$result->message = 'Conversation list retrieved successfully!' ;

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

	$data = json_decode( file_get_contents( 'php://input' ), true );
	$user_id = $data['user_id'];

	$query = $this->db->query("SELECT * FROM applicants WHERE id = '".$user_id."'")->row_array();
	if(!empty($query))
	{
		if(empty($data['time_zone'])){
			$this->response([
				'status' => FALSE,
				'message' => 'time zone missing!'
			], REST_Controller::HTTP_NOT_FOUND);
		}

		$time_zone = $data['time_zone'];
		date_default_timezone_set($time_zone);

		$dt = date("Y-m-d H");
		$dts = date("Y-m-d");
		$end = date( "Y-m-d", strtotime( "$dts +30 days" ) );

		if($query['role'] == 0){
			$this->db->select('t1.channel,t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.mentor_personal_message,COUNT(t4.rating) as rating_count,IFNULL(ROUND(AVG(t4.rating)),0) as rating_value');

        // $this->db->select('t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img,t3.mentor_personal_message,COUNT(t4.rating) as rating_count,IFNULL(ROUND(AVG(t4.rating)),0) as rating_value');
			$this->db->from('invite t1');
			$this->db->where('t1.invite_from',$user_id);
			$this->db->where('t1.delete_sts',0);        
			$this->db->where('t1.approved',1);        
			$this->db->where('t1.from_date_time >=',$dt);
			$this->db->where('t1.invite_date <=',$end);
			$this->db->join('applicants t2','t2.id=t1.invite_to','left');
			$this->db->join('mentor_details t3','t3.mentor_id=t1.invite_to','left');
			$this->db->join('review_ratings t4','t4.user_id=t1.invite_to','left');
			$this->db->order_by('t1.from_date_time','asc');
			$this->db->group_by('t1.invite_id');
			$res = $this->db->get()->result_array();
			$month_result = $res;
		}
		if($query['role'] == 1){
        // $this->db->select('t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img');

			$this->db->select('t1.channel,t1.invite_id,t1.invite_date,t1.invite_time,ADDTIME(t1.invite_time,"01:00:00") as invite_expire,t1.current_status,t2.id as app_id,t2.first_name,t2.last_name,t2.username,t2.profile_img');

			$this->db->from('invite t1');
			$this->db->where('t1.invite_to',$user_id);
			$this->db->where('t1.delete_sts',0);
                //$this->db->where('t1.current_status',0);
			$this->db->where('t1.approved',1);
        //$this->db->where("t1.invite_date BETWEEN '$dt' AND '$end'");
			$this->db->where('t1.from_date_time >=',$dt);
			$this->db->where('t1.invite_date <=',$end);
			$this->db->join('applicants t2','t2.id=t1.invite_from','left');
			$this->db->join('applicants_profile t3','t3.applicant_id=t1.invite_from','left');
			$this->db->order_by('t1.from_date_time','asc');
			$res = $this->db->get()->result_array();

			$month_result = $res;
		}
		$resultSet = $month_result;


		if(!empty($month_result)){

			foreach($month_result as $d){
				$results['channel'] = !empty($d['channel'])?$d['channel']:'';
				$results['invite_id'] = !empty($d['invite_id'])?$d['invite_id']:'';
				$results['invite_date'] = !empty($d['invite_date'])?$d['invite_date']:'';
				$results['invite_time'] = !empty($d['invite_time'])?$d['invite_time']:'';
				$results['invite_expire'] = !empty($d['invite_expire'])?$d['invite_expire']:'';
				$results['current_status'] = !empty($d['current_status'])?$d['current_status']:'';
				$results['app_id'] = !empty($d['app_id'])?$d['app_id']:'';
				$results['first_name'] = !empty($d['first_name'])?$d['first_name']:'';
				$results['last_name'] = !empty($d['last_name'])?$d['last_name']:'';
				$results['username'] = !empty($d['username'])?$d['username']:'';
				$results['profile_img'] = !empty($d['profile_img'])?$d['profile_img']:'';
				$results['mentor_personal_message'] = !empty($d['mentor_personal_message'])?$d['mentor_personal_message']:'';
				$results['rating_count'] = !empty($d['rating_count'])?$d['rating_count']:'0';
				$results['rating_value'] = !empty($d['rating_value'])?$d['rating_value']:'0';
				$datas[]=$results;

			}    

		}else{
			$datas = array();
		}


		$result = new stdClass();

		$result->success = true;
		$result->code = 200;
		$result->data = $datas;
		$result->message = 'Conversation list retrieved successfully!' ;

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


Public function insert_log_post(){ 


	$data = json_decode( file_get_contents( 'php://input' ), true );    
	if(empty($data)){
		$data = $this->input->post();
	}  

	$empty = new stdClass();
	$result = new stdClass();

	if(empty($data['invite_id'])){

		$result->status = false;
		$result->code = 400;        
		$result->message = 'Invite id missing';        

	}
	elseif(empty($data['from_id'])){
		$result->status = false;
		$result->code = 400;        
		$result->message = 'From id missing';

	}
	elseif(empty($data['to_id'])){
		$result->status = false;
		$result->code = 400;        
		$result->message = 'To id missing';

	}
	else{

		$where = array('invite_id'=>$data['invite_id']);
		$invite = $this->db->get_where('invite',$where)->row_array();
		$data['start_time'] =  date('H:i:s',strtotime($data['start_time']));  
		$data['end_time'] =  date('H:i:s',strtotime($data['end_time']));  
		$data['time_zone'] = date_default_timezone_get();  
		$data['invite_id'] = $data['invite_id'];  
		$data['invite_date'] = date('Y-m-d',strtotime($data['invite_date']));  
		$data['to_id']= $data['to_id'];
		$data['from_id']= $data['from_id'];   

		$this->db->insert('call_logs',$data);

		$id =   $this->db->insert_id();  
		$where = array('invite_id'=>$data['invite_id'],'payment_status'=>0);
		@$amount = $this->db->get_where('payments',$where)->row()->payment_gross;
		if(!empty($amount) && $amount != '0' ){
			$this->update_payment();  
		}else{
			$this->db->update('payments',array('payment_status'=>1,'amount'=>0),$where);
		}     

		$result->status = true;
		$result->code = 200;        
         // $result->message = $res;
		$result->message = 'success';

	}

	$this->set_response($result, REST_Controller::HTTP_CREATED);

}

Public function update_payment(){



	$datas = json_decode( file_get_contents( 'php://input' ), true );    
	if(empty($datas)){
		$datas = $this->input->post();
	}  

	$where = array('invite_id'=>$datas['invite_id'],'payment_status'=>0);
	$data = $this->db->get_where('payments',$where)->row();
	$amount = $data->payment_gross * 100;


	if(!empty($data)){

		\Stripe\Stripe::setApiKey("sk_test_nKMiwRltszi5bNOIjTW3EoxV");
		$charge = \Stripe\Charge::create(array(
          "amount" =>$amount, // $15.00 this time
          "currency" => "usd",
          "customer" =>$data->stripe_customer_id
        ));

		$data =  json_encode($charge);
		$data =  json_decode($data);    

        // echo '<pre>';print_r($data); exit;                 

		$update_data = array(
			'payment_status' => $data->paid,
			'txn_id' => $data->balance_transaction,
			'amount' => $data->amount,
			'source_id' => $data->id
		);
		return  $this->db->update('payments',$update_data,$where);

	}  else{
		return true;
	}

}
// 17-06-1996 10:30 udumalaipettai 
public function call_list_today_post()
{
	$data = json_decode( file_get_contents( 'php://input' ), true );    
	if(empty($data)){
		$data = $this->input->post();
	}  

	$result = new stdClass();   


	if(empty($data) || empty($data['user_id'])){

		$result->success = false;
		$result->code = 400;
		$result->data = array();
		$result->message = 'User id missing';
		echo json_encode($result);            
		exit;            
	}

	if(empty($data) || empty($data['time_zone'])){                 
		$result->success = false;
		$result->code = 400;
		$result->data = array();
		$result->message = 'timezone missing';
		echo json_encode($result);
		exit;           

	}
	$user_id = $data['user_id'];
	$time_zone = $data['time_zone'];

	date_default_timezone_set($time_zone);
	$resultSet=array();

	$query = $this->db->query("SELECT * FROM applicants WHERE id = '".$user_id."'")->row_array();

     // $res = $this->api->get_call_log_today($user_id,$page_no,$per_page);

	if(!empty($query)){
		$date = date('Y-m-d');

		if($query['role'] == 0){    


			$sql ="SELECT t1.invite_id, t1.invite_date, t1.invite_time, ADDTIME(t1.invite_time, '01:00:00') AS invite_expire, t1.current_status, t2.id AS app_id, t2.first_name, t2.last_name, t2.username, t2.profile_img, t3.mentor_personal_message,(SELECT COUNT(rating)  FROM review_ratings  WHERE user_id= '$user_id') AS rating_count,
			(SELECT  ROUND(AVG(rating))  FROM review_ratings  WHERE user_id= '$user_id') AS rating_value
			,t5.start_time,t5.end_time 
			FROM invite t1
			LEFT JOIN applicants t2 ON t2.id=t1.invite_to
			LEFT JOIN mentor_details t3 ON t3.mentor_id=t1.invite_to
			LEFT JOIN call_logs t5 ON t5.invite_id=t1.invite_id
			WHERE t1.invite_from = '$user_id' AND t1.delete_sts =0 AND t1.approved = 1 AND t1.invite_date = '$date' AND t5.start_time != '' AND (t5.from_id = '$user_id' OR t5.to_id = '$user_id')
			ORDER BY t5.log_id DESC";


		}elseif($query['role'] == 1){

			$sql="SELECT t1.invite_id, t1.invite_date, t1.invite_time, ADDTIME(t1.invite_time, '01:00:00') AS invite_expire, t1.current_status, t2.id AS app_id, t2.first_name, t2.last_name, t2.username, t2.profile_img, t3.mentor_personal_message,(SELECT COUNT(rating)  FROM review_ratings  WHERE user_id= '$user_id') AS rating_count,
			(SELECT  ROUND(AVG(rating))  FROM review_ratings  WHERE user_id= '$user_id') AS rating_value
			,t5.start_time,t5.end_time 
			FROM invite t1 
			LEFT JOIN applicants t2 ON t2.id=t1.invite_from
			LEFT JOIN mentor_details t3 ON t3.mentor_id=t1.invite_from        
			LEFT JOIN call_logs t5 ON t5.invite_id=t1.invite_id
			WHERE t1.invite_to = '$user_id' AND t1.delete_sts =0 AND t1.approved = 1 AND t1.invite_date = '$date' AND t5.start_time != '' AND (t5.from_id = '$user_id' OR t5.to_id = '$user_id')
			ORDER BY t5.log_id DESC";           
		}

		$res = $this->db->query($sql)->result_array(); 

    
     // echo '<pre>'; print_r($sql);

		if(!empty($res)){

			foreach ($res as $r) {

				$time1 = new DateTime($r['end_time']);
				$time2 = new DateTime($r['start_time']);
				$interval = $time1->diff($time2);
				//$interval = $interval->format('%H:%M:%S');


				$hours = $interval->h;
				$minutes =  $interval->i;
				$seconds =  $interval->s;

				$intervals = '';
				if($hours != '00'){
					$intervals .= $hours.' hr ';
				}
				if($minutes != '00'){
					$intervals .= $minutes.' min ';
				}

				if($seconds != '00'){
					$intervals .= $seconds.' seconds';
				}else{
					$intervals .= '0 seconds';
				}




				$interval = $interval->format('%H:%M:%S');
				$datas['invite_id'] =!empty($r['invite_id'])? $r['invite_id']:'';
				$datas['invite_date'] =!empty($r['invite_date'])? $r['invite_date']:'';
				$datas['invite_time'] =!empty($r['invite_time'])? $r['invite_time']:'';
				$datas['invite_expire'] =!empty($r['invite_expire'])? $r['invite_expire']:'';
				$datas['current_status'] =!empty($r['current_status'])? $r['current_status']:'';
				$datas['app_id'] =!empty($r['app_id'])? $r['app_id']:'';
				$datas['first_name'] =!empty($r['first_name'])? $r['first_name']:'';
				$datas['last_name'] =!empty($r['last_name'])? $r['last_name']:'';
				$datas['username'] =!empty($r['username'])? $r['username']:'';
				$datas['profile_img'] =!empty($r['profile_img'])? $r['profile_img']:'';
				$datas['mentor_personal_message'] =!empty($r['mentor_personal_message'])? $r['mentor_personal_message']:'';
				$datas['rating_count'] = !empty($r['rating_count'])?$r['rating_count']:'0';
				$datas['rating_value'] = !empty($r['rating_value'])?$r['rating_value']:'0';
				$datas['start_time'] = !empty($r['start_time'])?$r['start_time']:'';
				$datas['end_time'] = !empty($r['end_time'])?$r['end_time']:'';
				$datas['duration'] = $intervals;
				$resultSet[]=$datas;
			}

		}


		$result->success = true;
		$result->code = 200;
		$result->data = $resultSet;

		$this->set_response($result, REST_Controller::HTTP_OK);

	}else{
		$result = new stdClass();
		$result1 = new stdClass();
		$result->success = false;
		$result->code = 400;
		$result->data = $result1;
		$result->message = 'User does not exist';
		$this->set_response($result, REST_Controller::HTTP_OK);
	}

}

public function call_list_week_post()
{
	$data = json_decode( file_get_contents( 'php://input' ), true );
	$result = new stdClass();   


	if(empty($data) || empty($data['user_id'])){

		$result->success = false;
		$result->code = 400;
		$result->data = array();
		$result->message = 'User id missing';
		echo json_encode($result);            
		exit;            
	}

	if(empty($data) || empty($data['time_zone'])){                 
		$result->success = false;
		$result->code = 400;
		$result->data = array();
		$result->message = 'timezone missing';
		echo json_encode($result);
		exit;           

	}
	$user_id = $data['user_id'];
	$time_zone = $data['time_zone'];

	date_default_timezone_set($time_zone);


	$resultSet=array();
	$monday = strtotime("today");
	$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
	$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
	$this_week_sd = date("Y-m-d",$monday);
	$this_week_ed = date("Y-m-d",$sunday);

	$dt = date("Y-m-d");
	$end = date( "Y-m-d", strtotime('-6 days', strtotime($dt)) );

	$query = $this->db->query("SELECT * FROM applicants WHERE id = '".$user_id."'")->row_array();
	if(!empty($query))
	{
		if($query['role'] == 0){

			$sql ="SELECT t1.invite_id, t1.invite_date, t1.invite_time, ADDTIME(t1.invite_time, '01:00:00') AS invite_expire, t1.current_status, t2.id AS app_id, t2.first_name, t2.last_name, t2.username, t2.profile_img, t3.mentor_personal_message,(SELECT COUNT(rating)  FROM review_ratings  WHERE user_id= '$user_id') AS rating_count,
			(SELECT  ROUND(AVG(rating))  FROM review_ratings  WHERE user_id= '$user_id') AS rating_value
			,t5.start_time,t5.end_time 
			FROM invite t1
			LEFT JOIN applicants t2 ON t2.id=t1.invite_to
			LEFT JOIN mentor_details t3 ON t3.mentor_id=t1.invite_to
			LEFT JOIN call_logs t5 ON t5.invite_id=t1.invite_id
			WHERE t1.invite_from = '$user_id' AND t1.delete_sts =0 AND t1.approved = 1 AND t5.start_time != '' AND (t5.from_id = '$user_id' OR t5.to_id = '$user_id') AND ( t1.invite_date BETWEEN '$end' AND '$dt')
			ORDER BY t5.log_id DESC";          


		}
		if($query['role'] == 1){
			$sql ="SELECT t1.invite_id, t1.invite_date, t1.invite_time, ADDTIME(t1.invite_time, '01:00:00') AS invite_expire, t1.current_status, t2.id AS app_id, t2.first_name, t2.last_name, t2.username, t2.profile_img, t3.mentor_personal_message,(SELECT COUNT(rating)  FROM review_ratings  WHERE user_id= '$user_id') AS rating_count,
			(SELECT  ROUND(AVG(rating))  FROM review_ratings  WHERE user_id= '$user_id') AS rating_value
			,t5.start_time,t5.end_time 
			FROM invite t1
			LEFT JOIN applicants t2 ON t2.id=t1.invite_from
			LEFT JOIN mentor_details t3 ON t3.mentor_id=t1.invite_from
			LEFT JOIN call_logs t5 ON t5.invite_id=t1.invite_id
			WHERE t1.invite_to = '$user_id' AND t1.delete_sts =0 AND t1.approved = 1 AND  t5.start_time != '' AND (t5.from_id = '$user_id' OR t5.to_id = '$user_id') AND ( t1.invite_date BETWEEN '$end' AND '$dt')
			ORDER BY t5.log_id DESC";

		}
		$res = $this->db->query($sql)->result_array();

		if(!empty($res)){

			foreach ($res as $r) {

				$time1 = new DateTime($r['end_time']);
				$time2 = new DateTime($r['start_time']);
				$interval = $time1->diff($time2);
				// $interval = $interval->format('%H:%M:%S');
				$hours = $interval->h;
				$minutes =  $interval->i;
				$seconds =  $interval->s;

				$intervals = '';
				if($hours != '00'){
					$intervals .= $hours.' hr ';
				}
				if($minutes != '00'){
					$intervals .= $minutes.' min ';
				}

				if($seconds != '00'){
					$intervals .= $seconds.' seconds';
				}else{
					$intervals .= '0 seconds';
				}


				//$interval = $interval->format('%H:%M:%S');
				$datas['invite_id'] =!empty($r['invite_id'])? $r['invite_id']:'';
				$datas['invite_date'] =!empty($r['invite_date'])? $r['invite_date']:'';
				$datas['invite_time'] =!empty($r['invite_time'])? $r['invite_time']:'';
				$datas['invite_expire'] =!empty($r['invite_expire'])? $r['invite_expire']:'';
				$datas['current_status'] =!empty($r['current_status'])? $r['current_status']:'';
				$datas['app_id'] =!empty($r['app_id'])? $r['app_id']:'';
				$datas['first_name'] =!empty($r['first_name'])? $r['first_name']:'';
				$datas['last_name'] =!empty($r['last_name'])? $r['last_name']:'';
				$datas['username'] =!empty($r['username'])? $r['username']:'';
				$datas['profile_img'] =!empty($r['profile_img'])? $r['profile_img']:'';
				$datas['mentor_personal_message'] =!empty($r['mentor_personal_message'])? $r['mentor_personal_message']:'';
				$datas['rating_count'] = !empty($r['rating_count'])?$r['rating_count']:'0';
				$datas['rating_value'] = !empty($r['rating_value'])?$r['rating_value']:'0';
				$datas['start_time'] = !empty($r['start_time'])?$r['start_time']:'';
				$datas['end_time'] = !empty($r['end_time'])?$r['end_time']:'';
				$datas['duration'] = $intervals;
				$resultSet[]=$datas;
			}

		}


		$result = new stdClass();

		$result->success = true;
		$result->code = 200;
		$result->data = $resultSet;

		$this->set_response($result, REST_Controller::HTTP_OK);

	}else{
		$result = new stdClass();
		$result1 = new stdClass();
		$result->success = false;
		$result->code = 400;
		$result->data = $result1;
		$result->message = 'User does not exist';
		$this->set_response($result, REST_Controller::HTTP_OK);
	}

}

public function call_list_month_post()
{

	

	$data = json_decode( file_get_contents( 'php://input' ), true );
	$result = new stdClass();   



	

	if(empty($data) || empty($data['user_id'])){

		$result->success = false;
		$result->code = 400;
		$result->data = array();
		$result->message = 'User id missing';
		echo json_encode($result);            
		exit;            
	}

	if(empty($data) || empty($data['time_zone'])){                 
		$result->success = false;
		$result->code = 400;
		$result->data = array();
		$result->message = 'timezone missing';
		echo json_encode($result);
		exit;           

	}
	$user_id = $data['user_id'];
	$time_zone = $data['time_zone'];

	date_default_timezone_set($time_zone);


	$resultSet = array();
	$dt = date("Y-m-d");
	$end = date("Y-m-d", strtotime('-30 days', strtotime($dt)));  

	if(!empty($data['log_type'])){
		if($data['log_type'] == 'all'){
			$new_query = "";	
		}else{
			$new_query = "AND ( t1.invite_date BETWEEN '$end' AND '$dt')";
		}
		
	}else{
		$new_query = "AND ( t1.invite_date BETWEEN '$end' AND '$dt')";
	}

	$query = $this->db->query("SELECT * FROM applicants WHERE id = '".$user_id."'")->row_array();
	if(!empty($query))
	{
		if($query['role'] == 0){

			$sql ="SELECT t1.invite_id, t1.invite_date, t1.invite_time, ADDTIME(t1.invite_time, '01:00:00') AS invite_expire, t1.current_status, t2.id AS app_id, t2.first_name, t2.last_name, t2.username, t2.profile_img, t3.mentor_personal_message,(SELECT COUNT(rating)  FROM review_ratings  WHERE user_id= '$user_id') AS rating_count,
			(SELECT  ROUND(AVG(rating))  FROM review_ratings  WHERE user_id= '$user_id') AS rating_value
			,t5.start_time,t5.end_time 
			FROM invite t1
			LEFT JOIN applicants t2 ON t2.id=t1.invite_to
			LEFT JOIN mentor_details t3 ON t3.mentor_id=t1.invite_to
			LEFT JOIN call_logs t5 ON t5.invite_id=t1.invite_id
			WHERE t1.invite_from = '$user_id' AND t1.delete_sts =0 AND t1.approved = 1 AND t5.start_time != '' AND (t5.from_id = '$user_id' OR t5.to_id = '$user_id') AND ( t1.invite_date BETWEEN '$end' AND '$dt')
			ORDER BY t5.log_id DESC";          


		}
		if($query['role'] == 1){
			$sql ="SELECT t1.invite_id, t1.invite_date, t1.invite_time, ADDTIME(t1.invite_time, '01:00:00') AS invite_expire, t1.current_status, t2.id AS app_id, t2.first_name, t2.last_name, t2.username, t2.profile_img, t3.mentor_personal_message,(SELECT COUNT(rating)  FROM review_ratings  WHERE user_id= '$user_id') AS rating_count,
			(SELECT  ROUND(AVG(rating))  FROM review_ratings  WHERE user_id= '$user_id') AS rating_value
			,t5.start_time,t5.end_time 
			FROM invite t1
			LEFT JOIN applicants t2 ON t2.id=t1.invite_from
			LEFT JOIN mentor_details t3 ON t3.mentor_id=t1.invite_from
			LEFT JOIN call_logs t5 ON t5.invite_id=t1.invite_id
			WHERE t1.invite_to = '$user_id' AND t1.delete_sts =0 AND t1.approved = 1 AND  t5.start_time != '' AND (t5.from_id = '$user_id' OR t5.to_id = '$user_id') $new_query
			ORDER BY t5.log_id DESC";

		}
		$res = $this->db->query($sql)->result_array(); 

		if(!empty($res)){

			foreach ($res as $r) {
				$time1 = new DateTime($r['end_time']);
				$time2 = new DateTime($r['start_time']);
				$interval = $time1->diff($time2);

				$hours = $interval->h;
				$minutes =  $interval->i;
				$seconds =  $interval->s;

				$intervals = '';
				if($hours != '00'){
					$intervals .= $hours.' hr ';
				}
				if($minutes != '00'){
					$intervals .= $minutes.' min ';
				}

				if($seconds != '00'){
					$intervals .= $seconds.' seconds';
				}else{
					$intervals .= '0 seconds';
				}



				$interval = $interval->format('%H:%M:%S');
				$datas['invite_id'] =!empty($r['invite_id'])? $r['invite_id']:'';
				$datas['invite_date'] =!empty($r['invite_date'])? $r['invite_date']:'';
				$datas['invite_time'] =!empty($r['invite_time'])? $r['invite_time']:'';
				$datas['invite_expire'] =!empty($r['invite_expire'])? $r['invite_expire']:'';
				$datas['current_status'] =!empty($r['current_status'])? $r['current_status']:'';
				$datas['app_id'] =!empty($r['app_id'])? $r['app_id']:'';
				$datas['first_name'] =!empty($r['first_name'])? $r['first_name']:'';
				$datas['last_name'] =!empty($r['last_name'])? $r['last_name']:'';
				$datas['username'] =!empty($r['username'])? $r['username']:'';
				$datas['profile_img'] =!empty($r['profile_img'])? $r['profile_img']:'';
				$datas['mentor_personal_message'] =!empty($r['mentor_personal_message'])? $r['mentor_personal_message']:'';
				$datas['rating_count'] = !empty($r['rating_count'])?$r['rating_count']:'0';
				$datas['rating_value'] = !empty($r['rating_value'])?$r['rating_value']:'0';
				$datas['start_time'] = !empty($r['start_time'])?$r['start_time']:'';
				$datas['end_time'] = !empty($r['end_time'])?$r['end_time']:'';
				$datas['duration'] = $intervals;
				$resultSet[]=$datas;
			}

		}


		$result = new stdClass();

		$result->success = true;
		$result->code = 200;
		$result->data = $resultSet;

		$this->set_response($result, REST_Controller::HTTP_OK);

	}else{
		$result = new stdClass();
		$result1 = new stdClass();
		$result->success = false;
		$result->code = 400;
		$result->data = $result1;
		$result->message = 'User does not exist';
		$this->set_response($result, REST_Controller::HTTP_OK);
	}

}

public function push_notify_post()
{
	$target = $this->post('reg_id');
	$data = array('body'  => 'You have a call with Guru',
		'title'    => 'Time for Call',
		'icon' => 'myicon',/*Default Icon*/
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






 // Getting users for chat 

    Public function users_post(){



    	$user_data = $this->validate_user();


    	$inputs = json_decode( file_get_contents( 'php://input' ), true );
    	if(empty($inputs)){
    		$inputs = $this->input->post();
    	}  




    	if(!empty($user_data)){

    		$id = $inputs['user_id'];
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
    			$results = array(
    				'code' =>200,
    				'status' => TRUE,
    				'message'=>'Users retrieved successfully!',
    				'data' => $datas
    			);
    			$this->set_response($results, REST_Controller::HTTP_OK);     
    		}else{

    			$this->response([
    				'status' => FALSE,
    				'code' =>400,
    				'message' => 'No users!',
    				'data'=>array()

    			], REST_Controller::HTTP_NOT_FOUND);

    		}

    	}


    }


    public function get_call_type_post(){
    	$result = new stdClass();
    	$type = new stdClass();
    	if(!empty($_POST['user_id'])){         
    		$where  = array('call_to' =>$_POST['user_id']);
    		$datas = $this->db->select('call_id,type')->order_by('call_id','desc')->get_where('call_details',$where)->row_array();

    		if(!empty($datas)){

    			$this->db->delete('call_details',array('call_id' => $datas['call_id']));

    			$result->success = true;
    			$result->code = 200;        
    			$result->message = 'calls present';
    			$result->data =array('type'=>$datas['type']);
    			$this->set_response($result, REST_Controller::HTTP_OK);      
    		}else{

    			$result->success = false;
    			$result->code = 400;        
    			$result->data =array('type'=>'');
    			$result->message = 'No calls';
    			$this->set_response($result, REST_Controller::HTTP_OK); 

    		}       

    	}else{

    		$result->success = false;
    		$result->code = 400;        
    		$result->message = 'User id missing';
    		$this->set_response($result, REST_Controller::HTTP_NOT_FOUND);            
    	}
    }

    Public function conv_post()
    {


    	$user_data = $this->validate_user();  
    	$inputs = json_decode( file_get_contents( 'php://input' ), true );
    	if(empty($inputs)){
    		$inputs = $this->input->post();
    	}  

    	if(empty($inputs['page_no'])){ /* Missing Page no */
    		$this->response([
    			'code' => 400,
    			'status' => FALSE,                
    			'message' => 'Page no missing!',
    			'data' => $response
    		], REST_Controller::HTTP_NOT_FOUND);
    	}

    	if(!empty($inputs['selected_user_id'])){

    		$where = array('id' => $inputs['selected_user_id']);
    		$users  = $this->db->get_where('applicants',$where)->row_array();
    		if(count($users) == 0){

    			$this->response([
    				'code' => 400,
    				'status' => FALSE,
    				'message' => 'Selected user id not valid !'            
    			], REST_Controller::HTTP_NOT_FOUND);


    		}



    		if(empty($inputs['time_zone'])){
    			$this->response([
    				'code' => 400,
    				'status' => FALSE,
    				'message' => 'time zone missing!',
    				'data' => array()
    			], REST_Controller::HTTP_NOT_FOUND);
    		}

    		$session_id = $user_data['applicant_id'];
    		$selected_user = $users['id']; /* Selected user  id */
    		$time_zone = $inputs['time_zone'];

    		$per_page = 20;
    		$page_no = !empty($inputs['page_no'])?$inputs['page_no']:1;
    		$latest_chat= $this->api->get_latest_chat_new($selected_user,$session_id,$page_no,$per_page); 
    		$total_messages = $this->api->get_latest_chat_counts($selected_user,$session_id);
    		$total_pages = $total_messages / $per_page;  
    		$total_pages = ceil($total_pages);


    		if(!empty($latest_chat)){
    			foreach($latest_chat as $key => $currentuser) : 

    				$from_timezone = $currentuser['time_zone'];
    				$date_time = $currentuser['chatdate'];
    				$date_time  = $this->converToTz($date_time,$time_zone,$from_timezone);

    				$response['chat_time'] = date('Y-m-d H:i:s',strtotime($date_time));
    				$type = $currentuser['type'];        
    				$attachment_file = ($currentuser['file_path'])?($currentuser['file_path'].'/'.$currentuser['file_name']):'';        
    				$message = $currentuser['msg'];      

    				if($currentuser['sent_id'] == $user_data['applicant_id']){
    					$response['msg_type'] = 'OUTBOUND';

    				}elseif($currentuser['recieved_id'] == $user_data['applicant_id']){
    					$response['msg_type'] = 'INBOUND';
    				}

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

    				$selected_user_details = array(
    					'full_name' => $this->get_user_name($selected_user),
    					'profile_img' => $this->get_user_image($selected_user),
    				);
    				$results= array(
    					'chat_conversations'=>$datas,
    					'total_messages' => $total_messages,
    					'total_pages' => $total_pages,
    					'page_no' => $page_no            
    				);



    			endforeach;

    			$json['code'] = 200;
    			$json['status'] = TRUE;
    			$json['message'] = 'Messages fetched successfully!';    
    			$json['data'] = $results;
    			$this->set_response($json, REST_Controller::HTTP_OK);  

    		}else{
    			$this->response([
    				'code' =>400,
    				'status' => FALSE,
    				'message' => 'No messages!',
    				'data' => array()
    			], REST_Controller::HTTP_OK);
    		}



    	}else{
    		$this->response([
    			'code' =>400,
    			'status' => FALSE,
    			'message' => 'Selected user id missing!',
    			'data' => array()
    		], REST_Controller::HTTP_NOT_FOUND);

    	} 

    }

    Public function conversations_post()
    {


    	$user_data = $this->validate_user();  
    	$inputs = json_decode( file_get_contents( 'php://input' ), true );
    	if(empty($inputs)){
    		$inputs = $this->input->post();
    	}  




    	if(!empty($inputs['selected_user_id'])){

    		$where = array('id' => $inputs['selected_user_id']);
    		$users  = $this->db->get_where('applicants',$where)->row_array();
    		if(count($users) == 0){

    			$this->response([
    				'code' => 400,
    				'status' => FALSE,
    				'message' => 'Selected user id not valid !'            
    			], REST_Controller::HTTP_NOT_FOUND);


    		}



    		if(empty($inputs['time_zone'])){
    			$this->response([
    				'code' => 400,
    				'status' => FALSE,
    				'message' => 'time zone missing!',
    				'data' => array()
    			], REST_Controller::HTTP_NOT_FOUND);
    		}

    		$session_id = $inputs['user_id'];
    		$selected_user = $inputs['selected_user_id']; /* Selected user  id */
    		$time_zone = $inputs['time_zone'];


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

    				if($currentuser['sent_id'] == $user_data['applicant_id']){
    					$response['msg_type'] = 'OUTBOUND';

    				}elseif($currentuser['recieved_id'] == $user_data['applicant_id']){
    					$response['msg_type'] = 'INBOUND';
    				}

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

    				$selected_user_details = array(
    					'full_name' => $this->get_user_name($selected_user),
    					'profile_img' => $this->get_user_image($selected_user),
    				);
    				$results= array('chat_conversations'=>$datas,'selected_user_details'=>$selected_user_details);



    			endforeach;

    			$json['code'] = 200;
    			$json['status'] = TRUE;
    			$json['message'] = 'Messages fetched successfully!';    
    			$json['data'] = $datas;
    			$this->set_response($json, REST_Controller::HTTP_OK);  

    		}else{
    			$this->response([
    				'code' =>400,
    				'status' => FALSE,
    				'message' => 'No messages!',
    				'data' => array()
    			], REST_Controller::HTTP_OK);
    		}



    	}else{
    		$this->response([
    			'code' =>400,
    			'status' => FALSE,
    			'message' => 'Selected user id missing!',
    			'data' => array()
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


// Send Message 

    Public function send_message_post()
    {

    	$user_data = $this->validate_user();
    	$datas = json_decode( file_get_contents( 'php://input' ), true );
    	if(empty($datas)){
    		$datas = $this->input->post();
    	}  


    	if(!empty($datas['selected_user_id'])){
    		$where = array('id' => $datas['selected_user_id']);
    		$users  = $this->db->get_where('applicants',$where)->num_rows();
    		if($users == 0){

    			$this->response([
    				'code' => 400,
    				'status' => FALSE,
    				'message' => 'Selected user id not valid !'            
    			], REST_Controller::HTTP_NOT_FOUND);


    		}


    		if(empty($datas['time_zone'])){
    			$this->response([
    				'code' => 400,
    				'status' => FALSE,
    				'message' => 'time zone missing!'            
    			], REST_Controller::HTTP_NOT_FOUND);

    		} 
    		if(empty($datas['message'])){
    			$this->response([
    				'code' => 400,
    				'status' => FALSE,
    				'message' => 'Message missing!'            
    			], REST_Controller::HTTP_NOT_FOUND);

    		}


    		$this->normal_message($user_data);    

    		$time_zone = $datas['time_zone'];
    		$last_chat= $this->api->get_last_chat($datas['selected_user_id'],$datas['user_id']); 

    		$last_chat['type'] = 'message';
    		$last_chat['from_name'] = $this->get_user_name($last_chat['sent_id']);


    		$from_timezone = $last_chat['time_zone'];
    		$date_time = $last_chat['chatdate'];
    		$date_time  = $this->converToTz($date_time,$time_zone,$from_timezone);

    		$response['chat_time'] = date('Y-m-d H:i:s',strtotime($date_time));       
    		$last_chat['date_time'] = date('Y-m-d H:i:s',strtotime($date_time));       

    		$message = $last_chat['msg'];        
    		$response['content']= ($message)?$message:'';          
    		$response['chat_from']= $last_chat['sent_id'];  
    		$response['chat_to']= $last_chat['recieved_id'];          
    		$response['from_user_name']= $this->get_user_name($last_chat['sent_id']);  
    		$response['to_user_name']= $this->get_user_name($last_chat['recieved_id']);  
    		$response['profile_from_image']= $this->get_user_image($last_chat['sent_id']);  
    		$response['profile_to_image']= $this->get_user_image($last_chat['recieved_id']); 

    		$this->send_push_notification($last_chat);
     // echo '<pre>'; print_r($response);
     // exit;

    		$this->response([
    			'code' => 200,
    			'status' => TRUE,        
    			'message' => 'Message sent successfully!',
    			'data' => $response,
    		], REST_Controller::HTTP_OK);

    	}else{

    		$this->response([
    			'code' => 400,
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


    	$datas = json_decode( file_get_contents( 'php://input' ), true );
    	if(empty($datas)){
    		$datas = $this->input->post();
    	}  

    	$time_zone = $datas['time_zone'];
    	$from_timezone = date_default_timezone_get();
    	$date_time = date('Y-m-d H:i:s');
    	$date_time  = $this->converToTz($date_time,$time_zone,$from_timezone);
    	$data['sent_id'] =  $datas['user_id'];
    	$data['recieved_id']= $datas['selected_user_id'];
    	$data['time_zone'] =  $datas['time_zone'];
    	$data['chatdate'] = $date_time;
    	$data['msg'] = $datas['message'];



    if($datas['message']=='ENABLE_STREAM' || $datas['message'] =='DISABLE_STREAM'){ // Video stram messages neglected

    	$this->set_response([
    		'code' => 200,        
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
    		'code' => 200,            
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


    // Validating the user 
 Public function validate_user()
 {
   $data = json_decode( file_get_contents( 'php://input' ), true );
   if(empty($data)){
    $data = $this->input->post();
  }


  if(!empty($data['user_id'])){        
    $user = $this->api->get_user_data();
    if(!empty($user)){                        
     return $user;
            //$this->set_response($user, REST_Controller::HTTP_OK); 

   }else{                        
     $this->response([
      'code' => 400,
      'status' => FALSE,                
      'message' => 'User id not valid!'
    ], REST_Controller::HTTP_NOT_FOUND);
   }
 }else{

  $this->response([
   'code' => 400,
   'status' => FALSE,
   'message' => 'User id missing!'
 ], REST_Controller::HTTP_NOT_FOUND);

}

}




}
