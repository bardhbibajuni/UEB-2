<script>
        document.addEventListener("mousemove", e => {
            const glow = document.getElementById("glow");
            if(glow) {
                glow.style.left = e.clientX + "px";
                glow.style.top = e.clientY + "px";
            }
        });
    </script>
</body>
</html>
