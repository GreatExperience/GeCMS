<?php 
	if(!$log)exit;
	
	if(isset($_GET['template'])){
		$update = $dbh->prepare("UPDATE ".$connect['ext']."settings SET value=? WHERE name='siteTemplate'");
		$update->execute(array($_GET['template']));
		
		echo "<h1>Edited succesfull.</h1><script>window.location='./admin.php?action=templates&note=".urlencode($language['templateIsDefault'])."';</script>";
	}else{
		die("Hacking Attempt");
	}
  
?>