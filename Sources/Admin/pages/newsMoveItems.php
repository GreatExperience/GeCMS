<?php 
	if(!$log==true)exit;

	if(isset($_GET['id'])&&isset($_POST['new'])){
	
		$query = $dbh->prepare("UPDATE ".$connect['ext']."news_items SET cat=? WHERE cat=?");
		$query->execute(array($_POST['new'], $_GET['id']));
		
		echo "<h1>edited succesfull.</h1><script>window.location='./admin.php?action=newsManager&displayCats=1&note=".urlencode($language['succesNewsCat'])."';</script>";
	}
	?>