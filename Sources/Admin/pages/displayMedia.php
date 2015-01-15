<?php 
    if(!$log==true)exit;
?>
<?php
    $directoryArray = array();
    $thumbnails = "";
    $count = 0;
    if(isset($_GET['type']) && $_GET['type']=='file')
	$_GET['root'] = './Sources/Pages';
    
    if(isset($_GET['root'])){
	
	if(strpos($_GET['root'], '../')){die("Hacking attempt");}

	if(!is_dir($_GET['root'])){
	    echo "
				<div style='text-align:center;'><img src='./Sources/Admin/images/gelogo.png' style='width:15%;margin:0 auto;margin-top:5%;' /></div>
				<h1 style='font-size:80px;color:#555;text-align:center;'>That's an error!</h1>
				<p style='text-align:center;font-size:24px;'>Directory missing on path ".$_GET['root']."</p>
				<p style='text-align:center;'><button class='button'>Browse media files</button></p>";
	}else{
	    /* Open selected directory */
	    if ($handle = opendir($_GET['root'])) {
		
		/* This is the correct way to loop over the directory. */
		$fileId = 0;
		while (false !== ($entry = readdir($handle))) {
		    
		    if($entry!="."&&$entry!=".."){
			if(filetype($_GET['root']."/".$entry)=="dir"){
			    $directoryArray[] = $entry;
			}

			/* Get file */
			$file = new file($_GET['root']."/".$entry);

			/* Only images */
			switch($_GET['type']){
			    case 'image':
				if($file->isImage()==true){
				    $thumbnailWidth = '150px';
				    $thumbnailHeight = 125;
				    $thumbnails .= '
				    <div class="thumbnail" onclick="onclickThumb(this, \''.$file->getSRC().'\');">
					<div><img src="'.$file->getSRC().'" /></div>
					<p>'.$file->getName().'</p>
				    </div>';
				}
				break;
			    case 'media':
				if($file->isMedia()==true){
				    $thumbnailWidth = '275px';
				    $thumbnailHeight = 200;
				    $thumbnails .= '
				    <div class="thumbnail" onclick="onclickThumb(this, \''.$file->getSRC().'\');">
					<video controls style="width:100%;">
					  <source src="'.$file->getSRC().'" type="video/mp4">
					  <object data="'.$file->getSRC().'" width="320" height="240">
					    <embed src="'.$file->getSRC().'" width="320" height="240">
					  </object> 
					</video>
					<p>'.$file->getName().'</p>
				    </div>';
				}
				break;
			    case 'file':
				$thumbnailWidth = '100%';
				$thumbnailHeight = 20;
				if($count==1){
				    $bgColor = '#eaeaea';
				    $count = 0;
				}else{
				    $bgColor = '#ddd';
				    $count = 1;
				}
				$thumbnails .= '
				<div class="thumbnail" style="background:'.$bgColor.';" onclick="onclickThumb(this, \''.$file->getSRC().'\');">
				    <p style=\'text-align:left;\'><div style="padding-left:15px;">'.$file->getIcon().'<span style="padding-left:5px;">'.$file->getName(true).'</span></div></p>
				</div>';
				break;
			    default:echo $_GET['type']  . " ";break;
			}
		    }
		}
	    }
			
	}
    }
?>
<div class='sideNAVI'>
    <p style='margin:5px;'><a href='admin.php?action=<?php echo $_GET['action']."&type=".$_GET['type']."&root=".dirname($_GET['root']); ?>&layout=false'><button class='button blue' style='width:100%;'><img src='<?php echo $connect['url']; ?>/Sources/Admin/images/icons/folder_explore.png' /> <?php echo $language['directoryUp']; ?></button></a></p>
    <?php
	$color = 0;
	foreach($directoryArray as $value){
	    if($color==0){
		$bgColor = "f4f4f4";
		$color = 1;
	    }else{
		$bgColor = "ddd";
		$color = 0;
	    }
	    echo "
		<a href='admin.php?action=".$_GET['action']."&type=".$_GET['type']."&root=".$_GET['root']."/".$value."/&layout=false'>
		    <div style='border-top:1px solid #ccc;border-bottom:1px solid #ccc;margin-top:-1px;padding:7px;padding-top:5px;background:#".$bgColor.";'>
			<img src='".$connect['url']."/Sources/Admin/images/icons/folder.png' style='position:relative;top:2px;' /> " . $value . "
		    </div>
		</a>";
	    
	}
    ?>
</div>
<div class='fileContainer'>
    <div class='header' style='padding-top:2px;padding-bottom:2px;border-left:1px solid #ccc;background:#eee;'>
	<button class='root' id='selectedURL' style='position:relative;top:2px;'><?php echo $language['mediaUnselected']; ?></button>
	<button class='button blue' onclick='submitForm();' style='float:right;position:relative;top:2px;right:5px;'><img src='<?php echo $connect['url']; ?>/Sources/Admin/images/icons/accept.png'> <?php echo $language['add']; ?></button>
    </div>
    <?php echo $thumbnails; ?>
</div>
<div class='fileContainerEffect'></div>
<style>
    .thumbnail {
	<?php if($_GET['type'] != 'file') echo 'margin:10px;'; else echo 'margin:0 0 0 0;'; ?>
	background:#eee;
	outline:1px solid #aaa;
	<?php if($_GET['type'] != 'file') echo 'padding:5px;'; else echo 'padding:5px 0 5px 0;'; ?>
	width:<?php echo $thumbnailWidth; ?>;
	float:left;
	position:relative;
	z-index:200;
    }
    .thumbnail p {margin:0;text-align:center;text-overflow:ellipsis;<?php if($_GET['type'] != 'file') echo 'max-width:150px;'; ?>white-space: nowrap;overflow:hidden;}
    .thumbnail div {width:<?php echo $thumbnailWidth; ?>px;height:<?php echo $thumbnailHeight; ?>px;}
    .thumbnail img {max-width:100%;max-height:100%;}
    
    .sideNAVI {
	width:225px;
	position:fixed;
	top:0;
	left:0;
	bottom:0;
	border-right:1px solid #ccc;
	background:#eee;
	border-bottom-left-radius:5px;
	overflow-y:auto;
	<?php if($_GET['type'] == 'file') echo 'display:none;'; ?>
    }
    .fileContainer {
	position:fixed;
	top:0;
	left:225px;
	<?php if($_GET['type'] == 'file') echo 'left:0;'; ?>
	bottom:0;
	right:0;
	overflow-y:auto;
    }
    
    .fileContainerEffect {box-shadow:-10px 0px 20px 0px #fff;position:fixed;bottom:-10px;left:225px;right:0;height:10px;}
    
    a {text-decoration:none;color:#555;transition:.5s;}
    a:hover {color:#000;}
</style>
<script>
var parentWin = (!window.frameElement && window.dialogArguments) || opener || parent || top;
function onclickThumb(element, url){
    $('.thumbnail').css({
	background: '#eee',
	outline: '1px solid #ccc',
	color: '#000'
    });
    $(element).css({
	background: '#007eba',
	outline: '1px solid #00618f',
	color: '#fff'
    });
    
    $('#selectedURL').html(url);
    
}
function submitForm(){
    parentWin.document.getElementById(parentWin.fileInput).value = $('#selectedURL').html();parentWin.tinyMCE.activeEditor.windowManager.close();
}

    </script>