<?php

require_once("ClassConnection.php");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassLevel1
 *
 * @author Vikrant Pandey
 */
class Level1 {

    public $connection;

    function __construct() {
        $connectionObj = new ConnectionDb();
        $this->connection = $connectionObj->Connect();
    }

    public function Create($data) {

//        if ($this->CheckRedundancy($data[0], $data[3])) {
//            return false;
//        }

        $sql = "insert into level1 values (Null,?,?,?,?,?,?,?,?);";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("ssssssss", ...$data);
        if ($stmt->execute()) {

            return $stmt->insert_id;
        } else
            return false;
    }

    public function ReadCustomSql($sql) {
        $connection = $this->connection;

        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function Read($column, $whereColumn = "", $whereValue = "", $multiColumn = false) {
        $connection = $this->connection;
        if ($multiColumn) {

            $sql = "select ";
            foreach ($column as $col) {
                $sql .= $col . ", ";
            }

            $sql = rtrim($sql, ", ");
            $sql .= " from level1 where {$whereColumn}  = ? ;";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $whereValue);
        } else {
            // select specific columns

            switch ($column) {
                case '*': {
                        $stmt = $connection->prepare("select * from level1;");
                        break;
                    }
                case 'all': {
                        $sql = "select * from level1 where {$whereColumn}  = ? ;";
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("s", $whereValue);
                        break;
                    }
                default: {
                        $sql = "select {$column} from level1 where {$whereColumn} = ? ;";
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

}
