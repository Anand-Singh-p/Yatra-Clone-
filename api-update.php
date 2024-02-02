<?php
/*
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-Width ');

$data = json_decode(file_get_contents("php://input"), true);
$tableName = $data['table'];
$tableFields = $data['fields']; // Fields and their values for the specified table

// Include the database connection file
include "db_connection.php";

try {
    // Check if the connection is established
    if ($conn) {
        // Check if the table name and fields are provided in the request
        if (!empty($tableName) && !empty($tableFields)) {

            // Generate placeholders for prepared statement
            $placeholders = implode(', ', array_fill(0, count($tableFields), '?'));

            // SQL query to insert records into the specified table
            $sql = "INSERT INTO $tableName(" . implode(', ', array_keys($tableFields)) . ") VALUES ($placeholders)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $i = 1;
            foreach ($tableFields as $field => $value) {
                $stmt->bindValue($i++, $value);
            }

            // Execute the statement
            $stmt->execute();

            echo json_encode(['status' => 'true', 'message' => "$tableName record inserted."]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Table name or fields not provided.']);
        }
    } else {
        // Return an error message if the connection is not established
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    }
} catch (PDOException $e) {
    // Return an error message if the SQL query fails
    echo json_encode(['status' => 'false', 'message' => "$tableName Record not inserted.", 'error' => $e->getMessage()]);
}
*/
/*
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Include the database connection file
include "db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$password = $data['password'];
$email = $data['email'];
$dob = $data['dob'];  // Assuming this is provided in the registration data
$address = $data['address'];  // Assuming this is provided in the registration data

try {
    // Check if the connection is established
    if ($conn) {
        // Check if the username is already taken
        $checkUsername = "SELECT * FROM User WHERE Username = ?";
        $stmt = $conn->prepare($checkUsername);
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Username already taken.']);
        } else {
            // Insert the new user into the database
            $insertUser = "INSERT INTO User (Username, Password, Email, DOB, Address) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertUser);
            $stmt->execute([$username, $password, $email, $dob, $address]);
            echo json_encode(['status' => 'success', 'message' => 'User registered successfully.']);
        }
    } else {
        // Return an error message if the connection is not established
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    }
} catch (PDOException $e) {
    // Return an error message if the SQL query fails
    echo json_encode(['status' => 'error', 'message' => 'SQL Query Failed.', 'error' => $e->getMessage()]);
}
*/

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Include the database connection file
include "db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$password = $data['password'];
$email = $data['email'];
$dob = $data['dob'];
$userType = $data['userType'];  // Assuming this is provided in the registration data

try {
    // Check if the connection is established
    if ($conn) {
        // Check if the username is already taken
        $checkUsername = "SELECT * FROM $userType WHERE Username = ?";
        $stmt = $conn->prepare($checkUsername);
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Username already taken.']);
        } else {
            // Insert the new user into the database
            $insertUser = "INSERT INTO $userType (Username, Password, Email, DOB) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertUser);
            $stmt->execute([$username, $password, $email, $dob]);
            echo json_encode(['status' => 'success', 'message' => "$userType registered successfully."]);
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
