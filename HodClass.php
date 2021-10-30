<?php
require_once("ConnectionClass.php");
require_once("DepartmentClass.php");

/*
* Created on Sat Oct 30 2021 2:26:09 pm
*
* File Name HodClass.php
* ============================================================
* Program for Hod table CRUD
* ============================================================
*
* Copyright (c) 2021 @Vikrant Pandey
*/

/*
1 private CheckRedundancy(&$hodNumber, &$hodName)
=> have same data :: true
=> same data not exist :: false
=> for checking refresh doubled data entry.

2 public Create($hodNumber, $hodName, $hodDescription)
=> success :: insert_id
=> fail :: false
=>creates hod uses CheckRedundancy to check duplicate data.

3 public GetNextInsertId()
=> returns the last inserted id of table

*/


class Hod
{
    public $connection;
    private $departmentObj = 0;

    function __construct()
    {
        $connectionObj = new ConnectionDb();
        $this->connection = $connectionObj->Connect();
    }


    private function CheckRedundancy(&$hodDepartmentId, &$hodMobile)
    {
        $sql = "select hod_id from hod where hod_department_id = ? or hod_mobile= ? ; ";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("ii", $hodDepartmentId, $hodMobile);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else
            return false;
    }
    public function Create($data)
    {
        $this->departmentObj = new Department();

        if ($this->CheckRedundancy($data[0], $data[3])) {
            return false;
        }

        $sql = "insert into hod values (Null,?,?,?,?,?,?,?,?);";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("ssssssss", ...$data);
        if ($stmt->execute()) {

            if ($this->departmentObj->Update("department_hod_id", $stmt->insert_id, "department_id", $data[0])) {
                return $stmt->insert_id;
            } else
                return false;
        } else
            return false;
    }

    /*
    1-> Return the last inserted id +1     
    */
    public function GetNextInsertId()
    {
        $connection = $this->connection;
        $sql = "select Max(hod_id) from hod ;";
        $result =  $connection->query($sql);

        if ($result->num_rows > 0) {
            return ((int)$result->fetch_assoc()['Max(hod_id)']) + 1;
        } else {
            return false;
        }
    }
}