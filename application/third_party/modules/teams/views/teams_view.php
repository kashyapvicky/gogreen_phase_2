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
     <h3>Teams</h3>
      <?php  echo $this->session->flashdata('team');?>
      <?php  echo $this->session->flashdata('team_edit');?>
      <?php  echo $this->session->flashdata('choose_cleaner');?>
    </div>
  </div>
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Teams </h2>
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
           <a href="<?php echo base_url()?>teams/add_team">
      <button style="float: right; width:10%">Add New</button></a>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Team Name</th>
                <th>City</th>
                <th>Locality</th>
                <th>No Of Jobs</th>
                <th>operatiion</th>
                <!-- <th>operation</th> -->
              </tr>
            </thead>


            <tbody id="">
              <?php
              
                 foreach($teams as $key => $value)
                 {
                  //echo "<pre>";print_r($packages); die;
               // echo"<pre>";  print_r($teams); die;
                  echo"
                  <tr>
                   <td>".$value['name']."</td>
                   <td>".$value['city']."</td>
                   <td>".$value['locality']."</td>
                   <td>".$value['jobs']."</td>            
                   <td><a href='".base_url()."teams/edit_team?id=".$value['id']."' class='btn btn-info'>Edit</Edit></td>            
                  </tr>";


                 }
                 

              ?>
             
             <!-- <td>
                   <a href='".base_url()."packages/delete_package?id=".$value['id']."&l_id=".$value['locality_id']."&type=".$value['type']."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o m-right-xs'></i>Delete</a>
                   </td> -->
            
              
              <!-- <tr>
                <td>Airi Satou</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>33</td>
                <td>Tokyo</td>
                <td>33</td>
              </tr>  -->
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