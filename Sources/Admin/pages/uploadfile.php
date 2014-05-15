<?php
	if(!$log)exit;
	
	/* check if $_FILES exists */
	if(isset($_FILES)){
		if(isset($_FILES['file']['name'])){
			if( $_FILES["file"]["error"] > 1 )
				echo "<script>window.location=\"admin.php?action=".$_GET['return']."&root=".$_GET['root']."&note=".$_FILES["file"]["error"]."\";</script>";
			elseif( $_FILES["file"]["error"] == 1 )
				echo "<script>window.location=\"admin.php?action=".$_GET['return']."&root=".$_GET['root']."&note=".$language['uploadError1']."\";</script>";
			
			if (file_exists($_GET['root'] . $_FILES["file"]["name"]))
			  {
			  echo $_FILES["file"]["name"] . " already exists. ";
			  }
			else
			  {
			  move_uploaded_file($_FILES["file"]["tmp_name"],
			  $_GET['root'] . "/" . $_FILES["file"]["name"]);
			  echo "Stored in: " . $_GET['root']  . "/" . $_FILES["file"]["name"];
			  echo "<script>window.location=\"admin.php?action=".$_GET['return']."&root=".$_GET['root']."&note=".$language['uploadMsgFinish']."\";</script>";
			  }
		}else{
			echo "<script>window.location=\"admin.php?action=".$_GET['return']."&root=".$_GET['root']."&note=Unknown file error\";</script>";
		}
	}
?>