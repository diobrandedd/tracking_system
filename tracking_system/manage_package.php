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
    WHERE record_status = 'A'";

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
    <div class="table-responsive">
        <table id="packageTable" class="table table-bordered table-striped">
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
                    <th>Actions</th>
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
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-warning btn-sm" onclick="showEditModal(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <!-- Delete Button -->
                            <button class="btn btn-danger btn-sm" onclick="showDeleteModal('<?php echo $row['tracking_num']; ?>')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display: none; background: rgba(0, 0, 0, 0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; justify-content: center; align-items: center; z-index: 9999;">
    <div class="modal-content" style="background: white; padding: 20px; border-radius: 8px; width: 400px;">
        <h4>Edit Package</h4>
        <form id="editForm" method="POST" action="edit_package_action.php">
            <input type="hidden" name="tracking_num" id="editTrackingNum">
            <div class="mb-3">
                <label for="editDeliveryAddress" class="form-label">Delivery Address:</label>
                <input type="text" class="form-control" name="delivery_address" id="editDeliveryAddress" required>
            </div>
            <div class="mb-3">
                <label for="editRecipientName" class="form-label">Recipient Name:</label>
                <input type="text" class="form-control" name="recipient_name" id="editRecipientName" required>
            </div>
            <div class="mb-3">
                <label for="editRecipientNum" class="form-label">Recipient Contact:</label>
                <input type="text" class="form-control" name="recipient_num" id="editRecipientNum" required>
            </div>
            <div class="mb-3">
                <label for="editCurrentLocation" class="form-label">Current Location:</label>
                <input type="text" class="form-control" name="current_location" id="editCurrentLocation" required>
            </div>
            <div class="mb-3">
                <label for="editDeliveryStatus" class="form-label">Delivery Status:</label>
                <select class="form-select" name="delivery_status" id="editDeliveryStatus" required>
                    <option value="In Transit">In Transit</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="editEstimatedDelivery" class="form-label">Estimated Delivery:</label>
                <input type="date" class="form-control" name="estimated_delivery" id="editEstimatedDelivery" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <button type="button" class="btn btn-secondary" onclick="hideEditModal()">Cancel</button>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" style="display: none; background: rgba(0, 0, 0, 0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; justify-content: center; align-items: center; z-index: 9999;">
    <div class="modal-content" style="background: white; padding: 20px; border-radius: 8px; width: 400px;">
        <h4>Confirm Deletion</h4>
        <p>Are you sure you want to mark this package as inactive?</p>
        <button type="button" class="btn btn-secondary" onclick="hideDeleteModal()">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#packageTable').DataTable();
    });

    // Edit Modal Logic
    function showEditModal(packageData) {
        document.getElementById('editTrackingNum').value = packageData.tracking_num;
        document.getElementById('editDeliveryAddress').value = packageData.delivery_address;
        document.getElementById('editRecipientName').value = packageData.recipient_name;
        document.getElementById('editRecipientNum').value = packageData.recipient_num;
        document.getElementById('editCurrentLocation').value = packageData.current_location;
        document.getElementById('editDeliveryStatus').value = packageData.delivery_status;
        document.getElementById('editEstimatedDelivery').value = packageData.estimated_delivery;
        document.getElementById('editModal').style.display = 'flex';
    }

    function hideEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Delete Modal Logic
    let currentTrackingNum = "";

    function showDeleteModal(trackingNum) {
        currentTrackingNum = trackingNum;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function hideDeleteModal() {
        currentTrackingNum = "";
        document.getElementById('deleteModal').style.display = 'none';
    }

    document.getElementById("confirmDeleteBtn").addEventListener("click", () => {
        if (currentTrackingNum) {
            fetch("delete_package_action.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ tracking_num: currentTrackingNum })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
            hideDeleteModal();
        }
    });
</script>
</body>
</html>
