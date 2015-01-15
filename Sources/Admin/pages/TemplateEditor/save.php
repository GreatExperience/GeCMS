<?php
    if(!isset($_POST)){
        throw new Exception('No data found');
    }
    
    if(!isset($_GET['template'])){
        throw new Exception('No template found');
    }
    
    $template = $_GET['template'];
    $fileURL = $connect['root'].'/Templates/'.$template.'/roller.template.php';
    
    if(!file_exists($fileURL)){
        throw new Exception('Template "roller.template.php" does not exist!');
    }

    /* Creating Theme file */
    $fileContent = "<?php \n";
    foreach($_POST as $key => $value){
        $fileContent .= "   \$tmp$key = array(\n";

        foreach($_POST[$key] as $settingName => $settingValue){
            $fileContent .= "       '$settingName' => '$settingValue',\n";
        }
        $fileContent .= "   );\n\n";
    }

    $themeRoller = fopen($fileURL, 'w+');
    
    if(!fwrite($themeRoller, $fileContent)){
        throw new Exception('no acces to edit file');
    }else{
        echo '<script>$("#modalSave").fadeIn();</script>';
    }
    
    fclose($themeRoller);
?>