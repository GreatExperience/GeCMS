<?php

if(!$log)exit;

if( ! isset($_GET['template'])){
    Throw new Exception("No template selected");
}

$template = $_GET['template'];
$templateRoot = './Templates/'.$template;
    
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
    <iframe id="preview" src="./index.php?editorLayout='.$template.'&footerMenu=true" style="border:0;width:100%;height:100%;position:absolute;bottom:0;top:0;"></iframe>
    <div class="framePreLoader">
        <img src="./Sources/Admin/images/loader.gif" /><h1>'.$language['templateEditor'].'</h1>
    </div>
';

$modal['header'] = new Modal($language['templateEditHeader'], 'modalheader');
$modal['menu'] = new Modal($language['templateEditMenu'], 'modalmenu');
$modal['footer'] = new Modal($language['templateEditFooter'], 'modalfooter');
$modal['body'] = new Modal($language['templateEditBody'], 'modalbody');
$modal['container'] = new Modal($language['templateEditContainer'], 'modalcontainer');

$footerAdditional = '
    <h3>'.$language['displayMenuFooter'].'</h3>
    <select class="menuFooter">
        <option value="true"'.(isset($tmpfooter['menuFooter'])&&$tmpfooter['menuFooter']=='true' ? ' SELECTED' : '').'>'.$language['show'].'</option>
        <option value="false"'.(isset($tmpfooter['menuFooter'])&&$tmpfooter['menuFooter']=='false' ? ' SELECTED' : '').'>'.$language['hide'].'</option>
    </select>
';

foreach($modal as $key=>$value){
    $value->setWidth('800', 'px');
    $value->setHeight('600', 'px');
    $value->setHeader(false);
    if($key=='footer'){
        $value->setContent(templateEdit::modalContent('modal'.$key, ${'tmp'.$key}, array('additional' => $footerAdditional)));
    }else{
        $value->setContent(templateEdit::modalContent('modal'.$key, ${'tmp'.$key}));
    }
    $value->setCloseAction('modalReturnValues(\'modal'.$key.'\');');
}

$finishModal = new Modal($language['save'], 'modalSave');
$finishModal->setContent('<p style="text-align:center;">'.$language['saveSucces'].'</p> <div class="modalFooter"><button class="blue button" onclick="$(\'#modalSave\').fadeOut();">'.$language['go'].'</button></div>');
$finishModal->setHeight(125);
$finishModal->setWidth(225);
$finishModal->setHeader(false);

$validateModalContent = '<p>'.$language['validateError'].'</p>';
$validateModal = new Modal($language['validateErrorTitle'], 'validateModal');
$validateModal->setContent($validateModalContent);

echo $validateModal->render()
.$modal['header']->render()
.$modal['menu']->render()
.$modal['footer']->render()
.$modal['body']->render()
.$modal['container']->render()
.$finishModal->render()
.'</div></div>';

?>
<style>
  .framePreLoader {position:absolute;left:0;top:0;right:0;bottom:0;background:#fff;text-align:center;padding-top:calc(50% - 250px);}

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
            if ($tmpfooter['menuFooter']=='false'){
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
   });
   
   /*
    * Refresh function
    * For each dialog 'save' to see changes live
    */
   function refreshTemplate(element){
       
       if(validate(true)===true){
            element.fadeOut();
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
                count++;
            }
            
            if($('.menuFooter').val()=='true'){
                $('#preview').contents().find('.footer .menu').show();
                console.log("show");
            }else{
                $('#preview').contents().find('.footer .menu').hide();
                console.log("hide");
            }
        }
   }
   
   function openModal(modal){
       $(modal).fadeIn();
       elementCache = getObjectByModal(modal);
   }
   
   function modalReturnValues(modal){
       $.each(elementCache, function(index, value) {
           console.log('$("#' + modal + ' .'+index + '").val('+value+');');
           $('#' + modal + ' .'+index).val(value);
       });
   }
   
   /*
    * Global save
    * To save settings to template
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
   
   
</script>
<div id="hidden"></div>