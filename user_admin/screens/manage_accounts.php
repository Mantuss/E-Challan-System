<?php

include("../../DBM/getConnection.php");
error_reporting(0);


$error_status = "";
$color_status = "";

class ManageAccounts{

  private $conn;

  function __construct(){

    $object = new Connection();
    $this->conn = $object->getConnection("echallan");

  }

  private function checkExisting($id)
  {

      $sql = "SELECT COUNT(DISTINCT traffic_id) as count From traffic_logs WHERE traffic_id = '$id'";
      $result = $this->conn->query($sql);
      $count = mysqli_fetch_object($result);

      if ($count->count == 1) {
          return false;
      } else {
          return true;
      }
  }

  function getAccounts(){
      $data = array();
      $sql = "SELECT * FROM `traffic_logs` WHERE traffic_id != '' ";
      $result = $this->conn->query($sql);
      return $result;
  }

  function createAccount($first, $last, $traffic_id, $email,$password){

      $bool = $this->checkExisting($traffic_id);

      if ($bool) {
          $encrypted = md5($password);
          $sql = "INSERT INTO traffic_logs(`traffic_id`, `account_status`, `traffic_pass`, `email`,`firstname`, `lastname`) VALUES ('$traffic_id', '1','$encrypted','$email', '$first', '$last')";
          $this->conn->query($sql);
          return true;
      }
      else {
          return false;
      }
  }

}

if(isset($_POST['create'])){

    $create = new ManageAccounts();
    $bool = $create->createAccount($_POST['first'], $_POST['last'], $_POST['id'],$_POST['email'],$_POST['ranks'],$_POST['password']);
    if($bool){

      $error_status = "User has been created";
      $color_status = "success";

    }

    else{

      $error_status = "Oops! Something went wrong";
      $color_status = "danger";

    }

}

?>

 <html
   lang="en"
   class="light-style layout-menu-fixed"
   dir="ltr"
   data-theme="theme-default"
   data-assets-path="../assets/"
   data-template="vertical-menu-template-free"
 >
   <head>
     <meta charset="utf-8" />
     <meta
       name="viewport"
       content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
     />

     <title>Manage Accounts - Admin Panel</title>

     <meta name="description" content="" />

     <!-- Favicon -->
     <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

     <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.googleapis.com" />
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
     <link
       href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
       rel="stylesheet"
     />

     <!-- Icons. Uncomment required icon fonts -->
     <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />

     <!-- Core CSS -->
     <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
     <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
     <link rel="stylesheet" href="../../assets/css/demo.css" />

     <!-- Vendors CSS -->
     <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

     <!-- Page CSS -->

     <!-- Helpers -->
     <script src="../../assets/vendor/js/helpers.js"></script>

     <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
     <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
     <script src="../../assets/js/config.js"></script>
   </head>

   <body>
     <!-- Layout wrapper -->
     <div class="layout-wrapper layout-content-navbar">
       <div class="layout-container">
         <!-- Menu -->

         <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
           <div class="app-brand demo">
             <a href="index.html" class="app-brand-link">
               <span class="app-brand-logo demo">
                 <svg
                   width="25"
                   viewBox="0 0 25 42"
                   version="1.1"
                   xmlns="http://www.w3.org/2000/svg"
                   xmlns:xlink="http://www.w3.org/1999/xlink"
                 >
                   <defs>
                     <path
                       d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                       id="path-1"
                     ></path>
                     <path
                       d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                       id="path-3"
                     ></path>
                     <path
                       d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                       id="path-4"
                     ></path>
                     <path
                       d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                       id="path-5"
                     ></path>
                   </defs>
                   <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                     <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                       <g id="Icon" transform="translate(27.000000, 15.000000)">
                         <g id="Mask" transform="translate(0.000000, 8.000000)">
                           <mask id="mask-2" fill="white">
                             <use xlink:href="#path-1"></use>
                           </mask>
                           <use fill="#696cff" xlink:href="#path-1"></use>
                           <g id="Path-3" mask="url(#mask-2)">
                             <use fill="#696cff" xlink:href="#path-3"></use>
                             <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                           </g>
                           <g id="Path-4" mask="url(#mask-2)">
                             <use fill="#696cff" xlink:href="#path-4"></use>
                             <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                           </g>
                         </g>
                         <g
                           id="Triangle"
                           transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) "
                         >
                           <use fill="#696cff" xlink:href="#path-5"></use>
                           <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                         </g>
                       </g>
                     </g>
                   </g>
                 </svg>
               </span>
               <span class="app-brand-text demo menu-text fw-bolder ms-2">E-Challan</span>
             </a>

             <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
               <i class="bx bx-chevron-left bx-sm align-middle"></i>
             </a>
           </div>

           <div class="menu-inner-shadow"></div>

           <ul class="menu-inner py-1">
             <!-- Dashboard -->
             <li class="menu-item">
               <a href="http://localhost/E-Challan/user_admin/screens/dashboard.php" class="menu-link">
                 <i class="menu-icon tf-icons bx bx-home-circle"></i>
                 <div data-i18n="Analytics">Dashboard</div>
               </a>
             </li>

             <!-- Dashboard -->
             <li class="menu-item">
               <a href="http://localhost/E-Challan/user_admin/screens/inbox_requests.php" class="menu-link">
                 <i class='menu-icon bx bxs-inbox'></i>
                 <div data-i18n="Analytics">Inbox / Requests</div>
               </a>
             </li>


             <!-- Dashboard -->
             <li class="menu-item">
               <a href="http://localhost/E-Challan/user_admin/screens/history.php" class="menu-link">
                <i class='menu-icon bx bx-history' ></i>
                 <div data-i18n="Analytics">History</div>
               </a>
             </li>


             <!-- Dashboard -->
             <li class="menu-item active">
               <a href="http://localhost/E-Challan/user_admin/screens/manage_accounts.php" class="menu-link">
                <i class='menu-icon bx bxs-user-account'></i>
                 <div data-i18n="Analytics">Manage Accounts</div>
               </a>
             </li>

         </aside>
         <!-- / Menu -->

         <!-- Layout container -->
         <div class="layout-page">
           <!-- Navbar -->

           <nav
             class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
             id="layout-navbar"
           >
             <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
               <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                 <i class="bx bx-menu bx-sm"></i>
               </a>
             </div>

             <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
               <!-- Search -->
               <div class="navbar-nav align-items-center">
                 <div class="nav-item d-flex align-items-center">
                   <i class="bx bx-search fs-4 lh-0"></i>
                   <input
                     type="text"
                     class="form-control border-0 shadow-none"
                     placeholder="Search..."
                     aria-label="Search..."
                   />
                 </div>
               </div>
               <!-- /Search -->
             </div>
           </nav>

           <!-- / Navbar -->

           <!-- Content wrapper -->
           <div class="content-wrapper">
             <!-- Content -->

             <div class="container-xxl flex-grow-1 container-p-y">


               <!-- Modal -->
               <form method="post">
               <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <div class="modal-header">
                       <h5 class="modal-title" id="modalCenterTitle">Add an Account</h5>
                       <button
                         type="button"
                         class="btn-close"
                         data-bs-dismiss="modal"
                         aria-label="Close"
                       ></button>
                     </div>
                     <div class="modal-body">

                       <div class="row g-2 mb-3">
                         <div class="col mb-0">
                           <label for="emailWithTitle" class="form-label">First Name</label>
                           <input
                             type="text"
                             id="emailWithTitle"
                             class="form-control"
                             name="first"
                             placeholder="Raymon"
                           />
                         </div>
                         <div class="col mb-0">
                           <label for="dobWithTitle" class="form-label"> Last Name</label>
                           <input
                             type="text"
                             id="dobWithTitle"
                             class="form-control"
                             placeholder="Basnet"
                             name="last"
                           />
                         </div>
                       </div>

                       <div class="row g-2 mb-3">
                         <div class="col mb-0">
                           <label for="emailWithTitle" class="form-label">Email</label>
                           <input
                             type="text"
                             id="emailWithTitle"
                             class="form-control"
                             placeholder="xxxx@xxx.xx"
                             name="email"
                             required
                           />
                         </div>
                         <div class="col mb-0">
                           <label for="dobWithTitle" class="form-label"> Traffic Id </label>
                           <input
                             type="text"
                             id="dobWithTitle"
                             class="form-control"
                             name = "id"
                             required
                           />
                         </div>
                       </div>

                       <div class="row g-2">
                           <label for="dobWithTitle" class="form-label"> Password</label>
                           <input
                             type="text"
                             id="dobWithTitle"
                             class="form-control"
                             placeholder="xxxxxxx"
                             name = "password"
                             required
                           />
                       </div>
                     </div>
                     <div class="modal-footer">
                       <button type="submit" name="create" class="btn btn-primary">Save changes</button>
                     </div>
                   </div>
                 </div>
               </div>

             </form>

             <?php

             if(!empty($error_status)):

               echo "
               <div class='alert alert-".$color_status." alert-dismissible' role='alert'>
                 ".$error_status."
                 <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
               </div>
               ";

             endif;
             ?>


               <!-- Bordered Table -->
               <div class="card">
                 <div class="card-body">
                    <button type="button" class="btn btn-primary mb-4"   data-bs-toggle="modal"
                      data-bs-target="#modalCenter">
                            <i class='tf-icons bx bx-add-to-queue'></i>&nbsp; Add Account
                    </button>
                   <div class="table-responsive text-nowrap">
                     <table class="table table-bordered">
                       <thead>
                         <tr>
                           <th>&nbsp;&nbsp;&nbsp; Unique id</th>
                           <th> Email</th>
                           <th> Username </th>
                           <th>Status</th>
                           <th>Operations</th>
                         </tr>
                       </thead>
                       <tbody>
                         <?php
                           $obj = new ManageAccounts();
                           $result = $obj->getAccounts();
                           while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <form method="post" action="edit.php">
                            <tr>
                              <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <?php echo $row['traffic_id']; ?></td>
                              <td> <?php echo $row['email']; ?> </td>
                              <td> <?php echo $row['firstname']." ".$row['lastname'];  ?> </td>
                              <td><span class="badge bg-label-<?php if($row['account_status'] == 1){echo "success";} else{echo "danger";} ?> me-1"> <?php if($row['account_status'] == 1){echo "Active";} else{echo "Disable";} ?></span></td>
                              <td>
                              <button type="submit" class="btn btn-primary" data-bs-toggle="modal" name='tid' data-bs-target="#basicModal" value='<?php echo $row['traffic_id'];?>'>
                                <i class='tf-icons bx bx-edit-alt'></i>&nbsp; Edit
                              </button>
                            </td>
                          </tr>
                        </form>
                          <?php
                            }
                          ?>
                       </tbody>
                     </table>
                   </div>
                 </div>
               </div>
               <!--/ Bordered Table -->

             <div class="content-backdrop fade"></div>
           </div>
           <!-- Content wrapper -->
         </div>
         <!-- / Layout page -->
       </div>

       <!-- Overlay -->
       <div class="layout-overlay layout-menu-toggle"></div>
     </div>
     <!-- / Layout wrapper -->
     <!-- Core JS -->
     <!-- build:js assets/vendor/js/core.js -->
     <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
     <script src="../../assets/vendor/libs/popper/popper.js"></script>
     <script src="../../assets/vendor/js/bootstrap.js"></script>
     <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

     <script src="../../assets/vendor/js/menu.js"></script>
     <!-- endbuild -->

     <!-- Vendors JS -->

     <!-- Main JS -->
     <script src="../../assets/js/main.js"></script>

     <!-- Page JS -->

     <!-- Place this tag in your head or just before your close body tag. -->
     <script async defer src="https://buttons.github.io/buttons.js"></script>
   </body>
 </html>
