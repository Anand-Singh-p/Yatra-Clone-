<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-Width ');

$data = json_decode(file_get_contents("php://input"), true);
$u_name = $data['uname'];
$u_pass = $data['upaa'];
$u_email = $data['umail'];

// Include the database connection file
include "db_connection.php";

try {
    // Check if the connection is established
    if ($conn) {
        // Check if the table name is provided in the request

        // SQL query to select all records from the specified table
        $sql = "INSERT INTO Admin(Username, Password, Email) VALUES ('{$u_name}', '{$u_pass}', '{$u_email}')";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Execute the statement
        $stmt->execute();

        echo json_encode(['status' => 'true', 'message' => 'admin record inserted.']);

        // Check if records are found
    } else {
        // Return an error message if the connection is not established
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    }
} catch (PDOException $e) {
    // Return an error message if the SQL query fails
    echo json_encode(['status' => 'false', 'message' => 'Admin Record not inserted.', 'error' => $e->getMessage()]);
}

?>
