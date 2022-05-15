<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Dashboard - User Panel</title>

    <link rel="stylesheet" href="./dist/assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./dist/assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="./dist/assets/modules/bootstrap-social/bootstrap-social.css">

    <link rel="stylesheet" href="./dist/assets/css/style.css">
    <link rel="stylesheet" href="./dist/assets/css/components.css">
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
                <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
            </nav>

            <nav class="navbar navbar-secondary navbar-expand-lg">
                <div class="container">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a href="http://localhost/cms/index.php" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="http://localhost/cms/find.php" class="nav-link"><i class="fas fa-newspaper"></i><span> Find Challan </span></a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">

            <div class="row">
                <div class="col-12 mb-4">
                <div class="hero text-white hero-bg-image" style="background-image: url('./dist/assets/img/challan/traffic.png');">
                  <div class="hero-inner text-center">
                    <h2>Welcome!</h2>
                    <p class="lead">  Want to pay your challan? Find you Challan Online.</p>
                    <div class="mt-4">
                      <a href="http://localhost/cms/find.php" class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="far fa-user"></i> Find Challan </a>
                    </div>
                  </div>
                </div>
              </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators3" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators3" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators3" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="./dist/assets/img/challan/traffic3.jpg" height="500" alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="./dist/assets/img/challan/traffic2.jpg" height="500" alt="Second slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="./dist/assets/img/challan/traffic1.jpg" height="500" alt="Third slide">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators3" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators3" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>

               

            </div>
        </div>
    </div>


    <footer class="main-footer">
        <div class="text-center mb-5">
            <div class="font-weight-bold mb-3"> Follow For Updates </div>
            <a href="https://www.facebook.com/ktmtraffic/" class="btn btn-social-icon btn-facebook mr-1">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com/nepaltraffic" class="btn btn-social-icon btn-twitter mr-1">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://www.instagram.com/nepalpolice/?hl=en" class="btn btn-social-icon btn-instagram">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
        <div class="footer text-center">
            Copyright &copy; 2020 <div class="bullet"></div> Design By Group 2
        </div>

    </footer>

    <!-- General JS Scripts -->
    <script src="./dist/assets/modules/jquery.min.js"></script>
    <script src="./dist/assets/modules/popper.js"></script>
    <script src="./dist/assets/modules/tooltip.js"></script>
    <script src="./dist/assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="./dist/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="./dist/assets/modules/moment.min.js"></script>
    <script src="./dist/assets/js/stisla.js"></script>
    <script src="./dist/assets/js/scripts.js"></script>
    <script src="./dist/assets/js/custom.js"></script>
</body>

</html>