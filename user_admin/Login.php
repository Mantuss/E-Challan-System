<?php

include("../DBM/getConnection.php");

session_start();

class Login
{
    private $traffic_id;
    private $password;

    function __construct($traffic_id, $password)
    {
        $this->traffic_id = $traffic_id;
        $this->password = $password;
    }

    private function checkDatabase()
    {
        $connection = new Connection();
        $conn = $connection->getConnection("echallan");
        $encrypted = md5($this->password);

        $sql = "SELECT COUNT(DISTINCT admin_id) as count From super_admin WHERE admin_id = '$this->traffic_id' AND admin_pass = '$this->password' AND admin_status = 1";
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
            header("Location: ../user_admin/index.php");
            exit();
        } else {
            echo "Inavlid Login";
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
            <img src="echallanLogo.png" alt="App Logo">
        </div>
    </div>

    <div class="split right">
        <div class="centered">
            <form type="submit" method="post">
                <h1 id="loginID">Login</h1>
                <input id="usernameID" type="text" name="user" placeholder="User ID">
                <input id="passwordID" type="password" name="pass" placeholder="Password">
                <input type="submit" id="signup-btn" name="submit">
            </form>
        </div>
    </div>

    <script src="login.js"></script>

</body>

</html>