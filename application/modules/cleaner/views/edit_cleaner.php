
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
<a href="#" onclick="history.go(-1);" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
<div class="right_col" id="cool" role="main">
  <div class="page-title">
    <div class="title_left">
    </div>
    <div class="title_right">
    </div>
  </div>

  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
       <div class="x_title">
        <h2>Edit Clener </h2>
        <?php if($this->session->flashdata('phone_exist'))
          { 
            //echo"alresdy exist";die;
            echo"<div style='margin-left: 150px;'>";
            echo"<font color='red'>Email Already Exist</font>";
            echo"</div>";
          }
          ?>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form method="post" action="<?php echo base_url()?>cleaner/edit_cleaner?id=<?php echo $cleaner['id'];?>" id="" data-parsley-validate class="form-horizontal form-label-left">
          <?php //print_r($cleaner); die;?>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">First Name <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" value="<?php echo $cleaner['first_name']?>" id="first_name" name="first_name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" value="<?php echo $cleaner['last_name']?>" id="last-name" name="last_name" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Phone Number</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  required id="middle-name" value="<?php echo $cleaner['phone_number']?>" class="form-control col-md-7 col-xs-12" type="number" name="phone_number">
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select City <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
             
              <select name="city" onchange="get_city(this.value)"  class="form-control">
                 <?php if($cleaner['cleaner_status']==2)// cleaner is not free or assiagned in another team
              {?>
                <option value="<?php echo $cleaner['city_id']?>"  selected><?php echo $cleaner['city']?></option>
              <?php }
              else
              {
                   // print_r($cities); die;


                foreach ($cities as $key => $value)
                    {

                      if($value['id']==$cleaner['city_id'])
                      {
                      
                        $selected = 'selected';
                        
                      }
                      else{

                        $selected='';
                      }

                      echo"<option ".$selected." value='".$value['id']."'>".$value['name']."</option>";
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
              <select  name="locality" id='locality_select'  class="form-control">
                <option value="<?php echo $cleaner['locality_id']?>"  selected><?php echo $cleaner['locality']?></option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="email" id="first-name" value="
              <?php echo $cleaner['email']?>" name="email" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Password <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="password" id="" name="password" value="<?php echo $cleaner['password']?>" required="required" class="form-control col-md-7 col-xs-12">
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
  // alert(city_id);

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