<?php
class Admin {

    private $conn; 

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function getUsers() {
        return mysqli_query($this->conn, "SELECT * FROM users");
    }

    public function deleteUser($id) {
        $id = (int)$id;
        return mysqli_query($this->conn, "DELETE FROM users WHERE id=$id");
    }

    public function getCourses($search = "") {
        $search = mysqli_real_escape_string($this->conn, $search);
        return mysqli_query($this->conn, 
            "SELECT * FROM courses WHERE title LIKE '%$search%'"
        );
    }

    public function deleteCourse($id) {
        $id = (int)$id;
        return mysqli_query($this->conn, "DELETE FROM courses WHERE id=$id");
    }

    public function countUsers() {
        return mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM users"));
    }

    public function countCourses() {
        return mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM courses"));
    }
}
?>