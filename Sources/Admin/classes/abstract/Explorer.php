<?php

if (!$log)
    exit;

class Explorer {

    private $type;
    private $src;
    private $icon;
    private $editor;
    
    /**
     * 
     * @param type $src
     * @return boolean
     * @throws Exception
     */
    public function __CONSTRUCT($src) {
	$this->setSRC($src);
	if (!file_exists($this->getSRC())) {
	    throw new Exception('File/directory does not exist');
	    return false;
	}
    }
    
    /**
     * 
     * @param type $plain
     * @return type
     */
    public function getName($plain = false) {
	if ($plain == true)
	    return preg_replace("/\\.[^.\\s]{3,4}$/", "", basename($this->getSRC()));
	else
	    return basename($this->getSRC());
    }
    
    /**
     * 
     * @return type
     */
    public function getType() {
	return $this->type;
    }

    /**
     * 
     * @return type
     */
    public function getSRC() {
	return $this->src;
    }
    
    /**
     * 
     * @return type
     */
    public function getSize() {
	return filesize($this->src);
    }

    /**
     * 
     * @return type
     */
    public function getIcon() {
	return $this->icon;
    }
    
    /**
     * 
     * @return type
     */
    public function getEditor() {
	return $this->editor;
    }

    /**
     * 
     * @param type $type
     */
    public function setType($type) {
	$this->type = $type;
    }
    
    /**
     * 
     * @param type $src
     */
    public function setSRC($src) {
	$this->src = $src;
    }
    
    /**
     * 
     * @param type $icon
     */
    public function setIcon($icon) {
	$this->icon = $icon;
    }
    
    /**
     * 
     * @param type $editor
     */
    public function setEditor($editor) {
	$this->editor = $editor;
    }
    
    /**
     * 
     * @return type
     */
    public function getPermissions() {
	return fileperms($this->src);
    }
    
    /**
     * 
     * @return type
     */
    public function getModified() {
        return date("d M Y H:i:s",filemtime($this->getSRC()));
    }
}

?>
