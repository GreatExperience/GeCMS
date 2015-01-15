<?php 

/* Include system */
require_once("./SSI.php");

/* Page load time counter */
$generationTimeStart = microtime();
$generationTimeStart = explode(' ', $generationTimeStart);
$generationTimeStart = $generationTimeStart[1] + $generationTimeStart[0];

/* HTML defined header */
Template::getHtmlHeader();

/* Theme defined header */
Template::getBodyHeader();

/* Render page */
if(! isset($_GET['editorLayout'])){
    Page::render((isset($_GET['page']) ? $_GET['page'] : 'index'));
    Template::getBodyFooter();
}else{
    echo file_get_contents($connect['url'].'/Sources/Admin/pages/templateEditor/preview.php');
    Template::getBodyFooter(array('footerMenu' => true));
}


/* HTML defined footer */
Template::getHtmlFooter();

?>