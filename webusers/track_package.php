<?php
include '../connection.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if a tracking number is provided
if (!isset($_GET['tracking_num']) || empty($_GET['tracking_num'])) {
    die("<p>No tracking number provided. Please go back and enter a tracking number.</p>");
}

$tracking_num = $_GET['tracking_num'];

// Query the database for the package details and delivery status
$sql = "
    SELECT tracking_num, company_name, delivery_address, recipient_name, recipient_num, 
           sender_name, package_weight, current_location, estimated_delivery, delivery_status, updated_at 
    FROM packages 
    WHERE tracking_num = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tracking_num);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("<p>No package found with the tracking number '$tracking_num'. Please try again.</p>");
}

$package = $result->fetch_assoc();

// Query for tracking updates
$sqlUpdates = "
    SELECT current_location_1, current_location_2, current_location_3, delivery_status, updated_at 
    FROM tracking_updates 
    WHERE tracking_num = ?";
$stmtUpdates = $conn->prepare($sqlUpdates);
$stmtUpdates->bind_param("s", $tracking_num);
$stmtUpdates->execute();
$updates = $stmtUpdates->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Package</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <style>
        .navbar {
            background-color: rgb(231, 140, 137);
        }
        .navbar-brand {
            font-weight: bolder;
            color: white;
        }
        .nav-link {
            color: white;
        }
        .nav-link:hover {
            color: #ffd700;
        }
        .progress-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 20px;
            padding: 20px;
        }
        .progress-box {
            width: 200px;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 16px;
            background-color: #f8f9fa;
            border: 2px solid #28a745;
            border-radius: 10px;
            padding: 15px;
        }
        .progress-box i {
            font-size: 50px;
            margin-bottom: 10px;
            color: #28a745;
        }
        .progress-completed {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a href="index.php" class="navbar-brand">POWERPUFF BOYS EXPRESS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a href="index.php" class="nav-link">HOME</a></li>
                <li class="nav-item"><a href="contact.html" class="nav-link">CONTACT US</a></li>
                <li class="nav-item"><a href="about.html" class="nav-link">ABOUT US</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <!-- Package Information -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3>Package Details</h3>
        </div>
        <div class="card-body">
            <p><strong>Tracking Number:</strong> <?php echo htmlspecialchars($package['tracking_num']); ?></p>
            <p><strong>Company Name:</strong> <?php echo htmlspecialchars($package['company_name']); ?></p>
            <p><strong>Recipient Name:</strong> <?php echo htmlspecialchars($package['recipient_name']); ?></p>
            <p><strong>Recipient Contact:</strong> <?php echo htmlspecialchars($package['recipient_num']); ?></p>
            <p><strong>Sender Name:</strong> <?php echo htmlspecialchars($package['sender_name']); ?></p>
            <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($package['delivery_address']); ?></p>
            <p><strong>Package Weight:</strong> <?php echo htmlspecialchars($package['package_weight']); ?> kg</p>
            <p><strong>Estimated Delivery:</strong> <?php echo htmlspecialchars($package['estimated_delivery']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($package['delivery_status']); ?></p>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="progress-container">
        <!-- Box 1 -->
        <div class="progress-box">
            <i class="fas fa-box"></i>
            <p><strong>Added</strong></p>
            <p>Current Location: <?php echo htmlspecialchars($package['current_location']); ?></p>
        </div>

        <!-- Box 2 -->
        <div class="progress-box <?php echo !empty($updates['current_location_1']) ? 'progress-completed' : ''; ?>">
            <i class="fas fa-truck"></i>
            <p><strong>In Transit</strong></p>
            <p>Current Location: <?php echo htmlspecialchars($updates['current_location_1'] ?? 'Pending'); ?></p>
        </div>

        <!-- Box 3 -->
        <div class="progress-box <?php echo !empty($updates['current_location_2']) ? 'progress-completed' : ''; ?>">
            <i class="fas fa-truck"></i>
            <p><strong>On Delivery</strong></p>
            <p>Current Location: <?php echo htmlspecialchars($updates['current_location_2'] ?? 'Pending'); ?></p>
        </div>

        <!-- Box 4 -->
        <div class="progress-box <?php echo $package['delivery_status'] === 'Delivered' ? 'progress-completed' : ''; ?>">
            <i class="fas fa-home"></i>
            <p><strong>Delivered</strong></p>
            <p>Current Location: <?php echo htmlspecialchars($updates['current_location_3'] ?? 'Pending'); ?></p>
        </div>
    </div>

    <a href="index.php" class="btn btn-secondary mt-3">Back to Home</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
