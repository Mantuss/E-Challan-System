<?php

include("./Login.php");

if (isset($_POST['submit'])) {

    $login = new Login($_POST['user'], $_POST['pass'], "Traffic");
    $login->logUser();
}

?>

<html>

<head>
    <title> Login Page </title>
</head>

<body>
    <form method="POST">

        <label for="user"> User Id :</label>
        <input type="text" class="user" name="user"> &nbsp;&nbsp;

        <label for="pass"> Password :</label>
        <input type="password" class="pass" name="pass"> &nbsp;&nbsp;

        <input type="submit" class="submit" name="submit">

    </form>
</body>

</html>