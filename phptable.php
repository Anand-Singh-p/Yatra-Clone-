<?php
include("db_connection.php")

//Create admin table
$sql = "CREATE TABLE IF NOT EXISTS Admin(
    AdminID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL
)";
$conn->query($sql);
echo "Table Admin created succesfully";

?>
