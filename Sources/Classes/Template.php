<?php

/**
 * This is the default template class.
 */
class Template {
    
    /* Current  */
    private $_htmlHeader;
    private $_displayHeader;
    private $_footer;
    private $_title;
    private $_unicode;
    private $_keywords;
    private $_author;
    
    public function __construct() {
	$this->setUnicode('utf-8');
    }
    
    /* display layout */
    public function getLayoutHeader(){return '
<!DOCTYPE html>
<html>
<head>
<title>'.$this->_title.'</title>
<meta name="description" content="'.$this->_description.'">
<meta name="keywords" content="'.$this->_keywords.'">
<meta name="author" content="'.$this->_author.'">
<meta charset="'.$this->_unicode.'>
' . $this->_htmlHeader . '
</head>' . $this->_displayHeader;}

    public function getLayoutFooter(){return $this->_footer . "</body></html>";}
    
    /* Set layout */
    public function setHtmlHeader($i){$this->_htmlHeader = $i;}
    public function setDisplayHeader($i){$this->_displayHeader = $i;}
    public function setFooter($i){$this->_footer = $i;}
    public function setTitle($i){$this->_title = $i;}
    public function setUnicode($i){$this->_unicode = $i;}
}
