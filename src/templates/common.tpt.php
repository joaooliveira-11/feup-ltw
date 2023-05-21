<?php
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/classes/inquiry.class.php');

function drawLogin()
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
                <a class="form_button" href="../pages/register.php">Sign up here</a>
            </div>
        </div>
    </section>

<?php } ?>

<?php function drawInitialFooter()
{ ?>

    <img src="../docs/images/initialFooter.png" alt="">

<?php }

function drawFooterMain(){ ?>
    <footer id="footerMain">
        <div> ©2023 TicketEase Inc. All Rights Reserved </div>
        <section id="footerMainRight">
            <a href="../pages/aboutUs.php"> About Us </a>
            <div> | </div>
            <a href="../pages/faq.php"> User Help </a>
        </section>
    </footer>
    </body>
<?php }

 function drawRegister()
{ ?>
    <link rel="stylesheet" href="../css/forms.css">

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
                    <label>
                        <input type="password" placeholder="ConfirmPassword" name="password1" required>
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

function drawHeaderMain($scriptPage = null){?>
    <!DOCTYPE html>
    <head>
        <link rel="stylesheet" href="../css/style.css">
        <script defer src="../javascript/script.js"></script>
    <?php if ($scriptPage!=null) { ?>
        <script defer src="../javascript/<?php echo $scriptPage?>"></script>
    <?php } ?>
    </head>

    <body>
    <?php
        $db=getDatabaseConnection();
        $session = new Session();

        $user = User::getSingleUser($db, $session->getId());
        $inquiries = Inquiry::getUserInquiries($db,$user->getId());
        $count_inquiries = 0;
        foreach ($inquiries as $inquiry){
            $count_inquiries++;
        }

        $role = $user->getUserRole($db);

    ?>



    <header id ="HeaderMain">
        TicketEase
        <div class ="headerResponsive">
            <form action="../actions/action_logout.php" method="post" id="header-logout-form">
                <button type="submit" id="logout-button">
                    <img src="../docs/images/kisspng-computer-icons-login-download-logout-5b2a945b7528f7.8498128615295171474799.png" alt="">
                    Log Out
                </button>
            </form>
            <div class="dropdown">
                <button class="dropbtn">Dropdown</button>
                <div class="dropdown-content">
                    <a href="../pages/main.php" id="HomeButton">
                        <img src="../docs/images/kisspng-website-house-home-world-wide-web-computer-icons-house-clip-art-5ab036bbf19551.9166615015214977879895.png" alt="">
                        Home
                    </a>
                    <a href="../pages/profile.php" id="ProfileButton">
                        <img src="../docs/images/imagem-do-usuario-com-fundo-preto.png" alt="">
                        Profile
                    </a>
                    <a href="../pages/mytickets.php" id="MyTicketsButton">
                        <img src="../docs/images/—Pngtree—vector%20files%20icon_3788102.png" alt="">
                        My Tickets
                    </a>
                    <a href="../pages/inquiries.php" id="InquiriesButton">
                        <img src="../docs/images/imagem-do-usuario-com-fundo-preto.png" alt="">
                        Inquiries
                        <?php if($count_inquiries>0) { ?>
                        <div>
                            <?php echo $count_inquiries; ?>
                        </div>
                        <?php } ?>
                    </a>
                    <?php
                        if($role>1) drawAsideAgent();
                        if($role>2) drawAsideAdminResponsive();
                    ?>
                </div>
            </div>
        </div>
    </header>

<?php }

function drawAside(){
    $db=getDatabaseConnection();
    $session = new Session();

    $user = User::getSingleUser($db, $session->getId());
    $inquiries = Inquiry::getUserInquiries($db,$user->getId());
    $count_inquiries = 0;
    foreach ($inquiries as $inquiry){
        $count_inquiries++;
    }

    $role = $user->getUserRole($db);
    ?>
    <aside>
        <a href="../pages/main.php" id="HomeButton">
            <img src="../docs/images/kisspng-website-house-home-world-wide-web-computer-icons-house-clip-art-5ab036bbf19551.9166615015214977879895.png" alt="">
            Home
        </a>
        <a href="../pages/profile.php" id="ProfileButton">
            <img src="../docs/images/imagem-do-usuario-com-fundo-preto.png" alt="">
            Profile
        </a>
        <a href="../pages/mytickets.php" id="MyTicketsButton">
            <img src="../docs/images/—Pngtree—vector%20files%20icon_3788102.png" alt="">
            My Tickets
        </a>
        <a href="../pages/inquiries.php" id="InquiriesButton">
            <img src="../docs/images/imagem-do-usuario-com-fundo-preto.png" alt="">
            Inquiries
            <?php if($count_inquiries>0) { ?>
            <div>
                <?php echo $count_inquiries; ?>
            </div>
            <?php } ?>
        </a>

        <?php   
            if($role>1) drawAsideAgent();
            if($role>2) drawAsideAdmin();
        ?>

        <form action="../actions/action_logout.php" method="post">
            <button type="submit" id="logout-button">
                <img src="../docs/images/kisspng-computer-icons-login-download-logout-5b2a945b7528f7.8498128615295171474799.png" alt=""> 
                Log Out
            </button>
        </form>
    </aside>

<?php }

function drawAsideAgent(){ ?>
    <a href="../pages/openTickets.php" id="TicketsOpenButton">
        <img src="../docs/images/—Pngtree—vector%20files%20icon_3788102.png">
        Tickets From My Department(s)
    </a>
    <a href="../pages/myAssignedTickets.php" id="AssignedTicketsButton">
        <img src="../docs/images/—Pngtree—vector%20files%20icon_3788102.png">
        Tickets Assigned to me
    </a>

<?php }

function drawAsideAdmin(){ ?>
    <div id="AsideAdmin">
        <a id="ManageWebsite">
            <img src="../docs/images/definition.png">
            Manage Website
        </a>
        <img src="../docs/images/—Pngtree—vector%20right%20arrow%20icon_4184716.png" style="display: none" id="SetaParaDireita">
        <ul style="display: none">
            <button onclick="window.location.href='../pages/manageDepartments.php'">Manage Departments</button>
            <button onclick="window.location.href='../pages/manageUsers.php'">Manage Users</button>
            <button onclick="window.location.href='../pages/manageOptions.php'">Other Options</button>
        </ul>
    </div>
<?php }

function drawAsideAdminResponsive(){ ?>
    <a href="../pages/manageDepartments.php">
        <img src="../docs/images/definition.png">
        Manage Departments
    </a>
    <a href="../pages/manageUsers.php">
        <img src="../docs/images/definition.png">
        Manage Users
    </a>
    <a href="../pages/manageOptions.php">
        <img src="../docs/images/definition.png">
        Other Options
    </a>
<?php }


function drawMainPage(array $departments, PDO $db) { ?>
    <main id="HomePageContent">
    <article>
        <p>This is where you can submit your trouble tickets.</p>
        <p>1. Fill out the ticket form with details about the issue you are experiencing, including a clear and <br>
            concise description of the problem.<br>
            2. Choose the appropriate department from the dropdown list to ensure that your ticket is routed to <br>
            the right team for prompt resolution.</p>
        <p> Here are the different departments that can handle your issue:</p>
    </article>
    <article id="DepartmentsMain" class="MainOverflow">
    <?php foreach ($departments as $department) { ?>
            <section class="ADepartmentMain">
                <h4>
                    <?php echo $department['name'] ?>
                </h4>
                <p>
                    <?php echo $department['description'] ?>
                </p>
            </section>
        <?php } ?>
    </article>
        <a href="../pages/newTicket.php">
            <button class="CreateNewTicket"> <span>+</span> New Ticket</button>
        </a>
</main>

<?php }

