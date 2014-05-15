<?php
	/* Collecting menu objects */
	$menuObjects = $dbh->prepare("SELECT * FROM ".$connect['ext']."menu WHERE child=0 ORDER BY position");
	$menuObjects->execute();
	
	/* menu variable */
	$menu = "<ul>";
	
	/* Fetch ALL menu objects */
	while($mainObject = $menuObjects->fetchObject()){
		
		$menu .= "
<li><a href='".$mainObject->menuHREF."' target='".$mainObject->menuTarget."'><div>".$mainObject->menuName."</div></a>";
		
		/* Query for dropdown */
		$menuSubObjects = $dbh->prepare("SELECT * FROM ".$connect['ext']."menu WHERE child=1 AND child_of=? ORDER BY position");
		$menuSubObjects->execute(array($mainObject->id));
		
		if($menuSubObjects->rowCount()>0)$menu .= "
<ul class='sub'>";
		
		/* Fetch sub menu objects */
		while($subObject = $menuSubObjects->fetchObject()){
			$menu .= "
<li><a href='".$subObject->menuHREF."' target='".$subObject->menuTarget."'><div>".$subObject->menuName."</div></a></li>";
		
		}
		
		if($menuSubObjects->rowCount()>0)$menu .= "
</ul>";
		
		
		$menu .= "
</li>";
	}
	
	$menu .= "</ul>";
	echo $menu;
	

?>