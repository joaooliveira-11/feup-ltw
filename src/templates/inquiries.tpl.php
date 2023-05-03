<?php

function drawUserInquiries(PDO $db, array $inquiries){ ?>
    <main id="Inquiries">
        <?php
        foreach ($inquiries as $inquiry){
            $inquiryType = $inquiry->getType();
            if($inquiryType=="ASSIGN_AGENT"){
                drawTicketAssignRequest($db,$inquiry);
            }
        }
        ?>
    </main>
<?php }

function drawTicketAssignRequest(PDO $db, Inquiry $inquiry){
    $userRequesting = User::getSingleUser($db,$inquiry->getUserGiving());
    $ticket=Ticket::getTicketFromId($db,$inquiry->getTicket())?>
    <section class="retangulo">
        <h5> Requested by: <?php echo $userRequesting->getName() ?></h5>
        <h2 class="ticketText"> <?php echo $ticket->getTitle() ?></h2>
        <section class="ticketDescription">
            <?php echo $ticket->getDescription() ?>
        </section>
        <section>
            <article>
                <h5>Departament: <?=$ticket->getTicketDepartmentName($db)?></h5>
                <h5>Status: <?=$ticket->getLastTicketStatus($db)?></h5>
                <h5>Date: <?=$ticket->getCreateDate()?></h5>
            </article>
            <article class="AssignTicket">
                <form method="post" action="../actions/action_assign_to_agent.php">
                    <input type="hidden" name="Inquiry" value="<?php echo $inquiry->getIdInquiry() ?>">
                    <button id="AcceptTicketFromInquiry" type="submit" name="idTicket" value="<?php echo $ticket->getIdTicket() ?>">
                        Accept
                    </button>
                </form>
                <form method="post" action="../actions/action_deleteInquiry.php">
                    <button id="RejectTicketFromInquiry" type="submit" name="idInquiry" value="<?php echo $inquiry->getIdInquiry() ?>">
                        Reject
                    </button>
                </form>
            </article>
        </section>
    </section>
<?php }