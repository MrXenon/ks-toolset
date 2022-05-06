<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
require_once KS_TOOLSET_PLUGIN_MODEL_DIR  . '/classTables.class.php';
class StoreData{
    public function __construct(){
        $this->Tables          = new Tables();
    }
    // Define tables
    private function TablePrefix(){return $this->Tables->TablePrefix();}
    private function UpdateTable(){return $this->Tables->UpdateTable();}
    private function ShortcodesTable(){return $this->Tables->ShortcodesTable();}
    private function ChoiceTable(){return $this->Tables->ChoiceTable();}
    private function AuthorTable(){return $this->Tables->AuthorTable();}
    private function ColorChangerTable(){return $this->Tables->ColorChangerTable();}

    public function getGetValues(){
        //Define the check for params
        $get_check_array = array (
            //Action
            'action' => array('filter' => FILTER_SANITIZE_STRING ),

            'p' => array('filter' => FILTER_SANITIZE_STRING ),

            //Id of current row
            'id' => array('filter' => FILTER_VALIDATE_INT ));


        //Get filtered input:
        $inputs = filter_input_array( INPUT_GET, $get_check_array );

        // RTS
        return $inputs;

    }

    public function handleGetAction( $get_array ){
        $action = '';

        switch($get_array['action']){
            case 'update':
                // Indicate current action is update if id provided
                if ( !is_null($get_array['id']) ){
                    $action = $get_array['action'];
                }
                break;

            case 'delete':
                // Delete current id if provided
                if ( !is_null($get_array['id']) ){
                    $this->delete_page($get_array);
                    $this->delete($get_array);
                }
                $action = 'delete';
                break;

            default:
                // Oops
                    break;
                   
        }
       
        return $action;
    }

    // Store the data in our DB
    public function save($input_array){
            try {
                $array_fields = array( 'colorDefault', 'colorNew');
                $data_array = array();
    
                foreach( $array_fields as $field){
    
                    if (!isset($input_array[$field])){
                        throw new Exception(__("$field is mandatory for save."));
                    }
                    $data_array[] = $input_array[$field];
                }

                global $wpdb;

                $wpdb->query($wpdb->prepare("INSERT INTO `". $this->ColorChangerTable()
                    ."` ( `color_default`, `color_new`)".
                    " VALUES ( '%s', '%s');",
                    $input_array['colorDefault'],
                    $input_array['colorNew']) );

                if ( !empty($wpdb->last_error) ){
                    return FALSE;
                }

            } catch (Exception $exc) {
                echo '<p class="alert alert-warning">'. $exc->getMessage() .'</p>';
            }
        return TRUE;
    }

    // Update the data in our DB
    public function update($input_array){
        try {
            $array_fields = array( 'id','colorDefault', 'colorNew');
            $data_array = array();

            foreach( $array_fields as $field){

                if (!isset($input_array[$field])){
                    throw new Exception(__("$field is mandatory for update."));
                }
                $data_array[] = $input_array[$field];
            }
            global $wpdb;

            $wpdb->query($wpdb->prepare("UPDATE ".$this->ColorChangerTable()."
            SET `color_default` = '%s', `color_new` = '%s' ".
                "WHERE `".$this->ColorChangerTable()."`.`cid` =%d;",
                $input_array['colorDefault'],
                $input_array['colorNew'], 
                $input_array['id']) );

        } catch (Exception $exc) {
            $this->last_error = $exc->getMessage();
            return FALSE;
        }
        return TRUE;
    }
    // Delete the data in our DB
    public function delete($input_array){
        try {

            if (!isset($input_array['id']) ) throw new Exception(__("Missing mandatory fields") );
            global $wpdb;

            $wpdb->delete( $this->ColorChangerTable(),
                array( 'cid' => $input_array['id'] ),
                array( '%d' ) );

            if ( !empty($wpdb->last_error) ){
                throw new Exception( $wpdb->last_error);
            }
        } catch (Exception $exc) {

        return TRUE;
        }
        return FALSE;
    }
}
?>