<?php
	/* System includes */
	require_once("./SSI.php");
        
	/* Anti hack */
	if(!$log==true)exit;
	
	/* Old functionality, will be changed to classes! */
	require_once($connect['root'] . "Sources/Admin/system.php");

        if(!isset($_GET['noScripts'])){
?><!DOCTYPE html>
<html>
	<head>
		<title>GeCMS admin panel</title>
		<meta content = " width = 500px; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" />
		<script type="text/javascript" src="<?php echo $connect['url'] . "Sources/Tinymce/tinymce.min.js"; ?>"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>
		<script src="<?php echo $connect['url']; ?>Sources/highCharts/js/highcharts.js"></script>
		<script src="<?php echo $connect['url']; ?>Sources/highCharts/js/modules/exporting.js"></script>
                <script type="text/javascript" src="<?php echo $connect['url']; ?>/sources/colorPicker/js/colorpicker.js"></script>
                <script type="text/javascript" src="<?php echo $connect['url']; ?>/sources/colorPicker/js/eye.js"></script>
                <script type="text/javascript" src="<?php echo $connect['url']; ?>/sources/colorPicker/js/utils.js"></script>
		<link href="./Sources/Admin/adminSources/index.css" type="text/css" rel="stylesheet" />
                <link rel="stylesheet" href="<?php echo $connect['url']; ?>/sources/colorPicker/css/colorpicker.css" type="text/css" />

		<style type='text/css'>			
			body .container {
				position:fixed;
				top:51px;
				left:201px;
				right:0;
				bottom:0;
				overflow:auto;
                                overflow-x:hidden;
				z-index:1001;
				<?php
					if(isset($_COOKIE['cmsAdminMenuCookie'])){
						if($_COOKIE['cmsAdminMenuCookie']==1)
							echo "left:66px;";
						else
							echo "left:201px;";
					}else{
						echo "left:201px;";
					}
				?>
			}
			<?php
				if(isset($_COOKIE['cmsAdminMenuCookie'])){
					if($_COOKIE['cmsAdminMenuCookie']==1)
						echo ".navText {display:none;}";
				}
			?>
			
			body .sideNav {
				<?php
					if(isset($_COOKIE['cmsAdminMenuCookie'])){
						if($_COOKIE['cmsAdminMenuCookie']==1)
							echo "width:65px;";
						else
							echo "width:200px;";
					}else{
						echo "width:200px;";
					}
				?>
				z-index:1000;
			}

			
			
			<?php
			
				if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']))
				echo "
					#displayText, #settingsText, #bigBlueResize {display:none;}
					.search {max-width:100px;}
					.container {left:0;}
					#sidemenu {width:100%;transition:0.5s;}
					.right, .left, .modal {float:none;width:100%;}
					/*#content {zoom:0.65;}*/
					.header .button {font-size:0px;top:-2px;}
					
				";
		?>
		</style>
		<script>
			var small = false;
			function navSwitch() {
				if(small==false){
					$(".navText").fadeOut(0);
					$(".sideNav").css("width","65px");
					$(".container").css("left","66px");
					setCookie("cmsAdminMenuCookie", 1,365);
					small = true;
				}else{
					$(".navText").fadeIn();
					$(".sideNav").css("width","200px");
					$(".container").css("left","201px");
					setCookie("cmsAdminMenuCookie", 0,365);
					small = false;
				}
			}
			
			function getCookie(c_name){
				var c_value = document.cookie;
				var c_start = c_value.indexOf(" " + c_name + "=");
			if (c_start == -1)
			  {
			  c_start = c_value.indexOf(c_name + "=");
			  }
			if (c_start == -1)
			  {
			  c_value = null;
			  }
			else
			  {
			  c_start = c_value.indexOf("=", c_start) + 1;
			  var c_end = c_value.indexOf(";", c_start);
			  if (c_end == -1)
			  {
			c_end = c_value.length;
			}
			c_value = unescape(c_value.substring(c_start,c_end));
			}
			return c_value;
			}

			function setCookie(c_name,value,exdays)
			{
			var exdate=new Date();
			exdate.setDate(exdate.getDate() + exdays);
			var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
			document.cookie=c_name + "=" + c_value;
			}

			$( document ).ready(function() {
				if($('body').width()<700){resize();$("#sideMenu").css("left","-" + document.body.clientWidth + "px");}
			
				$( ".mobileSearch" ).click(function() {
				    $( "#mobileSearchInput" ).focus();
				});
				$( "#mobileSearchInput" ).focus(function() {
				  $(".mobileSearch").css( "background", "#c9ddec" );
				});
				$( "#mobileSearchInput" ).focusout(function() {
				    $(".mobileSearch").css( "background", "#fff" );
				});
			});
			
			function toggleNavMobile(){
			    $("#mobileMenu").toggle();
			}
		</script>
	</head>
        <body><?php } if(!isset($_GET['layout'])){ ?>
		<nav>
			<div class='nav'>
			    <img src='./Sources/Admin/images/template/menuSwitch.png' onclick='toggleNavMobile()' id="mobileMenuToggler">
			    <h1 id='logoTitle'>Great Experience CMS</h1> <h2 class="websiteURL"><?php echo Icon::display('world.png', array('style' => 'margin-right:5px;position:relative;top:3px;'));echo $connect['url']; ?></h2>
			    <div class='toRight'>
					<form action='admin.php?action=search' method='post' onsubmit='exit;'><input class='search' name='search' id='search' placeholder='Search...' /></form>
				</div>
				<a href='./admin.php?action=settings'>
					<div class='menuContainer'>
						<img src='<?php echo $connect['url'] . "Sources/Admin/images/template/settings.png"; ?>' />
						<span id='settingsText'><?php echo $language['settings']; ?></span>
					</div>
				</a>
				<a href='#'>
					<div class='menuContainer' onclick='window.open("./");'>
						<img src='<?php echo $connect['url'] . "Sources/Admin/images/template/display.png"; ?>' />
						<span id='displayText'><?php echo $language['displayWebsite']; ?></span>
					</div>
				</a>
				<div class='menuContainer' style='border-left:0;cursor:auto;'>
				</div>
			</div>
		</nav>
		<aside>
			<div class='sideNav' id='sideMenu'>
			    <p style='text-align:center;margin:0;' id='bigBlueResize'>
					<button class='button blue' onclick='navSwitch();' style='width:100%;border-radius:0;margin:0 auto;padding:8px;margin-top:-1px;'><img src='./Sources/Admin/images/template/menuSwitch.png' /></button>
				</p>
			    <?php echo Sidemenu::render(); ?>
			</div>
		    
			<div class='mobileNav' id='mobileMenu'>
			    <div class='mobileSearch'>
				    <img src='./Sources/Admin/images/search.png' />
				    <form action='admin.php?action=search' method='post' onsubmit='exit;'><input class='mobileSearchInput' name='search' id='mobileSearchInput' placeholder='Search...' /></form>
				</div>
			    <?php echo Sidemenu::render(); ?>
			</div>
		</aside>
		<section>
			<div class='container'>
				<?php
}
try {
		if(isset($_GET['action'])) {
                    if(file_exists($connect['root'] . "Sources/Admin/pages/".$_GET['action'].".php")){
			require_once($connect['root'] . "Sources/Admin/pages/".$_GET['action'].".php");
                    }else{
			$cmsError = $language['performError'];
			include $connect['root'] . "Sources/Admin/404.php";
                    }
		}else{
                    require_once($connect['root'] . "Sources/Admin/pages/index.php");
		}
} catch (Exception $e) {
    Error::render($e->getMessage());
}
					
					if(isset($_GET['note'])){
						echo "
				<div class='notification' id='saveTrue'>
				".$_GET['note']."
				</div>
				<script> $('#saveTrue').delay(2000).fadeOut(1000);</script>";
					}
if(!isset($_GET['layout'])){
				?>
			</div>
			
			<!-- For AJAX load requests -->
			<div id='hidden'></div>
			
		</section>
		<noscript id='javascript'>
			<div class='box' style='width:450px;margin:0 auto;border-radius:0;box-shadow:0px 0px 35px -5px #000;'>
				<h1 style='text-align:center;margin-top:-15px;'>
					<img src='./Sources/Admin/images/gelogo.png' style='width:90px;position:relative;top:40px;left:-10px;'>Great Experienced
				</h1>
				<h3 style='text-align:center;margin-top:50px;margin-bottom:25px;color:#666;'>Please enable JavaScript!</h3>
			</div>
		</noscript>
<?php } if(!isset($_GET['noScripts'])){ ?>
	</body>
</html><?php } ?>