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
    ?>
    <div class="retangulo <?php echo $backgroundColor ?>" data-department = "<?php echo $ticket->getidDepartment()?>" data-status ="<?php echo $ticket->getLastTicketStatus($db)?>">
        <h2 class="ticketText"><?=$ticket->getTitle()?></h2>
        <section>
            <h3 class="ticketDescription"><?=$ticket->getDescription()?></h3>
        </section>
        <section>
            <article>
                <h5>Departament: <?=$ticket->getTicketDepartmentName($db)?></h5>
                <h5>Status: <?=$status?></h5>
                <h5>Date: <?=$ticket->getCreateDate()?></h5>
            </article>
            <?php
            $ticket_id = $ticket->getIdTicket();
            if($entity==2){
                if($status=="OPEN"){
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
            else if($entity==3){ ?>
                <article class="AssignTicket">
                        <div id="status_change">
                            <button type="submit" name="Ticket"  id="change-status-btn"  data-ticket-id="<?php echo $ticket_id ?>">
                                Change Status
                            </button>
                        </div>
                </article>
           <?php }
            ?>
        </section>
    </div>
<?php }

