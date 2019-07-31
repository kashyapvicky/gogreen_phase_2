<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends MX_Controller {

	
	public function index()
	{
		$this->template->load('template', 'form');
	}


	public function validation_form()
	{
		//echo"inside validation form function";die;
		$this->template->load('template','form_validation.php');
	}
}
