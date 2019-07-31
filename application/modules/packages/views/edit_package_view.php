
<?php
/* * ***********************
 * PAGE: TO Add The packages.
 * #COPYRIGHT: Ripenapps
 * @AUTHOR: vicky kashyap
 * CREATOR: 04/07/2018.
 * UPDATED: --/--/----.
 * codeigniter framework
 * *** *********************/
?>
<?php
if($this->session->flashdata('frequency'))
{
  echo"<script>alert('Please Choose A Frequency')</script>";
}
?>
<style>
.span_ajax_class
{
 cursor: pointer; 
}
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    -ms-appearance: none;
    appearance: none;
    margin: 0; 
}
</style>
<style>

.selectBox {
  width: 100%;
  position: relative;
}

.selectBox select {
  width: 100%;
  height: 35px;
  /*font-weight: bold;*/
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#checkboxes {
  display: none;
  border: 1px #dadada solid;
}
#checkboxes_city {
  display: none;
  border: 1px #dadada solid;
}
#checkboxes_frequency {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes label {
  margin-left:8px;
  display: block;
}
#checkboxes_city label {
  margin-left:8px;
  display: block;
}
#checkboxes_frequency label {
  margin-left:8px;
  display: block;
}

#checkboxes label:hover {
  background-color: #1e90ff;
}
#checkboxes_city label:hover {
  background-color: #1e90ff;
}
#checkboxes_frequency label:hover {
  background-color: #1e90ff;
}
</style>
<style>
.multi-select-button
{
  max-width: none;
  overflow: visible;
}
.btn-save{
  margin:  0 auto!important;
  display: block;
}
</style>
<link href="<?php echo base_url_custom;?>build/css/example-styles.css" rel="stylesheet">
<a href="#" onclick="history.go(-1);" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
<div class="right_col" id="cool" role="main">

  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Edit  Packages</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form class="form-horizontal form-label-left" method="post" action="<?php echo base_url()?>packages/update_package?id=<?php echo  $package_row['id']; ?>">
            <div class="form-group">
              <div class="control-label col-md-3 col-sm-3 col-xs-12">
                <label>Package Name</label>           
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">           
                <input type="text" required class="form-control" name="pname" value="<?php echo $package_row['name']?>" placeholder="Enter Package Name">
                <input type="hidden" name="package_id" id="package_id" value=<?php echo $package_row['id'];?>>
              </div>
            </div>
            <div class="form-group">
              <div class="control-label col-md-3 col-sm-3 col-xs-12">
               <label>Please Choose A Car Type</label>
             </div>
             <div class="col-md-6 col-sm-6 col-xs-12">
              <select required class="form-control " id="car_type" name="car_type" placeholder="select car type">

                <option value="<?php echo $package_row['type']?>"><?php echo $package_row['type'];?></option>
              </select>
            </div>
          </div>
          <?php echo"<font color = 'red'>"; echo form_error('car_type');echo"</font>";?>
          <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
              <label>Selecte City</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">

              <div class="selectBox" onclick="showCheckboxes_city()">
                <select>
                  <option>Select an option</option>
                </select>
                <div class="overSelect"></div>
              </div>
              <div id="checkboxes_city">

                <?php 
                if(!empty($all_cities))
                {
                  foreach ($all_cities as $key => $value)
                  {  
                    // echo $value['id']; die;
                    ?>

                    <label for="one">
                      <input name="to_get_checked" onclick="demo(this.value)" <?=in_array($value['id'],$package_city) ? 'checked' : ''?> value="<?php echo $value['id']; ?>" type="checkbox" id="city_<?php echo $value['id'];?>"/><?=$value['name']?></label>
                  <!--   echo"<label for='one'>
                    <input onclick='demo(this.value)' ".in_array($all_cities,$package_city) ? 'checked' : ''." value='".$value['id']."' type='checkbox' id='city_".$value['id']."']'/>".$value['name']."</label>";--> 
                                                                                
                    <?php
                  }
                }
                ?>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
              <label>Selected Cities</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div id="textspan" style="min-height:100px;overflow:scroll; border:1px solid #ccc;padding:4px;">
                <?php

                   $counter =1;
                   foreach ($all_cities as $key => $value)
                   {
                    if(in_array($value['id'],$package_city))
                    {
                    ?>
                     <span id="<?php $value['id'];?>" class="tag"><span>
                      <?=$value['name']?>&nbsp;&nbsp;</span>
                      <span id="<?php echo  $value['id']?>" onclick='removefunction(this.id)' class='span_ajax_class' title='Remove City'>x</span></span>
                      <?php
                      $counter++;
                    }
                   }

                ?>
              </div>
            </div>
          </div>
          <?php echo"<font color = 'red'>"; echo form_error('city');echo"</font>";?>
          <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
              <label>Select Locality</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div  required class="selectBox" onclick="showCheckboxes()"> 
                <select>
                  <option>Select locality</option>

               

                </select>
                <?php
                if($this->session->flashdata('locality'))
                {
                  echo"<font color='red'>Please Choose Locality</font>";
                }
                ?>
                <div class="overSelect"></div>
              </div>
              <div id="checkboxes" class="collect_id">
                <?php
                  if(!empty($all_localities))
                {
                  foreach ($all_localities as $key => $value)
                  { 
                    if(in_array($value['city_id'], $package_city))
                    {
                    ?>

                      <label for="one">
                        <input onclick="get_final_locality_textarea(this.id)" <?=in_array($value['id'],$package_locality) ? 'checked' : ''?> value="<?php echo  $value['id']?>,<?php echo $value['city_id']?>" name="locality_checkbox[]" type="checkbox" id="locality_<?php echo $value['id'];?>"/><?=$value['name']?>(<?php echo $value['city']?>)</label>
                      <!--   echo"<label for='one'>
                        <input onclick='demo(this.value)' ".in_array($all_cities,$package_city) ? 'checked' : ''." value='".$value['id']."' type='checkbox' id='city_".$value['id']."']'/>".$value['name']."</label>";--> 
                                                                                
                    <?php
                  }
                  }
                }
                ?>
              </div>
            </div>
          </div>

          <!--/custom checkbox-->
          <!-- <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
              <label>Selected Localities</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div id="textspan_locality" style="min-height:100px; overflow:scroll; border:1px solid #ccc;padding:4px;">
                 <?php

                   $counter =1;
                   foreach ($all_localities as $key => $value)
                   {
                    if(in_array($value['id'],$package_locality))
                    {
                    ?>
                     <span id="localities_span_<?php echo $value['id'];?>" class="tag"><span>
                      <?=$value['name']?>&nbsp;&nbsp;</span>
                      <span id="<?php echo  $value['id']?>" onclick='removespan(this.id)' class='span_ajax_class' title='Remove City'>x</span></span>
                      <?php
                      $counter++;
                    }
                   }

                ?>

              </div>
            </div>
          </div> -->
          <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
              <label>Select Package type</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                  <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Monthly</a>
                  </li>
                  <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Once</a>
                  </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                    <div id="whenmonthly" style="">
                      <div class="form-group">
                        <div class="control-label col-md-4 col-sm-3 col-xs-12">
                         <label>Interior Cost(once)</label>
                       </div>
                       <div class="col-md-8 col-sm-6 col-xs-12">
                        <input name="interior_once" value="<?php echo $package_row['interior_once']?>" id="interior_once" onblur="do_require(this.value)"  type="number" class="form-control"  placeholder="Enter Cost">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="control-label col-md-4 col-sm-3 col-xs-12">
                       <label>Exterior Cost(once)</label>
                     </div>
                     <div class="col-md-8 col-sm-6 col-xs-12">
                      <input  type="number" class="form-control"  value="<?php echo $package_row['exterior_once']?>" name="exterior_once" id="exterior_once" placeholder="Enter Cost">
                    </div>
                  </div> 
                  <div class="form-group">
                    <div class="control-label col-md-4 col-sm-3 col-xs-12">
                     <label>Interior Cost(thrice)</label>
                   </div>
                   <div class="col-md-8 col-sm-6 col-xs-12">
                    <input  type="number" class="form-control" value="<?php echo $package_row['interior_thrice']?>" name="interior_thrice" id="interior_thrice" onblur="ext_three_require(this.value)" placeholder="Enter Cost">
                  </div>
                </div>
                <div class="form-group">
                  <div class="control-label col-md-4 col-sm-3 col-xs-12">
                   <label>Exterior Cost(thrice)</label>
                 </div>
                 <div class="col-md-8 col-sm-6 col-xs-12">
                  <input  type="number" class="form-control" value="<?php echo $package_row['exterior_thrice']?>" name="exterior_thrice" id="exterior_thrice" placeholder="Enter Cost">
                </div>
              </div> 
              <div class="form-group">
                <div class="control-label col-md-4 col-sm-3 col-xs-12">
                 <label>Interior Cost(five)</label>
               </div>
               <div class="col-md-8 col-sm-6 col-xs-12">
                <input  type="number" class="form-control" value="<?php echo $package_row['interior_five']?>" name="interior_five" id="interior_five" onblur="ext_five_require(this.value)" placeholder="Enter Cost">
              </div>
            </div>
            <div class="form-group">
              <div class="control-label col-md-4 col-sm-3 col-xs-12">
               <label>Exterior Cost(five)</label>
             </div>
             <div class="col-md-8 col-sm-6 col-xs-12">
              <input  type="number" class="form-control" value="<?php echo $package_row['exterior_five']?>"  name="exterior_five" id="exterior_five" placeholder="Enter Cost">
            </div>
          </div>
        </div><!--/when monthly close-->  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
        <div id="whenonce" style="">
          <div class="form-group">
            <div class="control-label col-md-4 col-sm-3 col-xs-12">
              <label> Interior Cost</label>
            </div>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input name="interior_cost" required id="interior_cost" type="number" value="<?php echo $package_row['price_interior']?>" onblur="require_all(this.value)" class="form-control"  placeholder="Enter Cost">
            </div>
          </div>
          <div class="form-group">
            <div class="control-label col-md-4 col-sm-3 col-xs-12">
             <label> Exterior Cost</label>
           </div>
           <div class="col-md-8 col-sm-6 col-xs-12">
            <input name="exterior_cost" required type="number" value="<?php echo $package_row['price_exterior']?>" id="exterior_cost" class="form-control"  placeholder="Enter Cost">
          </div>
        </div>
      </div>  <!--/when once-->
    </div>
  </div>
</div>
              <!-- <select onchange="show_text_field(this.value)" required class="form-control" id="select" name="p_type">
                <option value="" disabled selected>Select Package type</option>
                <option value="monthly">Monthly</option> <option value="once">Once</option>
              </select> -->
            </div>
          </div>  

          <!-- <div class="form-group" id="frequency_select">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
              <label>Select Frequency</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control">
                <option value="1">Once A Week</option>
                <option value="2">Thrice A Week</option>
                <option value="3">Five Times A Week</option>
              </select>    
            </div>
          </div>   -->
          


          <!-- when user choose monthy package-->


          
          <!--/ when user choose monthy package-->


          <br>
          <button id="button" class="btn btn-primary btn-md btn-save">Update</button>
        </form>
      </div>
    </div>
    <div class="col-md-3"></div>   
  </div><!--x panel-->
</div>
</div>
</div>

<script type="text/javascript">
// function to get city and locality for the locality dropdown
function get_locality_and_city(val)
{
  // alert(val);
    //var id = val;
    //console.log(id);
    var car_type = document.getElementById('car_type').value;
    var package_id = document.getElementById('package_id').value;
  // if(car_type)
  // {
     //return false;
     $.ajax
     ({
      type : "POST",
      url : "<?php echo base_url(); ?>packages/get_locality_with_city_edit",
      dataType : "json",
      data : {"city_id" : val,
      "car_type":car_type,"p_id":package_id
    },
    success : function(data) {
      // alert(data);
       // console.log(data); return false;
               //$("#ajax_select_locality").html(data.option);
               $("#checkboxes").html(data.option);
               //$("#textspan").html(data.textarea);
               //$("#locality_ajax_table").html(data.dropdown);
               //alert('hello');
            //   console.log(data); return false;
             },
             error : function(data) {
              alert('Something went wrong');
            } 
          });
  //}
  // else
  // {
  //   alert('select Car Type First');
  // }
}

//funxtion to get city for the text area
function get_city_for_textarea(val)
{
  //alert(val);
    //var id = val;
    //console.log(id);
    $.ajax
    ({
      type : "POST",
      url : "<?php echo base_url(); ?>packages/get_textarea_city_edit",
      dataType : "json",
      data : {"city_id" : val},
      success : function(data) {
             //$("#ajax_select_locality").html(data.option);
             //$("#checkboxes").html(data.option);
             $("#textspan").html(data.textarea);
             //$("#locality_ajax_table").html(data.dropdown);
             //alert('hello');
             console.log(data);
           },
           error : function(data) {
            alert('Something went wrong');
            console.log(data);
          }
        });
  }
</script>

<!-- jquery multi select -->
<script type="text/javascript">
 $(function(){
     // $('.forplugin').multiSelect();     
     $('#cityid').multiSelect();     
   });

 </script>
 <script>


  // to get array of selected checkboxes
  function demo()
  {
    // var car_type = document.getElementById('car_type').value;
    // if(car_type)
    // {  
     var myArray = [];
     var to_get_city = [];

     $("input:checkbox[name=to_get_checked]:checked").each(function()
     {

      if(this.value)
      {
              // alert(this.value);
              myArray.push(this.value);
              to_get_city.push(this.value);
            }
          });
         //alert(myArray);
         if (myArray === undefined || myArray.length == 0)
         {
            console.log('blank array');
            get_locality_and_city(0);
            //$('#textspan').html('');
          }
          else
          {
            // alert(myArray);
            get_locality_and_city(myArray);
          }
          if (to_get_city === undefined || to_get_city.length == 0) {
            console.log('blank array');
            $('#textspan').html('');
          }
          else
          {
            get_city_for_textarea(to_get_city);
          }
    //}
    // else
    // {
    //   alert('Select Car Type First');
    // }     
    //alert("Checked: " + myArray.join(","));
  }
</script>


<!--custom checkboxes-->
<script type="text/javascript">

  var expanded = false;

  function showCheckboxes() {
    var checkboxes = document.getElementById("checkboxes");
    if (!expanded) {
      checkboxes.style.display = "block";
      expanded = true;
    } else {
      checkboxes.style.display = "none";
      expanded = false;
    }
  }

</script>

<script type="text/javascript">

  function disablefrequency(val)
  {
    var type = val;
    if(type == "once")
    {
      $("#frequency_select").hide();
    }else{
      $("#frequency_select").show();
    }
  }

</script>


<!-- to remove textarea  span tag ,to uncheck sity dropdown checkbox and to remove locality from locality dropdown-->
<script>
  function removefunction(spanid)
  {
    var id = spanid;
    var city_id = 'city_'+spanid;
   // var to_delete_locality = id;
   document.getElementById(id).remove();
   document.getElementById(city_id).checked = false;
    //demo();
     //document.getElementById(to_delete_locality).remove();
    // console.log(to_delete_locality);
    //$("."+to_delete_locality).remove();
     //document.getElementsByClassName("to_delete_locality_7").remove();
     $('.to_delete_locality_'+id).remove();
    // 
    // document.getElementById(id).remove();
  }
</script>


<script type="text/javascript">

  var expanded = false;

  function showCheckboxes_city() {
  //var bool = 1;
  // if(bool=1)
  // {
  //   alert('choose city first');
  //   return false;
  // }
  var checkboxes = document.getElementById("checkboxes_city");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}

</script>
<script type="text/javascript">

  var expanded = false;

  function showCheckboxes_frequency() {
  //var bool = 1;
  // if(bool=1)
  // {
  //   alert('choose city first');
  //   return false;
  // }
  var checkboxes = document.getElementById("checkboxes_frequency");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}

</script>

<script>
  function get_final_locality_textarea(val)
  {

   var locality_id_array = [];
   //var to_get_city = [];

   $(".collect_id input:checked").each(function()
   {

    if(this.value)
    {
      //alert(this.value);
      locality_id_array.push(this.value);
      //to_get_city.push(this.value);
    }
  });
   if (locality_id_array === undefined || locality_id_array.length == 0) {
    console.log('blank array');
    $('#textspan_locality').html('');
  }
  else
  {
    get_locality_texrarea(locality_id_array);
  }
    //alert(locality_id_array);
    // get_locality_texrarea(locality_id_array);
  }
</script>
<script>

  function get_locality_texrarea(ids)
  {
   $.ajax
   ({
    type : "POST",
    url : "<?php echo base_url(); ?>packages/get_final_locality_for_textarea",
    dataType : "json",
    data : {"locality_id" : ids},
    success : function(data) {
             //$("#ajax_select_locality").html(data.option);
             $("#textspan_locality").html(data.option);
             // $("#textspan").html(data.textarea);
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
<script>
  function removespan(spanid)
  {
    var id = 'localities_span_'+spanid;
    var locality_id = 'locality_'+spanid;
     // alert(id);
    // alert(locality_id);
    document.getElementById(locality_id).checked = false;
    document.getElementById(id).remove();
  }
</script>
<script type="text/javascript">
  function show_text_field(val)
  {
    var type = val;
    // alert(type);
    if(type == "monthly")
    {
      document.getElementById( 'whenmonthly' ).style.display = 'block';
      document.getElementById( 'whenonce' ).style.display = 'none';
    }
    else{
      document.getElementById( 'whenonce' ).style.display = 'block';
      document.getElementById( 'whenmonthly' ).style.display = 'none';
    }

  }


</script>
<script>
function do_require(val)
{
  var interior_cost = val;
  if(interior_cost)
  {
    $("#exterior_once").prop('required',true);
  }
  else
  {
     $("#exterior_once").prop('required',false);
  }

}
function ext_three_require(val)
{
  var interior_cost = val;
  // alert(interior_cost); return false;
  if(interior_cost)
  {
    $("#exterior_thrice").prop('required',true);
  }
  else
  {
     $("#exterior_thrice").prop('required',false);
  }

}
function ext_five_require(val)
{
  var interior_cost = val;
  if(interior_cost)
  {
    $("#exterior_five").prop('required',true);
  }
  else
  {
     $("#exterior_five").prop('required',false);
  }
}
function require_all(val)
{
  var interior_cost = val;
  if(interior_cost)
  {
    $("#exterior_cost").prop('required',true);
  }
  else
  {
     $("#exterior_cost").prop('required',false);
  }

}
</script>


<script>
// $('#button').on('click',function(e)
// {
//   var exterior_cost = $("#exterior_cost").val();
//   var interior_cost = $("#interior_cost").val();

//   var interior_once = $("#interior_once").val();
//   var exterior_once = $("#exterior_once").val();


//   var interior_thrice = $("#interior_thrice").val();
//   var exterior_thrice = $("#exterior_thrice").val();

//    var interior_five = $("#interior_five").val();
//   var exterior_five = $("#exterior_five").val();


//   alert(interior_once);
//   alert(exterior_once);

//   if((!exterior_cost || exterior_cost==0 ) || (!interior_cost ||  interior_cost==0) )
//   {
//     alert('Please Fill Up The Once Package Amount');
//       e.preventDefault();
//   }
//   else if(interior_once  && (!exterior_once || exterior_once==0) )
//   {
//      alert('Please Fill The Amount For Exterior Once.');
//      e.preventDefault();
//   }
//   else if(interior_thrice && (!exterior_thrice || exterior_thrice==0))
//   {
//      alert('Please Fill The Amount For Exterior Thrice.');
//      e.preventDefault();
//   }
//   else if(interior_five && (!exterior_five || exterior_five==0))
//   {
//      alert('Please Fill The Amount For Exterior Five.');
//      e.preventDefault();
//   }
// });

</script>

<script>
$('#button').on('click',function(e)
{
    var exterior_cost = $("#exterior_cost").val();
    var interior_cost = $("#interior_cost").val();

    // var interior_once = $("#interior_once").val();
    var exterior_once = $("#exterior_once").val();


    // var interior_thrice = $("#interior_thrice").val();
    var exterior_thrice = $("#exterior_thrice").val();

    // var interior_five = $("#interior_five").val();
    var exterior_five = $("#exterior_five").val();
    
    if((!exterior_cost || exterior_cost==0) || (!exterior_once || exterior_once==0) || (!exterior_thrice || exterior_thrice==0) || (!exterior_five || exterior_five==0))
    {
      alert('Please Fill Up The All Exterior Amount Field');
       e.preventDefault();
    }

});

</script>