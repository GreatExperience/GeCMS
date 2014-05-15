<?php 
	if(!$log)exit;
	
	/* check if POST variables exists */
	if(!isset($_POST['content']))
		die("Hacking attempt!");
	
	/* Create update query */
	$update = $dbh->prepare("UPDATE ".$connect['ext']."settings SET value=? WHERE name='adminToDo';");

	/* Execute update query */
	$update->execute(array($_POST['content']));

	/* Send user back */
	echo "<h1>Edited succesfull.</h1><script>window.location='./admin.php?note=".$language['saveSucces']."';</script>";
?>