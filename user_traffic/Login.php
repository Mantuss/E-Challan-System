<?php

include("../DBM/getConnection.php");

session_start();

class Login
{
    private $traffic_id;
    private $password;
    private $conn;

    function __construct($traffic_id, $password)
    {
        $object = new Connection();
        $this->conn = $object->getConnection("echallan");
        $this->password = $password;
        $this->traffic_id = $traffic_id;
    }

    private function checkDatabase()
    {
        $encrypted = md5($this->password);
        $sql = "SELECT COUNT(DISTINCT traffic_id) as count From traffic_logs WHERE traffic_id = '$this->traffic_id' AND traffic_pass = '$encrypted' AND account_status = '1' ";
        $result = mysqli_query($this->conn, $sql);
        $count = mysqli_fetch_object($result);

        if ($count->count == 1) {
            return true;
        } 
        else {
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
            ?> <h1> <?php echo "Hello" ; ?> </h1> <?php
        }
    }
}


if (isset($_POST['submit'])) {

    $login = new Login($_POST['user'], $_POST['pass']);
    $login->logUser();

}

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="login.css">

<body>
    <div class="split left">
        <div class="centered">
            <img src="../images/E-Challan.svg" alt="App Logo">
        </div>
    </div>

    <div class="split right">
        <div class="centered">
            <form method="post" type="submit">
                <h1 id="loginID">Login</h1>
                <input id="usernameID" type="text" name="user" placeholder="User ID" required>
                <input id="passwordID" type="password" name="pass" placeholder="Password" required>
                <a id="link" href="">Forgot Password</a>
                <input type="submit" id="signup-btn" name="submit">
            </form>
        </div>
    </div>

    <script src="login.js"></script>

</body>

</html>