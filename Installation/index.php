<h1>Welcome!</h1>
<p style='max-width:1000px'>Welcome to the easy installer of GeCMS! You just 3 steps away from using the most usefull Content Management Systems for informative websites available! Please select a database below to start the installation:</p>

<h1>Requirements of GeCMS</h1>

<p style='max-width:1000px'>
    These are technical requirements we have checked for you. If there is a red icon you should fix it or call a system administrator to. Note that file writing is only checked for a single file in the GeCMS project. GeCMS needs full acces to file read/writing in its directory. For example to create a page.
		<ul style='list-style-type:none;'>
<?php
		$requiments = true;
		/* check file writing */
		if (is_readable(__FILE__) && is_writable(__FILE__)){
		    echo "<li><img src='./Sources/Admin/images/icons/accept.png' style='position:relative;top:3px;' /> File read/write access</li>";
		}else{
		    echo "<li><img src='./Sources/Admin/images/icons/exclamation.png' style='position:relative;top:3px;' /> File read/write access <u>not allowed</u>!</li>";
		    $requiments = false;
		}
		
		/* check php version */
		if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
		    echo "<li><img src='./Sources/Admin/images/icons/accept.png' style='position:relative;top:3px;' /> PHP version 5.3.X with a working PDO driver</li>";
		}else{
		    echo "<li><img src='./Sources/Admin/images/icons/exclamation.png' style='position:relative;top:3px;' /> Your php version is <u>not supported</u> by GeCMS!</li>";
		    $requiments = false;
		}
		
		
		/* check for php database objects */
		if (class_exists('PDO')){
		    
		    $ARR_DRIVERS = array();	//NOT SUPPORTED YET IN THE BETA!
		    $CountDrivers = 0;
		    foreach(PDO::getAvailableDrivers() AS $DRIVERS){
			$CountDrivers++;
			$ARR_DRIVERS[$CountDrivers] = $DRIVERS;
		    }
		    
		    if($CountDrivers > 0){
			 echo "<li><img src='./Sources/Admin/images/icons/accept.png' style='position:relative;top:3px;' /> A working PHP Database Object Driver (SQL Database)</li>";
		    }else{
			echo "<li><img src='./Sources/Admin/images/icons/exclamation.png' style='position:relative;top:3px;' /> No working SQL database found</li>";
			$requiments = false;
		    }
		    
		}else{
		    echo "<li><img src='./Sources/Admin/images/icons/exclamation.png' style='position:relative;top:3px;' /> Your hosting does not support PHP Database Objects!</li>";
		    $requiments = false;
		}
?>
		</ul>

</p>
<h1>Let's start!</h1>
<p style='max-width:1000px'>Select a database below you want to use for your website! In GeCMS we save some important information into the database. It is nercassy to connect to a specifique database!</p>
<form action='./install.php?step=2' id='selectDB' method='post'>
<?php 
    if($requiments==true){
?>
    <select class='input' name='database' style='margin:0;margin-top:10px;margin-bottom:50px;' onchange='$("#selectDB").submit();'>
	<option> - Select a database to start the installation - </option>
	<option value='mysql'>MySQL</option>
    </select>
<?php 
    }else{
	echo "<p style='text-decoration:underline;'>Please check the Requirements of GeCMS before starting the installation of GeCMS!</p>";
    }
?>
</form>

<script>
    $('.step').css({'width': '0%'});
    $('.step').animate({'width': '25%'});
</script>