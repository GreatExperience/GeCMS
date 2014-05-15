<?php 
	if(!$log)exit; 
	
	if(isset($_POST['content'])&&isset($_POST['content'])&&isset($_POST['newsTitle'])&&isset($_POST['newsDescription'])&&isset($_POST['newsTags'])&&isset($_POST['newsImage'])){
	
		if(!empty($_POST['content'])&&!empty($_POST['newsTitle'])&&!empty($_POST['newsDescription'])&&!empty($_POST['newsTags'])){
			if(isset($_GET['saveFile'])){
				$query = $dbh->prepare("UPDATE ".$connect['ext']."news_items SET content=? WHERE id=?");
				$query->execute(array($_POST['content'], $_GET['saveFile']));
				
				$query = $dbh->prepare("UPDATE ".$connect['ext']."news_items SET tags=? WHERE id=?");
				$query->execute(array($_POST['newsTags'], $_GET['saveFile']));
				
				$query = $dbh->prepare("UPDATE ".$connect['ext']."news_items SET description=? WHERE id=?");
				$query->execute(array($_POST['newsDescription'], $_GET['saveFile']));
				
				$query = $dbh->prepare("UPDATE ".$connect['ext']."news_items SET title=? WHERE id=?");
				$query->execute(array($_POST['newsTitle'], $_GET['saveFile']));
				
				$query = $dbh->prepare("UPDATE ".$connect['ext']."news_items SET img=? WHERE id=?");
				$query->execute(array($_POST['newsImage'], $_GET['saveFile']));
				
				$query = $dbh->prepare("UPDATE ".$connect['ext']."news_items SET cat=? WHERE id=?");
				$query->execute(array($_POST['newsCat'], $_GET['saveFile']));
				
			}else{
				$query = $dbh->prepare("INSERT INTO ".$connect['ext']."news_items (description, tags, title, img, content, cat, dateDay, dateMonth, dateYear) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$query->execute(array($_POST['newsDescription'], $_POST['newsTags'], $_POST['newsTitle'], $_POST['newsImage'], $_POST['content'], $_POST['newsCat'], date("d"), date("m"), date("Y")));
			}
			echo "<h1>Succes! JavaScript should send you back right now!</h1><script>window.location='./admin.php?action=newsManager&note=".urlencode($language['succesNews'])."';</script>";
		}else{
			echo "<h1>Thats an error. JavaScript should send you back right now!</h1><script>window.location='./admin.php?action=newsEditor&note=".urlencode($language['fillFields'] . "<br /> Content, Title,<br /> Description, tags")."';</script>";
		}
		
	}else{
		echo "Hacking attempt";
	}
	
?>