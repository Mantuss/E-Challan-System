<?php

include("./admin_functions.php");

error_reporting(0);

if (isset($_POST['create'])) {

    $admin = new Admin();
    $bool = $admin->createAccount($_POST['user'], $_POST['pass'], $_POST['traffic_post']);

    if ($bool) {
        $text = "Account Created";
    } else {
        $text = "Something went wrong";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin Page</title>

</head>

<body>

    <div style="margin-left:200px;">

        <form method="post" style="border: 1px solid black;width:250px;height:300px;padding-left:50px;">

            <h3> Create Account </h3>

            <div class="form-control">
                Traffic Id: <br>
                <input type="text" id="name" placeholder="Traffic Id" name="user" required />
            </div>
            <br>

            <div class="form-control">
                Password: <br>
                <input type="password" id="pass" placeholder="Password" name="pass" required /><br>
            </div>
            <br>

            <div class="form-control">
                Traffic Post: <br>
                <input type="text" id="pass" placeholder="Traffic Post" name="traffic_post" required /><br>
            </div>

            <br>
            <input type="submit" value="Create Account" class="submit-btn" name="create" />

            <div style="color:<?php if ($text == "Account Created") { ?> green; <?php } else { ?> red; <?php } ?>">
                <?php
                echo $text;
                ?>
            </div>

        </form>
</div>




    <a href="./logout.php"> Logout </a>

    <script src="./index.js"> </script>

</body>

</html>