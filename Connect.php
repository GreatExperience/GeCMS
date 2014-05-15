<?php

/* Installation
	0 = Finished
	1 = Installing
	2 = Closed for use
*/
$Install = '0';
    
/* Database connection settings */
$connect['client'] 	= 'mysql';
$connect['dbName'] 	= 'newcms';
$connect['dbHost'] 	= '127.0.0.1';
$connect['dbUser'] 	= 'root';
$connect['dbPass'] 	= '';
$connect['ext']		= 'cms_';
$connect['root']	= 'D:/WampServer/www/1.0.0.1/';
$connect['url']		= 'http://192.168.2.1/1.0.0.1/';

/* Setup connection */
try {
    $dbh = new PDO($connect['client'].':dbname='.$connect['dbName'].';host='.$connect['dbHost'], $connect['dbUser'], $connect['dbPass']);
} catch (PDOException $e) {
    echo '<h1>Whoops!</h1> <h2>Database connection failed</h2> <h3>Technical message:</h3> <p>' . $e->getMessage() . '</p>';
    exit;
}

?>
