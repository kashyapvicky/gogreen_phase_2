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
        <li><a  href="<?php echo base_url()?>orders/package_detail?id=<?php echo $user_id?>">Package Detail</a></li>
        <li><a  href="<?php echo base_url()?>orders/car_detail?id=<?php echo $user_id?>">Car Detail</a></li>
        <li class="active"><a  href="">Crew Detail</a></li>
       <!--  <li><a href="<?php echo base_url()?>orders/history?id=<?php echo $user_id?>">History</a></li> -->
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
           <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <tr>
                  <th>Cleaner Name</th>
                  <th>Phone Number</th>
                  <!-- <th>Car Model</th>
                  <th>Car Color</th>
                  <th>Registration Number</th>
                  <th>Parking Number</th> -->
                </tr>
              </tr>
            </thead>


            <tbody id="">
              <?php
                //echo"<pre>";print_r($crew); die;
             foreach($crew as $key => $value)
                {
                  echo"
                  <tr>
                  <td>".$value['name']."</td>
                  <td>".$value['phone_number']."</td>
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




