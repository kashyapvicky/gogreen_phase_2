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
          <li class=""><a href="<?php echo base_url()?>orders">Online</a></li>
          <li class=""><a href="<?php echo base_url()?>orders/index?cashtab=1">Cash</a></li>
          <li class="active"><a href="<?php echo base_url()?>pending">Pending</a></li>
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

                <th>Date</th>
                <th>Order ID</th>
                <!-- <th>Car Number</th> -->
                <th>Amount to be collected </th>
                <th>Customer Name</th>
                <th>Phone Number</th>
                <th>Type</th>
              </tr>
              </tr>
            </thead>
            <tbody id="">
              <?php
              //echo"hello";die;
                 foreach($pending_orders as $key => $value)
                 { $newsate = date('d-M-y',strtotime($value['purchase_date']));
                    //print_r($orders); die;
                  echo"
                  <tr>
                    <td>".$newsate."</td>
                    <td>".$value['orders_id']."</td>
                   
                    <td>".$value['net_paid']."</td>
                    <td>".$value['name']."</td>
                    <td>".$value['phone_number']."</td>
                    <td>COD</td>
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
    



<script>
  $(document).ready(function(){
    $("#datatable").dataTable().fnDestroy()
    $('#datatable').dataTable({
            
            dom: 'Bfrtip',
            buttons: [
                      {
                extend: 'excelHtml5',
                title: 'Data export',
                 exportOptions: {
                       columns: [ 0, 1, 2,3]
                }
            },
            {
                extend: 'csvHtml5',
                title: 'Data export',
                exportOptions: {
                   columns: [ 0, 1, 2,3]
                }
            },
    ],
    oLanguage: {
      "sSearch": "Search:"
    },
    columnDefs : [
                { 
                    'searchable'    : true, 
                    'targets'       : [1,2,3] 
                },
            ]
          });
});

</script>