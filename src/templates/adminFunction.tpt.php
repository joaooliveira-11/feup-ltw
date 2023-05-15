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
                    <form method="post" action="../pages/editDepartment.php">
                        <button type="submit" name="department" value="<?php echo $department ?>"> See agents from Department </button>
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