<?php

/**
 * Create a modal dialog
 *
 * @author Merijn
 */
class Modal {
    
    private $_id;
    private $_title;
    private $_header = true;
    private $_content;
    private $_width = '500';
    private $_height = '400';
    private $_attrX = 'px';
    private $_attrY = 'px';
    private $_closeOperation = '';
    private $_userSelect = 'none';
    
    /**
     * @param string $title
     * @param string $id
     */
    public function __construct($title, $id){
	$this->_title = $title;
	$this->_id = $id;
    }
    
    /**
     * Define whatever header image displayed or not
     * @param type $i
     * @throws Exception
     */
    public function setHeader($i){
	
	if($i != true && $i != false){
	    Throw new Exception('setHeader needs boolean, other given.');
	}
	
	$this->_header = $i;
    }
    
    public function setContent($i){ $this->_content = $i; }
    public function setWidth($i, $attr = "px") {$this->_width = $i; $this->_attrX = $attr;}
    public function setHeight($i, $attr = "px") {$this->_height = $i; $this->_attrY = $attr;}
    public function setCloseAction($i){$this->_closeOperation = $i;}
    public function render(){
	$return =  '<div class="modal" id="'.$this->_id.'" style="-webkit-user-select:'.$this->_userSelect.';user-select:'.$this->_userSelect.';-ms-user-select:'.$this->_userSelect.';-o-user-select:'.$this->_userSelect.';user-select:'.$this->_userSelect.'; width:'.$this->_width.$this->_attrX.';height:'.$this->_height.$this->_attrY.';'.( $this->_attrX=="px" ? 'margin-left:-'.($this->_width/2) : 'left:'.(100-$this->_width)/2).$this->_attrX.';'.( $this->_attrY=="px" ? 'margin-top:-'.($this->_height/2) : 'top:'.(100-$this->_height)/2).$this->_attrY.';">
<div class="modalTitle">'.$this->_title.'<button type="button" class="modalClose" aria-hidden="true" onclick="'.$this->_closeOperation.'$(\'#'.$this->_id.'\').hide();">x</button></div><div class="modalWrapper">';
	
        $return .= '<div class="modalContent">';
	if($this->_header)
	    $return .= '<div class="headImage"></div>';
	
	$return .= ''.$this->_content.'</div></div></div>';
	return $return;
    }
}
