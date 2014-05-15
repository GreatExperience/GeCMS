<?php

if (!$log)
    exit;

class Icon extends Explorer {
    
    public static function display($src, $extra = Array()){
	global $connect;
	$root			= $connect['url'].'/Sources/Admin/images/icons/';
	$iconAdditionalInfo	= '';
	foreach($extra as $key => $value){
	    $iconAdditionalInfo.= ' ' . $key . '="' . $value . '"';
	}

	    return '<img src="'.$root.$src.'" '.$iconAdditionalInfo.' />';
    }
}

?>
