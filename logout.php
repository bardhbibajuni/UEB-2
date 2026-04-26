<?php
session_start();
setcookie('brain_boost_user', '', time() - 3600, '/');
session_destroy();
header('Location: login.php');
exit;
