<?php
/**
 * Die Klasse page handhabt das ausgeben und modifizieren einer Seite
 *
 * @author Marius Rüter
 */
require_once 'stringparser.class.php';
require_once 'stringparser_bbcode.class.php';
require_once 'template.class.php';
require_once '../system/handlers/pageHandler.class.php';


class page {
    var $template;
    var $style = "default";
    var $home_link = "index.php";

    // setup page on default
    function __construct($constructPage=TRUE) {
        if($constructPage) {
            $this->setup_page();
        }
    }
    
    function setup_page() {

        $this->template = new Template();
        $this->template->readin("style/".$this->style."/tpl/tpl_overall.html");
        $this->template->fillin(
            "STYLESHEET",
            '<link rel="stylesheet" type="text/css" href="style/'.$this->style.'/css/default.css">'."\n".
            '<link rel="shortcut icon" type="image/x-icon" href="style/'.$this->style.'/img/favicon.ico">'
        );
        $this->template->fillin(
            "JAVASCRIPT",
            '<script src="style/'.$this->style.'/js/jquery-1.8.2.min.js" type="text/javascript"></script>'."\n".
            '<script src="style/'.$this->style.'/js/default.js" type="text/javascript"></script>'
        );
        $this->template->fillin("TITLE", "ITC-Grades-Tool");
        $this->template->fillin("ROTATOR",'<img src="style/'.$this->style.'/img/loader.gif"/>');
        $this->template->fillin("HOME_LINK", $this->home_link);


        $main_tpl = new Template();
        $main_tpl->readin("style/".$this->style."/tpl/tpl_main.html");
            $nav_entry = new Template();
            
            $nav_entry->readin("style/".$this->style."/tpl/tpl_nav_entry.html");
            $nav_entry->fillin("ACTIVE", ' class="active"');
            $nav_entry->fillin("NAVID", "link-home");
            $nav_entry->fillin("NAVURL", "#");
            $nav_entry->fillin("NAVTITLE", "Startseite");
            
            $nav_entry->readin("style/".$this->style."/tpl/tpl_nav_entry.html");
            $nav_entry->fillin("ACTIVE", '');
            $nav_entry->fillin("NAVID", "");
            $nav_entry->fillin("NAVURL", "#");
            $nav_entry->fillin("NAVTITLE", "Notenübersicht");
            
            $nav_entry->readin("style/".$this->style."/tpl/tpl_nav_entry.html");
            $nav_entry->fillin("ACTIVE", '');
            $nav_entry->fillin("NAVID", "");
            $nav_entry->fillin("NAVURL", "#");
            $nav_entry->fillin("NAVTITLE", "Noten eintragen");
            
            $nav_entry->readin("style/".$this->style."/tpl/tpl_nav_entry.html");
            $nav_entry->fillin("ACTIVE", '');
            $nav_entry->fillin("NAVID", "");
            $nav_entry->fillin("NAVURL", "#");
            $nav_entry->fillin("NAVTITLE", "Grafen");
            
            $nav_entry->readin("style/".$this->style."/tpl/tpl_nav_entry.html");
            $nav_entry->fillin("ACTIVE", '');
            $nav_entry->fillin("NAVID", "");
            $nav_entry->fillin("NAVURL", "#");
            $nav_entry->fillin("NAVTITLE", "Über das Projekt");
            
        $main_tpl->fillin("NAVIGATION", '<ul>'.$nav_entry->get_template().'</ul>');    
        $this->template->fillin("MAINCONTENT", $main_tpl->get_template());
        
        $this->template->fillin("FOOTER", "Ein GDI2 Projekt");
        
        $pageHandler = new pageHandler();
        $header_tpl_file = "tpl_header"; // Not logged in
        if($pageHandler->checkIfLogin()) {
            $header_tpl_file = "tpl_header_user"; // Logged in
        }

        $header_tpl = new Template();
        $header_tpl->readin("style/". $this->style ."/tpl/". $header_tpl_file .".html");
        $header_tpl->fillin("USERNAME", $pageHandler->getUsername());
        $this->template->fillin("HEADCONTENT", $header_tpl->get_template());

    }
    
    function set_body_content($value) {
        $this->template->fillin("CONTENT", $value);
    }

    function set_userControl_content($login=false, $username=NULL) {
        $header_tpl_file = "tpl_header"; // Not logged in
        if($login) {
            $header_tpl_file = "tpl_header_user"; // Logged in
        }

        $header_tpl = new Template();
        $header_tpl->readin("style/". $this->style ."/tpl/". $header_tpl_file .".html");
        $header_tpl->fillin("USERNAME", $username);
        $this->template->fillin("HEADCONTENT", $header_tpl->get_template());
    }

    function loadAdditionalTemplate($filename, $fillIn) {
        $new_tpl = new Template();
        $new_tpl->readin("style/". $this->style ."/tpl/tpl_". $filename .".html");

        foreach($fillIn as $key => $value) {
            $new_tpl->fillin($key, $value);
        }

        return $new_tpl->get_template();
    }

    function buildResultMessage($msgType, $msgText, $redirect=false, $redirectTo=NULL) {
        $new_tpl = new Template();
        $new_tpl->readin("style/". $this->style ."/tpl/tpl_resultMsg.html");
        $new_tpl->fillin("RESULT_MSG_TYPE", $msgType);

        if($redirect) {
            $redirect_tpl = new Template();
            $redirect_tpl->readin("style/". $this->style ."/tpl/tpl_redirect.html");
            $redirect_tpl->fillin("REDIRECT_HREF", $redirectTo);
            $msgText .= $redirect_tpl->get_template();
        }
        $new_tpl->fillin("RESULT_MSG_TEXT", $msgText);
        return $new_tpl->get_template();
    }

    function get_page() {
        return $this->template->get_template();
    }

    function get_style() {
        return $this->style;
    }
}
?>
