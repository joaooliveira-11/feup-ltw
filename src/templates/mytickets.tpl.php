<?php function drawMyTicketPage(array $tickets, PDO $db) { ?>
    <section class ="ticketsPage">
        <div class="yourTickets">
            <p id="TicketStatus" class="TicketStatusTitle">Your tickets:</p>
            <p id="TicketStatus" class= "circuloRed">Opened</p>
            <p id="TicketStatus" class= "circuloYellow">Assigned</p>
            <p id="TicketStatus" class= "circuloGreen">Closed</p>

        </div>
        <section class="TicketOverflow">
            <?php foreach($tickets as $ticket) {
                drawSingleTicket($db,$ticket);
            }?>
        </section>
       
    </section>

<?php }

function drawSingleTicket($db,Ticket $ticket){ ?>
    <?php
        $status = $ticket->getLastTicketStatus($db);
        $backgroundColor="";
        switch ($status){
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
    ?>
    <div class="retangulo <?php echo $backgroundColor ?>">
        <h2 id="ticketText"><?=$ticket->getTitle()?></h2>
        <section>
            <h3 id="ticketDescription"><?=$ticket->getDescription()?></h3>
        </section>
        <section>
            <h5 id="inline">Departament: <?=$ticket->getTicketDepartmentName($db)?></h5>
            <h5 id="inline">Status: <?=$status?></h5>
            <h5 id="inline">Date: <?=$ticket->getCreateDate()?></h5>
        </section>
    </div>
<?php }

