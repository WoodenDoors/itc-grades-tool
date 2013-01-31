<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Marius Rüter
 * Date: 24.01.13
 * Time: 14:30
 * To change this template use File | Settings | File Templates.
 */
require_once 'stringparser.class.php';
require_once 'template.class.php';
require_once 'page.class.php';

class Form
{
    private $tplPath;
    private $form;
    private $page;
    function __construct($pPage)
    {
        $this->page = $pPage;
        $this->tplPath = 'style/'.$this->page->get_style().'/tpl/forms/';

        $this->form = new Template();
        $this->form->readin($this->tplPath."tpl_form_head.html");
        $this->form->fillin("ACTION", $_SERVER["SCRIPT_NAME"]."{ARGS}");
    }

    function createForm($args) {
        $this->form->fillin("METHOD", $args["METHOD"]);

        //Parameter der URL zusammenfügen
        foreach($args["GETARGS"] as $getargsType => $getargsValue) {
            $getargs[] = $getargsType . '=' . $getargsValue;
        }
        $this->form->fillin("ARGS", "?".implode("&", $getargs));

        //Form zusammenstellen
        foreach($args["ELEMENTS"] as $elementArgs) {
            $this->createSubElement($elementArgs);
        }
        $this->form->fillin("CONTENT", "");
    }

    private function createFieldset($args) {
        $this->form->fillin("CONTENT", file_get_contents($this->tplPath."tpl_form_fieldset.html")."{NEXTCONTENT}");
        $this->form->fillin("TITLE", $args["TITLE"]);
        $this->form->fillin("ID", $args["ID"]);
        foreach($args["SUBELEMENTS"] as $elementArgs) {
            $this->createSubElement($elementArgs);
        }
        $this->form->fillin("CONTENT", "");
        $this->form->fillin("NEXTCONTENT", "{CONTENT}");
    }

    private function createFormActions($args) {
        $this->form->fillin("CONTENT", file_get_contents($this->tplPath."tpl_form_formactions.html")."{NEXTCONTENT}");
        foreach($args["SUBELEMENTS"] as $elementArgs) {
            $this->createSubElement($elementArgs);
        }
        $this->form->fillin("CONTENT", "");
        $this->form->fillin("NEXTCONTENT", "{CONTENT}");
    }

    private function createElement($args) {
        $this->form->fillin("CONTENT", file_get_contents($this->tplPath.'tpl_form_'.$args["ELEMENT"].'.html')."{CONTENT}");
        $this->form->fillin("TYPE", $args["TYPE"]);
        $this->form->fillin("NAME", $args["NAME"]);
        $this->form->fillin("LABEL", $args["LABEL"]);
        $this->form->fillin("PLACEHOLDER", $args["PLACEHOLDER"]);
    }

    private function createSubElement($args) {
        switch($args["ELEMENT"]) {
            case "fieldset":
                $this->createFieldset($args);
                break;
            case "formactions":
                $this->createFormActions($args);
                break;
            default:
                $this->createElement($args);
        }
    }

    function getForm() {
        return $this->form->get_template();
    }

}
