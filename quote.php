<?php
header('Content-Type: application/json');

$url = "https://zenquotes.io/api/random";

// fetch from API using PHP (NOT browser)
$response = file_get_contents($url);

// return it directly
echo $response;
?>