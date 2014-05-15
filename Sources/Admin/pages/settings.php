<?php if(!$log)exit; ?>
				<form action='./admin.php?action=saveSettings' method='post'>
					<header>
						<div class='header'>
							<span class='root'><?php echo $language['settings']; ?></span>
							<button class='button blue' style='float:right;margin-right:10px;margin-top:4px;'><?php echo "<img src='".$connect['url']."/Sources/Admin/images/icons/accept.png'>".$language['save']; ?></button>
						</div>
					</header>
					<div id='content'>
						<div class='left'>
							<div class='box'>
								<div class='title'><?php echo $language['basicSettings']; ?></div>
								<div class='pad'>
										<table style='width:100%;'>
											<tr>
												<td style='width:150px;'><?php echo $language['settingsWebsiteName']; ?></td>
												<td><input type='text' name='siteTitle' value='<?php echo $settings['siteTitle']; ?>' style='width:90%;' placeholder='<?php echo $language['settingsWebsiteName']; ?>' REQUIRED /></td>
											</tr>
											<tr>
												<td style='width:150px;'><?php echo $language['settingsWebsiteDescription']; ?></td>
												<td><input type='text' name='siteDescription' value='<?php echo $settings['siteDescription']; ?>' style='width:90%;' placeholder='<?php echo $language['settingsWebsiteDescription']; ?>' REQUIRED /></td>
											</tr>
											<tr>
												<td style='width:150px;'><?php echo $language['settingsWebsiteKeywords']; ?></td>
												<td><input type='text' name='siteKeywords' value='<?php echo $settings['siteKeywords']; ?>' style='width:90%;' placeholder='<?php echo $language['settingsWebsiteKeywords']; ?>' REQUIRED /></td>
											</tr>
											<tr>
												<td style='width:150px;'><?php echo $language['settingsWebsiteAuthor']; ?></td>
												<td><input type='text' name='siteAuthor' value='<?php echo $settings['siteAuthor']; ?>' style='width:90%;' placeholder='<?php echo $language['settingsWebsiteAuthor']; ?>'REQUIRED /></td>
											</tr>
											<tr>
												<td style='width:150px;'><?php echo $language['settingsWebsiteIndex']; ?></td>
												<td>
													<select name='siteRobots' style='width:93%;'>
														<option value='index, follow' <?php if($settings['siteRobots']=="index, follow")echo "SELECTED"; ?>><?php echo $language['settingsWebsiteIndexing'].", " . $language['settingsWebsiteFollow']; ?></option>
														<option value='noindex, follow' <?php if($settings['siteRobots']=="noindex, follow")echo "SELECTED"; ?>><?php echo $language['settingsWebsiteNoindex'].", " . $language['settingsWebsiteFollow']; ?></option>
														<option value='index, nofollow' <?php if($settings['siteRobots']=="index, nofollow")echo "SELECTED"; ?>><?php echo $language['settingsWebsiteIndexing'].", " . $language['settingsWebsiteNofollow']; ?></option>
														<option value='noindex, nofollow' <?php if($settings['siteRobots']=="noindex, nofollow")echo "SELECTED"; ?>><?php echo $language['settingsWebsiteNoindex'].", " . $language['settingsWebsiteNofollow']; ?></option>
														<option value='noimageindex' <?php if($settings['siteRobots']=="noimageindex")echo "SELECTED"; ?>><?php echo $language['settingsWebsiteNoImages']; ?></option>
														<option value='noimageclick' <?php if($settings['siteRobots']=="noimageclick")echo "SELECTED"; ?>><?php echo $language['settingsWebsiteNoImageRoot']; ?></option>
													</select>
												</td>
											</tr>
										</table>
										<div class='info message' style='margin:0;margin-top:10px;'><?php echo $language['settingsInfo']; ?></div>
										<div style='clear:both'></div>
									</form>
								</div>
							</div>
						</div>
						<div class='right'>
							<div class='box'>
								<div class='title'><?php echo $language['languageSettings']; ?> <button class='button' style='float:right;margin-top:0px;padding-top:7px;padding-bottom:6px;margin-right:10px;'><?php echo $language['languageBrowse'] ?></button></div>
								<div class='pad'>
									<select name='languageSettings' style='width:100%;'>
									<?php
										if ($handle = opendir("./Sources/Language")) {
											
											while (false !== ($entry = readdir($handle))) {
											
												if($entry!="."&&$entry!=".."){
													include "./Sources/Language/" . $entry . "/languageOptions.php";
												
													if( $entry == $settings['siteLanguage'] )
														echo "<option value='".$entry."' SELECTED>".$languageDisplay."</option>";
													else
														echo "<option value='".$entry."'>".$languageDisplay."</option>";
													
												}
											}
										}else{
											echo "Whoops! That didn't go well!!";
										}
									?>
									</select>
								</div>
							</div>
						</div>
						<div style='clear:both;'></div>
					</div>
				</form>