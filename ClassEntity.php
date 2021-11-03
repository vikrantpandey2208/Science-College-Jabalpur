<?php
require_once("ClassConnection.php");

/*
* Created on Sat Oct 30 2021 2:31:10 pm
*
* File Name EntityClass.php
* ============================================================
* Script for Hod table CRUD
* ============================================================
*
* Copyright (c) 2021 @Vikrant Pandey
*/

/*
1 public Read($whereColumn = "", $whereValue = "")
=> fail :: false
=> success :: query resultset
=> selects * from entity where column = value

*/

class Entity
{
    public $connection;

    function __construct()
    {
        $connectionObj = new ConnectionDb();
        $this->connection = $connectionObj->Connect();
    }

    public function Read($whereColumn = "", $whereValue = "")
    {
        $sql = "select * from entity";
        $stmt = $this->connection->prepare($sql);
        // $stmt->bind_param("s", $whereValue);

        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }
}