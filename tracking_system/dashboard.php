<?php
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];


$sqlTotal = "SELECT COUNT(*) AS total FROM packages";
$resultTotal = $conn->query($sqlTotal);
$totalPackages = $resultTotal->fetch_assoc()['total'];


$sqlDelivered = "SELECT COUNT(*) AS delivered FROM packages WHERE delivery_status = 'Delivered'";
$resultDelivered = $conn->query($sqlDelivered);
$deliveredPackages = $resultDelivered->fetch_assoc()['delivered'];


$sqlPending = "SELECT COUNT(*) AS pending FROM packages WHERE delivery_status IN ('Pending', 'In Transit')";
$resultPending = $conn->query($sqlPending);
$pendingPackages = $resultPending->fetch_assoc()['pending'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            background-color: #81cb71;
            padding-top: 20px;
        }
        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 10px 15px;
            display: block;
            font-size: 16px;
        }
        .sidebar a:hover {
            background-color: #6aa85e;
        }
        .sidebar a.active {
            background-color: #4d8742;
            font-weight: bold;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #81cb71;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Power Puff Dashboard</a>
            <span class="navbar-text text-white">
                Welcome, <?php echo htmlspecialchars($username); ?>!
            </span>
        </div>
    </nav>

    <div class="sidebar">
        <a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
        <a href="manage_package.php"><i class="fas fa-box"></i> Manage Package</a>
        <a href="package_history.php"><i class="fas fa-history"></i> Delivery History</a>
        <a href="deleted_packages.php"><i class="fas fa-trash-alt"></i> Deleted Packages</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content">
        <h1>Dashboard</h1>
        <p>Welcome to the Power Puff Tracking System Dashboard.</p>

        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Packages</h5>
                        <p class="card-text"><?php echo $totalPackages; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Delivered Packages</h5>
                        <p class="card-text"><?php echo $deliveredPackages; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pending Packages</h5>
                        <p class="card-text"><?php echo $pendingPackages; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
