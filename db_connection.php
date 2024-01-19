<?php
// Database connection code here:
class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "Yatra-Clone";
    private $conn = ''; // conn => connection 

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set PDO error mode to exception
            echo " Connection successful<br>";
        } catch (PDOException $e) {
            echo " Connection failed:<br>" . "<br><br>" . $e->getMessage();
        }
    }

    public function createTables()
    {
        $this->createTableAdmin();
        $this->createTableOwner();
        $this->createTableAgent();
        $this->createTableUser();
        $this->createTableTraveler();
        $this->createTableManager();
        $this->createTableCustomerSupport();
        $this->createTableManagerAdminRelationship();
        $this->createTableCustomerSupportUserRelationship();
    }

    private function createTableAdmin()
    {
        $q = "CREATE TABLE Admin (
            AdminID INT AUTO_INCREMENT PRIMARY KEY,
            Username VARCHAR(255) NOT NULL,
            Password VARCHAR(255) NOT NULL,
            Email VARCHAR(255) NOT NULL       
        );";

        $pq = $this->conn->prepare($q);

        try {
            $pq->execute();
            echo "<br>Admin table created";
        } catch (Exception $ee) {
            echo "<br>Couldn't create Admin table." . $ee->getMessage();
        }
    }

    private function createTableOwner()
    {
        $q = "CREATE TABLE Owner_details (
            OwnerID INT AUTO_INCREMENT PRIMARY KEY,
            Username VARCHAR(255) NOT NULL,
            Password VARCHAR(255) NOT NULL,
            Email VARCHAR(255) NOT NULL,
            DOB DATE,
            Address VARCHAR(255) 
        );";

        $pq = $this->conn->prepare($q);

        try {
            $pq->execute();
            echo "<br>Owner table created";
        } catch (Exception $ee) {
            echo "<br>Owner not created" . $ee->getMessage();
        }
    }

    private function createTableAgent()
    {
        $q = "CREATE TABLE Agent (
            AgentID INT AUTO_INCREMENT PRIMARY KEY,
            Username VARCHAR(255) NOT NULL,
            Password VARCHAR(255) NOT NULL,
            Email VARCHAR(255) NOT NULL,
            DOB DATE,
            Address VARCHAR(255)
        );";

        $pq = $this->conn->prepare($q);

        try {
            $pq->execute();
            echo "<br>Agent table created";
        } catch (Exception $ee) {
            // echo "<br>Agent table not created." . $ee->getMessage();
        }
    }

    private function createTableUser()
    {
        $q = "CREATE TABLE User (
            UserID INT AUTO_INCREMENT PRIMARY KEY,
            Username VARCHAR(255) NOT NULL,
            Password VARCHAR(255) NOT NULL,
            Email VARCHAR(255) NOT NULL,
            DOB DATE,
            Address VARCHAR(255)
        );";

        $pq = $this->conn->prepare($q);

        try {
            $pq->execute();
            echo "<br>User table created";
        } catch (Exception $ee) {
            echo "<br>User table not created." . $ee->getMessage();
        }
    }

    private function createTableTraveler()
    {
        $q = "CREATE TABLE Traveler (
            TravelerID INT AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(255) NOT NULL,
            Contact VARCHAR(20) NOT NULL,
            Email VARCHAR(255) NOT NULL,
            DOB DATE,
            Address VARCHAR(255)
        );";

        $pq = $this->conn->prepare($q);

        try {
            $pq->execute();
            echo "<br>Traveler table created";
        } catch (Exception $ee) {
            echo "<br>Traveler table not created." . $ee->getMessage();
        }
    }

    private function createTableManager()
    {
        $q = "CREATE TABLE Manager (
            ManagerID INT AUTO_INCREMENT PRIMARY KEY,
            Username VARCHAR(255) NOT NULL,
            Password VARCHAR(255) NOT NULL,
            Email VARCHAR(255) NOT NULL,
            ContactNumber VARCHAR(20) NOT NULL,
            Address VARCHAR(255),
            Salary DECIMAL(10, 2),
            HireDate DATE 
        );";

        $pq = $this->conn->prepare($q);

        try {
            $pq->execute();
            echo "<br>Manager table created";
        } catch (Exception $ee) {
            echo "<br>Manager table not created." . $ee->getMessage();
        }
    }

    private function createTableCustomerSupport()
    {
        $q = "CREATE TABLE CustomerSupport (
            SupportID INT AUTO_INCREMENT PRIMARY KEY,
            Username VARCHAR(255) NOT NULL,
            Password VARCHAR(255) NOT NULL,
            Email VARCHAR(255) NOT NULL,
            FirstName VARCHAR(255) NOT NULL,
            LastName VARCHAR(255) NOT NULL,
            ContactNumber VARCHAR(20) NOT NULL,
            JoinDate DATE
        );";

        $pq = $this->conn->prepare($q);

        try {
            $pq->execute();
            echo "<br>CustomerSupport table created";
        } catch (Exception $ee) {
            echo "<br>CustomerSupport table not created." . $ee->getMessage();
        }
    }

    private function createTableManagerAdminRelationship()
    {
        $q = "CREATE TABLE ManagerAdminRelationship (
            ManagerAdminRelationshipID INT AUTO_INCREMENT PRIMARY KEY,
            ManagerID INT,
            AdminID INT,
            FOREIGN KEY (ManagerID) REFERENCES Manager(ManagerID),
            FOREIGN KEY (AdminID) REFERENCES Admin(AdminID)
        );";

        $pq = $this->conn->prepare($q);

        try {
            $pq->execute();
            echo "<br>ManagerAdminRelationship table created";
        } catch (Exception $ee) {
            echo "<br>ManagerAdminRelationship table not created." . $ee->getMessage();
        }
    }

    private function createTableCustomerSupportUserRelationship()
    {
        $q = "CREATE TABLE CustomerSupportUserRelationship (
            CustomerSupportUserRelationshipID INT AUTO_INCREMENT PRIMARY KEY,
            CustomerSupportID INT,
            UserID INT,
            FOREIGN KEY (CustomerSupportID) REFERENCES CustomerSupport(SupportID),
            FOREIGN KEY (UserID) REFERENCES User(UserID)
        );";

        $pq = $this->conn->prepare($q);

        try {
            $pq->execute();
            echo "<br>CustomerSupportUserRelationship table created";
        } catch (Exception $ee) {
            echo "<br>CustomerSupportUserRelationship table not created." . $ee->getMessage();
        }
    }
}

// Instantiate the database class and create tables
$db_table = new Database();
$db_table->createTables();
?>
