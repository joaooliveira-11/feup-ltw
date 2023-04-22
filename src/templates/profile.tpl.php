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
<?php } ?>