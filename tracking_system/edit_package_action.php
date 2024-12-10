<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tracking_num = $_POST['tracking_num'];
    $delivery_address = $_POST['delivery_address'];
    $recipient_name = $_POST['recipient_name'];
    $recipient_num = $_POST['recipient_num'];
    $current_location = $_POST['current_location'];
    $delivery_status = $_POST['delivery_status'];
    $estimated_delivery = $_POST['estimated_delivery'];

    $sql = "UPDATE packages 
            SET delivery_address = ?, recipient_name = ?, recipient_num = ?, 
                current_location = ?, delivery_status = ?, estimated_delivery = ?, updated_at = NOW() 
            WHERE tracking_num = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssss",
        $delivery_address, $recipient_name, $recipient_num, 
        $current_location, $delivery_status, $estimated_delivery, $tracking_num
    );

    if ($stmt->execute()) {
        echo "<script>alert('Package updated successfully!'); window.location.href='manage_package.php';</script>";
    } else {
        echo "<script>alert('Failed to update package.'); window.location.href='manage_package.php';</script>";
    }
}
?>
