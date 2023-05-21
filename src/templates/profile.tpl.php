<?php function drawProfile($user, PDO $db)
{
    $idRole = $user->getUserRole($db);
    ?>
<main id="ProfileMain">
    <div id="HeaderProfile" class="HeaderMain">
        Profile
    </div>
    <section>
        <img src="../docs/images/imagem-do-usuario-com-fundo-preto.png">
        <article>
            <a>
                Name:  <span><?php echo $user->getName();  ?></span>
            </a>
            <a>
                Username: <span><?php echo $user->getUsername();  ?></span>
            </a>
            <a>
                E-mail: <span><?php echo $user->getEmail(); ?></span>
            </a>
            <a>
                Role: <span><?php echo $user->getRoleName($db, $idRole); ?></span>
            </a>
        </article>
    </section>
    <button id="EditProfileButton" onclick="window.location.href='../pages/editProfile.php'">
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
                        <input type="password" placeholder="Current Password" name="currentPassword" required="required">
                    </label>
                </div>
                <div>
                    New Password:
                    <label>
                        <input type="password" placeholder="New Password" name="newPassword">
                    </label>
                </div>
                <div>
                    Confirm Password:
                    <label>
                        <input type="password" placeholder="Confirm Password" name="confirmPassword">
                    </label>
                </div>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
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

<?php function drawCreateNewTicket(array $departments) { ?>
    <main> 
    <section class="createticket">
        <form action="../actions/action_newticket.php" method="post">
            <div class="form-wrapper">
                <div class="ticket-title">
                    <label for="ticket_title">Title: </label>
                    <input type="text" name="title" id="ticket_title" required="required" maxlength="40">
                </div>

                <div class="ticket-desc">
                    <label for="ticket_description">Description</label>
                    <br>
                    <textarea name="description" id="ticket_description" required="required" rows="4" cols="75" maxlength="300"></textarea>
                </div> 
                
                <div class="ticket-bottom">
                    <div class="ticket-dep">
                        <label for="ticket_department">Department: </label>
                        <select name="department" id="ticket_department">
                            <?php foreach ($departments as $department) { ?>
                                <option value="<?php echo $department['name']; ?>"><?php echo $department['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="ticket-prio">
                        <label for="ticket_priority">Priority</label>
                        <select name="priority" id="ticket_priority">
                            <option value=1>1</option>
                            <option value=2>2</option>
                            <option value=3>3</option>
                            <option value=4>4</option>
                            <option value=5>5</option>
                        </select>
                    </div>
                    
                    <div class="ticket-date">
                        <label for="ticket_createdate"><?php echo date('d-m-Y')?></label>
                        <input type="hidden" name="date" id="ticket_createdate" value="<?php echo date('d-m-Y')?>">
                    </div>
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                </div>
            </div>
            <button class="btn-submit" type="submit">Submit Ticket</button>
            <button class="btn-cancel" type="button" onclick="window.location.href='../pages/main.php'">Cancel</button>
        </form>
    </section>
    </main>
<?php } ?>