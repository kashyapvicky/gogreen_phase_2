
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
<div class="right_col" id="cool" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Add Clener</h3>
    </div>

    <div class="title_right">

    </div>
  </div>

  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
       <div class="x_title">
        <h2>Cleaner </h2>
        <?php if($this->session->flashdata('phone_exist'))
          { 
            //echo"alresdy exist";die;
            echo"<div style='margin-left: 150px;'>";
            echo"<font color='red'>Phone Number Already Exist</font>";
            echo"</div>";
          }
          ?>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form method="post" action="<?php echo base_url()?>cleaner/insert_cleaner" id="" data-parsley-validate class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">First Name <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="first_name" name="first_name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="last-name" name="last_name" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Phone Number</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  required id="middle-name" class="form-control col-md-7 col-xs-12" type="number" name="phone_number">
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select City <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="city" onchange="get_city(this.value)" required class="form-control">
                <option value="" disabled selected>Select City</option>
                <?php
                  if(!empty($cities))
                  {
                    foreach ($cities as $key => $value) {
                      echo"<option value='".$value['id']."'>".$value['name']."</option>";
                    }
                  }

                ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Locality <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select  name="locality" id='locality_select' required class="form-control">
                <option value="" disabled selected>Choose City First</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="email" id="first-name" name="email" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Password <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="password" id="" name="password" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>  
      </div>
    </div><!--x panel-->
  </div>
</div>
</div>
<script>

 function get_city(val)
 {
  var city_id = val;
  //alert(city_id);

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

</script>