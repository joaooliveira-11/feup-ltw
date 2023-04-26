<?php

require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/templates/mytickets.tpl.php');

function drawDepartmentsTicketsMain(array $departmentTickets, PDO $db) { ?>
    <section class = "ticketsPage">
        <section id="Filter" class="yourTickets" >
            Filter by:
            <button>
                Department
            </button>
            <button>
                Ticket Status
            </button>
            <button>
                Date
            </button>
        </section>
        <section class="TicketOverflow">
            <?php foreach ($departmentTickets as $ticket){
                drawSingleTicket($db, $ticket);
            } ?>
        </section>
    </section>
<?php }

function drawAssignedTicketsMain(){ ?>

<?php } ?>

