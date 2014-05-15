<?php 
	if(!$log==true)exit;
	
	if(isset($_GET['id'])){
		$select = $dbh->prepare("SELECT * FROM ".$connect['ext']."menu WHERE id=?");
		$select->execute(array($_GET['id']));
		if($select->rowCount()==1){
			$delete = $dbh->prepare("DELETE FROM ".$connect['ext']."menu WHERE id=?");
			$delete->execute(array($_GET['id']));
			
			if(isset($_POST['menuDrops'])){
				if($_POST['menuDrops'] == 'denie'){
					$delete = $dbh->prepare("DELETE FROM ".$connect['ext']."menu WHERE child_of=?");
					$delete->execute(array($_GET['id']));
				}else{
					$update = $dbh->prepare("UPDATE ".$connect['ext']."menu SET child_of=? WHERE child_of=?");
					$update->execute(array($_POST['menuDrops'], $_GET['id']));
				}
			}
			
			echo "<script>window.location='admin.php?action=menu&note=".urlencode($language['menuDeleteDone'])."';</script>";
		}else{
			echo "<script>window.location='admin.php?action=menu&note=".urlencode($language['menuDeleteFail'])."';</script>";
		}
	}else{
		echo "Data missing ~~ Hacking Attempt";
	}
  
?>