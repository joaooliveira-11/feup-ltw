<?php function drawProfile($user)
{ ?>
<main id="ProfileMain">
    <div id="HeaderProfile">
        Profile
    </div>
    <section>
        <img src="../docs/images/imagem-do-usuario-com-fundo-preto.png">
        <article>
            <div>
                name: <?php echo $user->getName();  ?>
            </div>
            <div>
                email: <?php echo $user->getEmail(); ?>
            </div>
        </article>
    </section>
    <button id="EditProfileButton" onclick="window.location.href='http://localhost:9000/pages/editProfile.php'">
        Edit Profile
    </button>
</main>
<?php }

function drawEditProfileMain(){ ?>
    <main id="EditProfileMain">
        <header class="HeaderMain">
            Edit Profile
        </header>
        <div id="ChangePhoto">
            <img src="../docs/images/imagem-do-usuario-com-fundo-preto.png">
            <button> Change Picture</button>
        </div>
        <article>
            <h2>
                Account Information
            </h2>
            <form>
                <div>
                    Name:
                    <label>
                        <input type="text" name="newName">
                    </label>
                </div>
                <div>
                    E-mail:
                    <label>
                        <input type="text" name="newEmail">
                    </label>
                </div>
            </form>
        </article>
        <article>
            <h2>
                Account Information
            </h2>
            <form>
                <div>
                    Current Password:
                    <label>
                        <input type="password" name="currentPassword">
                    </label>
                </div>
                <div>
                    New Password:
                    <label>
                        <input type="password" name="newPassword">
                    </label>
                </div>
                <div>
                    Confirm Password:
                    <label>
                        <input type="password" name="confirmPassword">
                    </label>
                </div>
            </form>
        </article>
        <div id="SubmitEditButtons">
            <button formaction="../actions/action_editProfile.php" formmethod="post">
                Submit Changes
            </button>
            <button onclick="window.location.href='../pages/profile.php'">
                Cancel
            </button>
        </div>
    </main>
<?php } ?>