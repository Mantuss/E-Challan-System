<?php

include("../DBM/getConnection.php");

class Traffic
{

    private $conn;

    function __construct()
    {
        $object = new Connection();
        $this->conn = $object->getConnection("echallan");
    }

    function createChallan($challan_id, $liscence, $vehicle_no, $username, $traffic_id)
    {
        $sql = "INSERT INTO  challan (`challan_id`, `license_number`, `vehicle_number`, `user_name`, `traffic_id`, `charge`) VALUES ('$challan_id','$liscence','$vehicle_no','$username','$traffic_id','10000')";
        $this->conn->query($sql);
    }

    function getRecents($traffic_id)
    {
        $sql = "SELECT * FROM challan WHERE traffic_id = '$traffic_id'"; 
        $result = $this->conn->query($sql);
    }

}
