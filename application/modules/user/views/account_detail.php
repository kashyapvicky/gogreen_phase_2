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
 .out_bal{
    font-size: 18px;
    color: #000;
    font-weight: 600;
}
</style>
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
<script type="text/javascript" src="<?php echo base_url_custom; ?>/build/js/sumTable.js"></script>
<a href="#" onclick="history.go(-1);" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3><?php if(!empty($personal_detail))
            {
              // print_r($personal_detail); die;
              echo $personal_detail['name'];
            }?></h3>
    </div>

    <div class="title_right">
      
    </div>
  </div>
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
        <?php echo $this->session->flashdata('link_send');?>
          <div class="row" style="text-align: center;">
            <div class="col-md-1">
              <!-- <a href="<?php echo base_url()?>user?page=0"><span class="fa fa-backward"></span></a> -->
            </div>
            <div class="col-md-3"><span class=" fa fa-user">&nbsp;&nbsp;&nbsp;&nbsp;</span><?php if(!empty($personal_detail))
            {
              // print_r($personal_detail); die;
              echo $personal_detail['t_name'];
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
          <div class="clearfix">
            
          </div>
        </div>
        <div class="x_content">
         
            <div class="row">
                <div class="col-md-4">
                  
                </div>
                <div class="col-md-4">
                  
                    <ul style="background-color: #E1DFDE;" class="nav nav-tabs nav-justified">
                      <li ><a href="<?php echo base_url('user/get_user_car_details?id='.$user_id.'')?>">Cars</a></li>
                      <li style="background-color: #4caf50; font-size:15px; font-weight: 500;"><a href="#" style="color: #fff;">Account Statement</a></li>
                    </ul>
                  
                </div>
                <div class="col-md-4"></div>
            </div>

             <div class="row" style="padding:20px 0";>
            <div class="col-md-4">
                   <button  data-toggle="modal" data-target="#payment_modal"  class="btn btn-info">Send Payment Link</button>
                </div>
                <div class="col-md-8">
                  <button style="background-color: #5bc0de; border: 1px solid #46b8da; color:#fff; float: right;"  data-toggle="modal" data-target="#myModal"  class="btn btn-active">Write-Offs</button>
                </div>
          </div>


          <table id="datatable" class="to_sum table table-striped table-bordered">
            <thead>
              <tr>
                <th>Order Id</th>
                <th>Date</th>
                <th>Particulars</th>
                <th>Amount Dr</th>
                <th>Amount Cr</th>
                <th>Payment Mode</th>
                
              </tr>
            </thead>


            <tbody id="">
               <?php
              if(!empty($ledger))
              {
               // echo "<pre>"; print_r($ledger); die;
                foreach($ledger as $key => $value)
                {


                   $status = $value['payment_type'];
                  if($status == 1)
                  {
                    $p_date = date('d-M-y',strtotime($value['purchase_date']));
                    // case of COD
                     echo"
                    <tr>
                    <td>".$value['orders_id']."</td>
                    <td>".$p_date."</td>
                    <td>".$value['remark']."</td>
                    <td>".$value['net_paid']."</td>
                    <td>0</td>
                    <td>COD</td>
                    </tr>
                    ";
                   $payment_detail =  get_payment_against_this_order($value['id']);
                   if(!empty($payment_detail))
                   {

                      $collected_amt = 0;
                      foreach ($payment_detail as $detail_key => $detail_value)
                      {
                        $newsate = date('d-M-y',strtotime($detail_value['created_at']));
                        
                        $collected_amt  += $detail_value['amount_collected'];
                        $amount_dr = $value['net_paid'] -$collected_amt;
                        echo"<tr>
                          <td>".$value['orders_id']."</td>
                          <td>".$newsate."</td>
                          <td>".$detail_value['particulars']."</td>
                          <td>0</td>
                          <td>".$detail_value['amount_collected']."</td>
                          <td>COD</td>
                        </tr>";
                      }
                   }
                  }
                  else
                  {
                     $newsate = date('d-M-y',strtotime($value['purchase_date']));
                    // cause of online
                     echo"
                    <tr>
                    <td>".$value['orders_id']."</td>
                    <td>".$newsate."</td>
                    <td>".$value['remark']."</td>
                    <td>".$value['net_paid']."</td>
                    <td>0</td>
                    <td>Online</td>
                    </tr>
                    ";
                     echo"
                    <tr>
                    <td>".$value['orders_id']."</td>
                    <td>". $newsate."</td>
                    <td>".$value['remark']."</td>
                    <td>0</td>
                    <td>".$value['net_paid']."</td>
                    <td>Online</td>
                    </tr>
                    ";
                  }
                  // echo"
                  // <tr>
                  // <td>".$value['orders_id']."</td>
                  // <td>".$value['purchase_date']."</td>
                  // <td>".$value['remark']."</td>
                  // <td>".$amount_debit."</td>
                  // <td>".$amount_credit."</td>
                  // <td>".$mod."</td>
                  // </tr>
                  // ";
                }
               $write_off_data =  get_if_any_write_off_made_by_admin($user_id);
              // echo $this->db->last_query(); die;
               if(!empty($write_off_data))
               {
                  foreach ($write_off_data as $w_key => $w_value)
                  {
                    $w_date = date('d-M-y',strtotime($w_value['created_at']));
                    echo"<tr>
                    <td>#</td>
                    <td>".$w_date."</td>
                    <td>".$w_value['particulars']."</td>
                    <td>0</td>
                    <td>".$w_value['write_off_amt']."</td>
                    <td>Writes off</td>
                    </tr>
                    ";
                  }
               }
              }
              $out_data =  get_if_outstanding($user_id);
              // echo $this->db->last_query(); die;
               if(!empty($out_data))
               {
                  foreach ($out_data as $o_key => $o_value)
                  {
                    if($o_value['outstanding_balance'] > 0)
                    {
                      if($o_value['created_at'] !="0000-00-00 00:00:00")
                      {
                        $o_date = date('d-M-y',strtotime($o_value['created_at']));
                        
                      }
                      else
                      {
                        $o_date = "N/A";
                      }
                      echo"<tr>
                      <td>#</td>
                      <td>".$o_date."</td>
                      <td>Outstanding</td>
                      <td>".$o_value['outstanding_balance']."</td>
                      <td>0</td>
                      <td>By Admin</td>
                      </tr>
                      ";
                      
                    }
                  }
               }


              ?>
            </tbody>
          </table>
         
        </div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4 out_bal">Outstanding Balance : <spna id="out_amt"></spna></div>
          <div class="col-md-4">
            

          </div>
        </div>
      </div>
    </div>

  </div>


  <div class="row">
    

  </div>
</div>
     

<!-- Modal For Write-off -->
<div style="" class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4  class="modal-title">Writes - Off</h4>
          </div>
          <div class="modal-body" style="">
           <form method="post" action="<?php echo base_url('user/insert_write_off')?>">
            <input type="hidden" name="user_id_hidden" value="<?php echo $user_id;?>">
             <label>Write off Amount</label>
            <input required type="number" step="any" class="form-control" name="write_off_amount" placeholder="Enter Amount">
            <label>Write off Reason</label>
            <input required type="text" class="form-control" name="reason" placeholder="Reason">

          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default" value="Add">
          </form>
          <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<!-- /Modal For Write-off -->
<!-- Modal for payment link -->
  <div style="" class="modal fade" id="payment_modal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4  class="modal-title">Link Amount</h4>
          </div>
          <div class="modal-body" style="">
           <form method="post" action="<?php echo base_url('user/send_payment_link')?>">
            <input type="hidden" name="user_id_hidden" value="<?php echo $user_id;?>">
             <label> Amount</label>
            <input required type="number" step="any" class="form-control" name="link_amount" placeholder="Enter Amount">
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default" value="Add">
          </form>
          <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<!--/ Modal for payment link -->
<script type="text/javascript">
  $(".to_sum").sumTable({
  "skipFirstColumn" : true,
  "skipSecondColumn" : true,
  "totalClass" : "className anotherClassName"
  });
</script>
<script>
function for_outstanding_row() {

   // alert('function_called');
    $('#0_t').html('');
    $('#1_t').html('');
    $('#4_t').html('');
    $('#for_color').css("color","#696969");
    $('#for_color').css("font-weight","Bold");

    $('#2_t').css("color","#696969");
    $('#2_t').css("font-weight","Bold");


     $('#3_t').css("color","#696969");
    $('#3_t').css("font-weight","Bold");
    //$('.sorting_1').css("color","");

    var total_debit_amount = Number($('#2_t').html());
    var total_credit_amount = Number($('#3_t').html());

    //console.log(total_debit_amount);
    //console.log(total_credit_amount);

    var outstanding_balance = total_debit_amount - total_credit_amount;
    console.log(outstanding_balance);
    $('#out_amt').html(outstanding_balance);

    //console.log(Number(total_debit_amount));
};

</script>

<script>
        $(document).on('click', '.to-popup', function () {
        return confirm('Are you sure you want to send payment link?');
    });$(document).on('click', '.wt_off', function () {
        return confirm('Are you sure to add amount?');
    });
   
</script>

<script>

   $(document).ready(function(){
    $("#datatable").dataTable().fnDestroy()
    $('#datatable').dataTable({
     
          
    "fnDrawCallback": function( oSettings )
    {
      ///alert( 'DataTables has redrawn the table' );
      //alert('test');
      for_outstanding_row();
     // for_outstanding_row();
    }


          });
});
</script>
