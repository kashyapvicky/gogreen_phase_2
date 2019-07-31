<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Dashboard extends MX_Controller {

	function __construct()
    {
		parent::__construct();
		$this->load->model('dashboard_model');
		$bool = $this->session->userdata('authorized');

		if($bool != 1)
		{
			//echo $bool;die;
			redirect('admin');
		}
	}
	public function index()
	{

		$dashboard_stat = $this->dashboard_model->get_dashboard_stat();
		$data['dashboard_data'] = $dashboard_stat;
		 $data['page'] = 'dashboard_view';
		//$this->template->load('dashboard_view', $data);
		   _layout($data);
	}
}
