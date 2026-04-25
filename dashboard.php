<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>

<?php include "header.php"; ?>

<style>
/* 🌫️ Background mjegull */
.bg {
    position: fixed;
    width: 100%;
    height: 100%;
    background:
        radial-gradient(circle at 20% 20%, rgba(99,102,241,0.3), transparent 40%),
        radial-gradient(circle at 80% 30%, rgba(0,255,255,0.2), transparent 40%),
        radial-gradient(circle at 50% 80%, rgba(255,0,255,0.2), transparent 50%);
    filter: blur(100px);
    z-index: -1;
}

/* Glow efekt */
.glow {
    position: fixed;
    width: 250px;
    height: 250px;
    background: radial-gradient(circle, rgba(99,102,241,0.4), transparent 60%);
    border-radius: 50%;
    pointer-events: none;
    transform: translate(-50%, -50%);
    z-index: 0;
}

/* Container */
.dashboard {
    text-align: center;
    padding: 100px 20px;
    color: white;
}

/* Gradient text */
.title {
    font-size: 3rem;
    font-weight: 700;
    background: linear-gradient(90deg, #00ffff, #6366f1, #ff00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 10px;
}

/* Subtitle */
.subtitle {
    color: #9ca3af;
    margin-bottom: 30px;
}

/* Logout button */
.logout-btn {
    padding: 14px 30px;
    border-radius: 30px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    color: white;
    background: linear-gradient(135deg, #ff00ff, #6366f1);
    transition: 0.3s;
}

.logout-btn:hover {
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 10px 30px rgba(255,0,255,0.5);
}
</style>

<div class="bg"></div>
<div class="glow" id="glow"></div>

<div class="dashboard">
    <h1 class="title">
        Welcome, <?php echo $_SESSION['user']; ?> 🧠
    </h1>

    <p class="subtitle">
        This is your Brain Boost dashboard.
    </p>

  
</div>

<script>
const glow = document.getElementById("glow");

document.addEventListener("mousemove", (e) => {
    glow.style.left = e.clientX + "px";
    glow.style.top = e.clientY + "px";
});
</script>

<?php include "footer.php"; ?>