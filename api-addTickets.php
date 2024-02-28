<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Include the database connection file
include "db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);

// Extract ticket details
$ticketType = $data['ticketType'];
$date = $data['date'];

try {
    // Check if the connection is established
    if ($conn) {
        // Insert available ticket into the database
        $insertTicket = "INSERT INTO AvailableTickets (TicketType, Date, Status) VALUES (?, ?, 'available')";
        $stmt = $conn->prepare($insertTicket);
        $stmt->execute([$ticketType, $date]);

        echo json_encode(['status' => 'success', 'message' => 'Ticket added successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Ticket addition failed.', 'error' => $e->getMessage()]);
}
?>
