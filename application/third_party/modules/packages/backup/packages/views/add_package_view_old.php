
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
#select
{
    /*min-width: 34%;*/
    /*height: 25px;*/
    /*margin: 2px 0 10px 7px;*/
    padding: 4px;
}
.centerfield
{
  margin-left: 100px;
  height: 30px;
  width: 50%;

}
#varientdiv1
{
  background-color: white;
  min-width: 30%;
  border: 1px solid #ccc;
}
.dropdowne
{
  display: block;
  margin: 0 auto;
  height: 30px;
  width: 50%
}
#btn
{
  margin-left: 30%;
  min-width: 37%;
  height: 30px;
  background-color: #73879C;
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
</style>
<div class="right_col" id="cool" role="main">
 
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Add New Packages </h2>
          
          <div class="clearfix"></div>
        </div>
    
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <br>
      <input type="text" class="form-control" name="pname" placeholder="Enter Package Name">
      <br>
      <select class="form-control" id="select" name="car_type" placeholder="select car type">
        <option>Select Car Type</option>
      </select>

      </div>
      <div class="col-md-3">
        <br>
        <h2>Add More Varient</h2>
        <button onclick="myfunction()" id="expand_btn" class="glyphicon glyphicon-plus-sign"></button>
        </div>

      </div><!--x panel-->
    </div>


    <!-- varient div row start from here-->
    
    <div   class="col-md-12 col-sm-12 col-xs-12" id="varientdiv1" onclick="" style="background-color: #E7E7E7; min-height: 115px; margin-top: 20px;">
      <ul id="demo1" class="nav navbar-right panel_toolbox">
      <li id="demo" ><i id="cross1" onclick="closevarient(this.id)" style="margin-left:60px" class="fa fa-close"></i></a>
      </li>
      </ul>
      <br>
      <div class="col-md-12">
        <div class="col-md-4">
          <select " class="form-control" name="car_type" placeholder="select car type">
          <option>Select City</option>
          </select>
        </div>
        <div class="col-md-4">
          <select class="form-control" name="car_type" placeholder="select car type">
          <option>Select Locality</option>
          </select>
        </div>
        <div class="col-md-4">
          <select class="form-control" name="car_type" placeholder="select car type">
          <option>Once</option>
          </select>
        </div>
      </div>
      <br>
      <br>
      <div class="col-md-12">
        <div class="col-md-4">
          <input type="text" id="" class="form-control" name="interior" placeholder="Cost For Interior Cleaning">
        </div>
        <div class="col-md-4">
          <input type="text" id="" class="form-control" name="interior" placeholder="Cost For Interior Cleaning">
        </div>
        <div class="col-md-4">
          <button id="btn"><font color="white">save</font></button>
        </div>  
      </div>
      <!-- <br>
      <br>
      <div class="col-md-4" id="varientdiv1">
        <br>
        <select class="" id="varientselect" name="car_type" placeholder="select car type">
        <option>Select City</option>
        </select>
        <br>
        <br>
        <select class="" id="varientselect" name="car_type" placeholder="select car type">
          <option>Select Locality</option>
        </select>
        <br>
        <br>
        <select class="" id="varientselect" name="car_type" placeholder="select car type">
          <option>Once</option>
        </select>
        <br>
        <br>
        <input type="text" id="varientselect" name="interior" placeholder="Cost For Interior Cleaning">
        <br>
        <br>
        <input type="text"  id="varientselect" name="exterior" placeholder="Cost For Exterior Cleaning">
        <br>
        <br>
        <br>
        <button id="btn">save</button>
        
      </div>
      
      <div class="col-md-4"></div> -->
    </div>
    <div class="clonediv"></div>

  </div>
</div>

<script>
  var counter = 2;
 function myfunction()
 { 
  var $div =  $("#varientdiv1").clone();
  var $klon = $div.clone().prop('id', 'varientdiv'+counter );
  $klon.find("#cross1").attr("id","varientdiv"+counter);
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