<?php
require_once('ClassLevel1.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassPrintLevel1
 *
 * @author user
 */


class ClassPrintLevel1 {

    public function GetNumberAndClasses(&$classInfo) {
        $level1Obj = new Level1();
        $result = $level1Obj->ReadCustomSql("select Distinct level1_class_id from level1");
        $classInfo = $result->fetch_all();

        return count($classInfo);
    }

}
