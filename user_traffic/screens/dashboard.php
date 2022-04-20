<?php

    session_start();
    include("../../DBM/getConnection.php");

    $error_status = "";
    $color_status = "";
    $challan_status = "";
    $data = array();


  class CreateChallan{

      function __construct(){

        $object = new Connection();
        $this->conn = $object->getConnection("echallan");

      }

      function challanGenerator($chars){
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, $chars);
      }

      function create($liscence, $plate, $name, $cause, $phone, $date, $time, $traffic, $amount){

        $generate = new CreateChallan();
        $challanId =  $generate->challanGenerator(7);
        $sql = "INSERT INTO `challan`(`challan_id`, `license_number`, `vehicle_number`, `user_name`, `cause`, `traffic_id`, `time_stamp`, `date_time`, `charge`) VALUES ('$challanId','$liscence','$plate','$name','$cause','$traffic','$time','$date','$amount')";
        if($this->conn->query($sql)){
            return true;
        }
        else{
            return false;
        }

      }

      function previewChallan($liscence){

        $sql = "SELECT * FROM `challan` WHERE license_number = '$liscence'";
        $result = $this->conn->query($sql);
        $row = mysqli_fetch_array($result);
        return $row;
    }

  }

  if(isset($_POST['create'])){

      $create = new CreateChallan();
      $bool = $create->create($_POST['liscence'], $_POST['plate'], $_POST['name'], $_POST['cause'], $_POST['phone'], $_POST['date'], $_POST['time'], $_POST['id'], $_POST['amount']);
      if($bool){
        $data = $create->previewChallan($_POST['liscence']);
        $error_status = "Operation Sucessful";
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

    <title>Dashboard - Traffic Account</title>

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
    <link rel="stylesheet" href="../../assets/css/demo.css"/>

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
                    <li class="menu-item active">
                      <a href="http://localhost/E-Challan/user_traffic/screens/dashboard.php" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                      </a>
                    </li>


                    <!-- Dashboard -->
                    <li class="menu-item">
                      <a href="http://localhost/E-Challan/user_traffic/screens/history.php" class="menu-link">
                        <i class='menu-icon bx bx-history' ></i>
                        <div data-i18n="Analytics">History</div>
                      </a>
                    </li>


                    <!-- Dashboard -->
                    <li class="menu-item">
                      <a href="" class="menu-link">
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

              <ul class="navbar-nav flex-row align-items-center ms-auto">

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="../../images/profile_icon.webp" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="http://localhost/E-Challan/user_traffic/authentication/Logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>



          <!-- / Navbar -->

          <form method="post">
          <!-- Content wrapper -->
          <div class="content-wrapper">

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
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
              <!-- Basic Layout -->
              <div class="row">
                <div class="col-xl">
                  <div class="card mb-4">
                    <div class="card-body">
                      <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Liscence</label>
                        <div class="col-md-10">
                          <input class="form-control" type="text" name="liscence" id="html5-text-input" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-search-input" class="col-md-2 col-form-label">Plate No</label>
                        <div class="col-md-10">
                          <input class="form-control" type="search"  name="plate" id="html5-search-input" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-email-input" class="col-md-2 col-form-label">Name</label>
                        <div class="col-md-10">
                          <input class="form-control" type="text" name="name"  id="html5-email-input" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-url-input" class="col-md-2 col-form-label">Cause</label>
                        <div class="col-md-10">
                          <input
                            class="form-control"
                            type="text"
                            name = "cause"
                            id="html5-url-input"
                          />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-tel-input" class="col-md-2 col-form-label">Phone</label>
                        <div class="col-md-10">
                          <div class="input-group input-group-merge">
                            <span class="input-group-text">Nepal (+977)</span>
                            <input
                              type="text"
                              id="phoneNumber"
                              name="phone"
                              class="form-control"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-date-input" class="col-md-2 col-form-label">Date</label>
                        <div class="col-md-10">
                          <input class="form-control" name="date" type="date"/>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-time-input" class="col-md-2 col-form-label">Time</label>
                        <div class="col-md-10">
                          <input class="form-control" name="time" type="time"  />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-email-input" class="col-md-2 col-form-label">Traffic Id</label>
                        <div class="col-md-10">
                          <!-- value="<?php echo $_SESSION['islogged']; ?>" -->
                          <input class="form-control" type="text" name="id"  id="html5-email-input"/>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-email-input" class="col-md-2 col-form-label">Amount</label>
                        <div class="col-md-10">
                          <div class="input-group input-group-merge">
                            <span class="input-group-text">Rs</span>
                            <input
                              type="text"
                              id="amount"
                              name="amount"
                              class="form-control"
                            />
                          </div>
                        </div>
                      </div>

                      <div class="demo-inline-spacing">
                        <button type="submit" name="create" class="btn btn-primary">
                          <span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; Create Challan
                        </button>
                      </div>

                    </form>

                    </div>
                  </div>
                </div>
                <div class="col-xl">
                  <div class="card">
                    <div class="card-body mb-5">

                      <div style="color: #333; height: 100%; width: 100%;" height="100%" width="100%">
                            <table  cellspacing="0" style="border-collapse: collapse; padding: 40px; width: 100%;" width="100%">
                              <tbody>
                                  <tr>
                                    <td width="5px" style="padding: 0;"></td>
                                      <td style="clear: both; display: block; margin: 0 auto; max-width: 600px; padding: 10px 0px; margin-bottom:6px;">
                                          <table width="100%" cellspacing="0" style="border-collapse: collapse;">
                                              <tbody>
                                                  <tr>
                                                      <td style="padding: 3px;">

                                                        <div class="app-brand demo mb-1">
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
                                                            <span class="app-brand-text demo  fw-bolder ms-2 text-dark">E-Challan</span>
                                                          </a>

                                                          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                                                            <i class="bx bx-chevron-left bx-sm align-middle"></i>
                                                          </a>
                                                        </div>

                                                      </td>
                                                      <td style="font-size: 15px; color: #000; padding: 0; text-align: right;" align="right">
                                                          <?php if($data){ echo $data[5];} else{echo "xxxxx";} ?>
                                                      </td>
                                                  </tr>
                                              </tbody>
                                          </table>
                                      </td>
                                      <td width="5px" style="padding: 0;"></td>
                                  </tr>

                                  <tr>
                                      <td width="5px" style="padding: 0;"></td>
                                      <td bgcolor="#FFFFFF" style="border: 1px solid #a4aeba; clear: both; display: block; margin: 0 auto; max-width: 600px; padding: 0;">
                                          <table width="100%" style="background: #f9f9f9; border-bottom: 1px solid #eee; border-collapse: collapse; color: #999;">
                                              <tbody>
                                                  <tr>
                                                      <td width="50%" style="padding: 20px;"><strong style="color: #333; font-size: 24px;">रु <?php if($data){ echo $data[7];} else{echo "xxxxx";} ?></strong> due</td>
                                                      <td align="right" width="50%" style="padding: 20px;"><span class="il"><?php if($data){ echo $data[0];} else{echo "xxxxx";} ?></span></td>
                                                  </tr>
                                              </tbody>
                                          </table>
                                      </td>
                                      <td style="padding: 0;"></td>
                                      <td width="5px" style="padding: 0;"></td>
                                  </tr>
                                  <tr>
                                    <tr>
                              <td width="5px" style="padding: 0;"></td>
                              <td style="border: 1px solid #a4aeba; border-top: 0; clear: both; display: block; margin: 0 auto; max-width: 600px; padding: 0;">
                                  <table cellspacing="0" style="border-collapse: collapse; border-left: 1px solid #a4aeba; margin: 0 auto; max-width: 600px;">
                                      <tbody>
                                          <tr>
                                              <td valign="top"  style="padding: 20px;">
                                                  <h3
                                                      style="
                                                          border-bottom: 2px solid #000;
                                                          color: #000;
                                                          font-size: 18px;
                                                          line-height: 1.2;
                                                          margin: 0;
                                                          margin-bottom: 15px;
                                                          padding-bottom: 5px;
                                                      "
                                                  >
                                                      Summary
                                </h3>


                                <?php




                                 ?>
                                <table cellspacing="0" style="border-collapse: collapse; margin-bottom: 40px;">
                                    <tbody>
                                        <tr>
                                            <td style="padding: 5px 0;">Liscence Number: &emsp;&emsp;</td>
                                            <td align="right" style="padding: 5px 0;"><?php if($data){ echo $data[0];} else{echo "xxxxx";} ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px 0;">Vehicle No. Plate:</td>
                                            <td align="right" style="padding: 5px 0;"><?php if($data){ echo $data[1];} else{echo "xxxxx";} ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px 0;"> Name: </td>
                                            <td align="right" style="padding: 5px 0;"><?php if($data){ echo $data[3];} else{echo "xxxxx";} ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px 0;"> Challan Cause: </td>
                                            <td align="right" style="padding: 5px 0;"><?php if($data){ echo $data[8];} else{echo "xxxxx";} ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border-bottom: 2px solid #000; border-top: 2px solid #000; color: #000; padding: 5px 0;">Amount</td>
                                            <td align="right" style="border-bottom: 2px solid #000; border-top: 2px solid #000; color: #000; padding: 5px 0;">रु <?php if($data){ echo $data[7];} else{echo "xxxxx";} ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td width="5px" style="padding: 0;"></td>
        </tr>
                                  </tr>
                                  <tr>
                                      <td width="5px" style="padding: 0;"></td>
                                      <td bgcolor="#FFFFFF" style="border-left:1px solid #a4aeba;border-right:1px solid #a4aeba; clear: both; display: block; margin: 0 auto; max-width: 600px; padding: 0;">
                                          <table width="100%" style="background: #f9f9f9; border-collapse: collapse; color: #999;">
                                              <tbody>
                                                  <tr>
                                                      <td width="50%" style="padding: 20px;"></td>
                                                      <td align="right" width="50%" style="padding: 20px;"><span class="il"> <button type="button" class="btn btn-primary"> <i class='bx bxs-download'></i> Download </button></span></td>
                                                  </tr>
                                              </tbody>
                                          </table>
                                      </td>
                                      <td style="padding: 0;"></td>
                                      <td width="5px" style="padding: 0;"></td>
                                  </tr>
                              </tbody>
                            </table>


                            </div>
                        </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
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
