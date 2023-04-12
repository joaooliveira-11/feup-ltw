<?php 

declare(strict_types = 1);
    
    
function drawLogin(Session $session) { ?>
    <section id="loginpage">
        <h1>Login</h1>
        <form action = "../actions/login.action.php" method = "post">
            <label>Email: <input type="email" name="email" value="<?=htmlentities($_SESSION['input']['email login'])?>"></label>
            <label>Password:<input type="password" name="password" value="<?=htmlentities($_SESSION['input']['password login'])?>"></label>
            <input id="button" type="submit" value="Entrar">
        </form>
    </section> <?php 
}

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

