<?php

/**
 * Description of Sidemenu
 *
 * @author Merijn
 */
class templateEdit {
    public static function modalContent($id, Array $array, $options = array()){
        global $language;
        
        if(isset($options['additional'])){
            $additionalButton = '<button class="root sub" onclick="'.$id.'Hide();$(\'#'.$id.' .additional\').fadeIn();">'.$language['additional'].'</button>';
            $additionalContent = '<div class="additional">'.$options['additional'].'</div>';
        }else{
            $additionalButton = '';
            $additionalContent = '';
        }
        
        $modalContent = '
    <div class="header" style="z-index:5;position:relative;">
	<button class="root sub" style="margin-left:5px" onclick="'.$id.'Hide();$(\'#'.$id.' .model\').fadeIn();">Model</button>
	<button class="root sub" onclick="'.$id.'Hide();$(\'#'.$id.' .text\').fadeIn();">Text</button>
	<button class="root sub" onclick="'.$id.'Hide();$(\'#'.$id.' .positionDia\').fadeIn();">'.$language['position'].'</button>
            '.$additionalButton.'
    </div>
    <div style="padding:10px;">
        <div class="model">
            <h3>'.$language['background'].'</h3>
            <table style="width:100%;vertical-align:top;">
                <tr>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['color'].':</strong>
                        <input value="'.(isset($array['background']) ? $array['background'] : '').'" type="text" pattern="^([a-fA-F0-9]{6}|[a-fA-F0-9]{6})$" class="colorPicker bgColor background" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;">
                        <strong>'.$language['background'].':</strong>
                        <input value="'.(isset($array['backgroundImage']) ? $array['backgroundImage'] : '').'" type="text" class="bgImage backgroundImage" style="width:100%;" placeholder="URL" />
                        <button class="button" style="float:right;position:relative;top:-27px;">Bladeren</button>
                    </td>
                    <td style="vertical-align:top;">
                        <strong>'.$language['backgroundPosition'].':</strong>
                        <select style="width:100%;" class="backgroundPosition">
                            <option value="top, left"'.(isset($array['backgroundPosition'])&&$array['backgroundPosition']=='top, left' ? ' SELECTED' : '').'>'.$language['top, left'].'</option>
                            <option value="top, center"'.(isset($array['backgroundPosition'])&&$array['backgroundPosition']=='top, center' ? ' SELECTED' : '').'>'.$language['top, center'].'</option>
                            <option value="top, right"'.(isset($array['backgroundPosition'])&&$array['backgroundPosition']=='top, right' ? ' SELECTED' : '').'>'.$language['top, right'].'</option>
                            <option value="center, left"'.(isset($array['backgroundPosition'])&&$array['backgroundPosition']=='center, left' ? ' SELECTED' : '').'>'.$language['center, left'].'</option>
                            <option value="center, center"'.(isset($array['backgroundPosition'])&&$array['backgroundPosition']=='center, center' ? ' SELECTED' : '').'>'.$language['center, center'].'</option>
                            <option value="center, right"'.(isset($array['backgroundPosition'])&&$array['backgroundPosition']=='center, right' ? ' SELECTED' : '').'>'.$language['center, right'].'</option>
                            <option value="bottom, left"'.(isset($array['backgroundPosition'])&&$array['backgroundPosition']=='bottom, left' ? ' SELECTED' : '').'>'.$language['bottom, left'].'</option>
                            <option value="bottom, center"'.(isset($array['backgroundPosition'])&&$array['backgroundPosition']=='bottom, center' ? ' SELECTED' : '').'>'.$language['bottom, center'].'</option>
                            <option value="bottom, right"'.(isset($array['backgroundPosition'])&&$array['backgroundPosition']=='bottom, right' ? ' SELECTED' : '').'>'.$language['bottom, right'].'</option>
                        </select>
                    </td>
                    <td style="vertical-align:top;">
                        <strong>'.$language['backgroundRepeat'].':</strong>
                        <select style="width:100%;" class="backgroundRepeat">
                            <option value="no-repeat"'.(isset($array['backgroundRepeat'])&&$array['backgroundRepeat']=='no-repeat' ? ' SELECTED' : '').'>no-repeat</option>
                            <option value="repeat-x"'.(isset($array['backgroundRepeat'])&&$array['backgroundRepeat']=='repeat-x' ? ' SELECTED' : '').'>repeat-x</option>
                            <option value="repeat-y"'.(isset($array['backgroundRepeat'])&&$array['backgroundRepeat']=='repeat-y' ? ' SELECTED' : '').'>repeat-y</option>
                            <option value="repeat"'.(isset($array['backgroundRepeat'])&&$array['backgroundRepeat']=='repeat' ? ' SELECTED' : '').'>repeat</option>
                        </select>
                    </td>
            </table>
            <h3><span style="float:left;">'.$language['margin'].'</span><span style="float:right;">'.$language['padding'].'</span><div style="clear:both;"></div></h3>
            <table style="width:30%;vertical-align:top;float:left;text-align:center;">
                <tr>
                    <td style="vertical-align:top;width:50px;"></td>
                    <td style="vertical-align:top;width:50px;">
                     <strong>'.$language['top'].':</strong>
                        <input value="'.(isset($array['marginTop']) ? $array['marginTop'] : '').'" type="number" class="marginTop" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:50px;"></td>
                </tr>
                <tr>
                    <td style="vertical-align:top;width:50px;">
                        <strong>'.$language['left'].':</strong>
                        <input value="'.(isset($array['marginLeft']) ? $array['marginLeft'] : '').'" type="number" class="marginLeft" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:50px;"></td>
                    <td style="vertical-align:top;width:50px;">
                        <strong>'.$language['right'].':</strong>
                        <input value="'.(isset($array['marginRight']) ? $array['marginRight'] : '').'" type="number" class="marginRight" style="width:100%;" />
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:top;width:50px;"></td>
                    <td style="vertical-align:top;width:50px;">
                        <strong>'.$language['bottom'].':</strong>
                        <input value="'.(isset($array['marginBottom']) ? $array['marginBottom'] : '').'" type="number" class="marginBottom" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:50px;"></td>
            </table>
            <table style="width:30%;vertical-align:top;float:right;text-align:center;">
                <tr>
                    <td style="vertical-align:top;width:50px;"></td>
                    <td style="vertical-align:top;width:50px;">
                        <strong>'.$language['top'].':</strong>
                        <input value="'.(isset($array['paddingTop']) ? $array['paddingTop'] : '').'" type="number" class="paddingTop" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:50px;"></td>
                </tr>
                    <td style="vertical-align:top;width:50px;">
                        <strong>'.$language['left'].':</strong>
                        <input value="'.(isset($array['paddingLeft']) ? $array['paddingLeft'] : '').'" type="number" class="paddingLeft" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:50px;"></td>
                    <td style="vertical-align:top;width:50px;">
                        <strong>'.$language['right'].':</strong>
                        <input value="'.(isset($array['paddingRight']) ? $array['paddingRight'] : '').'" type="number" class="paddingRight" style="width:100%;" />
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:top;width:50px;"></td>
                    <td style="vertical-align:top;width:50px;">
                        <strong>'.$language['bottom'].':</strong>
                        <input value="'.(isset($array['paddingBottom']) ? $array['paddingBottom'] : '').'" type="number" class="paddingBottom" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:50px;"></td>
            </table>
            <div style="clear:both;"></div>
            <h3><span style="float:left;">'.$language['border'].'</span><span style="float:right;">'.$language['outline'].'</span><div style="clear:both;"></div></h3>
            <table style="width:50%;vertical-align:top;float:left;">
                <tr>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['size'].':</strong>
                        <input value="'.(isset($array['borderSize']) ? $array['borderSize'] : '').'" type="number" class="borderSize" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['color'].':</strong>
                        <input value="'.(isset($array['borderColor']) ? $array['borderColor'] : '').'" type="text" pattern="^([a-fA-F0-9]{6}|[a-fA-F0-9]{6})$" class="colorPicker borderColor" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['type'].':</strong>
                        <select style="width:100%;" class="borderType">
                            <option value="solid"'.(isset($array['borderType'])&&$array['borderType']=='solid' ? ' SELECTED' : '').'>'.$language['solid'].'</option>
                            <option value="dotted"'.(isset($array['borderType'])&&$array['borderType']=='dotted' ? ' SELECTED' : '').'>'.$language['dotted'].'</option>
                            <option value="double"'.(isset($array['borderType'])&&$array['borderType']=='double' ? ' SELECTED' : '').'>'.$language['double'].'</option>
                        </select>
                    </td>
                    <td>
                        <strong>'.$language['borderRadius'].':</strong>
                        <input value="'.(isset($array['borderRadius']) ? $array['borderRadius'] : '').'" type="text" class="borderRadius" style="width:100%;" />
                    </td>
                </tr>
            </table>
            <table style="width:40%;vertical-align:top;float:right;">
                <tr>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['size'].':</strong>
                        <input value="'.(isset($array['outlineSize']) ? $array['outlineSize'] : '').'" type="number" class="outlineSize" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['color'].':</strong>
                        <input value="'.(isset($array['outlineColor']) ? $array['outlineColor'] : '').'" type="text" pattern="^([a-fA-F0-9]{6}|[a-fA-F0-9]{6})$" class="colorPicker outlineColor" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['type'].':</strong>
                        <select style="width:100%;" class="outlineType">
                            <option value="solid"'.(isset($array['outlineType'])&&$array['outlineType']=='solid' ? ' SELECTED' : '').'>'.$language['solid'].'</option>
                            <option value="dotted"'.(isset($array['outlineType'])&&$array['outlineType']=='dotted' ? ' SELECTED' : '').'>'.$language['dotted'].'</option>
                            <option value="double"'.(isset($array['outlineType'])&&$array['outlineType']=='double' ? ' SELECTED' : '').'>'.$language['double'].'</option>
                        </select>
                    </td>
                </tr>
            </table>
            <div style="clear:both"></div>
        </div>
        <div class="text" style="display:none;">
            <table style="width:100%;vertical-align:top;">
                <tr>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['color'].':</strong>
                        <input value="'.(isset($array['textColor']) ? $array['textColor'] : '').'" type="text" pattern="^([a-fA-F0-9]{6}|[a-fA-F0-9]{6})$" class="colorPicker textColor" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;">
                      
                    </td>
                    <td style="vertical-align:top;">
                        <strong>'.$language['family'].':</strong>
                        <select style="width:100%;" class="textFamily">
                           <option'.(isset($array['textFamily'])&&$array['textFamily']=='arial' ? ' SELECTED' : '').'>arial</option>
                           <option'.(isset($array['textFamily'])&&$array['textFamily']=='times new roman' ? ' SELECTED' : '').'>times new roman</option>
                           <option'.(isset($array['textFamily'])&&$array['textFamily']=='verdana' ? ' SELECTED' : '').'>verdana</option>
                        </select>
                    </td>
                    <td style="vertical-align:top;">
                        <strong>'.$language['size'].':</strong>
                        <input type="number" class="textSize" style="width:100%;" value="'.(isset($array['textSize']) ? $array['textSize'] : '').'" />
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['textAlign'].':</strong>
                        <select style="width:100%;" class="textAlign">
                           <option value="left"'.(isset($array['textAlign'])&&$array['textAlign']=='left' ? ' SELECTED' : '').'>'.$language['left'].'</option>
                           <option value="center"'.(isset($array['textAlign'])&&$array['textAlign']=='center' ? ' SELECTED' : '').'>'.$language['center'].'</option>
                           <option value="right"'.(isset($array['textAlign'])&&$array['textAlign']=='right' ? ' SELECTED' : '').'>'.$language['right'].'</option>
                        </select>
                    </td>
                    <td style="vertical-align:top;">
                      
                    </td>
                    <td style="vertical-align:top;">
                        <strong>'.$language['textDecoration'].':</strong>
                        <select style="width:100%;" class="textDecoration">
                           <option'.(isset($array['textDecoration'])&&$array['textDecoration']=='left' ? ' SELECTED' : '').'>'.$language['left'].'</option>
                           <option'.(isset($array['textDecoration'])&&$array['textDecoration']=='center' ? ' SELECTED' : '').'>'.$language['center'].'</option>
                           <option'.(isset($array['textDecoration'])&&$array['textDecoration']=='right' ? ' SELECTED' : '').'>'.$language['right'].'</option>
                        </select>
                    </td>
                    <td style="vertical-align:top;">
                    </td>
                </tr>
            </table>
        </div>
        <div class="positionDia" style="display:none;">
            <h3>'.$language['position'].'</h3>
            <table style="vertical-align:top;">
                <tr>
                    <td style="vertical-align:top;width:100px;">
                     <strong>'.$language['position'].':</strong>
                        <select class="position" style="width:100%;">
                            <option value="static"'.(isset($array['position'])&&$array['position']=='static' ? ' SELECTED' : '').'>'.$language['static'].'</option>
                            <option value="relative"'.(isset($array['position'])&&$array['position']=='relative' ? ' SELECTED' : '').'>'.$language['relative'].'</option>
                            <option value="absolute"'.(isset($array['position'])&&$array['position']=='absolute' ? ' SELECTED' : '').'>'.$language['absolute'].'</option>
                            <option value="fixed"'.(isset($array['position'])&&$array['position']=='fixed' ? ' SELECTED' : '').'>'.$language['fixed'].'</option>
                            <option value="inherit"'.(isset($array['position'])&&$array['position']=='inherit' ? ' SELECTED' : '').'>'.$language['inherit'].'</option>
                        </select>
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['top'].':</strong>
                        <input value="'.(isset($array['posTop']) ? $array['posTop'] : '').'" type="number" class="posTop" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['right'].':</strong>
                        <input value="'.(isset($array['posRight']) ? $array['posRight'] : '').'" type="number" class="posRight" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['bottom'].':</strong>
                        <input value="'.(isset($array['posBottom']) ? $array['posBottom'] : '').'" type="number" class="posBottom" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['left'].':</strong>
                        <input value="'.(isset($array['posLeft']) ? $array['posLeft'] : '').'" type="number" class="posLeft" style="width:100%;" />
                    </td>
                </tr>
            </table>
            <h3>'.$language['size'].'</h3>
            <table style="vertical-align:top;width:65%;float:left;">
                <tr>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['width'].':</strong>
                        <input value="'.(isset($array['width']) ? $array['width'] : '').'" type="number" class="width" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <select style="margin-top:14px;" class="widthOperator">
                            <option'.(isset($array['widthOperator']) && $array['widthOperator']=='%' ? ' SELECTED' : '').'>%</option>
                            <option'.(isset($array['widthOperator']) && $array['widthOperator']=='px' ? ' SELECTED' : '').'>px</option>
                        </select>
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['height'].':</strong>
                        <input value="'.(isset($array['height']) ? $array['height'] : '').'" type="number" class="height" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <select style="margin-top:14px;" class="heightOperator">
                            <option'.(isset($array['heightOperator']) && $array['heightOperator']=='%' ? ' SELECTED' : '').'>%</option>
                            <option'.(isset($array['heightOperator']) && $array['heightOperator']=='px' ? ' SELECTED' : '').'>px</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['minimal'].' '.$language['width'].':</strong>
                        <input value="'.(isset($array['minWidth']) ? $array['minWidth'] : '').'" type="number" class="minWidth" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <select style="margin-top:14px;" class="minWidthOperator">
                            <option'.(isset($array['minWidthOperator']) && $array['minWidthOperator']=='%' ? ' SELECTED' : '').'>%</option>
                            <option'.(isset($array['minWidthOperator']) && $array['minWidthOperator']=='px' ? ' SELECTED' : '').'>px</option>
                        </select>
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['minimal'].' '.$language['height'].':</strong>
                        <input value="'.(isset($array['minHeight']) ? $array['minHeight'] : '').'" type="number" class="minHeight" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <select style="margin-top:14px;" class="minHeightOperator">
                            <option'.(isset($array['minHeightOperator']) && $array['minHeightOperator']=='%' ? ' SELECTED' : '').'>%</option>
                            <option'.(isset($array['minHeightOperator']) && $array['minHeightOperator']=='px' ? ' SELECTED' : '').'>px</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['maximal'].' '.$language['width'].':</strong>
                        <input value="'.(isset($array['maxWidth']) ? $array['maxWidth'] : '').'" type="number" class="maxWidth" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <select style="margin-top:14px;" class="maxWidthOperator">
                            <option'.(isset($array['maxWidthOperator']) && $array['maxWidthOperator']=='%' ? ' SELECTED' : '').'>%</option>
                            <option'.(isset($array['maxWidthOperator']) && $array['maxWidthOperator']=='px' ? ' SELECTED' : '').'>px</option>
                        </select>
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <strong>'.$language['maximal'].' '.$language['height'].':</strong>
                        <input value="'.(isset($array['maxHeight']) ? $array['maxHeight'] : '').'" type="number" class="maxHeight" style="width:100%;" />
                    </td>
                    <td style="vertical-align:top;width:100px;">
                        <select style="margin-top:14px;" class="maxHeightOperator">
                            <option'.(isset($array['maxHeightOperator']) && $array['maxHeightOperator']=='%' ? ' SELECTED' : '').'>%</option>
                            <option'.(isset($array['maxHeightOperator']) && $array['maxHeightOperator']=='px' ? ' SELECTED' : '').'>px</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        '.$additionalContent.'
    </div>
    <div class="modalFooter">
        <button onclick="refreshTemplate($(\'#'.$id.'\'));" class="button submit blue">'.$language['save'].'</button>
    </div>
    <script>
        function '.$id.'Hide(){
            $("#'.$id.' .model").hide();
            $("#'.$id.' .text").hide();
            $("#'.$id.' .positionDia").hide();
            $("#'.$id.' .additional").hide();
        }
    </script>
        ';
        return $modalContent;
    }
}
