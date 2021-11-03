<?php
require_once("ClassConnection.php");

/*
 * Created on Wed Nov 03 2021 10:39:05 pm
 *
 * File Name ClassTeacher.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */
/*
 1. public Create($hodNumber, $hodName, $hodDescription)
 2. Read
 3. Update
 4. GetNextInsertId


 */
class Teacher
{
    public $connection;

    function __construct()
    {
        $connectionObj = new ConnectionDb();
        $this->connection = $connectionObj->Connect();
    }

    public function Update($setColumn, $setValue, $whereColumn, $whereValue): bool
    {
        $sql = "update teacher_staff set {$setColumn} = ? where {$whereColumn} = ?;";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ss", $setValue, $whereValue);

        return $stmt->execute();;
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
            $sql .= " from teacher_staff where {$whereColumn}  = ? ;";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $whereValue);
        } else {
            // select specific columns

            switch ($column) {
                case '*': {
                        $stmt = $connection->prepare("select * from teacher_staff;");
                        break;
                    }
                case 'all': {
                        $sql = "select * from teacher_staff where {$whereColumn}  = ? ;";
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("s", $whereValue);
                        break;
                    }
                default: {
                        $sql = "select {$column} from teacher_staff where {$whereColumn} = ? ;";
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
        if ($this->CheckRedundancy($data[0], $data[3])) {
            return false;
        }

        $sql = "insert into teacher_staff values (Null,Null,?,?,?,?,?,?,?,?);";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("iisissss", ...$data);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else
            return false;
    }
    private function CheckRedundancy(&$teacherDepartmentId, &$teacherMobile)
    {
        $sql = "select teacher_staff_id from teacher_staff
                 where teacher_staff_department_id = ? or teacher_staff_mobile= ? ; ";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("ii", $teacherDepartmentId, $teacherMobile);
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
        $sql = "select Max(teacher_staff) from hod ;";
        $result =  $connection->query($sql);

        if ($result->num_rows > 0) {
            return ((int)$result->fetch_assoc()['Max(teacher_staff)']) + 1;
        } else {
            return false;
        }
    }
}