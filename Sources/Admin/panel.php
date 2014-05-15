<?php
	/* System includes */
	require_once("./SSI.php");
        
	/* Anti hack */
	if(!$log==true)exit;
	
	/* Old functionality, will be changed to classes! */
	require_once($connect['root'] . "Sources/Admin/system.php");
	
?><!DOCTYPE html>
<html>
	<head>
		<title>GeCMS admin panel</title>
		<meta content = " width = 500px; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" />
		<script type="text/javascript" src="<?php echo $connect['url'] . "Sources/Tinymce/tinymce.min.js"; ?>"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>
		<script src="<?php echo $connect['url']; ?>Sources/highCharts/js/highcharts.js"></script>
		<script src="<?php echo $connect['url']; ?>Sources/highCharts/js/modules/exporting.js"></script>
		<link href="./Sources/Admin/adminSources/index.css" type="text/css" rel="stylesheet" />
		<style type='text/css'>			
			body .container {
				position:fixed;
				top:51px;
				left:201px;
				right:0;
				bottom:0;
				overflow:auto;
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
				overflow:auto;
				position:fixed;
				width:200px;
				top:51px;
				left:0;
				bottom:0;
				background:#ddd;
				border-right:1px solid #ccc;
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
				function resize() {
					if($('body').width()<700){
						$(".navText").fadeIn(0);
						small = false;
						
						$('.mobileSearch').css('display','block');
						$('.search').css('display','none');
						
						$('.actionIcon').css('zoom','1.5');
						
						$("#displayText, #settingsText, #bigBlueResize").css('display', 'none');
						document.getElementById("logoTitle").innerHTML='<img src=\'./Sources/Admin/images/template/menuSwitch.png\' onclick=\'toggleNavMobile()\'>';
						$(".container").css("left", "0px").css("z-index", "999");
						$("#sideMenu").css("width", "100%").css("position", "fixed").css("transition", "0.4s");
						$(".right, .left, .modal").addClass("mobile").css("float", "none").css("width", "100%");
						$(".modal").css("left", "0%").css("top", "0%").css("left", "0%").css("top", "0%").css("margin-top", "50px").css("height", document.body.clientHeight-50 + "px");
						$("#content").css("zoom", "0.65");
						$("#content .modal").css("zoom", "1.35");
						$(".header .button").css("font-size", "0px").css("top", "-2px");
					}else{
						$(".navText").fadeIn(0);
						small = false;
						
						$('.mobileSearch').css('display','none');
						$('.search').css('display','block');
						
						$('.actionIcon').css('zoom','1');
						
						$("#displayText, #settingsText, #bigBlueResize, #sideMenu").css('display', 'inline');
						document.getElementById("search").style.display='inline-block';
						document.getElementById("logoTitle").innerHTML='Great Experienced CMS';
						$(".container").css("left", "201px").css("z-index", "1001");
						$(".header .button").css("font-size", "inherit").css("top", "0");
						$("#content").css("zoom", "1.0");
						$(".right").css("float", "right").css("width", "49%");
						$(".left").css("float", "left").css("width", "49%");
						$("#content .modal").css("zoom", "1");
						$(".modal").removeClass("mobile").css("width", "500px").css("left", "50%").css("top", "50%").css("right", "auto").css("bottom", "auto").css("margin-top", "-200px").css("marginleft", "-250px").css("height", "400px");
						$("#sideMenu").css("left", "0px").css("width", "200px").css("transition", "0s");
					}
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
				if(small==true){
					$("#sideMenu").css("left","-" + document.body.clientWidth + "px");
					small = false;
				}else{
				$("#sideMenu").css("left","0px");
					setCookie("cmsAdminMenuCookie", 0,365);
					small = true;
				}
			}
		</script>
	</head>
	<body onresize='resize();'><?php if(!isset($_GET['layout'])){ ?>
		<nav>
			<div class='nav'>
			    <h1 id='logoTitle'>Great Experience CMS</h1> <h2><?php echo Icon::display('world.png', array('style' => 'margin-right:5px;position:relative;top:3px;'));echo $connect['url']; ?></h2>
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
				<div class='mobileSearch'>
				    <img src='./Sources/Admin/images/search.png' />
				    <form action='admin.php?action=search' method='post' onsubmit='exit;'><input class='mobileSearchInput' name='search' id='mobileSearchInput' placeholder='Search...' /></form>
				</div>
				<p style='text-align:center;margin:0;' id='bigBlueResize'>
					<button class='button blue' onclick='navSwitch();' style='width:100%;border-radius:0;margin:0 auto;padding:8px;margin-top:-1px;'><img src='./Sources/Admin/images/template/menuSwitch.png' /></button>
				</p>
				<a href='./admin.php'>
					<div class='item' style='border-top:0;height:0;'></div>
					<div class='item'>
						<img src='<?php echo $connect['url'] . "Sources/Admin/images/template/go-home.png"; ?>' />
						<span class='navText'>Dashboard</span>
					</div>
				</a>
				<a href='./admin.php?action=media&root=./Media'>
					<div class='item'>
						<img src='<?php echo $connect['url'] . "Sources/Admin/images/template/media.png"; ?>' />
						<span class='navText'>Media</span>
					</div>
				</a>
				<a href='./admin.php?action=templates'>
					<div class='item'>
						<img src='<?php echo $connect['url'] . "Sources/Admin/images/template/template.png"; ?>' />
						<span class='navText'><?php echo $language['templates'] . " " . $language['manager']; ?></span>
					</div>
				</a>
				<a href='./admin.php?action=plugins'>
					<div class='item'>
						<img src='<?php echo $connect['url'] . "Sources/Admin/images/template/plugin.png"; ?>' />
						<span class='navText'><?php echo $language['pluginManager']; ?></span>
					</div>
				</a>
				<a href='./admin.php?action=menu'>
					<div class='item'>
						<img src='<?php echo $connect['url'] . "Sources/Admin/images/template/menu.png"; ?>' />
						<span class='navText'><?php echo $language['menu'] . " " . $language['manager']; ?></span>
					</div>
				</a>
				<a href='./admin.php?action=pagelist&root=./Sources/Pages'>
					<div class='item'>
						<img src='<?php echo $connect['url'] . "Sources/Admin/images/template/page.png"; ?>' />
						<span class='navText'><?php echo $language['pages'] ?></span>
					</div>
				</a>
				<a href='./admin.php?action=newsManager'>
					<div class='item'>
						<img src='<?php echo $connect['url'] . "Sources/Admin/images/template/news.png"; ?>' />
						<span class='navText'><?php echo $language['news'] . " " . $language['manager']; ?></span>
					</div>
				</a>
				<div class='item' onclick="alert('not available yet!');">
					<img src='<?php echo $connect['url'] . "Sources/Admin/images/template/administration.png"; ?>' />
					<span class='navText'>Administration</span>
				</div>
				<div class='item' style='border-bottom:0;background:transparent;cursor:auto;height:2px;'></div>
			</div>
		</aside>
		<section>
			<div class='container'>
				<?php
}
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
<?php } ?>
	</body>
</html>