<?php 
	if(!$log)exit;
	
	/* check if POST variables exists */
	if(!isset($_POST['siteTitle'])||!isset($_POST['siteDescription'])||!isset($_POST['siteKeywords'])||!isset($_POST['siteAuthor'])||!isset($_POST['siteRobots'])||!isset($_POST['languageSettings']))
		die("Hacking attempt!");
	
	/* Create update query */
	$update = $dbh->prepare("
		UPDATE ".$connect['ext']."settings SET value=? WHERE name='siteRobots';
		UPDATE ".$connect['ext']."settings SET value=? WHERE name='siteLanguage';
		UPDATE ".$connect['ext']."settings SET value=? WHERE name='siteAuthor';
		UPDATE ".$connect['ext']."settings SET value=? WHERE name='siteKeywords';
		UPDATE ".$connect['ext']."settings SET value=? WHERE name='siteDescription';
		UPDATE ".$connect['ext']."settings SET value=? WHERE name='siteTitle'
		");
		
	/* Execute update query */
	$update->execute(array($_POST['siteRobots'], $_POST['languageSettings'], $_POST['siteAuthor'], $_POST['siteKeywords'], $_POST['siteDescription'], $_POST['siteTitle']));

	/* Send user back */
	echo "<h1>Edited succesfull.</h1><script>window.location='./admin.php?action=settings&note=".urlencode($language['settingsSave'])."';</script>";
?>