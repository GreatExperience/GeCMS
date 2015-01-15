<?php
    header("Content-Type: text/css");

    echo '/* CSS Rendered by GeCMS ThemeRoller */';
    
    /* Required PHP variables */
    require_once("../roller.template.php");

    class css {
        public static function render($prop, Array $values, Array $options = array()){
            $render = true;
            $output = '';
            foreach($values as $i){
                $output .= $i;
                if(strlen($i)==(isset($options['size']) ? $options['size'] : 0)){
                    $render = false;
                }
                
                if(count($values) > 1){
                    $output .= ' ';
                }
            }
            if($render){
                if(isset($options['operator'])){
                    $output .= $options['operator'];
                }
                
                if(isset($options['before'])){
                    $output = $options['before'].$output;
                }
                
                return $prop.':'.$output.';';
            }else{
                return '';
            }
        }
    }
    
    $count = 0;
    
    echo '.container {width:'.$tmpcontainer['width'].'px;}';
    while($count<5){
        
        switch($count){
            case 0: $tmp = $tmpbody;        $selector = 'body';         break;
            case 1: $tmp = $tmpfooter;      $selector = '.footer';      break;
            case 2: $tmp = $tmpheader;      $selector = '.header';      break;
            case 3: $tmp = $tmpmenu;        $selector = '.nav';         break;
            case 4: $tmp = $tmpcontainer;   $selector = '.content';   break;
        }
        
        echo '
'.$selector.' { '.
    css::render('margin-left', array($tmp['marginLeft']), array('operator' => 'px')).
    css::render('margin-right', array($tmp['marginRight']), array('operator' => 'px')).
    css::render('margin-bottom', array($tmp['marginBottom']), array('operator' => 'px')).
    css::render('margin-top', array($tmp['marginTop']), array('operator' => 'px')).
    css::render('padding-top', array($tmp['paddingTop']), array('operator' => 'px')).
    css::render('padding-left', array($tmp['paddingLeft']), array('operator' => 'px')).
    css::render('padding-right', array($tmp['paddingRight']), array('operator' => 'px')).
    css::render('padding-bottom', array($tmp['paddingBottom']), array('operator' => 'px')).
    css::render('border-radius', array($tmp['borderRadius']), array('operator' => 'px')).
    css::render('color', array($tmp['textColor']), array('before' => '#')).
    css::render('background-color', array($tmp['background']), array('before' => '#')).
    css::render('background-image', array($tmp['backgroundImage']), array('before' => 'url(', 'operator' => ')')).
    css::render('background-repeat', array($tmp['backgroundRepeat'])).
    css::render('background-position', array($tmp['backgroundPosition'])).
    css::render('font-family', array($tmp['textFamily'])).
    css::render('font-size', array($tmp['textSize']), array('operator' => 'px')).
    css::render('outline', array($tmp['outlineSize'].'px', $tmp['outlineType'], '#'.$tmp['outlineColor']), array('size' => 2)).
    css::render('border', array($tmp['borderSize'].'px', $tmp['borderType'], '#'.$tmp['borderColor']), array('size' => 2)).
    css::render('position', array($tmp['position'])).
    css::render('left', array($tmp['left'])).
    css::render('right', array($tmp['right'])).
    css::render('top', array($tmp['top'])).
    css::render('bottom', array($tmp['bottom'])).
    css::render('width', array($tmp['width']), array('operator' => $tmp['widthOperator'])).
    css::render('min-width', array($tmp['minWidth']), array('operator' => $tmp['minWidthOperator'])).
    css::render('max-width', array($tmp['maxWidth']), array('operator' => $tmp['maxWidthOperator'])).
    css::render('height', array($tmp['height']), array('operator' => $tmp['heightOperator'])).
    css::render('min-height', array($tmp['minHeight']), array('operator' => $tmp['minHeightOperator'])).
    css::render('max-height', array($tmp['maxHeight']), array('operator' => $tmp['maxHeightOperator'])).
    css::render('text-align', array($tmp['textAlign'])).
    css::render('text-decoration', array($tmp['textDecoration'])).'}';
    $count++;
};

?>