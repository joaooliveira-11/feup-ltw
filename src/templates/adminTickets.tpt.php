<?php

require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/templates/mytickets.tpl.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

function drawDepartmentsTicketsMain(array $departmentTickets, PDO $db) { ?>
    <section class = "ticketsPage">
        <section id="Filter" class="yourTickets">
            Filter by:
            <article>
                <div id="DepartmentFilter">
                    <button id="DepartmentFilterButton">
                        Department
                    </button>
                </div>
                <div id="StatusFilter">
                    <button id="StatusFilterButton">
                        Ticket Status
                    </button>
                </div>
                <div id="DateFilter">
                    <button id="DateFilterButton">
                        Date
                    </button>
                </div>
            </article>
        </section>
        <section class="TicketOverflow">
            <?php foreach ($departmentTickets as $ticket){
                drawSingleTicket($db, $ticket, 2);
            } ?>
        </section>
    </section>
<?php }


function drawAssignedTicketsMain(array $assignedTickets, PDO $db){ ?>
    <section class="TicketOverflow">
        <?php foreach ($assignedTickets as $ticket){
            drawSingleTicket($db, $ticket, 3);
        } ?>
    </section>
<?php }

function drawAgentsAvailableMain(int $idTicket, array $users){ ?>
    <main class="noPadding">
        <table>
            <thead>
            <tr>
                <th>Available Agents</th>
                <th>Number of tickets solving</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($users as $user){ ?>
                <tr class="availableAgents">
                    <th><?php echo $user[0] ?></th>
                    <th><?php echo $user[1] ?></th>
                    <th>
                        <form method="post" action="../actions/action_inquiry.php">
                            <input type="hidden" name="idTicket" value="<?php echo $idTicket?>">
                            <input type="hidden" name="idUserReceiving" value="<?php echo $user[2]?>">
                            <input type="hidden" name="type" value="ASSIGN_AGENT">
                            <button type="submit">Select</button>
                        </form>
                    </th>
                </tr>
        <?php }
        ?>
            </tbody>
        </table>
    </main>
<?php }

function drawTicketHistory(array $changes, PDO $db){ ?>
    <section class="TicketChanges">
        <?php foreach ($changes as $change){ ?>
            <div class="Ticket">
                <p>Status: <?php echo $change['idStatus'] ? Ticket::get_status_name($db, intval($change['idStatus'])) : '-'; ?></p>
                <p>Department: <?php echo $change['idDepartment'] ? Ticket::get_department_name($db, intval($change['idDepartment'])) : '-'; ?></p>
                <p>Agent: <?php echo $change['agent'] ? User::getUser_username($db, intval($change['agent'])) : '-'; ?></p>
                <p>Date: <?php echo $change['date']; ?></p>
            </div>
        <?php } ?>
    </section>
<?php } 
