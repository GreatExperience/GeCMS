<?php

	$query = $dbh->prepare("SELECT * FROM ".$connect['ext']."news_items WHERE id=?");
	$query->execute(array($_GET['article']));
	
	while($row = $query->fetchObject()){
	
		$selectCat = $dbh->prepare("SELECT name FROM ".$connect['ext']."news_cats WHERE id=?");
		$selectCat->execute(array($row->cat));
		$selectCat = $selectCat->fetchObject();
		
		echo "<div class='news article'>
		<div class='left'>";
		if($row->img != null)
		    echo "
			<div class='newsHeader'>
			    <h1>".$row->title."</h1>
			    <p class='newsDate'><img src='./Sources/Admin/images/icons/calendar.png' /> ".$row->dateDay." ". $language['month'.$row->dateMonth] . " " . $row->dateYear . "  <img src='./Sources/Admin/images/icons/book.png' class='iconTwo'/> ".$selectCat->name."</p>
			    <p class='newsDescription'>".$row->description."</p>
			    <img src='".$row->img."' class='newsImage' />
			</div>
			";
			
		else 
			echo "<h1 class='newsHeader'>".$row->title."</h2><p class='newsDate'><img src='./Sources/Admin/images/icons/calendar.png' /> ".$row->dateDay." ". $language['month'.$row->dateMonth] . " " . $row->dateYear . " <img src='./Sources/Admin/images/icons/book.png' /> ".$selectCat->name."</p>";
			echo "<div class='newsContent'>".$row->content."</div>";
		echo "
		</div>
		<div class='right'>
		    <h1>".$language['currentNews']."</h1>
		";
		
		$lastNews = $dbh->prepare('SELECT * FROM '.$connect['ext'].'news_items ORDER BY id DESC LIMIT 0, 6');
		$lastNews->execute();
		while($last = $lastNews->fetchObject()){
		    echo "<a href='./?page=".$_GET['page']."&article=".$last->id."'><h3>".$last->title."</h3></a>";
		}
		
		    echo '<h1>'.$language['cats'].'</h1>';
		    
		$catsQuery = $dbh->prepare('SELECT * FROM '.$connect['ext'].'news_cats');
		$catsQuery->execute();
		while($cats = $catsQuery->fetchObject()){
		    echo "<a href='./?page=".$_GET['page']."&cat=".$cats->id."'><button class='button'>".$cats->name."</button></a>";
		}
		
		echo "
		</div>
		<div style='clear:both;'></div>
<span class='st_sharethis_hcount' displayText='ShareThis'></span>
		<span class='st_facebook_hcount' displayText='Facebook'></span>
		<span class='st_twitter_hcount' displayText='Tweet'></span>
		<span class='st_linkedin_hcount' displayText='LinkedIn'></span>
		<span class='st_pinterest_hcount' displayText='Pinterest'></span>
		<span class='st_email_hcount' displayText='Email'></span>
		<script>var switchTo5x=false;</script>
		<script src=\"http://w.sharethis.com/button/buttons.js\"></script>
		<script>stLight.options({publisher: \"72c3dc34-487b-41e3-8074-a714c4ce8a4c\", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>  
		</div>";
	}
	
?>