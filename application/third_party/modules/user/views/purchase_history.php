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
      <h3>Purchase History</h3>
    </div>

    <div class="title_right">
      
    </div>
  </div>
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Cars </h2>
          <!-- <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Settings 1</a>
                </li>
                <li><a href="#">Settings 2</a>
                </li>
              </ul>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul> -->
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Purchase Date</th>
                <th>Date Of Expiry</th>
                <th>Packege</th>
                <th>Services</th>
                <th>Days</th>
                <th>Amount</th>
                <th>Coupan Applied</th>
                <th>Net Paid</th>
              </tr>
            </thead>


            <tbody id="">
               <?php
              if(!empty($purchase_history))
              {
                  
                    
                    if($purchase_history['services']==1)
                    {
                      $res = "Interior";
                    }
                    elseif($purchase_history['services']==2)
                    {
                      $res = "Exterior";
                    }
                    else{
                      $res = "Interior|Exterior";
                    }
                    //print_r($purchase_history); die;
                    echo"
                    <tr>
                     <td>".$purchase_history['purchase_date']."</td>
                     <td>".$purchase_history['expiry_date']."</td>
                      <td>".$purchase_history['package_type']."</td>
                      <td>".$res."</td>
                      <td>".$purchase_history['days']."</td>
                      <td>".$purchase_history['amount']."</td>
                      <td>".$purchase_history['coupan_applied']."</td>
                      <td>".$purchase_history['net_paid']."</td> 
                    </tr>";
              } 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>





  <div class="row">
   
    

  </div>
</div>
     

