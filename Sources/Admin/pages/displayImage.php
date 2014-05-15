<?php 
	if(!$log==true)exit;
	
	if(!ISSET($_GET['image']))die("No image selected");
	
	$res = getimagesize( $_GET['image'] );

?>
				<header>
					<div class='header'>
						<button class='root'><?php echo $language['image']; ?></button>
						<span class='root sub' style='-o-user-select: text;user-select: text;-webkit-user-select: text;-moz-user-select: text;-ms-user-select: text;  '><?php echo $_GET['image']; ?></span>		
						<button class='root sub' style='margin-left:10px;' title='<?php echo $language['fileSize']; ?>'><?php echo fileSizeCalc( $_GET['image'] ); ?></button>
						<button class='root sub' title='Resolution'><?php echo $res[0] . "x" . $res[1] ; ?></button>
						
						<select style='float:right;margin-right:10px;margin-top:5px;' onchange='$("#imageDisplay").css("zoom", this.value)'>
							<option>30%</option>
							<option>40%</option>
							<option>50%</option>
							<option>75%</option>
							<option SELECTED>100%</option>
							<option>125%</option>
							<option>150%</option>
							<option>175%</option>
							<option>200%</option>
							<option>250%</option>
							<option>300%</option>
							<option>400%</option>
						</select>
						
						<select style='float:right;margin-right:10px;margin-top:5px;' onchange='$("#imageDisplay").css("background-repeat", this.value)'>
							<option SELECTED>no-repeat</option>
							<option>repeat-y</option>
							<option>repeat-x</option>
							<option>repeat</option>
						</select>
						<input type='range' style='float:right;' min='0' max='360' value='0' onchange='$("#imageDisplay").css("transform", "rotate(" + this.value + "deg)");$("#imageDisplay").css("WebKitTransform", "rotate(" + this.value + ")");'>
					</div>
					<script>
					</script>
				</header>
				<div style='overflow:hidden;position:absolute;top:41px;bottom:0;width:100%;'>
					<div id='imageDisplay' style='z-index:-1;width:100%;position:absolute;top:0px;bottom:0;background-image: url("<?php echo $_GET['image']; ?>"); background-position:center center;background-repeat:no-repeat;'></div>
				</div>