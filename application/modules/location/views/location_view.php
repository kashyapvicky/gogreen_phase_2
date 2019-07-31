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
.forhover:hover
{
 text-decoration: underline;
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
.modal-footer
{
  text-align: center;
}
.modal-header
{
  background-color: #73879C;
}
.modal-header h4
{
  color: white;
}
.modal-header .close 
{
  color: #fff;
  opacity: 1;
}
.forcross
{
  
  margin-left: 20%;
  
}
.foredit
{
    width: 5%;
    margin-left: 70%;
    margin-top: 43px;
    position: absolute;
}
.toactive
{
  margin-left: 55%;
  margin-top: -9%;
}
.to_inactive_locality
{
  float: right;
  margin-right: 5%;
}
</style>

<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Locations</h3>
      <?php
      echo $this->session->flashdata('succ_active');
      echo $this->session->flashdata('city_exist');
      ?>
    </div>
    <div class="title_right">
    </div>
  </div>
  <br>
  <br>
  <br>
  <br>
  <div class="row locationtop-bx">

    <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="row">
      <div class="col-md-5"><font size="4px">City</font></div>
      <div class="col-md-7 text-right">
        <button type="button" value="" data-toggle="modal" data-target="#myModal"> Add City</button>
      </div>
    </div>
    </div>
      <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="row">
      <div class="col-md-5"><font size="4px"> Locality</font></div>
      <div class="col-md-7 text-right">
        <button type="button" data-toggle="modal" data-target="#localitymodal" value="">Add locality</button>
      </div>
      </div>
      </div>
      <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="row">
      <div class="col-md-5"><font size="4px"> Street</font></div>
      <div class="col-md-7 text-right">        
        <button type="button" data-toggle="modal" data-target="#streetmodal" value="">Add Street</button>
      </div>
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
              <th>City</th>
                <th>Edit</th>
                <th>Delete</th>
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
                  <td>
                  <div class='forcross'><a href='#editmodal' onclick='edit_city_ajax(".$value['id'].")' data-toggle='modal'><span class='fa fa-edit'></span></a></div>
                  </td>
                  <td>
                  <div class='forcross'><a href='".base_url()."location/remove_city_data?id=".$value['id']."'><span class='fa fa-close'></span></a></div>
                  </td>
                  </tr>";
                }
              }
              else{
                echo"No City To Display";
              }

              ?>
            </tbody>
          </table>
          <?php
          
          if($this->session->flashdata('SUCC_INACTIVE'))
          {
            echo"<font color = 'green'>";
            echo $this->session->flashdata('SUCC_INACTIVE');
            echo"</font>";
          }
          if($this->session->flashdata('city_del_error'))
          {
            echo"<font color = 'red'>";
            echo $this->session->flashdata('city_del_error');
            echo"</font>";
          }
          ?>
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
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>

              <tbody id="locality_row">
            </tbody>
          </table>
          <?php
          echo $this->session->flashdata('succ_active_locality');
          echo $this->session->flashdata('locality_inactive');
          echo $this->session->flashdata('locality_exist');
          if($this->session->flashdata('error'))
          {
            //echo"<script>alert('All Field Is Mandatory')</script>";
            echo"<font color = 'red'>";
            echo $this->session->flashdata('error');
            echo"</font>";

          }
          if($this->session->flashdata('locality_added_succesfully'))
          {
            echo"<font color = 'green'>";
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

                    <th>Payment</th>
                    <th>Edit</th>
                    <th>Delete</th>
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
          echo $this->session->flashdata('street_exist');
          echo $this->session->flashdata('street_inactive');
          if($this->session->flashdata('error_street'))
          {
            //echo"<script>alert('All Field Is Mandatory')</script>";
            echo"<font color = 'red'>";
            echo $this->session->flashdata('error_street');
            echo"</font>";

          }
          if($this->session->flashdata('street_added_succesfully'))
          {
            echo"<font color = 'green'>";
            echo $this->session->flashdata('street_added_succesfully');
            echo"</font>";
          }

          ?>
        </div>
      </div>

    </div> 


    <!-- modal for edit city -->
    <div style="" class="modal fade" id="editmodal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4  class="modal-title">Edit City</h4>
          </div>
          <div class="modal-body" style="">
           <form method="post" action="<?php base_url();?>location/editcity">
            <label>City Name</label>
            <input required type="text" class="form-control" id="city_ajax_name" name="city" placeholder="City Name">
            <input type="hidden" name="city_ajax_id" id="city_ajax_id">
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default" value="Update">
            <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </form>
          </div>
      </div>
    </div>
  </div>
    <!-- /modal for edit city -->


    <!-- Modal for city -->
    <div style="" class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4  class="modal-title">Add City</h4>
          </div>
          <div class="modal-body" style="">
           <form method="post" action="<?php base_url();?>location/addcity">
            <label>City Name</label>
            <input required type="text" class="form-control" name="city" placeholder="City Name">

          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default" value="Add">
          </form>
          <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!-- modal for locality edit -->
    <!-- #editmodal_locality -->
    <div style="" class="modal fade" id="editmodal_locality" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Locality</h4>
        </div>
        <div class="modal-body" style="">
         <form method="post" id = "localityform" action="<?php echo base_url();?>location/update_locality">
          <label>Select City</label>
          <select  name="city_select" class="form-control">
            <!-- <option value="NULL">City</option> -->
            <option value="" id="city_locked" disabled selected>Select City</option>
            
            </select>
            <br>
            <label>Locality Name</label>
            <input type="text" required="Please Select Locality" id="locality_edit" name="locality" placeholder="Enter Locality" class="form-control">
            <input type="hidden" name="edit_locality_id" id="edit_locality_id">
            <br>
            <label>Service Start Time</label>
            <input type="text" class="form-control timepicker1" id="st_id" required name="service_start" placeholder="Service Start Timing">
            <br>
            <label>Service End Time</label>
            <input type="text" class="form-control timepicker1" id="en_id" required name="service_end" placeholder="Service End Timing">

          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default" value="Update">
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
         <form method="post" id = "localityform" action="<?php echo base_url();?>location/addlocality">
          <label>Select City</label>
          <select required name="city_select" class="form-control">
            <!-- <option value="NULL">City</option> -->
            <option value="" disabled selected>Select City</option>
            <?php if(!empty($city)){foreach ($city as $key => $value) {
          # code...
              echo"<option value=".$value['id'].">".ucfirst($value['name'])."</option>";}}?>
            </select>
            <br>
            <label>Locality Name</label>
            <input type="text" required="Please Select Locality" name="locality" placeholder="Enter Locality" class="form-control">
            <br>
            <label>Service Start Time</label>
            <input type="text" class="form-control timepicker1" required name="service_start" placeholder="Service Start Timing">
            <br>
            <label>Service End Time</label>
            <input type="text" class="form-control timepicker1" required name="service_end" placeholder="Service End Timing">

          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default" value="Add">
          </form>
          <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- modaal for loclity -->


    <!-- modal for edit streets -->


      <div style="" class="modal fade" id="stree_modal_edit" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Street</h4>
        </div>
        <div class="modal-body" style="">
         <form method="post" action="<?php echo base_url();?>location/update_street">
          <label>Select City</label>
          <select onchange="" name="city_select" class="form-control">
            <!-- <option value="NULL">City</option> -->
            <option value="" disabled selected id="city_locked_for_street">Select City</option>
            </select>
            <br>
            <label>Select Locality</label>
            <select id=""   name="locality_select" class="form-control">
              <option value="" id="locality_locked" disabled selected> Select Locality</option>
            </select>
            <br>
            <label>Enter Street/Tower</label>
            <input type="text" name="street" id="street_edit" placeholder="Enter Street/Tower" class="form-control">
            <input type="hidden" name="street_hidden_id" id="street_hidden_id">
             <br>
            <label>Payment Type</label>
            <select id="paymnet_type"   name="payment_type" class="form-control">
              <option value="1">Go Green</option>
              <option value="2">Quickshine</option>
            </select>   
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default" value="Update">
          </form>
          <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>







    <!-- /modal for edit streets -->






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
          <label>Select City</label>
          <select onchange="get_locality_for_street(this.value)" name="city_select" class="form-control">
            <!-- <option value="NULL">City</option> -->
            <option value="" disabled selected>Select City</option>
            <?php if(!empty($city)){foreach ($city as $key => $value) {

              echo"<option value=".$value['id'].">".ucfirst($value['name'])."</option>";}}?>
            </select>
            <br>
            <label>Select Locality</label>
            <select id="locality_ajax"   name="locality_select" class="form-control">
              <option value="" disabled selected> Select Locality</option>
            </select>
            <br>
            <label>Enter Street/Tower</label>
            <input type="text" name="street" placeholder="Enter Street/Tower" class="form-control"> 
             <br>
            <label>Payment Type</label>
            <select id="paymnet_type"   name="payment_type" class="form-control">
              <option value="1"  selected>Go Green</option>
              <option value="2">Quickshine</option>
            </select>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default" value="Add">
          </form>
          <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal for streets -->
  <br><br>
  <!-- collapsible inactive cities -->
  <div class="row">
    <!--Inactive Cities -->
    <div class="col-md-6">
      <div class="panel">
        <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          <h4 class="panel-title"> &nbsp;&nbsp; View Inactive Locations </h4>
        </a>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>City</th>


                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if(!empty($inactive_city))
                    {

                      foreach ($inactive_city as $key => $value){
                        echo"<tr>";
                        echo"<td>".$value['name']."<div class='toactive'><a class='forhover btn btn-default' href='".base_url()."location/do_active?id=".$value['id']."'>Activate</a></div></td>";
                        echo"</tr>";


                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Locality</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if(!empty($inactive_locality))
                    {

                      foreach ($inactive_locality as $key => $value){
                        echo"<tr>";
                        echo"<td>".$value['name']."<div class='toactive'><a class='forhover btn btn-default' href='".base_url()."location/do_active_locality?id=".$value['id']."'>Activate</a></div></td>";
                        echo"</tr>";
                      }
                    }
                    else{
                      echo"
                      <tr>
                      <td>Nothing To Display</td>
                      </tr>

                      ";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <!-- /Inacive Citeis -->
  </div>

  <!-- collapsible inactive cities ends here -->

</div>
</div>



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
<script>
  $(document).ready(function () {
    // alert('hello');
    // console.log('test');
        // $('#localityform').validate({
        //     rules: {
        //         city_select: {
        //             required: true,
        //            // alpha: true,
        //         },
        //         locality: {
        //           required  : true,
        //         },
        //         service_start: {
        //           required  : true,
        //         },
        //         lat: {
        //           service_end  : true,
        //           number : true,
        //         }

        //     },
        //     messages: {
        //       city_select: "Please Select City name",
        //       locality: "Please Enter A Locality",
        //       service_start: "Choose Service Start Time",
        //       service_end: "Choose Service Start Time",


        //     },

        // });
      });
    </script>
    <link href="<?php echo base_url_custom;?>build/css/timepicki.css" rel="stylesheet">
    <script src="<?php echo base_url_custom;?>build/js/timepicki.js"></script>

    <script>
      $('.timepicker1').timepicki();
    </script>
<script>

//   $(document).ready(function(){
//     $('#editmodal').on('show.bs.modal', function (e) {
//         var rowid = $(e.relatedTarget).data('id');
//         console.log(rowid); return false;
//         $.ajax({
//             type : 'post',
//             url : 'fetch_record.php', //Here you will fetch records 
//             data :  'rowid='+ rowid, //Pass $id
//             success : function(data){
//             $('.fetched-data').html(data);//Show fetched data from database
//             }
//         });
//      });
// });

  function edit_city_ajax(val)
  {
      var id = val;
      $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>location/get_city_to_edit",
        dataType : "json",
        data : {"city_id" : id},
        success : function(data) {
          $("#city_ajax_id").val(data.id);
          $("#city_ajax_name").val(data.name);
         // $("#locality_ajax_table").html(data.dropdown);
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
  function edit_locality_ajax(val)
  {
     var id = val;
      $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>location/get_locality_to_edit",
        dataType : "json",
        data : {"locality_id" : id},
        success : function(data) {
          $("#city_locked").text(data.city);
          $("#locality_edit").val(data.locality);
          $("#edit_locality_id").val(data.id);
          $("#st_id").val(data.start_time);
          $("#en_id").val(data.end_time);
         // $("#locality_ajax_table").html(data.dropdown);
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
  function edit_street_ajax(val)
  {
     var id = val;
      $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>location/get_street_to_edit",
        dataType : "json",
        data : {"street_id" : id},
        success : function(data) {
          $("#city_locked_for_street").text(data.city);
          $("#locality_locked").text(data.locality);
          $("#street_edit").val(data.street);
          $("#street_hidden_id").val(data.id);
          $("#payment_type").val(data.payment_type);
          // $("#st_id").val(data.start_time);
          // $("#en_id").val(data.end_time);
         // $("#locality_ajax_table").html(data.dropdown);
             //alert('hello');
             console.log(data);
           },
           error : function(data) {
            alert('Something went wrong');
          }
        });
  }
  </script>