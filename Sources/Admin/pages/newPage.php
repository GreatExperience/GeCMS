<?php 
	if(!$log)exit;
	
	if(!isset($_POST['name']))die("Hacking attempt!");

	if(file_exists($connect['root'] . "/Sources/Pages/" . $_POST['name'] . ".php")){
		echo "<script>window.location='./admin.php?action=pagelist&root=./Sources/Pages&note=".$language['newPageExists']."';</script>";
	}else{
	
		$fp = fopen($connect['root'] . "/Sources/Pages/" . $_POST['name'] . ".php", 'w');
		fwrite($fp, "");
		fclose($fp);
		
		$insert = $dbh->prepare("INSERT INTO ".$connect['ext']."pages (file, meta, template, title) VALUES (?, ?, ?, ?)");
		$insert->execute(array($_POST['name'] . ".php", $_POST['meta'], $_POST['template'], $_POST['name']));
		
		echo "<script>window.location='./admin.php?action=pagelist&root=./Sources/Pages';</script>";
	}
