<?php

/* * ***********************
 * PAGE: TO Listing The packages.
 * #COPYRIGHT: Ripenapps
 * @AUTHOR: vicky kashyap
 * CREATOR: 04/06/2018.
 * UPDATED: --/--/----.
 * codeigniter framework
 * *** */
?>
<style>
.select
{
    min-width: 48%;
    /*margin: 2px 0 10px 7px;*/
    padding: 4px;
}
</style>
<br><br>
<div class="right_col" id="cool" role="main">
  <br><br>
  <div class="page-title">
    <div class="title_left">
      
      <!-- <select onchange="get_locality_for_street(this.value)" class="select"><option value="" disabled selected>Select City</option>
            <?php if(!empty($city)){foreach ($city as $key => $value) {
          
            echo"<option value=".$value['id'].">".ucfirst($value['name'])."</option>";}}?>
      </select>
      <select class="select" id="locality_ajax"><option>Choose City First</option></select> -->
      <!-- <button style="float: right">Add New</button> -->
    </div>

    <div class="title_right">
     <h3>Packages</h3>
    </div>
  </div>
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Packages </h2>
          <?php if($this->session->flashdata('package_added'))
          { echo"<div style='margin-left: 150px;'>";
            echo"<font color='green'>Packages Added Successfully</font>";
            echo"</div>";
          }
          ?>
          <?php if($this->session->flashdata('delete_succ'))
          { echo"<div style='margin-left: 150px;'>";
            echo"<font color='red'>Packages Deleted Successfully</font>";
            echo"</div>";
          }
          ?>
           <a href="<?php echo base_url()?>packages/add_package">
      <button style="float: right; width:10%">Add New</button></a>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Monthly/Once</th>
                <th>Cost(I)</th>
                <th>Cost(E)</th>
                <th>once(I)</th>
                <th>once(E)</th>
                <th>Thrice(I)</th>
                <th>Thrice(E)</th>
                <th>Five(I)</th>
                <th>Five(E)</th>
                <th>Operations</th>
                <!-- <th>operation</th> -->
              </tr>
            </thead>


            <tbody id="">
              <?php
              
                 foreach($packages as $key => $value)
                 {
                   if($value['p_type']==1)
                   {
                    $res ="Once";
                    }
                    elseif($value['p_type']==2)
                    {
                      $res ="Monthly";
                    }
                    else{
                      $res ="Both";
                    }
                  //echo "<pre>";print_r($packages); die;
                 //print_r($packages); die;
                  echo"
                  <tr>
                   <td>".$value['name']."</td>
                   <td>".$value['type']."</td>
                   <td>".$res."</td>
                   <td>".$value['price_interior']."</td>
                   <td>".$value['price_exterior']."</td>
                   <td>".$value['interior_once']."</td>
                   <td>".$value['exterior_once']."</td>
                   <td>".$value['interior_thrice']."</td>
                   <td>".$value['exterior_thrice']."</td>
                   <td>".$value['interior_five']."</td>
                   <td>".$value['exterior_five']."</td>
                    <td>
                      <a href='".base_url()."packages/delete_package?id=".$value['id']."&&type=".$value['type']."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o m-right-xs'></i>Delete</a>
                      <a href='".base_url()."packages/edit_package?id=".$value['id']."' class='btn btn-info btn-sm'><i class='fa fa-trash-o m-right-xs'></i>Edit</a> 
                    </td>
                  </tr>";


                 }
                 

              ?>
             
             <!-- <td>
                   <a href='".base_url()."packages/delete_package?id=".$value['id']."&l_id=".$value['locality_id']."&type=".$value['type']."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o m-right-xs'></i>Delete</a>
                   </td> -->
            
              <!--
              <tr>
                <td>Airi Satou</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>33</td>
              </tr>
              <tr>
                <td>Brielle Williamson</td>
                <td>Integration Specialist</td>
                <td>New York</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Michael Bruce</td>
                <td>Javascript Developer</td>
                <td>Singapore</td>
                <td>29</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
              </tr> -->

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>





  <div class="row">
   
    

  </div>
</div>
    



<script>
  $( document ).ready(function() {
  document.getElementById("cool").style.minHeight = "697px";
  });
</script>

<script>


 function get_locality_for_street(val)
 {

      var id = val;
    $.ajax
    ({
        type : "POST",
        url : "<?php echo base_url(); ?>packages/get_locality_for_street",
        dataType : "json",
        data : {"city_id" : id},
        success : function(data) {
             $("#locality_ajax").html(data.option);
             //$("#locality_ajax_table").html(data.dropdown);
             //alert('hello');
             console.log(data);
        },
        error : function(data) {
            alert('Something went wrong');
        }
    });
  }
 
 
</script>