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
        $this->template->fillin("STYLESHEET", '<link rel="stylesheet" type="text/css" href="css/default.css">');
        $this->template->fillin("TITLE", "ITC-Grades-Tool");
        
        $header_tpl = new Template();
        $header_tpl->readin("style/default/tpl_header.html");
        $this->template->fillin("HEADCONTENT", $header_tpl->get_template());
        $this->template->fillin("USERNAME", "Kreisverkehr");
        
    }
    
    function set_body_content($value)
    {
        $this->template->fillin("MAINCONTENT", $value);
    }
    
    function get_template()
    {
        return $this->template->get_template();
    }
}

?>
