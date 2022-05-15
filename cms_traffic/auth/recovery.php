<?php


include("../../cms_dbm/getCon.php");

session_start();
$error_status = "";
$color_status = "";


class Request
{

    private $conn;

    function __construct()
    {
        $object = new Connection();
        $this->conn = $object->getConnection("cms");
    }

    function checkExisting($email)
    {

        $sql = "SELECT COUNT(DISTINCT email) as count From cms_requests WHERE email = '$email'";
        $result = $this->conn->query($sql);
        $count = mysqli_fetch_object($result);
        if ($count->count == 1) {
            return true;
        } else {
            return false;
        }
    }

    function sendRequest($email, $username)
    {

        $sql = "INSERT INTO cms_requests(`email`, `user_name`, `status`) VALUES ('$email','$username','2')";
        if ($this->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    function checkAccount($email)
    {
        $sql = "SELECT COUNT(DISTINCT email) as count From cms_traffic WHERE email = '$email'";
        $result = $this->conn->query($sql);
        $count = mysqli_fetch_object($result);
        if ($count->count == 1) {
            return true;
        } else {
            return false;
        }
    }
}

$request = new Request();

if (isset($_POST['send'])) {

    if ($request->checkAccount($_POST['email'])) {
        $check = $request->checkExisting($_POST['email']);

        if (!$check) {

            $bool = $request->sendRequest($_POST['email'], $_POST['first_name'] . " " . $_POST['last_name']);

            if ($bool) {
                $error_status = "Success your request has been sent";
                $color_status = "success";
            } else {

                $error_status = "Oops! Something went wrong";
                $color_status = "danger";
            }
        } else {
            $error_status = "Request already in process";
            $color_status = "danger";
        }
    } else {
        $error_status = "Traffic account does not exist";
        $color_status = "warning";
    }
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Register &mdash; Stisla</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="../../dist/assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../dist/assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../../dist/assets/modules/jquery-selectric/selectric.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="../../dist/assets/css/style.css">
    <link rel="stylesheet" href="../../dist/assets/css/components.css">
    <!-- Start GA -->

    <style>
        body {
            background-color: #F0F8FF;
        }
    </style>


</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2 mt-5">

                        <div class="card card-primary">
                            <div class="card-header d-flex justify-content-center"><img src="../../dist/assets/img/avatar/E-challan.png" width="200" height="80"></div>
                            <div class="card-body">
                                <?php
                                if (!empty($error_status)) {
                                ?>
                                    <div class="alert alert-<?php echo $color_status; ?> alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            <?php echo  $error_status; ?>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <form method="POST">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="first_name">First Name</label>
                                            <input id="first_name" type="text" class="form-control" name="first_name" autofocus>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="last_name">Last Name</label>
                                            <input id="last_name" type="text" class="form-control" name="last_name">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email">
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" name="send" class="btn btn-primary btn-lg btn-block">
                                            Send Request
                                        </button>
                                    </div>
                                    <div class="card-header d-flex justify-content-center"><a href="http://localhost/cms/cms_traffic/auth/login.php"> Back to Login </a></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="../../dist/assets/modules/jquery.min.js"></script>
    <script src="../../dist/assets/modules/popper.js"></script>
    <script src="../../dist/assets/modules/tooltip.js"></script>
    <script src="../../dist/assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../dist.assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="../../dist/assets/modules/moment.min.js"></script>
    <script src="../../dist/assets/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="../../dist/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
    <script src="../../dist/assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="../../dist/assets/js/page/auth-register.js"></script>

    <!-- Template JS File -->
    <script src="../../dist/assets/js/scripts.js"></script>
    <script src="../../dist/assets/js/custom.js"></script>
</body>

</html>