<?php 
	if(!$log)exit;
	
	if(isset($_GET['template'])){
	
		rrmdir("./Templates/" . $_GET['template'] . "/");
		echo "<h1>Delete succesfull.</h1><script>window.location='./admin.php?action=templates&note=".urlencode($language['deleteTemplateSucces'])."';</script>";
	}else{
		die("Hacking Attempt");
	}
  
?>