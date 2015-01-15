<?php		
    /* Anti hack */
    if(!$log)exit;
?>
				<header>
					<div class='header'>
						<button class='root'><?php echo $language['pages']; ?></button>
						<button class='root sub'><?php echo $_GET['root']; ?></button>
						<button class='button blue' style='float:right;margin-right:10px;margin-top:4px;' onclick='$("#newPage_modal").fadeIn();'><?php echo Icon::display('add.png') . $language['newPage']; ?></button>
					</div>
				</header>
				<div id='content'>
					<?php
						include './Sources/Admin/fileSelect.php';
				echo '</div>';
				
				    $newPageModalContent = "
					<form action='./admin.php?action=newPage' method='post' id='newPageForm'>
					<table style='width:90%;margin:0 auto;padding-top:25px;'>
								<tr>
								    <td style='width:125px;'>".Icon::display('note.png', array('style'=>'position:relative;top:3px;margin-right:3px;')). $language['name']."</td>
									<td><input type='text' style='width:260px;' name='name' id='newName' REQUIRED />.php</td>
								</tr>
								<tr>
									<td style='width:125px;'>
										<img src='./Sources/Admin/images/icons/sitemap_color.png' style='position:relative;top:3px;margin-right:3px;' />
										".$language['metaSettings']."
									</td>
									<td>
										<select style='width:100%;' name='meta' >
											<option value='0'>Default (Custom Coming soon)</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style='width:125px;'>
										<img src='./Sources/Admin/images/icons/layout.png' style='position:relative;top:3px;margin-right:3px;' />
										".$language['template']."
									</td>
									<td>
										<select style='width:100%;' name='template'>
											<option value='0'>Default</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style='width:125px;'>
										<img src='./Sources/Admin/images/icons/page_white_vector.png' style='position:relative;top:3px;margin-right:3px;' />
										".$language['pageDefault']."
									</td>
									<td>
										<select style='width:100%;' name='pagedefault'>
											<option>Blank</option>
											<option>Sidemenu-left (Coming soon)</option>
											<option>Sidemenu-Right (Coming soon)</option>
											<option>Sidemenu-left+right (Coming soon)</option>
										</select>
									</td>
								</tr>
							</table>
						    </div>
					</form>
					<div class='modalFooter'>
					    <button class='button blue' style='margin-right:10px;' onclick='submitNewPage();'>".$language['create']."</button>
					    <button class='button' onclick='$(\"#newPage_modal\").fadeOut();return false;'>".$language['cancel']."</button>
					</div>
				    ";
				    $newPageModal = new Modal($language['newPage'], 'newPage_modal');
				    $newPageModal->setContent($newPageModalContent);
				    echo $newPageModal->render();
				?>
<!--
				<div class='modal' id='newPage_modal'>
					<div class='title'><?php echo $language['newPage']; ?></div>
					<form action='./admin.php?action=newPage' method='post' id='newPageForm'>
						<div class='cont'>
							<div class='headImage'></div>
							<table style='width:90%;margin:0 auto;padding-top:25px;'>
								<tr>
								    <td style='width:125px;'><?php echo Icon::display('note.png', array('style'=>'position:relative;top:3px;margin-right:3px;')). $language['name']; ?></td>
									<td><input type='text' style='width:260px;' name='name' id='newName' REQUIRED />.php</td>
								</tr>
								<tr>
									<td style='width:125px;'>
										<img src='./Sources/Admin/images/icons/sitemap_color.png' style='position:relative;top:3px;margin-right:3px;' />
										<?php echo $language['metaSettings']; ?>
									</td>
									<td>
										<select style='width:100%;' name='meta' >
											<option value='0'>Default (Custom Coming soon)</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style='width:125px;'>
										<img src='./Sources/Admin/images/icons/layout.png' style='position:relative;top:3px;margin-right:3px;' />
										<?php echo $language['template']; ?>
									</td>
									<td>
										<select style='width:100%;' name='template'>
											<option value='0'>Default</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style='width:125px;'>
										<img src='./Sources/Admin/images/icons/page_white_vector.png' style='position:relative;top:3px;margin-right:3px;' />
										<?php echo $language['pageDefault']; ?>
									</td>
									<td>
										<select style='width:100%;' name='pagedefault'>
											<option>Blank</option>
											<option>Sidemenu-left (Coming soon)</option>
											<option>Sidemenu-Right (Coming soon)</option>
											<option>Sidemenu-left+right (Coming soon)</option>
										</select>
									</td>
								</tr>
							</table>
						</div>
					    <button class='button blue' style='margin-right:10px;' onclick='submitNewPage();'><?php echo $language['create']; ?></button>
					</form>
					<button class='button' onclick='$("#newPage_modal").fadeOut();'><?php echo $language['cancel']; ?></button>
				</div>-->
				