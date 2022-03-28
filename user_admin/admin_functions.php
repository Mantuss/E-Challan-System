<?php

include("../DBM/getConnection.php");

class Admin
{
    private $conn;

    function __construct()
    {
        $object = new Connection();
        $this->conn = $object->getConnection("echallan");
    }

    private function checkExisting($id)
    {

        $sql = "SELECT COUNT(DISTINCT traffic_id) as count From traffic_logs WHERE traffic_id = '$id'";
        $result = $this->conn->query($sql);
        $count = mysqli_fetch_object($result);

        if ($count->count == 1) {
            return false;
        } else {
            return true;
        }
    }

    function createAccount($traffic_id, $password, $post)
    {

        $bool = $this->checkExisting($traffic_id);
        if ($bool) {

            $encrypted = md5($password);
            $sql = "INSERT INTO traffic_logs(`traffic_id`, `traffic_post`, `account_status`, `traffic_pass`) VALUES ('$traffic_id','$post','1','$encrypted')";
            $this->conn->query($sql);
            return true;
        } else {
            return false;
        }
    }

    function disableAccount($traffic_id)
    {
        $bool = $this->checkExisting($traffic_id);

        if ($bool) {
            $sql = "UPDATE traffic_logs SET account_status= '0' WHERE traffic_id= '$traffic_id' ";
            $this->conn->query($sql);
            return true;
        } else {
            return false;
        }
    }

    function changePassword($traffic_id, $password)
    {

        $bool = $this->checkExisting($traffic_id);

        if ($bool) {
            $encrypted = md5($password);
            $sql = "UPDATE traffic_logs SET traffic_pass= '$password' WHERE traffic_id= '$traffic_id'";
            $this->conn->query($sql);
            return true;
        } else {

            return false;

        }
    }
    

    function getChallanHistory(){

        $sql = "SELECT * FROM challan WHERE traffic_id != '' "; 
        $result = $this->conn->query($sql);

    }
}
