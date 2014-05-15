<?php 
	if(!$log==true)exit;
	
	
	
	/* Global variables */
	$fileId = 0;
	$outdated = 0;
	$pluginsOutput = "
		<table class='table' style='width:100%;'>
			<tr>
				<th style='width:16px;'></th>
				<th style='padding-left:10px;'>".$language['name']."</th>
				<th>".$language['author']."</th>
				<th>Code</th>
				<th>".$language['pluginVersion']."</th>
				<th style='text-align:center;width:100px;'>Actions</th>
			</tr>
	";
		
	/* Checking packages */
        $fileIds = 0;
        $dialogs = "";
	if ($handle = opendir("./Plugins/")) {
		/* This is the correct way to loop over the directory. */
		while (false !== ($entry = readdir($handle))) {
			if($entry!="."&&$entry!=".."){
				if(file_exists("./Plugins/".$entry."/options.plugin.php"))
					include "./Plugins/".$entry."/options.plugin.php";
				else {
					$pluginName = $entry;
					$pluginAuthor = "Unknown";
					$pluginSupport = "Unknown";
					$pluginVersion = "Unknown";
				}
				
				if(file_exists("./Plugins/".$entry."/icon.png"))
					$pluginIMG = "<img src='./Plugins/".$entry."/icon.png' style='width:16px;height:16px;position:relative;top:1px;' />";
				else {
					$pluginIMG = "<img src='./Sources/Admin/images/icon/basket.png' style='position:relative;top:1px;' />";
				}
				
				if($pluginSupport !== $settings['cmsVersion']){
					$pluginStyle = " style='box-shadow: 0px 0px 50px 50px lightred;background:red;color:red;' ";
					$outdated++;
				}else 
					$pluginStyle = "";
					
				$pluginsOutput .= "
					<tr".$pluginStyle.">
						<td>".$pluginIMG."</td>
						<td>".$pluginName."</td>
						<td>".$pluginAuthor."</td>
						<td><input DISABLED value='[#".$entry."]'></td>
						<td>".$pluginVersion."</th>
						<td style='text-align:center;'>
							<a href='admin.php?action=pluginDisplay&plugin=".$entry."'><img src='".$connect['url']."/Sources/Admin/images/icons/basket_edit.png' title='".$language['edit']."'></a>
							<a href='admin.php?action=media&root=./Plugins/".$entry."'><img src='".$connect['url']."/Sources/Admin/images/icons/basket_go.png' title='".$language['files']."'></a>
							<img src='".$connect['url']."/Sources/Admin/images/icons/basket_delete.png' title='".$language['delete']."' onclick='$(\"#deleteitem_modal_dir".$fileIds."\").fadeIn();'>
						</td>
					</tr>";

                                $dialogs .= "
                                                                <div class='modal' id='deleteitem_modal_dir".$fileIds."'>
									<div class='title'>".$language['file']." ".$language['delete']."</div>
									<div class='cont'>
										<div class='headImage'></div>
										<p style='text-align:center;'>".$language['deleteOne']." ".$entry." ".$language['deleteTwo']."</p>
										<table class='ignore' style='width:90%;margin:0 auto;text-align:left;'>
                                                                                    <tbody>
											<tr>
												<td>".$language['plugins']."</td>
												<td>
													".$entry."
												</td>
											</tr>
											<tr>
												<td>".$language['fileSize']."</td>
												<td>
													".fileSizeCalc(dirname($file)."/".basename($file))."
												</td>
											</tr>
											<tr>
												<td>".$language['filePermissions']."</td>
												<td>
													".fileperms(dirname($file)."/".basename($file))."
												</td>
											</tr>
											<tr>
												<td>".$language['fileLastEdit']."</td>
												<td>
													".date ("d M Y H:i:s", filemtime(dirname($file)."/".basename($file)))."
												</td>
											</tr>
                                                                                       </tbody>
										</table>
									</div>
										<a href='./admin.php?action=deletedir&root=./Plugins&directory=".$entry."&return=plugins'><button class='button red' style='margin-right:10px;'>".$language['delete']."</button></a>
										<button class='button' onclick='$(\"#deleteitem_modal_dir".$fileIds."\").fadeOut();'>".$language['cancel']."</button>
								</div>";
                                $fileIds++;
			}
		}
	}
	
	/* If an plugin is outdated */
	if($outdated > 0)
		$pluginsOutput = "<div class='info error'>".$language['pluginOutdated']."</div>".$pluginsOutput;
		
	$pluginsOutput .="</table>";
	
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
	if ($handle = opendir("./Packages/Plugins/")) {
		/* This is the correct way to loop over the directory. */
		while (false !== ($entry = readdir($handle))) {
			if($entry!="."&&$entry!=".."){
				if(checkfiletype( "./Packages/Plugins/" . $entry )=="ZIP file"){
					$packagesAmount++;
					
					$packageEcho .= "
						<tr>
							<td title='".fileSizeCalc( "./Packages/Plugins/" . $entry ).", ".fileperms( "./Packages/Plugins/" . $entry )."'>".str_replace(".zip", "", $entry)."</td>
							<td>
								<button class='button red' onclick='$(\"#deletePlugins_modal_file".$fileId."\").fadeIn(300);'>".$language['delete']."</button>
								<a href='./admin.php?action=zipUnpack&root=./Packages/Plugins/&destination=./Plugins/&return=Plugins&file=".$entry."'><button class='button blue'>".$language['install']."</button></a>
							</td>
						</tr>
					";
					$packageModals .= "
						<div class='modal' id='deletePlugins_modal_file".$fileId."'>
							<div class='title'>".$language['plugins']." ".$language['delete']."</div>
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
												".checkfiletype("./Packages/Plugins/" . $entry)."
											</td>
										</tr>
										<tr>
											<td>".$language['fileSize']."</td>
											<td>
												".fileSizeCalc("./Packages/Plugins/" . $entry)."
											</td>
										</tr>
										<tr>
											<td>".$language['filePermissions']."</td>
											<td>
												".fileperms("./Packages/Plugins/" . $entry)."
											</td>
										</tr>
										<tr>
											<td>".$language['fileLastEdit']."</td>
											<td>
												".date ("d M Y H:i:s", filemtime("./Packages/Plugins/" . $entry))."
											</td>
										</tr>
									</table>
								</div>
							<a href='./admin.php?action=deletePage&root=./Packages/Plugins&file=".$entry."&return=".$_GET['action']."'><button class='button red' style='margin-right:10px;'>".$language['delete']."</button></a>
							<button class='button' onclick='$(\"#deletePlugins_modal_file".$fileId."\").fadeOut(300);'>".$language['cancel']."</button>
						</div>
						<!-- end modal -->
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
						<button class='root'><?php echo $language['plugins']; ?></button>
						<button class='button blue' style='float:right;margin-right:10px;margin-top:4px;' onclick='$("#newPage_modal").fadeIn();'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/cart_add.png'>".$language['downloadPlugins']; ?></button>
						<button class='button' onclick='$("#installPlugins").fadeIn();' style='float:right;margin-right:10px;margin-top:4px;' onclick='$("#newPage_modal").fadeIn();'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/brick_add.png'>"; ?><?php echo $language['pluginInstall'];?></button>
					</div>
				</header>
				<div id='content'>
					<?php echo $pluginsOutput . $dialogs; ?>
					<div class='modal' id='installPlugins'>
						<div class='title'><?php echo $language['pluginsInstall']; ?></div>
						<div class='cont'>
							<div style='padding-top:10px;'>
								<?php echo $packageEcho . $packageModals; ?>
							</div>
						</div>
						<button class='button' onclick='$("#installPlugins").fadeOut();' style='margin-right:10px;'><?php echo $language['cancel']; ?></button>
						<button class='button blue' onclick='$("#upload_dialog_pluginsPackage").fadeIn();' style='margin-right:10px;'><?php echo $language['plugins'] . " " . $language['uploading']; ?></button>
					</div>
					<?php echo uploadFileForm("./Packages/Plugins/", "pluginsPackage") ?>
				</div>