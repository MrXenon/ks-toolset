<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
include KS_TOOLSET_PLUGIN_MODEL_DIR . "/classBuilder.class.php";

$builder = new classBuilder();

if ($builder->getColorAmount() < 1) {}else{
    $colors = $builder->getColors();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
function colorReplace(findHexColor, replaceWith) {
    function rgb2hex(rgb) {
    if (/^#[0-9A-F]{6}$/i.test(rgb)) return rgb;
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
    }
    $('*').map(function(i, el) {

    var styles = window.getComputedStyle(el);

    Object.keys(styles).reduce(function(acc, k) {
        var name = styles[k];
        var value = styles.getPropertyValue(name);
        if (value !== null && name.indexOf("color") >= 0) {

        if (value.indexOf("rgb(") >= 0 && rgb2hex(value) === findHexColor) {

            $(el).css(name, replaceWith);
        }
        }
    });
    });
}
<?php foreach($colors as $obj){echo'colorReplace("'.$obj->getColorDefault().'", "'.$obj->getColorNew().'");'; }?>
</script>
<?php } ?>