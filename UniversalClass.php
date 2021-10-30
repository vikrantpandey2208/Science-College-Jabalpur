<?php
/*
 * Created on Sat Oct 30 2021 3:07:53 pm
 *
 * File Name UniversalClass.php
 * ============================================================
 * Program for Some function used universally
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */
/*

1 public CheckFormSet($data)  - $data of array type
=> if all member are set :: true
=> else false

*/

class Universal
{
    public function CheckFormSet($data)
    {
        $count = count($data);
        for ($i = 0; $i < $count; $i++) {
            if ($data[$i] === "")
                return false;
        }
        return true;
    }
}