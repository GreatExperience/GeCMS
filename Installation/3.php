<?php 

    if(!isset($_POST['database'])||!isset($_POST['server'])||!isset($_POST['serverName'])||!isset($_POST['dbUsername'])||!isset($_POST['dbPassword'])||!isset($_POST['dbPrefix'])||!isset($_POST['username'])||!isset($_POST['password'])||!isset($_POST['mail'])||!isset($_POST['webUrl'])||!isset($_POST['webRoot']))
	die('We are missing some data! Please restart the installation!');
    
    try{
        $dbh = new pdo($_POST['database'].':host='.$_POST['server'].';dbname='.$_POST['serverName'], $_POST['dbUsername'] , $_POST['dbPassword'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	$dbh->beginTransaction();
	$query= "

CREATE TABLE IF NOT EXISTS `".$_POST['dbPrefix']."log` (`user` int(11) NOT NULL,`userAction` text NOT NULL,`returnValue` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `".$_POST['dbPrefix']."menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menuName` text NOT NULL,
  `menuTarget` text NOT NULL,
  `menuHREF` text NOT NULL,
  `child` int(11) NOT NULL,
  `child_of` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `".$_POST['dbPrefix']."menu` (`id`, `menuName`, `menuTarget`, `menuHREF`, `child`, `child_of`, `position`) VALUES
(1, 'Home', '_SELF', './', 0, 0, 0),
(2, 'Zwemmen', '_SELF', '?page=news', 0, 0, 1);


CREATE TABLE IF NOT EXISTS `".$_POST['dbPrefix']."news_cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `".$_POST['dbPrefix']."news_cats` (`id`, `name`, `position`) VALUES
(1, 'General', 0);


CREATE TABLE IF NOT EXISTS `".$_POST['dbPrefix']."news_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `tags` text NOT NULL,
  `title` text NOT NULL,
  `img` text NOT NULL,
  `content` text NOT NULL,
  `dateDay` int(11) NOT NULL,
  `dateMonth` int(11) NOT NULL,
  `dateYear` int(11) NOT NULL,
  `cat` int(11) NOT NULL,
  `share` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `".$_POST['dbPrefix']."news_items` (`id`, `description`, `tags`, `title`, `img`, `content`, `dateDay`, `dateMonth`, `dateYear`, `cat`, `share`) VALUES
(1, 'A news item generated by GeCMS installation', 'thank, you, for, using, gecms', 'This is a news item!', '', 'This is a news item generated through the installation of GeCMS! You can delete it in your admin panel.', ".date('d').", ".date('m').", ".date('Y').", 1, 0);


CREATE TABLE IF NOT EXISTS `".$_POST['dbPrefix']."pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` text NOT NULL,
  `meta` int(11) NOT NULL,
  `template` text NOT NULL,
  `title` text NOT NULL,
  `menu` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);
INSERT INTO `".$_POST['dbPrefix']."pages` (`id`, `file`, `meta`, `template`, `title`, `menu`) VALUES
(1, 'index.php', 1, '1', 'Home', 1),
(2, 'news.php', 1, '1', 'News', 0);


CREATE TABLE IF NOT EXISTS `".$_POST['dbPrefix']."sessions` (`id` int(11) NOT NULL AUTO_INCREMENT,`userIp` varchar(500) NOT NULL,`userAccount` varchar(500) NOT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS `".$_POST['dbPrefix']."settings` (`id` int(11) NOT NULL AUTO_INCREMENT,`name` varchar(100) NOT NULL DEFAULT '',`value` text NOT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
INSERT INTO `".$_POST['dbPrefix']."settings` (`id`, `name`, `value`) VALUES
(1, 'siteLanguage', 'en_US'),
(2, 'siteTitle', 'Another website generated by GeCMS'),
(3, 'siteDescription', 'This is a nice website generated by GeCMS!'),
(4, 'siteKeywords', 'this, are, the, default, keywords, please, use, the, same, structure'),
(5, 'siteAuthor', 'Great Experienced'),
(6, 'siteRobots', 'index, follow'),
(7, 'siteTemplate', 'default'),
(8, 'cmsVersion', '1.0.0.1'),
(9, 'adminToDo', ''),
(10, 'siteMenu', 'My side menu generated by GeCMS (you can edit this in the admin panel: Menu manager>Edit side menu)');

CREATE TABLE IF NOT EXISTS `".$_POST['dbPrefix']."users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `mail` varchar(255) NOT NULL DEFAULT '',
  `permissions` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);
INSERT INTO `".$_POST['dbPrefix']."users` (`id`, `username`, `password`, `mail`, `permissions`) VALUES (1, '".$_POST['username']."', '".crypt($_POST['password'], md5('$GeSALT'.$_POST['username'].'EndGeSALT$'))."', '".$_POST['mail']."', 1);

CREATE TABLE IF NOT EXISTS `".$_POST['dbPrefix']."visitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitorsDate` text NOT NULL,
  `visitorsPages` int(11) NOT NULL,
  `visitorsMonth` int(11) NOT NULL,
  `visitorsYear` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
";
	    
	$exec = $dbh->prepare($query);
	$exec->execute();
	
	
    }catch(PDOException $e){
        echo($e->getMessage());
	$pass = false;
	echo '<script>window.location="./install.php?step=2&database='.$_POST['database'].'&msg='.urlencode('Could not connect to the database. Please make sure all data is correct! technical message: ' . $e->getMessage).'";</script>';
    }
	
/**
 * Connection file 
 */
$body ="<?php
/* Installation
	0 = Finished
	1 = Installing
	2 = Closed for use
*/
\$Install = '0';
    
/* Database connection settings */
\$connect['client'] 	= '".$_POST['database']."';
\$connect['dbName'] 	= '".$_POST['serverName']."';
\$connect['dbHost'] 	= '".$_POST['server']."';
\$connect['dbUser'] 	= '".$_POST['dbUsername']."';
\$connect['dbPass'] 	= '".$_POST['dbPassword']."';
\$connect['ext']		= '".$_POST['dbPrefix']."';
\$connect['root']	= '".$_POST['webRoot']."';
\$connect['url']		= '".$_POST['webUrl']."';
    
/* Setup connection */
try {
    \$dbh = new PDO(\$connect['client'].':dbname='.\$connect['dbName'].';host='.\$connect['dbHost'], \$connect['dbUser'], \$connect['dbPass']);
} catch (PDOException \$e) {
    echo '<h1>Whoops!</h1> <h2>Database connection failed</h2> <h3>Technical message:</h3> <p>' . \$e->getMessage() . '</p>';
}

?>
";

    $file = fopen($_POST['webRoot'] . "connect.php","w+");
    if(fwrite($file,$body) === false){
    
	/* Actually commiting */
	$dbh->commit();
    }else{
	echo 'Could not write file.';
	echo '<script>window.location="./install.php?step=2&database='.$_POST['database'].'&msg='.urlencode('Could not write config file. Make sure the root is valid and GeCMS has file writing access').'";</script>';
	$pass = false;
    }
    
    if($pass==true){
?>
<h1>Installation finished!</h1>
<p>Dear <?php echo $_POST['username']; ?>,</p>
<br />
<p style='max-width:1000px;'>
    You just succesfully installed GeCMS! you can now login into the admin panel to edit your website! You can find the admin panel under <u><?php echo $_POST['webUrl']; ?>/ge-admin/</u> or <u><?php echo $_POST['webUrl']; ?>/admin.php</u>! 
    Having trouble? You can find a link to the support forum of GeCMS at your admin dashboard.
</p>
<p>Dont forget to <u>delete the installation files</u>. This is for security reasons. you can click below on the checkbox to give it a try!</p>
<form action='./admin.php' method='post'>
<table><tr><td style='padding-right:5px;'><input type='checkbox' title='Please give it a try to delete the installation files' REQUIRED /></td><td> Delete installation files</td></tr></table>
<input class='submit' value='Enter the admin panel' type='submit' style='width:200px !important;'>
</form>

<script>
    $('.step').css({'width': '50%'});
    $('.step').animate({'width': '100%'});
</script>
<style>
    input {margin:5px !important;width:100% !important;}
</style>
<?php }
?>