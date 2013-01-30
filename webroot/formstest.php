<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Marius Rüter
 * Date: 30.01.13
 * Time: 08:39
 * To change this template use File | Settings | File Templates.
 */

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
            "SUBELEMENTS" => [
                [
                    "ELEMENT" => "input",
                    "TYPE" => "text",
                    "NAME" => "username",
                    "LABEL" => "Benutzername:",
                    "PLACEHOLDER" => "Benutzername",
                    "REQUIRED" => true,
                ],
                [
                    "ELEMENT" => "input",
                    "TYPE" => "text",
                    "NAME" => "pass",
                    "LABEL" => "Passwort:",
                    "PLACEHOLDER" => "Passwort",
                    "REQUIRED" => true,
                ]
            ]
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
];

$form = new Form();
$form->createForm($formarr);
echo $form->getForm();

print_r($formarr);