<?php
session_start();

if(!isset($_SESSION['firstname'])){
    header("Location: login.php");
    exit();
}
?>

<?php include "header.php"; ?>

<div class="dashboard">

    <div class="glow" id="glow"></div>

    <h1 class="title">
        Welcome, <?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']."!" ;?>
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
