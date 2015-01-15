<?php 
    if(!$log==true)exit;
	
    /* Select default template */
    $default = $dbh->prepare("SELECT value FROM ".$connect['ext']."settings WHERE name='siteTemplate'");
    $default->execute();
    $default = $default->fetchObject();
	
    /* Check if able to open directory */
    $directory = new Folder("./Templates/");
    $files = $directory->getDirectoryFiles();
    
    if( ! $files){
        Throw Exception("No templates found");
    }
    
    $rows = "";
    $templates = 0;
    $menuModalContent = '
        <button class="button" onclick="$(\'#newTemplateModal\').fadeIn();$(\'#menuModal\').fadeOut();" style="width:90%;margin:0 auto;margin-top:5px;left:-5%;position:relative;">'.$language['newTemplate'].'</button>
        <button class="button" onclick="$(\'#installTemplates\').fadeIn();$(\'#menuModal\').fadeOut();" style="width:90%;margin:0 auto;margin-top:5px;left:-5%;position:relative;">'.$language['newTemplateThirdParty'].'</button>
    ';
    $menuModal = new Modal($language['newTemplate'], 'menuModal');
    $menuModal->setContent($menuModalContent);
    $menuModal->setWidth(300);
    $menuModal->setHeight(125);
    $menuModal->setHeader(false);
    echo $menuModal->render();
    
    $newTemplateModalContent = '
        <div class="left" style="width:50%;position:relative;height:100%;">
            <div style="padding:5%;padding-top:0;">
                <h1>'.$language['information'].'</h1>
                <p><strong>'.$language['name'].'</strong>       <input type="text" placeholder="'.$language['name'].'" style="width:100%" /></p>
                <p><strong>'.$language['author'].'</strong>     <input type="text" placeholder="'.$language['author'].'" style="width:100%" /></p>
                <p><strong>'.$language['license'].'</strong><br/>    <textarea class="input" type="text" style="width:90%;height:calc(100% - 250px);position:absolute;"></textarea></p>
            </div>
        </div>
        <div class="right" style="width:50%;height:100%;position:relative;">
            <div style="padding:5%;padding-top:0;position:relative;height:75%;box-sizing:border-box;">
                <h1>'.$language['look'].'</h1>
                <div class="lookIMG selected" onclick="lookFunction(this);">
                    <div class="lookHeader">Header</div>
                    <div class="lookMenu">Menu</div>
                    <div class="lookContainer"><div class="lookContent">Content</div></div>
                    <div class="lookFooter">Footer</div>
                </div>
                <div class="lookIMG" onclick="lookFunction(this);">
                    <div class="lookHeader">Header</div>
                    <div class="lookMenu">Menu</div>
                    <div class="lookContainer">
                        <div class="lookContent">Content</div>
                        <div class="lookFooter">Footer</div>
                    </div>
                </div>
                <div class="lookIMG containerFull" onclick="lookFunction(this);">
                    <div class="lookContainer">
                        <div class="lookHeader">Header</div>
                        <div class="lookMenu">Menu</div>
                        <div class="lookContent">Content</div>
                        <div class="lookFooter">Footer</div>
                    </div>
                </div>
                <div class="lookIMG" onclick="lookFunction(this);">
                    <div class="lookHeader">Header</div>
                    <div class="lookMenu">Menu</div>
                    <div class="lookContainer"><div class="lookContent">Content</div></div>
                    <div class="lookFooter">Footer</div>
                </div>
                <div class="lookIMG" onclick="lookFunction(this);">
                    <div class="lookHeader">Header</div>
                    <div class="lookMenu">Menu</div>
                    <div class="lookContainer"><div class="lookContent">Content</div></div>
                    <div class="lookFooter">Footer</div>
                </div>
                <div class="lookIMG" onclick="lookFunction(this);">
                    <div class="lookHeader">Header</div>
                    <div class="lookMenu">Menu</div>
                    <div class="lookContainer"><div class="lookContent">Content</div></div>
                    <div class="lookFooter">Footer</div>
                </div>
                <select id="lookSelect" style="display:none;">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                </select>
            </div>
        </div>
        <div style="clear:both"></div>
        <div class="modalFooter">
            <button class="button blue">'.$language['add'].'</button>
        </div>
    ';
    $newTemplateModal = new Modal($language['newTemplate'], 'newTemplateModal');
    $newTemplateModal->setContent($newTemplateModalContent);
    $newTemplateModal->setWidth(80, '%');
    $newTemplateModal->setHeight(60, '%');
    $newTemplateModal->setHeader(false);
    echo $newTemplateModal->render();
            
    $boolEven = false;
    
    foreach($files as $key => $entry) {
        
        /* reset template variables */
        unset($templateVersion);
        unset($templateCmsVersion);
        unset($templateLicense);
        unset($templateEditable);
        
        /* Template admin settings */
        if(file_exists($connect['root'] . './Templates/'.$entry.'/admin.template.php')){
            include $connect['root'] . './Templates/'.$entry.'/admin.template.php';
        }
        
        /* Use global variable */
	$rows = "";
	$templates = 0;	
        $img = (file_exists('./Templates/'.$entry.'/pre.png') ? '<img src="./Templates/'.$entry.'/pre.png" />' : '<div class="imageEmpty">?</div>');
	$editURL = (isset($templateEditable) && $templateEditable===true ? './admin.php?action=templateEditor&template='.$entry : './admin.php?action=media&root=./Templates/'. $entry);
        
	if($default->value==$entry){
            $buttons = "
		<button class='button yellow' style='width:100%;margin-top:5px;margin-bottom:3px;'>".$language['templateIsDefault']."</button>
		<br />
		<a href='$editURL'><button class='button' style='width:100%'>".$language['templateEdit']."</button></a>";
	}else{
            $setDefaultModalContent = "
                <form action='./admin.php?action=saveDefault&template=".$entry."' method='post'>
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
                    <div class='modalFooter'>
                        <input class='button submit' type='submit' class='submit' value='".$language['templateSetDefault']."' />
                        <button class='button' onclick='$(\"#asdefault".$entry."\").fadeOut();return false;'>".$language['cancel']."</button>
                    </div>
                </form>
            ";
            $setDefaultModal = new Modal($language['template'] . ' ' . $entry . ' ' . $language['templateSetDefault'], 'asdefault'.$entry);
            $setDefaultModal->setContent($setDefaultModalContent);
            
            $deleteTemplateModalContent = '
                <p style="margin:0 auto;margin-top:20px;font-size:14px;">'.$language['deleteOne'].' <u>'.$entry.'</u> '.$language['deleteTwo'].'</p>
                <div class="modalFooter">
                    <a href="./admin.php?action=deleteTemplate&template='.$entry.'"><button class="button red" style="margin-right:10px;">'.$language['delete'].'</button></a>
                    <button class="button" onclick="$(\'#deletetemplate'.$entry.'\').fadeOut();">'.$language['cancel'].'</button>
                </div>
            ';
            $deleteTemplateModal = new Modal($entry . ' '. $language['delete'], 'deletetemplate'.$entry);
            $deleteTemplateModal->setContent($deleteTemplateModalContent);
            $buttons = "
		<button onclick='$(\"#asdefault".$entry."\").fadeIn();' class='button blue' style='width:100%;margin-top:5px;margin-bottom:3px;'>".$language['templateSetDefault']."</button>
                <br />
                <a href='".$editURL."'><button class='button' style='width:100%;margin-bottom:3px;'>".$language['templateEdit']."</button></a>
                <br />
                <button onclick='$(\"#deletetemplate".$entry."\").fadeIn();' class='button red' style='width:100%'>".$language['templateDelete']."</button>
		".$setDefaultModal->render().$deleteTemplateModal->render();
	}
				
	$row .= "
            <div class='box' style='margin-top:10px;width:calc(50% - 5px);float:".($boolEven ? 'right' : 'left').";'>
		<div class='title'>".$entry." ".$language['template']."</div>
                <div style='padding:5px;'>
                    <table style='width:100%;border-collapse:collapse;'>
                        <tr>
                            <td style='width:135px;'>".$img."</td>
                            <td style='text-align:left;vertical-align:top;'>
                                <strong>".$language['templateVersion']."</strong>
                                <p style='margin-top:0;'>".(isset($templateVersion) ? $templateVersion : 'Undefined')."</p>

                                <strong>".$language['templateCmsVersion']."</strong>
                                 <p style='margin-top:0;'>".(isset($templateCmsVersion) ? $templateCmsVersion : 'Undefined')."</p>

                                <strong>".$language['license']."</strong>
                                <p style='margin-top:0;'>".(isset($templateLicense) ? $templateLicense : 'Undefined')."</p>
                            </td>
                            <td style='width:150px;vertical-align:top;text-align:Center;border-left:1px solid #bbb;padding-left:7px;'>
                                <strong><img src='./Sources/Admin/images/icons/bullet_wrench.png' style='position:relative;top:3px;'/>".$language['options'].":</strong>
                                ".$buttons."
                            </td>
                        </tr>
                    </table>
                </div>
            </div>";
        
            $boolEven = ($boolEven==true ? false : true);
            $templates++;

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
        $packageDirectory = new Folder('./Packages/Templates/');
        $packageFiles = $packageDirectory->getDirectoryFiles();
        
        foreach($packageFiles as $entry){
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
                
                $packagesDeleteModalContent = "
                    <p style='text-align:center;'>".$language['deleteOne']." ".$entry." ".$language['deleteTwo']."</p>
                    <table class='ignore' style='width:90%;margin:0 auto;text-align:left;'>
                            <tr><td>".$language['file']."</td>              <td>".$entry."</td></tr>
                            <tr><td>".$language['fileType']."</td>          <td>".checkfiletype("./Packages/Templates/" . $entry)."</td></tr>
                            <tr><td>".$language['fileSize']."</td>          <td>".fileSizeCalc("./Packages/Templates/" . $entry)."</td></tr>
                            <tr><td>".$language['filePermissions']."</td>   <td>".fileperms("./Packages/Templates/" . $entry)."</td></tr>
                            <tr><td>".$language['fileLastEdit']."</td>      <td>".date ("d M Y H:i:s", filemtime("./Packages/Templates/" . $entry))."</td></tr>
                    </table>
                    <div class='modalFooter'>
                        <a href='./admin.php?action=deletePage&root=./Packages/Templates&file=".$entry."&return=".$_GET['action']."'><button class='button red' style='margin-right:10px;'>".$language['delete']."</button></a>
                        <button class='button' onclick='$(\"#deleteTemplate_modal_file".$fileId."\").fadeOut(300);'>".$language['cancel']."</button>
                    </div>
                ";
                
                $packagesDeleteModal = new Modal('deleteTemplate_modal_file'.$fileId, 'deleteTemplate_modal_file'.$fileId);
                $packagesDeleteModal->setContent($packagesDeleteModalContent);
                $packageModals .= $packagesDeleteModal->render();
                $fileId++;
            }
		
            /* No packages? Display error */
            if( ! $packagesAmount > 0 )
                $packageEcho .= "<tr><td colspan='2'>".$language['noPackages']."</td></tr>";
	}
	
	$packageEcho .="</table>";
        
        $installContent = '
            <div class="modalFooter">
                <button class="button" onclick="$(\'#installTemplates\').fadeOut();" style="margin-right:10px;">'.$language['cancel'].'</button>
		<button class="button blue" onclick="$(\'#upload_dialog_templatePackage\').fadeIn();" style="margin-right:10px;">'.$language['template'] . ' ' . $language['uploading'].'</button>
            </div>
        ';
        $installModal = new Modal($language['templateInstall'], 'installTemplates');
        $installModal->setContent($packageEcho . $packageModals . $installContent);
        $installModal->setHeader(false);
        echo $installModal->render();
?>
				<header>
					<div class='header'>
                                            <button class='root'><?php echo $language['templates']; ?></button>
                                            <button class='root sub'><?php echo $templates; ?></button>
                                            <button class='button blue' onclick='$("#menuModal").fadeIn();' style='float:right;margin-right:10px;margin-top:4px;' onclick='$("#newPage_modal").fadeIn();'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/package_go.png'>"; ?><?php echo $language['templateInstall'] . ($packagesAmount>0 ? " (" . $packagesAmount . ")" : '');?></button>
                                            <button class='button' style='float:right;margin-right:10px;margin-top:4px;' onclick='$("#menuModal").fadeIn();'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/cart_add.png'>".$language['downloadTemplates']; ?></button>
					</div>
				</header>
				<div id='content'>
                                    <?php
					echo $row;
                                        echo $installModal->render();
                                        echo uploadFileForm("./Packages/Templates/", "templatePackage") 
                                    ?>
				</div>
<script>
    function lookFunction(selector){
        $('.lookIMG').removeClass('selected');
        $(selector).addClass('selected');
    }
</script>
<style>
  .lookIMG {
    width:30%;margin:1%;border:2px solid #ccc;float:left;
    height:calc(50% - 15px);color:#fff;position:relative;
  }
  .lookIMG .lookContainer {padding-top:auto;}
  .lookIMG .lookHeader {background:#0094FF;height:20%;text-align:center;line-height:100%;position:relative;}
  .lookIMG .lookMenu {background:#002D56;height:10%;text-align:center;line-height:100%;position:relative;}
  .lookIMG .lookContainer {width:80%;margin:0 auto;position:relative;height:50%;}
  .lookIMG .lookContent {background:gray;height:100%;text-align:center;position:relative;line-height:100%;}
  .lookIMG .lookFooter {background:#002D56;height:20%;text-align:center;position:relative;line-height:100%;}
  
  .lookIMG.selected .lookHeader {background:#7F0000 !important;}
  .lookIMG.selected .lookMenu {background:#FF0000 !important;}
  .lookIMG.selected .lookFooter {background:#FF0000 !important;}
  .lookIMG.containerFull .lookContainer {height:100% !important;margin-top:5%;}
  .lookIMG.containerFull .lookContent {height:40%;}
</style>