<?php if(!$log==true)exit; ?>
				<header>
					<div class='header'>
						<button class='root'><?php echo $language['menu']; ?></button>
						<button class='button blue' style='float:right;margin-right:10px;margin-top:4px;' onclick='$("#newMenuItem_modal").fadeIn();'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/add.png'>".$language['newMenu']; ?></button>
						<a href='./admin.php?action=menuSide'><button class='button' style='float:right;margin-right:10px;margin-top:4px;'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/layout_edit.png'>".$language['menuSide'] . " " . $language['edit']; ?></button></a>
					</div>
				</header>
				<div id='content'>
					<?php echo displayMenuConfig(); ?>
				</div>
<?php 

    $menuContent = '
	<form action="admin.php?action=addmenuitem" method="POST">
	    <table style="width:80%;margin:0 auto;margin-top:30px;">
		<tr>
		    <td style="width:75px;">'.$language['name'].'
		    <td><input type="text" name="menuName" placeholder="'.$language['name'].'" title="" style="margin-left:-10px;display:Block;width:100%;" REQUIRED /></td>
		</tr>
		<tr>
		    <td>'.$language['menuPosition'].'
		    <td>
			<input type="number" name="menuPosition" value="0" style="margin-left:-10px;display:Block;width:25%;float:left;" REQUIRED/>
			<span style="position:relative;left:40px;top:8px;">'.$language['menuFrame'].'</span>
			<select name="menuFrame" style="display:block;width:40%;float:right;margin-right:-7px;">
			    <option value="_BLANK">'.$language['menuBlank'].'</option>
			    <option value="_SELF">'.$language['menuSelf'].'</option>
			    <option value="_TOP">'.$language['menuTop'].'</option>
			    <option value="_PARENT">'.$language['menuParent'].'</option>
			</select>
		    </td>
		</tr>
		<tr>
		    <td>'.$language['menuUrl'].'
		    <td>
			<input type="text" name="menuURL" id="menuURL" placeholder="http://www.example.com/" style="margin-left:-10px;display:Block;width:100%;border-radius:0 3px 3px 0;padding-right:100px;" REQUIRED />
			<button class="button" id="btnSelectPage" style="float:right;margin-top:-29px;margin-right:10px;">Selecteren</button>
		    </td>
		</tr>
		<tr>
		    <td>'.$language['menuDropIN'].'</td>
		    <td>'.displayMenuDrops().'</td>
		</tr>
	    </table>
	    <div class="modalFooter">
		<input type="submit" class="button submit" value="'.$language['create'].'" />
		<button class="button" onclick="$(\'#newMenuItem_modal\').fadeOut();return false;">'.$language['cancel'].'</button>
	    </div>
	</form>
    ';
    $menu = new Modal($language['newMenu'], 'newMenuItem_modal');
    $menu->setContent($menuContent);
    echo $menu->render();
    
    $pageModal = new pageModal();
    echo $pageModal->renderModal('btnSelectPage', '#menuURL');
	    ?>