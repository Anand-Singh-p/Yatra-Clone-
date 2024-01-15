<?php
include("db_connection.php");
//  create Admin table
  $sql = "CREATE TABLE Admin (
    AdminID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL
  )";

  // use exec() because no results are returned
  $conn->exec($sql);
  echo "Table Admin created successfully";
  // Create Owner Table
$sql = "CREATE TABLE  Owner (
    OwnerID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    DOB DATE,
    Address VARCHAR(255)
)";
$conn->query($sqlOwner);
echo "Table Owner created successfully";
  ?>