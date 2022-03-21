<?php

include("../DBM/getConnection.php");

session_start();

class Login
{

    private $traffic_id;
    private $password;
    private $conn;
    private $status;

    function __construct($traffic_id, $password, $status)
    {

        $this->traffic_id = $traffic_id;
        $this->password = $password;
        $this->status = $status;
    }

    private function checkDatabase()
    {

        $connection = new Connection();
        $conn = $connection->getConnection("echallan");
        $encrypted = md5($this->password);

        echo $this->traffic_id;

        $sql = "SELECT COUNT(DISTINCT traffic_id) as count From traffic_logs WHERE traffic_id = '$this->traffic_id' AND password = '$this->password'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_fetch_object($result);

        if ($count->count == 1) {
            return true;
        } else {
            return false;
        }
    }

    function logUser()
    {
        $bool = $this->checkDatabase();
        if ($bool) {
            $_SESSION['session'] = $this->traffic_id;
            header("Location: ./index.php");
            exit();
        } else {

            header("Location: ../Error_Pages/connection_lost.php");
            exit();
        }
    }
}
