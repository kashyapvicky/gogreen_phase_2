<?php

/* * ***********************
 * PAGE: TO Listing The  Car Models.
 * #COPYRIGHT: Ripenapps
 * @AUTHOR: vicky kashyap
 * CREATOR: 09/07/2018.
 * UPDATED: --/--/----.
 * codeigniter framework
 * *** */
?>
<style>

</style>
<br><br>
<div class="right_col" id="cool" role="main">
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Car Models </h2>
          <?php if($this->session->flashdata('del_succ'))
          { echo"<div style='margin-left: 150px;'>";
            echo"<font color='green'>Successfully Deleted</font>";
            echo"</div>";
          }
          ?>
          <?php if($this->session->flashdata('del_err'))
          { echo"<div style='margin-left: 150px;'>";
            echo"<font color='red'>Error In Deletion</font>";
            echo"</div>";
          }
           if($this->session->flashdata('added_model'))
          {
            echo"<div style='margin-left: 150px;'>";
            echo"<font color='green'>Model Added Succesfully</font>";
            echo"</div>";
          }
          if($this->session->flashdata('failure_model'))
          {
            echo"<div style='margin-left: 150px;'>";
            echo"<font color='red'>Deletion In Error</font>";
            echo"</div>";
          }
          ?>
          <a href="<?php echo base_url()?>car/add_brand_with_model">
      <button style="float: right; width:10%">Add New</button></a>
      <button data-toggle="modal" data-target="#model_delete_modal" style="float: right;">Delete Model</button>
      <button data-toggle="modal" data-target="#brand_delete_modal" style="float: right;">Delete Brand</button>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Brand Name</th>
                <th>Model Name</th>
                <th>Operation</th>
               <!--  <th>Delete</th> -->
              </tr>
            </thead>


            <tbody id="">
              <?php
              
                 foreach($brand_model as $key => $value)
                 {
                   // echo"<pre>";print_r($brand_model); die;
                  echo"
                  <tr>
                   <td>".$value['brand']."</td>
                   <td>".$value['model']."</td>
                   <td><button class='btn btn-info' onclick='open_edit_modal(".$value['model_id'].")'>Edit</button></td>
                  </tr>";
                 }                 
              ?>
             
             
            <!--  <td>
                   <a href='".base_url()."car/delete_brand_model?b_id=".$value['brand_id']."&m_id=".$value['model_id']."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o m-right-xs'></i>Delete</a>
                   </td>-->
              
              <!-- <tr>
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
              </tr> 
 -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>





  <div class="row">
   
    

  </div>
</div>
    


<!-- modal for manuall team change -->
<div style="" class="modal fade" id="brand_edit_modal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4  class="modal-title">Edit Brand And Model</h4>
          </div>
          <div class="modal-body" style="">
           <form method="post" action="<?php base_url();?>car/edit_brand_model">
            <label>Brand Name</label>
            <input required type="text" class="form-control" required id="brand_edit" onblur="check_this_name(this.value)" name="brand_edit" placeholder="City Name">
            <span id="brand_exist"  style="color: red"></span>
            <input type="hidden" name="brand_id_edit" id="brand_id_edit">
            <input type="hidden" name="modal_id_edit" id="modal_id_edit">
            <br>
             <label>Model Name</label>
            <input required type="text" class="form-control" required id="modal_edit" name="modal_edit" placeholder="City Name">
            
            <span id="modal_span" style="color: red"></span>
            <input type="hidden" name="payment_key" id="payment_key">
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default" value="Update">
            <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </form>
          </div>
      </div>
    </div>
  </div>

  <!--/ moodal for manual team change -->


<!-- Delete brand modal -->
<div style="" class="modal fade" id="brand_delete_modal"  role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4  class="modal-title">Delete Brand</h4>
          </div>
          <div class="modal-body" style="">
           <form method="post" action="<?php base_url();?>car/delete_brand">
            <label>Choose Brand To Delete</label>
           <select class="form-control" name="brand_del">
                  <?php 
                  foreach($all_brands as $key => $value)
                 {
                    ?>
                    <option value="<?php echo $value['id']?>"><?php echo $value['name'];?></option>>

                    <?php
                 }
                 ?>
           </select> 
            <span id="modal_span" style="color: red"></span>
            <input type="hidden" name="payment_key" id="payment_key">
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default btn-danger" value="Delete">
            <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </form>
          </div>
      </div>
    </div>
  </div>

  <!--/ Delete Brand Model -->

  <!-- Delete model modal -->
<div style="" class="modal fade" id="model_delete_modal"  role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4  class="modal-title">Delete Model</h4>
          </div>
          <div class="modal-body" style="">
           <form method="post" action="<?php base_url();?>car/delete_model">
             <label>Please Select Brand</label>
             <select onchange="get_respective_models(this.value)" class="form-control" name="all_brands">
              <option disabled selected>Choose A Brand </option>
              <?php 
                  foreach($all_brands as $key => $value)
                 {
                    ?>
                    <option value="<?php echo $value['id']?>"><?php echo $value['name'];?></option>

                    <?php
                 }
                 ?>
             </select>
             <br>
            <label>Choose Model To Delete</label>
           <select required class="form-control" name="model_del" id="ajax_model">
                 <option disabled selected>Choose Brand First</option>
           </select> 
            <span id="modal_span" style="color: red"></span>
            <input type="hidden" name="payment_key" id="payment_key">
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default btn-danger" value="Delete">
            <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </form>
          </div>
      </div>
    </div>
  </div>

  <!--/ Delete model Model -->



<script>
  $( document ).ready(function() {
  document.getElementById("cool").style.minHeight = "697px";
  });
</script>
<script>
function open_edit_modal(id)
{
  var model_id = id;  
  $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>car/get_brand_model_to_edit",
        dataType : "json",
        data : {"model_id" : model_id},
        success : function(data)
        {

          // alert(data.model_id);
          $('#brand_edit').val(data.brand);
          $('#brand_id_edit').val(data.brand_id);
          $('#modal_id_edit').val(data.model_id);

          $('#modal_edit').val(data.model);
          $('#brand_edit_modal').modal('show');
          
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
 function check_this_name(val)
 {
    var brand_name = val;
    var brand_id = $('#brand_id_edit').val();
     $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>car/chek_brand_name_exist",
        dataType : "json",
        data : {"brand_id" : brand_id,"brand_name":brand_name},
        success : function(data)
        {

          if(data==1)
          {
            $('#brand_edit').val('');
            $('#brand_exist').html('Brand Alredy Exist');

          }
          // alert(data.model_id);
          
          
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
function get_respective_models(id)
{
   var brand_id = id;
    $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>car/get_brands_with_model_id",
        dataType : "json",
        data : {"brand_id" : brand_id},
        success : function(data)
        {

          $('#ajax_model').html(data);
             console.log(data);
        },
        error : function(data)
        {
            alert('Something went wrong');
        }
        });
   
}
</script>