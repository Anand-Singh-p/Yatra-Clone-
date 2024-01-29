<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Include the database connection file
include "db_connection.php";

try {
    // Check if the connection is established
    if ($conn) {
        // Check if the table name and ID are provided in the URL
        if (isset($_GET['table']) && isset($_GET['id'])) {
            $table = $_GET['table'];
            $id = $_GET['id'];

            // SQL query to select a record from the specified table based on the ID
            $sql = "SELECT * FROM $table WHERE {$table}ID = {$id}";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();

            // Fetch the record as an associative array
            $output = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Check if a record is found
            if (!empty($output)) {
                // Return the record as JSON
                echo json_encode(['status' => 'success', 'data' => $output]);
            } else {
                // Return a message if no record is found
                echo json_encode(['status' => 'error', 'message' => "No Record Found in table $table with ID $id."]);
            }
        } else {
            // Return an error message if the table name or ID is not provided
            echo json_encode(['status' => 'error', 'message' => 'Table name or ID not provided in the URL.']);
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
