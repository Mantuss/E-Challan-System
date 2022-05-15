<?php

session_start();

if(!$_SESSION['admin']){

    header("Location: ../auth/login.php");

}

require("../mailgun/Exception.php");
require("../mailgun/PHPMailer.php");
require("../mailgun/POP3.php");
require("../mailgun/SMTP.php");
include "../../cms_dbm/getCon.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class RequestRecovery
{

    private $conn;

    function __construct()
    {

        $object = new Connection();
        $this->conn = $object->getConnection("cms");
    }

    function getAccounts($sql)
    {

        $result = $this->conn->query($sql);
        return $result;
    }

    function passwordGenerator($chars)
    {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, $chars);
    }

    function removeRequest($email)
    {

        $sql = "DELETE FROM `cms_requests` WHERE email = '$email'";
        $this->conn->query($sql);
    }

    function changePassword($encrypted, $email)
    {

        $sql = "UPDATE `cms_traffic` SET `traffic_pass`='$encrypted' WHERE email = '$email'";
        $this->conn->query($sql);
    }

    function sendMail($indi, $email, $template, $new_pass)
    {

        if ($indi == "success") {

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.mailgun.org';
                $mail->SMTPAuth   =  true;
                $mail->Username   = 'otp@amsystem.codes';
                $mail->Password   = '8a801b07a93c183f930b212b2f718fcf-0677517f-c4783eaa';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
                $mail->setFrom('otp@amsystem.codes', 'E-Challan');
                $mail->addAddress($email);
                $mail->addAddress($email);
                $mail->isHTML(true);
                $messageFile = $template;
                $message = file_get_contents($messageFile);
                $message = str_replace("%email%", $email, $message);
                $message = str_replace("%password%", $new_pass, $message);               //Set email format to HTML
                $mail->Subject = 'Your Password Request Has Been Approved!';
                $mail->MsgHTML($message);
                $mail->AltBody = 'Your password reset request has been declined.';
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        } else {

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.mailgun.org';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'otp@amsystem.codes';
                $mail->Password   = '8a801b07a93c183f930b212b2f718fcf-0677517f-c4783eaa';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
                $mail->setFrom('otp@amsystem.codes', 'E-Challan');
                $mail->addAddress($email);
                $mail->addAddress($email);
                $mail->isHTML(true);
                $messageFile = $template;
                $message = file_get_contents($messageFile);
                $mail->Subject = 'Your Password Request Has Been Declined';
                $mail->MsgHTML($message);
                $mail->AltBody = 'Your password reset request has been declined.';
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }


    function getRequests($sql)
    {

        $result = $this->conn->query($sql);
        return $result;
    }


    function countRows($sql)
    {

        $result = $this->conn->query($sql);
        return $result;
    }

    function getComplains($sql)
    {
        $result = $this->conn->query($sql);
        return $result;
    }
}


if (isset($_POST['accept'])) {

    $email = $_POST['accept'];
    $send = new RequestRecovery();
    $new_pass = $send->passwordGenerator(6);
    $encrypted = md5($new_pass);
    $send->changePassword($encrypted, $email);
    $send->removeRequest($email);
    $bool = $send->sendMail("success", $email, "../template/accepted.html", $new_pass);

    if ($bool) {

        $error_status = "Operation Completed";
        $color_status = "success";
    } else {
        $error_status = "Oops! Something went wrong";
        $color_status = "danger";
    }
}


if (isset($_POST['decline'])) {

    $email = $_POST['decline'];
    $send = new RequestRecovery();
    $send->removeRequest($email);
    $bool = $send->sendMail("decline", $email, "../template/declined.html", "");

    if ($bool) {

        $error_status = "Operation Completed";
        $color_status = "success";
    } else {
        $error_status = "Something went wrong";
        $color_status = "danger";
    }
}


$inbox = new RequestRecovery();

$searched = "";

if(isset($_POST['searched'])){
    $searched = $_POST['search'];

}





?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title> Recovery Request &mdash; Admin</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="../../dist/assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../dist/assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="../../dist/assets/css/style.css">
    <link rel="stylesheet" href="../../dist/assets/css/components.css">
    <style>
        body {
            background-color: #F0F8FF;
            ;
        }
    </style>

</head>

<body class="layout-3">
    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="index.html" class="navbar-brand sidebar-gone-hide"> E-challan </a>
                <form class="form-inline ml-auto">

                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="../../dist/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, <?php if (!empty($_SESSION['admin'])) {
                                                                            echo $_SESSION['admin'];
                                                                        } ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="../auth/logout.php" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <nav class="navbar navbar-secondary navbar-expand-lg">
                <div class="container">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_admin/screens/cms_dash.php" class="nav-link"><i class="fas fa-home"></i><span> Dashboard </span></a>
                        </li>
                        <li class="nav-item active">
                            <a href="http://localhost/cms/cms_admin/screens/cms_inbox.php" class="nav-link"><i class="fas fa-inbox"></i><span> Requests </span></a>
                        </li>
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_admin/screens/cms_history.php" class="nav-link"><i class="fas fa-history"></i><span> History </span></a>
                        </li>
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_admin/screens/cms_accounts.php" class="nav-link"><i class="fas fa-users"></i><span> Manage Accounts </span></a>
                        </li>
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_admin/screens/cms_licence.php" class="nav-link"><i class="fas fa-id-card"></i><span> Licence Suspended </span></a>
                        </li>
                    </ul>
                </div>
            </nav>


            <div class="main-content">
                <div class="row">
                    <div class="col-12">
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
                        <div class="card">
                            <div class="card-header">
                                <h4>  </h4>
                                <div class="card-header-form">
                                    <form method="POST">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button type="submit" name="searched" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <form method="POST">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Email</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>

                                            <?php

                                            if(empty($searched)){
                                                $result = $inbox->getRequests("SELECT * FROM cms_requests INNER JOIN cms_traffic ON cms_requests.email = cms_traffic.email");
                                            }
                                            else{
                                                $result = $inbox->getRequests("SELECT * FROM cms_requests INNER JOIN cms_traffic ON cms_requests.email = cms_traffic.email WHERE traffic_id = '$searched'");
                                            }
                                            

                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $row['email']; ?>
                                                    </td>
                                                    <td>
                                                        <img alt="image" src="../../dist/assets/img/avatar/avatar-1.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Wildan Ahdian">
                                                    </td>
                                                    <td> <?php echo $row['firstname'] . " " . $row['lastname']; ?> </td>
                                                    <td>
                                                        <div class="badge badge-<?php if ($row['account_status'] == 1) {
                                                                                    echo 'success';
                                                                                } else {
                                                                                    echo "danger";
                                                                                } ?>"> <?php if ($row['account_status'] == 1) {
                                                                                        echo 'Active';
                                                                                    } else {
                                                                                        echo "Disabled";
                                                                                    } ?> </div>
                                                    </td>
                                                    <td> <button type="submit" name="accept" class="btn btn-icon btn-success" value="<?php echo $row['email']; ?>"><i class="fas fa-check"></i></button>
                                                        <button type="submit" name="decline" class="btn btn-icon btn-danger" value="<?php echo $row['email']; ?>"><i class="fas fa-times"></i></button>
                                                    </td>
                                                </tr>
                                            <?php
                                            }

                                            ?>
                                        </table>
                                    </form>
                                    <?php

                                    $result = $inbox->countRows("SELECT COUNT(request_id) as count FROM cms_requests WHERE request_id != ''");
                                    $count = mysqli_fetch_object($result);
                                    if ($count->count == 0) {
                                    ?>
                                        <div class="card-body">
                                            <div class="empty-state" data-height="400">
                                                <div class="empty-state-icon">
                                                    <i class="fas fa-question"></i>
                                                </div>
                                                <h2>We couldn't find any Requests</h2>
                                                <p class="lead">
                                                    Sorry we can't find any data, to get rid of this message, make at least 1 entry.
                                                </p>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- General JS Scripts -->
            <script src="../../dist/assets/modules/jquery.min.js"></script>
            <script src="../../dist/assets/modules/popper.js"></script>
            <script src="../../dist/assets/modules/tooltip.js"></script>
            <script src="../../dist/assets/modules/bootstrap/js/bootstrap.min.js"></script>
            <script src="../../dist/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
            <script src="../../dist/assets/modules/moment.min.js"></script>
            <script src="../../dist/assets/js/stisla.js"></script>

            <!-- JS Libraies -->

            <!-- Page Specific JS File -->

            <!-- Template JS File -->
            <script src="../../dist/assets/js/scripts.js"></script>
            <script src="../../dist/assets/js/custom.js"></script>

            <script src="assets/modules/jquery.min.js"></script>
            <script src="assets/modules/popper.js"></script>
            <script src="assets/modules/tooltip.js"></script>
            <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
            <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
            <script src="assets/modules/moment.min.js"></script>
            <script src="assets/js/stisla.js"></script>

            <!-- JS Libraies -->
            <script src="../../dist/assets/modules/simple-weather/jquery.simpleWeather.min.js"></script>
            <script src="../../dist/assets/modules/chart.min.js"></script>
            <script src="../../dist/assets/modules/jqvmap/dist/jquery.vmap.min.js"></script>
            <script src="../../dist/assets/modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
            <script src="../../dist/assets/modules/summernote/summernote-bs4.js"></script>
            <script src="../../dist/assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

            <!-- Page Specific JS File -->
            <script src="../../dist/assets/js/page/index-0.js"></script>

            <!-- Template JS File -->
            <script src="../../dist/assets/js/scripts.js"></script>
            <script src="../../dist/assets/js/custom.js"></script>
</body>

</html>