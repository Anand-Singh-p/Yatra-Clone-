<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Include the database connection file
include "db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);
$userID = $data['userID'];
$userType = $data['userType']; // Assuming you have the user type after login
$ticketDetails = $data['ticketDetails']; // Assuming you have details like ticket type, date, etc.

try {
    // Check if the connection is established
    if ($conn) {
        // Determine the ID and table based on the user type
        $idFieldName = '';
        $tableName = '';

        if ($userType === 'user') {
            $idFieldName = 'UserID';
            $tableName = 'User';
        } elseif ($userType === 'agent') {
            $idFieldName = 'AgentID';
            $tableName = 'Agent';
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid user type.']);
            exit();
        }

        // Fetch the corresponding ID for the given user type
        $fetchIDQuery = "SELECT $idFieldName FROM $tableName WHERE $idFieldName = ?";
        $stmt = $conn->prepare($fetchIDQuery);
        $stmt->execute([$userID]);
        $userExists = $stmt->rowCount() > 0;

        if (!$userExists) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid user ID or user type.']);
            exit();
        }

        // Insert the ticket booking into the database
        $insertTicket = "INSERT INTO Ticket ($idFieldName, TicketType, Date) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertTicket);
        $stmt->execute([$userID, $ticketDetails['ticketType'], $ticketDetails['date']]);

        echo json_encode(['status' => 'success', 'message' => 'Ticket booked successfully.']);
    } else {
        // Return an error message if the connection is not established
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    }
} catch (PDOException $e) {
    // Return an error message if the SQL query fails
    echo json_encode(['status' => 'error', 'message' => 'Ticket booking failed.', 'error' => $e->getMessage()]);
}

