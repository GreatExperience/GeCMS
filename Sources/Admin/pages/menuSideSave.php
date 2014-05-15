<?php if(!$log==true)exit; 

	if(isset($_POST['editor1'])){
	
		$query = $dbh->prepare("UPDATE ".$connect['ext']."settings SET value=? WHERE name='siteMenu'");
		$query->execute(array($_POST['editor1']));
		
		echo "<h1>edited succesfull.</h1><script>window.location='./admin.php?action=menuSide&note=".urlencode($language['menuSideEditDone'])."';</script>";
	}else{
		echo "hacking attempt";
	}
?>
				