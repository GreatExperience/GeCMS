<?php
    /* Include system */
    require_once("SSI.php");

    define('cms', 'install');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>GeCMS Installation</title>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>
		<style type='text/css'>
			body {
				margin:0 auto;
				font-family:verdana;
				background:#eee;
				font-size:13px;
				background: url(./Sources/Admin/images/bg.png) no-repeat center center fixed;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			}
			h1 {font-size:25px;}
			.box h1 {border-bottom:1px solid #ccc;padding-left:10px;padding-bottom:5px;margin-top:30px;color:#444;}
			h1 img {position:relative;top:35px;margin-right:10px;}
			.container {width:80%;margin:0 auto;margin-top:50px;}
			.top {position:fixed;top:50px;left:0;right:0;bottom:0;overflow:auto;padding-top:2%;padding-bottom:2%;}
			.box {background:#fff;padding:10px;box-shadow:0px 0px 40px -5px #000;z-index:5;position:relative;min-height:200px;}
			.box p {margin:5px;}
			.box input, .box select {background:#eee;padding:10px;width:438px;border:1px solid #ccc;margin:10px;margin-bottom:20px;box-sizing: border-box;}
			.box input:focus, .box select:focus {border:1px solid #00a2ff;outline:none;}
			.box input.submit {
				background:#00c0ff;
				border:1px solid #00a2ff;
				padding:0;
				padding-top:10px;
				padding-bottom:10px;
				margin:10px;
				width:200px;
				color:#fff;
				transition:0.5s;
				-webkit-transition:0.5s;
			}
			
			.box input.submit:hover {
				background:#00afe8;
				border:1px solid #007ac0;
			}
			input:-webkit-autofill {
					-webkit-box-shadow: 0 0 0px 1000px #eee inset;
			}
			.check input {
				display:none;
			}
			
			.check span {
				width: 15px;
				height: 15px;
				background:#eee;
				border:1px solid #eee;
				outline:1px solid #ccc;
				display: block;
				float:left;
				margin-left:5px;
			}
			.check input:checked + span {
				background:#00c0ff;
			}
			
			.nav {
				height:50px;
				background:#002d56;
				border-bottom:1px solid #00386c;
			}
			
			.nav h1 {margin:0;margin-top:-5px;font-size:22px;color:#fff;padding-top:12px;padding-left:20px;text-shadow:1px 1px #000;width:275px;float:left;}
			.nav .toRight {
				float:right;
				line-height:50px;
				padding-right:15px;
				padding-left:15px;
				border-left:1px solid #001c36;
			}
			.nav .progress {
				background:#01488a;
				border:1px solid #00529f;
				border-radius:15px;
				box-shadow:inset 0px 0px 5px -0px #00529f;
				color:#fff;
				height:32px;
					line-height:32px;
				transition:0.5s;
				-webkit-transition:0.5s;
				margin:10px;
				margin-top:7px;
				margin-bottom:0;
				text-align:center;
				text-shadow:1px 1px #000;
				font-size:16px;
			}
			.nav .progress:hover {
				outline:none;
				border:1px solid #016bce;
				background:#005baf;
			}
			
			.step {background: #499bea;
			    background: -moz-linear-gradient(top, #499bea 0%, #207ce5 100%);
			    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#499bea), color-stop(100%,#207ce5));
			    background: -webkit-linear-gradient(top, #499bea 0%,#207ce5 100%);
			    background: -o-linear-gradient(top, #499bea 0%,#207ce5 100%);
			    background: -ms-linear-gradient(top, #499bea 0%,#207ce5 100%);
			    background: linear-gradient(to bottom, #499bea 0%,#207ce5 100%);
			    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#499bea', endColorstr='#207ce5',GradientType=0 );
			    height:30px;position:relative;border-radius:15px;margin-top:1px;
			}
			
			.menuContainer {
				border-right:1px solid #00396e;
				border-left:1px solid #001c36;
				line-height:50px;
				height:50px;
				float:right;
				color:#b2cfeb;
				padding-right:15px;
				padding-left:15px;
				transition:0.5s;
				-webkit-transition:0.5s;
				cursor:pointer;
				
			}
			.menuContainer img {position:relative;top:7px;margin-right:4px;}
			.menuContainer:hover {color:#fff;}
			
			.alert {
			    	border: 1px solid;
				margin: 0px;
				margin-bottom:10px;
				padding:10px 10px 10px 20px;	
				font: bold 12px verdana;
				border-radius: 10px;
				box-shadow:inset 1px 1px 0 #fff;
				background:#BDE5F8;
				color:#00529B;
			}
		</style>
	</head>
	<body>
		<div class='nav'>
			<table style='width:100%;border-collapse:collapse;'>
				<tr>
					<td><h1 style='width:300px;text-align:center;'>GeCMS Installation</h1></td>
					<td style='width:100%;'><div class='progress'><div class='step' style='width:0%;'></div><div style='margin-top:-30px;z-index:2;position:relative;'>Progress</div></div></td>
				</tr>
			</table>
		</div>
		<div class='top'>
			<div class='container'>
			    <div class='box'>
				<p style='margin-top:15px;text-align:center;'><img src='./Sources/Admin/images/logoText.png' alt='logo' /></p>
				<?php
				    $selected = false;
				    $url = './installation/';
				    
				    if(isset($_GET['step'])){
					if(file_exists($url . $_GET['step'] . '.php')){
					    require_once($url . $_GET['step'] . '.php');
					    $selected = true;
					}
				    }
				    
				    if($selected==false){
					if(file_exists($url . "index.php")){
					    require_once($url . "index.php");
					}else{
					    echo 'that\'s an error!';
					}
				    }
				?>
			    </div>
			</div>
		</div>
	</body>
</html>
	