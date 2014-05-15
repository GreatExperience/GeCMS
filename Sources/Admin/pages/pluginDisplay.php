<?php 
	if(!$log==true)exit;
?>
				<header>
					<div class='header'>
						<button class='root'><?php echo $language['plugins']; ?></button>
						<button class='root sub'><?php echo $_GET['plugin']; ?></button>
					</div>
				</header>
				<div id='content'>
					<?php
						if(file_exists("./Plugins/". $_GET['plugin'] ."/admin.plugin.php"))
							require_once("./Plugins/". $_GET['plugin'] ."/admin.plugin.php");
						else {
							echo "
								<div style='text-align:center;'><img src='./sources/admin/images/gelogo.png' style='width:15%;margin:0 auto;margin-top:10%;' /></div>
								<h1 style='font-size:80px;color:#555;text-align:center;'>File missing</h1>
								<p style='text-align:center;font-size:24px;'>This plugin has no method to change its settings</p>";
						}
					?>
				</div>