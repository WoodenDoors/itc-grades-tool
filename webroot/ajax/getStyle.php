<?php
/**
 * @author: mwegmann
 * Date: 17.01.13
 * Time: 12:26
 */
$style = "default";
if (isset($_COOKIE['style'])) {
    $style = $_COOKIE['style'];
}
echo $style;