
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
<div class="right_col" id="cool" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Add Teams</h3>
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
          <h2>Add New Teams</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form class="form-horizontal form-label-left" method="post" action="<?php echo base_url()?>teams/insert_team">
            <div class="form-group">
              <div class="control-label col-md-3 col-sm-3 col-xs-12">
                <label>Team Name</label>           
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">           
                <input type="text" required class="form-control" name="tname" placeholder="Enter Team Name">
              </div>
            </div>
          <?php echo"<font color = 'red'>"; echo form_error('car_type');echo"</font>";?>
          <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
              <label>Select City</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select required name="city" onchange="get_city_wise_locality(this.value)">
                  <option disabled selected required>Select City</option>
                  <?php 
                    if(!empty($city))
                    {
                      foreach ($city as $key => $value)
                      {  
                        echo"<option value = '".$value['id']."'>".$value['name']."</option>";
                      }
                    }
                  ?>
                </select>
            </div>
          </div>
          <?php echo"<font color = 'red'>"; echo form_error('city');echo"</font>";?>
          <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
              <label>Select Locality</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="locality" onchange="clearstreet_field()" id="locality_row" required>
                  <option value="" disabled selected>Select locality</option>
                </select>
            </div>
          </div>


          <div class="form-group">
              <div class="control-label col-md-3 col-sm-3 col-xs-12">
               <label>Search Tower/Street</label>
             </div>
             <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" onkeyup="get_streets(this.value)" id="street"  class="form-control" placeholder="Enter Street Name" autocomplete="off">
              <div  class="form-control" id="searched_item" name="search_street" style="border: 1px solid #00000073; height: 50px; display:none"></div>
            </div>
          </div>

          <!--/custom checkbox-->
          <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
              <label>Selected Streets</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div id="textspan_locality" style="min-height:100px; overflow:scroll; border:1px solid #ccc;padding:4px;">
                

              </div>
            </div>
          </div>


          <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
               <label>Serach Cleaners</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input autocomplete="off" onkeyup="get_cleaners(this.value)" type="text"  class="form-control"  placeholder="Enter Cleaners Name">
              <div  class="form-control" id="searched_cleaner"  style="border: 1px solid #00000073; height: 50px; display:none"></div>
            </div>
          </div>
          <!-- </div> -->
          <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
              <label>Selected Cleaner</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div id="textspan_cleaners" style="min-height:100px; overflow:scroll; border:1px solid #ccc;padding:4px;">
              </div>
            </div>
          </div>
          <br>
          <!-- <button class="btn btn-primary btn-md btn-save">Save</button> -->
          <input type="submit" class="btn btn-primary btn-md btn-save" value="Save">
       
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
function get_verified_streets(val)
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
    var street_input_id = 'hidden_'+id;
    // alert(street_input_id);
    $('#'+street_input_id).remove();
    document.getElementById(id).remove();
  }
  function removespan_cleaner(spanid)
  {
    //alert('hello');
    var id = spanid;
    var cleaner_input_id = 'hidden_'+id;
    document.getElementById(id).remove();
     $('#'+cleaner_input_id).remove();
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
function get_verified_cleaners(val)
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
function add_street(id)
{
  var id=id;
  var values = $("input[name='streets_ids[]']")
              .map(function()
              {
                return $(this).val();
              }).get();

    console.log(values);
    if(jQuery.inArray(id, values)== -1)
    {
      get_verified_streets(id);

    }

}

function add_cleaner(id)
{
  var id=id;
  var values = $("input[name='cleaners_ids[]']")
              .map(function()
              {
                return $(this).val();
              }).get();

    console.log(values);
    if(jQuery.inArray(id, values)== -1)
    {
      get_verified_cleaners(id);

    }

}
</script>