<?php
	if(!$log)exit;
	
	if(!isset($_GET['id'])||!isset($_GET['table'])||!isset($_GET['return'])){
		die("Hacking attempt");
	}
	
	$table = stripslashes($_GET['table']);

	$query = $dbh->prepare("DELETE FROM ".$connect['ext'].$table." WHERE id=?");
	$query->execute(array($_GET['id']));
	
	echo "<h1>deleted succesfull.</h1><script>window.location='./admin.php?action=".$_GET['return']."&note=".urlencode($language['succesDelete'])."';</script>";
?>