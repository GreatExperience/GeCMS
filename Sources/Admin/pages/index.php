				<header>
					<div class='header'>
						<button class='root'>Dashboard</button>
					</div>
				</header>

				<div id='content'>
				    <div style='margin-right:20px'>
					<div id='chartViews' style='max-width:100% !important;'></div>
				    </div>
					<div class='left'>
						<div class='box'>
							<div class='title'><?php echo $language['start']; ?></div>
							<div class='pad'>
								<a href='./admin.php?action=pagelist&root=./Sources/Pages'>
									<div class='tile'>
										<img src='<?php echo $connect['url'] . "Sources/Admin/images/dashboard/page.png"; ?>' />
										<p><?php echo $language['pages'] ?></p>
									</div>
								</a>
								<a href='./admin.php?action=menu'>
									<div class='tile'>
										<img src='<?php echo $connect['url'] . "Sources/Admin/images/dashboard/menu.png"; ?>' />
										<p><?php echo $language['menu'] . " " . $language['manager']; ?></p>
									</div>
								</a>
								<a href='./admin.php?action=plugins'>
									<div class='tile'>
										<img src='<?php echo $connect['url'] . "Sources/Admin/images/dashboard/addon.png"; ?>' />
										<p><?php echo $language['pluginManager']; ?></p>
									</div>
								</a>
								<a href='./admin.php?action=newsManager'>
								    <div class='tile'>
									<img src='<?php echo $connect['url'] . "Sources/Admin/images/dashboard/news.png"; ?>' />
									<p>News manager</p>
								    </div>
								</a>
								<a href='./admin.php?action=media&root=./Media'>
									<div class='tile'>
										<img src='<?php echo $connect['url'] . "Sources/Admin/images/dashboard/media.png"; ?>' />
										<p>Media</p>
									</div>
								</a>
								<div class='tile' onclick='alert("Not yet available on the beta!");'>
									<img src='<?php echo $connect['url'] . "Sources/Admin/images/dashboard/admin.png"; ?>' />
									<p>Administration</p>
								</div>
								<a href='http://www.greatexperience.org/community/' target='_BLANK'>
								    <div class='tile'>
									    <img src='<?php echo $connect['url'] . "Sources/Admin/images/dashboard/support.png"; ?>' />
									    <p>Support</p>
								    </div>
								</a>
								<div class='tile' onclick='alert("Not yet available on the beta!");'>
									<img src='<?php echo $connect['url'] . "Sources/Admin/images/dashboard/backup.png"; ?>' />
									<p>Backup manager</p>
								</div>
								<div style='clear:both'></div>
							</div>
						</div>
							    <?php
							    
							    $pluginCount = 0;
							    $pluginsLoop = "";
							    /* Open directory */
							    if ($handle = opendir("./Plugins/")) {
								
								/* Read directory */
								while (false !== ($entry = readdir($handle))) {
									
									/* Remove directory up */
									if($entry!="."&&$entry!=".."){
									    
									    $pluginCount++;
									    $icon = "";
									    if( file_exists($connect['root'] . "/Plugins/" . $entry . "/icon.png"))
										    $icon = "<img src='./Plugins/".$entry."/icon.png' />";
									    $pluginsLoop .= "<a href='?action=pluginDisplay&plugin=".$entry."'><button class='button blue'>".$icon." ".$entry."</button></a>";
									}
								}
							    }
							    if($pluginCount==0)
								$pluginsLoop = $language['pluginsNoActive'];
							    
							    ?>
						<div class='box' style='margin-top:10px;'>
							<div class='title'><img src='<?php echo $connect['url']; ?>/Sources/Admin/images/icons/plugin.png' class='iconFix'/><?php echo $language['pluginsActive'] . " (".$pluginCount.")"; ?><a href='./admin.php?action=plugins'><button class='button' style='float:right;margin-top:0px;padding-top:7px;padding-bottom:6px;margin-right:10px;'><?php echo $language['manager'] ?></button></a></div>
							<div class='pad'>
							    <?php echo $pluginsLoop; ?>
							</div>
						</div>
						<div class='box' style='margin-top:10px;'>
							<?php
							if ($handle = opendir("./Templates/")) {

									/* Use global variable */
									$rows = "";
									$templates = 0;

									/* This is the correct way to loop over the directory. */
									while (false !== ($entry = readdir($handle))) {
										if($entry!="."&&$entry!=".."){

											/* Get Preview image */
											if(file_exists("./Templates/" . $entry . "/pre.png")){
												$rows .= "<a href='./admin.php?action=media&root=./Templates/".$entry."'><img class='tile' title='".$entry."' src='./Templates/" . $entry . "/pre.png' style='float:left;margin-right:10px;width:100px;height:100px;' /></a>";
											}else{
												$rows .= "<a href='./admin.php?action=media&root=./Templates/".$entry."'><div class='tile' title='".$entry."' style='margin-right:10px;float:left;width:100px;height:100px;line-height:100px;border:1px solid #bbb;background:#ccc;text-align:center;font-size:64px;color:#888;font-weight:bold;'>?</div></a>";
											}
											$templates++;
										}
									}
								}
								?>
							<div class='title'><img src='<?php echo $connect['url']; ?>/Sources/Admin/images/icons/rainbow.png' class='iconFix'/><?php echo $language['templates']; ?> (<?php echo $templates; ?>) <a href='./admin.php?action=templates'><button class='button' style='float:right;margin-top:0px;padding-top:7px;padding-bottom:6px;margin-right:10px;'><?php echo $language['manager'] ?></button></a></div>
							<div class='pad'>
								<?php echo $rows; ?>
								<div style='clear:both;'></div>
							</div>
						</div>
					    <?php
						$totalSpace = disk_total_space("./");
						$freeSpace = disk_free_space("./");
						$usedSpace = $totalSpace-$freeSpace;
						$percentageSpace = round($freeSpace / $totalSpace, 2)*100;
					    ?>
					    <div class="box" style="margin-top:10px;">
						<div class="title">Storage</div>
						<table style="width:100%;padding:10px;font-size:14px;">
						    <tr>
							<td><span class="darkText"><?php echo System::getByte($freeSpace) . ' (' . $percentageSpace . '%)'; ?></span> Ruimte beschikbaar</td>
							<td><span class="darkText"><?php echo System::getByte($usedSpace); ?></span> Ruimte gebruikt</td>
						    </tr>
						</table>
					    </div>
					</div>
					<div class='right'>
						<div class='box'>
							<div class='title'><img src='<?php echo $connect['url']; ?>/Sources/Admin/images/icons/newspaper.png' class='iconFix'/><?php echo $language['news']; ?></div>
							<table class='table' style='width:100%;border:0;margin-top:0;'>
							    <thead>
								<tr>
								    <th style='padding-left:10px;'>
									<img src='<?php echo $connect['url']; ?>/Sources/Admin/images/icons/pencil.png' class='iconFix'/><?php echo $language['title']; ?>
								    </th>
								    <th>
									<img src='<?php echo $connect['url']; ?>/Sources/Admin/images/icons/date.png' class='iconFix'/><?php echo $language['date']; ?>
								    </th>
								</tr>
							    </thead>
								<?php
								
								    $query = $dbh->prepare("SELECT * FROM ".$connect['ext']."news_items ORDER BY id DESC LIMIT 0, 10");
								    $query->execute();
								    
								    while($row = $query->fetchObject()){
									
									echo "
							    <tr>
								<td style='padding-left:10px;'>".$row->title."</td>
								<td>".$row->dateDay." ".$language['month'.$row->dateMonth]." ".$row->dateYear."</td>
							    </tr>";
								    
								    }
								    
								?>
						    </table>
						</div>
						<form action='./admin.php?action=saveDO&return=index&root=' method='post'>
							<div class='box' style='margin-top:10px;'>
								<div class='title'>
								    <img src='<?php echo $connect['url']; ?>/Sources/Admin/images/icons/note.png' class='iconFix'/> 
								    <?php echo $language['toDo']; ?>
								    <button class='button' style='float:right;margin-top:0px;padding-top:4px;padding-bottom:6px;margin-right:10px;'><img src='<?php echo $connect['url']; ?>/Sources/Admin/images/icons/note_edit.png' class='iconFix'/><?php echo $language['save'] ?></button>
								</div>
								<div class='pad' style='padding:0;margin-top:-1px;margin-bottom:-1px;'>
									<textarea name='content' id='editor1'><?php echo $settings['adminToDo']; ?></textarea>
								</div>
								</div>
							</div>
						</form>
					</div>
					<div style='clear:both;'></div>
					<script>
						tinymce.init({
							selector: "#editor1",
							plugins: [
								"advlist autolink lists link image charmap print preview anchor",
								"searchreplace visualblocks code fullscreen",
								"insertdatetime media table contextmenu paste moxiemanager"
							],
							menu: {
								file: {title: 'File'},
								edit: {title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace'},
								insert: {title: 'Insert', items: 'inserttable image media link | hr charmap'},
								format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
								tools: {title: 'Tools', items: 'code'}
							},
							toolbar: "undo redo  styleselect  bold italic  alignleft aligncenter alignright alignjustify  bullist numlist"
						});
						
			
						    
<?php

$chart = new pageChart('chartViews');
//$chart->setAmount(10);
$chart->setInterval(true);
$chart->executeQuery();
echo $chart->renderChart();
?>
    
					</script>

				<?php
				
				$a = new Modal('Test modal', 'test');
$a->setContent('de uber content van de modal <div class="modalFooter"><button class="button">Annuleer</button><button class="button blue">Activeer</button></div>');
echo $a->render();
?>
				<button onclick='$("#test").fadeIn();'>test</button>