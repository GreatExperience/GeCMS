<?php

if (!$log)
    exit;

class file extends Explorer {
    /* global file information */

    /**
     * 
     * @global type $connect
     * @param type $src
     */
    public function __CONSTRUCT($src) {
        global $connect;	    
	    parent::__CONSTRUCT($src);

            $file = basename($this->getSRC());
            /* images */
            if (strpos($file, '.png') !== false)
                $file_type = 'PNG image';
            elseif (strpos(strtolower($file), '.gif') !== false)
                $file_type = 'GIF image';
            elseif (strpos(strtolower($file), '.jpg') !== false)
                $file_type = 'JPEG image';
            elseif (strpos(strtolower($file), '.jpeg') !== false)
                $file_type = 'JPEG image';
            elseif (strpos(strtolower($file), '.bmp') !== false)
                $file_type = 'MSPAINT image';
            elseif (strpos(strtolower($file), '.tga') !== false)
                $file_type = 'TRUEVISION image';
            elseif (strpos(strtolower($file), '.ico') !== false)
                $file_type = 'Icon';

            elseif (strpos($file, '.pdf') !== false)
                $file_type = 'PDF file';
            elseif (strpos($file, '.db') !== false)
                $file_type = 'Database file';
            elseif (strpos($file, '.sql') !== false)
                $file_type = 'Database file';

            /* WEB DESIGN */
            elseif (strpos($file, '.htc') !== false)
                $file_type = 'HTML Component';
            elseif (strpos($file, '.js') !== false)
                $file_type = 'Javascript file';
            elseif (strpos($file, '.css') !== false)
                $file_type = 'Stylesheet file';
            elseif (strpos($file, '.html') !== false)
                $file_type = 'HTML file';
            elseif (strpos($file, '.htm') !== false)
                $file_type = 'HTML file';
            elseif (strpos($file, '.shtml') !== false)
                $file_type = 'HTML file';
            elseif (strpos($file, '.phtml') !== false)
                $file_type = 'PHP file';
            elseif (strpos($file, '.php') !== false)
                $file_type = 'PHP file';
            elseif (strpos($file, '.php3') !== false)
                $file_type = 'PHP file';
            elseif (strpos($file, '.php4') !== false)
                $file_type = 'PHP file';
            elseif (strpos($file, '.php5') !== false)
                $file_type = 'PHP file';
            elseif (strpos($file, '.php6') !== false)
                $file_type = 'PHP file';
            elseif (strpos($file, '.phps') !== false)
                $file_type = 'PHP file';

            /* Microsoft office WORD */
            elseif (strpos(strtolower($file), '.doc') !== false)
                $file_type = 'WORD document';
            elseif (strpos($file, '.docx') !== false)
                $file_type = 'WORD document';
            elseif (strpos($file, '.docm') !== false)
                $file_type = 'WORD document';
            elseif (strpos($file, '.dotx') !== false)
                $file_type = 'WORD document';
            elseif (strpos($file, '.dotm') !== false)
                $file_type = 'WORD document';

            /* Microsoft office Excell */
            elseif (strpos($file, '.xls') !== false)
                $file_type = 'EXCEL document';
            elseif (strpos($file, '.xlsx') !== false)
                $file_type = 'EXCEL document';
            elseif (strpos($file, '.xlsm') !== false)
                $file_type = 'EXCEL document';
            elseif (strpos($file, '.xltx') !== false)
                $file_type = 'EXCEL document';
            elseif (strpos($file, '.xltm') !== false)
                $file_type = 'EXCEL document';
            elseif (strpos($file, '.xlsb') !== false)
                $file_type = 'EXCEL document';
            elseif (strpos($file, '.xlam') !== false)
                $file_type = 'EXCEL document';
            elseif (strpos($file, '.xll') !== false)
                $file_type = 'EXCEL document';

            /* Microsoft office Powerpoint */
            elseif (strpos($file, '.fnt') !== false)
                $file_type = 'POWERPOINT';
            elseif (strpos($file, '.pptm') !== false)
                $file_type = 'POWERPOINT';
            elseif (strpos($file, '.ppt') !== false)
                $file_type = 'POWERPOINT';
            elseif (strpos($file, '.potx') !== false)
                $file_type = 'POWERPOINT';
            elseif (strpos($file, '.potm') !== false)
                $file_type = 'POWERPOINT';
            elseif (strpos($file, '.ppam') !== false)
                $file_type = 'POWERPOINT';
            elseif (strpos($file, '.ppsx') !== false)
                $file_type = 'POWERPOINT';
            elseif (strpos($file, '.ppsm') !== false)
                $file_type = 'POWERPOINT';
            elseif (strpos($file, '.pptx') !== false)
                $file_type = 'POWERPOINT';

            /* font files */
            elseif (strpos($file, '.abf') !== false)
                $file_type = 'FONT file';
            elseif (strpos($file, '.acfm') !== false)
                $file_type = 'FONT file';
            elseif (strpos($file, '.afm') !== false)
                $file_type = 'FONT file';
            elseif (strpos($file, '.amfm') !== false)
                $file_type = 'FONT file';
            elseif (strpos($file, '.bdf') !== false)
                $file_type = 'FONT file';
            elseif (strpos($file, '.cha') !== false)
                $file_type = 'FONT file';
            elseif (strpos($file, '.chr') !== false)
                $file_type = 'FONT file';
            elseif (strpos($file, '.dfont') !== false)
                $file_type = 'FONT file';
            elseif (strpos($file, '.fnt') !== false)
                $file_type = 'FONT file';

            /* sound and media */
            elseif (strpos($file, '.mp3') !== false)
                $file_type = 'MP3 media file';
            elseif (strpos($file, '.mp4') !== false)
                $file_type = 'MP4 media file';
            elseif (strpos($file, '.mpeg') !== false)
                $file_type = 'Media file';
            elseif (strpos($file, '.mpg') !== false)
                $file_type = 'Media file';
            elseif (strpos($file, '.mpc') !== false)
                $file_type = 'Classic Media file';

            /* others */
            elseif (strpos($file, '.dll') !== false)
                $file_type = 'DLL file';
            elseif (strpos($file, '.exe') !== false)
                $file_type = 'executable file';
            elseif (strpos($file, '.rar') !== false)
                $file_type = 'RAR file';
            elseif (strpos($file, '.zip') !== false)
                $file_type = 'ZIP file';
            elseif (strpos($file, '.dat') !== false)
                $file_type = 'DAT file)';
            elseif (strpos($file, '.rb') !== false)
                $file_type = 'Ruby file)';
            elseif (strpos($file, '.rtf') !== false)
                $file_type = 'Rich Text Format file';
            elseif (strpos($file, '.exe') !== false)
                $file_type = 'Execution file';
	    else
		$file_type = 'Uknown file';

            if ($file_type == "PHP file") {
		$this->setIcon(Icon::display('page_white_php.png'));
                $this->setEditor(1);
            } elseif ($file_type == "Stylesheet file") {
		$this->setIcon(Icon::display('css.png'));
                $this->setEditor(1);
            } elseif ($file_type == "HTML file") {
		$this->setIcon(Icon::display('html.png'));
                $this->setEditor(1);
            } elseif ($file_type == "Javascript file") {
		$this->setIcon(Icon::display('script.png'));
                $this->setEditor(0);
            } elseif ($file_type == "Icon" || $file_type == "PNG image" || $file_type == "GIF image" || $file_type == "JPEG image" || $file_type == "MSPAINT image" || $file_type == "TRUEVISION image") {
		$this->setIcon(Icon::display('image.png'));
                $this->setEditor(0);
            } elseif ($file_type == "PDF file") {
		$this->setIcon(Icon::display('page_white_acrobat.png'));
                $this->setEditor(0);
            } elseif ($file_type == "ZIP file") {
		$this->setIcon(Icon::display('box.png'));
                $this->setEditor(0);
            } elseif ($file_type == "RAR file") {
		$this->setIcon(Icon::display('box.png'));
                $this->setEditor(0);
            } elseif ($file_type == "WORD document") {
		$this->setIcon(Icon::display('page_word.png'));
                $this->setEditor(0);
            } elseif ($file_type == "EXCEL document") {
		$this->setIcon(Icon::display('page_excel.png'));
                $this->setEditor(0);
            } elseif ($file_type == "POWERPOINT") {
		$this->setIcon(Icon::display('page_white_powerpoint.png'));
                $this->setEditor(0);
            } elseif ($file_type == "Execution file") {
		$this->setIcon(Icon::display('application.png'));
                $this->setEditor(0);
            } else {
		$this->setIcon(Icon::display('page_white.png'));
                $this->setEditor(0);
            }
            $this->setType($file_type);
    }
    
    /**
     * 
     * @return type
     */
    public function getContent() {
        return file_get_contents($this->getSRC());
    }
    
    /**
     * 
     * @return boolean
     */
    public function deleteFile() {
        if (unlink($this->getSRC())) {
            return true;
        } else {
            return false;
        };
    }
    
    /**
     * 
     * @param type $content
     * @return boolean
     */
    public function editFile($content) {

        if (is_writable($this->getSRC())) {
            if ($_GET['edit'] == true) {

                $fp = fopen($_GET['root'] . "/" . $_GET['file'], 'w');
                fwrite($fp, stripslashes($_POST['content']));
                fclose($fp);

                return true;
            }

            if (isset($_POST['pageTitle']) && isset($_POST['pageTemplate'])) {
                $update = $dbh->prepare("UPDATE " . $connect['ext'] . "pages SET title=? WHERE file=?");
                $update->execute(array($_POST['pageTitle'], $_GET['file']));

                $update = $dbh->prepare("UPDATE " . $connect['ext'] . "pages SET template=? WHERE file=?");
                $update->execute(array($_POST['pageTemplate'], $_GET['file']));
            }
        } else {
            return true;
        }
    }
    
    /**
     * 
     * @return boolean
     */
    public function isImage() {
	if(strpos($this->getType(),strtolower('image')) !== false){
	    return true;
	}else{return false;}
    }
    
    /**
     * 
     * @return boolean
     */
    public function isMedia() {
	if(strpos($this->getType(),strtolower('media')) !== false){
	    return true;
	}else{return false;}
    }
}

?>
