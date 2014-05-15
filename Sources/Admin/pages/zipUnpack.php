<?php 
	
	if(!$log)exit;
	
	/* required data */
	if(!isset($_GET['root'])&&isset($_GET['file']))die("Hacking attempt!");
	if(!isset($_GET['destination']))die("No destination!");
	if(!isset($_GET['return']))die("No return destination!");
	
	/* check if file exists */
	if(file_exists($_GET['root'] . "/" .$_GET['file'])){
		
		/* check if destination exists */
		if(is_dir($_GET['destination'])){
		
			/* Open package */
			$zip = new ZipArchive;
			$openZip = $zip->open($_GET['root'] . "/" .$_GET['file']);
			if ($openZip===true){
			
				/* Unpack package */
				$zip->extractTo($_GET['destination']);
				
				/* Close package */
				$zip->close();
				
				/* Return to sender */
				echo "<script>window.location='admin.php?action=".$_GET['return']."&root=".$_GET['root']."&note=".urlencode($language['unzipSuccesfull'])."';</script>";
			}else{/* unpack error */echo 'Unpacking error.';}
			
		}else{
			/* No destination */
			echo "Destination directory missing ". $_GET['destination'];
		}
	}else{
		/* File missing */
		echo "File does not exists (anymore)". $connect['root']. $_GET['root'] . "/" . $_GET['file'];
	}
?>
