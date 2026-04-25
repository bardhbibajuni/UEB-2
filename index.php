<?php include "header.php"; ?>


<div style="
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
">

    <div>

        <!--  logoja -->
        <h1 style="
            font-family: 'Space Grotesk', sans-serif;
            font-size: 4rem;
            font-weight: 700;
            letter-spacing: 2px;
            background: linear-gradient(90deg, #00ffff, #6366f1, #ff00ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 25px rgba(0,255,255,0.3);
        ">
            Brain Boost 🧠
        </h1>

        <p style="
            color:#9ca3af;
            margin-top:10px;
            font-size:16px;
        ">
            Learn smarter. Build faster. Think better.
        </p>

        <!-- Butonat-->
        <div style="
            margin-top:35px;
            display:flex;
            flex-direction:column;
            gap:15px;
            align-items:center;
        ">


            <a href="login.php">
                <button style="
                    width:270px;
                    padding:16px 20px;

                    font-family: 'Inter', sans-serif;
                    font-size:16px;
                    font-weight:600;

                    border:none;
                    border-radius:14px;

                    cursor:pointer;
                    color:#0b0f19;

                    background: linear-gradient(135deg, #00ffff, #6366f1);

                    transition: all 0.25s ease;
                "
                onmouseover="this.style.transform='translateY(-4px) scale(1.03)'; this.style.boxShadow='0 15px 30px rgba(0,255,255,0.25)'"
                onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                     Login
                </button>
            </a>
 
          

            <a href="register.php">
                <button style="
                    width:270px;
                    padding:16px 20px;

                    font-family: 'Inter', sans-serif;
                    font-size:16px;
                    font-weight:600;

                    border:none;
                    border-radius:14px;

                    cursor:pointer;
                    color:#0b0f19;

                    background: linear-gradient(135deg, #ff00ff, #6366f1);

                    transition: all 0.25s ease;
                "
                onmouseover="this.style.transform='translateY(-4px) scale(1.03)'; this.style.boxShadow='0 15px 30px rgba(255,0,255,0.2)'"
                onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                     Register
                </button>
            </a>

        </div>

    </div>

</div>

<?php include "footer.php"; ?>