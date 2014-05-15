<?php

	$query = $dbh->prepare("SELECT * FROM ".$connect['ext']."news_items WHERE id=?");
	$query->execute(array($_GET['article']));
	
	while($row = $query->fetchObject()){
	
		$selectCat = $dbh->prepare("SELECT name FROM ".$connect['ext']."news_cats WHERE id=?");
		$selectCat->execute(array($row->cat));
		$selectCat = $selectCat->fetchObject();
		
		$newsOutput .= "<div class='news article'>";
		if($row->img != null)
			$newsOutput .= "<table class='newsHeader'>
								<tr>
									<td class='headerOne'><img src='".$row->img."' class='newsImage' /></td>
									<td class='headerTwo'>
										<h1>".$row->title."</h1>
										<p class='newsDate'><img src='./Sources/Admin/images/icons/calendar.png' /> ".$row->dateDay." ". $language['month'.$row->dateMonth] . " " . $row->dateYear . "  <img src='./Sources/Admin/images/icons/book.png' class='iconTwo'/> ".$selectCat->name."</p>
										<p class='newsDescription'>".$row->description."</p>
									</td>
								</tr>
							</table>";
		else 
			$newsOutput .= "<h1 class='newsHeader'>".$row->title."</h2><p class='newsDate'><img src='./Sources/Admin/images/icons/calendar.png' /> ".$row->dateDay." ". $language['month'.$row->dateMonth] . " " . $row->dateYear . " <img src='./Sources/Admin/images/icons/book.png' /> ".$selectCat->name."</p>";
			$newsOutput .= "<div class='newsContent'>".$row->content."</div>";
		$newsOutput .= "</div>";
	}
	
?>