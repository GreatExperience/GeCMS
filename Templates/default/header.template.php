<!DOCTYPE html>
<html>
<head>

<title><?php echo $settings['siteTitle']; ?></title>
<meta charset="utf-8">
<meta name="keywords" content="<?php echo $settings['siteKeywords']; ?>">
<meta name="description" content="<?php echo $settings['siteDescription']; ?>">
<meta name="robots" content="<?php echo $settings['siteRobots']; ?>" />
<meta name="author" content="<?php echo $settings['siteAuthor']; ?>" />
<link href="<?php echo $connect['url'] . "Templates/" . $settings['siteTemplate'] . "/CSS/index.css"; ?>" rel="stylesheet" type="text/css">

</head>
<body>
<div class='container'>
<nav>
<div class='nav'>
    <h1><?php echo $settings['siteTitle']; ?></h1>
    <?php require_once("./Templates/" . $settings['siteTemplate'] . "/menu.template.php"); ?>
</div>
</nav>
<div class='bodyBG'></div>

<div class='content'>