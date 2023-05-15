<?php function drawMyTicketPage(array $tickets, PDO $db) { ?>
    
    <link rel="stylesheet" href="../css/hashtags.css">

    <section class ="ticketsPage">
        <div class="yourTickets">
            <p id="TicketStatus" class="TicketStatusTitle">Your tickets:</p>
            <p id="TicketStatus" class= "circuloRed">Opened</p>
            <p id="TicketStatus" class= "circuloYellow">Assigned</p>
            <p id="TicketStatus" class= "circuloGreen">Closed</p>

        </div>
        <section class="TicketOverflow">
            <?php foreach($tickets as $ticket) {
                drawSingleTicket($db,$ticket,1);
            }?>
        </section>
       
    </section>

<?php }

function drawSingleTicket($db,Ticket $ticket, int $entity){ // esta entidade é para saber o que desenhar em cada página. Se for na página my tickets, desenho o ticket de uma determinada maneira; Se for na página DepartmentTickets, desenho o ticket doutra maneira, com mais funcionalidades, se for na página myAssignedTickets, desenho o ticket de outra maneira?>
    <?php
    
        $status = $ticket->getLastTicketStatus($db);
        $backgroundColor="";
        if($entity<=2) {
            switch ($status) {
                case "OPEN" :
                    $backgroundColor = "red";
                    break;
                case "ASSIGNED" :
                    $backgroundColor = "orange";
                    break;
                case "CLOSED" :
                    $backgroundColor = "green";
                    break;
            }
        }

        $autocompleteId = "autocomplete-list-" . $ticket->getIdTicket();
    ?>
    <script src="../javascript/hashtags.js"></script>
    <div class="retangulo <?php echo $backgroundColor ?>" id="ticket-<?=$ticket->getIdTicket()?>">
        <h2 class="ticketText"><?=$ticket->getTitle()?></h2>

        <section>
            <h3 class="ticketDescription"><?=$ticket->getDescription()?></h3>
        </section>

        <section class= hashtags>
        <div class="hashtags-container">
            <button id="add-hashtags-button" onclick="addHashtag(<?=$ticket->getIdTicket()?>, '<?=$autocompleteId?>')">Add Hashtag</button>
                <ul id="<?=$autocompleteId?>"></ul>
        </div>


        <?php $hashtags = $ticket->getTicketHashtags($db); ?>
        <div id="hashtag-button-container-<?php echo $ticket->getIdTicket(); ?>">
            <?php foreach ($hashtags as $hashtag) : ?>
                <div class="hashtag-button">
                    <a href="../actions/action_remove_hashtag.php?ticket_id=<?php echo $ticket->getIdTicket()?>&hashtag_id=<?php echo $hashtag['id'] ?>">
                        #<?php echo $hashtag['name'] ?>
                        <img src="../docs/images/icons-multiply.png" alt="remove_hashtag">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        </section>

        <section>
            <article>
                <h5>Departament: <?=$ticket->getTicketDepartmentName($db)?></h5>
                <h5>Status: <?=$status?></h5>
                <h5>Date: <?=$ticket->getCreateDate()?></h5>
            </article>
            <?php
            if($entity>1){
                if($status=="OPEN"){
                    $ticket_id = $ticket->getIdTicket();
                    $agentRequired = $ticket->searchIfRequestedToAssign($db);
                    if(!$agentRequired){
                    ?>
                    <article class="AssignTicket">
                        <form method="post" action="../actions/action_assign_to_agent.php">
                            <button type="submit" name="idTicket" value="<?php echo $ticket_id ?>">
                                Assign Ticket to me
                            </button>
                        </form>
                        <form method="post" action="../pages/agentsAvaiableToAssign.php">
                            <button type="submit" name="idTicket" value="<?php echo $ticket_id ?>">
                                Assign Ticket to other agent
                            </button>
                        </form>
                    </article>
                <?php
                    }
                    else{ ?>
                        <article class="AssignTicket">
                            Ticket already requested to be assign to <?php echo User::getSingleUser($db,$agentRequired)->getName()  ?>
                        </article>
                   <?php }
                }
            }
            ?>
        </section>
    </div>
<?php }

