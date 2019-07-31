<?php

/* * ***********************
 * PAGE: TO Listing The User.
 * #COPYRIGHT: Ripenapps
 * @AUTHOR: vicky kashyap
 * CREATOR: 04/06/2018.
 * UPDATED: --/--/----.
 * codeigniter framework
 * *** */
?>
<style>
select
{
    width: 50%;
    height: 25px;
}
</style>
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Orders</h3>

        <ul class="nav nav-tabs">
          <?php 
          if($this->input->get('cashtab'))
          {
            $class ='active';
            $online_class='none';
          }
          else
          {
            $online_class = 'active';
            $class='none';
          }

          ?>
          <li class="<?php echo $online_class?>"><a href="<?php echo base_url()?>orders">Online</a></li>
          <li class="<?php echo $class?>"><a href="<?php echo base_url()?>orders/index?cashtab=1">Cash</a></li>
          <li><a href="<?php echo base_url()?>orders/pending">Pending</a></li>
        </ul>
      
    </div>

    <div class="title_right">
      
    </div>
  </div>
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <div class="row">
            <div class="col-md-3">

             <!-- <select onchange="get_locality_for_street(this.value)" class="select"><option value="" disabled selected>Select City</option>
              <?php if(!empty($city)){foreach ($city as $key => $value) {

                echo"<option value=".$value['id'].">".ucfirst($value['name'])."</option>";}}?>
              </select>
            </div>
            <div class="col-md-3">
              <select class="select" id="locality_ajax"><option>Choose City First</option>
              </select>
            </div>
            <div class="col-md-3">
              <select>
                <option>Street</option>


              </select>
            </div>
            <div class="col-md-3">
             <select>
              <option>Team</option>
            </select>
 -->
          </div>
        </div> 
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Team</th>
                <th>Amount Paid</th>
                <th>Customer Number</th>
                <th>Team Assign</th>
              </tr>
              </tr>
            </thead>


            <tbody id="">
              <?php
              //echo"hello";die;
                 foreach($orders as $key => $value)
                 {
                    // print_r($orders); die;
                  echo"
                  <tr>
                    <td>".$value['orders_id']."</td>
                    <td><a href=".base_url()."orders/get_customer_detail?id=".$value['user_id'].">".$value['username']."</a></td>
                    <td>".$value['team_name']."</td>
                    <td>".$value['net_paid']."</td>
                    <td>".$value['phone_number']."</td>
                    <td><button href='' onclick='open_modal(".$value['primary_id'].")' class='btn btn-info'>Assign Team</button></td>
                  </tr>";
                 }
              ?>
              
              
             <!-- <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                 <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
                 <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Cedric Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>22</td>
                 <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Airi Satou</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>33</td>
              </tr>
              <tr>
                <td>Brielle Williamson</td>
                <td>Integration Specialist</td>
                <td>New York</td>
                <td>61</td>
                 <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Michael Bruce</td>
                <td>Javascript Developer</td>
                <td>Singapore</td>
                <td>29</td>
                 <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
                 <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
                 <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
                 <td>Edinburgh</td>
                <td>61</td>
              </tr> -->

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


 


  <div class="row">
   
    

  </div>
</div>
    

<!-- modal for manuall team change -->
<div style="" class="modal fade" id="team_modal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4  class="modal-title">Assiagn Team</h4>
          </div>
          <div class="modal-body" style="">
           <form method="post" action="<?php base_url();?>orders/change_team">
            <label>Team Name</label>
            <!-- <input required type="text" class="form-control" id="city_ajax_name" name="city" placeholder="City Name"> -->
            <select class="form-control" required id="modal_team_name" name="team_id">
            

            </select>
            <span id="modal_span" style="color: red"></span>
            <input type="hidden" name="payment_key" id="payment_key">
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default" value="Update">
            <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </form>
          </div>
      </div>
    </div>
  </div>

  <!--/ moodal for manual team change -->
<script>

function open_modal(id)
{
  var primary_id = id;
   $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>orders/get_teams_working_on_this_order",
        dataType : "json",
        data : {"primary_id" : primary_id},
        success : function(data)
        {

          if(data==5)
          {
            $('#modal_span').html('No team to assiagn');
          }
          $('#modal_team_name').html(data);
          $('#team_modal').modal('show');
          $('#payment_key').val(primary_id);
         // $("#locality_ajax_table").html(data.dropdown);
             //alert('hello');
             console.log(data);
           },
           error : function(data) {
            alert('Something went wrong');
          }
        });
}

</script>