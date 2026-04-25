<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("127.0.0.1", "root", "", "course_platform", 3307);

if(!$conn){
    die("DB ERROR: " . mysqli_connect_error());
}


?>