<?php

require_once("ClassConnection.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassWeekDay
 *
 * @author user
 */
class WeekDay {

    public $connection;

    function __construct() {
        $connectionObj = new ConnectionDb();
        $this->connection = $connectionObj->Connect();
    }

    public function DecodeWeekday($dayId) {
        $dayId = (string) $dayId;       // parsing to string

        $returnString = " ";

        for ($i = 0; $i < strlen($dayId); $i++) {
            $tempResult = $this->Read("weekday_code", "weekday_id", $dayId[$i]);
            $row = $tempResult->fetch_assoc();
            $returnString .= " " . $row['weekday_code'];
        }
        return $returnString;
    }

    public function Read($column, $whereColumn = "", $whereValue = "", $multiColumn = false) {
        $connection = $this->connection;
        if ($multiColumn) {

            $sql = "select ";
            foreach ($column as $col) {
                $sql .= $col . ", ";
            }

            $sql = rtrim($sql, ", ");
            $sql .= " from weekday where {$whereColumn}  = ? ;";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $whereValue);
        } else {
            // select specific columns

            switch ($column) {
                case '*': {
                        $stmt = $connection->prepare("select * from weekday;");
                        break;
                    }
                case 'all': {
                        $sql = "select * from weekday where {$whereColumn}  = ? ;";
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("s", $whereValue);
                        break;
                    }
                default: {
                        $sql = "select {$column} from weekday where {$whereColumn} = ? ;";
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
