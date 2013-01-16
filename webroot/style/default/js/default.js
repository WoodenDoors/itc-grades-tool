/*
 Created on : 05.11.12, 19:49
 Author     : mwegmann
 Description: default script
 */

var rotator;
var showRotator;
var hideRotator;

$(document).ready(function(){
    rotator = $("div#rotator");

    showRotator = function(){
        rotator.css({visibility: "visible", opacity: "1", display: "block"});
    }

     hideRotator = function(){
        rotator.fadeTo("fast", 0);
    }

    // Pflichtfelder mit * markieren
    $("form input[required]")
        .after('<span class="required">*</span>');

    // Stand-alone Buttons
    $("button#settings").click(function(){
        window.location.href = "settings.php";
        showRotator();
    });

    $("button#logout").click(function(){
        window.location.href = "logout.php";
        showRotator();
    });

    $("button#login").click(function(){
        window.location.href = "login.php";
        showRotator();
    });

    $("button#register").click(function(){
        window.location.href = "register.php";
        showRotator();
    });

    $("select#semester").change(function(){
        window.location.href = "addGrades.php?semester=" + $("select#semester").val();
        showRotator();
    });

    $("select#style").change(function(){
        window.location.href = "?style=" + $("select#style").val();
        showRotator();
    });

    $("select#pSemester").change(function(){
        window.location.href = "projects.php?page=add&semester=" + $("select#pSemester").val();
        showRotator();
    });

    hideRotator();
});
