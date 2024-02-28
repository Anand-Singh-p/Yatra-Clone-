<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Include the database connection file
include "db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);

// Extract cancellation details
$userID = $data['userID'];
$ticketID = $data['ticketID'];

try {
    // Check if the connection is established
    if ($conn) {
        // Update ticket status to 'available'
        $updateTicket = "UPDATE AvailableTickets SET Status = 'available' WHERE TicketID = ?";
        $stmt = $conn->prepare($updateTicket);
        $stmt->execute([$ticketID]);

        // Update booking status to 'cancelled'
        $updateBooking = "UPDATE BookingHistory SET Status = 'cancelled' WHERE UserID = ? AND TicketID = ?";
        $stmt = $conn->prepare($updateBooking);
        $stmt->execute([$userID, $ticketID]);

        echo json_encode(['status' => 'success', 'message' => 'Ticket cancelled successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Ticket cancellation failed.', 'error' => $e->getMessage()]);
}
?>
