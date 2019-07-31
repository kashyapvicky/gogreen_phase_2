<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Go Green</title>
  
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
 -->
  
      <link rel="stylesheet" href="<?php echo base_url_custom?>/build/css/style.css">

  
</head>

<body>
  <form method="post" action="admin/send_link">

    <div class="login">
      <h2>Enter Registerd Email</h2>
      <fieldset>
        <input type="email" placeholder="Email" name = "email" />
      </fieldset>
      <input type="submit" value="Send Verification Link"/>

      <div class="utilities">
          <?php  if($this->session->flashdata('check_email'))
          {
          // echo"<script>alert('Email not existed')</script>";
          echo"<font color='red'>";
          echo $this->session->flashdata('check_email');
          echo'</font>';
          }
          ?> 
        <!-- <a href="<?php echo base_url('admin/forget_password')?>">Forgot Password?</a>
        <a href="#">Send Verification Link &rarr;</a> -->
      </div>
    </div>
  </form>
</body>
</html>
