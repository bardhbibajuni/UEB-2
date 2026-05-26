<?php
// AJAX endpoint - live course search (no page reload)
session_start();
require_once '../helpers.php';

$search  = trim($_GET['q'] ?? '');
$courses = getAllCourses($search);

include '../partials/courses_grid.php';
