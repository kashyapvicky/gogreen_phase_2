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
		$localities_id = $this->input->post('locality_id');
		$bool = $this->input->get('cashtab');
		if(empty($bool))
		{
			$online_orders = $this->orders_model->get_all_orders(2,$localities_id);
			//echo "<pre>";print_r($online_orders); die;
			$data['orders'] = $online_orders;
			// echo"<pre>";print_r($data['orders']); die;
		}
		else
		{
			$cod_orders = $this->orders_model->get_all_orders(1,$localities_id);
			$data['orders'] = $cod_orders;
			// echo"<pre>";print_r($data['orders']); die;
		}
		$city = $this->orders_model->get_city();
		$data['city'] =$city;
     	$data['page'] = 'orders_view';
     	_layout($data);
	}

	public function get_customer_detail()
	{
		$user_id = $this->input->get('id');
		$primary_id = $this->input->get('primary_id');
		if(!empty($primary_id))
		{	
			$this->session->set_userdata('primary_id',$primary_id);
		}
		$row = $this->orders_model->get_user_detail_by_id($user_id);
		//echo $this->db->last_query(); die;
		//print_r($row); die;
		$data['customer_detail'] = $row;
		$data['page'] = 'customer';
		_layout($data);
	}
	public function package_detail()
	{
		$primary_id = $this->session->userdata('primary_id');
		// echo $primary_id; die;
		$user_id = $this->input->get('id');
		$packages = $this->orders_model->get_packages_detail($user_id,$primary_id);
		//echo"<pre>";print_r($packages); die;
		$data['user_id'] = $user_id;
		$data['packages'] = $packages;
		$data['page'] = 'packages_detail';
		_layout($data);
	}public function car_detail()
	{
		$user_id = $this->input->get('id');
		$primary_id = $this->session->userdata('primary_id');
		$cars = $this->orders_model->get_car_detail($user_id,$primary_id);
		$data['user_id'] = $user_id;
		$data['cars'] = $cars;
		$data['page'] = 'car_detail';
		_layout($data);
	}
	public function crew_detail()
	{
		$primary_id = $this->session->userdata('primary_id');
		$user_id = $this->input->get('id');
		$data['user_id'] = $user_id;

		$crew_row = $this->orders_model->get_crew_detail($user_id,$primary_id);
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
	public function add_remark()
	{
		$remark = $this->input->post('remark');
		$user_id = $this->input->post('hidden_user_id');
		$partial_amount = $this->input->post('partial_amount');
		$id = $this->input->post('payment_key_remark');
		$bool = $this->orders_model->update_remark($id,$remark,$partial_amount);
		// echo $this->db->last_query(); die;

		if($bool)
		{
			// make a entry in payment_collected_taber in order to show the complete history;
			$data = array
			(
				'user_id'=>$user_id,
				'payment_key'=>$id,
				'amount_collected'=>$partial_amount,
				'created_at'=>date('Y-m-d'),
				'particulars'=>$remark,
				'credited_by'=>'admin'
			);

			$insert_id = $this->orders_model->insert_payment_record($data);
			if($insert_id)
			{
				// this query will change the status only if partial amount and net_paid amount are same
				$bool = $this->orders_model->change_status_as_payment_recieved($id);
				$this->session->set_flashdata('data_registered','Payment Inserted Succesfully');
			}

			$this->session->set_flashdata('remark_added','Remark Succesfully Added');
			redirect(base_url('orders/index?cashtab=1'));
		}
	}
	public function update_payment_status_as_collected()
	{
		$order_id = $this->input->post('order_id');
		$bool = $this->orders_model->update_payment_status($order_id);
		$this->session->set_flashdata('status_changed','Succesfull');;
		echo json_encode($bool);
	}
	public function get_locality_for_street()
	{
		 $city_id = $this->input->post('city_id');
		// $city_id=3;
		 $localities = $this->cleaner_model->get_locality_ajax($city_id);
		 $output = '';
		 foreach ($localities as $key => $value)
		 {
		 	$output .='<label for="one">
        <input name="locality_id[]" type="checkbox" value="'.$value['id'].'" id="'.$value['id'].'" />'.$value['name'].'</label>';
		 } 
		 $data = array(
			'option'=>$output,
		 );
		 //print_r($data); die;
		 echo json_encode($data);
	}
}

  

	

