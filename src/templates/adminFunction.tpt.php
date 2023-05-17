<?php

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
            <section class="ADepartmentMain" id="DepartmentAdmin">
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
                    <form method="post" action="../actions/action_deleteDepartment.php">
                        <button type="submit" name="department" value="<?php echo $department['idDepartment'] ?>"> Delete Department</button>
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
            <form action="../actions/action_edit_or_create_department.php" method="post">
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
            </div>
                <button class="btn-submit" type="submit" name="idDepartment" value="<?php echo $department['idDepartment'] ?>">Edit Department</button>
                <button class="btn-cancel" onclick="window.location.href='../pages/manageDepartments.php'">Cancel</button>
            </form>
        </section>
    </main>
<?php }

function drawCreateDepartment(){ ?>
    <main>
        <section class="createticket">
            <form action="../actions/action_edit_or_create_department.php" method="post">
                <div class="form-wrapper">
                    <div class="ticket-title">
                        <label for="ticket_title"> Title: </label>
                        <input type="text" name="title" id="ticket_title" required="required" maxlength="30">
                    </div>

                    <div class="ticket-desc">
                        <label for="ticket_description">Description</label>
                        <br>
                        <textarea name="description" id="ticket_description" required="required" rows="4" cols="75" maxlength="300"></textarea>
                    </div>
                </div>
                <button class="btn-submit" type="submit">Create Department</button>
                <button class="btn-cancel" onclick="window.location.href='../pages/manageDepartments.php'">Cancel</button>
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
