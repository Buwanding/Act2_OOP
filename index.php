<?php

require 'conn.php';
$method = $_SERVER['REQUEST_METHOD'];

class Operation {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    function POST() {
        $schoolid = $_REQUEST['schoolid'];
        $first_name = $_REQUEST['first_name'];
        $middle_initial = $_REQUEST['middle_initial'];
        $last_name = $_REQUEST['last_name'];
        $gender = $_REQUEST['gender'];
        $date_of_birth = $_REQUEST['date_of_birth'];
        $course = $_REQUEST['course'];
        $year_level = $_REQUEST['year_level'];
        $sql = "INSERT INTO student (schoolid, first_name, middle_initial, last_name, gender, date_of_birth, course, year_level) VALUES ('$schoolid', '$first_name','$middle_initial','$last_name','$gender','$date_of_birth','$course','$year_level')";
        $res = $this->conn->query($sql);
        if ($res === TRUE) {
            echo "Record added";
        } else {
            echo "Error: " . $this->conn->error;
        }
    }

    function PUT() {
        $_PUT = file_get_contents("php://input");
        parse_str($_PUT, $put_vars);
        $schoolid = $put_vars['schoolid'];
        $first_name = $put_vars['first_name'];
        $middle_initial = $put_vars['middle_initial'];
        $last_name = $put_vars['last_name'];
        $gender = $put_vars['gender'];
        $date_of_birth = $put_vars['date_of_birth'];
        $course = $put_vars['course'];
        $year_level = $put_vars['year_level'];
        $sql = "UPDATE student SET first_name='$first_name', middle_initial='$middle_initial', last_name='$last_name', gender='$gender', date_of_birth='$date_of_birth', course='$course' WHERE schoolid='$schoolid'";
        $res = $this->conn->query($sql);
        if ($res === TRUE) {
            echo "Record updated";
        } else {
            echo "Error: " . $this->conn->error;
        }
    }

    function DEL() {
        $schoolid = $_GET['schoolid'];
        $sql = "DELETE FROM student WHERE schoolid='$schoolid'";
        $res = $this->conn->query($sql);
        if ($res === TRUE) {
            echo "Record deleted";
        } else {
            echo "Error: " . $this->conn->error;
        }
    }

    function GET() {
        $data = $_GET;
        if (isset($data['search'])) {
            $search = $data['search'];
            $sql = "SELECT * FROM student WHERE schoolid = '$search' OR first_name = '$search'";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo json_encode($row, JSON_PRETTY_PRINT);
                }
            } else {
                echo "No results found.";
            }
        } else {
            $sql = "SELECT * FROM student";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo json_encode($row, JSON_PRETTY_PRINT);
                }
            } else {
                echo "No results found.";
            }
        }
    }
}

$Operation = new Operation($conn);

if ($method === "POST") {
    $Operation->POST();
} elseif ($method === "PUT") {
    $Operation->PUT();
} elseif ($method === "DELETE") {
    $Operation->DEL();
} else {
    $Operation->GET();
}
?>
