
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
<!--  <link href="<?php echo base_url_custom; ?>build/css/selectstyle.css" rel="stylesheet"> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<div class="right_col" id="cool" role="main">


  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
       <div class="x_title">
        <h2> Search  User </h2>
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
        <form method="post" action="<?php echo base_url()?>manual/add_user" id="user_form" data-parsley-validate class="form-horizontal form-label-left">
          <input type="hidden" name="hidden_user_id" id="hidden_user_id">
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Search User
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="city" theme="google" onchange="get_user_info(this)" placeholder="Select Your Favorite" id="users" data-search="true"  class="form-control">
                <option value="" disabled selected>Select User</option>
                <?php
                  if(!empty($users))
                  {
                    foreach ($users as $key => $value) 
                    {
                      echo"<option class='".$value['phone_number']."_".$value['email']."' value='".$value['id']."'>".$value['name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$value['email']."";
                    }
                  }
                ?>
              </select>
            </div>
          </div>
               <!--  <h3 style="text-align: center;">OR</h3> -->

          <div id="users_details_fields" style="display: none;"> 
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_number-name">Phone Number <!-- <span class="required">*</span> -->
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input  placeholder="Phone Number" type="text" onchange="is_phone_exist(this.value)" required id="phone_number" name="phone_number" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input placeholder="email" onblur="is_email_exist(this.value)"  required id="email" class="form-control col-md-7 col-xs-12" type="email" name="email">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <!-- <span class="required">*</span> -->
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="name" name="name" required="required" placeholder="User Name" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <div class="row">
                  <div class="col-md-4"></div>
                  <div class="col-md-2">
                    <button type="submit" id="form_button" class="btn btn-success">Next</button>
                  </div>
                   <div class="col-md-2">
                    <button type="reset" onClick="window.location.reload()" class="btn btn-danger">Clear</button>
                  </div>
                  <div class="col-md-4"></div>
                </div>
              </div>
            </div>
          </div><!-- div containing selected users detail in hidden -->
        </form>  
      </div>
    </div><!--x panel-->
  </div>
</div>
</div>
 <!-- <script src="<?php echo base_url_custom; ?>build/js/selectstyle.js"></script> -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
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
 // to get user info from dropdown
function get_user_info(element)
{
  // var user_id = id;
  // alert(user_id); 
  var select_element = element;
  var user_name = select_element.options[select_element.selectedIndex].text;
  var user_id = select_element.options[select_element.selectedIndex].value;
  var phone_email = select_element.options[select_element.selectedIndex].getAttribute("class");

  var myarr = phone_email.split("_");
  var phone_number = myarr[0];
  var email = myarr[1];
  // alert(phone_number);
  // alert(email);

  $('#hidden_user_id').val(user_id);

  $('#name').val(user_name);
  $("#name").prop("disabled", true);

  $('#phone_number').val(phone_number);
  $("#phone_number").prop("disabled", true);

  $('#email').val(email);
  $("#email").prop("disabled", true);

  //show div containing users details
  $('#users_details_fields').show();
  
}

function  is_phone_exist(number)
{
  var phone_number = number;

  if (phone_number) 
  {

       $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>manual/check_phone_existence",
        dataType : "json",
        data : {"phone_number" : phone_number},
        success : function(data) 
        {
           if(data==2)
           {
              $('#phone_number').val('');
              alert('Phone Number Already Exist');
           }
         },
         error : function(data) {
          alert('Something went wrong');
        }
      });
    }
  }


function  is_email_exist(number)
{
  var email = number;

  if(email)
  {

     $.ajax
    ({
      type : "POST",
      url : "<?php echo base_url(); ?>manual/check_email_existence",
      dataType : "json",
      data : {"email" : email},
      success : function(data) 
      {
         if(data==2)
         {
            $('#email').val('');
            alert('Email Already Exist');
         }
       },
      error : function(data)
      {
      alert('Something went wrong');
      }
    });
  }
}

$("#users").select2();
//$('#users').selectstyle();

//select2();
// function select2(){
//   alert('sss');
// }
</script>



