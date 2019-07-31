
<?php
// print_r($team_id);die;
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
<style>
div#showbox {
    width: 100%;
    position: relative;
}

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

#checkboxes label {
  margin-left:8px;
  display: block;
}


#checkboxes label:hover {
  background-color: #1e90ff;
}

</style>
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

  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Edit  Teams Location</h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <form class="form-horizontal form-label-left" method="post" action="<?php echo base_url()?>teams/update_team_location?id=<?=$location_array['team_id']?>">
            <input type="hidden" value="<?php echo $location_array['team_id']?>" id="team_id_hidden">
          <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
              <label>Select City</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select required name="city" onchange="get_city_wise_locality(this.value)">
                  <option >Select City</option>
                  <?php 
                    if(!empty($city))
                    {
                      foreach ($city as $key => $value)
                      {
                        if($location_array['city'] == $value['name'])
                        {
                          $selected='selected';
                        }
                        else
                        {
                          $selected='';
                        }
                        echo"<option ".$selected." value = '".$value['id']."'>".$value['name']."</option>";
                      }
                    }
                  ?>
                </select>
            </div>
          </div>
          <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
              <label>Select Locality</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="locality" onchange="get_streets_by_locality_id(this.value)" id="locality_row" required>
                  <!-- <option value="" disabled selected>Select locality</option> -->
                   <?php 
                    if(!empty($localities))
                    {
                      foreach ($localities as $key => $value)
                      {
                        if($location_array['locality'] == $value['name'])
                        {
                          $selected='selected';
                        }
                        else
                        {
                          $selected='';
                        }
                        echo"<option ".$selected." value = '".$value['id']."'>".$value['name']."</option>";
                      }
                    }
                  ?>
                </select>
            </div>
          </div>


          <!-- custom streets dropdown -->

          <div class="form-group">
            <div class="control-label col-md-3 col-sm-3 col-xs-12">
              <label>Select Streets</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div  required class="selectBox" id="showbox"> 
                <select>
                  <option >Select Streets</option>
                </select>
                <div class="overSelect"></div>
              </div>
              <div id="checkboxes" class="collect_id">
                <?php
                  if(!empty($streets))
                {
                  foreach ($streets as $key => $value)
                  { 
                    
                    ?>
                      <label for="one">
                        <input value="<?php echo  $value['id']?>" name="streets_checkbox[]" <?=in_array($value['name'],$location_array['streets']) ? 'checked' : ''?> type="checkbox" id=""><?=$value['name']?></label>
                    <?php
                  }
                }
                ?>
              </div>
            </div>
          </div>
          <!-- /custom streets dropdown -->





        
          <br>
          <input type="submit" class="btn btn-primary btn-md btn-save" value="Update">
          <div class="col-md-3"></div>   
          </form>
        </div><!--x panel-->
      </div>
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
         $("#locality_row").html(data.table);
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

 function get_streets_by_locality_id(val)
 {
     // var alphabets = val;
     var locality_id = val;
     var team_id = $('#team_id_hidden').val();
     //alert(alphabets);
      //console.log(city_id);
      // alert('inside function');
      // var url = "<?php echo base_url(); ?>location/get_city_wise_locality";
      // console.log(url);
      $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>teams/get_street_for_dropdown",
        dataType : "json",
        data : {"locality_id" : locality_id,"team_id":team_id},
        success : function(data) {
         $("#checkboxes").html(data);
             //alert('hello');
            // $('#searched_item').show();
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
  // function removespan(spanid)
  // {
  //   var id = spanid;
  //   document.getElementById(id).remove();
  // }
  // function removespan_cleaner(spanid)
  // {
  //   //alert('hello');
  //   var id = spanid;
  //   document.getElementById(id).remove();
  // }
</script>

<script>

  // function get_cleaners(val)
  // {
  //    var  cleaner_string = val;
  //     var locality_id = $('#locality_row').val();
  //     // alert(locality_id);
  //     // alert(cleaner_string);

  //     $.ajax
  //     ({
  //       type : "POST",
  //       url : "<?php echo base_url(); ?>teams/get_cleaners",
  //       dataType : "json",
  //       data : {"locality_id" : locality_id,"string" : cleaner_string},
  //       success : function(data) {
  //        $("#searched_cleaner").html(data.cleaners);
  //            //alert('hello');
  //            $('#searched_cleaner').show();
  //            console.log(data);
  //          },
  //          error : function(data) {
  //           console.log('Something went wrong');
  //         }
  //       });
  // }


// to add cleaners in textarea 
// function add_cleaner(val)
// {
//   cleaner_id = val;

//   $.ajax
//       ({
//         type : "POST",
//         url : "<?php echo base_url(); ?>teams/get_cleaners_for_textarea",
//         dataType : "json",
//         data : {"cleaner_id" : cleaner_id},
//         success : function(data) {
//          $("#textspan_cleaners").append(data.cleaners);
//              //alert('hello');
//              //$('#textspan_locality').show();
//              console.log(data);
//            },
//            error : function(data) {
//             console.log('Something went wrong');
//           }
//         });
// }

// function clearstreet_field()
// {
//   $('#street').val('');
//   $('#textspan_locality').html('');
// }
</script>
<script>
// $('#cleaners_multiselect').multiselect({
//   nonSelectedText: 'Select Streets',
//   enableFiltering: true,
//   enableCaseInsensitiveFiltering: true,
//   buttonWidth:'500px'
//  });


</script>
<script type="text/javascript">
  var expanded = false;
  $('#showbox').click( function (){
    //alert("df");
    var checkboxes = document.getElementById("checkboxes");
    if (!expanded) {
      checkboxes.style.display = "block";
      expanded = true;
    } else {
      checkboxes.style.display = "none";
      expanded = false;
    }
  });
 
  // function showCheckboxes() {
  //   // alert('hello');
  //   // return false;
  //   var checkboxes = document.getElementById("checkboxes");
  //   if (!expanded) {
  //     checkboxes.style.display = "block";
  //     expanded = true;
  //   } else {
  //     checkboxes.style.display = "none";
  //     expanded = false;
  //   }
  // }
</script>