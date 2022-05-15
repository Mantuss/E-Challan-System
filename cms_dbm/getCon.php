<?php

class Connection
{
    function getConnection($dbname)
    {
        $conn = new mysqli("localhost","root","", $dbname);
        return $conn;
    }
}

?>