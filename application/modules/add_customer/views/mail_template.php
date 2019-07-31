<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
@import url('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese');
</style>
<style type="text/css">
	body{
		font-family: 'Open Sans', sans-serif;
		margin:0;
		padding:0;
		box-sizing: border-box;
		line-height: normal;
	}
	a{
		text-decoration: none;
	}
	.tablebx{
		width: 100%;
		float: left;
		padding: 30px 30px 0;
	}
	.row{
		width: 100%;
		float: left;
		margin:20px 0;
	}
	.width30{
		width: 33%;
		float: left;
		text-align: center;
	}
	.width30 a{
		color: #333;
		font-weight: 600;
	}
	.width30 a:hover{
		color: green;
	}
	.width30 a:hover i{
		color: green;
	}
	.ico{
		color: #333;
		font-size: 20px;
		padding: 0 15px;
	}
	.ico1{
		padding: 0 7px 0 0;
	}
	.appbtn-wrap{
		width: 100%;
		float: left;
		text-align: center;
		margin:20px 0 0;
	}
	.app-btn{
		width: 200px;
		display: inline-block;
		padding: 0 10px;
	}
	.app-btn img{
		width: 100%;
	}
	.text-center{
		width: 100%;
		float: left;
		padding: 15px 0;
		text-align: center;
	}
	.text-center a{
		color: #666;
		padding: 0 15px;
		text-decoration: underline;
	}

	@media(max-width: 767px){
	.tablebx{
		padding: 30px 15px 0;
	}
	.row{
		margin:0 0 12px;
	}
	.width30{
		width: 100%;
		margin:10px 0;
	}
	.appbtn-wrap{
		margin: 10px 0 0 0;
	}
	.text-center a{
		font-size: 13px;
		padding: 0 7px;
	}
	}

</style>
</head>
<body>
<table class="tablebx">
	<tr>
		<td>Dear Customer</td>
	</tr>
	<tr>
		<td><p>Thanking for choosing Go Green Car Wash Services.</p>
			<p>Your order<?php echo $order_id; ?> has been received and is currently being processed by our team.</p></td>
	</tr>
	<tr>
		<td class="row">Ordered: <i><?php echo date('M-d-Y'); ?>Nov 24, 2018<i></td>
	</tr>
	<tr>
		<td>ORDER SUMMARY</td>
	</tr>
	<tr>
		<td>Order No: <i><?php echo $order_id; ?></i></td>
	</tr>
	<tr>
		<td>Order Total: <i>AED<?php echo $amount; ?>.00</i></td>
	</tr>
	<tr>
		<td>Payment: <?php echo $amount; ?>(In case of COD our team will call you shortly)</td>
	</tr>

	<tr>
		<td class="row"><a href="#" style="color: red;">View Order Details</a></td>
	</tr>
	<tr>
		<td>
			<span>Shukran,</span><br>
			<span>Team Go Green</span>
		</td>
	</tr>
</table>

<table class="tablebx" style="background-color: #eee; margin-top: 7px;">
	<tr>
		<td class="width30"><i class="fa fa-envelope ico1"></i><a href="mailto:info@gogreen-uae.com">info@gogreen-uae.com</a></td>
		<td class="width30"><i class="fa fa-phone ico1"></i><a href="tel:971 545866100">971545866100</a></td>
		<td class="width30"><a href="#"><i class="fa fa-facebook ico"></i></a><a href="#"><i class="fa fa-twitter ico"></i></a><a href="#"><i class="fa fa-instagram ico"></i></a><a href="#"><i class="fa fa-linkedin ico"></i></a></td>
	</tr>
	<tr>
		<td>
			<hr style="width: 60%; text-align: center; margin: 0 auto; margin-top: 17px;">
		</td>
	</tr>
	<tr>
		<td class="appbtn-wrap">
			<a href="#" class="app-btn"><img src="<?php echo base_url_custom;?>images/gstore.png" alt="playstore"></a><a href="#" class="app-btn"><img src="<?php echo base_url_custom;?>images/istore.png" alt="appstore"></a>
		</td>
	</tr>
	<tr>
		<td class="text-center">
			<a href="#">Privacy Policy</a><a href="#">Terms of Use</a><a href="#">Terms of Sale</a>
		</td>
	</tr>
</table>
</body>
</html>