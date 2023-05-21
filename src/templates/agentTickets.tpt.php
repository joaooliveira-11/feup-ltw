<?php

require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__) . '/templates/myTickets.tpl.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

function drawDepartmentsTicketsMain(array $departmentTickets, PDO $db) { ?>
    <section class = "ticketsPage">
        <section id="Filter" class="yourTickets">
            <article>
                Filter By:
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
            </article>
            <article>
                Order By:
                <div id="PriorityFilter">
                    <button id="PriorityFilterButton">
                        Priority
                        <img src="../docs/images/icon-minus.png">
                    </button>
                </div>
                <div id="DateFilter">
                    <button id="DateFilterButton">
                        Date
                        <img src="../docs/images/icon-minus.png">
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
                            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
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
    <main id ="TicketHistory">
        <section class="TicketChanges">
            <div>
                Last Changes:
            </div>
            <?php foreach ($changes as $change){ ?>
                <div class="Ticket">
                    <p>Status: <?php echo $change['idStatus'] ? Ticket::get_status_name($db, intval($change['idStatus'])) : '-'; ?></p>
                    <p>Department: <?php echo $change['idDepartment'] ? Ticket::get_department_name($db, intval($change['idDepartment'])) : '-'; ?></p>
                    <p>Agent: <?php echo $change['agent'] ? User::getUser_username($db, intval($change['agent'])) : '-'; ?></p>
                    <p>Date: <?php echo $change['date']; ?></p>
                </div>
            <?php } ?>
        </section>
    </main>
<?php } 
