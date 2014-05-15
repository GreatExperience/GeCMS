<?php 
	if(!$log)exit; 
	

	if(isset($_POST['editPosition'])&&isset($_POST['editName'])&&isset($_GET['id'])){
	
		$query = $dbh->prepare("UPDATE ".$connect['ext']."news_cats SET name=? WHERE id=?");
		$query->execute(array($_POST['editName'], $_GET['id']));
		
		$query = $dbh->prepare("UPDATE ".$connect['ext']."news_cats SET position=? WHERE id=?");
		$query->execute(array($_POST['editPosition'], $_GET['id']));
		
		echo "<h1>edited succesfull.</h1><script>window.location='./admin.php?action=newsManager&displayCats=1&note=".urlencode($language['succesNewsCat'])."';</script>";
	}else{
		echo "Whoops! Thats did'nt go right.";
	}
?>