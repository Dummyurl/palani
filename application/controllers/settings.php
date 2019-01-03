<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('type') != 'superadmin' ){
			redirect('login');
		}
		$this->load->model('setting_model','settings');
	}

	public function index()
	{

		$this->data['module'] = 'subject';        
		$this->load->vars($this->data);
		$this->load->view('template');

	}
	Public function get_all_subjects(){

		$list = $this->settings->get_all_subjects();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $g) {
			$row = array();                          
			$row[] = $i++;
			$row[] = $g->subject;
			$row[] = '<button class="btn btn-primary btn-xs" onclick="edit_subject('.$g->subject_id.')"><i class="fa fa-pencil"></i></button>
			<button class="btn btn-danger btn-xs" onclick="delete_subject('.$g->subject_id.')"><i class="fa fa-trash"></i></button>';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->settings->count_all_subject(),
			"recordsFiltered" => $this->settings->count_all_filtered_subjects(),
			"data" => $data,
		);
                //output to json format
		echo json_encode($output);		
	}
	Public function get_all_courses(){

		$list = $this->settings->get_all_courses();		
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $g) {
			$row = array();                          
			$row[] = $i++;
			$row[] = $g->subject;
			$row[] = $g->course;
			$row[] = '<button class="btn btn-primary btn-xs" onclick="edit_course('.$g->course_id.')"><i class="fa fa-pencil"></i></button>
			<button class="btn btn-danger btn-xs" onclick="delete_course('.$g->course_id.')"><i class="fa fa-trash"></i></button>';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->settings->count_all_course(),
			"recordsFiltered" => $this->settings->count_all_filtered_course(),
			"data" => $data,
		);
                //output to json format
		echo json_encode($output);		
	}

	Public function add_subject(){				
		$data =  array('subject' => $_POST['subject']);
		$result = array();

		if(!empty($_POST['subject'])){
			$count = $this->db->get_where('subject',array('subject'=>$_POST['subject'],'status' =>1))->num_rows();			
			if($count != 0){
				$result['error'] = 'Subject name already exist';

				
			}else{

				if(empty($_POST['subject_id'])){
					$this->db->insert('subject',$data);	

					$result['subject'] = $_POST['subject'];
					$result['subject_id'] = $this->db->insert_id();
					$result['success'] =  "Subject added successfully!";
 
				}else{
					$this->db->update('subject',$data,array('subject_id'=>$_POST['subject_id']));
					$result['subject'] = $_POST['subject'];
					$result['subject_id'] = $_POST['subject_id'];
					$result['success'] ="Subject updated successfully!";	
				}		
				
			}			
		}else{
			$result['error'] = 'Enter subject name';				
		}
		echo json_encode($result);
		
	}
	Public function get_subject_by_id(){
		$data = $this->db->get_where('subject',array('subject_id'=>$_POST['subject_id']))->row();
		echo json_encode($data);
	}
	Public function get_course_by_id(){
		$data = $this->db->get_where('courses',array('course_id'=>$_POST['course_id']))->row();
		echo json_encode($data);
	}

	Public function add_course(){
		$data = array(
			'subject_id' => $_POST['subject_id'],
			'course' => $_POST['course']			
		);

		if(empty($_POST['course_id'])){
			 $this->db->insert('courses',$data);		
			 $result ="Course added successfully!";
		}else{
			$where = array('course_id' => $_POST['course_id']);
			 $this->db->update('courses',$data,$where);	
			 $result ="Course updated successfully!";	
		}
		echo $result;	
	}
	Public function get_subjects()
	{
		$json = array();
		$data = $this->settings->get_subjects();
		if(!empty($data)){
			foreach ($data as $d) {
				$res['label'] = $d->subject;
				$res['value'] = $d->subject_id;
				$json[]=$res;
			}			
		}
		echo json_encode($json);
	}
	Public function delete_subject(){
		$this->db->update('subject',array('status'=>0),array('subject_id'=>$_POST['subject_id']));
		$this->db->update('courses',array('status'=>0),array('subject_id'=>$_POST['subject_id']));
		return true;
	}
	Public function delete_course(){		
		$this->db->update('courses',array('status'=>0),array('course_id'=>$_POST['course_id']));
		return true;
	}

}

/* End of file  */
/* Location: ./application/controllers/ */