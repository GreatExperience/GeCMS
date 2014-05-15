<?php 
	if(!$log)exit;
	
	/* Check if root exists */
	if(isset($_GET['root'])){		
	
		/* Unable to use negative roots */
		if(strpos($_GET['root'],'../')){die("Hacking attempt");}
		
		/* Create directory object */
		$directory = new Folder($_GET['root']);
		
		if(!$directory->getIsDir()){
			echo "
				<div style='text-align:center;'><img src='./sources/admin/images/gelogo.png' style='width:15%;margin:0 auto;margin-top:5%;' /></div>
				<h1 style='font-size:80px;color:#555;text-align:center;'>That's an error!</h1>
				<p style='text-align:center;font-size:24px;'>Directory missing on path ".$_GET['root']."</p>
				<p style='text-align:center;'><button class='button'>Browse media files</button></p>
				";
		}else{
		
			/* Message at folders: warn user > edit important files */
			if($directory->getIsGlobal()==false){
				echo "<div class='msg'>".$language['editRisk']."</div>";
			}
			
			/* Pagelist needs different display creating variable*/
			if($directory->getSRC()=="./Sources/Pages"){$small=true;}else{$small=false;}
			
			/* Open selected directory */

			
				/* Use global variable */
				$rows = "";
				
				echo "<table class='table' style='width:100%;'>
				<tr>
				<th style='width:15px;'></th>
				<th>Name</th>
				<th style='width:150px;text-align:center;border-left:1px solid #bbb;'>".$language['fileLastEdit']."</th>
				<th style='width:125px;text-align:center;border-left:1px solid #bbb;'>".$language['fileSize']."</th>
				<th style='width:125px;text-align:center;border-left:1px solid #bbb;'>".$language['fileType']."</th>
				<th style='width:150px;text-align:center;border-left:1px solid #bbb;'>".$language['filePermissions']."</th>
				<th style='width:80px;text-align:center;border-left:1px solid #bbb;'>Actions</th></tr>";

				/* This is the correct way to loop over the directory. */
				$fileId = 0;
				
				$files = $directory->getDirectoryFiles();
				
				if(!$files==false){
				    /* Loop though directory files */
				    foreach($files as $key => $entry) {

					/* File identifications for modal boxes */
					$fileId++;

					/* Directory needs different display (if Directory... ELSE... File) */
					if(filetype($_GET['root']."/".$entry)=="dir"){

					    $overwriteDir = new Folder($directory->getSRC()."/".$entry);

					    $iconFolder	    = Icon::display('folder.png');
					    $iconFolderDelete   = Icon::display('folder_delete.png', Array('title' => $language['delete'], 'onclick' => '$(\'#deletepage_modal_file'.$fileId.'\').fadeIn();'));

					    /* Display directory */
					    $rows = "<tr ondblclick='window.location=\"./admin.php?action=".$_GET['action']."&root=".$directory->getSRC()."/".$overwriteDir->getName()."\";'>
							<td>".$iconFolder."</td>
							<td>".$overwriteDir->getName()."</td>
							<td>".$overwriteDir->getModified()."</td>
							<td></td>
							<td style='text-align:left;'>DIR</td>
							<td>".$overwriteDir->getPermissions()."</td>
							<td style='text-align:center;'>
							    ".$iconFolderDelete."
								<div class='modal' id='deletepage_modal_file".$fileId."'>
								<div class='title'>".$language['file']." ".$language['delete']."</div>
								<div class='cont'>
								    <div class='headImage'></div>
								    <p>".$language['deleteOne']." <u>".$overwriteDir->getName()."</u> ".$language['deleteTwo']."</p>
								</div>
								<a href='./admin.php?action=deletedir&root=".$directory->getSRC()."&return=".$_GET['action']."&directory=".$overwriteDir->getName()."'><button class='button red' style='margin-right:10px;'>".$language['delete']."</button></a>
								<button class='button' onclick='$(\"#deletepage_modal_file".$fileId."\").fadeOut();'>".$language['cancel']."</button>
									</div>

							</td>
						    </tr>" . $rows;

					}else{
					    /* Get file */
					    $file = new file($_GET['root']."/".$entry);

					    /* Collect file type */
					    $filetype = $file->getType();

					    /* on double click event */
					    if($filetype=="ZIP file")
						$dblclick = "$(\"#unzipArchive".$fileId."\").fadeIn();";
					    else
						$dblclick = "";

					    /* Display file */
					    $rows = $rows ."<tr id='file".$fileId."' ondblclick='".$dblclick."'>
								<td>".$file->getIcon()."</td>
								<td>$entry</td>
								<td>".$file->getModified()."</td>
								<td style='text-align:left;'>".fileSizeCalc($file->getSRC())."</td>
								<td style='text-align:left;'>".checkfiletype($directory->getSRC()."/".$entry)."</td>
								<td>".$file->getPermissions()."</td>
								<td style='text-align:center;'>";
					    if($small==true){
						$rows = $rows . displayActions($directory->getSRC()."/".$entry, true);
					    } else {
						$rows = $rows . displayActions($directory->getSRC()."/".$entry);
					    }

						$rows = $rows . "
								</td>
							</tr>";

					    if($filetype=="ZIP file"){
						echo "<div class='modal' id='unzipArchive".$fileId."'>
							<div class='title'>".$language['file']." ".$language['unzip']."</div>
							<div class='cont'>
							    <div class='headImage'></div>
							    <p style='text-align:center;'>".$language['deleteOne']." ".$entry." ".$language['unzipHereText'].":</p>
							    <p style='text-align:center;text-decoration:underline;'>".$directory->getSRC()."</p>

							</div>
							<a href='./admin.php?action=zipUnpack&root=".$directory->getSRC()."&file=".$entry."&return=".$_GET['action']."&destination=".$directory->getSRC()."'><button class='button blue' style='margin-right:10px;'>".$language['unzipHere']."</button></a>
							<button class='button' onclick='$(\"#unzipArchive".$fileId."\").fadeOut();'>".$language['cancel']."</button>
						</div>
								    ";
					    }
					}	
				    }
				}
				echo $rows . "</table>";
				
				/* If directory empty: give message */
				if($files==false){
					echo "
						<div class='box' style='padding:5px;text-align:center;font-size:14px;'>".$language['noFiles']."</div>
					";
				}

				
				$folderAdd = Icon::display('folder_add.png');
				$folderExplore = Icon::display('folder_explore.png');
				$driveAdd = Icon::display('drive_add.png');
				
				echo "<div id='errorHandle'></div>
					<p>
					    <a href='admin.php?action=".$_GET['action']."&root=".dirname($directory->getSRC())."'><button class='button'>".$folderExplore." ".$language['directoryUp']."</button></a>
					    <button class='button' onclick='$(\"#upload_dialog\").fadeIn();'>".$driveAdd." ".$language['upload']."</button>
				";
				
				if($small==false) echo "<button class='button' onclick='$(\"#createdir_dialog\").fadeIn();'>".$folderAdd." ".$language['newDirectory']."</button>";
				
				echo "
					</p>	
					<div class='modal' id='upload_dialog'>
						<div class='title'>".$language['file']." ".$language['uploading']."</div>
						<form action='admin.php?action=uploadfile&root=".$directory->getSRC()."&return=".$_GET['action']."' method='post' enctype='multipart/form-data'>
							<div class='cont'>
								<div class='headImage'></div>
								<div style='width:80%;margin:0 auto;'>
									<label for='file' style='font-size:13px;font-weight:bold;'><p>".$language['uploadMsg']."</p></label>
									<p>
										<input type='file' name='file' id='file' style='width:100%;height:100px;margin-left:-10px;display:Block;' REQUIRED>
										<span syle='padding-top:10px;'><strong>Maximale bestandsgrootte:</strong> ".ini_get('upload_max_filesize')."</span>
									</p>
								</div>
							</div>
							<input type='submit' class='submit' name='submit' value='".$language['upload']."'>
						</form>
						<button class='button' onclick='$(\"#upload_dialog\").fadeOut();'>".$language['cancel']."</button>
					</div>
					<div class='modal' id='createdir_dialog'>
						<div class='title'>".$language['newDirectory']."</div>
						<form action='admin.php?action=createdir&root=".$directory->getSRC()."&return=".$_GET['action']."' method='post' enctype='multipart/form-data'>
							<div class='cont'>
								<div class='headImage'></div>
								<div style='width:80%;margin:0 auto;'>
									<p style='text-align:center;font-size:14px;'>
										".$language['newDirectoryText']."
									</p>
									<p>
										<input type='text' name='directory' style='margin-left:-10px;display:Block;width:100%;margin-top:25px;' REQUIRED />
									</p>
								</div>
							</div>
							<input type='submit' class='submit' name='submit' value='".$language['create']."'>
						</form>
						<button class='button' onclick='$(\"#createdir_dialog\").fadeOut();'>".$language['cancel']."</button>
					</div>
				";
			}
	}else{
		/* Whoops! */
		echo "No root selected";
	}


?>