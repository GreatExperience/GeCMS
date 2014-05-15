<script src="http://github.highcharts.com/highcharts-more.js"></script>
<?php 
	if(!$log)exit; 
	
	$tbAdvanced = "";
	$tbAdvandedCount = 0;
	$count = 0;
	
	$tb = "<table class='table' style='width:100%;border:0;'>
		<tr>
			<th style='width:20px;'></th>
			<th style='padding-left:10px;'>".$language['name']."</th>
			<th style='padding-left:10px;'>Directory</th>
			<th style='width:10%;min-width:100px;'>".$language['fileType']."</th>
			<th style='width:15%;min-width:100px;'>".$language['fileSize']."</th>
			<th style='width:15%;min-width:130px;'>".$language['fileLastEdit']."</th>
			<th style='width:73px;padding-left:15px;'>Actions</th>
		</tr>";
		
if( isset($_POST['search']) || isset($_GET['directory']) ){
	if( $_POST['search'] != null || $_GET['directory'] != null ) {
	
		if( $_POST['search'] != null )
			$search = $_POST['search'];
		else
			$search = $_GET['search'];
			
		$dir = new RecursiveDirectoryIterator("./");
		foreach (new RecursiveIteratorIterator($dir) as $filename => $file) {
			
			if(strpos(strtolower($file), strtolower($search))!==false){
			
				$count++;
				$url = $connect['url'].str_replace(".\\", "", $file);
				/* Get file type & icon */
				$filetype = checkfiletype($file);
				include $connect['root'] . "/Sources/Admin/fileType.php";
				
				if(strpos($file, "Media")!==false||strpos($file, "Pages")!==false){
					$tb .= "
					<tr id='file".$fileId."'>
						<td>".$icon."</td>
						<td title='".$url."'>".basename($file)."</td>
						<td><a href='./admin.php?action=Media&root=".dirname($file)."'><button class='button' style='padding:2px;'>".dirname($file)."</button></a></td>
						<td>".$filetype."</td>
						<td>".fileSizeCalc($file)."</td>
						<td>".date ("d M Y H:i:s", filemtime($file))."</td>
						<td>".displayActions($file)."</td>
					</tr>
					";
				}else{
					$tbAdvanced .= "
					<tr class='tableHide'>
						<td>".$icon."</td>
						<td title='".$url."'>".basename($file)."</td>
						<td><a href='./admin.php?action=Media&root=".dirname($file)."'><button class='button' style='padding:2px;'>".dirname($file)."</button></a></td>
						<td>".$filetype."</td>
						<td>".fileSizeCalc($file)."</td>
						<td>".date ("d M Y H:i:s", filemtime($file))."</td>
						<td>".displayActions($file)."</td>
					</tr>
					";
					$tbAdvandedCount++;
				}
			}
		}

		if($tbAdvandedCount>0){
			$tbAdvanced .= "</table>
				<div style='padding:10px;'>
					<div class='bar' onclick='$(this).fadeOut();$(\".tableHide\").fadeIn();' style='cursor:pointer;'>
						<img src='./Sources/Admin/images/icons/arrow_refresh.png' style='position:relative;top:3px;margin:0;' />
						<span style='position:relative;top:-3px;color:#000;text-decoration:underline;'><strong>".$tbAdvandedCount."</strong> ".$language['advancedSearchResults']."</span>
					</div>
				</div>";
		}
	}
}else{
	$_POST['search'] = "";
}
?>
				<header>
					<div class='header'>
						<button class='root'><?php echo $language['search']; ?></button>
						<button class='root sub'><?php echo $_POST['search']; ?></button>
						
						<select style='float:right;margin-right:10px;margin-top:5px;' onchange='alert("Coming soon!");'>
							<option value='0'><?php echo $language['mediaPages']; ?></option>
							<option value='1'><?php echo $language['allFiles']; ?></option>
							<option value='2'><?php echo $language['onlyPages']; ?></option>
							<option value='3'><?php echo $language['onlyMedia']; ?></option>
						</select>
					</div>
				</header>
				<div id='content' style='padding:0;'>
				<?php 
					if($count>0){
					
						/* Results found : display results */
						echo $tb . $tbAdvanced . "</table>"; 
						
					}else{
					
						/* No search results : display box */
						if($_POST['search'] != null){
							echo "<div class='box' style='margin:10px;padding:10px;text-align:center;'><img src='./Sources/admin/images/icons/delete.png' style='position:relative;top:3px;'> ".$language['noSearchResults']."</div>";
						}else{
							echo "<div class='box' style='margin:10px;padding:10px;text-align:center;'><img src='./Sources/admin/images/icons/delete.png' style='position:relative;top:3px;'> Post entry empty</div>";
						}
					}
				
				?>
				</div>
				<style>
					.tableHide {display:none;}
				</style>