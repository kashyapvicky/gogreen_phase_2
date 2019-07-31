<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Cleaner extends MX_Controller {

	function __construct()
    {
		parent::__construct();
		$this->load->model('cleaner_model');
		$bool = $this->session->userdata('authorized');

		if($bool != 1)
		{
			//echo $bool; die;
			redirect('admin');
		}
	}
	public function index()
	{
    $cleaners = $this->cleaner_model->get_all_cleaners();

    $data['cleaners'] =$cleaners;
		//$this->template->load('template', 'cleaner_view',$data);
     $data['page'] ='cleaner_view';
    	_layout($data);
	}
	public function add_cleaner()
	{
		$city_array = $this->cleaner_model->get_city();
		$data['cities'] = $city_array;
		$data['page'] = 'add_cleaner_view';
		_layout($data);
	}
	public function get_locality()
	{
		$city_id = $this->input->post('city_id');
		$locality_array =$this->cleaner_model->get_locality_by_ajax($city_id);
		//echo "<pre>";print_r($locality_array); die;
		$output = '';
		foreach($locality_array as $key=>$value)
		{
			$output.='
			<option value='.$value['id'].'>'.$value['name'].'</option>
			';
		}
		echo json_encode($output);
	}
	public function insert_cleaner()
	{
		$first_name = $this->input->post('first_name');
		if($this->input->post('last_name'))
		{
			$last_name = $this->input->post('last_name');
		}
		else
		{

			$last_name = '';
		}
		$phone_number = $this->input->post('phone_number');
		$city = $this->input->post('city');
		$locality = $this->input->post('locality');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$row_array = $this->cleaner_model->check_phone_number($phone_number);
		if($row_array)
		{
			$this->session->set_flashdata('phone_exist','phone already exist');
			redirect('cleaner/add_cleaner');
		}
		else
		{
			$data = array(

				'first_name'=>$first_name,
				'last_name'=>$last_name,
				'email'=>$email,
				'password'=>$password,
				'phone_number'=>$phone_number,
				'city_id'=>$city,
				'locality_id'=>$locality,
			);
			$bool = $this->cleaner_model->insert_cleaner_data($data);
			if($bool)
			{
				$this->session->set_flashdata('cleaner_added','cleaner added');
			}
			else{

				$this->session->set_flashdata('cleaner_error','cleaner added');
			}
		}
		redirect('cleaner');
	}
	public function edit_cleaner()
	{
		$cleaner_id = $this->input->get('id');
		if($_POST)
		{
			echo"here die;";
			$first_name = $this->input->post('first_name');
			if($this->input->post('last_name'))
			{
				$last_name = $this->input->post('last_name');
			}
			else
			{

				$last_name = '';
			}
			$phone_number = $this->input->post('phone_number');
			$city = $this->input->post('city');
			$locality = $this->input->post('locality');
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$row_array = $this->cleaner_model->check_phone_number($phone_number,$cleaner_id);
			if($row_array && $flag!=1)
			{
				$this->session->set_flashdata('phone_exist','phone already exist');
				$flag=1;
				redirect('cleaner/edit_cleaner?id='.$cleaner_id.'');
			}
			else
			{
				$data = array(

					'first_name'=>$first_name,
					'last_name'=>$last_name,
					'email'=>$email,
					'password'=>$password,
					'phone_number'=>$phone_number,
					
				);
				$bool = $this->cleaner_model->update_cleaner_data($data,$cleaner_id);
				if($bool)
				{
					$this->session->set_flashdata('cleaner_added','cleaner added');
					redirect('cleaner');
				}
				else{

					$this->session->set_flashdata('cleaner_error','cleaner added');
				}
			}
		}



		$cleaner_id = $this->input->get('id');
		$row = $this->cleaner_model->get_cleaner_to_edit($cleaner_id);
		$data['cleaner']=$row;
		$data['page']='edit_cleaner';
		_layout($data);
	}
	public function inactive_cleaner()
	{
		$cleaner_id = $this->input->get('id');
		// echo $cleaner_id; die;
		$bool = $this->cleaner_model->inactivate_cleaner($cleaner_id);
		if($bool)
		{
			$this->session->set_flashdata('cleaner_delleted','Cleaner deleted successfully');
		}
		else
		{
			echo"<script>alert('Error IN Deletion');</script>";
		}
		redirect('cleaner');
	}
}   
  

	

