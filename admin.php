<?php 

/* Include system */
require_once("./SSI.php");

if(isset($_POST['username'])&&isset($_POST['password'])){
		
    /* checking username and password */
    $selectUser = $dbh->prepare("SELECT * FROM ".$connect['ext']."users WHERE username=? AND password=? ");
    $selectUser->execute(array($_POST['username'], crypt($_POST['password'], md5('$GeSALT'.stripslashes($_POST['username']).'EndGeSALT$'))));
    
    if($selectUser->RowCount() != 1){
	$fail = "<div class='error'>Invalid username or password!</div>";
    }
	
    /* Get user data */
    $selectUser = $selectUser->fetchObject();
			
    /* Session handling */
    $selectSession = $dbh->prepare("SELECT * FROM ".$connect['ext']."sessions WHERE userIp=? AND userAccount=? ");
    $selectSession->execute(array($_SERVER['REMOTE_ADDR'], $selectUser->id));
			
    /* If there is no session, create one */
    if($selectSession->RowCount()==0) {
	$insertSession = $dbh->prepare("INSERT INTO ".$connect['ext']."sessions (userIp, userAccount) VALUES (?, ?)");
	$insertSession->execute(array($_SERVER['REMOTE_ADDR'], $selectUser->id));
    }
			
    /* When cookie already exists there is no need to create another one */
    if(!ISSET($_COOKIE['574a8h3rt4'])){
				
	/* Start fix for login */
	ob_start();
				
	/* Boolean as check */
	$cookieEndless = true;
				
	/* Set cookie for long time period */
	if(isset($_POST['autoLogin'])){
	    if($_POST['autoLogin']=='on'){
		setcookie("574a8h3rt4", $selectUser->id, time()+3600);
	    }else{$cookieEndless = false;}
	}else{$cookieEndless = false;}
				    
	/* Set cookie with limited time */
	if( ! $cookieEndless)
	    setcookie("574a8h3rt4", $selectUser->id);
				
	/* End fix for login */
	ob_end_flush();
    }
			
    /* Send user to the admin panel */
    echo "<script>window.location='./admin.php';</script>";
    exit;
}else{
    /* no post sended */
    if(isset($_post))$fail = "<div class='error'>Error: Data not sended!</div>";
}
	


/* Check if person is logged */
if($log){
    
    /* return admin panel */
    require_once($connect['root'] . "Sources/Admin/panel.php");	
}else{
    
    /* Login page */
	echo "
<!DOCTYPE html>
<html>
	<head>
		<title>GeCMS login</title>
		<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js' ></script>
		<meta content = ' width = 500px; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name = 'viewport' />
		<style type='text/css'>
			html, body {height:100%;}
			body {
				margin:0 auto;
				font-family:verdana;
				background:#eee;
				font-size:13px;
				background: url(".$connect['url']."/Sources/Admin/images/bg.png) no-repeat center center fixed;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
				overflow:hidden;
			}
			h1 {text-align:center;font-size:32px;margin-top:-20px;margin-bottom:30px;}
			h1 img {position:relative;top:35px;margin-right:10px;}
			.container {display:block;width:500px;margin:0 auto;}
			.top {position:fixed;top:40%;margin-top:-162px;left:0;right:0;bottom:0;}
			.box {background:#fff;padding:10px;box-shadow:0px 0px 40px -5px #000;-webkit-animation: loginFade 0.6s;-moz-animation: loginFade 0.6s;animation: loginFade 0.6s;border-radius:5px;}
			.box p {margin:5px;}
			.box input {background:#eee;padding:10px;width:438px;border:1px solid #ccc;margin:10px;margin-bottom:20px;}
			.box input:focus {border:1px solid #00a2ff;outline:none;}
			.box input.submit {
				background:#007eba;
				border:1px solid #00618f;
				padding:0;
				padding-top:10px;
				padding-bottom:10px;
				margin:10px;
				width:100%;
				color:#fff;
				float:right;
				transition:0.5s;
				-webkit-transition:0.5s;
				padding-left:40px;
				padding-right:40px;
				box-shadow:inset 0 1px 0 0 #0299e1;
				border-radius:3px;
			}
			.box input.submit:hover {
				border:1px solid #005177;
				background:#0a71a2;
				box-shadow:inset 0 1px 0 0 #028bcc;
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
				margin-left:10px;
			}
			.check input:checked + span {
				background:#00c0ff;
			}
			
			.input {margin:0 auto;}
			.logo {width:90px;margin:0 auto;margin-left:15px;}
			
			table {width:100%;float:left;padding-top:15px;border-collapse:collapse;}
			
			/* Chrome, Safari, Opera */
			@-webkit-keyframes loginFade {
			    from {-ms-transform: scale(0,0);-webkit-transform: scale(0,0);transform: scale(0,0);box-shadow:0px 0px 0px 0px #000;}
			    to {white;-ms-transform: scale(1,1);-webkit-transform: scale(1,1);transform: scale(1,1);box-shadow:0px 0px 40px -5px #000;}
			}

			/* Standard syntax */
			@keyframes loginFade {
			    from {-ms-transform: scale(0,0);-webkit-transform: scale(0,0);transform: scale(0,0);box-shadow:0px 0px 0px 0px #000;}
			    to {white;-ms-transform: scale(1,1);-webkit-transform: scale(1,1);transform: scale(1,1);box-shadow:0px 0px 40px -5px #000;}
			}
		</style>
		<script>
		    function resize() {
					if($('body').width()<700){
					    $('.box').css('position','fixed').css('bottom', '0').css('left', '0').css('right', '0').css('top', '0');
					    $('.input').css('width','90%').css('margin-top', '25px').css('float', 'none');
					    $('.input').css('margin-bottom','0px');
					}else{
					    $('.box').css('position','initial');
					    $('.input').css('width','438px').css('margin', '10px').css('margin-top', '10px');
					    $('.input').css('margin-bottom','20px');
					}
					
					if($('body').width()<550){
					     $('.logoText').css('text-align','center').css('width','100%').css('margin-top','25px').css('line-height','45px');
					     $('.logo').css('margin-left','0');
					     $('.logoHolder').css('text-align','center').css('width','100%');
					}else{
					    $('.logoText').css('width','350px').css('margin-top','0').css('line-height','160px');
					    $('.logo').css('margin-left','15px');
					    $('.logoHolder').css('width','90px').css('margin-top','0');

					}
					
					if($('body').width()<700 && $('body').height()<350){
					    $('#firstInput').css('margin-top','-120px');
					}else{
					    $('#firstInput').css('margin-top','20px');
					}
				}
			$( document ).ready(function() {
				if($('body').width()<700){resize();}
			});
		</script>
	</head>
	<body onresize='resize();'>
		<div class='top'>
			<div class='container'>
				<div class='box'>
					<h1 style='text-align:center;'>
					    <div style='width:90px;margin-right:15px;float:left;text-align:center;' class='logoHolder'><img src='".$connect['url']."/Sources/Admin/images/gelogo.png' class='logo'></div>
					    <div style='width:350px;float:left;line-height:160px;margin:0;' class='logoText'>Great Experienced</div>
					</h1>
					<form src='".$connect['url']."/admin.php' method='post'>
						<input class='input' name='username' type='text' placeholder='".$language['username']."' id='firstInput' />
				
						<input class='input' name='password' type='password' placeholder='".$language['password']."' />
						
						<table>
						    <tr>
							<td>
							    <label class='check'/>
								 <input name='autoLogin' type='checkbox' />
								 <span>
								 </span>
							    </label>
							    <span style='float:left;margin-left:15px;'>".$language['autologin']."</span>
							</td>
							<td>
							    <input type='submit' class='submit' value='Login' />
							</td>
						    </tr>
						</table>
						
						<div style='clear:both'></div>
						";
						if(isset($fail)){echo $fail;}
						echo "
					</form>
				</div>
				<p style='text-align:center;font-size:9px;opacity:0.5;margin-top:10%;color:#fff;'>".$language['version']." ".$settings['cmsVersion']." (beta)</p>
			</div>
		</div>
		<div style='clear:both'></div>
	</body>
</html>
	
	
	";
}
?>