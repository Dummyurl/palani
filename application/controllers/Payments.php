<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payments extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

			if($this->session->userdata('applicant_id') ==''){
			redirect('login');
			}
		 $this->timezone = $this->session->userdata('time_zone');
   if(!empty($this->timezone)){
   	date_default_timezone_set($this->timezone);
   }

		$this->type = $this->session->userdata('type');
		$this->load->model('payment_model','payment');
	}

	public function index()
	{
			switch ($this->type) {
				case 'guru':					
				$this->data['theme']=$this->type;
					break;
				case 'user':					
				$this->data['theme']='applicant';
					break;	
				case 'superadmin':					
				$this->data['theme']=$this->type;
				break;				
			}
			$this->data['title'] = 'Payments';
			$this->data['module'] = 'payments';
			$this->load->vars($this->data);
			$this->load->view('template');
		
	}
	Public function payment_list(){
		$list = $this->payment->get_all_payments();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $g) {
			$row = array();                          
			$row[] = $i++;
			$row[] = date('d-m-Y',strtotime($g->request_date));
			$row[] = '$'.$g->request_amount;
			$row[] = ($g->resolved_date!='0000-00-00')?date('d-m-Y',strtotime($g->resolved_date)):'-';

			switch ($this->type){
				case 'superadmin':

				$user = $this->db->select('a.type,a.username,a.first_name,a.last_name,a.profile_img,a.id,s.picture_url')
								->join('social_applicant_user s','a.id = s.reference_id','left')
								->get_where('applicants a',array('a.id' => $g->mentor_id))->row();				

				
			if(!empty($user->profile_img) && empty($user->picture_url) ||  !empty($user->profile_img) && !empty($user->picture_url)){
            		$mentor_img = $user->profile_img;    
               $file_to_check = FCPATH . '/assets/images/' . $mentor_img;
	              if (file_exists($file_to_check)) {
	              $mentor_img = base_url() . 'assets/images/'.$mentor_img;
	              }else{
	              $mentor_img = base_url() . 'assets/images/default-avatar.png';
	              }  
              }else if(empty($user->profile_img) && !empty($user->picture_url)){
              	 $mentor_img = $user->picture_url;      
              }else{
             	 $mentor_img = base_url() . 'assets/images/default-avatar.png';
              }

              if($user->type == 'guru'){
              	$type='Mentor';
              }else{
              	$type='Mentee';
              }

              $row[] ='<a href="'.base_url().'mentor-profile/'.$user->username.'" title="'.$type.'"><img src="'.$mentor_img.'" class="img-circle" height="40" width="40">&nbsp;&nbsp;'.$user->first_name.' '.$user->last_name.'</a>';

				if( $g->status == 1){
				$status='<div class="dropdown">						
                        <button class="btn-xs btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" id="btn_'.$g->payment_id.'">Requested <span class="caret"></span></button>  
                        <ul class="dropdown-menu">     
                        <li><a href="javascript:void(0);" onclick="pay_amount('.$g->payment_id.','.$g->request_amount.')">Pay</a></li>
                        <li><a href="javascript:void(0);" onclick="reject_amount('.$g->payment_id.','.$g->request_amount.')">Rejected</a></li>
                        </ul>                          
                        </div>';	

			}elseif( $g->status == 2){
				$status='<button class="btn btn-xs btn-success">Paid</button>';				
			}elseif( $g->status == 3){						
				$status='<button class="btn btn-xs btn-danger">Rejected</button>';	
			}
				break;

				default :

				if( $g->status == 1){				
				$status='<button class="btn btn-xs btn-info">Requested</button>';	
				}elseif( $g->status == 2){
					if($this->session->userdata('type') == 'guru'){
						$status='<button class="btn btn-xs btn-success">Paid</button>';	
					}else{
						$status='<button class="btn btn-xs btn-success">Refunded</button>';	
					}
				}elseif( $g->status == 3){						
				$status='<button class="btn btn-xs btn-danger">Rejected</button>';	
				}


				break;
			}

			$row[]=$status;			
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->payment->count_all_payment(),
			"recordsFiltered" => $this->payment->count_all_filtered_payment(),
			"data" => $data,
		);
                //output to json format
		echo json_encode($output);	
	}


	Public function pay_amount(){
		$data = array('status'=>2,'admin_description'=>$_POST['description'],'resolved_date' => date('Y-m-d'));
		$result = 	$this->db->update('pay_request_details',$data,array('payment_id'=>$_POST['payment_id']));
		echo json_encode(array('status'=>$result));
	}
	Public function reject_amount(){
		$data = array('status'=>3,'admin_description'=>$_POST['description'],'resolved_date' => date('Y-m-d'));
		$result = 	$this->db->update('pay_request_details',$data,array('payment_id'=>$_POST['payment_id']));
		echo json_encode(array('status'=>$result));
	}

}
