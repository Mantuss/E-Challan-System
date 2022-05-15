<?php

include "../../cms_dbm/getCon.php";
session_start();

if(!$_SESSION['admin']){

    header("Location: ../auth/login.php");

}

$active_status = "";
$active_status_color = "";

class EditProfile
{

    private $conn;

    function __construct()
    {

        $object = new Connection();
        $this->conn = $object->getConnection("cms");
    }

    function getAccounts($tid)
    {

        $sql = "SELECT * FROM `cms_traffic` WHERE email = '$tid' ";
        $result = $this->conn->query($sql);
        return $result;
    }

    function updateStatus($tid, $status)
    {

        $sql = "UPDATE `cms_traffic` SET `account_status`='$status' WHERE email= '$tid'";
        if ($this->conn->query($sql)) {
            return true;
        }
        return false;
    }

    function getComplains($sql)
    {
        $result = $this->conn->query($sql);
        return $result;
    }

    function updateDetails($firstname, $lastname, $email, $phone, $address, $state, $zip, $traffic)
    {
        $query = "UPDATE `cms_traffic` SET `firstname`='$firstname',`email`='$email',`number`='$phone',`address`='$address',`state`='$state',`zip_code`='$zip',`lastname`='$lastname' WHERE traffic_id = '$traffic'";

        if ($this->conn->query($query)) {
            return true;
        }

        return false;
    }
}

$edit = new EditProfile();

if (isset($_POST['save'])) {

    $firstname = explode(" ", $_POST['fullname'])[0];
    $lastname = explode(" ", $_POST['fullname'])[sizeof(explode(" ", $_POST['fullname'])) - 1];

    $updateDetails = new EditProfile();
    $bool = $updateDetails->updateDetails($firstname, $lastname, $_POST['tid'], $_POST['number'], $_POST['address'], $_POST['state'], $_POST['zip'], $_POST['traffic']);
    if ($bool) {

        $active_status = "Operation Complete";
        $active_status_color = "success";
    } else {

        $active_status = "Oops! Something went wrong";
        $active_status_color = "danger";
    }
}

if (isset($_POST['status'])) {

    $update = new EditProfile();
    $result = $update->getAccounts($_POST['tid']);
    $row = mysqli_fetch_array($result);

    if ($row['account_status'] == 1) {

        $bool = $update->updateStatus($_POST['tid'], 0);

        if ($bool) {

            $active_status = "Operation Complete";
            $active_status_color = "success";
        } else {

            $active_status = "Oops! Something went wrong";
            $active_status_color = "danger";
        }
    } else {

        $bool = $update->updateStatus($_POST['tid'], 1);

        if ($bool) {

            $active_status = "Operation Complete";
            $active_status_color = "success";
        } else {

            $active_status = "Oops! Something went wrong";
            $active_status_color = "danger";
        }
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title> Edit Account &mdash; Admin</title>

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
                            <a href="http://localhost/cms/cms_admin/screens/cms_licence.php" class="nav-link"><i class="fas fa-id-card"></i><span> Licence Suspended </span></a>
                        </li>
                    </ul>
                </div>
            </nav>

            <?php
            $result = $edit->getAccounts($_POST['tid']);
            $row = mysqli_fetch_assoc($result);
            ?>
            <form method="POST">
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
                                        <?php echo $active_status; ?>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="card">
                                <div class="card-header">
                                    <a href="http://localhost/cms/cms_admin/screens/cms_accounts.php" class="btn btn-primary">Back</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-body pb-3">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" name="fullname" class="form-control" value="<?php echo $row['firstname'] . " " . $row['lastname']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="number" class="form-control phone-number" value="<?php if (!empty($row['number'])) {
                                                                                                                            echo $row['number'];
                                                                                                                        } ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="tid" class="form-control purchase-code" value="<?php echo $_POST['tid']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Traffic ID</label>
                                        <input type="text" name="traffic" class="form-control invoice-input" value="<?php echo $row['traffic_id']; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label> Province / State </label>
                                        <select name="state" class="form-control">
                                            <option value="" <?php if (empty($_POST['state'])) {
                                                                    echo "selected";
                                                                } ?> disabled> Choose a option </option>
                                            <option value="Province 1" <?php if (!empty($row['state'] == "Province 1")) {
                                                                            echo "selected";
                                                                        } ?>>Province 1 </option>
                                            <option value="Province 2" <?php if (!empty($row['state'] == "Province 2")) {
                                                                            echo "selected";
                                                                        } ?>> Province 2 </option>
                                            <option value="Province 3" <?php if (!empty($row['state'] == "Province 3")) {
                                                                            echo "selected";
                                                                        } ?>> Province 3 </option>
                                            <option value="Province 4" <?php if (!empty($row['state'] == "Province 4")) {
                                                                            echo "selected";
                                                                        } ?>> Province 4 </option>
                                            <option value="Province 5" <?php if (!empty($row['state'] == "Province 5")) {
                                                                            echo "selected";
                                                                        } ?>> Province 5 </option>
                                            <option value="Province 6" <?php if (!empty($row['state'] == "Province 6")) {
                                                                            echo "selected";
                                                                        } ?>> Province 6 </option>
                                            <option value="Province 7" <?php if (!empty($row['state'] == "Province 7")) {
                                                                            echo "selected";
                                                                        } ?>> Province 7 </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label> Address Line 1 </label>
                                        <input type="text" name="address" class="form-control purchase-code" value="<?php if (!empty($row['address'])) {
                                                                                                                        echo $row['address'];
                                                                                                                    } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label> Zip Code </label>
                                        <input type="text" name="zip" class="form-control invoice-input" value="<?php if ($row['zip_code']) {
                                                                                                                    echo $row['zip_code'];
                                                                                                                } ?>">
                                    </div>
                                    <div class="form-group pt-1">
                                        <button name="save" type="submit" class="btn btn-primary mt-4"> Save Changes </button>
                                        <button name="status" type="submit" class="btn btn-<?php if ($row['account_status'] == 1) {
                                                                                                echo "danger";
                                                                                            } else {
                                                                                                echo "success";
                                                                                            } ?> mt-4"> <?php if ($row['account_status'] == 1) {
                                                                                                            echo "Disable";
                                                                                                        } else {
                                                                                                            echo "Enable";
                                                                                                        } ?> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>



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