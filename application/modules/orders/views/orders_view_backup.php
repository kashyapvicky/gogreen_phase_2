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
      <h3>Orders</h3>
       
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab1" class="nav nav-tabs bar_tabs right" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content11" id="home-tabb" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Pending</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content22" role="tab" id="profile-tabb" data-toggle="tab" aria-controls="profile" aria-expanded="false">Expired</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content33" role="tab" id="profile-tabb3" data-toggle="tab" aria-controls="profile" aria-expanded="false">Cash</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content33" role="tab" id="profile-tabb3" data-toggle="tab" aria-controls="profile" aria-expanded="false">Online</a>
                        </li>
                      </ul>
                      <!-- <div id="myTabContent2" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">
                          <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher
                            synth. Cosby sweater eu banh mi, qui irure terr.</p>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="profile-tab">
                          <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                            booth letterpress, commodo enim craft beer mlkshk aliquip</p>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content33" aria-labelledby="profile-tab">
                          <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                            booth letterpress, commodo enim craft beer mlkshk </p>
                        </div>
                      </div> -->
                    </div>

      <?php
      //  if($this->session->flashdata('succ'))
      // { 
      //   //echo"alresdy exist";die;
      //   echo"<div style='margin-left: 150px;'>";
      //   echo"<font color='green'>".$this->session->flashdata('succ')."</font>";
      //   echo"</div>";
      // }
      // echo $this->session->flashdata('coupan_del');
      ?>
    </div>

    <div class="title_right">
      
    </div>
  </div>
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
         <!--  <div class="row">
            <div class="col-md-3">

             <select onchange="get_locality_for_street(this.value)" class="select"><option value="" disabled selected>Select City</option>
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
                <option>Tower</option>


              </select>
            </div>
            <div class="col-md-3">
               <select>
                <option>Street</option>


              </select>

            </div>
          </div> -->
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Package</th>
                <th>Team</th>
                <th>Amount Paid</th>
                <th>Status</th>
              </tr>
            </thead>


            <tbody id="">
              <?php
                 // foreach($coupans as $key => $value)
                 // {
                 //  if($value['user_type'] == 1)
                 //  {
                 //    $user_type = 'NEW USER';
                 //  }
                 //  else
                 //  {
                 //    $user_type = 'EXISTING USER';
                 //  }
                 //  echo"
                 //  <tr>
                 //    <td>".$value['offer_name']."</td>
                 //    <td>".$value['valid_from']."</td>
                 //    <td>".$value['valid_upto']."</td>
                 //    <td>".$value['coupan_code']."</td>
                 //    <td>".$value['discount']."</td>
                 //    <td>".$value['minimum_order']."</td>
                 //    <td>".$user_type."</td>
                 //    <td>".$value['max_discount']."</td>
                 //    <td>
                 //      <a href='".base_url()."coupans/delete_coupans?id=".$value['id']."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o m-right-xs'></i>Delete
                 //      </a>
                 //    </td>
                 //  </tr>";
                 // }
              ?>
              
              <tr>
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
              </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


 


  <div class="row">
   
    

  </div>
</div>
    



