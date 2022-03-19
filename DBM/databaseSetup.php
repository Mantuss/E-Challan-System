<?php

class SetupDatabase
{
    private $username;
    private $password;
    private $server;
    private $dbname;

    function __construct($username, $password, $server, $dbname)
    {
        $this->username = $username;
        $this->password = $password;
        $this->server = $server;
        $this->dbname = $dbname;
    }

    function databaseCreate()
    {
        $conn = new mysqli($this->server, $this->username, $this->password);

        if ($conn->connect_error) {
            header("Location: http://localhost/E-Challan/Error_Pages/connection_lost.php");
            exit();
        }

        $sql = "CREATE DATABASE $this->dbname";

        if ($conn->query($sql)) {

            $queries = array(

                "CREATE TABLE traffic_logs (
                    traffic_id varchar(6) NOT NULL,
                    traffic_post varchar(20) NOT NULL,
                    account_status int NOT NULL,
                    password varchar(10) NOT NULL
                );",

                "CREATE TABLE challan (
                    challan_id varchar(10) NOT NULL,
                    license_number varchar(10) NOT NULL,
                    vehicle_number varchar(10) NOT NULL, 
                    user_name varchar(20) NOT NULL,
                    traffic_id varchar(6) NOT NULL,
                    time_stamp TIMESTAMP NOT NULL,
                    date_time date NOT NULL
                );",

                "CREATE TABLE super_admin (
                    admin_id varchar(6) NOT NULL,
                    admin_status int NOT NULL
                );"

            );

            $conn = new mysqli($this->server, $this->username, $this->password, $this->dbname);

            for ($i = 0; $i < sizeof($queries); $i++) {
                $conn->query($queries[$i]);
            }

            header("Location: http://localhost/E-Challan/Login/LoginPanel.php");
            exit();
        } else {

            header("Location: http://localhost/E-Challan/Login/LoginPanel.php");
            exit();
        }

        $conn->close();
    }
}


$setup = new SetupDatabase("root","","localhost","echallan");
$setup->databaseCreate();
