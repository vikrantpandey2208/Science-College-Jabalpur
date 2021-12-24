<?php
require_once("ClassConnection.php");

class Room
{
    public $connection;

    function __construct()
    {
        $connectionObj = new ConnectionDb();
        $this->connection = $connectionObj->Connect();
    }

    public function DecodeRoom($roomId) {
        $tempResult = $this->Read("room_number", "room_id", $roomId);
        $row = $tempResult->fetch_assoc();
        return $row['room_number'];
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
            $sql .= " from room where {$whereColumn}  = ? ;";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $whereValue);
        } else {
            // select specific columns

            switch ($column) {
                case '*': {
                        $stmt = $connection->prepare("select * from room;");
                        break;
                    }
                case 'free': {
                        $stmt = $connection->prepare("select * from room where room_alloted = 0;");
                        break;
                    }
                case 'all': {
                        $sql = "select * from room where {$whereColumn}  = ? ;";
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("s", $whereValue);
                        break;
                    }
                default: {
                        $sql = "select {$column} from room where {$whereColumn} = ? ;";
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

    private function CheckRedundancy(&$roomNumber, &$roomName)
    {
        $sql = "select room_id from room where room_number = ? and room_name= ? ; ";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("is", $roomNumber, $roomName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else
            return false;
    }

    public function Create($roomNumber, $roomName, $roomDescription)
    {

        if ($this->CheckRedundancy($roomNumber, $roomName)) {
            return false;
        }

        $stmt = $this->connection->prepare("insert into room (room_number, room_name , room_desc) values (?,?,?);");

        $stmt->bind_param("iss", $roomNumber, $roomName, $roomDescription);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else
            return false;
    }

    /*
    1-> Return the last inserted id +1     
    */
    public function GetNextInsertId()
    {
        $connection = $this->connection;
        $sql = "select Max(room_id) from room ;";
        $result =  $connection->query($sql);

        if ($result->num_rows > 0) {
            return ((int)$result->fetch_assoc()['Max(room_id)']) + 1;
        } else {
            return false;
        }
    }
}