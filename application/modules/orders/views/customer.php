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
          <li class="active"><a href="#"">Customer</a></li>
          <li><a href="<?php echo base_url()?>orders/package_detail?id=<?php echo $customer_detail['id'];?>">Package Detail</a></li>
          <li><a href="<?php echo base_url()?>orders/car_detail?id=<?php echo $customer_detail['id'];?>">Car Detail</a></li>
          <li><a href="<?php echo base_url()?>orders/crew_detail?id=<?php echo $customer_detail['id'];?>">Crew Detail</a></li>
         <!--  <li><a href="<?php echo base_url()?>orders/history?id=<?php echo $customer_detail['id'];?>">History</a></li> -->
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
          
          <div class="table-responsive">
                            <table class="table">
                              <?php
                                 // print_r($customer_detail); die;

                              ?>
                              <tbody>
                                <tr>
                                  <th style="width:50%">Customer Name:</th>
                                  <td><?php echo $customer_detail['name'];?></td>
                                </tr>
                                <tr>
                                  <th>Phone Number</th>
                                  <td><?php echo $customer_detail['phone_number'];?></td>
                                </tr>
                                <tr>
                                  <th>Email:</th>
                                  <td><?php echo $customer_detail['email'];?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
        </div>
      </div>
    </div>
  </div>


 


  <div class="row">
   
    

  </div>
</div>
    



