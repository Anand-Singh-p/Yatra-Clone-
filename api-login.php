<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Include the database connection file
include "db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$password = $data['password'];
$userType = $data['userType'];  // Assuming this is provided in the login data

try {
    // Check if the connection is established
    if ($conn) {
        // Validate input parameters
        if (!empty($username) && !empty($password)) {

            // SQL query to check user credentials
            $sql = "SELECT * FROM $userType WHERE Username = ? AND Password = ?";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bindValue(1, $username);
            $stmt->bindValue(2, $password);

            // Execute the statement
            $stmt->execute();

            // Fetch the user record as an associative array
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                echo json_encode(['status' => 'success', 'message' => "$userType login successful.", 'data' => $user]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid username or password.']);
            }

        } else {
            echo json_encode(['status' => 'error', 'message' => 'Username or password not provided.']);
        }
    } else {
        // Return an error message if the connection is not established
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    }
} catch (PDOException $e) {
    // Return an error message if the SQL query fails
    echo json_encode(['status' => 'error', 'message' => "$userType login failed.", 'error' => $e->getMessage()]);
}

?>
