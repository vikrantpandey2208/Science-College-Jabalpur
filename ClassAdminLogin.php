<?php
require_once("ClassConnection.php");
/*
 * Created on Wed Nov 03 2021 4:16:46 pm
 *
 * File Name ClassAdminLogin.php
 * ============================================================
 * Program for perform curd on table admin user
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */

/*
1 public function GetNextInsertId()
=> returns the last inserted id of table
=> on fail returns false

2 public function Create($data)
3 public function Read($column, $whereColumn = "", $whereValue = "", $multiColumn = false)
 */



class AdminLogin
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
        $sql = "select * from admin_user where admin_user_username =? and 
                                admin_user_user_password = ?  ;";

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
            $sql .= " from admin_user where {$whereColumn}  = ? ;";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $whereValue);
        } else {
            // select specific columns

            switch ($column) {
                case '*': {
                        $stmt = $connection->prepare("select * from admin_user;");
                        break;
                    }
                case 'all': {
                        $sql = "select * from admin_user where {$whereColumn}  = ? ;";
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("s", $whereValue);
                        break;
                    }
                default: {
                        $sql = "select {$column} from admin_user where {$whereColumn} = ? ;";
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

        if ($this->CheckRedundancy($data[0])) {
            return false;
        }

        $sql = "insert into admin_user values (Null,?,?,?,?);";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("isss", ...$data);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else
            return false;
    }

    private function CheckRedundancy(&$adminUserTableId)
    {
        $sql = "select admin_user_id from admin_user where admin_user_table_id = ?  ; ";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("i", $adminUserTableId);
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
        $sql = "select Max(admin_user_id) from admin_user ;";
        $result =  $connection->query($sql);

        if ($result->num_rows > 0) {
            return ((int)$result->fetch_assoc()['Max(admin_user_id)']) + 1;
        } else {
            return false;
        }
    }
}
