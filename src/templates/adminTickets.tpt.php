<?php

require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/templates/mytickets.tpl.php');

function drawDepartmentsTicketsMain(array $departmentTickets, PDO $db) { ?>
    <main class = "ticketsPage">
        <section id="Filter">
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
        <?php foreach ($departmentTickets as $ticket){
            drawSingleTicket($db, $ticket);
        } ?>
    </main>
<?php }

function drawAssignedTicketsMain(){ ?>

<?php } ?>

