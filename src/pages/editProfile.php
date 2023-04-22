<?php

require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/utils/session.php');

drawHeaderMain();
drawAside();
?>
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
<?php
drawFooterMain(); ?>

