<?php

include "../../cms_dbm/getCon.php";
session_start();

if(!$_SESSION['admin']){

    header("Location: ../auth/login.php");

}

class History
{

    private $conn;

    function __construct()
    {
        $object = new Connection();
        $this->conn = $object->getConnection("cms");
    }

    function countRows($sql)
    {

        $result = $this->conn->query($sql);
        return $result;
    }

    function getHistory($sql)
    {
        $result = $this->conn->query($sql);
        return $result;
    }

    function getComplains($sql)
    {
        $result = $this->conn->query($sql);
        return $result;
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

$history = new History();

$searched = "";

if(isset($_POST['search'])){

    $searched = $_POST['searched'];


}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>History &mdash; Admin</title>

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
                <a href="index.html" class="navbar-brand sidebar-gone-hide"> E-challan </a>
                <form class="form-inline ml-auto">

                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="../../dist/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, <?php echo $_SESSION['admin'];  ?></div>
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
                        <li class="nav-item active">
                            <a href="http://localhost/cms/cms_admin/screens/cms_history.php" class="nav-link"><i class="fas fa-history"></i><span> History </span></a>
                        </li>
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_admin/screens/cms_accounts.php" class="nav-link"><i class="fas fa-users"></i><span> Manage Accounts </span></a>
                        </li>
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_admin/screens/cms_licence.php" data-toggle="dropdown" class="nav-link"><i class="fas fa-id-card"></i><span> Licence Suspended </span></a>
                        </li>
                    </ul>
                </div>
            </nav>


            <!-- Main Content -->
            <div class="main-content">
                <div class="card">
                    <div class="card-header">
                        <h4> </h4>
                        <div class="card-header-form">
                            <form method="POST">
                                <div class="input-group">
                                    <input type="text" name="searched" class="form-control" placeholder="Search">
                                    <div class="input-group-btn">
                                        <button type="submit" name="search" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

                <form method="post">

                    <?php

                    if(!empty($searched)){
                        $result = $history->getHistory("SELECT DISTINCT license_number  FROM cms_challan where license_number = '$searched'");
                    }

                    else{
                        $result = $history->getHistory("SELECT DISTINCT license_number  FROM cms_challan");
                    }
                   
                    while ($row = mysqli_fetch_assoc($result)) {
                        $license = $row['license_number'];
                        $userinfo = $history->getHistory("SELECT DISTINCT user_name, challan_id, date_time FROM cms_challan WHERE license_number = $license");
                        $info = mysqli_fetch_assoc($userinfo);
                    ?>
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
                                                                <h3><?php echo $info['user_name']; ?></h3><br>
                                                                Putalisadak, Kathmandu 44600, Nepal
                                                            </address>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                                        <div class="invoice-details">

                                                            <div>
                                                                <h3> Invoice#<?php echo $info['challan_id']; ?> </h3>
                                                            </div>
                                                            <?php
                                                            $date = explode(" ", $info['date_time'])[0];
                                                            $month = $history->getMonth(explode("-", $date)[1]);

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
                                                                <tbody>

                                                                    <?php
                                                                    $paid = 0;
                                                                    $count = 0;
                                                                    $license = $row['license_number'];
                                                                    $res = $history->getHistory("SELECT * FROM cms_challan WHERE license_number = '$license'");
                                                                    while ($data = mysqli_fetch_assoc($res)) {

                                                                        if ($data['isPaid'] == 0) {
                                                                            $count += $data['charge'];
                                                                        }

                                                                        $paid = $data['isPaid'];
                                                                    ?>
                                                                        <tr>
                                                                            <td>
                                                                            <p class="m-0">
                                                                             <?php echo $data['cause']; ?>
                                                                            </p>
                                                                            </td>
                                                                            <td>#<?php echo $data['license_number']; ?></td>
                                                                            <td><?php echo $data['vehicle_number']; ?></td>

                                                                            <td>रू <?php echo $data['charge']; ?></td>
                                                                            <td><span class="badge badge-<?php if ($paid == 1) {echo "success";} else {echo "danger";} ?> ml-2"> <?php if ($paid == 1) {echo "Due Cleared";} else {echo "Not Cleared";}?></span></td>
                                                                        </tr>
                                                                    <?php

                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                        <td colspan="2">
                                                                         <h5 class="text-primary"><strong>Grand Total</strong></h5>
                                                                        </td>
                                                                        <td colspan="2">
                                                                         <h5 class="text-primary"><strong>रू <?php echo $count;  ?></strong></h5>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Row end -->
                                            </div>
                                            <div class="mt-3">
                                                <button onclick="printDiv('printable')" class="btn btn-light"> <i class="fas fa-print"> </i> Print </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php

                    }

                    $result = $history->countRows("SELECT COUNT(challan_id) as count FROM cms_challan");
                    $count = mysqli_fetch_object($result);
                    if ($count->count == 0) {
                    ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="empty-state" data-height="400">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-question"></i>
                                    </div>
                                    <h2>We couldn't find any Challan</h2>
                                    <p class="lead">
                                        Sorry we can't find any data, to get rid of this message, make at least 1 entry.
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </form>
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