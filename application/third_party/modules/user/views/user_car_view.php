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
.x_title span {
    color: #607D8B;
}
.for_hover:hover
{
  text-decoration: underline;
}
</style>
<style>
#datatable-responsive_paginate{
  display:none !important;

}
</style>
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Car Deatails</h3>
    </div>

    <div class="title_right">
      
    </div>
  </div>
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <div class="row" style="text-align: center;">
            <div class="col-md-3"><span class=" fa fa-user">&nbsp;&nbsp;&nbsp;&nbsp;</span><?php if(!empty($personal_detail))
            {
              //print_r($user_detail); die;
              echo $personal_detail['name'];
            }?></div>
            <div class="col-md-3"><span class=" fa fa-envelope">&nbsp;&nbsp;&nbsp;&nbsp;</span><?php if(!empty($personal_detail))
            {
              echo $personal_detail['email'];
            }?></div>
            <div class="col-md-3" style=""><span class=" fa fa-phone">&nbsp;&nbsp;&nbsp;&nbsp;</span><?php if(!empty($personal_detail))
            {
              echo $personal_detail['phone_number'];
            }?></div>
          </div>
          
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
                <th>Brand</th>
                <th>Model</th>
                <th>Reg No</th>
                <th>Location</th>
                <th>Team</th>
                <th>Package</th>
                <th>Status</th>
              </tr>
            </thead>


            <tbody id="">
               <?php
              if(!empty($user_detail))
              {
             //echo "<pre>"; print_r($user_detail); die;
                   foreach($user_detail as $key => $detail)
                   {
                    //echo "<pre>";print_r($user_detail); die;
                      if($user_detail[$key]['status']==1)
                      {
                        $status = "Active";
                      }
                      else{
                        $status = "Inactive";
                      }
                    //print_r($users); die;
                    echo"
                    <tr>
                     <td>".$user_detail[$key]['brand']."</td>
                     <td>".$user_detail[$key]['model']."</td>
                      <td>".$user_detail[$key]['reg_no']."</td>
                      <td>".$user_detail[$key]['city']."-".$user_detail[$key]['locality']."-".$user_detail[$key]['street']."</td>
                      <td></td>
                      <td><a class='for_hover' href='".base_url()."user/purchase_history?id=".$user_detail[$key]['package_id']."&u_id=".$user_detail[$key]['package_user_id']."'>".$user_detail[$key]['package_type']."</a></td>
                      <td>".$status."</td> 
                    </tr>";
                   }
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
     

