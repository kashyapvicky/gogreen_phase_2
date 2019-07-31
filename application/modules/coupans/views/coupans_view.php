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
          <h2>Coupons </h2>
          <a href="<?php echo base_url()?>coupans/add_coupans">
          <button style="float: right;">Add New Offer</button></a>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Offer Name</th>
                <th>Valid From</th>
                <th>Valid To</th>
                <th>Coupon Code</th>
                <th>Discount %</th>
                <th>Minimum Order</th>
                <th>User Type</th>
                <th>Max Discount</th>
                <th>Operations</th>
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

                   $valid_from = date('d-M-y',strtotime($value['valid_from']));
                   $valid_upto = date('d-M-y',strtotime($value['valid_upto']));
                  echo"
                  <tr>
                    <td>".$value['offer_name']."</td>
                    <td>".$valid_from."</td>
                    <td>".$valid_upto."</td>
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
            
            dom: 'lBfrtip',
            buttons: [
                      {
                extend: 'excelHtml5',
                title: 'Data export',
                 exportOptions: {
                       columns: [ 0, 1, 2,3,4,5,6,7 ]
                }
            },
            {
                extend: 'csvHtml5',
                title: 'Data export',
                exportOptions: {
                   columns: [ 0, 1, 2,3,4,5,6,7]
                }
            },
    ],
    oLanguage: {
      "sSearch": "Search:"
    },
    columnDefs : [
                { 
                    'searchable'    : false, 
                    'targets'       : [1,2,3] 
                },
            ]
          });
});

</script>