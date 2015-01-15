<?php

class Page {
    
    static function render($controller, $options = array()){
	global $connect, $settings, $selectPage, $language, $dbh;
	
	if(file_exists($connect['root'] . "Sources/Pages/" . $controller . ".php"))
	    $storage = file_get_contents($connect['root'] . "Sources/Pages/" . $controller . ".php");
	else
	    $storage = "<h1 style='text-align:center;padding:30px;'>" . $language['404e'] . "</h1>";
	
	/* Check if news exists */
	if (strpos($storage, '[#news]') !== FALSE){
		require_once($connect['root'] . "/Sources/News/index.news.php");
		$storage = str_replace("[#news]", $newsOutput , $storage);
	}

	/* Check if newsHeader exists */
	if (strpos($storage, '[#newsHeader]') !== FALSE){
		require_once($connect['root'] . "/Sources/News/index.news.php");
		$storage = str_replace("[#newsHeader]", $newsOutput , $storage);
	}

	/* Collect plugins */
	if ($handle = opendir("./Plugins/")) {
	    while (false !== ($entry = readdir($handle))) {
		if($entry!="."&&$entry!=".."){
		    if(file_exists("./Plugins/".$entry."/index.plugin.php")){
			$plugin = file_get_contents("./Plugins/".$entry."/index.plugin.php");
			$storage = str_replace("[#".$entry."]", $plugin , $storage);
		    }
		}
	    }
	}
	
	if(!isset($selectPage->menu))$selectPage->menu = 0;

	if($selectPage->menu==0){
	    echo eval(" ?> ".$storage);
	}elseif($selectPage->menu==1){
	    echo "<table class='layTable'><tr><td class='main'>";
	    eval(" ?> ".$storage."");
	    echo "</td><td class='sub'>".$settings['siteMenu']."</td></table>";
	}else{
	    echo "<table class='layTable'><tr><td class='sub'>".$settings['siteMenu']."</td><td class='main'>";
	    eval(" ?> ".$storage."");
	    echo "</td></table>";
	}
	
	return true;
    }
}
