<?php

include "../../cms_dbm/getCon.php";
include '../../cms_dbm/setupdb.php';

session_start();

$error_status = "";

class Login
{
    private $traffic_id;
    private $password;

    function __construct($traffic_id, $password)
    {
        $this->traffic_id = $traffic_id;
        $this->password = $password;
    }

    private function checkDatabase()
    {
        $connection = new Connection();
        $conn = $connection->getConnection("cms");
        $encrypted = md5($this->password);

        $sql = "SELECT COUNT(DISTINCT admin_id) as count From cms_admin WHERE admin_id = '$this->traffic_id' AND admin_pass = '$this->password' AND admin_status = 1";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_fetch_object($result);
        if ($count->count == 1) {
            return true;
        } else {
            return false;
        }
    }

    function logUser()
    {
        $bool = $this->checkDatabase();
        if ($bool) {
          $_SESSION['admin'] = $this->traffic_id;
          header("Location: ../screens/cms_dash.php");
          exit();
        }
    }
}

if (isset($_POST['submit'])) {

    $login = new Login($_POST['email'], $_POST['password']);
    $login->logUser();
    $error_status = "Invalid Login Credintials ";
    $color_status = "light";

}

function createDatabase(){

  $setup = new SetupDatabase("root", "", "localhost", "cms");

  if(!$setup->ifExist()){

    $setup->databaseCreate("http://localhost/E-Challan/user_admin/authentication/Login.php");
    
  }
 
}
createDatabase();

if(isset($_SESSION['admin'])){

    header("Location: ../screens/cms_dash.php");

}

else{

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title> Login - Admin Panel </title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../../dist/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../dist/assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="../../dist/assets/css/style.css">
  <link rel="stylesheet" href="../../dist/assets/css/component.css">
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
          
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 pt-5 mt-5">
            <div class="card card-primary">
            <div class="card-header d-flex justify-content-center"><img src="../../dist/assets/img/avatar/E-challan.png" width="200" height="80"></div>

              <div class="card-body">
              <?php
              if(!empty($error_status)){
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
                <form method="POST" action="#" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Password</label>
                      <div class="float-right">
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit" tabindex="4">
                      Login
                    </button>
                  </div>
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
  <script src="../../dist/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="../../dist/assets/modules/moment.min.js"></script>
  <script src="../../dist/assets/js/stisla.js"></script>
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>

<?php

}

?>