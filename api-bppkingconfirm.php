<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Include the database connection file
include "db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);

// Extract booking details
$userID = $data['userID'];
$ticketID = $data['ticketID']; //  we have the ticket ID from available tickets
$ticketType = $data['ticketType'];

try {
    // Check if the connection is established
    if ($conn) {
        // Update ticket status to 'booked'
        $updateTicket = "UPDATE AvailableTickets SET Status = 'booked' WHERE TicketID = ?";
        $stmt = $conn->prepare($updateTicket);
        $stmt->execute([$ticketID]);

        // Insert booking details into the BookingHistory table
        $insertBooking = "INSERT INTO BookingHistory (UserID, TicketType, Date) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($insertBooking);
        $stmt->execute([$userID, $ticketType]);

        echo json_encode(['status' => 'success', 'message' => 'Ticket booked successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Ticket booking failed.', 'error' => $e->getMessage()]);
}
?>
