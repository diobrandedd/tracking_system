<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $tracking_num = $data['tracking_num'] ?? '';

    if ($tracking_num) {
        // Update record_status to "I" (Inactive)
        $sql = "UPDATE packages SET record_status = 'I', updated_at = NOW() WHERE tracking_num = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $tracking_num);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Package marked as inactive."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to mark package as inactive."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid tracking number."]);
    }
}
?>
