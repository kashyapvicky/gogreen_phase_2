<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teams extends MX_Controller {

	function __construct()
    {
		parent::__construct();
		$this->load->model('teams_model');
		$bool = $this->session->userdata('authorized');
		$this->load->library('form_validation');

		if($bool != 1)
		{
			//echo $bool; die;
			redirect('admin');
		}
	}
	public function index()
	{

		$teams = $this->teams_model->get_teams_detail();
		$data['teams'] = $teams;
		$data['page'] ='teams_view';
		_layout($data);
		// $this->template->load('template', 'packages_view',$data);
	}
	public function add_team()
	{
		$city = $this->teams_model->get_city();
		$data['city'] =$city;
		$data['page'] ='add_team_view';
		_layout($data);
	}
	public function get_locality()
	{
		 $city_id = $this->input->post('city_id');
		

		 $localities = $this->teams_model->get_locality_ajax($city_id);
		 $output = '';
		 foreach ($localities as $key => $value)
		 {
		 	$output .='
		 	<option value ='.$value['id'].'>'.$value['name'].'</option>

		 	';
		 } 
		 $data = array(

			'table'=>$output

		 );
		 //print_r($data); die;
		 echo json_encode($data);
	}
	public function get_street()
	{

		$letters = $this->input->post('string');
		//$letters = "se";
		$locality_id = $this->input->post('locality_id');
		//$locality_id = 1;

		$streets = $this->teams_model->get_streets($letters,$locality_id);
		//echo"<pre>";print_r($streets); die;
		$output = '';
		foreach ($streets as $key => $value) 
		{

			$output .='<span onclick="add_street(this.id)" value='.$value['name'].' class="forhover" id='.$value['id'].'>'.$value['name'].'</span>,&nbsp;&nbsp;&nbsp;';

		}
		 $data = array(

			'streets'=>$output

		 );
		 //print_r($data); die;
		 echo json_encode($data);

	}
	public function get_street_for_textarea()
	{
		$street_id = $this->input->post('street_id');
		//$street_id=1;
		$street_row = $this->teams_model->get_textarea_street($street_id);
		$span_list='';
		$span_list.="<span value=".$street_row['id']." id='street_".$street_row['id']."' class='tag'><span>
		 	".$street_row['name']."&nbsp;&nbsp;</span>
		 	<span id='street_".$street_row['id']."' onclick='removespan(this.id)' class='span_ajax_class' title='Remove street'>x</span></span>
		 	<input type='hidden' id='hidden_street_".$street_row['id']."' required value=".$street_row['id']." name='streets_ids[]'>
			";
			$data = array(

			'streets'=>$span_list

		 );
			echo json_encode($data);
	}
	public function get_cleaners()
	{
		$locality_id = $this->input->post('locality_id');
		//$locality_id = 1;
		$string = $this->input->post('string');
		//$string = "am";

		$cleaners = $this->teams_model->get_cleaners($locality_id,$string);

		$output = '';
		foreach ($cleaners as $key => $value) {

			$output .='<span onclick="add_cleaner(this.id)" value='.$value['first_name'].' class="forhover" id='.$value['id'].'>'.$value['first_name'].'</span>,&nbsp;&nbsp;&nbsp;';

		}
		 $data = array(

			'cleaners'=>$output

		 );
		 //print_r($data); die;
		 echo json_encode($data);
	}
	public function get_cleaners_for_textarea()
	{
		$cleaner_id = $this->input->post('cleaner_id');
		//$cleaner_id=1;
		$cleaner_row = $this->teams_model->get_textarea_cleaner($cleaner_id);
		$span_list_cleaner='';
		$span_list_cleaner.="<span value=".$cleaner_row['id']." id='cleaner_".$cleaner_row['id']."' class='tag'><span>
		 	".$cleaner_row['first_name']."&nbsp;&nbsp;</span>
		 	<span id='cleaner_".$cleaner_row['id']."' onclick='removespan_cleaner(this.id)' class='span_ajax_class' title='Remove street'>x</span></span>
		 	<input type='hidden' id='hidden_cleaner_".$cleaner_row['id']."' required value=".$cleaner_row['id']." name='cleaners_ids[]'>
			";
			$data = array(

			'cleaners'=>$span_list_cleaner

		 );
			echo json_encode($data);
	}

	public function insert_team()
	{
		//print_r($_POST); die;
		$this->form_validation->set_rules('streets_ids[]', 'Street', 'required');
		$this->form_validation->set_rules('cleaners_ids[]', 'Cleaners', 'required');
	    if ($this->form_validation->run() == TRUE)
	    {
	    	

			$team_name = $this->input->post('tname');
			$city_id = $this->input->post('city');
			$locality_id = $this->input->post('locality');
			$data = array(

				'name'=>$team_name,
				'city_id'=>$city_id,
				'locality_id'=>$locality_id,

			);

			$insert_id = $this->teams_model->insert_team($data);
			if($insert_id)
			{

				foreach ($_POST['streets_ids'] as $key => $value)
				{
					if(!empty($value))
					{
						$data = array(

							'team_id'=>$insert_id,
							'street_id'=>$value
						);
						$insert_id_street = $this->teams_model->insert_street_id_to_team($data);
					}
				}

				foreach ($_POST['cleaners_ids'] as $key => $value)
				{
					$data = array(

						'team_id'=>$insert_id,
						'street_id'=>$insert_id_street,
						'cleaner_id'=>$value
					);
					$last_insert_id = $this->teams_model->insert_cleaners_id_to_team($data);
					$this->teams_model->update_cleaner_status($value);

					

				}
				$this->session->set_flashdata('team','SUCCESFULLY INSERTED DATA');
				redirect('teams');
			}
		}
		$this->session->set_flashdata('team','ERROR IN INSERTION');
		redirect('teams/add_team');		
	}
	public function edit_team()
	{
		$team_id = $this->input->get('id');

		$team_info = $this->teams_model->get_team_info($team_id);
		$team_cleaner = $this->teams_model->get_cleaner_assaigned_to_this_team($team_id);
		$all_free_cleaner = $this->teams_model->get_all_free_cleaner_on_street($team_info['street_id']);
		// echo"<pre>";  print_r($team_cleaner); 
		// echo"<br>";
		//  echo"<pre>";print_r($all_free_cleaner); 
		 $new = array_merge($team_cleaner,$all_free_cleaner);
		 // echo"<pre>";print_r($new);die;
		$data['all_free_cleaner'] = $new;
		$data['team_cleaner'] = $team_cleaner;
		$data['team'] = $team_info;
		$data['page'] = 'team_edit';
		_layout($data);
	}

	public function update_team()
	{

		if(empty($this->input->post('cleaners')))
		{
			$this->session->set_flashdata('choose_cleaner','Please Choose Cleaners');
			redirect('teams');
		}
		// $this->db->trans_start();

		// //Your code Here...

		// $this->db->trans_complete();

		// $trans_status = $this->db->trans_status();

		// if ($trans_status == FALSE) {
		// $this->db->trans_rollback();
		// } else {
		// $this->db->trans_commit();
		// }

		$team_id = $this->input->get('id');
		$team_cleaner = $this->teams_model->get_cleaner_assaigned_to_this_team($team_id);
		$team_cleaner_id_coulmn = array_column($team_cleaner, 'cleaner_id');    // array of cleaner ids of this team
		$all_new_cleaners = $this->input->post('cleaners');
		// print_r($all_new_cleaners);die;
		$this->db->trans_start();
		//set column to 1 of all the cleaners
		$this->teams_model->update_status_as_inactive($team_cleaner_id_coulmn);
		$this->teams_model->delete_all_cleaner_from_team_cleaners($team_id);
		$this->teams_model->update_status_as_active($all_new_cleaners);
		$this->teams_model->insert_all_cleaners_to_team_cleaners($all_new_cleaners,$team_id);


		


		$this->db->trans_complete();
		$trans_status = $this->db->trans_status();

		if ($trans_status == FALSE) 
		{
			$this->db->trans_rollback();
			$this->session->set_flashdata('team_edit','Error In Edit Team');
		} 
		else 
		{
			$this->db->trans_commit();
			// die('done');
			$this->session->set_flashdata('team_edit','Team Edit Successfully');
			redirect('teams');
		}
		redirect('teams');
		// print_r($team_cleaner_id_coulmn); die;
		// echo"<pre>";print_r($all_cleaners);
	}
	
}   
  

	

