<?php

function drawWebsiteDepartments(array $departments) { ?>
    <main>
        <div>
            Departments:
        </div>
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
                    <form method="post" action="../pages/edit_or_createDepartment.php">
                        <button type="submit" name="department" value="<?php echo $department ?>"> See agents from Department </button>
                    </form>
                    <form method="post" action="../pages/edit_or_createDepartment.php">
                        <button type="submit" name="department" value="<?php echo $department ?>"> Edit Department Information</button>
                    </form>
                    <form method="post" action="../actions/action_deleteDepartment.php">
                        <button type="submit" name="department" value="<?php echo $department ?>"> Delete Department</button>
                    </form>
                </article>
            </section>
        <?php } ?>
        </section>
    </main>
<?php }