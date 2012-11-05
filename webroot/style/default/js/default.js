/*
 Created on : 05.11.12, 19:49
 Author     : mwegmann
 Description: default script
 */
$(document).ready(function(){

    // Stand-alone Buttons
    $("button#logout").click(function(){
        window.location.href = "logout.php";
    });

    $("button#login").click(function(){
        window.location.href = "login.php";
    });

    $("button#register").click(function(){
        window.location.href = "register.php";
    });

});
