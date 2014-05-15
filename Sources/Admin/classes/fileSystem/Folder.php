<?php

if (!$log)
    exit;

class Folder extends Explorer {

    /**
     * 
     * @global type $connect
     * @param type $src
     */
    public function __CONSTRUCT($src) {    
	    parent::__CONSTRUCT($src);
    }
    
    /**
     * 
     * @return type
     * @throws Exception
     */
    public function getDirectoryFiles(){
	$output = '';
	if ($handle = opendir($this->getSRC())) {
	    while (false !== ($entry = readdir($handle))) {
		if($entry!="."&&$entry!=".."){
		    $output[] = $entry;
		}
	    }
	    
	    if($output==null)return false;
	}else{
	    throw new Exception('Failed to open directory!');
	}
	
	return $output;
    }
    
    public function getIsDir(){
	
	if(is_dir($this->getSRC())){
	    return true;
	}else{
	    return false;
	}
    }
    
    public function getIsGlobal(){
	if($this->getSRC()=="."||(strpos($this->getSRC(),'Sources')&&$this->getSRC()!="./Sources/Pages")){
	    return false;
	}else{
	    return true;
	}
    }
}
?>
