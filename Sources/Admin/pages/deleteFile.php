<?php 

	require("../../../SSI.php");
	
	if(!$log)die("Hacking attempt");
	
	if(!isset($_GET['root'])&&isset($_GET['file'])&&isset($_GET['id']))die("Hacking attempt!");
	
        try {
            $file = new file($_GET['root']."/".$_GET['file']);
            
            $file->deleteFile();
            
            echo "<script>$('#deleteitem_modal_file".$_GET['id']."').fadeOut();$('#loader".$_GET['id']."').fadeOut(0);$('#file".$_GET['id']."').delay(600).fadeOut();</script>";
            
        }catch(Exception $e){
            echo "File does not exists (anymore) ".  $_GET['root'] . "/" . $_GET['file'] ."j ". dirname($_GET['root'] . "/" . $_GET['file']). PHP_EOL;
		echo "
		<div class='notification'>".$language['fileMissing']."</div>
		<script>console.log('".$_GET['id']."');$('#deleteitem_modal_file".$_GET['id']."').fadeOut();$('#loader".$_GET['id']."').fadeOut(0);$('.notification').delay(3000).fadeOut();</script>";
        }
?>
