<?php 
	if(!$log)exit;
	
	if(is_dir($_GET['root'] . "/" . $_GET['directory'] . "/")){
		rrmdir($_GET['root'] . "/" . $_GET['directory'] . "/");
		echo "<script>window.location=\"admin.php?action=".$_GET['return']."&root=".$_GET['root']."&note=".$language['deleteDirectoryMsgFinish']."\";</script>";
	}
    
  
?>