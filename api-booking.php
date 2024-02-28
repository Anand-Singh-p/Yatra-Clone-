<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Include the database connection file
include "db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);
$userID = $data['userID'];
$userType = $data['userType']; //  we have the user type after login
$bookingType = $data['bookingType']; // Type can be 'self', 'family', or 'agent'
$ticketDetails = $data['ticketDetails']; //  we have details like ticket type
$travelers = $data['travelers']; // Array of traveler details for family booking

try {
    // Check if the connection is established
    if ($conn) {
        // Insert the ticket booking into the database
        $insertTicket = "INSERT INTO Ticket (UserID, TicketType, Date) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertTicket);

        // Check the booking type
        if ($bookingType === 'self' || $bookingType === 'family') {
            // Booking for self or family
            foreach ($travelers as $traveler) {
                // Insert each family member's ticket
                $stmt->execute([$userID, $traveler['ticketType'], $traveler['date']]);
            }
        } elseif ($bookingType === 'agent') {
            // Booking by agent on behalf of the user
            foreach ($travelers as $traveler) {
                // Insert each family member's ticket with the user's ID
                $stmt->execute([$userID, $traveler['ticketType'], $traveler['date']]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid booking type.']);
            exit();
        }

        echo json_encode(['status' => 'success', 'message' => 'Ticket booked successfully.']);
    } else {
        // Return an error message if the connection is not established
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    }
} catch (PDOException $e) {
    // Return an error message if the SQL query fails
    echo json_encode(['status' => 'error', 'message' => 'Ticket booking failed.', 'error' => $e->getMessage()]);
}
?>
