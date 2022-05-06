<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
class PostValues{
    public function __construct(){
        $this->Tables          = new Tables();
    }

    public function getPostValues(){
        $post_check_array = array (
            /**Storage values */
            'add'                   => array('filter' => FILTER_SANITIZE_STRING ),
            'submit'                => array('filter' => FILTER_SANITIZE_STRING ),
            'update'                => array('filter' => FILTER_SANITIZE_STRING ),
            /**Color changer values*/
            'cid'                   => array('filter' => FILTER_VALIDATE_INT ),
            'colorDefault'          => array('filter' => FILTER_SANITIZE_STRING ),
            'colorNew'              => array('filter' => FILTER_SANITIZE_STRING ),
            /**Pagename */
            'p'                     => array('filter' => FILTER_SANITIZE_STRING ),
            /**Delete file */
            'deleted'               => array('filter' => FILTER_VALIDATE_INT ),
            /**global ID value*/
            'id'                    => array( 'filter'=> FILTER_VALIDATE_INT    ),
        );
        $inputs = filter_input_array( INPUT_POST, $post_check_array );
        return $inputs;
    }
}
?>