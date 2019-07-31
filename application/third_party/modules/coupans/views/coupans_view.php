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
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Coupans</h3>
      <?php if($this->session->flashdata('succ'))
      { 
        //echo"alresdy exist";die;
        echo"<div style='margin-left: 150px;'>";
        echo"<font color='green'>".$this->session->flashdata('succ')."</font>";
        echo"</div>";
      }
      echo $this->session->flashdata('coupan_del');
      ?>
    </div>

    <div class="title_right">
      
    </div>
  </div>
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Coupans </h2>
          <a href="<?php echo base_url()?>coupans/add_coupans">
          <button style="float: right; width:10%">Add New Offer</button></a>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Offer Name</th>
                <th>Valid From</th>
                <th>Valid To</th>
                <th>Coupan Code</th>
                <th>Discount %</th>
                <th>Minimum Order</th>
                <th>User Type</th>
                <th>Max Discount</th>
                <th>Operation</th>
              </tr>
            </thead>


            <tbody id="">
              <?php
                 foreach($coupans as $key => $value)
                 {
                  if($value['user_type'] == 1)
                  {
                    $user_type = 'NEW USER';
                  }
                  else
                  {
                    $user_type = 'EXISTING USER';
                  }
                  echo"
                  <tr>
                    <td>".$value['offer_name']."</td>
                    <td>".$value['valid_from']."</td>
                    <td>".$value['valid_upto']."</td>
                    <td>".$value['coupan_code']."</td>
                    <td>".$value['discount']."</td>
                    <td>".$value['minimum_order']."</td>
                    <td>".$user_type."</td>
                    <td>".$value['max_discount']."</td>
                    <td>
                      <a href='".base_url()."coupans/delete_coupans?id=".$value['id']."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o m-right-xs'></i>Delete
                      </a>
                      <a href='".base_url()."coupans/add_coupans?id=".$value['id']."' class='btn btn-info btn-sm'><i class='fa fa-edit m-right-xs'></i>Edit
                      </a>
                    </td>
                  </tr>";
                 }
              ?>
              
              <!-- <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td> <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
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
    



