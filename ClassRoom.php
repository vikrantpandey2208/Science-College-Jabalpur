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