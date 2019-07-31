<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Car extends MX_Controller {

	function __construct()
    {
		parent::__construct();
		$this->load->model('car_model');
		$bool = $this->session->userdata('authorized');

		if($bool != 1)
		{
			//echo $bool; die;
			redirect('admin');
		}
	}
	public function index()
	 {
 
	 	$brand_model_array = $this->car_model->get_brand_with_models();
	 	$all_brands = $this->car_model->get_all_brands();
	 	$data['all_brands'] = $all_brands;
	 	$all_models = $this->car_model->get_all_models();
	 	$data['all_models'] = $all_models;
	 	$data['brand_model'] =$brand_model_array; 
	 	$data['page'] = 'car_brand_model_list';
	 	_layout($data);
		//$this->template->load('template', 'car_brand_model_list',$data);
	}
	public function add_brand_with_model()
	{
		$brand_array = $this->car_model->get_brands();
    	$data['brands'] = $brand_array;
    	$data['page'] ='car_view';
    	_layout($data);
		//$this->template->load('template', 'car_view',$data);
	}
	public function insert_models()
	{
		//print_r($_POST['model']);
		//echo "<pre>";print_r($_POST);
		$brand = $this->input->post('brand');
		$model = $this->input->post('model');
		//print_r($model);die;
		$bool=0;
		foreach ($model as $key => $value)
		{
			$data=array(
				'name'=>$value,
				'brand_id'=>$brand,
				'type'=>'admin'
			);
			$bool = $this->car_model->insert_model($data);
			
		}
		if($bool)
			{
				$this->session->set_flashdata('added_model','model added');
			}
			else
			{
				$this->session->set_flashdata('failure_model','model added');
			}

		redirect('car');
	}
	public function addbrand()
	{
		$name = $this->input->post('add_brand');
		$type='admin';
		if(!empty($name))
		{
			$data=array(
				'type' =>$type,
				'name'=>$name
			);

			$bool = $this->car_model->add_brand($data);
			if($bool)
			{
				$this->session->set_flashdata('added','brand added');
			}
			else
			{
				$this->session->set_flashdata('failure','brand added');
			}
		}
		else
		{
			echo"<script>alert('Please Enter Brand')</script>";
		}
		redirect('car/add_brand_with_model');
	}
	public function delete_brand_model()
	{
		$brand_id = $this->input->get('b_id');
		$model_id = $this->input->get('m_id');
		if(!empty($brand_id && $model_id))
		{
			$bool = $this->car_model->delete_brand_and_model($brand_id,$model_id);
			if($bool)
			{
				$this->session->set_flashdata('del_succ','delete');
			}
			else
			{
				$this->session->set_flashdata('del_err','delete');
			}
		}
		redirect('car');

	}
	public function get_brand_model_to_edit()
	{
		$brand_id = $this->input->post('brand_id');
		// $brand_id=1;
		$row = $this->car_model->get_brands_and_model($brand_id);
		// echo $this->db->last_query(); die;
		echo json_encode($row);
		// print_r($row); die;
	}
	public function edit_brand_model()
	{
		$brand_id = $this->input->post('brand_id_edit');
		$brand_name = $this->input->post('brand_edit');
		$model_name = $this->input->post('modal_edit');
		$model_id = $this->input->post('modal_id_edit');
		$this->car_model->update_braand_and_model($brand_id,$model_id,$brand_name,$model_name);
		// echo $this->db->last_query(); die;
		redirect('car');
	}

	public function chek_brand_name_exist()
	{
		$brand_id = $this->input->post('brand_id');
		// $brand_id=1;
		$brand_name = $this->input->post('brand_name');
		// $brand_name = 'swift';

		$row = $this->car_model->check_brand_exist($brand_id,$brand_name);
		// echo $this->db->last_query(); die;
		if(!empty($row))
		{
			$flag=1;
		}
		else
		{
			$flag=2;
		}
		echo json_encode($flag);
	}
	public function delete_brand()
	{
		$brand_id= $this->input->post('brand_del');
		$this->car_model->delete_brand($brand_id);
		redirect('car');
	}
	public function delete_model()
	{
		$model_id= $this->input->post('model_del');
		$this->car_model->delete_model($model_id);
		redirect('car');
	}
}   
  

	

