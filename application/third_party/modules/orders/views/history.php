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
          <li ><a href="<?php echo base_url()?>orders/get_customer_detail?id=<?php echo $user_id?>">Customer</a></li>
          <li><a  href="<?php echo base_url()?>orders/package_detail?id=<?php echo $user_id?>">Package Detail</a></li>
          <li><a  href="<?php echo base_url()?>orders/car_detail?id=<?php echo $user_id?>">Car Detail</a></li>
          <li><a  href="<?php echo base_url()?>orders/crew_detail?id=<?php echo $user_id?>">Crew Detail</a></li>
          <li class="active"><a href="<?php echo base_url()?>orders/history?id=<?php echo $user_id?>">History</a></li>
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
                <th>Package</th>
                <th>Team</th>
                <th>Amount Paid</th>
                <th>Status</th>
              </tr>
              </tr>
            </thead>


            <tbody id="">
              <?php
                 foreach($history as $key => $value)
                 {
                 
                  echo"
                  <tr>
                    <td>".$value['orders_id']."</td>
                    <td>".$value['name']."</td>
                    <td>".$value['package_type']."</td>
                    <td>".$value['team_name']."</td>
                    <td>".$value['net_paid']."</td>
                    <td>".$value['status']."</td>
                  </tr>";
                 }
              ?>
              
               <!-- <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td> <td>Edinburgh</td>
                <td>61</td>
              </tr> -->
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
    



