<?php 
	if(!$log==true)exit;

	$news = $dbh->prepare("SELECT title, dateDay, dateMonth, dateYear, id, cat FROM ".$connect['ext']."news_items ORDER BY id DESC");
	$news->execute();
	$newsOutput = "<table class='table' style='width:100%;'><tr><th style='padding-left:10px;'>".$language['name']."</th><th>".$language['cat']."</th><th>".$language['date']."</th><th style='text-align:center;width:80px;'>Actions</th></tr>";
	$newsOrder = "nodateYet";
	
	while($row = $news->fetchObject()){
	
		/* order by month */
		if($row->dateMonth.$row->dateYear!=$newsOrder){
			 $newsOutput .= "<tr class='light'><td colspan='4'>".$language['month'.$row->dateMonth]. " " .$row->dateYear."</td></tr>";
			 $newsOrder = $row->dateMonth.$row->dateYear;
		}
		
		/* Get cat name */
		$getCat = $dbh->prepare("SELECT * FROM ".$connect['ext']."news_cats WHERE id=?");
		$getCat->execute(array($row->cat));
		if($getCat->rowCount()==1){
			$getCat = $getCat->fetchObject();
			$getCat = $getCat->name;
		}else{
			$getCat = "Error: No cat selected!";
		}
		
		$newsOutput .= "<tr><td>".$row->title."</td><td>".$getCat."</td><td>".$row->dateDay. " " . $language['month'.$row->dateMonth] . " " . $row->dateYear."</td><td style='text-align:center;'>
							<img src='".$connect['url']."/Sources/Admin/images/icons/eye.png' title='".$language['eye']."'>
							<a style='text-decoration:none;' />
								<a href='./admin.php?action=newsEditor&id=".$row->id."'><img src='".$connect['url']."/Sources/Admin/images/icons/page_edit.png' title='".$language['edit']."'></a>
							</a>
							<img src='".$connect['url']."/Sources/Admin/images/icons/page_delete.png' title='".$language['delete']."' onclick='$(\"#deletenews".$row->id."\").fadeIn();' >
							<div class='modal' id='deletenews".$row->id."'>
								<div class='title'>".$language['delete']." ".$row->title."</div>
									<div class='cont'>
										<div class='headImage'></div>
										<p>".$language['deleteOne']." ".$row->title." ".$language['deleteTwo']."</p>
									</div>
								<a href='./admin.php?action=./database/delete.db&id=".$row->id."&return=newsManager&table=news_items'><button class='button red' style='margin-right:10px;'>".$language['delete']."</button></a>
								<button class='button' onclick='$(\"#deletenews".$row->id."\").fadeOut();'>".$language['cancel']."</button>
							</div>
							</td></tr>";
	}
	
	$cats = $dbh->prepare("SELECT * FROM ".$connect['ext']."news_cats ORDER BY position");
	$cats->execute();
	$catsOutput = "<table class='table' style='width:100%;'><tr><th style='padding-left:10px;'>".$language['name']."</th><th style='width:50px;'>".$language['items']."</th><th style='width:50px;'>".$language['menuPosition']."</th><th></th><th style='width:160px;text-align:right;padding-right:10px;'>Actions</th></tr>";
	
	while($row = $cats->fetchObject()){
	
		/* Selecting OTHER cats */
		$alternativeCats = $dbh->prepare("SELECT * FROM ".$connect['ext']."news_cats");
		$alternativeCats->execute();
		$alternativeOutput = "";
		while($alternative = $alternativeCats->fetchObject()){
			if($row->id!=$alternative->id){
				$alternativeOutput .= "<option value='".$alternative->id."'>".$alternative->name."</option>";
			}
		}
		
		$newsByCat = $dbh->prepare("SELECT * FROM ".$connect['ext']."news_items WHERE cat=?");
		$newsByCat->execute(array($row->id));
		$newsImg = "";
		if(!$newsByCat->rowCount()>=1){
			$newsImg = "<img src='".$connect['url']."/Sources/Admin/images/icons/page_delete.png' title='".$language['delete']."' onclick='$(\"#deletecat".$row->id."\").fadeIn();' style='float:right;' >";
		}else{
			$newsImg = "<button class='button' style='float:right;padding:2px;margin:-3px;margin-right:2px;' onclick='$(\"#movecat".$row->id."\").fadeIn();'>".$language['catMove']."</button>";
		}
		$amount = $newsByCat->rowCount();
		
		$catsOutput .= "
			<tr>
				<form action='./admin.php?action=newsSaveCatEdit&id=".$row->id."' method='post'>
					<td style='padding-left:10px;'><input type='text' value='".$row->name."' style='font-weight:normal;width:85%;' name='editName' id='editName".$row->id."' DISABLED REQUIRED /></td>
					<td>".$amount."</td>
					<td><input type='text' value='".$row->position."' style='width:100%;' name='editPosition' id='editPosition".$row->id."' DISABLED REQUIRED /></td>
					<td style='width:70px;'><button class='button' style='display:none;' id='saveCat".$row->id."'>Save</button></td>
				</form>
				<td>
					<a style='text-decoration:none;' />
						<img src='".$connect['url']."/Sources/Admin/images/icons/page_edit.png' title='".$language['edit']."' style='float:right;margin:2px;' onclick='document.getElementById(\"editName".$row->id."\").disabled=false;document.getElementById(\"editPosition".$row->id."\").disabled=false;$(\"#saveCat".$row->id."\").fadeIn();' >
					</a>
					<img src='".$connect['url']."/Sources/Admin/images/icons/eye.png' title='".$language['eye']."' style='float:right;margin:2px;'>
					".$newsImg."
					<div class='modal' id='deletecat".$row->id."'>
								<div class='title'>".$language['delete']." ".$row->name."</div>
									<div class='cont'>
										<div class='headImage'></div>
										<p style='text-align:center;'>".$language['deleteOne']." ".$row->name." ".$language['deleteTwo']."</p>
									</div>
								<a href='./admin.php?action=./database/delete.db&id=".$row->id."&return=newsManager&table=news_cats'><button class='button red' style='margin-right:10px;'>".$language['delete']."</button></a>
								<button class='button' onclick='$(\"#deletecat".$row->id."\").fadeOut();'>".$language['cancel']."</button>
					</div>
					<div class='modal' id='movecat".$row->id."'>
						<div class='title'>".$language['catMove']."</div>
							<form action='./admin.php?action=newsMoveItems&id=".$row->id."' method='post'>
								<div class='cont' style='text-align:center;'>
									<div class='headImage'></div>
									<p>".$language['catMoveText']."</p>
									<select name='new' style='width:80%;margin:0 auto;margin-top:10px;'>
										".$alternativeOutput."
									</select>
								</div>
								<button class='button blue' style='margin-right:10px;'>".$language['catMove']."</button>
							</form>
							<button class='button' onclick='$(\"#movecat".$row->id."\").fadeOut();'>".$language['cancel']."</button>
					</div>
				</td>
			</tr>
		";
	}
	$catsOutput .= "</table>";
	$newsOutput .= "</table>";
?>
				<header>
					<div class='header'>
						<button class='root'><?php echo $language['news']; ?></button>
						<a href='./admin.php?action=newsEditor'><button class='button blue' style='float:right;margin-right:10px;margin-top:4px;' onclick='$("#newPage_modal").fadeIn();'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/page_add.png'>".$language['news'] . " " . $language['create']; ?></button></a>
						<button class='button' onclick='$("#catDialog").fadeIn();' style='float:right;margin-right:10px;margin-top:4px;'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/folder_edit.png'>"; ?><?php echo $language['cats'] . " " . $language['manage']; ?></button>
						<button class='button' onclick='$("#aboutNewsDialog").fadeIn();' style='float:right;margin-right:10px;margin-top:4px;'><img src='./Sources/Admin/images/icons/anchor.png' /><?php echo $language['newsAbout']; ?></button>
					</div>
				</header>
				<div id='content'>
					<div class='modal' id='catDialog'>
						<div class='title'><?php echo $language['cats'] . " " . $language['manage']; ?></div>
						<div class='cont'>
							<div style='padding:10px;'>
								<form action='./admin.php?action=newsAddCat' method='post'>
									<button class='button blue'><?php echo $language['create']; ?></button>
									<input type='text' name='newsCat' style='width:375px;margin-bottom:10px;' placeholder='<?php echo $language['title']; ?>' REQUIRED />
								</form>
								<?php echo $catsOutput; ?>
							</div>
						</div>
						<button class='button' onclick='$("#catDialog").fadeOut();' style='margin-right:10px;'><?php echo $language['cancel']; ?></button>
					</div>
					<div class='modal' id='aboutNewsDialog'>
						<div class='title'><?php echo $language['newsAbout']; ?></div>
						<div class='cont'>
							<div style='padding:10px;'>
								<?php echo $language['newsAboutText']; ?>
							</div>
						</div>
						<button class='button' onclick='$("#aboutNewsDialog").fadeOut();' style='margin-right:10px;'><?php echo $language['cancel']; ?></button>
					</div>
					<?php echo $newsOutput; ?>
				</div>
<?php if(isset($_GET['displayCats']))echo "<script>document.getElementById('catDialog').style.display='block';</script>"; ?>