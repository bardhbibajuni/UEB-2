<?php
function clean($data, $conn) {
    return mysqli_real_escape_string($conn, htmlspecialchars($data));
}
?>