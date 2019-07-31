<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Orders extends MX_Controller {

	function __construct()
    {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('orders_model');
		$bool = $this->session->userdata('authorized');
		//echo $bool; die;

		if($bool != 1)
		{
			//echo $bool; die;
			redirect('admin');
		}
	}
	public function index()
	{
		//echo"here";die;
		$bool = $this->input->get('cashtab');
		if(empty($bool))
		{
			$online_orders = $this->orders_model->get_all_orders(2);
			//echo "<pre>";print_r($online_orders); die;
			$data['orders'] = $online_orders;
			// echo"<pre>";print_r($data['orders']); die;
		}
		else
		{
			$cod_orders = $this->orders_model->get_all_orders(1);
			$data['orders'] = $cod_orders;
			// echo"<pre>";print_r($data['orders']); die;
		}
     	$data['page'] = 'orders_view';
     	_layout($data);
	}

	public function get_customer_detail()
	{
		$user_id = $this->input->get('id');
		$row = $this->orders_model->get_user_detail_by_id($user_id);
		//echo $this->db->last_query(); die;
		//print_r($row); die;
		$data['customer_detail'] = $row;
		$data['page'] = 'customer';
		_layout($data);
	}
	public function package_detail()
	{
		$user_id = $this->input->get('id');
		$packages = $this->orders_model->get_packages_detail($user_id);
		//echo"<pre>";print_r($packages); die;
		$data['user_id'] = $user_id;
		$data['packages'] = $packages;
		$data['page'] = 'packages_detail';
		_layout($data);
	}public function car_detail()
	{
		$user_id = $this->input->get('id');
		$cars = $this->orders_model->get_car_detail($user_id);
		$data['user_id'] = $user_id;
		$data['cars'] = $cars;
		$data['page'] = 'car_detail';
		_layout($data);
	}
	public function crew_detail()
	{
		$user_id = $this->input->get('id');
		$data['user_id'] = $user_id;

		$crew_row = $this->orders_model->get_crew_detail($user_id);
		$data['crew']=$crew_row;

		$data['page'] = 'crew_detail';
		_layout($data);
	}
	public function history()
	{
		$user_id = $this->input->get('id');
		$data['user_id'] = $user_id;
		$history = $this->orders_model->get_user_history($user_id);
		$data['history'] = $history;
		$data['page'] = 'history';
		_layout($data);
	}
	public function cash()
	{
		$user_id = $this->input->get('id');
		$data['user_id'] = $user_id;
		$data['page'] = 'customer';
		_layout($data);
	}
	public function pending()
	{
		$pending_orders = $this->orders_model->get_pending_payment_order();
		$data['pending_orders'] = $pending_orders;
		$data['page']='pending_view';
		_layout($data);
	}
	public function get_teams_working_on_this_order()
	{
		$id = $this->input->post('primary_id');
		// $id = 20;
		$teams = $this->orders_model->get_teams_working_on_this_package($id);
		$output='';
		if(!empty($teams))
		{	$output.='<option value="">Select A Team</option>';
			foreach ($teams as $key => $value)
			{
				$output.=
				'
				<option value="'.$value['team_id'].'"">'.$value['team_name'].'</option>
				';		
			}
		}
		else
		{
			$output = 5;
		}

		echo json_encode($output);
	}


	public function change_team()
	{
		$team_id = $this->input->post('team_id');
		$payment_key = $this->input->post('payment_key');

		$bool = $this->orders_model->update_assiagned_team_tabel($team_id,$payment_key);
		// echo $this->db->last_query(); die;
		if($bool)
		{
			$this->session->set_flashdata('team_change','team Changed Successfully');
			redirect('orders');
		}
		else
		{

				$this->session->set_flashdata('team_change','Error In changing Team');
		}
	}
}   
  

	

