<?php

/**
 * Description of Sidemenu
 *
 * @author Merijn
 */
class Sidemenu {
    public static function render(){
	global $connect , $language;
    return "
				<a href='./admin.php'>
					<div class='item' style='border-top:0;height:0;'></div>
					<div class='item'>
						<img src='".$connect['url'] . "Sources/Admin/images/template/go-home.png' />
						<span class='navText'>Dashboard</span>
					</div>
				</a>
				<a href='./admin.php?action=media&root=./Media'>
					<div class='item'>
						<img src='".$connect['url'] . "Sources/Admin/images/template/media.png' />
						<span class='navText'>Media</span>
					</div>
				</a>
				<a href='./admin.php?action=templates'>
					<div class='item'>
						<img src='".$connect['url'] . "Sources/Admin/images/template/template.png' />
						<span class='navText'>".$language['templates'] . " " . $language['manager']."</span>
					</div>
				</a>
				<a href='./admin.php?action=plugins'>
					<div class='item'>
						<img src='".$connect['url'] . "Sources/Admin/images/template/plugin.png' />
						<span class='navText'>".$language['pluginManager']."</span>
					</div>
				</a>
				<a href='./admin.php?action=menu'>
					<div class='item'>
						<img src='".$connect['url'] . "Sources/Admin/images/template/menu.png' />
						<span class='navText'>".$language['menu'] . " " . $language['manager']."</span>
					</div>
				</a>
				<a href='./admin.php?action=pagelist&root=./Sources/Pages'>
					<div class='item'>
						<img src='".$connect['url'] . "Sources/Admin/images/template/page.png' />
						<span class='navText'>".$language['pages']."</span>
					</div>
				</a>
				<a href='./admin.php?action=newsManager'>
					<div class='item'>
						<img src='".$connect['url'] . "Sources/Admin/images/template/news.png' />
						<span class='navText'>".$language['news'] . " " . $language['manager']."</span>
					</div>
				</a>
				<div class='item' onclick=\"alert('not available yet!');\">
					<img src='".$connect['url'] . "Sources/Admin/images/template/administration.png' />
					<span class='navText'>Administration</span>
				</div>
				<div class='item' style='border-bottom:0;background:transparent;cursor:auto;height:2px;'></div>";
    }
}
