<?php

function hasPurchased($user_id, $course_id, $purchases) {

    foreach ($purchases as $p) {
        if ($p["user_id"] == $user_id && $p["course_id"] == $course_id) {
            return true;
        }
    }

    return false;
}

?>