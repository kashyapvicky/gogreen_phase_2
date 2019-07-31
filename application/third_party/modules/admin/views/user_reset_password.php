
<?php
$id = $this->input->get('id');
?>
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
  <form method="post" action="<?php echo base_url('admin/reset_user_password?id='.$id.'')?>">
   
    <div class="login">
      <h2>Go Green</h2>
      <fieldset>
        <input type="password" placeholder="New Password" name = "password1" />
        <input type="password" placeholder="Confirm Password" name="password2" />
      </fieldset>
      <input type="submit" value="Save Password"/>
      <div class="utilities">
        <?php  
        echo"<font color = 'red'>";
        echo $this->session->flashdata('error');
        //echo  $this->session->tempdata('error');
        echo "</font>";
        ?> 
        <!-- <a href="#">Sign Up &rarr;</a> -->
      </div>
    </div>
  </form>
</body>
</html>
