<?php
session_start();
require_once 'helpers.php';
http_response_code(404);
include 'header.php';
?>

<div class="home-container" style="text-align:center;padding:80px 20px;color:#fff;">
    <h1 style="font-size:72px;margin:0;background:linear-gradient(135deg,#ff00ff,#00ffff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
        404
    </h1>
    <h2 style="color:#a5b4fc;margin:10px 0;">Page Not Found</h2>
    <p style="color:#9ca3af;max-width:500px;margin:15px auto 30px;">
        Faqja qe po kerkon nuk ekziston ose eshte zhvendosur diku tjeter.
    </p>
    <a href="index.php" class="btn-card btn-view" style="display:inline-block;padding:12px 28px;">
        ← Kthehu ne Home
    </a>
</div>

<?php include 'footer.php'; ?>
