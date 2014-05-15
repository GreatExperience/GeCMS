<?php 
	/* Anti hack */
	if(!$log)exit; 
	
	/* Overwrite file? */
	if(isset($_GET['file'])&&isset($_GET['root']))
	    {$overwrite=true;}else{$overwrite=false;}
	    
//TODO: Create php inside editorHTML.php	
	    
	/* Timebased fix : Not yet support for create files */
	if( ! isset($_GET['file']) ){
	    $cmsError = $language['fileMissing'];
	    include $connect['root'] . "Sources/Admin/404.php";
	    exit;
	}
	
	/* Return = Media when there is no return written */
	if( ! isset($_GET['return'] ))
	    $_GET['return'] = "media";
	
	/* Select page settings */
	$select = $dbh->prepare("SELECT * FROM ".$connect['ext']."pages WHERE file=?");
	$select->execute(array($_GET['file']));
	
	/* check if page settings exists */
	if($select->rowCount()==1){
	
		/* Exists = fetch options */
		$fileOptions = $select->fetchObject();
	}else{
		
		/* Insert empty file settings if there are no settings */
		$insert = $dbh->prepare("INSERT INTO ".$connect['ext']."pages (file, meta, template, title) VALUES (?, 1, 1, '')");
		$insert->execute(array($_GET['file']));
		
		/* fetch options & Select */
		$select = $dbh->prepare("SELECT * FROM ".$connect['ext']."pages WHERE file=?");
		$select->execute(array($_GET['file']));
		$fileOptions = $select->fetchObject();
	}
		
	
?>
				<form id='theForm' action='admin.php?action=savePage&return=<?php echo $_GET['return']; ?>&root=<?php echo $_GET['root']; ?>&edit=true&file=<?php echo $_GET['file']; ?>' method='post'>
					<header>
						<div class='header'>
							<span class='root'><?php echo $language['editor']; ?></span>
							<span class='root sub'>HTML</span>
							<span class='root sub' title='<?php echo $_GET['root'] . "/" . $_GET['file']; ?>'><?php echo $_GET['file']; ?></span>
							<button onclick='$("#theForm").submit()' class='button blue' style='float:right;margin-right:10px;margin-top:4px;'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/accept.png'>".$language['save']; ?></button>
							<button onclick='$("#theForm").get(0).setAttribute("action", "admin.php?action=savePage&return=editorHTML&root=<?php echo urlencode($_GET['root']); ?>&edit=true&file=<?php echo $_GET['file']; ?>"); $("#theForm").submit()' class='button' style='float:right;margin-right:10px;margin-top:4px;'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/accept.png'>".$language['save'] . " " . $language['andReturn']; ?></button>
						</div>
					</header>
					<div id='content'>
						<div style='margin-top:10px;'>
							<textarea id='editor1' class='editor1' name='content' style='margin-top:10px;'><?php if($overwrite){include $_GET['root']."/".$_GET['file']; } ?></textarea>
							<div class='box' style='margin-top:10px;'>
								<div class='title'>File settings</div>
								<div class='pad'>
									<table style='width:45%;float:left;'>
										<tr>
											<td style='width:175px;'><strong><?php echo $language['pagetitle']; ?></strong></td>
											<td>
												<input id='title' name='pageTitle' style='width:100%;' value='<?php echo $fileOptions->title ?>' REQUIRED />
											</td>
										</tr>
										<tr>
											<td style='width:175px;'><strong><?php echo $language['menuSide']; ?></strong></td>
											<td>
											    <select name='sideMenu' style='width:100%'>
												<?php
												    switch($fileOptions->menu){
													case 0:
													    echo '
														<option value="0" SELECTED>'.$language['menuSideNo'].'</option>
														<option value="1">'.$language['menuSideRight'].'</option>
														<option value="2">'.$language['menuSideLeft'].'</option>
													    ';
													    break;
													case 1:
													    echo '
														<option value="0">'.$language['menuSideNo'].'</option>
														<option value="1" SELECTED>'.$language['menuSideRight'].'</option>
														<option value="2">'.$language['menuSideLeft'].'</option>
													    ';
													    break;
													case 2:
													    echo '
														<option value="0">'.$language['menuSideNo'].'</option>
														<option value="1">'.$language['menuSideRight'].'</option>
														<option value="2" SELECTED>'.$language['menuSideLeft'].'</option>
													    ';
													    break;
												    }
												?>
											    </select>
											</td>
										</tr>
									</table>
									<table style='width:45%;float:right;'>
										<tr>
											<td style='width:150px;'><strong><?php echo $language['metaSettings']; ?></strong></td>
											<td>
												<select style='width:100%;' name='meta'>
													<option>Default</option>
												</select>
											</td>
										</tr>
										<tr>
											<td style='width:150px;'><strong><?php echo $language['template']; ?></strong></td>
											<td>
												<select style='width:100%;' name='pageTemplate'>
													<option value='1'><?php echo $language['pageDefaultIn']; ?></option>
													<?php
														if ($handle = opendir("./Templates/")) {
															while (false !== ($entry = readdir($handle))){
																if($entry!="."&&$entry!=".."){
																	echo "<option>".$entry."</option>";
																}
															}
														}
													?>
												</select>
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
							if(tinymce.init({
								height:(getDocHeight()-360),
								selector: "#editor1",
								plugins: [
									"advlist autolink lists link image charmap print preview anchor",
									"searchreplace visualblocks code fullscreen",
									"insertdatetime media table contextmenu paste textcolor"
								],
								toolbar: "insertfile undo redo | styleselect fontsizeselect forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
								file_browser_callback : myFileBrowser,
							}))
						    
						    function myFileBrowser (field_name, url, type, win) {
							window.fileInput = field_name;
							window.hideIt = win;

							/* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry
							   the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
							   These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */

							var cmsURL = "./admin.php?action=displayMedia&layout=false&root=./Media"
							if (cmsURL.indexOf("?") < 0) {
							    //add the type as the only query parameter
							    cmsURL = cmsURL + "?type=" + type;
							}
							else {
							    //add the type as an additional query parameter
							    // (PHP session ID is now included if there is one at all)
							    cmsURL = cmsURL + "&dialog=&type=" + type;
							}

							tinyMCE.activeEditor.windowManager.open({
							    file : cmsURL,
							    title : '<?php echo $language['mediaInsert']; ?>...',
							    width : (document.body.clientWidth / 100 ) * 80,  // Your dimensions may differ - toy around with them!
							    height : (document.body.clientHeight / 100 ) * 80,
							    resizable : "yes",
							    inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
							    close_previous : "no"
							}, {
							    window : win,
							    input : field_name,
							});
							return false;
						      }

						    window.fileNamespace = "";
						    window.fileInput = "Not set";
						     window.hideIt = "set";
						</script>
					</div>
				</form>