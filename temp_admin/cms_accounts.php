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

class Account
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

$account = new Account();

$error_status = "";
$description = "";
$color_status = "";

if (isset($_POST['submit'])) {

    $check = $account->createAccount($_POST['email'], $_POST['first'], $_POST['last'], $_POST['id'], $_POST['password']);
    if ($check) {
        $bool = $account->sendMail("success", $_POST['email'], "../template/logs.html", $_POST['id'], $_POST['password']);
        $error_status = "Congratulations";
        $description =  "You have successfully registered with our system. All login credintials are sent via email.";
        $color_status = "success";
    } else {

        $error_status = "Oops! Something went wrong";
        $description =  "The system was unable to create the account. Please wait and try after some moment";
        $color_status = "danger";
    }
}

$searched = "";

if (isset($_POST['search'])) {

    $searched = $_POST['searched'];
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title> Manage Account &mdash; Admin</title>

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
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">
                                Messages
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>

                            <?php
                            $result = $account->getComplains("SELECT * FROM cms_complains INNER JOIN cms_challan on cms_complains.user_id = cms_challan.license_number LIMIT 10");
                            if (!empty($row = mysqli_num_rows($result))) {
                            ?>
                                <div class="dropdown-list-content dropdown-list-message">

                                    <?php
                                    while ($data = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <a class="dropdown-item">
                                            <div class="dropdown-item-avatar">
                                                <img alt="image" src="../../dist/assets/img/avatar/avatar-5.png" class="rounded-circle">
                                            </div>
                                            <div class="dropdown-item-desc">
                                                <b> <?php echo $data['user_name']; ?> </b>
                                                <p> <?php echo $data['complainHead']; ?> </p>
                                                <p class="text-primary"> Now </p>
                                            </div>
                                        </a>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="dropdown-footer text-center" style="background-color:FDFDFD;">
                                    <a href="./cms_complains.php">View All <i class="fas fa-chevron-right"></i></a>
                                </div>

                            <?php

                            }

                            ?>

                        </div>
                    </li>

                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="../../dist/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, <?php if (!empty($_SESSION['admin'])) {
                                                                                echo $_SESSION['admin'];
                                                                            } ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item has-icon text-danger">
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
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_admin/screens/cms_inbox.php" class="nav-link"><i class="fas fa-inbox"></i><span> Requests </span></a>
                        </li>
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_admin/screens/cms_history.php" class="nav-link"><i class="fas fa-history"></i><span> History </span></a>
                        </li>
                        <li class="nav-item active">
                            <a href="http://localhost/cms/cms_admin/screens/cms_accounts.php" class="nav-link"><i class="fas fa-users"></i><span> Manage Accounts </span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" class="nav-link"><i class="fas fa-comments"></i><span> Complains </span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" class="nav-link"><i class="fas fa-id-card"></i><span> Licence Suspended </span></a>
                        </li>
                    </ul>
                </div>
            </nav>

            <form method="post">
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-head mt-4 mb-3 text-center">
                                <h4> Create Account </h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Email</span>
                                        </div>
                                        <input type="email" name="email" class="form-control" placeholder="" aria-label="" required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">First and Last Name</span>
                                        </div>
                                        <input type="text" name="first" class="form-control" required>
                                        <input type="text" name="last" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> Traffic ID </span>
                                        </div>

                                        <?php

                                        $traffic_id = "";
                                        $result = $account->countRows("SELECT traffic_id  FROM cms_traffic ORDER BY traffic_id  DESC LIMIT 1");
                                        $count = mysqli_fetch_array($result);
                                        if (!empty($count)) {

                                            $traffic_id = (int) $count['traffic_id'] + 1;
                                        } else {

                                            $traffic_id = "100000";
                                        }
                                        ?>
                                        <input type="text" value="<?php echo $traffic_id; ?>" name="id" class="form-control" placeholder="" aria-label="" required readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> Password </span>
                                        </div>
                                        <input type="password" id="pass" name="password" class="form-control" placeholder="" aria-label="" required>
                                        <div class="input-group-append">
                                            <button onclick="randomPassword()" class="btn btn-primary" type="button"> Generate </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer mb-3">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close </button>
                                <button type="submit" name="submit" class="btn btn-primary"> Add Account </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="main-content">
                <div class="row">
                    <div class="col-12">
                        <?php

                        if (!empty($error_status)) {

                        ?>
                            <div class="hero align-items-center bg-<?php echo $color_status; ?> alert-dismissible text-white mb-4">
                                <div class="hero-inner text-center">
                                    <h2> <?php echo $error_status; ?></h2>
                                    <p class="lead"> <?php echo $description; ?></p>
                                </div>
                            </div>
                        <?php

                        }
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h4> <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Account</button> </h4>
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

                            <form method="post" action="./cms_edit.php">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Traffic No</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>

                                            <?php

                                            if (!empty($searched)) {
                                                $result = $account->getRequests("SELECT * FROM cms_traffic WHERE email='$searched' OR traffic_id='$searched'");
                                            } else {
                                                $result = $account->getRequests("SELECT * FROM cms_traffic");
                                            }

                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $row['traffic_id']; ?>
                                                    </td>
                                                    <td>
                                                        <img alt="image" src="../../dist/assets/img/avatar/avatar-1.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Wildan Ahdian">
                                                    </td>
                                                    <td> <?php echo $row['firstname'] . " " . $row['lastname']; ?> </td>
                                                    <td> <?php echo $row['email']; ?> </td>
                                                    <td>
                                                        <div class="badge badge-<?php
                                                                                if ($row['account_status'] == 1) {
                                                                                    echo 'success';
                                                                                } else {
                                                                                    echo "danger";
                                                                                } ?>"> <?php if ($row['account_status'] == 1) {
                                                                                            echo 'Active';
                                                                                        } else {
                                                                                            echo "Disabled";
                                                                                        } ?> </div>
                                                    </td>
                                                    <td>
                                                        <button type="submit" class="btn btn-primary" name='tid' value="<?php echo $row['email']; ?>">Edit</button>
                                                    </td>
                                                </tr>
                                            <?php
                                            }

                                            ?>
                                        </table>
                                        <?php

                                        $result = $account->countRows("SELECT COUNT(traffic_id) as count FROM cms_traffic WHERE traffic_id != ''");
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



            <script src="../../function.js"> </script>
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