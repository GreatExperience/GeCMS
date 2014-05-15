<?php 
	if(!$log)exit; 
		
	$newsQuery = "";
	$newsContent = "";
	$newsDescription = "";
	$newsImage = "";
	$newsTitle = "";
	$newsTags = "";
	$newsSave = "";
	
	$textTree = $language['news'];
	$textTreeSecond = "";
	$newsCat = "";
		
	if(isset($_GET['id'])){
	
		$query = $dbh->prepare("SELECT * FROM ".$connect['ext']."news_items WHERE id=?");
		$query->execute(array($_GET['id']));
		
		if($query->rowCount()==0)die("File lost!");
		
		$query = $query->fetchObject();
		
		$newsContent = $query->content;
		$newsDescription = $query->description;
		$newsImage = $query->img;
		$newsTitle = $query->title;
		$newsTags = $query->tags;
		$newsSave = "&saveFile=".$query->id;
		$newsCat = $query->cat;
		
		$textTree = $language['edit'];
		$textTreeSecond = "<span class='root sub'>".$query->title."</span>";
	}
?>
				<form id='theForm' action='admin.php?action=newsSave<?php echo $newsSave; ?>' method='post'>
					<header>
						<div class='header'>
							<span class='root'><?php echo $language['news']; ?></span>
							<span class='root sub'><?php echo $textTree; ?></span>
							<?php echo $textTreeSecond; ?>
							<button onclick='$("#theForm").submit()' class='button' style='float:right;margin-right:10px;margin-top:4px;'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/accept.png'>".$language['save']; ?></button>
						</div>
					</header>
					<div id='content'>
						<div>
							<textarea id='editor1' class='editor1' name='content' style='margin-top:10px;'><?php echo $newsContent; ?></textarea>
							<div class='box' style='margin-top:10px;'>
								<div class='title'>File settings</div>
								<div class='pad'>
									<table style='width:45%;float:left;'>
										<tr>
											<td style='width:100px;'><strong><?php echo $language['title']; ?></strong></td>
											<td colspan='3'>
												<input id='title' name='newsTitle' style='width:100%;' value='<?php echo $newsTitle; ?>' placeholder='<?php echo $language['title']; ?>' REQUIRED />
											</td>
										</tr>
										<tr>
											<td style='width:100px;'><strong><?php echo $language['description']; ?></strong></td>
											<td>
												<input id='title' name='newsDescription' style='width:100%;' value='<?php echo $newsDescription; ?>' placeholder='<?php echo $language['description']; ?>' REQUIRED />
											</td>
											<td style='width:75px;text-align:center;padding-left:10px;'><strong>tags</strong></td>
											</td>
											<td>
												<input id='title' name='newsTags' style='width:100%;' value='<?php echo $newsTags; ?>' placeholder='tags' REQUIRED />
											</td>
										</tr>
									</table>
									<table style='width:45%;float:right;'>
										<tr>
											<td style='width:100px;'><strong><?php echo $language['cat']; ?></strong></td>
											<td>
												<select style='width:90%' name='newsCat'>
													<?php 
														$query = $dbh->prepare("SELECT * FROM ".$connect['ext']."news_cats");
														$query->execute();
														while($row = $query->fetchObject()){
															if($row->id==$newsCat)
																echo "<option value='".$row->id."' SELECTED>".$row->name."</option>";
															else
																echo "<option value='".$row->id."'>".$row->name."</option>";
														}
													?>
												</select>
											</td>
										</tr>
										<tr>
											<td style='width:100px;'><strong>Image URL</strong></td>
											<td>
												<input id='title' name='newsImage' style='width:90%;' value='<?php echo $newsImage; ?>' placeholder='Image URL' />
											</td>
										</tr>
									</table>
									<div style='clear:both'></div>
								</div>
							</div>
						</form>
						<script>
							function getDocHeight() {
								var doc = document;
								return Math.max(
									Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight),
									Math.max(doc.body.offsetHeight, doc.documentElement.offsetHeight),
									Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
								);
							}
							tinymce.init({
								height:(getDocHeight()-360),
								selector: "#editor1",
								plugins: [
									"advlist autolink lists link image charmap print preview anchor",
									"searchreplace visualblocks code fullscreen",
									"insertdatetime media table contextmenu paste moxiemanager"
								],
								toolbar: "insertfile undo redo | styleselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
								theme_advanced_resizing: true
							});
						</script>
					</div>
				</form>