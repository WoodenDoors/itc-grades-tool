<?php
/**
 * Die Klasse page handhabt das ausgeben und modifizieren einer Seite
 *
 * @author Marius Rüter
 */
require_once 'stringparser.class.php';
require_once 'stringparser_bbcode.class.php';
require_once 'template.class.php';

class page {
    var $template;
    var $style = "default";

    function __construct() {
        $this->setup_page();
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
    
    function get_page() {
        return $this->template->get_template();
    }
}
?>
