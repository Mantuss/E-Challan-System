<?php

class SetupDatabase
{
    private $username;
    private $password;
    private $server;
    private $dbname;
    private $mysqli;

    function __construct($username, $password, $server, $dbname)
    {
        $this->username = $username;
        $this->password = $password;
        $this->server = $server;
        $this->dbname = $dbname;
        $this->mysqli = new mysqli($this->server, $this->username, $this->password);
    }

    function ifExist()
    {

        if ($this->mysqli->connect_error) {

            header("Location: http://localhost/E-Challan/Error_Pages/connection_lost.php");
            exit();
        }

        $database = $this->mysqli->query("SHOW DATABASES LIKE '$this->dbname'");
        $row = $database->fetch_assoc();

        if (!empty($row)) {

            return true;
        } 

        else {

            return false;
        }

    }
    function databaseCreate($url)
    {
        
        if($this->ifExist()){

            header("Location: http://localhost/E-Challan/user_admin/Login/Login.php");
            exit();
                    
        }

        if ($this->mysqli->query("CREATE DATABASE $this->dbname")) {

            $conn = new mysqli($this->server, $this->username, $this->password, $this->dbname);
            $queries = array(

                "CREATE TABLE cms_traffic(
                            traffic_id varchar(6) NOT NULL,
                            account_status int NOT NULL,
                            traffic_pass varchar(50) NOT NULL,
                            firstname varchar(50) NOT NULL,
                            lastname varchar(50) NOT NULL,
                            email varchar(50) NOT NULL,
                            number varchar(10),
                            address varchar(50),
                            state varchar(50),
                            zip_code int(5),
                            indicator int(10) NOT NULL
                        );",

                "CREATE TABLE cms_challan(
                            challan_id varchar(10) NOT NULL,
                            license_number varchar(10) NOT NULL,
                            vehicle_number varchar(10) NOT NULL, 
                            user_name varchar(20) NOT NULL,
                            traffic_id varchar(6) NOT NULL,
                            time_stamp TIMESTAMP NOT NULL,
                            date_time date NOT NULL,
                            charge int NOT NULL,
                            cause int(10) NOT NULL
                        );",

                "CREATE TABLE cms_requests(
                            request_id int(11) NOT NULL PRIMARY KEY,
                            email varchar(50) NOT NULL,
                            status int(10) NOT NULL
                        );",

                "CREATE TABLE cms_images(
                            image_id int(11) NOT NULL PRIMARY KEY,
                            images varchar(50) NOT NULL
                        );",

                "CREATE TABLE cms_admin (
                            admin_id varchar(20) NOT NULL,
                            admin_pass varchar(10) NOT NULL,
                            admin_status int NOT NULL
                        );",

                "INSERT INTO cms_admin(admin_id, admin_pass, admin_status) VALUES ('admin_traffic','admin_pass', 1);",

            );

            foreach ($queries as $query) {
                $conn->query($query);
            }

            header("Location: $url");
            exit();

        } else {
            header("Location: http://localhost/E-Challan/Error_Pages/connection_lost.php");
            exit();
        }
    }
}


// $setup = new SetupDatabase("root", "", "localhost", "echall");
// $setup->databaseCreate("http://localhost/E-Challan/user_admin/Login/Login.php");
