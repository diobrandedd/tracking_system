<?php
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['tracking_num'])) {
    $tracking_num = urlencode($_GET['tracking_num']);
    header("Location: update_package.php?tracking_num=$tracking_num");
    exit();
}

// Fetch all packages
$sql = "
    SELECT tracking_num, delivery_address, recipient_name, recipient_num, sender_name, 
           package_weight, current_location, estimated_delivery, delivery_status, updated_at
    FROM packages WHERE record_status = 'A'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Packages</title>
    <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #81cb71;">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="dashboard.php">Power Puff Dashboard</a>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4">Manage Packages</h2>

    <!-- Add Package Button -->
    <div class="mb-3">
        <a href="add_package.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Package</a>
    </div>

    <!-- Package Table -->
    <div class="table-responsive">
        <table id="packageTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tracking Number</th>
                    <th>Delivery Address</th>
                    <th>Recipient Name</th>
                    <th>Recipient Contact</th>
                    <th>Sender Name</th>
                    <th>Package Weight</th>
                    <th>Current Location</th>
                    <th>Estimated Delivery</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
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
                        <td>
                            <a href="update_package.php?tracking_num=<?php echo urlencode($row['tracking_num']); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <a href="delete_package.php?tracking_num=<?php echo urlencode($row['tracking_num']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this package?');"><i class="fas fa-trash"></i> Delete</a>
                        </td>
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
        $('#packageTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true
        });
    });
</script>
</body>
</html>
