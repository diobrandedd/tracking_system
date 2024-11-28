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


if (isset($_POST['submit_tracking'])) {
    $tracking_num = $_POST['tracking_num'];

    //$courier = "SELECT * FROM packages WHERE "
    $sql = "SELECT * FROM packages WHERE tracking_num = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tracking_num);
    $stmt->execute();
    $result = $stmt->get_result();
    $package = $result->fetch_assoc();

    if ($package) {
        if ($package['company_name'] === $company_name) {
            header("Location: update_package.php?tracking_num=" . $tracking_num);
            exit();
        } else {
            echo "<script>alert('You do not have permission to update packages from other companies.');</script>";
        }
    } else {
        echo "<script>alert('Tracking number not found.');</script>";
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
<body>
 <a href=""></a>
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
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link"  aria-current="page" href="./courier.php">Add Package</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="#">Update Package</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="history.php">History</a>
  </li>
</ul>
<div style="background-color: #98daf1;">
  <br><br>
<div class="updatepackage" id="formbg">
<h2 id="textstyle">Enter Tracking Number To Update a Package</h2>
<br>
<form method="POST">
    <label for="tracking_num" id="textstylelower">Tracking Number:</label>
    <br>
    <input type="text" name="tracking_num" required size="94"><br>
    <br>
    <input type="submit" name="submit_tracking" value="Submit" class="btn btn-success">
</form>
</div>
<br><br><br><br><br><br>
</div>

<style type="text/css">
.updatepackage{
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
    font-size: 30px; 
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