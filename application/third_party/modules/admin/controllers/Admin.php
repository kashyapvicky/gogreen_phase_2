<?php

/*
	


*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends MX_Controller {


	function __construct()
    {
    	
		parent::__construct();
		$this->load->model('admin_model');
	}

	
	public function index()
	{
		// $SQL = "SELECT NOW()";
		// $query = $this->db->query($SQL);

		// $timezone =  $query->result_array();
		// print_r($timezone); die;
		$this->load->view('admin_login');
	}

	public function login()
	{
		$this->form_validation->set_rules('email', 'Email', 'required'); 
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$admin_detail = $this->admin_model->admin_credentials();
		// $this->session->set_userdata(array('authorized' => 1));
		 // echo"<pre>";
		  //print_r($admin_detail);
		 
			if(($admin_detail['email'] == $email) && ($admin_detail['password'] == $password))
			{
				$this->session->set_userdata('session_data',$admin_detail);
				$this->session->set_userdata(array('authorized' => 1));
				redirect(base_url('dashboard'));
			}
			else
			{
				$this->session->set_flashdata('item','item-value');
			}
			
		
		redirect(base_url('admin'));
	}

	public function logout()
	{

		$this->session->unset_userdata('session_data', $admin_detail);
		$this->session->set_userdata(array('authorized' => 0));
		redirect(base_url(admin));
	}


	public function forget_password()
	{

		$this->load->view('forget_password');
	}
	public function send_link()
	{
		
		if($_POST)
		{
			 $email = $this->input->post('email');

			$bool = $this->admin_model->check_email_existense($email);

			if($bool == true)
			{
				
				$id = $this->admin_model->get_id_by_email($email);
				// echo"<a href = ".base_url('admin/confirm_password')."?id=$id>";
				// echo"click here";
				// echo"</a>";
				// $message = "To Reset Your Password";
				//$id = $row_data['id'];
				$this->load->library('email');
				$config['protocol']    = 'smtp';
				$config['smtp_host']    = 'smtp.gmail.com';
				$config['smtp_port']    = '567';
				$config['smtp_timeout'] = '7';
				$config['smtp_user']    = 'veee.kay258@gmail.com';
				//$config['smtp_pass']    = 'Heyudude@0';
				$config['charset']    = 'utf-8';
				$config['newline']    = "\r\n";
				$config['mailtype'] = 'html'; // or html
				$config['validation'] = TRUE; // bool whether to validate email or not      
				$this->load->library('email', $config);
				$this->email->from('vicky@ripenapps.com', 'vicky');
				$this->email->to($email);
				$this->email->subject('Password Verification Link');
				$message = "click on the link below to reset your password";
				$message .=  "<br>";
				$message .="<a href = ".base_url()."admin/confirm_password?id=$id>Link</a>";
				$this->email->message($message);  
				if($this->email->send())
				{
					echo "Password Reset Link Sent To Your Mail. Please Check Your Mail To Update Your Password";
					die;
				}
				else{
					echo "Error In Sending Mail";
				}

			}
			else
			{
				//die('not existed');
				$this->session->set_flashdata('check_email','email not existed');
				//echo"<script>alert('email not existed')</script>";
			}
		}
		
		redirect('admin/forget_password');
	}


	public function confirm_password()
	{
		
		
		//echo $id; die;

		$this->form_validation->set_rules('password1', 'Password', 'required');
		$this->form_validation->set_rules('password2', 'Confirm Password', 'required|matches[password1]',array('matches' => 'Password Did Not Match'));
		if($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			//$this->session->set_tempdata('error', validation_errors(), 10);

		}
		else
		{
			$id = $this->input->get('id');
			//echo $id; die;
			$password = $this->input->post('password1');

			
			$data = array
			(
				'password'=>$password,
			);
			$bool = $this->admin_model->update_password($id,$data);
			if($bool)
			{
			$this->session->set_flashdata('success', 'Password Updated!,Login With New Password');
			redirect('admin');
			}
			else
			{
				$this->session->set_flashdata('failure', 'Unable To Update , Please Try Again');
				redirect('admin');
			}
		}




		$this->load->view('confirm_password');
		// echo"inside conform password";
	}

	public function reset_user_password()
	{
		//$id = $this->input->get('id');
		$this->form_validation->set_rules('password1', 'Password', 'required');
		$this->form_validation->set_rules('password2', 'Confirm Password', 'required|matches[password1]',array('matches' => 'Password Did Not Match'));
		if($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			//$this->session->set_tempdata('error', validation_errors(), 10);

		}
		else
		{
			$id = $this->input->get('id');
			//echo $id; die;
			$password = $this->input->post('password1');

			
			$data = array
			(
				'password'=>$password,
			);
			$bool = $this->admin_model->reset_user_password($id,$data);
			if($bool)
			{
				//print_r($bool); die;
			// $this->session->set_flashdata('go_to_app', 'Password Updated!,Login With New Password');
			// redirect('admin');
				//$this->load->view('go_to_app');
				
				//die;
				echo"Your Password Is Updated Successfully. Please Go To App To Login With A New Password"; die;
			}
			else
			{
				echo"error"; die;
				$this->session->set_flashdata('failure', 'Unable To Update , Please Try Again');
				//redirect('admin');
			}
		}

		$this->load->view('user_reset_password');
	}
	public function change_password()
	{

		$this->form_validation->set_rules('current_password', 'Current Password', 'required');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[4]|max_length[12]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
		if ($this->form_validation->run() == true)
		{
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password');
			$confirm_password = $this->input->post('confirm_password');
			$row = $this->admin_model->check_current_password($current_password);
			if(empty($row))
			{
				$this->session->set_flashdata('Invalid_password','Invalid Current Password');
			}
			else
			{
				$bool = $this->admin_model->update_password_admin($new_password,$current_password);
				if($bool)
				{
					$this->session->set_flashdata('success','Password Updated Succesfully');
				}
				else
				{
					$this->session->set_flashdata('success','Error In Updation password');
				}
			}

		}
		$data['page'] = 'change_password';
		_layout($data);
	}
}
