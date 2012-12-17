<?php
/**
 * Die Klasse page handhabt das Ausgeben und modifizieren einer Seite
 *
 * @author Marius Rüter
 */
require_once 'stringparser.class.php';
require_once 'stringparser_bbcode.class.php';
require_once 'template.class.php';
require_once '../system/handlers/pageHandler.class.php';


class page {
    private $template;
    private $style = "default";
    private $home_link = "index.php";
    private $config;
    private $page_title;

    // setup page on default
    function __construct($constructPage=TRUE) {
        $this->validateconfig();
        if(!isset($_GET['PageMode'])) $_GET['PageMode'] = "";
        if(isset($_COOKIE['style'])) $this->style = $_COOKIE['style'];
        if(isset($_GET['style'])) {
            setcookie('style', $_GET['style']);
            $this->style = $_GET['style'];
        }
        if($constructPage) {
            $this->setup_page();
        }
    }
    
    function setup_page() {
        $this->config = simplexml_load_file('style/'.$this->style.'/config.xml');
        $this->template = new Template();
        $this->template->readin("style/".$this->style."/tpl/tpl_overall".$_GET['PageMode'].".html");

        //Stylesheets einfügen
        foreach($this->config->css as $csssheet) {
            $this->template->fillin("STYLESHEET", '<link rel="stylesheet" type="text/css" href="style/'.$this->style.'/css/'.$csssheet.'">'."\n{STYLESHEET}");
        }
        $this->template->fillin("STYLESHEET",'');

        //JavaScript einfügen
        foreach($this->config->js as $jsfile) {
            $this->template->fillin("JAVASCRIPT", '<script src="style/'.$this->style.'/js/'.$jsfile.'" type="text/javascript"></script>'."\n{JAVASCRIPT}");
        }
        $this->template->fillin("JAVASCRIPT",'');

        $this->template->fillin("TITLE", "ITC-Grades-Tool");
        $this->template->fillin("ROTATOR",'<img src="style/'.$this->style.'/img/loader.gif"/>');
        $this->template->fillin("HOME_LINK", $this->home_link);


        $main_tpl = new Template();
        $main_tpl->readin("style/".$this->style."/tpl/tpl_main.html");
        $this->template->fillin("MAINCONTENT", $main_tpl->get_template());

        $nav_entry = new Template();
        $site = simplexml_load_file("site.xml");
        foreach($site->nav->navelement as $navelement) {
            $nav_entry->readin("style/".$this->style."/tpl/tpl_nav_entry.html");
            $nav_entry->fillin("NAVID", $navelement->id);
            $nav_entry->fillin("NAVURL", $navelement->url);
            $nav_entry->fillin("NAVTITLE", " ".$navelement->title);
            $nav_entry->fillin("ICON", $navelement->icon);
            if(preg_match('/\S*'.$navelement->url.'\S*/i', $_SERVER['SCRIPT_FILENAME'])) {
                $nav_entry->fillin('ACTIVE', ' class="active"');
                $this->page_title = $navelement->title;
            }
            else {
                $nav_entry->fillin("ACTIVE", '');
            }

        }
        $this->template->fillin("NAVIGATION", $nav_entry->get_template());
        $this->template->fillin("PAGE_TITLE", $this->page_title);
        
        $this->template->fillin("FOOTER", "Ein GDI2 Projekt");
        
        $pageHandler = new pageHandler();
        $this->set_userControl_content($pageHandler->checkIfLogin(), $pageHandler->getUsername(), $pageHandler->getVorname(), $pageHandler->getNachname());

    }
    
    function set_body_content($value) {
        $this->template->fillin("CONTENT", $value);
    }

    function set_userControl_content($login=false, $username=NULL, $firstname=NULL, $lastname=NULL) {
        $header_tpl_file = "tpl_header"; // Not logged in
        if($login) {
            $header_tpl_file = "tpl_header_user"; // Logged in
        }

        $header_tpl = new Template();
        $header_tpl->readin("style/". $this->style ."/tpl/". $header_tpl_file .".html");
        $header_tpl->fillin("USERNAME", $username);
        $header_tpl->fillin("FIRSTNAME", $firstname);
        $header_tpl->fillin("LASTNAME", $lastname);
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

    private function validateconfig() {
        libxml_use_internal_errors(true);
        $xml = new DOMDocument();
        $xml->load('style/'.$this->style.'/config.xml');

        if (!$xml->schemaValidate('../system/template/config.xsd')) {
            $this->style = "default";
        }
    }
}
?>
