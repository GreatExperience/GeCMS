<?php
/* don't do anything if SSI is already loaded */
if (defined('CMS'))
	exit;
	
define('CMS', 'SSI');

/* disable absolute path of ssi.php */
if( basename($_SERVER['PHP_SELF']) == 'ssi.php' )
	return exit;

/* GeCMS will not tollerate 'half working' codes */
error_reporting(E_ALL | E_STRICT);

/* Developing modes :) */
ob_start();

/* Change directory for AJAX requests */
chdir(dirname(__file__));

/* include database objects */
require_once( dirname(__file__) . "/Connect.php" );
require_once( dirname(__file__) . "/Sources/Classes/Template.php");

/* User is logged out */
$log = false;
	
/* Installation mode */
if($Install==1 && basename($_SERVER["SCRIPT_NAME"]) == "index.php"){echo "<script language='javascript'>window.location=\"install.php\";</script>";exit;}

/* Maintenance mode */
if($Install==2){echo "This website is currently in maintenance mode!";}

if($Install==0){

    /* Getting results */
    $dbSettings = $dbh->prepare("SELECT name, value FROM ".$connect['ext']."settings");
    $dbSettings->execute();

    /* Make array from database output */
    while($row = $dbSettings->fetchObject()) { $settings[$row->name] = $row->value; }

    /* Check if user is logged */
    if(isset($_COOKIE['574a8h3rt4'])){
	
	    /* Check avaible sessions */
	    $selectIp = $dbh->prepare("SELECT * FROM ".$connect['ext']."sessions WHERE userIp=? AND userAccount=?");
	    $selectIp->execute(array($_SERVER['REMOTE_ADDR'], $_COOKIE['574a8h3rt4']));
	    if($selectIp->RowCount()==0) {

		    /* Anti hack */
		    setcookie('574a8h3rt4', 'detection', time()-10);
		    die("Whoops! Please refresh your browser!");
	    }else{

		    /* Set user to logged in */
		    $log = true;

		    /* Collect user data out of the database */
		    $selectUser = $dbh->prepare("SELECT * FROM ".$connect['ext']."users WHERE id=?");
		    $selectUser->execute(array($_COOKIE['574a8h3rt4']));
		    $user = $selectUser->fetchObject();
		    
		    /* Include admin related classes */
		    $classesDirectory = new RecursiveDirectoryIterator($connect['root'] . "/Sources/Admin/classes/");
		    foreach (new RecursiveIteratorIterator($classesDirectory) as $filename => $file) {
			require_once($filename);
		    }
	    }
    }

    /* Configure template */
    if(!isset($_GET['page'])){$file="index.php";}else{$file=$_GET['page'].".php";}

    /* Collect page details */
    $selectPage = $dbh->prepare("SELECT * FROM ".$connect['ext']."pages WHERE file=?");
    $selectPage->execute(array($file));

    /* Page file exists */
    if($selectPage->rowCount()==1){
	    $selectPage = $selectPage->FetchObject();
	    if(!$selectPage->template==0){
		if(is_dir($connect['root'].$selectPage->template)){

		    /* Custom template selected by settings */
		    $cmsTemplate = $selectPage->template;
		}else{
		    /* Fall back to default */
		    $cmsTemplate = $settings['siteTemplate'];
		}
	    }else{ 

		    /* Default template selected by settings */
		    $cmsTemplate = $settings['siteTemplate'];
	    }
    }else{

	    /* Default template selected by settings */
	    $cmsTemplate = $settings['siteTemplate'];
    }

    /* things to do outside admin.php */
    if(basename($_SERVER["SCRIPT_FILENAME"], '.php')==="index"){

	    /* Pageview system */
	    $checkDate = $dbh->prepare("SELECT visitorsPages FROM ".$connect['ext']."visitors WHERE visitorsDate=?");
	    $checkDate->execute(array(date("d-m-Y")));

	    if($checkDate->rowCount()==1){
		    $checkDate = $checkDate->fetchObject();
		    $insertDate = $dbh->prepare("UPDATE ".$connect['ext']."visitors SET visitorsPages=? WHERE visitorsDate=?");
		    $insertDate->execute(array(($checkDate->visitorsPages+1), date("d-m-Y")));
	    }else{
		    $insertDate = $dbh->prepare("INSERT INTO ".$connect['ext']."visitors (visitorsDate, visitorsPages) VALUES (?, 1)");
		    $insertDate->execute(array(date("d-m-Y")));
	    }

	    /* Include template */
	    require_once($connect['root'] . "Templates/" . $cmsTemplate . "/index.template.php");

    }

    /* Include Language package */
    require_once($connect['root'] . "Sources/Language/" . $settings['siteLanguage'] . "/index.php");

}
?>