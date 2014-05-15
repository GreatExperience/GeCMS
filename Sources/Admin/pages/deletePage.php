<?php 
	
	if(!$log)exit;
	
	if(!isset($_GET['root'])&&isset($_GET['file']))die("Hacking attempt!");
	
	if(file_exists($_GET['root'] . "/" .$_GET['file'])){
		unlink($_GET['root'] . "/" . $_GET['file']);
		if($_GET['root']=="./Sources/Pages"){
			$delete = $dbh->prepare("DELETE FROM ".$connect['ext']."pages WHERE file=?");
			$delete->execute(array($_GET['file']));
		}
		echo "<script>window.location='admin.php?action=".$_GET['return']."&root=".$_GET['root']."&note=".urlencode($language['deleteFileMsgFinish'])."';</script>";
	}else{
		echo "<script>document.write('<div class='notification'>".$language['fileMissing']."</div>');$('#deleteitem_modal_file".$_GET['id']."').fadeOut();$('#loader".$_GET['id']."').fadeOut(0);$('.notification').fadeOut(0);</script>";
		//echo "File does not exists (anymore)". $connect['root']. $_GET['root'] . "/" . $_GET['file'];
	}
?>
