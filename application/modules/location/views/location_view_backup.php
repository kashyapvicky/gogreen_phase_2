<?php

/* * ***********************
 * PAGE: TO Listing The User.
 * #COPYRIGHT: Ripenapps
 * @AUTHOR: vicky kashyap
 * CREATOR: 04/06/2018.
 * UPDATED: --/--/----.
 * codeigniter framework
 * *** */
?>

<style>
#datatable-responsive_paginate{
  display:none !important;

}
.citydiv
{

  min-height: 270px;
  border: 1px solid #ccc;
  padding-top: 7px;
  background-color: white;
  
}

.select
{
    margin: 2px 0 0 7px;
    padding: 3px;
}

</style>

<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Locations</h3>
    </div>

    <div class="title_right">

    </div>
  </div>
  <br>
  <br>
  <br>
  <br>
  <div class="row">

    <div class="col-md-12">
      <div class="col-md-1"><font size="4px">City</font></div>
      <div class="col-md-3">
        
        <button type="button" value="" data-toggle="modal" data-target="#myModal"> Add City</button>
      </div>
      <div class="col-md-1"><font size="4px"> Locality</font></div>

      <div class="col-md-3">
        <button type="button" data-toggle="modal" data-target="#localitymodal" value="">Add locality</button>

      </div>
      <div class="col-xs-1"><font size="4px"> Street</font></div>
      <div class="col-md-3">        
        <button type="button" data-toggle="modal" data-target="#streetmodal" value="">Add Street</button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="citydiv">
      <table class="table table-striped">
        <thead>
          <tr>
            <th></th>
            <th><font>City</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            if(!empty($city))
            {
              foreach ($city as $key => $value)
              {
              //print_r($value); die;
                echo"<tr>
                <td></td>
                <td>".ucfirst($value['name'])."</td>

                </tr>";
              }
            }
            

            ?>
          </tbody>
        </table>
      </div>
    </div>

      
      <div class="col-md-4" >
        <div class="citydiv">
        <select class="select" onchange="get_city_wise_locality(this.value)"><option value="" disabled selected>Select City</option>
          <?php if(!empty($city)){foreach ($city as $key => $value) {
        
          echo"<option value=".$value['id'].">".ucfirst($value['name'])."</option>";}}?>
        </select>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Locality</th>
                <th>Timing</th>
              </tr>
            </thead>

            <tbody id="locality_row">
              
              
              
              <!-- <tr>
                <td>Dubai</td>
                <td>6AM-9PM</td>
              </tr>
              <tr>
                <td>Tokyo</td>
                <td>7Am-8PM</td>
              </tr>
              <tr>
                <td>Texas</td>
                <td>9Am-10PM</td>
              </tr> -->
            </tbody>
          </table>
            <?php
            if($this->session->flashdata('error'))
            {
            //echo"<script>alert('All Field Is Mandatory')</script>";
              echo"<font color = 'red'>";
              echo $this->session->flashdata('error');
              echo"</font>";

            }
            if($this->session->flashdata('locality_added_succesfully'))
            {
              echo"<font color = 'red'>";
              echo $this->session->flashdata('locality_added_succesfully');
              echo"</font>";
            }
            
            ?>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="citydiv">
          <select onchange="get_locality_for_street(this.value)" class="select"><option value="" disabled selected>Select City</option>
            <?php if(!empty($city)){foreach ($city as $key => $value) {
          
            echo"<option value=".$value['id'].">".ucfirst($value['name'])."</option>";}}?>
          </select>
         <select onchange="get_street(this.value)" id="locality_ajax_table" class="select">
          <option value="" disabled selected> Select Locality</option>
           
         </select>

         <table class="table table-striped">
          <thead>
            <tr>
              <th></th>
              <th><font>Street/Towers</th>
              </tr>
            </thead>
            <tbody id="streets_row">
              <!-- <tr>
                <td></td>
                <td>Street 1</td>
              </tr>
              <tr>
                <td></td>
                <td>Tower 1</td>
              </tr>
              <tr>
                <td></td>
                <td>quan</td>
              </tr> -->
            </tbody>
          </table>
          <?php
            if($this->session->flashdata('error_street'))
            {
            //echo"<script>alert('All Field Is Mandatory')</script>";
              echo"<font color = 'red'>";
              echo $this->session->flashdata('error_street');
              echo"</font>";

            }
            if($this->session->flashdata('street_added_succesfully'))
            {
              echo"<font color = 'red'>";
              echo $this->session->flashdata('street_added_succesfully');
              echo"</font>";
            }
            
            ?>
        </div>
      </div>
        
      </div> 
      
      
      




      <!-- Modal for city -->
      <div style="" class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
          
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Add City</h4>
            </div>
            <div class="modal-body" style="">
             <form method="post" action="<?php base_url();?>location/addcity">
              <input required type="text" name="city" placeholder="City Name">
              
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-default" value="Add">
              </form>
              <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
       </div>
     </div>
           
       

   <!-- Modal for locality -->
    <div style="" class="modal fade" id="localitymodal" role="dialog">
      <div class="modal-dialog">
        
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Locality</h4>
          </div>
          <div class="modal-body" style="">
           <form method="post" action="<?php echo base_url();?>location/addlocality">
            <select required  name="city_select" style="width: 30%; height:27px">
              <!-- <option value="NULL">City</option> -->
              <option value="" disabled selected>Select City</option>
              <?php if(!empty($city)){foreach ($city as $key => $value) {
          # code...
                echo"<option value=".$value['id'].">".ucfirst($value['name'])."</option>";}}?>
              </select>
              <br>
              <br>
              <input required type="text" name="locality" placeholder="Locality Name">
              <br>
              <br>
              <input required class="timepicker1" type="text" name="service_start" placeholder="Service Start Timing">
              <br>
              <br>
              <input required class="timepicker1" type="text" name="service_end" placeholder="Service End Timing">
              
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-default" value="Add">
              </form>
              <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
    </div>

      <!-- Modal for street -->
    <div style="" class="modal fade" id="streetmodal" role="dialog">
      <div class="modal-dialog">
        
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Street</h4>
          </div>
          <div class="modal-body" style="">
           <form method="post" action="<?php echo base_url();?>location/addstreet">
            <select required onchange="get_locality_for_street(this.value)" name="city_select" style="width: 30%; height:27px">
              <!-- <option value="NULL">City</option> -->
              <option value="" disabled selected>Select City</option>
              <?php if(!empty($city)){foreach ($city as $key => $value) {
          
                echo"<option value=".$value['id'].">".ucfirst($value['name'])."</option>";}}?>
              </select>
              <br>
              <br> 
              <select required id="locality_ajax"   name="locality_select" style="width: 30%; height:27px">
                <option value="" disabled selected> Select Locality</option>
              </select>
              <br>
              <br>
              <input required type="text" name="street" placeholder="Enter Street/Tower">   
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-default" value="Add">
              </form>
              <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
    </div>

  </div> 
</div>


  <!--TIMEPICKER start -->

    <link href="<?php echo base_url_custom?>build/css/timepicki.css" rel="stylesheet">
    <script src="<?php echo base_url_custom?>build/js/timepicki.js"></script>

    <!--TIMEPICKER CLOSE -->
  <script>
  $('.timepicker1').timepicki();
    </script>

<script>

 function get_city_wise_locality(val)
 {

      var city_id = val;
      //console.log(city_id);
      // alert('inside function');
      // var url = "<?php echo base_url(); ?>location/get_city_wise_locality";
      // console.log(url);
    $.ajax
    ({
        type : "POST",
        url : "<?php echo base_url(); ?>location/get_locality",
        dataType : "json",
        data : {"city_id" : city_id},
        success : function(data) {
             $("#locality_row").html(data.table);
             //alert('hello');
             console.log(data);
        },
        error : function(data) {
            alert('Something went wrong');
        }
    });
  }
 
 
</script>
<script>


 function get_locality_for_street(val)
 {

      var id = val;
      //console.log(id);
      // alert('inside function');
      // var url = "<?php echo base_url(); ?>location/get_city_wise_locality";
      // console.log(url);
    $.ajax
    ({
        type : "POST",
        url : "<?php echo base_url(); ?>location/get_locality_for_street",
        dataType : "json",
        data : {"city_id" : id},
        success : function(data) {
             $("#locality_ajax").html(data.option);
             $("#locality_ajax_table").html(data.dropdown);
             //alert('hello');
             console.log(data);
        },
        error : function(data) {
            alert('Something went wrong');
        }
    });
  }
 
 
</script>

<script>


 function get_street(val)
 {

      var id = val;
      //console.log(id);
     
    // $.ajax
    // ({
    //     type : "POST",
    //     url : "<?php echo base_url(); ?>location/get_streets",
    //     dataType : "json",
    //     data : {"locality_id" : id},
    //     success : function(data) {
    //          $("#streets_row").html(data.streets);
    //          console.log(data);
    //     },
    //     error : function(data) {
    //         alert('Something went wrong');
    //         console.log(data);
    //     }
    // });
    $.ajax
    ({
        type : "POST",
        url : "<?php echo base_url(); ?>location/get_streets",
        dataType : "json",
        data : {"locality_id" : id},
        success : function(data) {
             $("#streets_row").html(data.streets);
             //alert('hello');
             console.log(data);
        },
        error : function(data) {
            alert('Something went wrong');
        }
    });
  }
 
 
</script>
<?php
 $last_inserted_city_id =''; 
  if($this->session->flashdata('last_insert_id_to_call_ajax'))
  {
    $last_inserted_city_id =  $this->session->flashdata('last_insert_id_to_call_ajax');
    echo "<script type='text/javascript'>console.log('$last_inserted_city_id');</script>";
    echo "<script type='text/javascript'>get_city_wise_locality('$last_inserted_city_id');</script>";
 }?>
 <?php
 $last_inserted_locality_id =''; 
  if($this->session->flashdata('last_insert_street_id_to_call_ajax'))
  {
    $last_inserted_locality_id =  $this->session->flashdata('last_insert_street_id_to_call_ajax');
    echo "<script type='text/javascript'>console.log('$last_inserted_locality_id');</script>";
    echo "<script type='text/javascript'>get_street('$last_inserted_locality_id');</script>";
 }?>
 