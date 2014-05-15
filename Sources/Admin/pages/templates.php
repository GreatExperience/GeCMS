<?php 
	if(!$log==true)exit;
	
	/* Select default template */
	$default = $dbh->prepare("SELECT value FROM ".$connect['ext']."settings WHERE name='siteTemplate'");
	$default->execute();
	$default = $default->fetchObject();
	
	/* Check if able to open directory */
	if ($handle = opendir("./Templates/")) {
		
		/* Use global variable */
		$rows = "";
		$templates = 0;

		/* This is the correct way to loop over the directory. */
		while (false !== ($entry = readdir($handle))) {
			if($entry!="."&&$entry!=".."){
			
				/* Get Preview image */
				if(file_exists("./Templates/" . $entry . "/pre.png")){
					$img = "<img src='./Templates/" . $entry . "/pre.png' />";
				}else{
					$img = "<div style='width:125px;height:125px;line-height:125px;border:1px solid #bbb;background:#ccc;text-align:center;font-size:64px;color:#888;font-weight:bold;'>?</div>";
				}
				if(file_exists("./Templates/" . $entry . "/options.template.php")){
					$info = file_get_contents("./Templates/" . $entry . "/options.template.php");
				}else{
					$info = "";
				}
				
				if($default->value==$entry){
					$buttons = "
										<button class='button yellow' style='width:100%;margin-top:5px;'>".$language['templateIsDefault']."</button>
										<br />
										<a href='./admin.php?action=media&root=./Templates/".$entry."'><button class='button' style='width:100%'>".$language['templateEdit']."</button></a>";
				}else{
					$buttons = "
										<button onclick='$(\"#asdefault".$entry."\").fadeIn();' class='button blue' style='width:100%;margin-top:5px;'>".$language['templateSetDefault']."</button>
										<div class='modal' id='asdefault".$entry."'>
											<div class='title'> ". $language['template'] . " " . $entry . " " . $language['templateSetDefault']."</div>
												<form action='./admin.php?action=saveDefault&template=".$entry."' method='post'>
													<div class='cont'>
														<div class='headImage'></div>
														<p style='width:90%;margin:0 auto;margin-top:25px;'>".$language['newTemplateDefault']."</p>
														<table class='table' style='width:90%;margin:0 auto;margin-top:25px;border:0;'>
															<tr>
																<td style='width:175px;'>".$language['oldTemplate']."</td>
																<td>".$default->value."</td>
															</tr>
															<tr>
																<td>".$language['newTemplate']."</td>
																<td>".$entry."</td>
															</tr>
														</table>
													</div>
													<input type='submit' class='submit' value='".$language['templateSetDefault']."'/>
												</form>
												<button class='button' onclick='$(\"#asdefault".$entry."\").fadeOut();'>".$language['cancel']."</button>
											</div>
										</div>
										<br />
										<a href='./admin.php?action=media&root=./Templates/".$entry."'><button class='button' style='width:100%'>".$language['templateEdit']."</button></a>
										<br />
										<button onclick='$(\"#deletetemplate".$entry."\").fadeIn();' class='button red' style='width:100%'>".$language['templateDelete']."</button>
										<div class='modal' id='deletetemplate".$entry."'>
											<div class='title'> " . $entry . " ". $language['delete'] . "</div>
												<div class='cont'>
													<div class='headImage'></div>
													<p style='width:90%;margin:0 auto;margin-top:40px;font-size:14px;'>".$language['deleteOne']." ".$entry." ".$language['deleteTwo']."</p>
												</div>
												<a href='./admin.php?action=deleteTemplate&template=".$entry."'><button class='button red' style='margin-right:10px;'>".$language['delete']."</button></a>
											<button class='button' onclick='$(\"#deletetemplate".$entry."\").fadeOut();'>".$language['cancel']."</button>
										</div>
										";
				}
				
				$row .= "
					<div class='box' style='margin-top:10px;'>
						<div class='title'>".$entry." ".$language['template']."</div>
						<div style='padding:5px;'>
							<table style='width:100%;border-collapse:collapse;'>
								<tr>
									<td style='width:135px;'>".$img."</td>
									<td style='text-align:left;vertical-align:top;'>".$info."</td>
									<td style='width:150px;vertical-align:top;text-align:Center;border-left:1px solid #bbb;padding-left:7px;'>
										<strong><img src='./Sources/Admin/images/icons/bullet_wrench.png' style='position:relative;top:3px;'/>".$language['options'].":</strong>
										".$buttons."
									</td>
								</tr>
							</table>
						</div>
					</div>";
					
				$templates++;
			}
		}
	}
		
	/* Global variables */
	$fileId = 0;
	$packagesAmount = 0;
	$packageModals = "";
	$packageEcho = "
		<table class='table' style='width:90%;margin:0 auto;'>
			<tr>
				<th style='text-align:center;'>".$language['name']."</th>
				<th style='text-align:center;'>Actions</th>
			</tr>
	";
		
	/* Checking packages */
	if ($handle = opendir("./Packages/Templates/")) {
		/* This is the correct way to loop over the directory. */
		while (false !== ($entry = readdir($handle))) {
			if($entry!="."&&$entry!=".."){
				if(checkfiletype( "./Packages/Templates/" . $entry )=="ZIP file"){
					$packagesAmount++;
					
					$packageEcho .= "
						<tr>
							<td title='".fileSizeCalc( "./Packages/Templates/" . $entry ).", ".fileperms( "./Packages/Templates/" . $entry )."'>".str_replace(".zip", "", $entry)."</td>
							<td>
								<button class='button red' onclick='$(\"#deleteTemplate_modal_file".$fileId."\").fadeIn(300);'>".$language['delete']."</button>
								<a href='./admin.php?action=zipUnpack&root=./Packages/Templates/&destination=./Templates/&return=templates&file=".$entry."'><button class='button blue'>".$language['install']."</button></a>
							</td>
						</tr>
					";
					$packageModals .= "
						<div class='modal' id='deleteTemplate_modal_file".$fileId."'>
							<div class='title'>".$language['template']." ".$language['delete']."</div>
								<div class='cont'>
									<div class='headImage'></div>
									<p style='text-align:center;'>".$language['deleteOne']." ".$entry." ".$language['deleteTwo']."</p>
									<table class='ignore' style='width:90%;margin:0 auto;text-align:left;'>
										<tr>
											<td>".$language['file']."</td>
											<td>
												".$entry."
											</td>
										</tr>
										<tr>
											<td>".$language['fileType']."</td>
											<td>
												".checkfiletype("./Packages/Templates/" . $entry)."
											</td>
										</tr>
										<tr>
											<td>".$language['fileSize']."</td>
											<td>
												".fileSizeCalc("./Packages/Templates/" . $entry)."
											</td>
										</tr>
										<tr>
											<td>".$language['filePermissions']."</td>
											<td>
												".fileperms("./Packages/Templates/" . $entry)."
											</td>
										</tr>
										<tr>
											<td>".$language['fileLastEdit']."</td>
											<td>
												".date ("d M Y H:i:s", filemtime("./Packages/Templates/" . $entry))."
											</td>
										</tr>
									</table>
							</div>
							<a href='./admin.php?action=deletePage&root=./Packages/Templates&file=".$entry."&return=".$_GET['action']."'><button class='button red' style='margin-right:10px;'>".$language['delete']."</button></a>
							<button class='button' onclick='$(\"#deleteTemplate_modal_file".$fileId."\").fadeOut(300);'>".$language['cancel']."</button>
						</div>
					";
					$fileId++;
				}
			}
		}
		
		/* No packages? Display error */
		if( ! $packagesAmount > 0 )
			$packageEcho .= "<tr><td colspan='2'>".$language['noPackages']."</td></tr>";
	}
	
	$packageEcho .="</table>";
?>
				<header>
					<div class='header'>
						<button class='root'><?php echo $language['templates']; ?></button>
						<button class='root sub'><?php echo $templates; ?></button>
						<button class='button blue' style='float:right;margin-right:10px;margin-top:4px;' onclick='$("#newPage_modal").fadeIn();'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/cart_add.png'>".$language['downloadTemplates']; ?></button>
						<button class='button' onclick='$("#installTemplates").fadeIn();' style='float:right;margin-right:10px;margin-top:4px;' onclick='$("#newPage_modal").fadeIn();'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/package_go.png'>"; ?><?php echo $language['templateInstall'] . " (" . $packagesAmount . ")";?></button>
					</div>
				</header>
				<div id='content'>
					<?php echo $row; ?>
					<div class='modal' id='installTemplates'>
						<div class='title'><?php echo $language['templateInstall']; ?></div>
						<div class='cont'>
							<div style='padding-top:10px;'>
								<?php echo $packageEcho . $packageModals; ?>
							</div>
						</div>
						<button class='button' onclick='$("#installTemplates").fadeOut();' style='margin-right:10px;'><?php echo $language['cancel']; ?></button>
						<button class='button blue' onclick='$("#upload_dialog_templatePackage").fadeIn();' style='margin-right:10px;'><?php echo $language['template'] . " " . $language['uploading']; ?></button>
					</div>
					<?php echo uploadFileForm("./Packages/Templates/", "templatePackage") ?>
				</div>