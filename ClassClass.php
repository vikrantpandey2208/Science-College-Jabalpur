<?php
require_once("ClassConnection.php");
/*
 * Created on Fri Nov 05 2021 8:16:01 pm
 *
 * File Name ClassClass.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */

/*
 1. public Create($hodNumber, $hodName, $hodDescription)
 2. Read
 3. GetNextInsertId


 */

class Classes
{
    public $connection;

    function __construct()
    {
        $connectionObj = new ConnectionDb();
        $this->connection = $connectionObj->Connect();
    }

    public function Read($column, $whereColumn = "", $whereValue = "", $multiColumn = false)
    {
        $connection = $this->connection;
        if ($multiColumn) {

            $sql = "select ";
            foreach ($column as $col) {
                $sql .= $col . ", ";
            }

            $sql = rtrim($sql, ", ");
            $sql .= " from class where {$whereColumn}  = ? ;";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $whereValue);
        } else {
            // select specific columns

            switch ($column) {
                case '*': {
                        $stmt = $connection->prepare("select * from class;");
                        break;
                    }
                case 'all': {
                        $sql = "select * from class where {$whereColumn}  = ? ;";
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("s", $whereValue);
                        break;
                    }
                default: {
                        $sql = "select {$column} from class where {$whereColumn} = ? ;";
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

    public function Create($data)
    {
        if ($this->CheckRedundancy($data[2], $data[3], $data[4])) {
            return false;
        }

        $sql = "insert into class values (Null,?,?,?,?,?,?);";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("iissss", ...$data);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else
            return false;
    }

    private function CheckRedundancy(&$name, &$section, &$year)
    {
        $sql = "select class_id from class
                 where class_name = ? and class_section= ? and class_year = ? ; ";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("ssi", $name, $section, $year);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else
            return false;
    }
    public function GetNextInsertId()
    {
        $connection = $this->connection;
        $sql = "select Max(class_id) from class ;";
        $result =  $connection->query($sql);

        if ($result->num_rows > 0) {
            return ((int)$result->fetch_assoc()['Max(class_id)']) + 1;
        } else {
            return false;
        }
    }
}
