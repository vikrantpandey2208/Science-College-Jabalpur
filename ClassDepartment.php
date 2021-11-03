<?php
require_once("ClassConnection.php");

/*
* Created on Sat Oct 30 2021 2:32:18 pm
*
* File Name DepartmentClass.php
* ============================================================
* Program for .....
* ============================================================
*
* Copyright (c) 2021 @Vikrant Pandey
*/
/*

1 construct => create connection to db

2 private CheckRedundancy(&$departmentName, &$departmentDescription)
=> have same data :: true
=> same data not exist :: false
=> for checking refresh doubled data entry.

3 public Create($departmentName, $departmentDescription)
=> success :: insert_id
=> fail :: false
=>creates hod uses CheckRedundancy to check duplicate data.

4 public Read($column, $whereColumn = "", $whereValue = "", $multiColumn = false)
=> fail :: false
=> success :: query resultset

=>if param multicolumn == true selects columns which are in array in param column
where column = value
=> param column = '*'' select whole table
=> param column = "all" select row with
where column = value
=> column = "column_name"
select the column_name with
where column = value

5 public GetNextInsertId()
=> returns the last inserted id of table

6 public Update($setColumn, $setValue, $whereColumn, $whereValue)
=> success :: true
=> fail :: false
=> updates the setColumn with setValue.
where column = value
*/


class Department
{
    public $connection;

    function __construct()
    {
        $connectionObj = new ConnectionDb();
        $this->connection = $connectionObj->Connect();
    }

    private function CheckRedundancy(&$departmentName, &$departmentDescription)
    {
        $sql = "select department_id from department where department_name = ? and department_desc= ? ; ";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("ss", $departmentName, $departmentDescription);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else
            return false;
    }

    public function Create($departmentName, $departmentDescription)
    {

        if ($this->CheckRedundancy($departmentName, $departmentDescription)) {
            return false;
        }

        $stmt = $this->connection->prepare("insert into department (department_name , department_desc) values (?,?);");

        $stmt->bind_param("ss", $departmentName, $departmentDescription);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else
            return false;
    }

    public function Read($column, $whereColumn = "", $whereValue = "", $multiColumn = false)
    {
        $connection = $this->connection;
        if ($multiColumn) {
            // select multiple columns
            // $numColumn = count($column);

            $sql = "select ";
            foreach ($column as $col) {
                $sql .= $col . ", ";
            }

            $sql = rtrim($sql, ", ");
            $sql .= " from department where {$whereColumn}  = ? ;";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $whereValue);
        } else {
            // select specific columns

            switch ($column) {
                case '*': {
                        $stmt = $connection->prepare("select * from department;");
                        break;
                    }
                case 'all': {
                        $sql = "select * from department where {$whereColumn}  = ? ;";
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("s", $whereValue);
                        break;
                    }
                default: {
                        $sql = "select {$column} from department where {$whereColumn} = ? ;";
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("s", $whereValue);
                        break;
                    }
            }
        }
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    /*
    1-> Return the last inserted id +1     
    */
    public function GetNextInsertId()
    {
        $connection = $this->connection;
        $sql = "select Max(department_id) from department ;";
        $result =  $connection->query($sql);

        if ($result->num_rows > 0) {
            return ((int)$result->fetch_assoc()['Max(department_id)']) + 1;
        } else {
            return false;
        }
    }
    /*
    1-> Set the new value to set column 
        where = value    
    */
    public function Update($setColumn, $setValue, $whereColumn, $whereValue): bool
    {
        $sql = "update department set {$setColumn} = ? where {$whereColumn} = ?;";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ss", $setValue, $whereValue);

        return $stmt->execute();;
    }
}