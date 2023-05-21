<?php

require_once(dirname(__DIR__) . '/templates/myTickets.tpl.php');

function drawWebsiteDepartments(array $departments) { ?>
    <main>
        <section id="manageDepartmentsHeader">
            <div>
                Departments:
            </div>
            <button class="CreateNewTicket" onclick="window.location.href='../pages/createDepartment.php'"> <span>+</span> New Department</button>
        </section>
        <section id="DepartmentsAdmin">
        <?php foreach ($departments as $department){ ?>
            <section class="ADepartmentMain">
                <h4>
                    <?php echo $department['name'] ?>
                </h4>
                <p>
                    <?php echo $department['description'] ?>
                </p>
                <article>
                    <form method="post" action="../pages/manageDepartAgents.php">
                        <button type="submit" name="department" value="<?php echo $department['idDepartment'] ?>"> See agents from Department </button>
                    </form>
                    <form method="post" action="../pages/editDepartment.php">
                        <button type="submit" name="department" value="<?php echo $department['idDepartment'] ?>"> Edit Department Information</button>
                    </form>
                </article>
            </section>
        <?php } ?>
        </section>
    </main>
<?php }


function drawEditDepartment($department){ ?>
    <main>
        <section class="createticket">
            <form action="../actions/action_editOrCreateDepartment.php" method="post">
            <div class="form-wrapper">
                <div class="ticket-title">
                    <label for="ticket_title"> Title: </label>
                    <input type="text" name="title" value="<?php echo $department['name'] ?>" id="ticket_title" required="required" maxlength="30">
                </div>

                <div class="ticket-desc">
                    <label for="ticket_description">Description</label>
                    <br>
                    <textarea name="description" id="ticket_description" required="required" rows="4" cols="75" maxlength="300"> <?php echo $department['description']?></textarea>
                </div>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            </div>
                <button class="btn-submit" type="submit" name="idDepartment" value="<?php echo $department['idDepartment'] ?>">Edit Department</button>
                <button class="btn-cancel" type="button" onclick="window.location.href='../pages/manageDepartments.php'">Cancel</button>
            </form>
        </section>
    </main>
<?php }

function drawCreateDepartment(){ ?>
    <main>
        <section class="createticket">
            <form action="../actions/action_editOrCreateDepartment.php" method="post">
                <div class="form-wrapper">
                    <div class="ticket-title">
                        <label for="ticket_title"> Title: </label>
                        <input type="text" name="title" id="ticket_title" required="required" maxlength="30">
                    </div>

                    <div class="ticket-desc">
                        <label for="ticket_description">Description: </label>
                        <br>
                        <textarea name="description" id="ticket_description" required="required" rows="4" cols="75" maxlength="300"></textarea>
                    </div>
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                </div>
                <button class="btn-submit" type="submit">Create Department</button>
                <button class="btn-cancel" type="button" onclick="window.location.href='../pages/manageDepartments.php'">Cancel</button>
            </form>
        </section>
    </main>
<?php }

function drawWebsiteUsers(){ ?>
<main class="noPadding TicketOverflow">
    <table id="usersTable">
        <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Role</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="usersBody">
        </tbody>
    </table>
</main>
<?php }


function drawBanUser(int $idUser){ ?>
    <main>
        <section class="createticket">
            <form action="../actions/action_banUser.php" method="post">
                <div class="form-wrapper">
                    <div class="ticket-title">
                        <label for="ticket_title"> Reason: </label>
                        <input type="text" name="title" id="ticket_title" required="required" maxlength="30">
                    </div>

                    <div class="ticket-desc">
                        <label for="ticket_description">Description: </label>
                        <br>
                        <textarea name="description" id="ticket_description" rows="4" cols="75" maxlength="300"></textarea>
                    </div>
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                </div>
                <article>
                <button class="btn-submit" type="submit" name="idUser" value="<?php echo $idUser ?>">Ban User</button>
                <button class="btn-cancel" type="button" onclick="window.location.href='../pages/manageUsers.php'">Cancel</button>
                </article>
            </form>
        </section>
    </main>
<?php }

function drawDepartmentAgents(array $users, int $idDepartment, PDO $db){ ?>
    <main class="noPadding">
        <table>
            <thead>
            <tr>
                <th>Agents</th>
                <th>Current Departments</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($users as $user){ ?>
            
                <tr class="availableAgents">
                    <th><?php echo $user[0] ?></th>
                    <th><?php echo User::countUserDepartments($db, intval($user[2]));?></th>
                </tr>
        <?php }
        ?>
            </tbody>
        </table>
        <form action="../pages/agentsOutsideDepart.php" method="post">
            <button class="CreateNewTicket" name="department" value="<?php echo $idDepartment?>" type="submit"> <span>+</span> New Agent</button>
        </form>
    </main>
<?php }

function drawOutsideDepartmentAgents(array $users, int $idDepartment, PDO $db){ ?>
     <main class="noPadding">
        <table>
            <thead>
            <tr>
                <th>Available Agents</th>
                <th>Current Departments</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($users as $user){?>
                <tr class="availableAgents" id ="<?= $user[1]?>">
                    <th><?php echo $user[0] ?></th>
                    <th><?php echo User::countUserDepartments($db, intval($user[1]));?></th>
                    <th>
                        <form class="agentsOutside">
                            <input type="hidden" id="userinput" name="idUser" value="<?php echo $user[1]?>">
                            <input type="hidden" id="departinput" name="idDepart" value="<?= $idDepartment?>">
                            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                            <button type="submit" id="agentsOutside-button">Select</button>
                        </form>
                    </th>
                </tr>
        <?php }
        ?>
            </tbody>
        </table>        
    </main>
<?php }

function drawOtherOptions($errorMessage = null){ ?>

    <main>
        <div id="informationAdding">
            <p>
                Write a new Status or a new Hashtag to add to the system.<br> Note that if you write on both, it will only add one, the option linked to the add button
            </p>
            <?php if(isset($errorMessage)){ ?>
            <div class="errorMessage">
                <p><?php echo $errorMessage ?></p>
            </div>
    <?php } ?>
        </div>
        <section class="createticket">
            <form action="../actions/action_addOption.php" method="post" class="spaceBetween">
                <div class="form-wrapper">
                    <div class="ticket-title">
                        <label for="ticket_title"> Add Hastag: </label>
                        <input type="text" name="new_hashtag" id="ticket_title" maxlength="30">
                    </div>
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                </div>
                <article>
                <button class="btn-submit" type="submit">Add</button>
                <button class="btn-cancel" type="button" onclick="window.location.href='../pages/manageUsers.php'">Cancel</button>
                </article>
            </form>
            <form action="../actions/action_addOption.php" method="post" class="spaceBetween">
                <div class="form-wrapper">
                    <div class="ticket-title">
                        <label for="ticket_title"> Add Status: </label>
                        <input type="text" name="new_status" maxlength="24">
                    </div>
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                </div>
                <article>
                    <button class="btn-submit" type="submit">Add</button>
                    <button class="btn-cancel" type="button" onclick="window.location.href='../pages/manageUsers.php'">Cancel</button>
                </article>
            </form>
        </section>
        <div class="seeAllTickets">
            <button onclick="window.location.href='../pages/adminTickets.php'" class="seeAllTicketsButton">
                See all tickets from website
            </button>
        </div>
    </main>
<?php }


function drawAllTickets(array $tickets, PDO $db){ ?>
    <section class = "ticketsPage">
        <section id="Filter" class="yourTickets">
            <article>
                Filter By:
                <div id="DepartmentFilterAdmin">
                    <button id="DepartmentFilterButtonAdmin">
                        Department
                    </button>
                </div>
                <div id="StatusFilterAdmin">
                    <button id="StatusFilterButtonAdmin">
                        Ticket Status
                    </button>
                </div>
            </article>
            <article>
                Order By:
                <div id="PriorityFilterAdmin">
                    <button id="PriorityFilterButtonAdmin">
                        Priority
                        <img src="../docs/images/icon-minus.png">
                    </button>
                </div>
                <div id="DateFilterAdmin">
                    <button id="DateFilterButtonAdmin">
                        Date
                        <img src="../docs/images/icon-minus.png">
                    </button>
                </div>
            </article>
        </section>
        <section class="TicketOverflow">
            <?php foreach ($tickets as $ticket){
                drawSingleTicket($db, $ticket, 4);
            } ?>
        </section>
    </section>
<?php }