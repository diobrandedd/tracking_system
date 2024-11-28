<?php
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "
    SELECT tracking_num, delivery_address, recipient_name, recipient_num, sender_name, 
           package_weight, current_location, estimated_delivery, delivery_status, updated_at, company_name
    FROM packages";

$stmt = $conn->prepare($sql);

if (!$stmt->execute()) {
    echo "Error executing query: " . $stmt->error;
    exit();
}

$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "No packages found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Package Delivery History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #81cb71;">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="dashboard.php">Power Puff Dashboard</a>
    </div>
</nav>


<div class="container mt-5">
    <h2 class="text-center" id="textstyle">Package Delivery History</h2>
    <div class="table-responsive">
        <table id="packageHistory" class="table table-bordered table-striped">
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
                    <th>Company Name</th>
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
                        <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#packageHistory').DataTable();
    });
</script>

</body>
</html>