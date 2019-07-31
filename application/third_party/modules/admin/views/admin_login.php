<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Go Green</title>
  
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
 -->
  
      <link rel="stylesheet" href="<?php echo base_url_custom; ?>/build/css/style.css">
  <style type="text/css">
    .login .utilities a
    {
    text-shadow: none;
    }
  </style>

  
</head>

<body>
  <form method="post" action="<?php echo base_url()?>admin/login">
    <?php  if($this->session->flashdata('item'))
    {
      echo"<script>alert('Invalid Admin Credentials')</script>";
    }
    
    ?> 
    <div class="login">
        <div id="flashdata">
          <font color="red">
          <?php echo $this->session->flashdata('success'); ?>
          <?php echo $this->session->flashdata('failure'); ?>
          </font>
        </div>
      <h2>Go Green</h2>
      <fieldset>
        <input type="email" placeholder="Email" name = "email" />
      	<input type="password" placeholder="Password" name="password" />
      </fieldset>
      <input type="submit" value="Log In"/>
      <div class="utilities">
        <a href="<?php echo base_url('admin/forget_password')?>">Forgot Password?</a>

          
        <!-- <a href="#">Sign Up &rarr;</a> -->
      </div>
    </div>
  </form>
</body>
</html>
<script>
</script>