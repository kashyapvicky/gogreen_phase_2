<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class User extends MX_Controller {

	function __construct()
    {
		parent::__construct();
		$this->load->model('user_model');
		$bool = $this->session->userdata('authorized');

		if($bool != 1)
		{
			//echo $bool; die;
			redirect('admin');
		}
	}
	public function index()
	{
    $users = $this->user_model->get_all_users();
	//echo "<pre>";print_r($users);die;
    $data['users'] =$users;
    $data['page'] ='user_view';
		//$this->template->load('template', 'user_view',$data);
		_layout($data);
	}

	public function get_user_car_details()
	{
		$id = $this->input->get('id');;
		$car_detail = $this->user_model->get_car_details($id);

		$user_personal_detail = $this->user_model->get_user_detai($id);
		$data['personal_detail'] = $user_personal_detail;

		//echo "<pre>";print_r($car_detail);die;
		$data['user_detail'] = $car_detail;
		 $data['page'] ='user_car_view';
		//$this->template->load('template', 'user_view',$data);
		_layout($data);
		//$this->template->load('template', 'user_car_view',$data);
		//echo "<pre>";print_r($car_detail); die;
	}
	public function purchase_history()
	{
		$id= $this->input->get('id');
		$user_id= $this->input->get('u_id');
		$row = $this->user_model->get_purchase_history($id,$user_id);
		$data['purchase_history'] = $row;
		$data['page'] ='purchase_history';
		_layout($data);

		//$this->template->load('template', 'purchase_history',$data);
	}
}   
  

	

