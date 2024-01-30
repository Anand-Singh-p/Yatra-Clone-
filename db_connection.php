<?php



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Yatra";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo " Connection successful<br>";
} catch (PDOException $e) {
    
    // echo "Connection failed: " . $e->getMessage();
    //echo " Connection failed:<br>" . "<br><br>" . $e->getMessage();
}

