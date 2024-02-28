<?php

class DatabaseSetup {
    private $conn;

    public function __construct($host, $username, $password, $database) {
        $this->conn = mysqli_connect($host, $username, $password);
        if ($this->conn === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $query = "CREATE DATABASE IF NOT EXISTS $database";
        if (mysqli_query($this->conn, $query)) {
            echo "Database created successfully or already exists.<br>";
        } else {
            echo "Error creating database: " . mysqli_error($this->conn) . "<br>";
        }

        mysqli_select_db($this->conn, $database);

        $table = "student";
        $query = "CREATE TABLE IF NOT EXISTS $table (
            schoolid  INT(11) AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(50) NOT NULL,
            middle_initial VARCHAR(1),
            last_name VARCHAR(50) NOT NULL,
            gender ENUM('Male', 'Female') NOT NULL,
            date_of_birth DATE NOT NULL,
            course VARCHAR(50) NOT NULL,
            year_level VARCHAR(50) NOT NULL
        )";
        if (mysqli_query($this->conn, $query)) {
            echo "Table created successfully or already exists.<br>";
        } else {
            echo "Error creating table: " . mysqli_error($this->conn) . "<br>";
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        mysqli_close($this->conn);
    }
}

$databaseSetup = new DatabaseSetup("localhost", "root", "", "act1");
$conn = $databaseSetup->getConnection();
?>