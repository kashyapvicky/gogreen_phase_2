
<?php
// echo $user_id; die;
/* * ***********************
 * PAGE: TO Add The packages.
 * #COPYRIGHT: Ripenapps
 * @AUTHOR: vicky kashyap
 * CREATOR: 04/07/2018.
 * UPDATED: --/--/----.
 * codeigniter framework
 * *** *********************/
?> 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
 <!-- <link href="<?php echo base_url_custom;?>build/css/datepicker.css" rel="stylesheet"> -->
<a href="#" onclick="history.go(-1);" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a> 
<div class="right_col" id="cool" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Activate Package</h3>
    </div>
    <div class="title_right">
    </div>
  </div>
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
       <div class="x_title">
        <h2>Add Package To Inactive Cars</h2>

        <?php
        ?>
        <?php if($this->session->flashdata('phone_exist'))
        { 
            //echo"alresdy exist";die;
          echo"<div style='margin-left: 150px;'>";
          echo"<font color='red'>Email Already Exist</font>";
          echo"</div>";
        }
        ?>

        <div class="clearfix"></div>
        <?php
        if(empty($cars))
        {
          echo "You Have No Inactive Car.";
        }
         echo $this->session->flashdata('package_activated');
        echo $this->session->flashdata('car_inserted');
        echo $this->session->flashdata('car_updated');

        ?>
      </div>
      <div class="x_content">
        <form method="post" action="<?php echo base_url()?>manual/book_packaage" id="car_data" data-parsley-validate class="form-horizontal form-label-left">

          <input type="hidden" name="hidden_user_id" id="hidden_user_id" value="<?php echo $user_id?>">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Selected Car
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select required name="car" onchange=""  class="form-control">
               <!--  <option value="" disabled selected>Select Car</option> -->
                <?php
                if(!empty($cars))
                {
                  //echo $car_id; die;
                       // print_r($cars); die;
                  foreach ($cars as $key => $value) 
                  {
                    if($value['id']==$car_id)
                    {
                      echo"<option  selected value='".$value['id']."'>".$value['reg_no']."";
                      
                    }
                  }
                }
                ?>
              </select>
            </div>
          </div>  <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select City
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select required name="city" onchange="get_city(this.value)"  class="form-control">
                <option value="" disabled selected>Select City</option>
                <?php
                if(!empty($cities))
                {
                       // print_r($cars); die;
                  foreach ($cities as $key => $value) 
                  {

                    echo"<option  value='".$value['id']."'>".$value['name']."";

                  }
                }
                ?>
              </select>
            </div>
          </div>    
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Locality
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select required name="locality" id="locality_select" onchange="get_street(this.value)"   class="form-control">
                <option value="" disabled selected>Choose City First</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Street
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select required name="street" id="street_select" onchange=""   class="form-control">
                <option value="" disabled selected>Choose Locality First</option>
                <?php

                // if(!empty($all_brands))
                // {
                //   foreach ($all_brands as $key => $value) 
                //   {
                //     echo"<option  value='".$value['id']."'>".$value['name'].""; 
                //   }
                // }
                ?>

              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Service
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select required name="services" id="services" onchange=""   class="form-control" >
               <option value="2" selected>Exterior</option>
               <option value="3">Both(Interior + Exterior)</option>
              
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Type
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select required name="type" id="type" onchange="hide_show_div(this.value)"   class="form-control">
                <option value="" disabled selected>Choose Package Type</option>
               <option value="monthly">Monthly</option>
               <option value="once">Once</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Date
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
           <!--  <input type="text" name="date" id="date" class="form-control" autocomplete="off" required placeholder="DD / MM / YY" data-select="datepicker"> -->
           <input type="text" name="date" class="form-control has-feedback-left" id="custom_calender" placeholder="First Name" aria-describedby="inputSuccess2Status2">
            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            </div>
          </div>
          <div id="monthly_type" style="display: none">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Frequency
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select  name="frequency" id="frequency" onchange=""   class="form-control">
                  <option value="" disabled selected>Choose Frequency</option>
                 <option value="2">Twice A Week</option>
                 <option value="3">Thrice A Week</option>
                 <option value="6">Six Times A Week</option>
                </select>
              </div>
            </div>
             <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Month
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select required name="no_of_months" id="no_of_months"   class="form-control">
                  <option value="" disabled selected>Choose A Number</option>
                 <option value="1"> 1 Month</option>
                 <option value="2"> 2 Month</option>
                 <option value="3"> 3 Month</option>
                 <option value="4"> 4 Month</option>
                 <option value="5"> 5 Month</option>
                 <option value="6"> 6 Month</option>
                 <option value="7"> 7 Month</option>
                 <option value="8"> 8 Month</option>
                 <option value="9"> 9 Month</option>
                 <option value="10"> 10 Month</option>
                 <option value="11"> 11 Month</option>
                 <option value="12"> 12 Month</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Days
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select  name="days[]" id="days" class="form-control" multiple>
                 <option value="Sun">Sunday</option>
                 <option value="Mon">Monday</option>
                 <option value="Tue">Tuesday</option>
                 <option value="Wed">Wednesday</option>
                 <option value="Thu">Thrusday</option>
                 <option value="Sat">Saturday</option>
                </select>
              </div>
            </div>
          </div>   <!-- montyhly type ends here  -->
          <div class="row" style="text-align: center;">
            <button class="btn btn-success" id="form_btn" >Save</button>
          </div>
        </form>
      </div>
    </div><!--x panel-->
  </div>
</div>
</div>
<!-- <script src="<?php echo base_url_custom; ?>build/js/datepicker.js"></script> -->
<script>
 function get_city(val)
 {
  var city_id = val;
  $.ajax
  ({
    type : "POST",
    url : "<?php echo base_url(); ?>cleaner/get_locality",
    dataType : "json",
    data : {"city_id" : city_id},
    success : function(data) 
    {
     $("#locality_select").html(data);
     console.log(data);
   },
   error : function(data) {
    alert('Something went wrong');
  }
});
}
 // to get user info from dropdown
 function get_respective_models(id)
 {
   var brand_id = id;
   $.ajax
   ({
    type : "POST",
    url : "<?php echo base_url(); ?>manual/get_brands_with_model_id",
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

 function save_data(e)
 {
  var post_array = $('#car_data').serialize(); 
  console.log(post_array);
  event.preventDefault();
}

function get_car_info(array_index)
{

  var car_array = <?php echo json_encode( $cars) ?>;
  var array_key = array_index;

  var car_id = car_array[array_key].id;
  // var user_id = car_array[array_key].user_id;
  // alert(car_id); return false;
  var reg_no = car_array[array_key].reg_no;
  var type = car_array[array_key].type;
  var brand = car_array[array_key].brand;
  var model = car_array[array_key].model;
  var parking_number = car_array[array_key].parking_number;
  var color = car_array[array_key].color;


  $('#color').val(color);
  $('#type').val(type);
  $('#reg_no').val(reg_no);
  $('#brand').val(brand);
  $('#ajax_model').val(model);
  $('#parking_number').val(parking_number);
  $('#formbutton').text('Update');
  $('#hidden_car_id').val(car_id);
  // $('#hidden_user_id').val(user_id);
}

function is_exist(number)
{
 var reg_no = number;
 var car_id = $('#hidden_car_id').val();
 if(reg_no)
 {
  $.ajax
  ({
    type : "POST",
    url : "<?php echo base_url(); ?>manual/check_reg_no_existence",
    dataType : "json",
    data : {"reg_no" : reg_no,"car_id":car_id},
    success : function(data) 
    {
     if(data==2)
     {
      $('#reg_no').val('');
      alert('Car Already Exist');
    }
  },
  error : function(data)
  {
    alert('Something went wrong');
  }
});
}
}
function hidden_reset()
{
  $('#hidden_car_id').val('');
}


function get_city(val)
 {
  var city_id = val;
  //alert(city_id);

  $.ajax
  ({
    type : "POST",
    url : "<?php echo base_url(); ?>manual/get_locality",
    dataType : "json",
    data : {"city_id" : city_id},
    success : function(data) 
    {
       $("#locality_select").html(data);
       console.log(data);
     },
     error : function(data) {
      alert('Something went wrong');
    }
  });
 }
 function get_street(val)
 {
  var locality_id = val;
  // alert(locality_id);
  $.ajax
  ({
    type : "POST",
    url : "<?php echo base_url(); ?>manual/get_streets",
    dataType : "json",
    data : {"locality_id" : locality_id},
    success : function(data) 
    {
       $("#street_select").html(data);
       console.log(data);
     },
     error : function(data) {
      alert('Something went wrong');
    }
  });

 }
</script>


<script>

function hide_show_div(val)
{
  var type = val;

  if(type=='monthly')
  {
    $('#monthly_type').show();
    $("#frequency").prop('required',true);
    $("#days").prop('required',true);
    $("#no_of_months").prop('required',true);
  }
  else
  {

     $('#monthly_type').hide();
     $("#frequency").prop('required',false);
    $("#days").prop('required',false);
    $("#no_of_months").prop('required',false);
  }
}



// for multiselect
// $('#services').multiselect({
//   nonSelectedText: 'Choose Service',
//   enableFiltering: true,
//   enableCaseInsensitiveFiltering: true,
//   buttonWidth:'570px'
//  });


// $('#frequency').multiselect({
//   nonSelectedText: 'Choose Frequency',
//   enableFiltering: true,
//   enableCaseInsensitiveFiltering: true,
//   buttonWidth:'570px'
//  });

$('#days').multiselect({
  nonSelectedText: 'Choose Days',
  enableFiltering: false,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'570px'
 });



// to check weather the selected days is equal to frequency or not
// function check_frequency(e)
// {
//   alert('clicked');
//  event.preventDefault();
//  var frequency = $('#frequency').val();
//  // if(!frequency)
//  // {
//  //  alert('Please Choose Frequency First');
//  //  event.preventDefault();
//  // }
 

//   var days = $('#days').val();
//   console.log(days);
// }


</script>


<script>
$('#form_btn').click(function(e){

var frequency = $('#frequency').val();
var days = $('#days').val();
  // console.log(days.length);
  if(days.length != frequency)
  {
    alert('Days Frequency Not appropriate');
    event.preventDefault();
  }
});
</script>