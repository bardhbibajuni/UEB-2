<?php
session_start();

// Fshin te gjitha te dhenat e sessionit (log-out i perdoruesit)
session_destroy();

// E kthen perdoruesin prap te faqja login
header("Location: login.php");
exit();
?>
