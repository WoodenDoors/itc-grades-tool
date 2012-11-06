/*
 Created on : 05.11.12, 19:49
 Author     : mwegmann
 Description: default script
 */
$(document).ready(function(){

    // rotator just for the heck of it for now
    // TODO -- might have to disable (doesn't spin in FF and possibly other)

    var rotator = $("div#rotator");
    hideRotator();

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


    function showRotator(){
        rotator.css({visibility: "visible", opacity: "1", display: "block"});
    }

    function hideRotator(){
        rotator.fadeTo("fast", 0);
    }

});
