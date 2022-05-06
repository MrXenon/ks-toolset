<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
require_once KS_TOOLSET_PLUGIN_MODEL_DIR  . '/classTables.class.php';
class ComponentCheck{
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

}
?>