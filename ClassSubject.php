<?php
require_once("ClassConnection.php");

/*
 * Created on Fri Nov 05 2021 8:51:26 pm
 *
 * File Name ClassSubject.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */

class Subject
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
            $sql .= " from subject where {$whereColumn}  = ? ;";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $whereValue);
        } else {
            // select specific columns

            switch ($column) {
                case '*': {
                        $stmt = $connection->prepare("select * from subject;");
                        break;
                    }
                case 'all': {
                        $sql = "select * from subject where {$whereColumn}  = ? ;";
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("s", $whereValue);
                        break;
                    }
                default: {
                        $sql = "select {$column} from subject where {$whereColumn} = ? ;";
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
        if ($this->CheckRedundancy($data[0], $data[1])) {
            return false;
        }

        $sql = "insert into subject values (Null,?,?,?,?);";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("isss", ...$data);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else
            return false;
    }

    private function CheckRedundancy(&$name, &$paper)
    {
        $sql = "select subject_id from subject
                 where subject_name = ? and subject_paper= ?  ; ";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("si", $name, $paper);
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
        $sql = "select Max(subject_id) from subject ;";
        $result =  $connection->query($sql);

        if ($result->num_rows > 0) {
            return ((int)$result->fetch_assoc()['Max(subject_id)']) + 1;
        } else {
            return false;
        }
    }
}