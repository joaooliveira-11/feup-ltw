<?php function drawProfile($user, PDO $db)
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
                username: <?php echo $user->getUsername();  ?>
            </div>
            <div>
                email: <?php echo $user->getEmail(); ?>
            </div>
            <div>
                roles: <?php echo implode(', ', $user->getRoles($db)); ?>
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
        <form>
            <article>
                <h2>
                    Change Account Information (if you want)
                </h2>
                <div>
                    Name:
                    <label>
                        <input type="text" placeholder="New Name" name="newName">
                    </label>
                </div>
                <div>
                    Username:
                    <label>
                        <input type="text" placeholder="New Username" name="newUsername">
                    </label>
                </div>
                <div>
                    E-mail:
                    <label>
                        <input type="email" placeholder="New Email"name="newEmail">
                    </label>
                </div>
            </article>
            <article>
                <h2>
                    Change Password (if you want)
                </h2>
                <div>
                    Current Password:
                    <label>
                        <input type="password" placeholder="Obrigatório preencher" name="currentPassword">
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
            </article>
            <div id="SubmitEditButtons">
                <button formaction="../actions/action_editProfile.php" formmethod="post">
                    Submit Changes
                </button>
                <button type="button" onclick="window.location.href='../pages/profile.php'">
                    Cancel
                </button>
            </div>
        </form>
    </main>
<?php } ?>