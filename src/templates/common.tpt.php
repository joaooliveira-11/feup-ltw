<?php function drawLogin()
{ ?>

    <link rel="stylesheet" href="../css/forms.css">

    <section id="login">
        <div class="container sign_form">
            <form>
                <h1>TicketEase</h1>
                <p>Welcome Back! Please log in to your account.</p>
                <label>
                     <input type="text" required placeholder="Username" name="username">
                </label>
                <label>
                     <input type="password" required placeholder="Password" name="password">
                </label>

                <button class="form_button" formaction="../actions/action_login.php" formmethod="post">Login</button>
            </form>
            <div class="form_alternative">
                <p><span class="bold">Not a member?</span></p>
                <a class="form_button" href="register.php">Sign up here</a>
            </div>
        </div>
    </section>

<?php } ?>

<?php function drawInitialFooter()
{ ?>

    <link rel="stylesheet" href="../css/forms.css">
    <img src="../docs/images/initialFooter.png" alt="">

<?php }

function drawFooterMain(){ ?>
    <footer id="footerMain">
        <div> ©2023 TicketEase Inc. All Rights Reserved </div>
        <section id="footerMainRight">
            <a src="#"> About Us </a>
            <div> | </div>
            <a src="#"> User Help </a>
        </section>
    </footer>
<?php }

 function drawRegister()
{ ?>

    <section id="register">
        <div class="container sign_form">
            <form>
            <h1>TicketEase</h1>
                <p>Just a few septs to create your account!</p>
                    <label>
                         <input type="text" placeholder="Name" name="name" required>
                    </label>
                    <label>
                         <input type="text" placeholder="Username" name="username" required>
                    </label>
                    <label>
                         <input type="email" placeholder="Email" name="email" required>
                    </label>
                    <label>
                        <input type="password" placeholder="Password" name="password" required>
                    </label>
                    <button class="form_button" formaction="../actions/action_register.php" formmethod="post">Sign Up</button>
             
            </form>
            <div class="form_alternative">
                <p><span class="bold">Already have an account?</span></p>
                <a class="form_button" href="login.php">Login here</a>
            </div>
        </div>

    </section>

<?php }

function drawHeaderMain(){ ?>
    <link rel="stylesheet" href="../css/style.css">
    <script defer src="../javascript/script.js"></script>

    <header id ="HeaderMain">
        TicketEase
    </header>

<?php }

function drawAside(){ ?>
    <aside>
        <section id="HomeButton">
            <img src="../docs/images/kisspng-website-house-home-world-wide-web-computer-icons-house-clip-art-5ab036bbf19551.9166615015214977879895.png" alt="">
            <div> Home </div>
        </section>
        <section id="ProfileButton">
            <img src="../docs/images/imagem-do-usuario-com-fundo-preto.png" alt="">
            <div> Profile </div>
        </section>
        <section id="MyTicketsButton">
            <img src="../docs/images/—Pngtree—vector%20files%20icon_3788102.png" alt="">
            <div> My Tickets </div>
        </section>
        <section id="InquiriesButton">
            <img src="../docs/images/imagem-do-usuario-com-fundo-preto.png" alt="">
            <div> Inquiries </div>
        </section>
        <form action="../actions/action_logout.php" method="post">
            <button type="submit" id="logout-button">
                <img src="../docs/images/kisspng-computer-icons-login-download-logout-5b2a945b7528f7.8498128615295171474799.png" alt=""> 
                Log Out
            </button>
        </form>
    </aside>

<?php } ?>
