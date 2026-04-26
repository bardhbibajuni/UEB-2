<?php
session_start();
session_destroy();
setcookie('brain_boost_user', '', time() - 3600, '/');
header('Location: login.php');
exit;
