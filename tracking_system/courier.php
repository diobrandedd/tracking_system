<?php include 'connection.php'; ?>

<?php
//if ($_SESSION['position'] !== 'courier') {
//    header("Location:login.php");
//    exit();
//}
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$company_name = $_SESSION['company_name'];
$default_record_status = "A";

if (isset($_POST['add_package'])) {
  $tracking_num = $_POST['tracking_num'];
  $delivery_address = $_POST['delivery_address'];
  $recipient_name = $_POST['recipient_name'];
  $recipient_num = $_POST['recipient_num'];
  $sender_name = $_POST['sender_name'];
  $sender_email = $_POST['sender_email'];
  $sender_num = $_POST['sender_num'];
  $package_weight = $_POST['package_weight'];
  $current_location = $_POST['current_location'];
  $estimated_delivery = $_POST['estimated_delivery'];

  // Insert into packages table
  $sql = "INSERT INTO packages 
          (tracking_num, delivery_address, recipient_name, recipient_num, sender_name, sender_email, sender_num, package_weight, current_location, estimated_delivery, company_name, record_status) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);

  if (!$stmt) {
      die("Prepare failed (packages): " . $conn->error);
  }

  $stmt->bind_param("ssssssssssss", $tracking_num, $delivery_address, $recipient_name, $recipient_num, $sender_name, $sender_email, $sender_num, $package_weight, $current_location, $estimated_delivery, $company_name, $default_record_status);

  if (!$stmt->execute()) {
      die("Execution failed (packages): " . $stmt->error);
  } else {
      echo "<script> alert('Package added successfully');</script>";
  }

  // Insert into tracking_updates table
  $sqls = "INSERT INTO tracking_updates (tracking_num, current_location_1, delivery_status) 
           VALUES (?, ?, ?)";
  $stmts = $conn->prepare($sqls);

  if (!$stmts) {
      die("Prepare failed (tracking_updates): " . $conn->error);
  }

  $delivery_status = "In Transit"; // Default status for new packages
  $stmts->bind_param("sss", $tracking_num, $current_location, $delivery_status);

  if (!$stmts->execute()) {
      die("Execution failed (tracking_updates): " . $stmts->error);
  } else {
      echo "<script> alert('Tracking update added successfully');</script>";
  }
}



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body >
<nav class="navbar" id="navitems">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <a class="navbar-brand" id="textstyle">
      <img src="./images/powerpuffboys.png" alt="Logo" width="100" height="60" class="d-inline-block align-text-top">
      Power Puff Tracking
    </a>
    <div class="d-flex align-items-center">
      <span class="navbar-text me-3" id="textstyle">Welcome, <?php echo htmlspecialchars($company_name); ?>!</span>
      <form class="d-flex" method="POST" action="logout.php">
        <button class="btn btn-outline-danger" type="submit">Log Out</button>
      </form>
    </div>
  </div>
</nav>
<ul class="nav nav-tabs" >
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Add Package</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="courier2.php">Update Package</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="history.php">History</a>
  </li>
</ul>
<div style="background-color: #98daf1;">
  <br><br>
<div class="addpackage"  id="formbg">
<h2 id="textstyle" style="text-align: center;">Add New Package</h2>
<br>
  <form method="POST">
    <label for="tracking_num" style="padding-right: 70px;" id="textstylelower" class="textpadding">Tracking Number:</label>
    <input type="text" name="tracking_num" required><br>

    <label for="delivery_address" style="padding-right: 73px;" id="textstylelower" class="textpadding">Delivery Address:</label>
    <input type="text" name="delivery_address" required><br>

    <label for="recipient_name" style="padding-right: 79px;" id="textstylelower" class="textpadding">Recipient Name:</label>
    <input type="text" name="recipient_name" required><br>

    <label for="recipient_num" style="padding-right: 4px;" id="textstylelower" class="textpadding">Recipient Contact Number:</label>
    <input type="text" name="recipient_num" required><br>

    <label for="sender_name" style="padding-right: 95px;" id="textstylelower" class="textpadding">Sender Name:</label>
    <input type="text" name="sender_name" required><br>

    <label for="sender_email" style="padding-right: 100px;" id="textstylelower" class="textpadding">Sender Email:</label>
    <input type="email" name="sender_email" required><br>

    <label for="sender_num" style="padding-right: 20px;" id="textstylelower" class="textpadding">Sender Contact Number:</label>
    <input type="text" name="sender_num" required><br>

    <label for="package_weight" style="padding-right: 47px;" id="textstylelower" class="textpadding">Package Weight (kg):</label>
    <input type="text" name="package_weight" required><br>

    <label for="current_location" style="padding-right: 73px;" id="textstylelower" class="textpadding">Current Location:</label>
    <input type="text" name="current_location" required><br>

    <label for="estimated_delivery"style="padding-right: 23px;" id="textstylelower" class="textpadding">Estimated Delivery Date:</label>
    <input type="date" name="estimated_delivery" required><br><br>

    <input type="submit" name="add_package" value="Add Package" class="btn btn-success">
</form>
</div>
<br><br><br><br><br>
</div>

<style type="text/css">
.addpackage{
  padding: 5%;
  max-width: fit-content;
  margin-left: auto;
  margin-right: auto;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  width: 1000px;
  border-radius: 30px;
}
#formbg{
  background-color: #e78c89;
}
#navitems{
  background-color: #81cb71;
}
#textstyle{
    font-size: 35px; 
    font-weight: bold; 
    color: white;
    text-shadow: 2px 0 #000, -2px 0 #000, 0 2px #000, 0 -2px #000,
               1px 1px #000, -1px -1px #000, 1px -1px #000, -1px 1px #000; 
}
#textstylelower{
    font-size: 16px; 
    color: white;
    text-shadow: 1px 0 #000, -1px 0 #000, 0 1px #000, 0 -1px #000,
               1px 1px #000, -1px -1px #000, 1px -1px #000, -1px 1px #000; 
}
.textpadding{
  padding-bottom: 10px;
}


</style>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>