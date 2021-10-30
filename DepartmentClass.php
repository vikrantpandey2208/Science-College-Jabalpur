<?php
require_once("ConnectionClass.php");

class Department
{
    public $connection;

    function __construct()
    {
        $connectionObj = new ConnectionDb();
        $this->connection = $connectionObj->Connect();
    }

    private function CheckRedundancy(&$departmentName, &$departmentDescription)
    {
        $sql = "select department_id from department where department_name = ? and department_desc= ? ; ";
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("ss", $departmentName, $departmentDescription);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else
            return false;
    }

    public function Create($departmentName, $departmentDescription)
    {

        if ($this->CheckRedundancy($departmentName, $departmentDescription)) {
            return false;
        }

        $stmt = $this->connection->prepare("insert into department (department_name , department_desc) values (?,?);");

        $stmt->bind_param("ss", $departmentName, $departmentDescription);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else
            return false;
    }

    /*
    1-> Read full table when $column= * 
        then not need of 2 and 3rd argument
    2-> Read a column where = value
        need all argument but returns only one value
    3-> Read all columns value 
        where = value

    */
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
            $sql .= " from department where {$whereColumn}  = ? ;";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $whereValue);
        } else {
            // select specific columns

            switch ($column) {
                case '*': {
                        $stmt = $connection->prepare("select * from department;");
                        break;
                    }
                case 'all': {
                        $sql = "select * from department where {$whereColumn}  = ? ;";
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("s", $whereValue);
                        break;
                    }
                default: {
                        $sql = "select {$column} from department where {$whereColumn} = ? ;";
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

    /*
    1-> Return the last inserted id +1     
    */
    public function GetNextInsertId()
    {
        $connection = $this->connection;
        $sql = "select Max(department_id) from department ;";
        $result =  $connection->query($sql);

        if ($result->num_rows > 0) {
            return ((int)$result->fetch_assoc()['Max(department_id)']) + 1;
        } else {
            return false;
        }
    }
    /*
    1-> Set the new value to set column 
        where = value    
    */
    public function Update($setColumn, $setValue, $whereColumn, $whereValue)
    {
        $sql = "update department set {$setColumn} = ? where {$whereColumn} = ?;";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ss", $setValue, $whereValue);

        return $stmt->execute();;
    }
}