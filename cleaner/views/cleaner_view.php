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
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Cleaners</h3>
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
          <h2>Cleaners </h2>
          <a href="<?php echo base_url()?>cleaner/add_cleaner">
          <button style="float: right; width:10%">Add New</button></a>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Name</th>
                <th>Phone Number</th>
                <th>City</th>
                <th>Locality</th>
                <th>Operation</th>

              </tr>
            </thead>


            <tbody id="">
              <?php
                 foreach($cleaners as $key => $cleaner)
                 {
                  echo"
                  <tr>
                    <td>".$cleaner['first_name']."</td>
                    <td>".$cleaner['phone_number']."</td>
                    <td>".$cleaner['city']."</td>
                    <td>".$cleaner['locality']."</td>
                    <td> 
                    <a href='".base_url()."cleaner/inactive_cleaner?id=".$cleaner['id']."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o m-right-xs'></i>Delete
                      </a>
                       <a href='".base_url()."cleaner/edit_cleaner?id=".$cleaner['id']."' class='btn btn-info btn-sm'><i class='fa fa-trash-o m-right-xs'></i>Edit
                      </a>
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

