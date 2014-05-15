<?php 
	if(!$log)exit;
	
	if(!isset($_GET['root'])||!isset($_POST['content'])||!isset($_GET['return']))die("Hacking attempt!");

		try {

			$file = new file($_GET['root'] . "/" . $_GET['file']);
			$file->editFile($_POST['content']);
			
			$extraUrl;
			if(isset($_GET['coding']))$extraUrl = $_GET['coding'];
			    
			if(isset($_POST['pageTitle'])&&isset($_POST['pageTemplate'])&&isset($_POST['sideMenu'])){
			    $update = $dbh->prepare("UPDATE ".$connect['ext']."pages SET title=? WHERE file=?");
			    $update->execute(array($_POST['pageTitle'], $_GET['file']));
			
			    $update = $dbh->prepare("UPDATE ".$connect['ext']."pages SET template=? WHERE file=?");
			    $update->execute(array($_POST['pageTemplate'], $_GET['file']));
			    
			    $update = $dbh->prepare("UPDATE ".$connect['ext']."pages SET menu=? WHERE file=?");
			    $update->execute(array($_POST['sideMenu'], $_GET['file']));
			}
			
			echo "<h1>Edited succesfull.</h1><script>window.location='./admin.php?action=".$_GET['return']."&root=".urlencode($_GET['root'])."&file=".$_GET['file']."&note=".$language['saveSucces']."';</script>";

		} catch (Exception $ex) {
			echo $ex;
		}
	/*
	if (is_writable($_GET['root'] . "/" . $_GET['file'])) {
		if($_GET['edit']==true){

			$fp = fopen($_GET['root'] . "/" . $_GET['file'], 'w');
			fwrite($fp, stripslashes($_POST['content']));
			fclose($fp);
			
			echo "<h1>Edited succesfull.</h1><script>window.location='./admin.php?action=pagelist&root=".$_GET['root']."&save=true';</script>";
		}
	
	}else{echo "Please make sure your webserver supports file writing & editing!";}
		*/
?>