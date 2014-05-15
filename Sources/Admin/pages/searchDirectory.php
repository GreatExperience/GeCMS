<?php 
	if(!$log)exit; 
	
	$tb = "<table class='table' style='width:100%;border:0;'><tr><td></td><td></td></tr>";
  
$dir = new RecursiveDirectoryIterator($connect['root']);
foreach (new RecursiveIteratorIterator($dir) as $filename => $file) {
	if(strpos($file, $_GET['search'])!==false){
		$tb .= "
			<tr>
				<td>".$filename."</td>
				<td>".$file->getSize()."</td>
				<td>".date ("d M Y H:i:s", filemtime($file))."555</td>
			</tr>
		";
	}
}
?>
				<header>
					<div class='header'>
						<button class='root'><?php echo $language['search']; ?></button>
						<button class='root sub'><?php echo $_GET['search']; ?></button>
						
						<select style='float:right;margin-right:10px;margin-top:5px;'>
							<option value='0'>Media en Pagina's</option>
							<option value='1'>Alle bestanden</option>
							<option value='2'>Alleen Pagina's</option>
							<option value='3'>Alleen Media</option>
						</select>
					</div>
				</header>
				<?php echo $tb . "</table>"; ?>