<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Go Green</title>
  
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
 -->
  
      <link rel="stylesheet" href="<?php echo base_url_custom; ?>/build/css/style.css">
  <style type="text/css">
  @import url('https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese');
body{
      background-color: #76b852;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
      font-family: "Roboto", sans-serif;
}
.login {
    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
    background-color: #fff;
    margin: 0 auto;
    display: block;
    position: static;
    margin-top: 150px;
}
.login h2{
  color: #76b852;
  text-shadow: none;
}
.login h2 {
    color: #76b852;
    text-shadow: none;
    font-size: 24px;
    font-weight: bold;
}
.login  input {
    outline: none;
    width: 100%;
    display: block;
    background: #f2f2f2;
    border: none;
    margin: 0;
    padding: 17px 15px;
    font-size: 13px;
    margin: 0 0 20px 0;
    box-shadow: none;
    border-radius: 0;
    color: #000;
    float: left;
    box-sizing: border-box;
}
.login input::placeholder {
  color: #000;
}
.login input[type="submit"] {
    margin: 0;
    display: block;
    padding: 13px 0;
    width: 100%;
    font-size: 13px;
    font-weight: bold;
    border: 0;
    text-shadow: none;
    background-color: #4CAF50;
     background-image: none;
    border-radius: 0;
    box-shadow: none;
    color: #fff;
    cursor: pointer;
    margin: 0 0 15px;
}
.login input[type="submit"]:hover {
  background: #43A047;
}
.login:before, .login:after{
  display: none;
}
.login .utilities a{
  color: #4CAF50;
  text-shadow: none;
  font-size: 16px;
}
.login .utilities a:hover{
  font-weight: 400;
  color: #4CAF50;
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
        <input type="email" placeholder="Email" name = "email" />
      	<input type="password" placeholder="Password" name="password" />
      <input type="submit" value="LOGIN"/>
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