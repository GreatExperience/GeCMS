<?php

if (!$log)
    exit;

class Icon extends Explorer {
    
    public static function display($src, $extra = Array()){
	global $connect;
	$iconAdditionalInfo	= '';
	foreach($extra as $key => $value){
	    $iconAdditionalInfo.= ' ' . $key . '="' . $value . '"';
	}

	return '<img class="icon" src="'.$connect['url'].'/Sources/Admin/images/icons/'.$src.'"'.$iconAdditionalInfo.' />';
    }
}

?>
