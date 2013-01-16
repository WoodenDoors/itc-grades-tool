/*
 Created on : 05.11.12, 19:49
 Author     : mwegmann
 Description: default script
 */

var rotator = $("div#rotator");

var showRotator = function(){
    rotator.css({visibility: "visible", opacity: "1", display: "block"});
}

var hideRotator = function(){
    rotator.fadeTo("fast", 0);
}

$(document).ready(function(){

    // rotator just for the heck of it for now
    // TODO -- might have to disable (doesn't spin in FF and possibly other)
    hideRotator();

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

    $("select#pSemester").change(function(){
        window.location.href = "projects.php?page=add&semester=" + $("select#pSemester").val();
        showRotator();
    });

    function showRotator(){
        rotator.css({visibility: "visible", opacity: "1", display: "block"});
    }

    function hideRotator(){
        rotator.fadeTo("fast", 0);
    }

});
