<?php function drawMyTicketPage(array $tickets, PDO $db) { ?>
    <section id="tickets">
        <div id="yourTickets">
            <p id="TicketStatus" class="TicketStatusTitle">Your tickets:</p>
            <p id="TicketStatus" class= "circuloRed">Opened</p>
            <p id="TicketStatus" class= "circuloYellow">Assigned</p>
            <p id="TicketStatus" class= "circuloGreen">Closed</p>

        </div>
        
        <?php foreach($tickets as $ticket) {?>
            <div class="retangulo">
                <h3 id="ticketText"><?=$ticket->getTitle()?></h3>
                <p class="blackLine"><p>
                <h3 id="ticketDescription"><?=$ticket->getDescription()?></h3>
                <p class="blackLine"><p>
                <h3 id="inline">Departament: <?=$ticket->getTicketDepartmentName($db)?></h3>
                <h3 id="inline">Status: <?=$ticket->getLastTicketStatus($db)?></h3>
                <h3 id="inline">Date: <?=$ticket->getCreateDate()?></h3>
                </p>
            </div>  
        <?php }?>
       
    </section>

<?php } ?>
