<?php 
	if(!$log==true)exit;
	
	if(isset($_POST['menuName'])&&isset($_POST['menuPosition'])&&isset($_POST['menuURL'])&&isset($_POST['menuDrops'])){
		
		/* Data has to contain chars */
		if(strlen($_POST['menuName'])>0&&strlen($_POST['menuPosition'])>0&&strlen($_POST['menuURL'])>0&&strlen($_POST['menuDrops'])>0){
			if($_POST['menuDrops']=='denie'){
			
				/* Insert MAIN menu item */
				$insert = $dbh->prepare("INSERT INTO ".$connect['ext']."menu (menuName, menuTarget, menuHREF, child, child_of, position) VALUES (?, ?, ?, ?, ?, ?)");
				$insert->execute(array($_POST['menuName'], $_POST['menuFrame'], $_POST['menuURL'], 0, 0, $_POST['menuPosition']));
			}else{
				/* Insert SUB menu item */
				$insert = $dbh->prepare("INSERT INTO ".$connect['ext']."menu (menuName, menuTarget, menuHREF, child, child_of, position) VALUES (?, ?, ?, ?, ?, ?)");
				$insert->execute(array($_POST['menuName'], $_POST['menuFrame'], $_POST['menuURL'], 1, $_POST['menuDrops'], $_POST['menuPosition']));
			}
			
			echo "<script>window.location='admin.php?action=menu&note=".urlencode($language['menuAddDone'])."';</script>";
			
		}else{
			
			/* Return note: data not filled */
			echo "<script>window.location='admin.php?action=menu&note=".urlencode($language['notFilled'])."';</script>";
		}
		
	}else{
	
		/* Missing post data > Return error */
		echo "DATA MISSING! ~~ Hacking attempt";
	}
?>