<?php

/*****************************************************************************
 *	functions.system.php	- ADMIN RELATED FUNCTIONS
 *
 *	File version 1
 *	Author:	Merijn Geurts
 *	
 *
 *	#####################################
 *  #       Function properties         #
 *  ###############################3#####
 *
 *	Required parameters: *
 *	Optional parameters: -
 *  Extra information:   !
 *
 *	#####################################
 *  #          Function list            #
 *  ###############################3#####
 *
 *  displayActions() 		- Returns action icons of given file
 *   * [STRING] 	File + root to file
 *	 - [BOOL] 		Compact view, default disabled
 *
 *	fileSizeCalc()			- Returns file size of given value
 *	 * [INTEGER] 	Bit to convert
 *
 *  rrmdir()				- Remove selected directory
 *   * [STRING]		Directory to remove + root
 *
 *  checkfiletype($file)	- Check file type of given file
 *   * [STRING]		File + root to file
 *
 *  is_dir_empty()			- Check if directory is empty
 *   * [STRING]		File + root to file
 *
 *  uploadFileForm()		- Creates file upload form
 *   * [STRING]		Directory where file will be uploaded to
 *   * [string]		Identification
 *	 ! ACCES TO THE UPLOAD DIALOG: upload_dialog_{Identification}
 *
 *****************************************************************************/
 
	/* Anti hack */
	if(!$log)exit;
	
	/* Function related */
	$fileId = 0;
	/* This function returns a set of icons inclusive url with actions for a selected file */
	function displayActions($file, $compact=false) {
		global $connect, $language, $fileId; 
		if(file_exists($file)){

			/* Action globals */
			$editLink = "";
			$deleteLink = "";
			
			/* Create fileType */
			$fileType = checkfiletype($file);
			
			if($fileType=="HTML file" || $fileType=="PHP file"){
				if($compact==true){
					$editLink = "
					<a href='?action=editorHTML&root=".dirname($file)."&file=".basename($file)."'><img class='actionIcon' src='".$connect['url']."/Sources/Admin/images/icons/page_edit.png' title='".$language['edit']."'></a>";
				} else {
					$editLink = "
					<span class='iconDropDown'>
						<img class='actionIcon' src='".$connect['url']."/Sources/Admin/images/icons/page_edit.png' title='".$language['edit']."' onclick='$(\".dropdownIcon\").fadeOut(0);$(\"#drop".$fileId."\").fadeIn(0);'>
						<ul id='drop".$fileId."' class='dropdownIcon'>
							<span class='goToTop' onclick='$(\"#drop".$fileId."\").fadeOut(0);'><img class='actionIcon' src='".$connect['url']."/Sources/Admin/images/icons/page_edit.png' title='".$language['edit']."'></span>
							<li onclick='window.location=\"?action=./editorHTML&root=".urlencode(dirname($file))."&file=".basename($file)."&return=".$_GET['action']."\";'>WYSIWYG editor</li>
							<li onclick='window.location=\"?action=./coding&root=".urlencode(dirname($file))."&file=".basename($file)."&return=".$_GET['action']."\";'>Code editor</li>
						</ul>
					</span>
					";
				}				
			}else{
				if( ! strpos($fileType,'image') ){
				    $editLink = "<a href='?action=coding&root=".dirname($file)."&file=".basename($file)."'><img class='actionIcon' src='".$connect['url']."/Sources/Admin/images/icons/page_edit.png' title='".$language['edit']."'></a>";
				}else {
				    $editLink = "<a><img class='actionIcon' src='".$connect['url']."/Sources/Admin/images/icons/empty.png' title='".$language['edit']."'></a>";
				}
			}
			
			if(strpos(strtolower($fileType), 'image')){
				$viewLink = "<a href='./admin.php?action=displayImage&image=".str_replace('\\', '/', $file)."'><img class='actionIcon' src='".$connect['url']."/Sources/Admin/images/icons/eye.png' title='".$language['eye']."'></a>";
			}else{$viewLink="<img class='actionIcon' src='".$connect['url']."/Sources/Admin/images/icons/eye.png' title='".$language['eye']."'>";}
			
			$finalDropDown = $fileId;
			$fileId++;
			return "
			".$viewLink."
			
			".$editLink."
			
			<img class='actionIcon' src='".$connect['url']."/Sources/Admin/images/icons/delete.png' title='".$language['delete']."' onclick='$(\"#deleteitem_modal_file".$finalDropDown."\").fadeIn();'>
			
								<div class='modal' id='deleteitem_modal_file".$finalDropDown."'>
									<div class='title'>".$language['file']." ".$language['delete']."</div>
									<div class='cont'>
										<div class='headImage'></div>
										<p style='text-align:center;'>".$language['deleteOne']." ".basename($file)." ".$language['deleteTwo']."</p>
										<table class='ignore' style='width:90%;margin:0 auto;text-align:left;'>
											<tr>
												<td>".$language['file']."</td>
												<td>
													".basename($file)."
												</td>
											</tr>
											<tr>
												<td>".$language['fileType']."</td>
												<td>
													<span style='position:absolute;margin-left:-25px;'></span> ".checkfiletype(dirname($file)."/".basename($file))."
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
										</table>
									</div>
										<button class='button red' style='margin-right:10px;' onclick='$(\"#loader".$finalDropDown."\").fadeIn(0);$(\"#hidden\").load(\"./Sources/Admin/pages/deleteFile.php?file=".urlencode(basename($file))."&root=".urlencode(str_replace('\\', '/', (dirname($file))))."&id=".$finalDropDown."\");'>".$language['delete']."</button>
										<button class='button' onclick='$(\"#deleteitem_modal_file".$finalDropDown."\").fadeOut();'>".$language['cancel']."</button>
										<img src='./Sources/Admin/images/loader.gif' class='loader' id='loader".$finalDropDown."' />
								</div>
			";
		}else{
			return false;
		}
	}

	if(!$log==true)exit;
	function rrmdir($dir) {
	   if (is_dir($dir)) {
		 $objects = scandir($dir);
		 foreach ($objects as $object) {
		   if ($object != "." && $object != "..") {
			 if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
		   }
		 }
		 reset($objects);
		 rmdir($dir);
	   }
	}
	
	/* Create user system */
	function createUser($username, $password, $mail, $permissions){
		/**
		 *	FUNCTION SETTINGS
		 *
		 *	Return 0 = User have been created
		 *	Return 1 = User not alowed to create accounts
		 *	Return 2 = Username exists
		 *	Return 3 = Mail exists
		 *	Return 4 = One or more variable empty
		 *
		 */
		 
		global $connect, $dbh, $user;
		 
		 /* Check if user is permissed to do this action */
		if(!$user->permissions==1)return(1);
		
		/* Check if all variables are filled */
		if(strlen($username)==0||strlen($password)==0||strlen($mail)==0||strlen($permissions)==0)
			return(4);
		
		/* Check if username exists */
		$select = $dbh->prepare("select * from ".$connect['ext']."users WHERE username=?");
		$select->execute(array($username));
		
		if($select->RowCount()==1)
			return(2);
		
		/* Check if mail exists */
		$select = $dbh->prepare("select * from ".$connect['ext']."users WHERE mail=?");
		$select->execute(array($mail));
		
		if($select->RowCount()==1)
			return(3);
		
		/* Create account */
		$insert = $dbh->prepare("INSERT INTO ".$connect['ext']."users (username, password, mail, permissions) VALUES (?, ?, ?, ?)");
		$insert->execute(array($username, $password, $mail, $permissions));
		
		return(0);
	}
	
	/* Edit user system */
	function editUser($id, $username, $password, $mail, $permissions){
		/**
		 *	FUNCTION SETTINGS
		 *
		 *	Return 0 = User have been edited
		 *	Return 1 = User not alowed to edit accounts
		 *	Return 2 = Variables empty
		 *	Return 3 = User not exists
		 *
		 */
		 
		global $connect, $dbh, $user;
		
		/* Check if user is permissed to do this action */
		if(!$user->permissions==1)return(1);
		
		/* Check if all variables are filled */
		if(strlen($id)==0||strlen($username)==0||strlen($password)==0||strlen($mail)==0||strlen($permissions)==0)
			return(2);
		
		/* Check if username exists */
		$select = $dbh->prepare("SELECT * FROM ".$connect['ext']."users WHERE id=?");
		$select->execute(array($id));
		
		if(!$select->RowCount()==1)
			return(3);
		
		/* Update user */
		$update = $dbh->prepare("UPDATE ".$connect['ext']."users SET username=?, password=?, mail=?, permissions=? WHERE id=?");
		$update->execute(array($username, $password, $mail, $permissions, $id));
		
		return(0);
	}
	
	function deleteUser($id){
		/**
		 *	FUNCTION SETTINGS
		 *
		 *	Return 0 = User have been edited
		 *	Return 1 = User not alowed to edit accounts
		 *	Return 2 = Variables empty
		 *	Return 3 = User not exists
		 *
		 */
		 
		global $connect, $dbh, $user;
		
		/* Check if user is permissed to do this action */
		if(!$user->permissions==1)return(1);
		
		/* Check if all variables are filled */
		if(strlen($id)==0)
			return(2);
		
		/* Check if username exists */
		$select = $dbh->prepare("SELECT * FROM ".$connect['ext']."users WHERE id=?");
		$select->execute(array($id));
		
		if(!$select->RowCount()==1)
			return(3);
		
		/* Delete user */
		$delete	= $dbh->prepare("DELETE FROM ".$connect['ext']."users WHERE id=?");
		$delete->execute(array($id));
		
		return(0);
	}
	
	
	function editSettings($name, $value){
		/**
		 *	FUNCTION SETTINGS
		 *
		 *	Return 0 = User have been edited
		 *	Return 1 = Variables empty
		 *	Return 2 = Variable not exists
		 *
		 *	ANY ACCOUNT IS ALOWED TO DO THIS ACTION!
		 *
		 *	This action will be saved into the log!
		 */
		 
		global $connect, $dbh, $user;
		
		/* Check if all variables are filled */
		if(strlen($name)==0||strlen($value)==0)
			return(1);
		
		/* check if setting exists */
		$select = $dbh->prepare("SELECT * FROM ".$connect['ext']."settings WHERE name=?");
		$select->execute(array($name));
		
		if(!$select->RowCount()==1)return(2);
		
		/* Log changes from lower rank user */
		if(!$user->permissions==1){
			$values = $select->fetchObject();
			echo "[" . $values->value . "][" .$value. "]";
			if($values->value!=$value){
				echo "here";
				$insert = $dbh->prepare("INSERT INTO ".$connect['ext']."log (user, userAction, returnValue) VALUES (?, ?, ?)");
				$insert->execute(array($user->id, "Changed settings [".$name."] => '".$value."'", "UPDATE ".$connect['ext']."settings SET value='".$values->value."' WHERE name='".$name."'"));
			}
			
		}
		
		/* Actually update */
		$update = $dbh->prepare("UPDATE ".$connect['ext']."settings SET value=? WHERE name=?");
		$update->execute(array($value, $name));
		
		return(0);
	}
	
	
	/* File size calculator */
	function fileSizeCalc($file) {
		$size = filesize($file);
		$units = array(' B', ' KB', ' MB', ' GB', ' TB');for ($i = 0; $size >= 1024 && $i < 4; $i++) 
		$size /= 1024;
		return round($size, 2).$units[$i];
	}
	
	function checkfiletype($file){
	$file_type = 'undefined';
		$file = strtolower($file);
		/* images */
		if (strpos($file,'.png') !== false)
			$file_type = 'PNG image';
		if (strpos($file,'.gif') !== false)
			$file_type = 'GIF image';
		if (strpos($file,'.jpg') !== false)
			$file_type = 'JPEG image';
		if (strpos($file,'.jpeg') !== false)
			$file_type = 'JPEG image';
		if (strpos($file,'.bmp') !== false)
			$file_type = 'MSPAINT image';
		if (strpos($file,'.tga') !== false)
			$file_type = 'TRUEVISION image';
		if (strpos($file,'.ico') !== false)
			$file_type = 'Icon';
						
		if (strpos($file,'.pdf') !== false)
			$file_type = 'PDF file';
		if (strpos($file,'.db') !== false)
			$file_type = 'Database file';
		if (strpos($file,'.sql') !== false)
			$file_type = 'Database file';
	
		/* WEB DESIGN */
		if (strpos($file,'.htc') !== false)
			$file_type = 'HTML Component';
		if (strpos($file,'.js') !== false)
			$file_type = 'Javascript file';
		if (strpos($file,'.css') !== false)
			$file_type = 'Stylesheet file';
		if (strpos($file,'.html') !== false)
			$file_type = 'HTML file';
		if (strpos($file,'.htm') !== false)
			$file_type = 'HTML file';
		if (strpos($file,'.shtml') !== false)
			$file_type = 'HTML file';
		if (strpos($file,'.phtml') !== false)
			$file_type = 'PHP file';
		if (strpos($file,'.php') !== false)
			$file_type = 'PHP file';
		if (strpos($file,'.php3') !== false)
			$file_type = 'PHP file';
		if (strpos($file,'.php4') !== false)
			$file_type = 'PHP file';
		if (strpos($file,'.php5') !== false)
			$file_type = 'PHP file';
		if (strpos($file,'.php6') !== false)
			$file_type = 'PHP file';
		if (strpos($file,'.phps') !== false)
			$file_type = 'PHP file';
			
		/* Microsoft office WORD */
		if (strpos($file,'.doc') !== false)
			$file_type = 'WORD document';
		if (strpos($file,'.docx') !== false)
			$file_type = 'WORD document';
		if (strpos($file,'.docm') !== false)
			$file_type = 'WORD document';
		if (strpos($file,'.dotx') !== false)
			$file_type = 'WORD document';
		if (strpos($file,'.dotm') !== false)
			$file_type = 'WORD document';
		
		/* Microsoft office Excell */
		if (strpos($file,'.xls') !== false)
			$file_type = 'EXCEL document';
		if (strpos($file,'.xlsx') !== false)
			$file_type = 'EXCEL document';
		if (strpos($file,'.xlsm') !== false)
			$file_type = 'EXCEL document';
		if (strpos($file,'.xltx') !== false)
			$file_type = 'EXCEL document';
		if (strpos($file,'.xltm') !== false)
			$file_type = 'EXCEL document';
		if (strpos($file,'.xlsb') !== false)
			$file_type = 'EXCEL document';
		if (strpos($file,'.xlam') !== false)
			$file_type = 'EXCEL document';
		if (strpos($file,'.xll') !== false)
			$file_type = 'EXCEL document';
			
		/* Microsoft office Powerpoint */
		if (strpos($file,'.fnt') !== false)
			$file_type = 'POWERPOINT';
		if (strpos($file,'.pptm') !== false)
			$file_type = 'POWERPOINT';
		if (strpos($file,'.ppt') !== false)
			$file_type = 'POWERPOINT';
		if (strpos($file,'.potx') !== false)
			$file_type = 'POWERPOINT';
		if (strpos($file,'.potm') !== false)
			$file_type = 'POWERPOINT';
		if (strpos($file,'.ppam') !== false)
			$file_type = 'POWERPOINT';
		if (strpos($file,'.ppsx') !== false)
			$file_type = 'POWERPOINT';
		if (strpos($file,'.ppsm') !== false)
			$file_type = 'POWERPOINT';
		if (strpos($file,'.pptx') !== false)
			$file_type = 'POWERPOINT';
			
		/* font files */
		if (strpos($file,'.abf') !== false)
			$file_type = 'FONT file';
		if (strpos($file,'.acfm') !== false)
			$file_type = 'FONT file';
		if (strpos($file,'.afm') !== false)
			$file_type = 'FONT file';
		if (strpos($file,'.amfm') !== false)
			$file_type = 'FONT file';
		if (strpos($file,'.bdf') !== false)
			$file_type = 'FONT file';
		if (strpos($file,'.cha') !== false)
			$file_type = 'FONT file';		
		if (strpos($file,'.chr') !== false)
			$file_type = 'FONT file';
		if (strpos($file,'.dfont') !== false)
			$file_type = 'FONT file';
		if (strpos($file,'.fnt') !== false)
			$file_type = 'FONT file';			
		
		/* sound and media */
		if (strpos($file,'.mp3') !== false)
			$file_type = 'MP3 file';
		if (strpos($file,'.mp4') !== false)
			$file_type = 'MP4 file';
		if (strpos($file,'.mpeg') !== false)
			$file_type = 'Media file';
		if (strpos($file,'.mpg') !== false)
			$file_type = 'Media file';
		if (strpos($file,'.mpc') !== false)
			$file_type = 'Classic Media file';
			
		/* others */
		if (strpos($file,'.dll') !== false)
			$file_type = 'DLL file';
		if (strpos($file,'.exe') !== false)
			$file_type = 'executable file';
		if (strpos($file,'.rar') !== false)
			$file_type = 'RAR file';
		if (strpos($file,'.zip') !== false)
			$file_type = 'ZIP file';
		if (strpos($file,'.dat') !== false)
			$file_type = 'DAT file)';
		if (strpos($file,'.rb') !== false)
			$file_type = 'Ruby file)';
		if (strpos($file,'.rtf') !== false)
			$file_type = 'Rich Text Format file';
		if (strpos($file,'.exe') !== false)
			$file_type = 'Execution file';

		/* Return value */
		return $file_type;
	}
	
	/* Check if dir is empty */
	function is_dir_empty($dir) {
	  if (!is_readable($dir)) return NULL; 
	  $handle = opendir($dir);
	  while (false !== ($entry = readdir($handle))) {
		if ($entry != "." && $entry != "..") {
		  return FALSE;
		}
	  }
	  return TRUE;
	}
	
	function displayMenuConfig(){
		/**
		 *	FUNCTION SETTINGS
		 *
		 *	Return 0 = User have been edited
		 *	Return 1 = No menu items
		 *	Return 2 = Variable not exists
		 *
		 *	ANY ACCOUNT IS ALOWED TO DO THIS ACTION!
		 *
		 *	This action will be saved into the log!
		 */
		 
		global $connect, $dbh, $user, $language;
		
		/* check if setting exists */
		$select = $dbh->prepare("SELECT * FROM ".$connect['ext']."menu WHERE child=0 ORDER BY position");
		$select->execute();
		
		if(!$select->RowCount()==1)return("<div class='msg'>".$language['menuEmpty']."</div>");
		
		/* Create local function variable wich will be returned */
		$display = "";
		
		/* Create items */
		while($row = $select->fetchObject()){
			$display .= "
					<div class='bar'>
						<form action='admin.php?action=inlineedit&id=".$row->id."' method='post'>
							<table style='width:100%;'>
								<tr>
									<td style='min-width:75px;'><input name='name' id='name".$row->id."' value='".$row->menuName."' style='width:100%;' DISABLED /></td>
									<td style='width:15%;min-width:80px;'>
										<select id='frame".$row->id."' name='frame' style='width:100%;' onchange='$(\"#buttonSave".$row->id."\").fadeIn();' DISABLED>";
										switch($row->menuTarget){
											case "_BLANK":
												$display .= "<option value='_BLANK' SELECTED>".$language['menuBlank']."</option><option value='_SELF'>".$language['menuSelf']."</option><option value='_TOP'>".$language['menuTop']."</option><option value='_PARENT'>".$language['menuParent']."</option>";
												break;
											case "_SELF":
												$display .= "<option value='_BLANK'>".$language['menuBlank']."</option><option value='_SELF' SELECTED>".$language['menuSelf']."</option><option value='_TOP'>".$language['menuTop']."</option><option value='_PARENT'>".$language['menuParent']."</option>";
												break;
											case "_TOP":
												$display .= "<option value='_BLANK'>".$language['menuBlank']."</option><option value='_SELF'>".$language['menuSelf']."</option><option value='_TOP' SELECTED>".$language['menuTop']."</option><option value='_PARENT'>".$language['menuParent']."</option>";
												break;
											case "_PARENT":
												$display .= "<option value='_BLANK'>".$language['menuBlank']."</option><option value='_SELF'>".$language['menuSelf']."</option><option value='_TOP' SELECTED>".$language['menuTop']."</option><option value='_PARENT'>".$language['menuParent']."</option>";
												break;
										}
										$display .= "
										</select>
									</td>
									<td style='width:20%;min-width:120px;'><input id='url".$row->id."' name='url' type='text' value='".$row->menuHREF."' style='width:100%;' onchange='$(\"#buttonSave".$row->id."\").fadeIn();' DISABLED /></td>
									<td style='width:50px;text-align:right;'>
										<input id='position".$row->id."' name='position' type='number' value='".$row->position."' style='width:35px;' onchange='$(\"#buttonSave".$row->id."\").fadeIn();' DISABLED />
									</td>
									<td style='width:120px;'>
										<div style='position:Relative;top:3px;text-align:right;'>
											<button id='buttonSave".$row->id."' class='button' style='position:absolute;margin-top:-3px;margin-left:-73px;display:none;'>".$language['save']."</button>
											<img onclick='$(\"#buttonSave".$row->id."\").fadeIn();document.getElementById(\"url".$row->id."\").disabled=false;document.getElementById(\"frame".$row->id."\").disabled=false;document.getElementById(\"name".$row->id."\").disabled=false;document.getElementById(\"position".$row->id."\").disabled=false;' src='".$connect['url']."/Sources/Admin/images/icons/link_edit.png' title='".$language['edit']."'>
											<img onclick='$(\"#delete_menu".$row->id."\").fadeIn();' src='".$connect['url']."/Sources/Admin/images/icons/delete.png' title='".$language['delete']."' />
										</div>
									</td>
								</tr>
							</table>
						</form>
					</div>
					<div class='modal' id='delete_menu".$row->id."'>
						<div class='title'>".$language['deleteMenu']."</div>
							<form action='admin.php?action=deletemenuitem&id=".$row->id."' method='post'>
								<div class='cont' style='text-align:center;'>
									<div class='headImage'></div>
									<p>".$language['deleteOne']." ".$row->menuName." ".$language['deleteTwo']."</p>
									<table class='table ignore' style='width:90%;margin:0 auto;text-align:left;border:0;'>
										<tr>
											<td>".$language['name']."</td>
											<td>
												".$row->menuName."
											</td>
										</tr>
										<tr>
											<td>".$language['menuUrl']."</td>
											<td>
												".$row->menuHREF."
											</td>
										</tr>
										<tr>
											<td>".$language['menuPosition']."</td>
											<td>
												".$row->position."
											</td>
										</tr>
										<tr>
											<td>".$language['menuFrame']."</td>
											<td>
												".$row->menuTarget."
											</td>
										</tr>
									</table>
									<p style='width:90%;padding-left:15px;margin:0 auto;margin-top:20px;'>".displayMenuDrops($language['menuNoMove'], $row->id)."</p>
								</div>
								<input type='submit' class='submit' value='".$language['delete']."' />
							</form>
						<button class='button' onclick='$(\"#delete_menu".$row->id."\").fadeOut();'>".$language['cancel']."</button>
					</div>
					";
			
			/* Selecting child of menu item */
			$selectChild = $dbh->prepare("SELECT * FROM ".$connect['ext']."menu WHERE child=1 AND child_of=".$row->id." ORDER BY position");
			$selectChild->execute();
			
			/* Create childs */
			while($child = $selectChild->fetchObject()){
				$display .= "
					<div class='barSub'>
						<form action='admin.php?action=inlineedit&id=".$child->id."' method='post'>
							<table style='width:100%;'>
								<tr>
									<td style='min-width:75px;'><input value='".$child->menuName."' name='name' id='name".$child->id."' style='width:100%;' disabled/></td>
									<td style='width:15%;min-width:80px;'>
										<select id='frame".$child->id."' name='frame' style='width:100%;' DISABLED >";
										switch($child->menuTarget){
											case "_BLANK":
												$display .= "<option value='_BLANK' SELECTED>".$language['menuBlank']."</option><option value='_SELF'>".$language['menuSelf']."</option><option value='_TOP'>".$language['menuTop']."</option><option value='_PARENT'>".$language['menuParent']."</option>";
												break;
											case "_SELF":
												$display .= "<option value='_BLANK'>".$language['menuBlank']."</option><option value='_SELF' SELECTED>".$language['menuSelf']."</option><option value='_TOP'>".$language['menuTop']."</option><option value='_PARENT'>".$language['menuParent']."</option>";
												break;
											case "_TOP":
												$display .= "<option value='_BLANK'>".$language['menuBlank']."</option><option value='_SELF'>".$language['menuSelf']."</option><option value='_TOP' SELECTED>".$language['menuTop']."</option><option value='_PARENT'>".$language['menuParent']."</option>";
												break;
											case "_PARENT":
												$display .= "<option value='_BLANK'>".$language['menuBlank']."</option><option value='_SELF'>".$language['menuSelf']."</option><option value='_TOP'>".$language['menuTop']."</option><option value='_PARENT' SELECTED>".$language['menuParent']."</option>";
												break;
										}
										$display .= "
										</select>
									</td>
									<td style='width:20%;min-width:120px;'><input id='url".$child->id."' name='url' type='text' value='".$child->menuHREF."' style='width:100%;' DISABLED /></td>
									<td style='width:50px;text-align:right;'>
										<input id='position".$child->id."' name='position' type='number' value='".$child->position."' style='width:35px;' DISABLED />
									</td>
									<td style='width:120px;'>
										<div style='position:Relative;top:3px;text-align:right;'>
											<button id='buttonSave".$child->id."' class='button' style='position:absolute;margin-top:-3px;margin-left:-73px;display:none;'>".$language['save']."</button>
											<img onclick='$(\"#buttonSave".$child->id."\").fadeIn();document.getElementById(\"url".$child->id."\").disabled=false;document.getElementById(\"frame".$child->id."\").disabled=false;document.getElementById(\"name".$child->id."\").disabled=false;document.getElementById(\"position".$child->id."\").disabled=false;' src='".$connect['url']."/Sources/Admin/images/icons/link_edit.png' title='".$language['edit']."'>
											<img onclick='$(\"#delete_menu".$child->id."\").fadeIn();' src='".$connect['url']."/Sources/Admin/images/icons/delete.png' title='".$language['delete']."'>
										</div>
									</td>
								</tr>
							</table>
						</form>
					</div>
					<div class='modal' id='delete_menu".$child->id."'>
						<div class='title'>".$language['deleteMenu']."</div>
							<form action='admin.php?action=deletemenuitem&id=".$child->id."' method='post'>
								<div class='cont' style='text-align:center;'>
									<div class='headImage'></div>
									<p>".$language['deleteOne']." ".$child->menuName." ".$language['deleteTwo']."</p>
									<table class='table ignore' style='width:90%;margin:0 auto;text-align:left;border:0;'>
										<tr>
											<td>".$language['name']."</td>
											<td>
												".$child->menuName."
											</td>
										</tr>
										<tr>
											<td>".$language['menuUrl']."</td>
											<td>
												".$child->menuHREF."
											</td>
										</tr>
										<tr>
											<td>".$language['menuPosition']."</td>
											<td>
												".$child->position."
											</td>
										</tr>
										<tr>
											<td>".$language['menuFrame']."</td>
											<td>
												".$child->menuTarget."
											</td>
										</tr>
									</table>
								</div>
								<input type='submit' class='submit' value='".$language['delete']."' />
							</form>
						<button class='button' onclick='$(\"#delete_menu".$child->id."\").fadeOut();'>".$language['cancel']."</button>
					</div>
					";
			}
		}
		
		return($display);
	}
	
	function displayMenuDrops($name = null, $hide = false) {
	
		global $connect, $dbh, $user, $language;
		
		if($name==null)$name= $language['menuDropINDenie'];
		
		
		$list = "<select name='menuDrops' style='margin-left:-10px;display:block;width:100%;padding-right:30px;'><option value='denie'>".$name."</option>";
		/* check if setting exists */
		$select = $dbh->prepare("SELECT * FROM ".$connect['ext']."menu WHERE child=0 ORDER BY position");
		$select->execute();
		
		while($row = $select->fetchObject()){
			if($hide!=$row->id)
			$list .= "<option value='".$row->id."'>".$row->menuName."</option>";
		}
		
		$list .= "</select>";
		return $list;
	}
	
	function uploadFileForm($directory, $identification) {
		global $language;
		return "
					<div class='modal' id='upload_dialog_".$identification."'>
						<div class='title'>".$language['file']." ".$language['uploading']."</div>
						<form action='admin.php?action=uploadfile&root=".$directory."&return=".$_GET['action']."' method='post' enctype='multipart/form-data'>
							<div class='cont'>
								<div class='headImage'></div>
								<div style='width:80%;margin:0 auto;'>
									<label for='file' style='font-size:13px;font-weight:bold;'><p>".$language['uploadMsg']."</p></label>
									<p>
										<input type='file' name='file' id='file' style='width:100%;height:100px;margin-left:-10px;display:Block;' multiple>
										<span syle='padding-top:10px;'><strong>Maximale bestandsgrootte:</strong> ".ini_get('upload_max_filesize')."</span>
									</p>
								</div>
							</div>
							<input type='submit' class='submit' name='submit' value='".$language['upload']."'>
						</form>
						<button class='button' onclick='$(\"#upload_dialog_".$identification."\").fadeOut();'>".$language['cancel']."</button>
					</div>
		";
	}




?>