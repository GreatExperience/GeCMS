<?php

if (!$log)
    exit;

class pageChart extends Chart {

    /**
     * 
     * @global type $connect
     * @param type $src
     */
    private $amount = null;
    private $interval = false;
    
    public function __CONSTRUCT($src) {
	    parent::__CONSTRUCT($src);
    }
    
    public function setAmount($min){ $this->amount = $min; }
    public function setInterval($i) { $this->interval = $i; }
    
    private function getQueryExtension(){
	$ext = '';
	if($this->amount != null){
	    $ext .= ' LIMIT 0, ' . $this->amount . '';
	}
	return $ext;
    }
    
    public function executeQuery(){
	global $dbh, $connect, $dbh;
	
	$select = $dbh->prepare("SELECT * FROM ".$connect['ext']."visitors ORDER BY id DESC ".$this->getQueryExtension()."");
	
	$select->execute();
	$data = '';
	$cats = '';
	$first = false;
	$modifier = false;
	$modCount = 0;
	
	$min = null;
	$max = null;
	
		//die($select->rowCount());
	if($select->rowCount()>40 && $this->interval){
	    $modifier = round($select->rowCount()/20)-1;
	    $modCount = 1;
	    $modValue = 0;
	}
	
	while($row = $select->fetchObject()){
	    
	    if($min==null || strtotime($row->visitorsDate) < $min){
		$min = strtotime($row->visitorsDate);
	    }
	    
	    if($max==null || strtotime($row->visitorsDate) > $max){
		$max = strtotime($row->visitorsDate);
	    }
	    
	    
	    if($first==false) {
		$cats = "'" . date('d-m', strtotime($row->visitorsDate)) . "'";
		//$data  = $row->visitorsPages;
		$data = '[' . strtotime($row->visitorsDate) . '*1000,  ' . $row->visitorsPages . ']';
		$first = true;
	    }else{
		if(isset($modValue) && $modCount==$modifier){
		    $cats .= ", '" . strtotime($row->visitorsDate) . "'";
		    $data = '[' . strtotime($row->visitorsDate) . '*1000, ' . round($modValue/($modifier+1)) . '], ' . $data;
		    $modCount = 0;
		    $modValue = 0;
		}elseif($modifier==false && !isset($modValue)){
		    $cats .= ", '" . strtotime($row->visitorsDate) . "'";
		    //$data .= ", ".$row->visitorsPages;  
		    $data = ',[' . strtotime($row->visitorsDate) . '*1000,  ' . $row->visitorsPages . '], ' . $data;
		}else{
		    $modCount++;
		    $modValue = $modValue + $row->visitorsPages;
		}
	    }
	    
	    $this->setBegin($min);
	    $this->setEnd($max);
	}
	
	$this->setSeries("name: 'pageviews', data: [".$data."]");
	$this->setChart(array('type' => 'area'));
	$this->setCategories($cats);
    }
  
}

?>
