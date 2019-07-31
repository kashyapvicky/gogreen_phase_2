
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
<style>
select
{
  width: 100%;
  height: 35px;
  /*font-weight: bold;*/
}
.span_ajax_class
{
 cursor: pointer; 
}

.btn-save
{
  margin:  0 auto!important;
  display: block;
}
.forhover:hover
{
  text-decoration: underline;
  cursor: pointer;
}
</style>

<link href="<?php echo base_url(); ?>/build/css/example-styles.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

<a href="#" onclick="history.go(-1);" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
<div class="right_col" id="cool" role="main">
  <div>
    <div class="title_left">
      <?php  echo $this->session->flashdata('team');
      echo validation_errors();?>
    </div>

    <div class="title_right">

    </div>
  </div>

  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Edit  Teams</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form class="form-horizontal form-label-left" method="post" action="<?php echo base_url()?>teams/update_team?id=<?=$team['id']?>">
            
            <div class="form-group">
              <div class="control-label col-md-3 col-sm-3 col-xs-12">
                <label>Team Name</label>           
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">           
                <input type="text" required class="form-control" value="<?=$team['name'];?>" name="tname" placeholder="Enter Team Name">
              </div>
            </div>
          <?php echo"<font color = 'red'>"; echo form_error('car_type');echo"</font>";?>
          
          <?php echo"<font color = 'red'>"; echo form_error('city');echo"</font>";?>         
          <!--/custom checkbox-->
          <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
               <label>Search Cleaners</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
             <!--  <input autocomplete="off" onkeyup="get_cleaners(this.value)" type="text"  class="form-control"  placeholder="Enter Cleaners Name"> -->
             <select name="cleaners[]" id="cleaners_multiselect" class="form-control" multiple>
              <?php

                foreach ($all_free_cleaner as $key => $value)
                {
                  if(empty($value['status']))
                  {
                    $selected = 'selected';
                  }
                  else
                  {
                    $selected = '';
                  }
                  ?>
                  <option <?= $selected?> value="<?=$value['cleaner_id']?>"><?=$value['first_name'];?></option>
                    <?php
                }


              ?>
             </select>
              <div  class="form-control" id="searched_cleaner"  style="border: 1px solid #00000073; height: 50px; display:none"></div>
            </div>
          </div>
          <!-- </div> -->
         <!--  <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
              <label>Selected Cleaner</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div id="textspan_cleaners" style="min-height:100px; overflow:scroll; border:1px solid #ccc;padding:4px;">
              </div>
            </div>
          </div> -->
          <br>
          <!-- <button class="btn btn-primary btn-md btn-save">Save</button> -->
          <input type="submit" class="btn btn-primary btn-md btn-save" value="Update">
       
      <!-- </div> -->
    <!-- </div> -->
    <div class="col-md-3"></div>   
     </form>
  </div><!--x panel-->
</div>
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
        url : "<?php echo base_url(); ?>teams/get_locality",
        dataType : "json",
        data : {"city_id" : city_id},
        success : function(data) {
         $("#locality_row").append(data.table);
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

 function get_streets(val)
 {
     var alphabets = val;
     var locality_id = $('#locality_row').val();
     //alert(alphabets);
      //console.log(city_id);
      // alert('inside function');
      // var url = "<?php echo base_url(); ?>location/get_city_wise_locality";
      // console.log(url);
      $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>teams/get_street",
        dataType : "json",
        data : {"string" : alphabets,"locality_id" : locality_id},
        success : function(data) {
         $("#searched_item").html(data.streets);
             //alert('hello');
             $('#searched_item').show();
             console.log(data);
           },
           error : function(data) {
            console.log('Something went wrong');
          }
        });

    


 }

</script>

<script>
function add_street(val)
{
  street_id = val;

  $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>teams/get_street_for_textarea",
        dataType : "json",
        data : {"street_id" : street_id},
        success : function(data) {
         $("#textspan_locality").append(data.streets);
             //alert('hello');
             $('#textspan_locality').show();
             console.log(data);
           },
           error : function(data) {
            console.log('Something went wrong');
          }
        });
  
  
}

</script>

<script>
  function removespan(spanid)
  {
    var id = spanid;
    document.getElementById(id).remove();
  }
  function removespan_cleaner(spanid)
  {
    //alert('hello');
    var id = spanid;
    document.getElementById(id).remove();
  }
</script>

<script>

  function get_cleaners(val)
  {
     var  cleaner_string = val;
      var locality_id = $('#locality_row').val();
      // alert(locality_id);
      // alert(cleaner_string);

      $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>teams/get_cleaners",
        dataType : "json",
        data : {"locality_id" : locality_id,"string" : cleaner_string},
        success : function(data) {
         $("#searched_cleaner").html(data.cleaners);
             //alert('hello');
             $('#searched_cleaner').show();
             console.log(data);
           },
           error : function(data) {
            console.log('Something went wrong');
          }
        });
  }


// to add cleaners in textarea 
function add_cleaner(val)
{
  cleaner_id = val;

  $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>teams/get_cleaners_for_textarea",
        dataType : "json",
        data : {"cleaner_id" : cleaner_id},
        success : function(data) {
         $("#textspan_cleaners").append(data.cleaners);
             //alert('hello');
             //$('#textspan_locality').show();
             console.log(data);
           },
           error : function(data) {
            console.log('Something went wrong');
          }
        });
}

function clearstreet_field()
{
  $('#street').val('');
  $('#textspan_locality').html('');
}
</script>
<script>
$('#cleaners_multiselect').multiselect({
  nonSelectedText: 'Select Cleaners',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'500px'
 });


</script>