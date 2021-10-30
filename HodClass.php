<?php
require_once("ConnectionClass.php");

class Hod
{
    public $connection;

    function __construct()
    {
        $connectionObj = new ConnectionDb();
        $this->connection = $connectionObj->Connect();
    }

    private function CheckRedundancy(&$hodNumber, &$hodName)
    {
        $sql = "select hod_id from hod where hod_number = ? and hod_name= ? ; ";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("is", $hodNumber, $hodName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else
            return false;
    }
    public function Create($hodNumber, $hodName, $hodDescription)
    {

        if ($this->CheckRedundancy($hodNumber, $hodName)) {
            return false;
        }

        $stmt = $this->connection->prepare("insert into hod (hod_number, hod_name , hod_desc) values (?,?,?);");

        $stmt->bind_param("iss", $hodNumber, $hodName, $hodDescription);
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
        $sql = "select Max(hod_id) from hod ;";
        $result =  $connection->query($sql);

        if ($result->num_rows > 0) {
            return ((int)$result->fetch_assoc()['Max(hod_id)']) + 1;
        } else {
            return false;
        }
    }
}