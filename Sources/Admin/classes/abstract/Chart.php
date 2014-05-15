<?php

if (!$log)
    exit;

class Chart {
    
    private $selector;
    
    private $_chart = array();
    private $_begin;
    private $_end;
    private $_categories;
    private $_series;
    private $_tooltip;
    private $_credits;
    private $_plotOptions;
    
    

    public function __CONSTRUCT($selector) {
	$this->selector = $selector;
    }
    
    public function renderChart(){
	//die($this->getBegin() . "  " . $this->getEnd() );
	return "
$(document).ready(function () {
    chart = new Highcharts.Chart({
	chart: {timeBox: true, renderTo: '".$this->selector."', type: 'area'},
	title: {text: ''},
	legend: {layout: 'vertical', align: 'left', verticalAlign: 'top', x: 150, y: 100, floating: true, borderWidth: 1, backgroundColor: '#ffffff'},
	xAxis: {type: 'datetime',   dateTimeLabelFormats: {
                    month: '%e. %b',
                    year: '%b'
                },},
	yAxis: {title: {text: ''}, min:0, },
	tooltip: {shared: true, headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '<u>{point.x:%e. %b}</u>: {point.y:.2f}'},
	credits: {enabled: false},
	plotOptions: {areaspline: {fillOpacity: 0.5}},
	series: [{".$this->getseries()."}]
    });
});";
    }
    
    /* getters */
    public function getChart(){ return json_encode($this->_chart); }
    public function getBegin(){ return $this->_begin; }
    public function getEnd(){ return $this->_end; }
    public function getSeries(){ return $this->_series; }
    public function getTooltip(){ return $this->_tooltip; }
    public function getCredits(){ return $this->_credits; }
    public function getPlotOptions(){ return $this->_plotOptions; }
    public function getCategories(){ if(isset($this->_categories))return $this->_categories; else return ''; }
    
    /* Setters */
    public function setChart($i){ $this->_chart = $i ;}
    public function setBegin($i){ $this->_begin = $i ;}
    public function setEnd($i){ $this->_end = $i ;}
    public function setSeries($i){ $this->_series = $i ;}
    public function setTooltip($i){ $this->_tooltip = $i ;}
    public function setCredits($i){ $this->_credits = $i ;}
    public function setPlotOptions($i){ $this->_plotOptions = $i ;}
    public function setCategories($i){ $this->_categories = $i ; }
    
  
}

?>
