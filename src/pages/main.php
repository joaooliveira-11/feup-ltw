<?php
require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/database/connection.php');

$db = getDatabaseConnection();

drawHeaderMain();
drawAside();
?>
<main id="HomePageContent">
    <article>
        <p>This is where you can submit your trouble tickets.</p>
        <p>1. Fill out the ticket form with details about the issue you are experiencing, including a clear and <br>
            concise description of the problem.<br>
            2. Choose the appropriate department from the dropdown list to ensure that your ticket is routed to <br>
            the right team for prompt resolution.</p>
        <p> Here are the different departments that can handle your issue:</p>
    </article>
    <article id="DepartmentsMain">
    <?php
        $that = $db->prepare("Select * From Department");
        $that->execute();

        $result = $that->fetchAll();

        foreach ($result as $row) { ?>
            <section id="ADeparmentMain">
                <h4>
                    <?php echo $row['name'] ?>
                </h4>
                <p>
                    <?php echo $row['description'] ?>
                </p>
            </section>
        <?php }
    ?>
    </article>
    <button id="CreateNewTicket"> <span>+</span> New Ticket</button>
</main>

<?php
drawFooterMain();?>

