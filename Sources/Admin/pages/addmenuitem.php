<?php 

if(!$log==true) exit;

if(!(isset($_POST['menuName'])&&isset($_POST['menuPosition'])&&isset($_POST['menuURL'])&&isset($_POST['menuDrops']))){
    echo "DATA MISSING! ~~ Hacking attempt";
    exit;
}

/* Data has to contain chars */
if(!(strlen($_POST['menuName'])>0&&strlen($_POST['menuPosition'])>0&&strlen($_POST['menuURL'])>0&&strlen($_POST['menuDrops'])>0)){
    echo "<script>window.location='admin.php?action=menu&note=".urlencode($language['notFilled'])."';</script>";
    exit;
}

/* Query */
$insert = $dbh->prepare("INSERT INTO ".$connect['ext']."menu (menuName, menuTarget, menuHREF, child, child_of, position) VALUES (?, ?, ?, ?, ?, ?)");
$insert->execute(array($_POST['menuName'], $_POST['menuFrame'], $_POST['menuURL'], ($_POST['menuDrops']=='denie' ? 0 : 1), ($_POST['menuDrops']=='denie' ? 0 : $_POST['menuDrops']), $_POST['menuPosition']));	
echo "<script>window.location='admin.php?action=menu&note=".urlencode($language['menuAddDone'])."';</script>";
		
?>