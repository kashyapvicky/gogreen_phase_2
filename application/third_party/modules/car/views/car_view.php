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
<?php

?>
<style>
.btn-save{
  margin:  0 auto!important;
  display: block;
}
#expand_btn
{
  background-color: Transparent;
  /*background-repeat:no-repeat;*/
  border: none;
  /*cursor:pointer;*/
  /*overflow: hidden;*/
  /* outline:none;*/
  font-size: 50px;
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

</style>
<div class="right_col" id="cool" role="main">

  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Add Models </h2>
          
          <div class="clearfix"></div>
          <?php
          if($this->session->flashdata('added'))
          {
            echo"<div style='margin-left: 150px;'>";
            echo"<font color='green'>Brand Added Succesfully</font>";
            echo"</div>";
          }
          ?>
        </div>

        <div class="col-md-3"><br>
          <h2>Add More Model</h2>
          <button onclick="myfunction()" id="expand_btn" class="glyphicon glyphicon-plus-sign"></button>
        </div>
        <div class="col-md-6">
          <br>
          <form method="post" action="<?php echo base_url()?>car/insert_models">
            <label>Select Car Brand</label>
            <select required name='brand' class="form-control" id="select" name="brand_name" placeholder="select car type">
              <option  value="" disabled selected>Select Car Brand</option>
              <?php
                foreach ($brands as $key => $value) {

                  echo"<option value='".$value['id']."'>".$value['name']."</option>";
                }
              ?>
            </select>
            <br>
            <div id="varientdiv1"> 
              <div id="cross1" onclick='closevarient(this.id)' style="float:right; color:red; text-decoration:underline;cursor:pointer;"><span  class="fa fa-close"></span></div>
              <input required type="text" id="field" placeholder="Model Name" name="model[]" style="" class="form-control
              ">
              <br>
            </div>
            
            <div class="clonediv"></div>
            <button class="btn btn-primary btn-md btn-save">Save</button>
          </div>
          </form>
            <div class="col-md-3" style="margin-top: 30px">
              <h2>Add More Brand</h2>
              <button onclick="modalfunction()" data-toggle="modal" data-target="#myModal" id="expand_btn" class="glyphicon glyphicon-plus-sign"></button>
            </div>

          
          </div><!--x panel-->
        </div>
      </div>
    </div>



    <!--Modal For brand add-->

    <div style="" class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
          
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4  class="modal-title">Add Brand</h4>
            </div>
            <div class="modal-body" style="">
             <form method="post" action="<?php base_url();?>car/addbrand">
              <input required type="text" class="form-control" name="add_brand" placeholder="Brand Name">
              
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-default" value="Add">
              </form>
              <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
       </div>
    </div>

    <!--modal closed -->



    <script>
      var counter = 2;
      function myfunction()
      { 
        var $div =  $("#varientdiv1").clone();
        var $klon = $div.clone().prop('id', 'varientdiv'+counter );
        $klon.find("#cross1").attr("id","varientdiv"+counter);
        //$klon.find("#field").attr("name","varientdiv"+counter);
  // $klon.append('<div id="varientdiv"+counter onclick="closevarient(this.id)" style="float:right; color: red; text-decoration: underline; cursor:pointer;">delete</div>')
  $klon.insertAfter("div.clonediv:last");
  counter++;
}
</script>
<script>
  function closevarient(id)
  {
    var cross_id = id;
    document.getElementById(cross_id).remove();
  }

</script>
<script>
//   $( document ).ready(function() {
//    document.getElementById('cross1').remove();
// });

</script>
<script type="text/javascript">
  

</script>>