<?php

include("./Login.php");

if (isset($_POST['submit'])) {

    $login = new Login($_POST['user'], $_POST['pass'], "Traffic");
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
            <form method="post" type="submit">
                <h1 id="loginID">Login</h1>
                <input id="usernameID" type="text" name="user" placeholder="User ID" required>
                <input id="passwordID" type="password" name="pass" placeholder="Password" required>
                <a id="link" href="https://gazani.com">Forgot Password</a>
                <input type="submit" id="signup-btn" name="submit">
            </form>
        </div>
    </div>

    <script src="login.js"></script>

</body>

</html>