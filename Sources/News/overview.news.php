<?php
    $offset = 0;  
    if(isset($_GET['offset']))$offset = intval($_GET['offset']);
    
    $end = 10;
    
    /* Catagory selected check */
    if(isset($_GET['cat'])){
	
	/* Get news items depends on category */
	$query = $dbh->prepare("SELECT * FROM ".$connect['ext']."news_items WHERE cat=:cat ORDER BY id DESC LIMIT :offset, :end");
	$query->bindParam(':cat', $_GET['cat']);
	$query->bindParam(':offset', $offset, PDO::PARAM_INT);
	$query->bindParam(':end', $end, PDO::PARAM_INT);
	$query->execute();
	
	$amountQuery = $dbh->prepare("SELECT id FROM ".$connect['ext']."news_items WHERE cat=:cat");
	$amountQuery->bindParam(':cat', $_GET['cat']);
	$amountQuery->execute();
    }else{
	
	/* get news items (all) */
	$query = $dbh->prepare("SELECT * FROM ".$connect['ext']."news_items ORDER BY id DESC LIMIT :offset,:end");
	$query->bindParam(':offset', $offset, PDO::PARAM_INT);
	$query->bindParam(':end', $end, PDO::PARAM_INT);
	$query->execute();

	$amountQuery = $dbh->prepare("SELECT id FROM ".$connect['ext']."news_items");
	$amountQuery->execute();

    }
    
    $amount = $amountQuery->rowCount();
    $pages = 1;
    while($amount > 9){
	$pages++;
	$amount-=10;
    }
    
    /* styling for templates */
    $newsOutput .= "<div class='news newsOverview'>";
    
    while($row = $query->fetchObject()){
	
	$selectCat = $dbh->prepare("SELECT name FROM ".$connect['ext']."news_cats WHERE id=?");
	$selectCat->execute(array($row->cat));
	$selectCat = $selectCat->fetchObject();
	
	$img = '';
	if($row->img != null)
	    $img = "<img src='".$row->img."' class='newsImage' />";
	
	$newsOutput .= "
	    <table class='newsHeader'>
		<tr>
			<td class='headerOne'>".$img."</td>
			<td class='headerTwo'>
				<a href='?page=".$_GET['page']."&article=".$row->id."' style='color:#333;'><h1>".$row->title."</h1></a>
				<p class='newsDate'><img src='./Sources/Admin/images/icons/calendar.png' /> ".$row->dateDay." ". $language['month'.$row->dateMonth] . " " . $row->dateYear . "  <img src='./Sources/Admin/images/icons/book.png' class='iconTwo'/> ".$selectCat->name."</p>
				<p class='newsDescription'>".$row->description."</p>
			</td>
		</tr>
	    </table>
	    <hr />
	";
	
    }
    
    /* end styling */
    $newsOutput .= "</div>";
    
    $pageOffsetModifier = 0;
    while($pages > 0){

	$urlOffset = ($pages > 1 ? '&offset='.($pages*10-10) : '');
	$urlOffset .= (isset($_GET['cat']) ? '&cat='.$_GET['cat'] : '');

	$url = '?page='.$_GET['page'].$urlOffset;
	$disabled = (isset($_GET['offset'])&&$pages*10==$_GET['offset'] ? ' DISABLED' : '');
	$newsOutput .= '<a href="'.$url.'"><button class="button" style="float:right;margin-left:2px;"'.$disabled.'>'.$pages.'</button></a>';
	$pages--;
    }
?>