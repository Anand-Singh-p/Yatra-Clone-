<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Include the database connection file
include "db_connection.php";

try {
    // Check if the connection is established
    if ($conn) {
        // Retrieve available tickets
        $getTickets = "SELECT * FROM AvailableTickets WHERE Status = 'available'";
        $stmt = $conn->query($getTickets);
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['status' => 'success', 'tickets' => $tickets]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to retrieve available tickets.', 'error' => $e->getMessage()]);
}
?>
