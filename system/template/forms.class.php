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

    /**
     * Konstruktor
     *
     * Konstruktor benötigt ein page-Objekt zu Designunterscheidung. Die Formaction wird automatisch auf die ausgeführe PHP-Datei gesetzt.
     * Get-Parameter können in dem FormArray angegeben werden.
     *
     * @param   page    Benötigt für Designunterscheidung
     *
     * @see     createForm(), getForm()
     */
    function __construct($pPage)
    {
        $this->page = $pPage;
        $this->tplPath = 'style/' . $this->page->get_style() . '/tpl/forms/';

        $this->form = new Template();
        $this->form->readin($this->tplPath . "tpl_form_head.html");
        $this->form->fillin("ACTION", $_SERVER["SCRIPT_NAME"] . "{ARGS}");
    }

    /**
     * Erstellt das Formular anhand des übergebenen Arrays.
     *
     * Das Formular wird entsprechend dem übergebenen Array erstellt und intern gespeichert.
     * Für das ausgeben des Arrays steht eine eigene Methode bereit.
     *
     * @param   Array Übergebenes Array. Struktur siehe formtest.php
     * @see     getForm()
     */
    function createForm($args)
    {
        $this->form->fillin("METHOD", $args["METHOD"]);

        //Parameter der URL zusammenfügen
        foreach ($args["GETARGS"] as $getargsType => $getargsValue) {
            $getargs[] = $getargsType . '=' . $getargsValue;
        }
        $this->form->fillin("ARGS", "?" . implode("&", $getargs));

        //Form zusammenstellen
        foreach ($args["ELEMENTS"] as $elementArgs) {
            $this->createSubElement($elementArgs);
        }
        $this->form->fillin("CONTENT", "");
    }

    private function createFieldset($args)
    {
        $this->loadFile("fieldset", true);
        $this->fillinArgs($args, [
            "TITLE",
            "ID"
        ]);
        foreach ($args["SUBELEMENTS"] as $elementArgs) {
            $this->createSubElement($elementArgs);
        }
        $this->form->fillin("CONTENT", "");
        $this->form->fillin("NEXTCONTENT", "{CONTENT}");
    }

    private function createFormActions($args)
    {
        $this->loadFile("formactions", true);
        foreach ($args["SUBELEMENTS"] as $elementArgs) {
            $this->createSubElement($elementArgs);
        }
        $this->form->fillin("CONTENT", "");
        $this->form->fillin("NEXTCONTENT", "{CONTENT}");
    }

    private function createElement($args)
    {
        $this->loadFile($args["ELEMENT"]);
        $this->fillinArgs($args, [
            "TYPE",
            "NAME",
            "LABEL",
            "PLACEHOLDER",
            "VALUE"
        ]);
        $this->processBools($args);
    }

    private function processBools($args)
    {
        $bools = ["REQUIRED" => "required", "AUTOFOCUS" => "autofocus"];
        foreach($bools as $bool => $tag) {
            if (isset($args[$bool])) {
                if ($args[$bool]) {
                    $this->form->fillin("EXT", " " . $tag . "{EXT}");
                }
            }
        }
        $this->form->fillin("EXT", "");
    }

    private function createSubElement($args)
    {
        switch ($args["ELEMENT"]) {
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

    private function loadFile($type, $subelements = false)
    {
        if ($subelements) {
            $this->form->fillin("CONTENT", file_get_contents($this->tplPath . 'tpl_form_' . $type . '.html') . "{NEXTCONTENT}");
        } else {
            $this->form->fillin("CONTENT", file_get_contents($this->tplPath . 'tpl_form_' . $type . '.html') . "{CONTENT}");
        }
    }

    private function fillinArgs($args, $keys)
    {
        foreach($keys as $key) {
            if(isset($args[$key])){
                $this->form->fillin($key, $args[$key]);
            } else {
                $this->form->fillin($key, "");
            }
        }
    }

    /**
     * Holt das fertige Formular als String
     * @return String   Das fertige Formular
     */
    function getForm()
    {
        return $this->form->get_template();
    }

}
