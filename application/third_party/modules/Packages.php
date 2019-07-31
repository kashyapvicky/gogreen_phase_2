<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends MX_Controller {

	function __construct()
    {
		parent::__construct();
		$this->load->model('packages_model');
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
		$city = $this->packages_model->get_city();
		$data['city'] =$city;
		$data['packages'] = $this->packages_model->get_packages();
		$data['page'] ='packages_view';
		_layout($data);
		// $this->template->load('template', 'packages_view',$data);
	}

	public function add_package()
	{
		$city = $this->packages_model->get_city();
		$data['city'] =$city;
		$data['page'] ='add_package_view';
		_layout($data);
		//$this->template->load('template','add_package_view',$data);
	}


	public function get_locality_for_street()
	{
		 $city_id = $this->input->post('city_id');
		

		 $localities = $this->packages_model->get_locality_ajax($city_id);
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
		 );
		 //print_r($data); die;
		 echo json_encode($data);
	}

	// get locality and city via ajax for loocality dropdown
	public function get_locality_with_city()
	{
		$city_id = $this->input->post('city_id');
		$car_type = $this->input->post('car_type');

		 $localities = $this->packages_model->get_locality_and_city($city_id,$car_type);		
		 $output='';
			 foreach ($localities as $key => $value)
			 {
			 	$output.="<label class='to_delete_locality_".$value['city_id']."'>
			 	<input onclick='get_final_locality_textarea(this.id)'  id ='locality_".$value['id']."' name='locality_checkbox[]' type='checkbox' value=".$value['id'].",".$value['city_id'].">&nbsp;&nbsp;&nbsp;".$value['name']."(".$value['city'].")

			 	</label>

				";
			 }
		
		  $data = array(
			 'option'=>$output,
			 // 'textarea'=>$textarea,
		  );
		 // //print_r($data); die;
		 echo json_encode($data);
	}
	public function get_locality_with_city_edit()
	{
		// controller code to show selected loclities
		$package_id = $this->input->post('p_id');
		 // $package_id = 4;
		// echo json_encode($package_id); die;
		// echo $package_id ; //die;
		$package_row = $this->packages_model->package_details_to_edit($package_id);
		//echo $this->db->last_query(); die;
		$package_type = $package_row['type'];
		// secho $package_type; die;
		if($package_type == 'saloon')
		{
			$flag=1; // 1 for saloon
		}
		else
		{
			$flag=2; // two for suv
		}
		// echo"<pre>";print_r($package_row); die;
		$pacakge_location =$this->packages_model->get_package_location_by_id($package_id);
		$package_city = array_column($pacakge_location, 'city_id');
		$package_locality = array_column($pacakge_location, 'locality_id');
		//echo "<pre>"; print_r($package_locality); 
		
		// controller code to show selected loclities ends here

		$city_id = $this->input->post('city_id');
		 // $city_id = 1;
		$car_type = $this->input->post('car_type');
		// $car_type = 'saloon';
		//echo "dfs"; die;

		 $localities = $this->packages_model->get_locality_and_city_edit($city_id,$car_type,$package_locality);		
		 $output='';
			 foreach ($localities as $key => $value)
			 {
			 //	echo $value['id']."<br>";
			 	if(in_array($value['id'],$package_locality))
			 	{
			 		$checked = "checked='true'";
			 	}
			 	else
			 	{
			 		$checked = "";
			 	}
//echo json_encode($checked); die;
			 	$output.="<label class='to_delete_locality_".$value['city_id']."'>
			 	<input onclick='get_final_locality_textarea(this.id)' ".$checked."  id ='locality_".$value['id']."' name='locality_checkbox[]'  type='checkbox' value=".$value['id'].",".$value['city_id'].">&nbsp;&nbsp;&nbsp;".$value['name']."(".$value['city'].")

			 	</label>

				";
				 
			 }
		
		  $data = array(
			 'option'=>$output,
			 // 'textarea'=>$textarea,
		  );
		//echo "<pre>"; print_r($data); 
		//die;
		 echo json_encode($data);
	}

//get city for text area ajax function
	public function get_textarea_city()
	{
		 $city_id = $this->input->post('city_id');
		// echo $city_id; die;
		

		 $cities = $this->packages_model->get_city_via_ajax($city_id);		
		 //print_r($cities); die;

		 $textarea='';
		 $counter =1;
		 foreach ($cities as $key => $value)
		 {
		 	$textarea.="<span id='".$value['id']."' class='tag'><span>
		 	".$value['name']."&nbsp;&nbsp;</span>
		 	<span id='".$value['id']."' onclick='removefunction(this.id)' class='span_ajax_class' title='Remove City'>x</span></span>
			";
			$counter++;
		 }

		
		  $data = array(
			 
			  'textarea'=>$textarea,
		  );
		 // //print_r($data); die;
		 echo json_encode($data);
	}

	public function get_textarea_city_edit()
	{
		 $city_id = $this->input->post('city_id');
		// echo $city_id; die;
		

		 $cities = $this->packages_model->get_city_via_ajax($city_id);		
		 //print_r($cities); die;

		 $textarea='';
		 $counter =1;
		 foreach ($cities as $key => $value)
		 {
		 	$textarea.="<span id='".$value['id']."' class='tag'><span>
		 	".$value['name']."&nbsp;&nbsp;</span>
		 	<span id='".$value['id']."' onclick='removefunction(this.id)' class='span_ajax_class' title='Remove City'>x</span></span>
			";
			$counter++;
		 }

		
		  $data = array(
			 
			  'textarea'=>$textarea,
		  );
		 // //print_r($data); die;
		 echo json_encode($data);
	}

	public function insert_package()
	{
		//print_r($_POST); die;
		$this->form_validation->set_rules('pname', 'Package Name', 'required');
		$this->form_validation->set_rules('car_type', 'Choose A car type', 'required',array('required' =>'Please Choose Car Type'));
		// $this->form_validation->set_rules('p_type', 'type', 'required',array('required' =>'Please Choose A Package Type'));
		// $this->form_validation->set_rules('interior', 'interior cost', 'required');
		// $this->form_validation->set_rules('exterior', 'exterior cost', 'required');
	    if ($this->form_validation->run() == FALSE)
	    {
	    	redirect('packages/add_package');
		}
		else
		{

			if(empty($this->input->post('locality_checkbox')))
			{
				$this->session->set_flashdata('locality', 'Please Choose  Locality');
				$this->add_package();
			}
			else
			{
				 $pname = $this->input->post('pname');
				 $car_type = $this->input->post('car_type');
				 $p_type = $this->input->post('p_type');
				 /* To get package type key  */

				 if(!empty($this->input->post('exterior_cost')) && !empty($this->input->post('exterior_once')))
				 {
				 	$p_type = 3; // for package type both;
				 }
				 elseif(!empty($this->input->post('exterior_cost')))
				 {
				 	$p_type = 1;// for once
				 }
				 elseif(!empty($this->input->post('exterior_once')) || !empty($this->input->post('exterior_thrice')) || !empty($this->input->post('exterior_five')))
				 {
				 	$p_type = 2; // for package type monthly
				 }

				 /* /To get package type key  */

				 if(!empty($this->input->post('interior_cost')))
				 {
				 	$interior_cost=$this->input->post('interior_cost');
				 }
				 else{
				 	$interior_cost="0";
				 }
				 if(!empty($this->input->post('exterior_cost')))
				 {
				 	$exterior_cost=$this->input->post('exterior_cost');
				 }
				 else{
				 	$exterior_cost="0";
				 }
				 if(!empty($this->input->post('interior_once')))
				 {
				 	$interior_once=$this->input->post('interior_once');
				 }
				 else{
				 	$interior_once="0";
				 }
				 if(!empty($this->input->post('exterior_once')))
				 {
				 	$exterior_once=$this->input->post('exterior_once');
				 }
				 else{
				 	$exterior_once="0";
				 }
				 if(!empty($this->input->post('interior_thrice')))
				 {
				 	$interior_thrice=$this->input->post('interior_thrice');
				 }
				 else{
				 	$interior_thrice="0";
				 }
				 if(!empty($this->input->post('exterior_thrice')))
				 {
				 	$exterior_thrice=$this->input->post('exterior_thrice');
				 }
				 else{
				 	$exterior_thrice="0";
				 }
				 if(!empty($this->input->post('interior_five')))
				 {
				 	$interior_five=$this->input->post('interior_five');
				 }
				 else{
				 	$interior_five="0";
				 }
				 if(!empty($this->input->post('exterior_five')))
				 {
				 	$exterior_five=$this->input->post('exterior_five');
				 }
				 else{
				 	$exterior_five="0";
				 }


					$data = array
					(

						'name'	=>$pname,
						'type'=>$car_type,
						'p_type'=>$p_type,
						'price_interior'=>$interior_cost,
						'price_exterior'=>$exterior_cost,
						'exterior_once'=>$exterior_once,
						'interior_once'=>$interior_once,

						'exterior_thrice'=>$exterior_thrice,
						'interior_thrice'=>$interior_thrice,


						'exterior_five'=>$exterior_five,
						'interior_five'=>$interior_five,
					);
				 
					$insert_id = $this->packages_model->insert_package_details($data);
						// to update is _package key of locality tabel					
					

				foreach ($_POST['locality_checkbox'] as $key => $value)
				{
					$city_locality_id = explode(',', $value);
					$locality_id =$city_locality_id['0'];
					$city_id = $city_locality_id['1'];

					$data = array
					(
						'package_id'=>$insert_id,
						'city_id'=>$city_id,
						'locality_id'=>$locality_id
					);
					$this->packages_model->insert_locations_of_inserted_package($data);	
					if($car_type == 'saloon')
					{
						$this->packages_model->update_is_saloon($locality_id);
					}
					else
					{
						$this->packages_model->update_is_suv($locality_id);
					}				
				}

				if($insert_id)
				{
					$this->session->set_flashdata('package_added','Package');
					redirect('packages');
				}
				else
				{
					$this->session->set_flashdata('package_falied','Package');
				}
			}
		}
		// if($pageto == 1)
		// {
		// 	$this->add_package();
		// }
		// else
		// {
		// 	redirect('packages');
		// }		
	}


	public function update_package()
	{

		if(empty($this->input->post('locality_checkbox')))
		{
			$this->session->set_flashdata('locality', 'Please Choose  Locality');
			$this->edit_package();
		}
		$package_id = $this->input->get('id');
		$type = $this->input->post('car_type');
		// echo $type; die;
		$package_localities = $this->packages_model->get_all_localities_of_respective_packages($package_id);
		$locality_id_array = array_column($package_localities, 'locality_id');

		// echo"<pre>";print_r($locality_id_array); die;
		if(!empty($locality_id_array))
		{
			$this->packages_model->set_default_status_to_localities($locality_id_array,$type);
		}
		$this->packages_model->delete_all_entries_of_respective_package($package_id);


		// insert edited package entries
		// $this->form_validation->set_rules('p_type', 'type', 'required',array('required' =>'Please Choose A Package Type'));
		// $this->form_validation->set_rules('interior', 'interior cost', 'required');
		// $this->form_validation->set_rules('exterior', 'exterior cost', 'required');
	    
		

		if(empty($this->input->post('locality_checkbox')))
		{
			// print_r($locality_id_array);die;
			$this->session->set_flashdata('locality', 'Please Choose  Locality');
			$this->edit_package();
		}
		else
		{
			// die('working');
			 $pname = $this->input->post('pname');
			 $car_type = $this->input->post('car_type');
			 $p_type = $this->input->post('p_type');
			 /* To get package type key  */

			 if(!empty($this->input->post('exterior_cost')) && !empty($this->input->post('exterior_once')))
			 {
			 	$p_type = 3; // for package type both;
			 }
			 elseif(!empty($this->input->post('exterior_cost')))
			 {
			 	$p_type = 1;// for once
			 }
			 elseif(!empty($this->input->post('exterior_once')) || !empty($this->input->post('exterior_thrice')) || !empty($this->input->post('exterior_five')))
			 {
			 	$p_type = 2; // for package type monthly
			 }

			 /* /To get package type key  */

			 if(!empty($this->input->post('interior_cost')))
			 {
			 	$interior_cost=$this->input->post('interior_cost');
			 }
			 else{
			 	$interior_cost="0";
			 }
			 if(!empty($this->input->post('exterior_cost')))
			 {
			 	$exterior_cost=$this->input->post('exterior_cost');
			 }
			 else{
			 	$exterior_cost="0";
			 }
			 if(!empty($this->input->post('interior_once')))
			 {
			 	$interior_once=$this->input->post('interior_once');
			 }
			 else{
			 	$interior_once="0";
			 }
			 if(!empty($this->input->post('exterior_once')))
			 {
			 	$exterior_once=$this->input->post('exterior_once');
			 }
			 else{
			 	$exterior_once="0";
			 }
			 if(!empty($this->input->post('interior_thrice')))
			 {
			 	$interior_thrice=$this->input->post('interior_thrice');
			 }
			 else{
			 	$interior_thrice="0";
			 }
			 if(!empty($this->input->post('exterior_thrice')))
			 {
			 	$exterior_thrice=$this->input->post('exterior_thrice');
			 }
			 else{
			 	$exterior_thrice="0";
			 }
			 if(!empty($this->input->post('interior_five')))
			 {
			 	$interior_five=$this->input->post('interior_five');
			 }
			 else{
			 	$interior_five="0";
			 }
			 if(!empty($this->input->post('exterior_five')))
			 {
			 	$exterior_five=$this->input->post('exterior_five');
			 }
			 else{
			 	$exterior_five="0";
			 }


				$data = array
				(

					'name'	=>$pname,
					'type'=>$car_type,
					'p_type'=>$p_type,
					'price_interior'=>$interior_cost,
					'price_exterior'=>$exterior_cost,
					'exterior_once'=>$exterior_once,
					'interior_once'=>$interior_once,

					'exterior_thrice'=>$exterior_thrice,
					'interior_thrice'=>$interior_thrice,


					'exterior_five'=>$exterior_five,
					'interior_five'=>$interior_five,
				);
			 
				$bool = $this->packages_model->update_package_details($data,$package_id);
				// echo $bool; die;
					// to update is _package key of locality tabel					
				

			foreach ($_POST['locality_checkbox'] as $key => $value)
			{
				$city_locality_id = explode(',', $value);
				$locality_id =$city_locality_id['0'];
				$city_id = $city_locality_id['1'];

				$data = array
				(
					'package_id'=>$package_id,
					'city_id'=>$city_id,
					'locality_id'=>$locality_id
				);
				$this->packages_model->insert_locations_of_inserted_package($data);	
				if($car_type == 'saloon')
				{
					$this->packages_model->update_is_saloon($locality_id);
					// echo $this->db->last_query(); die;
				}
				else
				{
					$this->packages_model->update_is_suv($locality_id);
				}				
			}

			if($bool)
			{
				$this->session->set_flashdata('package_added','Package');
				redirect('packages');
			}
			else
			{
				$this->session->set_flashdata('package_falied','Package');
			}
		}
		

	}

	public function delete_package()
	{
		$id = $this->input->get('id');
		$locality_id = $this->input->get('l_id');
		$type = $this->input->get('type');
		//echo $locality_id; die;
		$bool = $this->packages_model->del_package($id);

		if($bool)
		{
			if($type == 'saloon')
			{
				$this->packages_model->update_is_saloon_on_delete($locality_id);
				$this->session->set_flashdata('delete_succ', 'Deleted Successfully');
				redirect('packages');
			}
			else
			{
				$this->packages_model->update_is_suv_on_delete($locality_id);
				$this->session->set_flashdata('delete_succ', 'Deleted Successfully');
				redirect('packages');
			}
		}
		else{
			$this->session->set_flashdata('error_del','error deleted');
			redirect('packages');
		}
	}


	public function get_final_locality_for_textarea()
	{
		$locality_id = $this->input->post('locality_id');
		 $localities = $this->packages_model->get_final_locality($locality_id);		
		 $span_list='';
		 foreach ($localities as $key => $value)
		 {
		 	$span_list.="<span id='localities_span_".$value['id']."' class='tag'><span>
		 	".$value['name']."&nbsp;&nbsp;</span>
		 	<span id='".$value['id']."' onclick='removespan(this.id)' class='span_ajax_class' title='Remove City'>x</span></span>
			";
		 }
		
		  $data = array(
			 'option'=>$span_list,
			 // 'textarea'=>$textarea,
		  );
		 // //print_r($data); die;
		 echo json_encode($data);
	}

	public function edit_package()
	{
		$package_id = $this->input->get('id');

		$package_row = $this->packages_model->package_details_to_edit($package_id);
		// print_r($package_row);die;
		$package_type = $package_row['type'];
		// secho $package_type; die;
		if($package_type == 'saloon')
		{
			$flag=1; // 1 for saloon
		}
		else
		{
			$flag=2; // two for suv
		}
		// echo"<pre>";print_r($package_row); die;
		$pacakge_location =$this->packages_model->get_package_location_by_id($package_id);
		// print_r($pacakge_location); die;
		$package_city = array_column($pacakge_location, 'city_id');
		$all_cities = $this->packages_model->get_all_cities();
			$package_locality = array_column($pacakge_location, 'locality_id');
			$all_localities = $this->packages_model->get_all_localities($flag,$package_locality);
		  // echo"<pre>"; print_r($all_localities); die;
		// echo"<pre>";print_r($pacakge_location); die;
		$data['package_row'] = $package_row;
		$data['pacakge_location'] = $pacakge_location;
		$data['all_cities'] = $all_cities;
		$data['all_localities'] = $all_localities;
		$data['package_city'] = $package_city;
		$data['package_locality'] = $package_locality;
	 	// echo "<pre>";print_r($pacakge_location); die;
		$data['page'] = 'edit_package_view';
		_layout($data);
	}	
}   
  

	

