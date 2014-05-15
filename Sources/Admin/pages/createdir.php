<?php 
	if(!$log)exit;
	
	if (!mkdir($_GET['root'] . "/" . $_POST['directory'], 0700)) {
		echo "<script>window.location=\"admin.php?action=".$_GET['return']."&root=".$_GET['root']."&note=".$language['newDirectoryMsgDie']."\";</script>";
	}else{
		echo "<script>window.location=\"admin.php?action=".$_GET['return']."&root=".$_GET['root']."&note=".$language['newDirectoryMsgFinish']."\";</script>";
	}
    
  
?>