<?php if(isset($_GET['save']))echo "
<div class='notification' id='saveTrue'>
".$language['pageSaved']."
</div>
<script> $('#saveTrue').delay(2000).fadeOut(1000);</script>
"; 
?>
				<header>
					<div class='header'>
						<button class='root'><?php echo $language['files']; ?></button>
						<button class='root sub'><?php echo $_GET['root']; ?></button>
					</div>
				</header>
				<div id='content'>
					<?php
						include './Sources/Admin/fileSelect.php';
					?>
				</div>