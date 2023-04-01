<?php function drawLogin()
{ ?>


    <section id="login">
        <div class="container sign_form">
            <form>
                <h2>Login</h2>
                <label>
                    Email <input type="text" required placeholder="Email" name="email">
                </label>
                <label>
                    Password <input type="password" required placeholder="Password" name="password">
                </label>

                <button class="form_button" formaction="../actions/action_login.php" formmethod="post">Login</button>
            </form>
            <div class="form_alternative">
                <p><span class="bold">Don't have an account?</span></p>
                <a class="form_button" href="register.php">Register</a>
            </div>
        </div>
    </section>

<?php } ?>