<?php

include("./Login.php");

if (isset($_POST['submit'])) {

    $login = new Login($_POST['user'], $_POST['pass'], "Traffic");
    $login->logUser();
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Super Admin Login</title>
    <link rel="stylesheet" href="./style.css" />
</head>

<body>
    <div class="image-container">
        <img src="../images/E-Challan.svg" alt="logo or some illustration" height="550" width="700" />
    </div>
    <div class="login-form">
        <form class="items" method="post">
            <input class="input" type="text" name="user" placeholder="Email or UserId">
            <input class="input" type="password" name="pass" placeholder="Password">
            <input class="button" type="submit" name="submit">
        </form>
    </div>

</body>

</html>