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
class TimeSlot {

    public $connection;

    function __construct() {
        $connectionObj = new ConnectionDb();
        $this->connection = $connectionObj->Connect();
    }

    public function DecodeSlot($slotId, $selection, $periodName = null) {
        if (isset($periodName)) {
            $tempResult = $this->Read("timeslot_name", "timeslot_id", $slotId);
            $row = $tempResult->fetch_assoc();
            return $row['timeslot_name'];
        }
        // selection = 0 for start and 1 for end
        switch ($selection) {
            case 0: {
                    $tempResult = $this->Read("timeslot_start", "timeslot_id", $slotId);
                    $row = $tempResult->fetch_assoc();
                    return $row['timeslot_start'];
                    break;
                }
            case 1: {
                    $tempResult = $this->Read("timeslot_end", "timeslot_id", $slotId);
                    $row = $tempResult->fetch_assoc();
                    return $row['timeslot_end'];
                    break;
                }
        }
        
    }

    public function Read($column, $whereColumn = "", $whereValue = "", $multiColumn = false) {
        $connection = $this->connection;
        if ($multiColumn) {

            $sql = "select ";
            foreach ($column as $col) {
                $sql .= $col . ", ";
            }

            $sql = rtrim($sql, ", ");
            $sql .= " from timeslot where {$whereColumn}  = ? ;";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $whereValue);
        } else {
            // select specific columns

            switch ($column) {
                case '*': {
                        $stmt = $connection->prepare("select * from timeslot;");
                        break;
                    }
                case 'all': {
                        $sql = "select * from timeslot where {$whereColumn}  = ? ;";
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("s", $whereValue);
                        break;
                    }
                default: {
                        $sql = "select {$column} from timeslot where {$whereColumn} = ? ;";
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
