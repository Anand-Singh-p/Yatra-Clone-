<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yatra_clone";
$conn='';

try
{
    $conn=new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //set PDO error mode to exception
    echo " connection successfull<br>";
}

catch(PDOException $e)
{
       echo "Connection failed:<br>"."<br><br>". $e->getMessage();  
}
?>

