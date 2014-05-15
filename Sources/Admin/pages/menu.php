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
				<div class='modal' id='newMenuItem_modal'>
				<div class='title'><?php echo $language['newMenu']; ?></div>
					<form action='admin.php?action=addmenuitem' method='POST'>
						<div class='cont'>
							<div class='headImage'></div>
							<table style='width:80%;margin:0 auto;margin-top:30px;'>
								<tr>
									<td style='width:75px;'>
										<?php echo $language['name']; ?>
									<td>
										<input type='text' name='menuName' placeholder='<?php echo $language['name']; ?>' title='' style='margin-left:-10px;display:Block;width:100%;' REQUIRED />
									</td>
								</tr>
								<tr>
									<td>
										<?php echo $language['menuPosition']; ?>
									<td>
										<input type='number' name='menuPosition' value='0' title='' style='margin-left:-10px;display:Block;width:25%;float:left;' REQUIRED/>
										<span style='position:relative;left:40px;top:8px;'><?php echo $language['menuFrame']; ?></span>
										<select name='menuFrame' style='display:block;width:40%;float:right;margin-right:-7px;'>
											<option value='_BLANK'><?php echo $language['menuBlank']; ?></option>
											<option value='_SELF'><?php echo $language['menuSelf']; ?></option>
											<option value='_TOP'><?php echo $language['menuTop']; ?></option>
											<option value='_PARENT'><?php echo $language['menuParent']; ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										<?php echo $language['menuUrl']; ?>
									<td>
										<input type='text' name='menuURL' placeholder='http://www.example.com/' title='' style='margin-left:-10px;display:Block;width:100%;' REQUIRED />
									</td>
								</tr>
								<tr>
									<td>
										<?php echo $language['menuDropIN']; ?>
									<td>
										<?php
											echo displayMenuDrops();
										?>
									</td>
								</tr>
							</table>
						</div>
						<input type='submit' class='submit' value='<?php echo $language['create']; ?>' />
					</form>
					<button class='button' onclick='$("#newMenuItem_modal").fadeOut();'><?php echo $language['cancel']; ?></button>
				
				</div>