<?php
require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/utils/session.php');

$session = new Session();

drawHeaderMain();
drawAside();
$db = getDatabaseConnection();
$user= User::getSingleUser($db,$session->getId());
?>
<main id="ProfileMain">
    <header class="HeaderMain">
        Profile
    </header>
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
<?php
drawFooterMain();
?>