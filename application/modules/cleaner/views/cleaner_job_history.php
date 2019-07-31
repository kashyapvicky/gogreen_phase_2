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
#datatable-responsive_paginate{
  display:none !important;

}
</style>
<a href="#" onclick="history.go(-1);" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <?php echo $this->session->flashdata('cleaner_delleted');?>
      <?php if($this->session->flashdata('cleaner_added'))
      { 
        //echo"alresdy exist";die;
        echo"<div style='margin-left: 150px;'>";
        echo"<font color='green'>Cleaner Added Succesfully</font>";
        echo"</div>";
      }
      ?>
    </div>

    <div class="title_right">
      
    </div>
  </div>
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Cleaners History</h2>
          <a href="<?php echo base_url()?>cleaner/add_cleaner">
          <button style="float: right; width:10%">Add New</button></a>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Order Id</th>
                <th>Date</th>
                <th>Locality</th>
                <th>Street</th>
                <th>Report</th>
                <th>Reason</th>
                <th>Feedback</th>

              </tr>
            </thead>


            <tbody id="">
              <?php
                 foreach($history as $key => $cleaner)
                 {
                  // print_r($history);die;
                  if($cleaner['attendent']==1)
                  {
                    $flag='Attendent';
                  }
                  else
                  {
                    $flag='Not Attendent';
                  }
                  echo"
                  <tr>
                    <td>".$cleaner['orders_id']."</td>
                    <td>".$cleaner['job_done_date']."</td>
                    <td>".$cleaner['locality']."</td>
                    <td>".$cleaner['street']."</td>
                    <td>".$flag."</td>
                    <td>".$cleaner['reason']."</td>
                    <td>".$cleaner['feedback']."</td>
                  </tr>";
                 }
              ?>
              
             <!--  <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
              </tr>
              <tr>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
              </tr>
              <tr>
                <td>Cedric Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>22</td>
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
              </tr>
              <tr>
                <td>Michael Bruce</td>
                <td>Javascript Developer</td>
                <td>Singapore</td>
                <td>29</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
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
    


<script>

     $(document).ready(function(){
     
  //   fetch_data('no');
//function fetch_data(change_location,location_id =''){
   
    ///----------------on load get da list start
     $('#datatable-responsive').dataTable( { 
             "columns": [
                {"data": "id"},
    {"data": "first_name"},       
                {"data": "name"},
            ],
            columnDefs: [
               { orderable: false, targets: [-1,2,3,5] },
             
            ], 
           // "processing": true,
            "serverSide": true,
            "ajax": {
                url: '<?php echo base_url(); ?>ajax_pagination/pagination',
                type: 'POST',
                 "data": {
                   
                }
 //           }
    } );
  ///----------------on load get da list end
 }
 

    } );
   
</script>   

