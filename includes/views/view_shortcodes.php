<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */

add_shortcode('ks_change_color','changeColor');

function changeColor($atts, $content = NULL){
include KS_TOOLSET_PLUGIN_INCLUDES_VIEWS_DIR . '/KsChangeColor.php';
}