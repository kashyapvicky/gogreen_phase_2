
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>

 <!-- <link href="<?php echo base_url(); ?>/build/css/datepicker.css" rel="stylesheet">
 <script src="<?php echo base_url(); ?>/build/js/datepicker.js"></script> -->
<style>
.custom .form-control {
  border: none;
  box-shadow: none;
  height: 21px;
}

.custom_label
{
  margin-left: -70px;
  margin-top: 5px;
}
</style>
<div class="right_col" id="cool" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Add Coupan</h3>
    </div>

    <div class="title_right">

    </div>
  </div>

  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
       <div class="x_title">
        <h2>Coupan</h2>
        <?php
         if($this->session->flashdata('image_error'))
        { 
            //echo"alresdy exist";die;
          echo"<div style='margin-left: 150px;'>";
          echo  $this->session->flashdata('image_error')['error'];
          echo"</div>";
        }

        if($this->session->flashdata('Failure'))
        { 
            //echo"alresdy exist";die;
          echo"<div style='margin-left: 150px;'>";
          echo  $this->session->flashdata('Failure');
          echo"</div>";
        }
        if($this->session->flashdata('choose_file'))
        { 
            //echo"alresdy exist";die;
          echo"<div style='margin-left: 150px;'>";
          echo  $this->session->flashdata('choose_file');
          echo"</div>";
        }
        ?>
        <?php
          echo"<div style='margin-left: 150px;'>";
          echo"<font color='red'>";
          echo validation_errors();
          echo"</font>";
          echo"</div>";
          

        ?>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>coupans/add_coupans?id=<?php echo $coupan['id'];?>" id="" data-parsley-validate class="form-horizontal form-label-left"> 
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Coupan Image <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <input type="file" onchange="previewFile()" class="filestyle" data-input="false" data-buttonText="Choose Banner Image"  name="coupan_image">
            </div>
            <div id="imgdiv" class="col-md-3 col-sm-6 col-xs-12" style="display: none">
             <img id="myimg" src="" height="50" alt="Image preview...">
           </div>
         </div>
         <?php // print_r($coupan); die;?>
         <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Offer Name <!-- <span class="required">*</span> -->
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text"  name="offer_name" value="<?php echo  $coupan['offer_name']?>" class="form-control col-md-7 col-xs-12">
          </div>
        </div>
        <div class="form-group">
          <label for="middle-name" value="<?php echo  $coupan['valid_from']?>" class="control-label col-md-3 col-sm-3 col-xs-12">Valid From</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <!-- <input id="valid_from"  required  class="form-control col-md-7 col-xs-12 docs-date" type="text" name="valid_from" data-toggle="datepicker"> -->
            <input type="text" class="form-control has-feedback-left" id="single_cal2" placeholder="First Name" aria-describedby="inputSuccess2Status2" name="valid_from">
            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            <span id="inputSuccess2Status2" class="sr-only">(success)</span>
          </div>
        </div>

        <div class="form-group">
          <label for="middle-name" value="<?php echo  $coupan['valid_upto']?>" class="control-label col-md-3 col-sm-3 col-xs-12">Valid Upto</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="valid_upto"  class="form-control has-feedback-left" id="custom_calender" placeholder="First Name" aria-describedby="inputSuccess2Status2">
            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>

          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Coupan Code <!-- <span class="required">*</span> -->
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" id="code" disabled  name="coupan_code" value="<?php echo  $coupan['coupan_code']?>" required class="form-control col-md-7 col-xs-12">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Discount % <!-- <span class="required">*</span> -->
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="number" name="discount" id="perc" onkeyup="percentage(this.value)" value="<?php echo  $coupan['discount']?>" required="required" class="form-control col-md-7 col-xs-12">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Minimum Order <!-- <span class="required">*</span> -->
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="number" name="minimum_order" value="<?php echo  $coupan['minimum_order']?>" required="required" class="form-control col-md-7 col-xs-12">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Max Discount <!-- <span class="required">*</span> -->
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="number" name="max_discount" value="<?php echo  $coupan['max_discount']?>" required="required" class="form-control col-md-7 col-xs-12">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">User Type <!-- <span class="required">*</span> -->
          </label>
          <div class="col-md-2 col-sm-3 col-xs-6 custom">
            <input type="radio" name="user_type" value="2" <?php echo ($coupan['user_type']== 2) ?  "checked" : "" ;  ?> selected required="required" class="form-control custom_radio" selected="true">
          </div>
          <div class="col-md-1 col-sm-3 col-xs-6 custom_label">
            <label>Existing</label>
          </div>
          <div class="col-md-2 col-sm-3 col-xs-6 custom">
            <input type="radio" name="user_type" required="required" value="1" <?php echo ($coupan['user_type']== 1) ?  "checked" : "" ;  ?>  class="form-control">
          </div>
          <div class="col-md-2 col-sm-3 col-xs-6 custom_label">
            <label>New User</label>
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
<script>

//   function test() {
//     alert('call');
//     var newSrc = 'http://example.com/johnson.gif';
// $('#myimg').attr('src', newSrc);
//   }
function previewFile() {

  //var preview = document.querySelector('img');
  var file    = document.querySelector('input[type=file]').files[0];
  var reader  = new FileReader();

  reader.addEventListener("load", function () {

    //preview.src =reader.result;
    var imgstring = reader.result;
    //console.log(imgstring);
    $('#myimg').attr('src', imgstring);
    $('#imgdiv').show();
  }, false);

  if (file) {
    reader.readAsDataURL(file);
  }
}
</script>
<script>
 function check_code()
 {
    var code = $("#code").val();
    // var url = "<?php echo base_url(); ?>coupans/check_coupan_exis";
    // console.log(url);
    //alert(code);
    $.ajax
    ({
        type : "POST",
        url : "<?php echo base_url(); ?>coupans/check_coupan_exis",
        dataType : "json",
        data : {"coupan_code" : code},
        success : function(data)
        {
         console.log(data);
         alert('Coupan Already Exist');
         $("#code").val('');
        },
    });
  } 
</script>

<script>
function percentage(val)
{ 
  var percentage = parseInt(val);
  if(percentage >100)
  {
    alert('Invalid percentage amount');
    $('#perc').val('');
  }

}

  </script>