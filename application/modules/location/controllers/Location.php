<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Location extends MX_Controller {

	function __construct()
    {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('location_model');
		$bool = $this->session->userdata('authorized');

		if($bool != 1)
		{
			//echo $bool; die;
			redirect('admin');
		}
	}
	public function index()
	{
		$city = $this->location_model->get_city();
		$inactive_city_array=$this->location_model->inactive_cities();
		$inactive_locality_array=$this->location_model->inactive_localities();

		$data['inactive_city'] = $inactive_city_array;
		$data['inactive_locality'] = $inactive_locality_array;
		$data['city'] =$city;
		$data['page'] ='location_view';
		_layout($data);
   		//$this->template->load('template', 'location_view',$data);
	}
	
	public function addcity()
	{
		if($_POST)
		{
			$city = $this->input->post('city');
			$row = $this->location_model->is_city_already_exist($city);
			if($row)
			{
				// echo"<script>alert('City Already Exist')</script>";
				$this->session->set_flashdata('city_exist','City Already Exist');
				redirect('location');
			}
			else
			{

				$data =array('name' =>$city);
				$bool = $this->location_model->insert_city($data);
				if($bool)
				{
					redirect('location');
				}
				else
				{
					echo"<script>alert('Error')</script>";
				}
			}
		}
	}

	public function addlocality()
	{
		$this->form_validation->set_rules('city_select', 'Select City', 'required');
		$this->form_validation->set_rules('locality', 'Locality', 'required');
		$this->form_validation->set_rules('service_start', 'Start Time', 'required');
		$this->form_validation->set_rules('service_end', 'End Time', 'required');

		if ($this->form_validation->run() == TRUE)
		{

			$city_id = $this->input->post('city_select');
			$locality_name = $this->input->post('locality');

			$row = $this->location_model->is_locality_already_exist($city_id,$locality_name);
			if($row)
			{
				$this->session->set_flashdata('locality_exist','Locality Already Exist');
				redirect('location');
			}
			else
			{

				$start_time = $this->input->post('service_start');
				$end_time = $this->input->post('service_end');
				$data = array
				(
					'name' => $locality_name,
					'city_id' =>$city_id,
					'start_time' => $start_time,
					'end_time' => $end_time
				);
				$last_id = $this->location_model->insert_locality($data);
				if($last_id)
				{
					$this->session->set_flashdata('last_insert_id_to_call_ajax', $city_id);
					$this->session->set_flashdata('locality_added_succesfully','Locality Sucessfully Added');
				}
			}
		}
		else
		{
			$this->session->set_flashdata('error', validation_errors());

		}
		//redirect(base_url('admin'));
		redirect(base_url('location'));
	}


	public function get_locality()
	{
		 $city_id = $this->input->post('city_id');
		

		 $localities = $this->location_model->get_locality_ajax($city_id);
		 $output = '';
		 foreach ($localities as $key => $value)
		 {
		 	$output .='<tr>
		 	<td>'.$value["name"].'</td>
		 	<td>'.$value["start_time"].'-'.$value["end_time"].'</td>
		 	<td>
		 	<div class=""><a href="#editmodal_locality" onclick="edit_locality_ajax('.$value["id"].')" data-toggle="modal"><span class="fa fa-edit"></span></div>
		 	</td>
		 	<td>
		 	<div class="to_inactive_locality"><a href="'.base_url().'location/do_locality_inactive?id='.$value['id'].'"><span class="fa fa-close"></span></div>
		 	</td>
		 	
		  	</tr>';
		 } 
		 $data = array(

			'table'=>$output

		 );
		 //print_r($data); die;
		 echo json_encode($data);
	}



	public function get_locality_for_street()
	{
		 $city_id = $this->input->post('city_id');
		

		 $localities = $this->location_model->get_locality_ajax($city_id);
		 $output = '';
		 $output.='
		 <option value="" disabled selected> Select Locality</option>';
		 foreach ($localities as $key => $value)
		 {
		 	$output .='
		 	<option value ='.$value["id"].'>'.$value["name"].'</option>';
		 } 
		 $data = array(

			'option'=>$output,
			'dropdown'=>$output

		 );
		 //print_r($data); die;
		 echo json_encode($data);
	}




	public function addstreet()
	{
		$this->form_validation->set_rules('city_select', 'Select City', 'required');
		$this->form_validation->set_rules('locality_select', 'Locality', 'required');
		$this->form_validation->set_rules('street', 'Street', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			//$city_id = $this->input->post('city_select');
			$locality_id = $this->input->post('locality_select');
			$city_id = $this->input->post('city_select');
			$street = $this->input->post('street');
			$payment_type = $this->input->post('payment_type');
			$row = $this->location_model->is_street_already_exist($locality_id,$city_id,$street);
			// print_r($row); die;
			if($row)
			{
				$this->session->set_flashdata('street_exist','Street Already Exist');
			}
			else
			{

				$data = array
				(
					'city_id'=>$city_id,
					'locality_id' =>$locality_id,
					'name' => $street,
					'payment_type'=>$payment_type
				);
				$bool = $this->location_model->insert_street($data);
				if($bool)
				{	
					$this->session->set_flashdata('last_insert_street_id_to_call_ajax', $locality_id);
					$this->session->set_flashdata('street_added_succesfully','Street Sucessfully Added');
				}
			}
		}
		else
		{
			$this->session->set_flashdata('error_street', validation_errors());

		}
		//redirect(base_url('admin'));
		redirect(base_url('location'));
	}

	public function get_streets()
	{
		 $locality_id = $this->input->post('locality_id');
		

		 $streets = $this->location_model->get_streets_ajax($locality_id);
		 $output_streets ='';
		 foreach ($streets as $key => $value)
		 {
		 	if($value['payment_type']==2)
		 	{
		 		$type = "Quickshine";
		 	}
		 	else
		 	{
		 		$type = "Go Green";
		 	}
		 	$output_streets .='<tr>
		 	<td></td>
		 	<td>'.$value["name"].'</td>
		 	<td>'.$type.'</td>
		 	<td>
		 	<div class=""><a href="#stree_modal_edit" onclick="edit_street_ajax('.$value["id"].')" data-toggle="modal"><span class="fa fa-edit"></span></div>
		 	</td>
		 	<td>
		 	<div class=""><a href="'.base_url().'location/do_street_inactive?id='.$value['id'].'"><span class="fa fa-close"></span></div>
		 	</td>

		  	</tr>';
		 } 
		 $data = array(

			'streets'=>$output_streets

		 );
		 //print_r($data); die;
		 echo json_encode($data);
	}
	public function remove_city_data()
	{
		$city_id = $this->input->get('id');
		$bool = $this->location_model->inactive_city_locality_street($city_id);
		if($bool)
		{
			$this->session->set_flashdata('SUCC_INACTIVE','City Deleted Successfully');
			//redirect('location');
		}
		else
		{
			$this->session->set_flashdata('city_del_error','CANNOT DELETED CITY');
		}
		redirect('location');
	}
	public function do_active()
	{
		$id = $this->input->get('id');
		$bool = $this->location_model->activate_city($id);
		if($bool)
		{
			$this->session->set_flashdata('succ_active','SUCCESS');
		}
		else
		{
			$this->session->set_flashdata('succ_active','ERROR');
		}
		redirect('location');
	}
	public function do_street_inactive()
	{
		$street_id =$this->input->get('id');
		$bool = $this->location_model->inactivte_street($street_id);
		if($bool)
		{
			$this->session->set_flashdata('street_inactive','Successfully Deleted');
		}
		else
		{
			$this->session->set_flashdata('street_inactive','Something Went Wrong');
		}
		redirect('location'); 
	}
	public function do_locality_inactive()
	{
		$locality_id =$this->input->get('id');
		$bool = $this->location_model->inactivte_locality($locality_id);
		if($bool)
		{
			$this->session->set_flashdata('locality_inactive','Successfully Deleted');
		}
		else
		{
			$this->session->set_flashdata('locality_inactive','Something Went Wrong');
		}
		redirect('location'); 
	}
	public function do_active_locality()
	{
		$id = $this->input->get('id');
		$bool = $this->location_model->activate_locality($id);
		if($bool)
		{
			$this->session->set_flashdata('succ_active_locality','SUCCESS');
		}
		else
		{
			$this->session->set_flashdata('succ_active_locality','ERROR');
		}
		redirect('location');
	}
	public function get_city_to_edit()
	{
		$city_id =$this->input->post('city_id');
		$row = $this->location_model->get_city_to_edit($city_id);
		echo json_encode($row);
	}

	public function editcity()
	{
		$city_name = $this->input->post('city');
		$city_id = $this->input->post('city_ajax_id');
		$bool = $this->location_model->edit_city($city_name,$city_id);
		// echo $this->db->last_query(); die;
		redirect('location');
	}

	public function get_locality_to_edit()
	{
		 $locality_id = $this->input->post('locality_id');
		 $localities = $this->location_model->get_locality_to_edit($locality_id);
		 echo json_encode($localities);
	}
	public function get_street_to_edit()
	{
		 $street_id = $this->input->post('street_id');
		 $localities = $this->location_model->get_street_to_edit($street_id);
		 echo json_encode($localities);
	}
	public function update_locality()
	{
		$locality_id = $this->input->post('edit_locality_id');
		$name = $this->input->post('locality');
		$start_time = $this->input->post('service_start');
		$end_time = $this->input->post('service_end');
		$data = array('name'=>$name,'start_time'=>$start_time,'end_time'=>$end_time);
		$this->location_model->update_locality($data,$locality_id);
		redirect('location');
	}
	public function update_street()
	{
		$street_id = $this->input->post('street_hidden_id');
		$payment_type = $this->input->post('payment_type');
		$name = $this->input->post('street');
		$this->location_model->update_street($name,$street_id,$payment_type);
		redirect('location');
	}
		

}   
  

	

