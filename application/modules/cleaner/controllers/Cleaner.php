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

		$city = $this->cleaner_model->get_city();
		$data['city'] =$city;
		$localities_id = $this->input->post('locality_id');
		$cleaners = $this->cleaner_model->get_all_cleaners($localities_id);

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
		$row_array = $this->cleaner_model->check_email($email);
		$image_string='iVBORw0KGgoAAAANSUhEUgAAAMIAAADCCAYAAAAb4R0xAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDIxIDc5LjE1NTc3MiwgMjAxNC8wMS8xMy0xOTo0NDowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTQgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkY5MjJFMDZDQjBFQjExRThCMUU1RUE3QTg1QTlEMkJCIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkY5MjJFMDZEQjBFQjExRThCMUU1RUE3QTg1QTlEMkJCIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6RjkyMkUwNkFCMEVCMTFFOEIxRTVFQTdBODVBOUQyQkIiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6RjkyMkUwNkJCMEVCMTFFOEIxRTVFQTdBODVBOUQyQkIiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4zD1ZIAAAVZUlEQVR42uxd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';
		if($row_array)
		{
			$this->session->set_flashdata('phone_exist','Email Already Exist');
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
				'image_string'=>$image_string
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
			// echo"here die;";
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
			// echo $city; die;
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$row_array = $this->cleaner_model->check_phone_number($email,$cleaner_id);
			if($row_array && $flag!=1)
			{
				$this->session->set_flashdata('phone_exist','Email Already Exist');
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
					'city_id'=>$city,
					'locality_id'=>$locality
					
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
		$city_array = $this->cleaner_model->get_city();
		$data['cities'] = $city_array;
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
			$this->cleaner_model->delete_this_cleaner_row_from_team_cleaner_tabel($cleaner_id);
			$this->session->set_flashdata('cleaner_delleted','Cleaner deleted successfully');
		}
		else
		{
			echo"<script>alert('Error IN Deletion');</script>";
		}
		redirect('cleaner');
	}
	public function cleaner_job_detail()
	{
		$cleaner_id = $this->input->get('id');

		$work_history = $this->cleaner_model->get_cleaner_job_done_detail($cleaner_id);
		// echo"<pre>";print_r($work_history); die;
		$data['history'] = $work_history;
		$data['page'] = 'cleaner_job_history';
		_layout($data);
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
  

	

