<?php

/**
 * Open a modal where the user can select pages from.
 *
 * @author Merijn
 */
class pageModal extends Modal {
    private $id = 0;
    
    public function __construct($options = array()){
	global $language;
	parent::__construct($language['pageSelect'], 'pageSelect_'.$this->id);
	$this->setWidth('80', '%');
	$this->setHeight('80', '%');
	$this->setHeader(false);
    }
    public function renderModal($element, $return){
	global $language, $connect;
	$pages = new Folder('./sources/Pages/');
	$pagesHTML  = '';

	
	foreach($pages->getDirectoryFiles() as $key => $value){
	    $pageName = str_replace('.php', '', $value);
	    $pagesHTML  .= '<button class="button" style="width:24%;margin:0.5%;float:left;padding-top:10px;padding-bottom:10px;" onclick="$(\'#pageSelect_'.$this->id.' #selectedURL\').html(\'?page='.$pageName.'\')">'.$pageName.'</button>';
	}
	
	$endHTML = '
	    <div class="fileContainer">
    <div class="header" style="padding-top:2px;padding-bottom:2px;border-left:1px solid #ccc;background:#eee;">
	<button class="root" id="selectedURL" style="position:relative;top:2px;">'.$language['mediaUnselected'].'</button>
	<button class="button blue" onclick="$(\''.$return.'\').val($(\'#pageSelect_'.$this->id.' #selectedURL\').html()); $(\'#pageSelect_'.$this->id.'\').hide();" style="float:right;position:relative;top:2px;right:5px;"><img src="'.$connect['url'].'/Sources/Admin/images/icons/accept.png">'.$language['select'].'</button>
    </div>
    <p style="text-align:left;">'.$pagesHTML.'</p>
</div>
	';
	$this->setContent($endHTML);
	
	$output = $this->render();
	$output .= '<script>$(document).ready(function(){document.getElementById("'.$element.'").onclick = function(){$("#pageSelect_'.$this->id.'").fadeIn();return false;}});</script>';
	$this->id = $this->id + 1;
	
	return $output;
    }
}
