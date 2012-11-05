/*
 Created on : 05.11.12, 19:49
 Author     : mwegmann
 Description: default script
 */

$(document).ready(function(){
    // Einfach nur so, weil ich es kann!
    $("button#logout").click(function(){
        $("article#content").slideUp();
        $("article#content").fadeIn();
    });
});
