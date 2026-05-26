<?php
session_start();
require_once 'helpers.php';
include 'header.php';

$search  = trim($_GET['search'] ?? '');
$courses = getAllCourses($search);
?>

<div class="courses-section">
    <h1 class="section-title">All Courses</h1>

    <div class="search-form">
        <input type="text" id="searchInput" placeholder="Search courses..." value="<?= sanitize($search) ?>">
        <button onclick="doSearch()">Search</button>
        <?php if ($search): ?>
            <a href="courses.php" style="color:#9ca3af;margin-left:10px;">Clear</a>
        <?php endif; ?>
    </div>

    <div id="courses-container">
        <?php include 'partials/courses_grid.php'; ?>
    </div>
</div>

<script>
let searchTimer;
document.getElementById('searchInput').addEventListener('input', function () {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(doSearch, 350);
});

function doSearch() {
    const q = document.getElementById('searchInput').value;
    fetch('ajax/search_courses.php?q=' + encodeURIComponent(q))
        .then(r => r.text())
        .then(html => {
            document.getElementById('courses-container').innerHTML = html;
        })
        .catch(() => {});
}
</script>

<?php include 'footer.php'; ?>
