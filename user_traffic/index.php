<?php


include("./traffic_functions.php");


error_reporting(0);

if (isset($_POST['submit'])) {

  $traffic = new Traffic();
  $traffic->createChallan($_POST['challan_id'], $_POST['liscence'], $_POST['vehicle_num'], $_POST['username'], $_POST['traffic_id']);

  $text = "Challan Created";

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="traffic_Panel.css" />
  <script src="https://kit.fontawesome.com/8b955d5b9e.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="header"></div>

  <div class="sidebar">
    <h2 class="challanLogo">Logo</h2>
    <button id="dashboard-btn">Dashboard</button>
    <button id="history-btn">History</button>
    <button id="logout-btn"> <a href="./logout.php">Log Out </a> </button>
  </div>

  <div class="form">

    <form method="post">

      <label>Challan ID</label>
      <input id="challan-id" type="text" placeholder="Challan ID" name="challan_id" required />
      <label>License</label>
      <input id="opd-num" type="text" placeholder="License Number" name="liscence" required />
      <label>Vehicle number:</label>
      <input id="vehicle-number" type="text" placeholder="Vehicle Number" name="vehicle_num" required />
      <label>Username</label>
      <input id="username" type="text" placeholder="Username" name="username" required />
      <label>Traffic ID:</label>
      <input id="traffic-id" type="text" placeholder="Traffic ID" name="traffic_id" required />
      <input id="submitData" type="submit" name="submit" value="Save Data" />

      <div>

          <?php echo $text; ?>

      </div>

    </form>
  </div>
  <script src="index.js"></script>
</body>

</html>