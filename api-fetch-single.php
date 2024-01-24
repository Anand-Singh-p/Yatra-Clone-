<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$data = json_decode(file_get_contents("php://input"),true);
$admin_id = $data['adminid'];
// Include the database connection file
include "db_connection.php";

try {
    // Check if the connection is established
    if ($conn) {
        // SQL query to select all records from the Admin table
        $sql = "SELECT * FROM Admin WHERE AdminID ={$admin_id} ";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Execute the statement
        $stmt->execute();

        // Fetch all records as an associative array
        $output = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if records are found
        if (!empty($output)) {
            // Return the records as JSON
            echo json_encode(['status' => 'success', 'data' => $output]);
        } else {
            // Return a message if no records are found
            echo json_encode(['status' => 'error', 'message' => 'No Admin Records Found.']);
        }
    } else {
        // Return an error message if the connection is not established
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    }
} catch (PDOException $e) {
    // Return an error message if the SQL query fails
    echo json_encode(['status' => 'error', 'message' => 'SQL Query Failed.', 'error' => $e->getMessage()]);
}
?>
