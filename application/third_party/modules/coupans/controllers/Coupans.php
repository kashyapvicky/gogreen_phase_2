<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Coupans extends MX_Controller {

	function __construct()
    {
		parent::__construct();
		 $this->load->library('form_validation');
		$this->load->model('coupans_model');
		$bool = $this->session->userdata('authorized');

		if($bool != 1)
		{
			//echo $bool; die;
			redirect('admin');
		}
	}
	public function index()
	{
     $coupans = $this->coupans_model->get_all_coupans();

    // $data['cleaners'] =$cleaners;
		//$this->template->load('template', 'cleaner_view',$data);
     $data['coupans'] = $coupans;
     $data['page'] ='coupans_view';
    	_layout($data);
	}
	public function add_coupans()
	{
		if($this->input->get('id'))
		{
			$coupan_id = $this->input->get('id');
			$flag=1;	// edit the data
			// echo $coupan_id; die;
		}
		else
		{
			$flag=2;// add the data
		}
		if($_POST)
		{
			if(empty($_FILES['coupan_image']['name']) && $flag==2)
			{
				$this->session->set_flashdata('choose_file','Please choose image File');
			}
			else
			{
				$bool = $this->coupans_model->check_img($_FILES['coupan_image']['name']);
				if($flag==1)
				{
					$bool==0;
				}
				if($bool)
				{
					$this->session->set_flashdata('img_existed_already','Image Already Existed');
				}
				else
				{

					$this->form_validation->set_rules('offer_name', 'Offer Name', 'required');
					$this->form_validation->set_rules('valid_from', 'valid From', 'required');
					$this->form_validation->set_rules('valid_upto', 'valid Upto', 'required');
					if($flag==2)
					{

						$this->form_validation->set_rules('coupan_code', 'Coupan Code', 'required');
					}
					$this->form_validation->set_rules('discount', 'Discount', 'required');
					$this->form_validation->set_rules('minimum_order', 'Minimum Order', 'required');
					$this->form_validation->set_rules('user_type', 'user_typ', 'required');
					if ($this->form_validation->run() == true)
					{ 
						$offer_name = $this->input->post('offer_name');
						$valid_from = $this->input->post('valid_from');
						$valid_from_sql = date('Y-m-d', strtotime($valid_from));
						$valid_upto = $this->input->post('valid_upto');
						$valid_upto_sql = date('Y-m-d', strtotime($valid_upto));
						$valid_upto = $this->input->post('valid_upto');
						$coupan_code = $this->input->post('coupan_code');
						$discount = $this->input->post('discount');
						$minimum_order = $this->input->post('minimum_order');
						$max_discount = $this->input->post('max_discount');
						$user_type = $this->input->post('user_type');
						// uploaded file configuration
						$config['upload_path']   = './uploads/'; 
						$config['allowed_types'] = 'gif|jpg|png'; 
						$config['max_size']      = 2048; 
						$config['max_width']     = 0; 
						$config['max_height']    = 0;  
						$this->load->library('upload', $config);
						if (!$this->upload->do_upload('coupan_image') && $flag==2)
						{
							$error = array('error' => $this->upload->display_errors());
							$this->session->set_flashdata('image_error',$error);
						}
						else 
						{ 	
							$data = array('upload_data' => $this->upload->data());
							// print_r($data);
							 $filename = $data['upload_data']['file_name'];
							//echo $filename;die;
							 $data=array
							 (
							 	'img_name'=>$filename,
							 	'offer_name'=>$offer_name,
							 	'valid_from'=>$valid_from_sql,
							 	'valid_upto'=>$valid_upto_sql,
							 	'coupan_code'=>$coupan_code,
							 	'discount'=>$discount,
							 	'minimum_order'=>$minimum_order,
							 	'max_discount'=>$max_discount,
							 	'user_type'=>$user_type,	
							 );
							 if($flag==1)
							 {
							 		unset($data['img_name']);
							 		unset($data['coupan_code']);

							 }
							 // print_r($data);die;
							 $bool = $this->coupans_model->insert_coupan($data,$flag,$coupan_id);
							 if($bool)
							 {
							 	$this->session->set_flashdata('succ','Coupans Added Successfully');
							 	redirect('coupans');
							 }
							 else
							 {
							 	$this->session->set_flashdata('Failure','Error IN Adding Coupans');
							 } 
						} 
					} 
				}
			}//this one
		}
		if($flag==1)
		{
			// $coupan_id = $this->input->get('id');
			$row = $this->coupans_model->get_coupans_for_edit($coupan_id);
			// print_r($row); die;
			$data['coupan'] = $row;
			$data['page']='edit_coupans';
			_layout($data);
		}
		else
		{

			$data['page'] = 'add_coupan_view';
			_layout($data);
		}
	}

	public function edit_coupans()
	{
		$coupan_id = $this->input->get('id');
		$row = $this->coupans_model->get_coupans_for_edit($coupan_id);
		$data['coupan'] = $row;
		$data['page']='edit_coupans';
		_layout($data);
	}
	public function check_coupan_exis()
	{
		$coupan_code = $this->input->post('coupan_code');

		$row = $this->coupans_model->check_coupan_code_exist($coupan_code);
		if($row)
		{
			echo json_encode($row);
		}
		else
		{
			return false;
		}
		
	}
	public  function delete_coupans()
	{
		$coupan_id = $this->input->get('id');
		$bool = $this->coupans_model->delete_coupan_by_id($coupan_id);
		if($bool)
		{
			$this->session->set_flashdata('coupan_del','SUCCESFULLY DELETED');
		}
		else
		{
			$this->session->set_flashdata('coupan_del','ERROR IN DELETION');
		}
		redirect('coupans');
	}
}   
  

	

