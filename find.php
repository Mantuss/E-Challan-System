<?php


session_start();
include "./cms_dbm/getCon.php";

class FindChallan
{
  private $conn;

  function __construct()
  {
    $object = new Connection();
    $this->conn = $object->getConnection("cms");
  }

  function getChallanData($licence)
  {

    $sql = "SELECT * FROM cms_challan WHERE license_number = '$licence'";
    $result = $this->conn->query($sql);
    return $result;
  }

  function getUserInfo($licence)
  {

    $sql = "SELECT * FROM cms_challan WHERE license_number = '$licence'";
    $result = $this->conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
  }

  function getCount($licence)
  {

    $sql = "SELECT COUNT(challan_id) as count From cms_challan WHERE  license_number = '$licence' ";
    $result = mysqli_query($this->conn, $sql);
    $count = mysqli_fetch_object($result);
    return $count->count;
  }

  function getAmount($licence)
  {

    $sql = "SELECT SUM(charge) as count From cms_challan WHERE  license_number = '$licence' AND isPaid = '0' ";
    $result = mysqli_query($this->conn, $sql);
    $count = mysqli_fetch_object($result);
    return $count->count;
  }

  function getHistory($sql)
  {
    $result = $this->conn->query($sql);
    return $result;
  }

  function countRows($sql)
  {

    $result = $this->conn->query($sql);
    return $result;
  }

  function getStatus($licence)
  {

    $sql = "SELECT DISTINCT(isSuspended) From cms_challan WHERE  license_number = '$licence' ";
    $result = mysqli_query($this->conn, $sql);
    $count = mysqli_fetch_assoc($result);
    if (!empty($count)) {
      if ($count['isSuspended'] == 1) {
        return true;
      }
      return false;
    }
    return false;
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

$find = new FindChallan();

$row = array();
$count = 0;
$amount = 0;
$status = false;

if (isset($_POST['search'])) {

  if (!empty($_POST['searched'])) {

    $row = $find->getUserInfo($_POST['searched']);
    $count = $find->getCount($_POST['searched']);
    $amount = $find->getAmount($_POST['searched']);
    $status =  $find->getStatus($_POST['searched']);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title> Find Challan - User Panel </title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="./dist/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./dist/assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="./dist/assets/css/style.css">
  <link rel="stylesheet" href="./dist/assets/css/components.css">

  <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
  <style>
    body {
      background-color: #F0F8FF;
    }

    .stripe-button-el span {
      display: none !important;
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
        <a href="index.html" class="navbar-brand sidebar-gone-hide">E-challan</a>
        <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
        <div class="nav-collapse">
          <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
            <i class="fas fa-ellipsis-v"></i>
          </a>
        </div>
      </nav>

      <nav class="navbar navbar-secondary navbar-expand-lg">
        <div class="container">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a href="http://localhost/cms/index.php" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item active">
              <a href="http://localhost/cms/find.php" class="nav-link"><i class="fas fa-newspaper"></i><span> Find Challan </span></a>
            </li>
          </ul>
        </div>
      </nav>

     
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>


      <!-- Main Content -->
      <div class="main-content">
        <div class="card">
          <div class="card-header">
            <h4> Search Challan </h4>
            <div class="card-header-form">
              <form method="post">
                <div class="input-group">
                  <input type="text" class="form-control" name="searched" placeholder="Search License">
                  <div class="input-group-btn">
                    <button type="submit" name="search" class="btn btn-primary"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <section class="section">
          <div class="card profile-widget pt-5">
            <div class="profile-widget-header">
              <img alt="image" src="./dist/assets/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture">
              <div class="profile-widget-items">
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label"> Challans </div>
                  <div class="profile-widget-item-value"> <?php if (!empty($count)) {
                                                            echo $count;
                                                          } else {
                                                            echo "---";
                                                          } ?></div>
                </div>
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Due Amount</div>
                  <div class="profile-widget-item-value"> <?php if (!empty($amount)) {
                                                            echo $amount;
                                                          } else {
                                                            echo "---";
                                                          } ?> </div>
                </div>
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label"> Licence Status </div>
                  <div class="profile-widget-item-value"> <span class="badge badge-<?php if (!empty($status)) {
                                                                                      echo "danger";
                                                                                    } else {
                                                                                      echo "success";
                                                                                    } ?>"> <?php if ($status) {
                                                                                              echo "Suspended";
                                                                                            } else if ($status == false) {
                                                                                              echo "Active";
                                                                                            } ?> </span> </div>
                </div>
              </div>
            </div>
            <div class="profile-widget-description">
              <div class="profile-widget-name"><?php if (!empty($row['user_name'])) {
                                                  echo $row['user_name'];
                                                } else {
                                                  echo "---";
                                                } ?> <div class="d-inline">
                  <div class="slash"></div> <?php if (!empty($row['license_number'])) {
                                              echo $row['license_number'];
                                            } else {
                                              echo "---";
                                            } ?>
                </div>
              </div>
            </div>
          </div>

          <form>

            <?php

            if (!empty($_POST['searched'])) {

              $searched = $_POST['searched'];
              $result = $find->getHistory("SELECT DISTINCT license_number  FROM cms_challan where license_number = '$searched'");


              if($row = mysqli_fetch_assoc($result)) {
                $license = $row['license_number'];
                $userinfo = $find->getHistory("SELECT DISTINCT user_name, challan_id, date_time FROM cms_challan WHERE license_number = $license");
                $info = mysqli_fetch_assoc($userinfo);
               ?>
                <div class="row gutters my-4">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="card">
                      <div class="mt-3 ml-3">
                        <button type="button" onclick="printDiv('printable')" class="btn btn-light"> <i class="fas fa-print"> </i> Print </button>
                       
                        <div class="float-right mr-3">
                          <button type="button" class="btn btn-success" id="pay"> <i class="fas fa-print"> </i> Pay Challan </button>
                        </div>
                      </div>

                      <div class="card-body p-0" id="printable">
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
                                  $month = $find->getMonth(explode("-", $date)[1]);

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
                                      $res = $find->getHistory("SELECT * FROM cms_challan WHERE license_number = '$license'");
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
                                          <td><span class="badge badge-<?php if ($paid == 1) {
                                                                          echo "success";
                                                                        } else {
                                                                          echo "danger";
                                                                        } ?> ml-2"> <?php if ($paid == 1) {
                                                                                    echo "Due Cleared";
                                                                                  } else {
                                                                                    echo "Not Cleared";
                                                                                  } ?></span></td>
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
                                          <input type="number" id="total" value="<?php echo $count; ?>" hidden>
                                          <h5 class="text-primary"><strong>रू <?php echo $count; ?></strong></h5>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>

                            <!-- Row end -->
                          </div>

                        </div>

                      </div>
                    </div>
                  </div>
                </div>

              <?php
              }
            }

            if (empty($searched)) {
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

        </section>
      </div>

    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="./function.js"></script>
 
  <script>
    var config = {
      // replace the publicKey with yours
      "publicKey": "test_public_key_dc74e0fd57cb46cd93832aee0a390234",
      "productIdentity": "1234567890",
      "productName": "Dragon",
      "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
      "paymentPreference": [
        "KHALTI",
        "EBANKING",
        "MOBILE_BANKING",
        "CONNECT_IPS",
        "SCT",
      ],
      "eventHandler": {
        onSuccess(payload) {
          // hit merchant api for initiating verfication
          console.log(payload);
        },
        onError(error) {
          console.log(error);
        },
        onClose() {
          console.log('widget is closing');
        }
      }
    };


    var checkout = new KhaltiCheckout(config);
    var btn = document.getElementById("pay");
    var total = document.getElementById("total").value;
    btn.onclick = function() {
      // minimum transaction amount must be 10, i.e 1000 in paisa.
      checkout.show({
        amount: parseInt(total) * 100
      });
    }
  </script>

</body>

</html>