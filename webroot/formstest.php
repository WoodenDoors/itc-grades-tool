<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Marius Rüter
 * Date: 30.01.13
 * Time: 08:39
 * To change this template use File | Settings | File Templates.
 */

require_once '../system/template/page.class.php';
require_once '../system/template/forms.class.php';

$formarr = [
    "METHOD" => "POST",
    "GETARGS" => [
        "login" => "true",
        "muell" => "nochmehrmuell",
    ],
    "ELEMENTS" => [
        [
            "ELEMENT" => "fieldset",
            "TITLE" => "Test",
            "ID" => "loginFieldset",
            "CLASS" => "form-horizontal",
            "SUBELEMENTS" => [
                [
                    "ELEMENT" => "input",
                    "TYPE" => "text",
                    "NAME" => "username",
                    "LABEL" => "Benutzername:",
                    "PLACEHOLDER" => "Benutzername",
                    "REQUIRED" => true,
                    "AUTOFOCUS" => true,
                ],
                [
                    "ELEMENT" => "input",
                    "TYPE" => "password",
                    "NAME" => "pass",
                    "LABEL" => "Passwort:",
                    "PLACEHOLDER" => "Passwort",
                    "REQUIRED" => true,
                ],
                [
                    "ELEMENT" => "formactions",
                    "SUBELEMENTS" => [
                        [
                            "ELEMENT" => "button",
                            "TYPE" => "submit",
                            "NAME" => "loginSubmit",
                            "LABEL" => "Login",
                            "PLACEHOLDER" => "",
                            "REQUIRED" => null,
                        ]
                    ]
                ]
            ]
        ]
    ]
];

$page = new page();
$form = new Form($page);
$form->createForm($formarr);
$page->set_body_content($form->getForm());
echo $page->get_page();

//print_r($formarr);