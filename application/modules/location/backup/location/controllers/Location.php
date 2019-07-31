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
		//$locality = $this->location_model->get_locality();
		//print_r($city); die;
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
			$street = $this->input->post('street');
			$data = array
			(
				'locality_id' =>$locality_id,
				'name' => $street,
			);
			$bool = $this->location_model->insert_street($data);
			if($bool)
			{	
				$this->session->set_flashdata('last_insert_street_id_to_call_ajax', $locality_id);
				$this->session->set_flashdata('street_added_succesfully','Locality Sucessfully Added');
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
		 	$output_streets .='<tr>
		 	<td></td>
		 	<td>'.$value["name"].'</td>		 	
		  	</tr>';
		 } 
		 $data = array(

			'streets'=>$output_streets

		 );
		 //print_r($data); die;
		 echo json_encode($data);
	}

}   
  

	

