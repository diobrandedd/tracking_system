<?php

include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "
    SELECT tracking_num, company_name, delivery_address, recipient_name, recipient_num, sender_name, 
           package_weight, current_location, estimated_delivery, delivery_status, updated_at 
    FROM packages 
    WHERE record_status = 'I'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleted Packages</title>
    <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #81cb71;">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="dashboard.php">Power Puff Dashboard</a>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4">Deleted Packages</h2>
    <div class="table-responsive">
    <table id="deletedPackagesTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Tracking Number</th>
            <th>Company Name</th>
            <th>Delivery Address</th>
            <th>Recipient Name</th>
            <th>Recipient Contact</th>
            <th>Sender Name</th>
            <th>Package Weight</th>
            <th>Current Location</th>
            <th>Estimated Delivery</th>
            <th>Status</th>
            <th>Last Updated</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['tracking_num']); ?></td>
                <td><?php echo htmlspecialchars($row['company_name']); ?></td>
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#deletedPackagesTable').DataTable();
    });
</script>
</body>
</html>
