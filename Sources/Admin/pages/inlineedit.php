<?php 
	
	if(!$log)exit;
	
	if(!isset($_POST['frame'])&&isset($_POST['url'])&&isset($_POST['position'])&&isset($_POST['name'])&&isset($_GET['id']))die("Hacking attempt!");
		$update = $dbh->prepare("UPDATE ".$connect['ext']."menu SET menuName=? WHERE id=?");
		$update->execute(array($_POST['name'], $_GET['id']));
		
		$update = $dbh->prepare("UPDATE ".$connect['ext']."menu SET position=? WHERE id=?");
		$update->execute(array($_POST['position'], $_GET['id']));
		
		$update = $dbh->prepare("UPDATE ".$connect['ext']."menu SET menuTarget=? WHERE id=?");
		$update->execute(array($_POST['frame'], $_GET['id']));
		
		$update = $dbh->prepare("UPDATE ".$connect['ext']."menu SET menuHREF=? WHERE id=?");
		$update->execute(array($_POST['url'], $_GET['id']));
		
		echo "<script>window.location='admin.php?action=menu&note=".urlencode($language['menuEditDone'])."';</script>";
		
	if(strlen($_POST['frame'])>0&&strlen($_POST['url'])>0&&strlen($_POST['position'])>0){
	}else{
		echo "<script>window.location='admin.php?action=menu&note=".urlencode($language['noFilled'])."';</script>";
	}
