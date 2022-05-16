<?php

session_start();
error_reporting(0);
include("../../cms_dbm/getCon.php");

$error_status = "";
$color_status = "";
$amount = 0;

if(!$_SESSION['islogged']){

    header("Location:../auth/login.php");

}


class Traffic
{
    function __construct()
    {
        $object = new Connection();
        $this->conn = $object->getConnection("cms");
    }

    function generateChallanId($chars)
    {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, $chars);
    }

    function getChallanInfo($license)
    {

        $info = $this->conn->query("SELECT * FROM  cms_challan WHERE license_number='$license'");
        return $info;
    }

    function createChallan($name, $licence, $vehicle, $traffic_id, $charge, $cause, $time, $challanid)
    {
        $sql = "INSERT INTO `cms_challan`(`challan_id`, `license_number`, `vehicle_number`, `user_name`, `traffic_id`, `date_time`, `charge`, `cause`, `isPaid`, `isSuspended`) VALUES ('$challanid','$licence','$vehicle','$name','$traffic_id','$time','$charge','$cause','0','0')";
        if ($this->conn->query($sql)) {
            return true;
        } else {
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

    function checkExistingChallan($license)
    {
        $sql = "SELECT COUNT(user_name) as count From cms_challan WHERE license_number = '$license' AND isPaid ='0' ";
        $result = $this->conn->query($sql);
        $count = mysqli_fetch_object($result);

        if ($count->count <= 1) {
            return true;
        } else {
            return false;
        }
    }
    function getMonth($index)
    {

        if ($index == 1) {

            return "January";
        }
        if ($index == 2) {

            return "February";
        }
        if ($index == 3) {

            return "March";
        }
        if ($index == 4) {

            return "April";
        }
        if ($index == 5) {

            return "May";
        }
        if ($index == 6) {

            return "June";
        }
        if ($index == 7) {

            return "July";
        }
        if ($index == 8) {

            return "August";
        }
        if ($index == 9) {

            return "September";
        }
        if ($index == 10) {

            return "October";
        }
        if ($index == 11) {

            return "November";
        }
        if ($index == 12) {

            return "December";
        }
    }
}

$traffic = new Traffic();

if (isset($_POST['create'])) {

    if ($traffic->checkExistingChallan($_POST['licence'])) {

        $info =  $traffic->getChallanInfo($_POST['licence']);
        $row = mysqli_fetch_assoc($info);

        $check = $traffic->createChallan($_POST['name'], $_POST['licence'], $_POST['vehicle'], $_SESSION['islogged'], $_POST['amount'], $_POST['reason'], $_POST['time'], $row['challan_id']);
        if ($check) {
            $error_status = "Challan Created Successfully";
            $color_status = "success";
        } else {
            $error_status = "Oops! Something went wrong";
            $color_status = "danger";
        }
    } else {

        $check = $traffic->createChallan($_POST['name'], $_POST['licence'], $_POST['vehicle'], $_SESSION['islogged'], $_POST['amount'], $_POST['reason'], $_POST['time'], $_POST['challan_id']);

        if ($check) {
            $error_status = "Challan Created Successfully";
            $color_status = "success";
        } else {
            $error_status = "Oops! Something went wrong";
            $color_status = "danger";
        }
    }
}

if (isset($_POST['refresh'])) {
    header("Refresh:0");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title> Dashboard &mdash; Traffic Panel </title>

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

        .invoice-container {
            padding: 1rem;
        }

        .invoice-container .invoice-header .invoice-logo {
            margin: 0.8rem 0 0 0;
            display: inline-block;
            font-size: 1.6rem;
            font-weight: 700;
            color: #2e323c;
        }

        .invoice-container .invoice-header .invoice-logo img {
            max-width: 130px;
        }

        .invoice-container .invoice-header address {
            font-size: 0.8rem;

            margin: 0;
        }

        .invoice-container .invoice-details {
            margin: 1rem 0 0 0;
            padding: 1rem;
            line-height: 180%;

        }

        .invoice-container .invoice-details .invoice-num {
            text-align: right;
            font-size: 0.8rem;
        }

        .invoice-container .invoice-body {
            padding: 1rem 0 0 0;
        }

        .invoice-container .invoice-footer {
            text-align: center;
            font-size: 0.7rem;
            margin: 5px 0 0 0;
        }

        .invoice-status {
            text-align: center;
            padding: 1rem;
            background: #ffffff;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .invoice-status h2.status {
            margin: 0 0 0.8rem 0;
        }

        .invoice-status h5.status-title {
            margin: 0 0 0.8rem 0;
            color: #9fa8b9;
        }

        .invoice-status p.status-type {
            margin: 0.5rem 0 0 0;
            padding: 0;
            line-height: 150%;
        }

        .invoice-status i {
            font-size: 1.5rem;
            margin: 0 0 1rem 0;
            display: inline-block;
            padding: 1rem;
            background: #f5f6fa;
            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            border-radius: 50px;
        }

        .invoice-status .badge {
            text-transform: uppercase;
        }

        @media (max-width: 767px) {
            .invoice-container {
                padding: 1rem;
            }
        }


        .custom-table {
            border: 1px solid #e0e3ec;
        }

        .custom-table thead {
            background: #6777ef;
        }

        .custom-table thead th {
            border: 0;
            color: #ffffff !important;

        }

        .custom-table>tbody tr:hover {
            background: #fafafa;
        }

        .custom-table>tbody tr:nth-of-type(even) {
            background-color: #ffffff;
        }

        .custom-table>tbody td {
            border: 1px solid #e6e9f0;
        }


        .card {
            background: #ffffff;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            border: 0;
            margin-bottom: 1rem;
        }

        .text-success {
            color: #00bb42 !important;
        }

        .text-muted {
            color: #9fa8b9 !important;
        }

        .custom-actions-btns {
            margin: auto;
            display: flex;
            justify-content: flex-end;
        }

        .custom-actions-btns .btn {
            margin: .3rem 0 .3rem .3rem;
        }
    </style>

</head>

<body class="layout-3">
    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="" class="navbar-brand sidebar-gone-hide"> E-challan </a>
                <form class="form-inline ml-auto">

                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="../../dist/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, <?php echo $traffic->getNameTraffic()['firstname'] . " " . $traffic->getNameTraffic()['lastname']; ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="http://localhost/cms/cms_traffic/auth/logout.php" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <nav class="navbar navbar-secondary navbar-expand-lg">
                <div class="container">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a href="http://localhost/cms/cms_traffic/screens/cms_dash.php" class="nav-link"><i class="fas fa-home"></i><span> Issue Challan </span></a>
                        </li>
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_traffic/screens/cms_history.php" class="nav-link"><i class="fas fa-newspaper"></i><span> History </span></a>
                        </li>
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_traffic/screens/cms_licence.php" class="nav-link"><i class="fas fa-id-card"></i><span> Licence </span></a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                <?php if (!empty($error_status)) {
                ?>
                    <div class="alert alert-<?php echo $color_status; ?> alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            <?php echo $error_status; ?>
                        </div>
                    </div>
                <?php
                }
                ?>
                <div class="row">
                    <div class="card-body">
                        <div class="row mt-4">
                            <div class="col-12 col-lg-8 offset-lg-2">
                                <div class="wizard-steps">
                                    <div class="wizard-step  <?php if (empty($_POST['submit']) && empty($_POST['create']) || $_POST['submit'] == 1  && empty($_POST['create'])) {
                                                                    echo "wizard-step-active";
                                                                } ?>">
                                        <div class="wizard-step-icon">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                        <div class="wizard-step-label">
                                            Create Challan
                                        </div>
                                    </div>
                                    <div class="wizard-step <?php if ($_POST['submit'] == 2) {
                                                                echo "wizard-step-active";
                                                            } ?>">
                                        <div class="wizard-step-icon">
                                            <i class="fas fa-eye"></i>
                                        </div>
                                        <div class="wizard-step-label">
                                            Preview Challan
                                        </div>
                                    </div>
                                    <div class="wizard-step <?php if ($_POST['create'] == 3) {
                                                                echo "wizard-step-active";
                                                            } ?>">
                                        <div class="wizard-step-icon">
                                            <i class="fas fa-print"></i>
                                        </div>
                                        <div class="wizard-step-label">
                                            Print Challan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-body">
                        <?php if (empty($_POST['submit']) && empty($_POST['create']) || $_POST['submit'] == 1  && empty($_POST['create'])) {

                        ?>
                            <form method="POST" action="./cms_dash.php">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="first_name">Licence Number</label>
                                        <input id="first_name" type="text" class="form-control" value="<?php if (!empty($_POST['licence'])) {
                                                                                                            echo $_POST['licence'];
                                                                                                        } ?>" name="licence" autofocus required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="last_name"> Vehicle Number </label>
                                        <input id="last_name" type="text" class="form-control" value="<?php if (!empty($_POST['vehicle'])) {
                                                                                                            echo $_POST['vehicle'];
                                                                                                        } ?>" name="vehicle" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email"> Name </label>
                                    <input id="email" type="text" class="form-control" name="name" value="<?php if (!empty($_POST['name'])) {
                                                                                                                echo $_POST['name'];
                                                                                                            } ?>" required>
                                    <div class="invalid-feedback">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email"> Reason / Cause </label>
                                    <div class="form-group">
                                        <select id="cause" name="reason" class="form-control form-control-lg">
                                            <option value="" <?php if (empty($_POST['reason'])) {
                                                                    echo "selected";
                                                                } ?> disabled> Choose a option </option>
                                            <option value="Overspeeding" <?php if ($_POST['reason'] == "Overspeeding") {
                                                                                echo "selected";
                                                                            } ?>> Overspeeding </option>
                                            <option value="Accident" <?php if ($_POST['reason'] == "Accident") {
                                                                            echo "selected";
                                                                        } ?>> Accident </option>
                                            <option value="Drink and Drive" <?php if ($_POST['reason'] == "Drink and Drive") {
                                                                                echo "selected";
                                                                            } ?>> Drink and Drive </option>
                                            <option value="Others" <?php if ($_POST['reason'] == "Others") {
                                                                        echo "selected";
                                                                    } ?>> Others </option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="password" class="d-block"> Location </label>
                                        <input id="password" type="text" class="form-control pwstrength" name="location" data-indicator="pwindicator" name="location" value="<?php if (!empty($_POST['location'])) {
                                                                                                                                                                                    echo $_POST['location'];
                                                                                                                                                                                } ?>" required>
                                    </div>
                                    <div id="amount" class="form-group col-6">
                                        <label for="amount" class="d-block"> Amount </label>
                                        <input id="amt" type="text" class="form-control" name="amount" value="<?php if (!empty($_POST['amount'])) {
                                                                                                                    echo $_POST['amount'];
                                                                                                                } ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" name="submit" value="2" class="btn btn-primary btn-lg btn-block">
                                        Preview Challan
                                    </button>
                                </div>

                            </form>
                        <?php
                        } else {
                        ?>
                        <form method="POST">
                            <div class="row gutters my-4">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card" id="printable">
                                        <div class="card-body p-0">
                                            <div class="invoice-container">
                                                <div class="invoice-header">
                                                    <!-- Row end -->
                                                    <!-- Row start -->
                                                    <div class="row gutters">
                                                        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                                            <div class="invoice-details">
                                                                <address>
                                                                    <h3><input  name="name" value="<?php if (!empty($_POST['name'])) {echo $_POST['name'];} ?>" hidden> <?php echo $_POST['name']; ?></h3><br>
                                                                    Putalisadak, Kathmandu 44600, Nepal
                                                                </address>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                                            <div class="invoice-details">

                                                                <div>
                                                                    <?php  $id = $traffic->generateChallanId(4);  ?>
                                                                    <h3><input  name="challan_id" value="<?php echo $id ?>" hidden> Invoice#<?php echo $id; ?> </h3>
                                                                </div>
                                                                <?php

                                                                $date = explode(" ", date("Y-m-d H:i:s"))[0];
                                                                $month = $traffic->getMonth(explode("-", $date)[1]);

                                                                ?>
                                                                <div><?php echo $month . " " . explode("-", $date)[2] . "th" . " " . explode("-", $date)[0] ?></div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Row end -->
                                                </div>
                                                <div class="invoice-body">
                                                    <!-- Row start -->
                                                    <div class="row gutters">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="table-responsive">
                                                                <table class="table custom-table m-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th> Reason of Challan / Description </th>
                                                                            <th> License Number </th>
                                                                            <th> Vehicle Number </th>
                                                                            <th> Net Total (रू) </th>
                                                                            <th> </th>

                                                                        </tr>
                                                                    </thead>
                                                                    <input  name="location" value="<?php if (!empty($_POST['location'])) {echo $_POST['location'];} ?>" hidden>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <p class="m-0">
                                                                                <input  name="reason" value="<?php if (!empty($_POST['reason'])) {echo $_POST['reason'];} ?>" hidden>
                                                                                    <?php echo $_POST['reason']; ?>
                                                                                </p>
                                                                            </td>
                                                                            <td><input  name="licence" value="<?php if (!empty($_POST['licence'])) {echo $_POST['licence'];} ?>" hidden> <?php echo $_POST['licence']; ?></td>
                                                                            <td> <input  name="vehicle" value="<?php if (!empty($_POST['vehicle'])) {echo $_POST['vehicle'];} ?>" hidden><?php echo $_POST['vehicle']; ?></td>

                                                                            <td><input  name="amount" value="<?php if (!empty($_POST['amount'])) {echo $_POST['amount'];} ?>" hidden> रू <?php echo $_POST['amount']; ?></td>
                                                                            <td><span class="badge badge-danger"> Not Cleared </span></td>
                                                                        </tr>
                                                                        
                                                                        <tr>
                                                                            <td>&nbsp;</td>
                                                                            <td colspan="2">
                                                                                <h5 class="text-primary"><strong>Grand Total</strong></h5>
                                                                            </td>
                                                                            <td colspan="2">
                                                                                <h5 class="text-primary"><strong>रू <?php echo $_POST['amount'];  ?></strong></h5>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Row end -->
                                                </div>
                                                <?php if ($_POST['submit'] == 2) {
                                                ?>
                                                    <div class="text-md-right mt-5">
                                                        <div class="float-lg-left mb-lg-0 mb-3 pb-4">
                                                            <button type="submit" name="submit" value="1" class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Discard Challan </button>
                                                        </div>
                                                        <button type="submit" name="create" value="3" class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i> Create Challan </button>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="text-md-right mt-5">
                                                        <div class="float-lg-left mb-lg-0 mb-3 pb-4">
                                                            <button type="submit" name="refresh" value="1" class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Restart Form </button>
                                                        </div>
                                                        <input type="button" onclick="printDiv('printable')" value="Print" class="btn btn-primary btn-icon icon-left">
                                                    </div>

                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </form>
                        <?php
                        }
                        ?>

                    </div>
                </div>


            </div>

        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="../../function.js"></script>
    <script src="../js/print.js"></script>
    <script src="../js/print.js"></script>
    <script src="../js/dropdown.js"></script>
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
</body>

</html>