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

    function setupDatabase()
    {
        $conn = new mysqli($this->server, $this->username, $this->password);

        if ($conn->connect_error) {
            header("Location: http://localhost/E-Challan/Error_Pages/connection_lost.php");
            exit();
        }

        $sql = "DROP DATABASE $this->dbname";

        if ($conn->query($sql)) {

            echo "Database Deleted";
            
        } else {

            echo "Something went wrong";
        }
    }
}


    if(isset($_POST['submit'])){

        $dbname = $_POST['dbname'];
        $newConn = new SetupDatabase("root", "", "localhost", $dbname);
        $newConn->setupDatabase();
    }

?>

<html>

<title> Database Drop </title>

    <body align="center">

        <form method="POST">
            <br><br>
            <h3> Database Name: </h3> 
            <input type="text" name="dbname"> 
            <br> <br>
            <input type="submit" name="submit">
        </form>

    </body>

</html>