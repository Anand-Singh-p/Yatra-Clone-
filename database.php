<?php  
class Database
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
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
        $this->createTablebookticket();
    }

    private function createTableAdmin()
    {
        $q = "CREATE TABLE Admin (
            AdminID INT AUTO_INCREMENT PRIMARY KEY,
            Username VARCHAR(255) NOT NULL,
            Password VARCHAR(255) NOT NULL,
            Email VARCHAR(255) NOT NULL       
        );";

        $this->executeQuery($q, 'Admin');
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

        $this->executeQuery($q, 'Owner_details');
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

        $this->executeQuery($q, 'Agent');
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

        $this->executeQuery($q, 'User');
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

        $this->executeQuery($q, 'Traveler');
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

        $this->executeQuery($q, 'Manager');
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

        $this->executeQuery($q, 'CustomerSupport');
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

        $this->executeQuery($q, 'ManagerAdminRelationship');
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

        $this->executeQuery($q, 'CustomerSupportUserRelationship');
    }
    private function createTablebookticket ()
    {
        $q = "CREATE TABLE Ticket(
              TicketID INT AUTO_INCREMENT PRIMARY KEY,
              UserID INT,
              TicketType VARCHAR(255) NOT NULL,
              Date DATE, 
              FOREIGN KEY (UserID) REFERENCES User(UserID)
            );";
            $this->executeQuery($q, 'Ticket');
    }

    private function executeQuery($query, $tableName)
    {
        $pq = $this->conn->prepare($query);

        try {
            $pq->execute();
            echo "<br>$tableName table created";
        } catch (Exception $ee) {
            echo "<br>Couldn't create $tableName table." . $ee->getMessage();
        }
    }
}

// Include the database connection file
include "db_connection.php";

// Instantiate the database class and create tables
$db_table = new Database($conn);
$db_table->createTables();

?>
