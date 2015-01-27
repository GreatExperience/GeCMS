<?php
/**
 * TEMPLATE EDITOR
 * @version 1.0 beta
 * @author Merijn Geurts
 * @License Dual license of GeCMS
 */
if(!$log)exit;

if( ! isset($_GET['template'])){
    Throw new Exception("No template selected");
}

$template = $_GET['template'];
$templateRoot = './Templates/'.$template;
$item = array(
    'header' => 'modalheader',
    'menu' => 'modalmenu',
    'footer' => 'modalfooter',
    'body' => 'modalbody',
    'container' => 'modalcontainer'
);

/* Footer has additional options */
$footerAdditional = '
    <h3>'.$language['displayMenuFooter'].'</h3>
    <select class="menuFooter">
        <option value="true"'.(isset($tmpfooter['menuFooter'])&&$tmpfooter['menuFooter']=='true' ? ' SELECTED' : '').'>'.$language['show'].'</option>
        <option value="false"'.(isset($tmpfooter['menuFooter'])&&$tmpfooter['menuFooter']=='false' ? ' SELECTED' : '').'>'.$language['hide'].'</option>
    </select>
';
    
if( ! file_exists($templateRoot .'/admin.template.php') ||  ! file_exists($templateRoot .'/roller.template.php')){
    Throw new Exception("Missing files or unable to edit");
}
    
require_once($templateRoot.'/admin.template.php');
require_once($templateRoot.'/roller.template.php');

echo '
    <header>
        <div class="header" style="z-index:5;position:relative;">
            <button class="root">'.$language['templates'].'</button>
            <button class="root sub">'.$template.'</button>
            <button class="button blue editMenuToggle" onclick="editMenuToggle()" style="float:right;height:40px;border-radius:0;z-index:2;padding:5px;">'.Icon::display('../template/menuSwitch.png', array('style' => 'position:relative;left:1px;')).'</button>
            <button onclick="save()" class="button blue" style="float:right;margin-right:10px;margin-top:4px;"><img src="'.$connect['url'].'/Sources/Admin/images/icons/accept.png">'.$language['save'].'</button>
            <button class="button" onclick="openModal(\'#modalheader\')" style="float:right;margin-right:10px;margin-top:4px;"><img src="'.$connect['url'].'/Sources/Admin/images/icons/bullet_wrench.png">'.$language['templateEditHeader'].'</button>
            <button class="button" onclick="openModal(\'#modalfooter\')" style="float:right;margin-right:10px;margin-top:4px;"><img src="'.$connect['url'].'/Sources/Admin/images/icons/bullet_wrench.png">'.$language['templateEditFooter'].'</button>
            <button class="button" onclick="openModal(\'#modalmenu\')" style="float:right;margin-right:10px;margin-top:4px;"><img src="'.$connect['url'].'/Sources/Admin/images/icons/bullet_wrench.png">'.$language['templateEditMenu'].'</button>
            <button class="button" onclick="openModal(\'#modalbody\')" style="float:right;margin-right:10px;margin-top:4px;"><img src="'.$connect['url'].'/Sources/Admin/images/icons/bullet_wrench.png">'.$language['templateEditBody'].'</button>
            <button class="button" onclick="openModal(\'#modalcontainer\')" style="float:right;margin-right:10px;margin-top:4px;"><img src="'.$connect['url'].'/Sources/Admin/images/icons/bullet_wrench.png">'.$language['templateEditContainer'].'</button>
       </div>
    </header>
    <div style="position:relative;top:-41px;height:100%;padding-top:41px;box-sizing:border-box;margin-bottom:-60px;z-index:4;">
    <div style="width:100%;position:relative;height:100%;z-index:4;">
    <iframe onclick="$(\'.colorpicker\').delay(100).hide();" id="preview" src="./index.php?editorLayout='.$template.'&footerMenu=true" style="border:0;width:75%;height:100%;position:absolute;bottom:0;top:0;"></iframe>

    <div class="framePreLoader">
        <img src="./Sources/Admin/images/loader.gif" /><h1>'.$language['templateEditor'].'</h1>
    </div>
';

$count = false;
foreach($item as $key=>$value){
    
    /* Select background dialog */
    $imageModal = new Modal('', 'modalBG'.$key);
    $imageModal->setHeader(false);
    $imageModal->setContent('...');
    
    echo $imageModal->render().'
    <div class="sideMenu" id="'.$value.'" style="display:'.($count==false ? 'true' : 'false').';width:25%;float:right;position:absolute;right:0;top:0;bottom:0;background:#fff;">
    ';  
    if($key=='footer'){
        echo '<div>'.templateEditSide::modalContent('modal'.$key, $key, ${'tmp'.$key}, array('additional' => $footerAdditional)).'</div>';
    }else{
        echo '<div>'.templateEditSide::modalContent('modal'.$key, $key, ${'tmp'.$key}).'</div>';
    }

    echo '</div>';

    $count = true;
}

/* Saving template with succes = show finish modal */
$finishModal = new Modal($language['save'], 'modalSave');
$finishModal->setContent('<p style="text-align:center;">'.$language['saveSucces'].'</p> <div class="modalFooter"><button class="blue button" onclick="$(\'#modalSave\').fadeOut();">'.$language['go'].'</button></div>');
$finishModal->setHeight(125);
$finishModal->setWidth(225);
$finishModal->setHeader(false);

/* Saving template with validate error = show validateModal */
$validateModalContent = '<p>'.$language['validateError'].'</p>';
$validateModal = new Modal($language['validateErrorTitle'], 'validateModal');
$validateModal->setContent($validateModalContent);

echo $validateModal->render()
.$finishModal->render()
.'</div></div>';

?>
<style>
  .framePreLoader {position:absolute;left:0;top:0;right:0;bottom:0;z-index:100;background:#fff;text-align:center;padding-top:calc(50% - 250px);}
</style>
<script>
    var elementCache = {};
    /*
     *  jQuery on start
     *  Setup template editor
     */
    
    /* Make template clickable for editor */
    $('#preview').one('load', function() {
        $('.framePreLoader').fadeOut();
        /* Do not click on links :) */
        $('#preview').contents().find('body a').attr("href","#");
        
        document.getElementById("preview").contentDocument.addEventListener('click', function(event) {$('.colorpicker').hide();}, false);
        
        
        /* Template click & hover events */
        object = {0:{0:'nav', 1:'menu'},  1:{0:'footer', 1:'footer'},  2:{0:'header', 1:'header'},  3:{0:'content.container', 1:'container'}};
        $.each(object, function(index, value) {
            $('#preview').contents().find('body .'+value[0]).hover(function(){
                $('#preview').contents().find('body .'+value[0]).css("outline","2px solid red");
            },function(){
                $('#preview').contents().find('body .'+value[0]).css("outline","");
            });
            
            $('#preview').contents().find('body .'+ value[0]).click(function(){openModal('#modal'+value[1]);});
            
        });
        
        <?php
            if (isset($tmpfooter['menuFooter'])&&$tmpfooter['menuFooter']=='false'){
                echo '$(\'#preview\').contents().find(".footer .menu").css("display", "none");';
            }
        ?>
    });
    

    $(document).ready(function(){
        $('.colorPicker').ColorPicker({
            onSubmit: function(hsb, hex, rgb, el) {
		$(el).val(hex);
		$(el).ColorPickerHide();
            },
            onBeforeShow: function () {
                    $(this).ColorPickerSetColor(this.value);
            }
        })
        .bind('keyup', function(){
                $(this).ColorPickerSetColor(this.value);
        });
        <?php 
            foreach($item as $key=>$value){ 
                echo '
                $("#'.$value.'").find("input, select").change(function(){refreshTemplate()});
                $(".colorpicker_submit").click(function(){refreshTemplate()});
                '; 
               
            } 
        ?>
   });
   
   var menuToggle = false;
   function editMenuToggle(){
       if(menuToggle){
           $('.sideMenu').css({'margin-right': '0'});
           $('#preview').css('width', '75%');
           menuToggle = false;
       }else{
           $('.sideMenu').css({'margin-right': '-25%'});
           $('#preview').css('width', '100%');
           menuToggle = true;
       }
   }
   
   /*
    * Refresh function
    */
   function refreshTemplate(){
       
       if(validate(true)===true){
            var ele = 5;
             var count = 0;
             var selector1 = '';
             var selector2 = '';
             while(count < ele){
                switch(count){
                    case 0:  selector1 = 'body';        selector2 = 'body';     break;
                    case 1:  selector1 = 'header';      selector2 = '.header';  break;
                    case 2:  selector1 = 'menu';        selector2 = '.nav';    break;
                    case 3:  selector1 = 'footer';      selector2 = '.footer';  break;
                    case 4:  selector1 = 'container';   selector2 = '.content';  break;
                }
                $('#preview').contents().find(selector2).css({
                     'background' : '#'+$('#modal'+selector1+' .bgColor').val() + ' url('+$('#modal'+selector1+' .bgImage').val()+')',
                     'backgroundPosition': $('#modal'+selector1+' .backgroundPosition').val(),
                     'backgroundRepeat': $('#modal'+selector1+' .backgroundRepeat').val(),
                     'color': '#' + $('#modal'+selector1+' .textColor').val(),
                     'font-family': $('#modal'+selector1+' .textFamily').val(),
                     'font-size': $('#modal'+selector1+' .textSize').val() + 'px',
                     'marginLeft': $('#modal'+selector1+' .marginLeft').val() + 'px',
                     'marginRight': $('#modal'+selector1+' .marginRight').val() + 'px',
                     'marginTop': $('#modal'+selector1+' .marginTop').val() + 'px',
                     'marginBottom': $('#modal'+selector1+' .marginBottom').val() + 'px',
                     'paddingLeft': $('#modal'+selector1+' .paddingLeft').val() + 'px',
                     'paddingRight': $('#modal'+selector1+' .paddingRight').val() + 'px',
                     'paddingTop': $('#modal'+selector1+' .paddingTop').val() + 'px',
                     'paddingBottom': $('#modal'+selector1+' .paddingBottom').val() + 'px',
                     'border': $('#modal'+selector1+' .borderSize').val() + 'px ' + $('#modal'+selector1+' .borderType').val() + ' #' + $('#modal'+selector1+' .borderColor').val(),
                     'borderRadius': $('#modal'+selector1+' .borderRadius').val() + "px",
                     'outline': $('#modal'+selector1+' .outlineSize').val() + 'px ' + $('#modal'+selector1+' .outlineType').val() + ' #' + $('#modal'+selector1+' .outlineColor').val(),
                     'position': $('#modal'+selector1+' .position').val(),
                     'left': $('#modal'+selector1+' .posLeft').val() + "px",
                     'right': $('#modal'+selector1+' .posRight').val() + "px",
                     'top': $('#modal'+selector1+' .posTop').val() + "px",
                     'bottom': $('#modal'+selector1+' .posbottom').val() + "px",
                     'width': $('#modal'+selector1+' .width').val() + $('#modal'+selector1+' .widthOperator').val(),
                     'minWidth': $('#modal'+selector1+' .minWidth').val() + $('#modal'+selector1+' .minWidthOperator').val(),
                     'maxWidth': $('#modal'+selector1+' .maxWidth').val() + $('#modal'+selector1+' .maxWidthOperator').val(),
                     'height': $('#modal'+selector1+' .height').val() + $('#modal'+selector1+' .heightOperator').val(),
                     'minHeight': $('#modal'+selector1+' .minHeight').val() + $('#modal'+selector1+' .minHeightOperator').val(),
                     'maxHeight': $('#modal'+selector1+' .maxHeight').val() + $('#modal'+selector1+' .maxHeightOperator').val(),
                     'textAlign': $('#modal'+selector1+' .textAlign').val(),
                     'textDecoration': $('#modal'+selector1+' .textDecoration').val()
                });
                
                if(selector1==='footer' && $('#modal'+selector1+' .menuFooter').val()=='false'){
                    $('#preview').contents().find(selector2 + ' .menu').css('display', 'none');
                }else{
                    $('#preview').contents().find(selector2 + ' .menu').css('display', 'initial');
                }
                
                if(selector1=='container'){
                    $('#preview').contents().find('.nav .container').css({
                        'width': $('#modal'+selector1+' .width').val() + $('#modal'+selector1+' .widthOperator').val(),
                        'minWidth': $('#modal'+selector1+' .minWidth').val() + $('#modal'+selector1+' .minWidthOperator').val(),
                        'maxWidth': $('#modal'+selector1+' .maxWidth').val() + $('#modal'+selector1+' .maxWidthOperator').val(),
                    });
                }
                
                if(selector1=='menu'){
                    $('#preview').contents().find('.nav > div > ul > li > a').css({
                        'line-height': $('#modal'+selector1+' .height').val() + $('#modal'+selector1+' .heightOperator').val(),
                    });
                }
                count++;
            }
            
            if($('.menuFooter').val()=='true'){
                $('#preview').contents().find('.footer .menu').show();
            }else{
                $('#preview').contents().find('.footer .menu').hide();
            }
        }
   }
   
   /*
    * Opening a edit menu
    * @param {editMenu} modal
    * @returns {nothing}
    */
   function openModal(modal){
       <?php foreach($item as $key=>$value){ echo '$("#'.$value.'").hide();'; } ?>
               console.log(modal);
       $(modal).show();
       elementCache = getObjectByModal(modal);
   }
   
   /**
    * Used for?
    * @param {type} modal
    * @returns {undefined}
    */
   function modalReturnValues(modal){
       $.each(elementCache, function(index, value) {
           console.log('$("#' + modal + ' .'+index + '").val('+value+');');
           $('#' + modal + ' .'+index).val(value);
       });
   }
   
   /*
    * Global save To save settings to template
    * @returns {Nothing}
    */
   function save(){
       var object = {}
       var ele = 5;
       var count = 0;
       var selector = '';
       while(count < ele){
           switch(count){
               case 0:  selector = 'body';    break;
               case 1:  selector = 'header';  break;
               case 2:  selector = 'menu';    break;
               case 3:  selector = 'footer';  break;
               case 4:  selector = 'container';  break;
           }
           
           object[selector] = getObjectByModal('#modal'+selector);

           count++;
       }
       
        if(validate(false)===true){
            $.ajax({
             type: "POST",
             url: "./admin.php?layout=false&noScripts=true&action=/templateEditor/save&template=<?php echo $template; ?>",
             data: object,
             success: function(data){
                 $('#hidden').html(data);
             },
             dataType: "html"
           });
       }else{
        $('#validateModal').fadeIn();
       }
   }
   
   /**
   * Checks if all fields(ALL edit menu's) are filled correctly.
   * @param {boolean} bool (not used yet)
   * @returns {Boolean}    
   **/
   function validate(bool){
       var stop = false;
       var count = 0;
       var validated = true;
       while(stop===false){
           vElement = $('input')[count];
            if(vElement !== undefined && vElement.length !== 0){
               if(vElement.checkValidity() !== true){
                   $(document.getElementsByClassName(vElement.className)).addClass('invalid');
                   validated = false;
               }else{
                   $(document.getElementsByClassName(vElement.className)).removeClass('invalid');
               }
            }else{
                stop = true;
            }
           count++;
       }
       return validated;
   }
   
   /**
   * Returns object with values from selected edit menu
   * @param {modalMenu} selector
   * @returns {getObjectByModal.templateEditorAnonym$4}    
   **/
   function getObjectByModal(selector){
       return {
           'background': $(selector+' .bgColor').val(),
           'backgroundImage': $(selector+' .bgImage').val(),
           'backgroundPosition': $(selector+' .backgroundPosition').val(),
           'backgroundRepeat': $(selector+' .backgroundRepeat').val(),
           'textColor': $(selector+' .textColor').val(),
           'textFamily': $(selector+' .textFamily').val(),
           'textSize': $(selector+' .textSize').val(),
           'marginLeft': $(selector+' .marginLeft').val(),
           'marginRight': $(selector+' .marginRight').val(),
           'marginTop': $(selector+' .marginTop').val(),
           'marginBottom': $(selector+' .marginBottom').val(),
           'paddingLeft': $(selector+' .paddingLeft').val(),
           'paddingRight': $(selector+' .paddingRight').val(),
           'paddingTop': $(selector+' .paddingTop').val(),
           'paddingBottom': $(selector+' .paddingBottom').val(),
           'borderSize': $(selector+' .borderSize').val(),
           'borderType': $(selector+' .borderType').val(),
           'borderColor': $(selector+' .borderColor').val(),
           'borderRadius': $(selector+' .borderRadius').val(),
           'outlineSize': $(selector+' .outlineSize').val(),
           'outlineType': $(selector+' .outlineType').val(),
           'outlineColor': $(selector+' .outlineColor').val(),
           'position': $(selector+' .position').val(),
           'left': $(selector+' .posLeft').val(),
           'right': $(selector+' .posRight').val(),
           'top': $(selector+' .posTop').val(),
           'bottom': $(selector+' .posBottom').val(),
           'width': $(selector+' .width').val(),
           'minWidth': $(selector+' .minWidth').val(),
           'maxWidth': $(selector+' .maxWidth').val(),
           'widthOperator': $(selector+' .widthOperator').val(),
           'minWidthOperator': $(selector+' .minWidthOperator').val(),
           'maxWidthOperator': $(selector+' .maxWidthOperator').val(),
           'height': $(selector+' .height').val(),
           'minHeight': $(selector+' .minHeight').val(),
           'maxHeight': $(selector+' .maxHeight').val(),
           'heightOperator': $(selector+' .heightOperator').val(),
           'minHeightOperator': $(selector+' .minHeightOperator').val(),
           'maxHeightOperator': $(selector+' .maxHeightOperator').val(),
           'textDecoration': $(selector+' .textDecoration').val(),
           'textAlign': $(selector+' .textAlign').val(),
           'menuFooter': $(selector+' .menuFooter').val()
           };
   }
   
   /**
   * Function for textAlign buttons
   * @param {textalignButton} element button to be turned to blue
   * @param {textalignButton} inner buttons to be turned to gray
   * @returns nothing    
   **/
   function changeTextAlign(element, inner){
       $('#'+ inner + ' .textAlignBTN').removeClass('blue');
       $(element).addClass('blue');
   }
   
   
</script>
<div id="hidden"></div>