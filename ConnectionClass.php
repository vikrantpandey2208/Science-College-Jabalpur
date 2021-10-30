<?php
class ConnectionDb
{
    function __construct()
    {
    }
    public function Connect()
    {
        $server = "localhost";
        $user = "root";
        $password = "";
        $databaseName = "trs";
        $connection = new mysqli($server, $user, $password, $databaseName);
        if ($connection->connect_error) {
            echo "Connection failed: " . $connection->connect_error;
        } else
            return $connection;
    }
}