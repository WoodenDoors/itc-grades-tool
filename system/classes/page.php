<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Die Klasse page handhabt das ausgeben und modifizieren einer Seite
 *
 * @author Marius Rüter
 */
class page {
    var $template;
    
    function setup_page()
    {
        $this->template = new Template();
        $this->template->readin("style/default/tpl/tpl_overall.html");
        $this->template->fillin("STYLESHEET", '<link rel="stylesheet" type="text/css" href="style/default/css/default.css">');
        $this->template->fillin("TITLE", "ITC-Grades-Tool");
        
        $header_tpl = new Template();
        $header_tpl->readin("style/default/tpl/tpl_header.html");
        $header_tpl->fillin("USERNAME", "Kreisverkehr");
        $this->template->fillin("HEADCONTENT", $header_tpl->get_template());
        
        $main_tpl = new Template();
        $main_tpl->readin("style/default/tpl/tpl_main.html");
            $nav_entry = new Template();
            
            $nav_entry->readin("style/default/tpl/tpl_nav_entry.html");
            $nav_entry->fillin("ACTIVE", ' class="active"');
            $nav_entry->fillin("NAVID", "link-home");
            $nav_entry->fillin("NAVURL", "#");
            $nav_entry->fillin("NAVTITLE", "Startseite");
            
            $nav_entry->readin("style/default/tpl/tpl_nav_entry.html");
            $nav_entry->fillin("ACTIVE", '');
            $nav_entry->fillin("NAVID", "");
            $nav_entry->fillin("NAVURL", "#");
            $nav_entry->fillin("NAVTITLE", "Notenübersicht");
            
            $nav_entry->readin("style/default/tpl/tpl_nav_entry.html");
            $nav_entry->fillin("ACTIVE", '');
            $nav_entry->fillin("NAVID", "");
            $nav_entry->fillin("NAVURL", "#");
            $nav_entry->fillin("NAVTITLE", "Noten eintragen");
            
            $nav_entry->readin("style/default/tpl/tpl_nav_entry.html");
            $nav_entry->fillin("ACTIVE", '');
            $nav_entry->fillin("NAVID", "");
            $nav_entry->fillin("NAVURL", "#");
            $nav_entry->fillin("NAVTITLE", "Grafen");
            
            $nav_entry->readin("style/default/tpl/tpl_nav_entry.html");
            $nav_entry->fillin("ACTIVE", '');
            $nav_entry->fillin("NAVID", "");
            $nav_entry->fillin("NAVURL", "#");
            $nav_entry->fillin("NAVTITLE", "Über das Projekt");
            
        $main_tpl->fillin("NAVIGATION", '<ul>'.$nav_entry->get_template().'</ul>');    
        $this->template->fillin("MAINCONTENT", $main_tpl->get_template());
    }
    
    function set_body_content($value)
    {
        $this->template->fillin("CONTENT", $value);
    }
    
    function get_template()
    {
        return $this->template->get_template();
    }
}

?>
