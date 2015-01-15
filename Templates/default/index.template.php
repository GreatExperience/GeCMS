<?php

require_once(dirname(__FILE__).'/roller.template.php');

class Theme {

    static function getBodyHeader($options){
	global $connect, $settings;
	echo '
<link href="'.$connect['url'] . 'Templates/' . $settings['siteTemplate'] . '/CSS/index.css" rel="stylesheet" type="text/css">
<link href="'.$connect['url'] . 'Templates/' . $settings['siteTemplate'] . '/CSS/themeRoller.css.php" rel="stylesheet" type="text/css">
</head>
<body>
<nav>
<div class="nav">
<div class="container">
<h1>'.$settings['siteTitle'].'</h1>'.
	Template::renderNavigation().'
</div>
</div>
</nav>
<div class="header">
</div>

<div class="content container">
';
        }
    
    static function getBodyFooter($options){
        global $settings, $tmpfooter;
	echo '
</div>
</div>
<footer>
<div class="footer">
<div class="container">
    '.(isset($options['footerMenu']) || $tmpfooter['menuFooter']=='true' ? '<div class="menu">'.Template::renderNavigation().'</div>' : '').'
    Copyright &copy; '.$settings['siteAuthor'].' '.date('Y').'
</div>
</div>
</footer>
	';
    }
    
}