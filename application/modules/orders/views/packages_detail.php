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
      <h3>Car Details</h3>
        <ul class="nav nav-tabs">
          <li ><a href="<?php echo base_url()?>orders/get_customer_detail?id=<?php echo $user_id?>">Customer</a></li>
          <li class="active"><a  href="#">Package Detail</a></li>
          <li><a href="<?php echo base_url()?>orders/car_detail?id=<?php echo $user_id;?>">Car Detail</a></li>
          <li><a href="<?php echo base_url()?>orders/crew_detail?id=<?php echo $user_id;?>">Crew Detail</a></li>
          <!-- <li><a href="<?php echo base_url()?>orders/history?id=<?php echo $user_id;?>">History</a></li> -->
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
                <th>Package Type</th>
                <th>City</th>
                <th>Locality</th>
                <th>Street</th>
                <th>Days</th>
                <th>Price</th>
                <th>Amount Paid</th>
                <th>Purchase Date</th>
                <th>Expiry Date</th>
              </tr>
              </tr>
            </thead>


            <tbody id="">
              <?php
              //echo"<pre>";print_r($packages); die;
                 foreach($packages as $key => $value)
                 {
                  echo"
                  <tr>
                    <td>".$value['package_type']."</td>
                    <td>".$value['city']."</td>
                    <td>".$value['locality']."</td>
                    <td>".$value['street']."</td>
                    <td>".$value['days']."</td>
                    <td>".$value['amount']."</td>
                    <td>".$value['amount']."</td>
                    <td>".$value['purchase_date']."</td>
                    <td>".$value['expiry_date']."</td>
                  </tr>";
                 }
              ?>
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
    



