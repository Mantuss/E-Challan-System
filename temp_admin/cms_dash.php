<?php

session_start();

if(!$_SESSION['admin']){

    header("Location: ../auth/login.php");

}


include "../../cms_dbm/getCon.php";

class Admin
{

    private $conn;

    function __construct()
    {
        $object = new Connection();
        $this->conn = $object->getConnection("cms");
    }

    function getAnalyticsData($sql, $index)
    {
        $result = $this->conn->query($sql);
        $count = mysqli_fetch_assoc($result);
        return $count[$index];
    }

    function getRecovery($sql)
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

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title> Dashboard &mdash; Admin </title>

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

<?php
$admin = new Admin();
?>

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
                                Complains
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>

                            <?php
                            $result = $admin->getComplains("SELECT * FROM cms_complains INNER JOIN cms_challan on cms_complains.user_id = cms_challan.license_number LIMIT 10");
                            if(!empty($row = mysqli_num_rows($result)))
                                {
                             ?>
                            <div class="dropdown-list-content dropdown-list-message">

                            <?php
                                while($data = mysqli_fetch_assoc($result)) 
                                {
                             ?>
                                <a class="dropdown-item">
                                    <div class="dropdown-item-avatar">
                                        <img alt="image" src="../../dist/assets/img/avatar/avatar-5.png" class="rounded-circle">
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <b> <?php echo $data['user_name']; ?> </b>
                                         <p> <?php echo $data['complainHead'];?> </p>
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
                        <li class="nav-item active">
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
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" class="nav-link"><i class="fas fa-comments"></i><span> Complains </span></a>
                        </li>
                        <li class="nav-item">
                            <a href="http://localhost/cms/cms_admin/screens/cms_licence.php" class="nav-link"><i class="fas fa-id-card"></i><span> Licence Suspended </span></a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-primary">
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Traffic</h4>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $result = $admin->getAnalyticsData("SELECT COUNT(DISTINCT traffic_id) as t_accounts FROM cms_traffic WHERE traffic_id != ''", "t_accounts");
                                        echo $result;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-danger">
                                    <i class="far fa-newspaper"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Challan</h4>
                                    </div>
                                    <div class="card-body">
                                        <?php

                                        $result = $admin->getAnalyticsData("SELECT COUNT(DISTINCT challan_id) as count FROM cms_challan WHERE challan_id != ''", "count");
                                        echo $result;

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-warning">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Amount</h4>
                                    </div>
                                    <div class="card-body">

                                        <?php

                                        $result = $admin->getAnalyticsData("SELECT SUM(charge) as charge FROM cms_challan WHERE license_number != ''", "charge");
                                        if (empty($result)) {
                                            echo "0";
                                        } else {
                                            echo $result;
                                        }

                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-success">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Active Users</h4>
                                    </div>
                                    <div class="card-body">
                                        <?php

                                        $result = $admin->getAnalyticsData("SELECT COUNT(DISTINCT traffic_id) as t_accounts FROM cms_traffic WHERE account_status != '0'", "t_accounts");
                                        echo $result;

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Statistics</h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart" height="182"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Recovery Request</h4>
                                </div>
                                <div class="card-body">

                                    <ul class="list-unstyled list-unstyled-border">
                                        <?php
                                        $sql = "SELECT * FROM cms_requests INNER JOIN cms_traffic ON cms_requests.email = cms_traffic.email";
                                        $result = $admin->getRecovery($sql);
                                        $count = 0;
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <li class="media">
                                                <img class="mr-3 rounded-circle" width="50" src="../../dist/assets/img/avatar/avatar-1.png" alt="avatar">
                                                <div class="media-body">
                                                    <div class="float-right text-primary"><?php if ($count == 0) {
                                                                                                echo "Now";
                                                                                            } else {
                                                                                                echo "";
                                                                                            } ?></div>
                                                    <div class="media-title"><?php echo $row['firstname'] . " " . $row['lastname']; ?></div>
                                                    <span class="text-small text-muted"> New Password Request Recovery </span>
                                                </div>
                                            </li>

                                        <?php
                                            $count += 1;
                                        }
                                        ?>
                                    </ul>
                                    <div class="text-center pt-1 pb-4">
                                        <a href="./cms_inbox.php" class="btn btn-primary btn-lg btn-round">
                                            View All
                                        </a>
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