<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
// Define required files
require_once KS_TOOLSET_PLUGIN_MODEL_DIR . '/classComponentCheck.class.php';
require_once KS_TOOLSET_PLUGIN_MODEL_DIR . '/classLists.class.php';
require_once KS_TOOLSET_PLUGIN_MODEL_DIR . '/classStoreData.class.php';
require_once KS_TOOLSET_PLUGIN_MODEL_DIR . '/classPostValues.class.php';
require_once KS_TOOLSET_PLUGIN_MODEL_DIR . '/classTables.class.php';

class classBuilder{
    // Define attributes
    private $colid                  =   '';
    private $colorDefault           =   '';
    private $colorNew               =   '';
    // Define shortcode variables
    private $shortId                =   '';
    private $shortName              =   '';
    private $shortDesc              =   '';
    // Define author variables      
    private $authId                 =   '';
    private $authName               =   '';
    private $authMail               =   '';
    private $authSite               =   '';
    //Define update log
    private $uid                    =   '';
    private $uvers                  =   '';
    private $udesc                  =   '';
    private $ulist                  =   '';
    private $ufdesc                 =   '';
    // Define choice
    private $cid                    =   '';
    private $choice                 =   '';
    private $choiceVar              =   '';

    // Define classess
    public function __construct(){
        $this->Tables          = new Tables();
        $this->PostValues      = new PostValues();
        $this->Check           = new ComponentCheck();
        $this->Lists           = new Lists();
        $this->StoreData       = new StoreData();
    }

    // Define tables
    private function TablePrefix(){return $this->Tables->TablePrefix();}
    private function UpdateTable(){return $this->Tables->UpdateTable();}
    private function ShortcodesTable(){return $this->Tables->ShortcodesTable();}
    private function ChoiceTable(){return $this->Tables->ChoiceTable();}
    private function AuthorTable(){return $this->Tables->AuthorTable();}
    private function ColorChangerTable(){return $this->Tables->ColorChangerTable();}
    //Define post values
    public function getPostValues(){return $this->PostValues->getPostValues();}

    // Define all storage data
    public function getGetValues(){return $this->StoreData->getGetValues();}
    public function handleGetAction($get_array){return $this->StoreData->handleGetAction($get_array);}
    public function save($input_array){return $this->StoreData->save($input_array);}
    public function update($input_array){return $this->StoreData->update($input_array);}
    public function delete($input_array){return $this->StoreData->delete($input_array);}

    // Define all lists
    public function getKSbuilderList(){return $this->Lists->getKSbuilderList();}
    public function getKSShortcodes(){return $this->Lists->getKSShortcodes();}
    public function getKSAuthor(){return $this->Lists->getKSAuthor();}
    public function getKSUpdateLog(){return $this->Lists->getKSUpdateLog();}
    public function getKSChangeLog(){return $this->Lists->getKSChangeLog();}
    public function getColorAmount(){return $this->Lists->getColorAmount();}
    public function getColors(){return $this->Lists->getColors();}

    /* #region Set Shortcodes */
    public function setShortcodeId( $shortId ){
        if ( is_int(intval($shortId) )){
            $this->shortId = trim($shortId);
        }
    }
    public function setShortcodeName( $shortName ){
        if ( is_string( $shortName )){
            $this->shortName = trim($shortName);
        }
    }
    public function setShortcodeDesc( $shortDesc ){
        if ( is_string( $shortDesc )){
            $this->shortDesc = trim($shortDesc);
        }
    }
/* #endregion */
/* #region Get Shortcodes */
    public function getShortId(){
        return $this->shortId;
    }
    public function getShortName(){
        return $this->shortName;
    }
    public function getShortDesc(){
        return $this->shortDesc;
    }
/* #region Set Author */
    public function setAuthorId( $authId ){
        if ( is_int(intval( $authId ))){
            $this->authId = trim($authId);
        }
    }
    public function setAuthorName( $authName ){
        if ( is_string( $authName )){
            $this->authName = trim($authName);
        }
    }
    public function setAuthorMail( $authMail ){
        if ( is_string( $authMail )){
            $this->authMail = trim($authMail);
        }
    }
    public function setAuthorSite( $authSite ){
        if ( is_string( $authSite )){
            $this->authSite = trim($authSite);
        }
    }
/* #endregion */
/* #region Get Author */
    public function GetAuthorId(){
        return $this->authId;
    }
    public function getAuthorName(){
        return $this->authName;
    }
    public function getAuthorMail(){
        return $this->authMail;
    }
    public function getAuthorSite(){
        return $this->authSite;
    }
    /* #endregion */

    /* #region Set update log */
    public function setUpdateId( $uid ){
        if ( is_int(intval( $uid ))){
            $this->uid = trim($uid);
        }
    }
    public function setUpdateVersion( $uvers ){
        if ( is_string( $uvers )){
            $this->uvers = trim($uvers);
        }
    }
    public function setUpdateDesc( $udesc ){
        if ( is_string( $udesc )){
            $this->udesc = trim($udesc);
        }
    }
    public function setUpdateList( $ulist ){
        if ( is_string( $ulist )){
            $this->ulist = trim($ulist);
        }
    }
    public function setUpdateFdesc( $ufdesc ){
        if ( is_string( $ufdesc )){
            $this->ufdesc = trim($ufdesc);
        }
    }
    /* #endregion */
    /* #region get update log */
    public function getUpdateId(){
        return $this->uid;
    }
    public function getUpdateVersion(){
        return $this->uvers;
    }
    public function getUpdateDesc(){
        return $this->udesc;
    }
    public function getUpdateList(){
        return $this->ulist;
    }
    public function getUpdateFdesc(){
        return $this->ufdesc;
    }
    /* #endregion */
    /*#region set choice */
    public function setChoiceId( $cid ){
    if ( is_int(intval( $cid ))){
        $this->cid = trim($cid);
    }
    }
    public function setChoice( $choice ){
    if ( is_string( $choice )){
        $this->choice = trim($choice);
    }
    }
    public function setChoiceVar( $choiceVar ){
    if ( is_string( $choiceVar )){
        $this->choiceVar = trim($choiceVar);
    }
    }
    /* #endregion*/
    /*#region get choice */
    public function getChoiceId(){
    return $this->cid;
    }
    public function getChoice(){
    return $this->choice;
    }
    public function getChoiceVar(){
    return $this->choiceVar;
    }
    /* #endregion*/
    /*#region set color */
    public function setColorId($colid){
        if ( is_int(intval( $colid ))){
            $this->colid = trim($colid);
        }
    }

    public function setColorDefault($colorDefault){
        if ( is_string( $colorDefault )){
            $this->colorDefault = trim($colorDefault);
        }
    }

    public function setColorNew($colorNew){
        if ( is_string( $colorNew )){
            $this->colorNew = trim($colorNew);
        }
    }
    /* #endregion*/
    /*#region get Color */
    public function getColorId(){
        return $this->colid;
    }

    public function getColorDefault(){
        return $this->colorDefault;
    }

    public function getColorNew(){
        return $this->colorNew;
    }
    /* #endregion*/
}
?>