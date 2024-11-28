<?php
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$company_name = $_SESSION['company_name'];

// Fetch all package data
$sql = "
    SELECT tracking_num, delivery_address, recipient_name, recipient_num, sender_name, 
           package_weight, current_location, estimated_delivery, delivery_status, updated_at
    FROM packages 
    WHERE company_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $company_name);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delivery History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
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
    <a class="nav-link" href="courier2.php">Update Package</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">History</a>
  </li>
</ul>
<div style="background-color: #98daf1;">
<br>
<div class="container mt-5" id="history">
    <h2 class="text-center" id="textstyle">Delivery History</h2>

    <div class="table-responsive">
        <table id="deliveryHistory" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tracking Number</th>
                    <th>Delivery Address</th>
                    <th>Recipient Name</th>
                    <th>Recipient Contact</th>
                    <th>Sender Name</th>
                    <th>Package Weight (kg)</th>
                    <th>Current Location</th>
                    <th>Estimated Delivery Date</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['tracking_num']); ?></td>
                        <td><?php echo htmlspecialchars($row['delivery_address']); ?></td>
                        <td><?php echo htmlspecialchars($row['recipient_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['recipient_num']); ?></td>
                        <td><?php echo htmlspecialchars($row['sender_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['package_weight']); ?></td>
                        <td><?php echo htmlspecialchars($row['current_location']); ?></td>
                        <td><?php echo htmlspecialchars($row['estimated_delivery']); ?></td>
                        <td><?php echo htmlspecialchars($row['delivery_status']); ?></td>
                        <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
    </div>
</div>
<br><br><br><br><br><br>
</div>

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
        #history {
            padding: 5%;
            max-width: fit-content;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            width: 1200px;
            border-radius: 30px;
            background-color: #e78c89; /* Match the background color */
        }
    </style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#deliveryHistory').DataTable();
    });
</script>
</body>
</html>