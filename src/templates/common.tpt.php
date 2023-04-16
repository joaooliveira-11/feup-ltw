<?php function drawLogin()
{ ?>

    <link rel="stylesheet" href="../css/forms.css">

    <section id="login">
        <div class="container sign_form">
            <form>
                <h1>TicketEase</h1>
                <p>Welcome Back! Please login to your account.</p>
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


<?php } ?>

<?php function drawRegister()
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

<?php } ?>

<?php function drawHello()
{ ?>

<h1>Hello World!</h1>


<?php } ?>
