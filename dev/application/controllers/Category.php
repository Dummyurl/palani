<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function index()
	{
		$this->load->view('home');
	}

	Public function get_countries()
	{


		$datas = array();
		$query=$this->db->get('country');
        $result= $query->result();
        $data=array();
		foreach($result as $r)
		{
			$data['value']=$r->countryid;
			$data['label']=$r->country;
			$json[]=$data;
			
			
		}
		$datas['country'] = $json;

		if(!empty($_POST['countryid'])){
		$data=array();

		$result=$this->db->where('countryid',$_POST['countryid'])
		->get('state')
		->result();

		$data=array();
		foreach($result as $r){
		$data['value']=$r->id;
		$data['label']=$r->statename;
		$json1[]=$data;						
		}
		$datas['state'] = $json1;
		}
		if(!empty($_POST['stateid'])){
		$data=array();

		$result=$this->db->where('stateid',$_POST['stateid'])
		->get('city')
		->result();

		$data=array();
		foreach($result as $r){
		$data['value']=$r->id;
		$data['label']=$r->city;
		$json2[]=$data;						
		}
		$datas['city'] = $json2;
		}
		
		echo json_encode($datas);
		

	
	}

	Public function get_states()
	{
		$json=array();
		  $result=$this->db->where('countryid',$_POST['id'])
						->get('state')
						->result();
     
        $data=array();
		foreach($result as $r)
		{
			$data['value']=$r->id;
			$data['label']=$r->statename;
			$json[]=$data;
			
			
		}
		echo json_encode($json);

	}

		Public function get_cities()
	{

		$json=array();
		  $result=$this->db->where('stateid',$_POST['id'])
						->get('city')
						->result();
     
        $data=array();
		foreach($result as $r)
		{
			$data['value']=$r->id;
			$data['label']=$r->city;
			$json[]=$data;
			
			
		}
		echo json_encode($json);

	}


}
