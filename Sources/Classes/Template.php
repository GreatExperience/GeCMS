<?php

class Template {
    
    /**
     * Get the default html tags defined within the database
     * @global type $settings
     * @param type $options
     * @return string
     */
    public static function getHtmlHeader($options = array()){
	
	/* Settings from Database */
	global $settings;
	
	$html = '<!DOCTYPE html>
<html>
<head>
<title>'.$settings['siteTitle'].'</title>
<meta name="description" content="'.$settings['siteDescription'].'">
<meta name="keywords" content="'.$settings['siteKeywords'].'">
<meta name="author" content="'.$settings['siteAuthor'].'">
<meta name="robots" content="'.$settings['siteRobots'].'">
	';
	echo $html;
	return true;
	
    }
    
    /**
     * Get the bottom section of the website
     * @return string
     */
    public static function getHtmlFooter(){
	echo '
</body>
</html>
';
	return true;
    }
    
    /**
     * Body header defined within the theme
     * @param type $options
     */
    public static function getBodyHeader($options = array()) {
	Theme::getBodyHeader($options);
    }
    
    /**
     * Body footer defined within the theme
     * @param type $options
     */
    public static function getBodyFooter($options = array()){
	Theme::getBodyFooter($options);
    }
    
    /**
     * Render navigation defined in database
     * @global type $connect
     * @global type $dbh
     * @param type $options
     */
    public static function renderNavigation($options = array()){
	global $connect, $dbh;
	/* Collecting menu objects */
	$menuObjects = $dbh->prepare("SELECT * FROM ".$connect['ext']."menu WHERE child=0 ORDER BY position");
	$menuObjects->execute();
	
	/* start navigation element */
	$menu = "<ul>";
	
	/* Fetch ALL menu objects */
	while($mainObject = $menuObjects->fetchObject()){
		$target = ($mainObject->menuTarget=='_SELF' ? '' : 'target="'.$mainObject->menuTarget.'"');

		$menu .= "
<li><a href='".$mainObject->menuHREF."' $target><div>".$mainObject->menuName."</div></a>";
		
		/* Query for dropdown */
		$menuSubObjects = $dbh->prepare("SELECT * FROM ".$connect['ext']."menu WHERE child=1 AND child_of=? ORDER BY position");
		$menuSubObjects->execute(array($mainObject->id));
		
		if($menuSubObjects->rowCount()>0)$menu .= "
<ul class='sub'>";
		
		/* Fetch sub menu objects */
		while($subObject = $menuSubObjects->fetchObject()){
			$menu .= "
<li><a href='".$subObject->menuHREF."' $target><div>".$subObject->menuName."</div></a></li>";
		
		}
		
		if($menuSubObjects->rowCount()>0)$menu .= "
</ul>";
		
		
		$menu .= "
</li>";
	}
	
	$menu .= "</ul>";
	return $menu;
    }
}
