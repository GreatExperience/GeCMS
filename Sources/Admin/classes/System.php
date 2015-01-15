<?php

/**
 * Description of Sidemenu
 *
 * @author Merijn
 */
class System {
    public static function getByte($size){
	$units = array(' B', ' KB', ' MB', ' GB', ' TB');for ($i = 0; $size >= 1024 && $i < 4; $i++) 
	$size /= 1024;
	return round($size, 2).$units[$i];
    }
}
