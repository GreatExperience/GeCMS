<?php
/* Installation
	0 = Finished
	1 = Installing
	2 = Closed for use
*/
$Install = 1;

if((int)$Install == 0)
    exit;

/* Database connection settings */
$connect['client'] 	= 'mysql';
$connect['dbName'] 	= 'topcms';
$connect['dbHost'] 	= '127.0.0.1';
$connect['dbUser'] 	= 'woodpekker0';
$connect['dbPass'] 	= 'koekjes';
$connect['ext']		= 'cms_';
$connect['root']	= 'D:/WampServer/www/GeCMS/';
$connect['url']		= 'http://localhost/GeCMS/';
    
/* Setup connection */
try {
    $dbh = new PDO($connect['client'].':dbname='.$connect['dbName'].';host='.$connect['dbHost'], $connect['dbUser'], $connect['dbPass']);
} catch (PDOException $e) {
    echo '<h1>Whoops!</h1> <h2>Database connection failed</h2> <h3>Technical message:</h3> <p>' . $e->getMessage() . '</p>';
}

?>
