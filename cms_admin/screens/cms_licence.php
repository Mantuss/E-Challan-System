<?php

session_start();

if(!$_SESSION['admin']){

    header("Location: ../auth/login.php");

}

$active_status = "";
$active_status_color = "";

require("../../cms_admin/mailgun/Exception.php");
require("../../cms_admin/mailgun/PHPMailer.php");
require("../../cms_admin/mailgun/POP3.php");
require("../../cms_admin/mailgun/SMTP.php");
include "../../cms_dbm/getCon.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Licence
{

    private $conn;

    function __construct()
    {
        $object = new Connection();
        $this->conn = $object->getConnection("cms");
    }

    private function checkAccount($email, $id)
    {
        $sql = "SELECT COUNT(traffic_id) as count From cms_traffic WHERE traffic_id = '$id' OR  email = '$email' ";
        $result = $this->conn->query($sql);
        $count = mysqli_fetch_object($result);

        if ($count->count == 1) {
            return false;
        } else {
            return true;
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

    function sendMail($indi, $email, $template, $id, $pass)
    {

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
            $message = str_replace("%id%", $id, $message);
            $message = str_replace("%password%", $pass, $message);               //Set email format to HTML
            $mail->Subject = 'New User Credentials';
            $mail->MsgHTML($message);
            $mail->AltBody = 'Your password reset request has been declined.';
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function getNameTraffic()
    {
        $id = $_SESSION['islogged'];
        $sql = "SELECT firstname, lastname FROM cms_traffic WHERE traffic_id = '$id'";
        $result = $this->conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    function getAnalyticsData($sql, $index)
    {
        $result = $this->conn->query($sql);
        $count = mysqli_fetch_assoc($result);
        return $count[$index];
    }

    function suspendAccount($license, $indi)
    {

        $sql = "UPDATE `cms_challan` SET `isSuspended`='$indi' WHERE license_number='$license'";
        if ($this->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }


    function createAccount($email, $first, $last, $id, $pass)
    {
        $encrypted = md5($pass);
        $bool = $this->checkAccount($email, $id);
        if ($bool) {
            $sql = "INSERT INTO `cms_traffic`(`traffic_id`, `account_status`, `traffic_pass`, `firstname`, `lastname`, `email`) VALUES ('$id','1','$encrypted','$first','$last','$email')";
            if ($this->conn->query($sql)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

$licence = new Licence();

$error_status = "";
$description = "";
$color_status = "";


$searched = "";

if (isset($_POST['search'])) {

    $searched = $_POST['searched'];
}


if (isset($_POST["suspend"])) {

    $bool = $licence->suspendAccount($_POST["suspend"], 1);

    if ($bool) {

        $active_status = "Operation Complete";
        $active_status_color = "success";
    } else {

        $active_status = "Oops! Something went wrong";
        $active_status_color = "danger";
    }
}

if(isset($_POST['active'])){

    $bool = $licence->suspendAccount($_POST["active"], 0);

    if ($bool) {

        $active_status = "Operation Complete";
        $active_status_color = "success";
    } else {

        $active_status = "Oops! Something went wrong";
        $active_status_color = "danger";
    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title> Manage Licence &mdash; Traffic </title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="../../dist/assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../dist/assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../dist/assets/modules/izitoast/css/iziToast.min.css">
    

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="../../dist/assets/css/style.css">
    <link rel="stylesheet" href="../../dist/assets/css/components.css">
    <style>
        body {
            background-color: #F0F8FF;
        }
    </style>

</head>

<body class="layout-3">
    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="index.html" class="navbar-brand sidebar-gone-hide"> E-Challan </a>
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
                    <ul class="navbar-nav pl-2">
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_admin/screens/cms_dash.php" class="nav-link"><i class="fas fa-home"></i><span> Dashboard </span></a>
                        </li>
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_admin/screens/cms_inbox.php" class="nav-link"><i class="fas fa-inbox"></i><span> Requests </span></a>
                        </li>
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_admin/screens/cms_history.php" class="nav-link"><i class="fas fa-history"></i><span> History </span></a>
                        </li>
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_admin/screens/cms_accounts.php" class="nav-link"><i class="fas fa-users"></i><span> Manage Accounts </span></a>
                        </li>
                        <li class="nav-item active">
                            <a href="http://localhost/cms/cms_admin/screens/cms_licence.php" class="nav-link"><i class="fas fa-id-card"></i><span> Licence Suspended </span></a>
                        </li>
                    </ul>
                </div>
            </nav>

    

            <div class="main-content">
                <div class="row">
                    <div class="col-12">
                        <?php
                        if (!empty($active_status)) {
                        ?>
                            <div class="alert alert-<?php echo $active_status_color; ?> alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    <?php echo  $active_status; ?>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="card">

                            <div class="card-header">
                                <h4>  Search License </h4>
                                <div class="card-header-form">
                                    <form method="POST">
                                        <div class="input-group">
                                            <input type="text" name="searched" class="form-control" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button name="search" type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <form method="POST">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tr>
                                                <th> Licence No </th>
                                                <th> Vehicle No </th>
                                                <th> Image </th>
                                                <th> Full Name </th>
                                                <th> Challan's </th>
                                                <th> Status </th>
                                                <th> Action </th>
                                            </tr>

                                            <?php

                                            if (!empty($searched)) {
                                                $result = $licence->getRequests("SELECT DISTINCT license_number FROM cms_challan WHERE license_number ='$searched'");
                                            } else {
                                                $result = $licence->getRequests("SELECT DISTINCT license_number FROM cms_challan");
                                            }
                                            while ($row = mysqli_fetch_assoc($result)) {

                                                $license = $row['license_number'];

                                                $data = $licence->getRequests("SELECT DISTINCT user_name, vehicle_number, isSuspended FROM cms_challan WHERE license_number = '$license' ");
                                                $info = mysqli_fetch_assoc($data);
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $row['license_number']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $info['vehicle_number']; ?>
                                                    </td>
                                                    <td>
                                                        <img alt="image" src="../../dist/assets/img/avatar/avatar-5.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Wildan Ahdian">
                                                    </td>
                                                    <td> <?php echo $info['user_name']; ?> </td>
                                                    <td class="text-left"> <?php $count = $licence->getAnalyticsData("SELECT COUNT(charge) as charge FROM cms_challan WHERE license_number = '$license'", "charge");
                                                                            if (empty($count)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $count;
                                                                            }
                                                                            ?></td>

                                                    <td>
                                                        <div class="badge badge-<?php
                                                                                if ($info['isSuspended'] == 1) {
                                                                                    echo 'danger';
                                                                                } else {
                                                                                    echo "success";
                                                                                } ?>"> <?php if ($info['isSuspended'] == 0) {
                                                                                            echo 'Active';
                                                                                        } else {
                                                                                            echo "Suspended";
                                                                                        } ?> </div>
                                                    </td>
                                                    <td>
                                                        <?php

                                                        if ($info['isSuspended'] == 0) {

                                                        ?>
                                                            <button name="suspend" value="<?php echo $row['license_number']; ?>" type="submit" class="btn btn-danger" <?php if ($count < 6) {
                                                                                                                                                                            echo "disabled";
                                                                                                                                                                        } ?>> Suspend </button>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <button name="active" value="<?php echo $row['license_number']; ?>" type="submit" class="btn btn-success"> Activate </button>

                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php
                                            }


                                            ?>
                                        </table>
                                        <?php

                                        $result = $licence->countRows("SELECT COUNT(traffic_id) as count FROM cms_traffic WHERE traffic_id != ''");
                                        $count = mysqli_fetch_object($result);
                                        if ($count->count == 0) {
                                        ?>
                                            <div class="card-body">
                                                <div class="empty-state" data-height="400">
                                                    <div class="empty-state-icon">
                                                        <i class="fas fa-question"></i>
                                                    </div>
                                                    <h2>We couldn't find any Accounts</h2>
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <script src="../../function.js"></script>
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
           
            <script src="../../dist/assets/modules/izitoast/js/iziToast.min.js"></script>
            <script src="../../dist/assets/js/page/modules-toastr.js"></script>

<!-- Page Specific JS File -->
           
</body>

</html>