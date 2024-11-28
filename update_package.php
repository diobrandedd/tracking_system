<?php 
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Ensure company_name is defined
$company_name = isset($_SESSION['company_name']) ? $_SESSION['company_name'] : '';

// Check if tracking number is provided
if (isset($_GET['tracking_num'])) {
    $tracking_num = $_GET['tracking_num'];

    // Fetch the package details using the tracking number
    $sql = "SELECT * FROM packages WHERE tracking_num = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tracking_num);
    $stmt->execute();
    $result = $stmt->get_result();
    $package = $result->fetch_assoc();

    if (!$package) {
        echo "Package not found!";
        exit();
    }
} else {
    echo "No tracking number provided!";
    exit();
}

// Handle form submission for updating the package
if (isset($_POST['update_package'])) {
    $current_location = $_POST['current_location'];
    $delivery_status = $_POST['delivery_status'];
    $estimated_delivery = $_POST['estimated_delivery'];

    // Update the package details in the database
    $sql = "UPDATE packages SET current_location = ?, delivery_status = ?, estimated_delivery = ?, updated_at = NOW() WHERE tracking_num = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $current_location, $delivery_status, $estimated_delivery, $tracking_num);
    $stmt->execute();

    echo "<script>alert('Package updated successfully!');</script>";
    header("Location: courier2.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Package</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #navitems {
            background-color: #81cb71;
        }
        #textstyle {
            font-size: 35px;
            font-weight: bold;
            color: white;
            text-shadow: 2px 0 #000, -2px 0 #000, 0 2px #000, 0 -2px #000,
                        1px 1px #000, -1px -1px #000, 1px -1px #000, -1px 1px #000; 
        }
        #update {
            padding: 5%;
            max-width: fit-content;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            width: 600px;
            border-radius: 30px;
            background-color: #e78c89; /* Match the background color */
        }
    </style>
</head>
<body>
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
    <a class="nav-link" href="courier.php">Add Package</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Update Package</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="history.php">Package History</a>
  </li>
</ul>
<div style="background-color: #98daf1;">
<br><br>
<div id="update">
  <h2>Update Package Details</h2>
  <form method="POST" action="">
  <div class="mb-3">
            <label for="tracking_num" class="form-label">Tracking Number:</label>
            <input type="text" class ="form-control" id="tracking_num" name="tracking_num" value="<?php echo htmlspecialchars($package['tracking_num']); ?>" readonly>
        </div>
    <div class="mb-3">
      <label for="current_location" class="form-label">Current Location</label>
      <input type="text" class="form-control" id="current_location" name="current_location" required>
    </div>
    <div class="mb-3">
      <label for="delivery_status" class="form-label">Delivery Status</label>
      <input type="text" class="form-control" id="delivery_status" name="delivery_status" required>
    </div>
    <div class="mb-3">
      <label for="estimated_delivery" class="form-label">Estimated Delivery Date</label>
      <input type="date" class="form-control" id="estimated_delivery" name="estimated_delivery" required>
    </div>
    <button type="submit" name="update_package" class="btn btn-primary">Update Package</button>
  </form>
</div>
<br><br><br><br><br><br>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>