<?php
require_once("ClassConnection.php");
/*
 * Created on Fri Nov 05 2021 3:52:02 pm
 *
 * File Name ClassTeacherLogin.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */

class TeacherLogin
{
    public $connection;

    function __construct()
    {
        $connectionObj = new ConnectionDb();
        $this->connection = $connectionObj->Connect();
    }

    public function ReadForLogin($userName, $password, &$result)
    {
        $connection = $this->connection;
        $sql = "select * from staff_login where staff_login_username =? and 
        staff_login_user_password = ?  ;";

        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $userName, $password);

        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function Create($data)
    {

        if ($this->CheckRedundancy($data[0])) {
            return false;
        }

        $sql = "insert into staff_login values (Null,?,?,?,?);";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("isss", ...$data);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else
            return false;
    }

    private function CheckRedundancy(&$loginTeacherId)
    {
        $sql = "select staff_login_id from staff_login where staff_login_teacher_id = ?  ; ";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("i", $loginTeacherId);
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
        $sql = "select Max(staff_login_id) from staff_login ;";
        $result =  $connection->query($sql);

        if ($result->num_rows > 0) {
            return ((int)$result->fetch_assoc()['Max(staff_login_id)']) + 1;
        } else {
            return false;
        }
    }
}