[![Open in Visual Studio Code](https://classroom.github.com/assets/open-in-vscode-c66648af7eb3fe8bc4f294546bfd86ef473780cde1dea487d3c4ff354943c9ae.svg)](https://classroom.github.com/online_ide?assignment_repo_id=10501973&assignment_repo_type=AssignmentRepo)

All users should be able to (users can simultaneously be clients and agents):
- Register a new account. (DONE)
- Login and Logout. (DONE)
- Edit their profile (at least name, username, password, and e-mail). (DONE)

Clients should be able to:
- Submit a new ticket optionally choosing a department (e.g., "Accounting"). (DONE - upgrade for optionally)
- List and track tickets they have submitted. (DONE)
- Reply to inquiries (e.g., the agent asks for more details) about their tickets and add more information to already submitted tickets. (NOT DONE)

Agents should be able to (they are also clients):
- List tickets from their departments (e.g., "Accounting"), and filter them in different ways (e.g., by date, by assigned agent, by status, by priority, by hashtag). (NOT DONE - BERNA)
- Change the department of a ticket (e.g., the client chose the wrong department). (NOT DONE - JONY)
- Assign a ticket to themselves or someone else. (DONE)
- Change the status of a ticket. Tickets can have many statuses (e.g., open, assigned, closed); some may change automatically (e.g., ticket changes to "assigned" - after being assigned to an agent). (DONE)
- Edit ticket hashtags easily (just type hashtag to add (with autocomplete), and click to remove). (NOT DONE - KIKA)
- List all changes done to a ticket (e.g., status changes, assignments, edits). (NOT DONE)
- Manage the FAQ and use an answer from the FAQ to answer a ticket. (NOT DONE)

Admins should be able to (they are also agents):
- Upgrade a client to an agent or an admin. (NOT DONE)
- Add new departments, statuses, and other relevant entities. (NOT DONE)
- Assign agents to departments. (NOT DONE)
- Control the whole system. (NOT DONE)

Some suggested additional requirements. These requirements are a way of making sure each project is unique. You do not have to implement all of these:
- Tickets can have documents attached to them (both by clients and agents).
- Admins should be able to see key performance indicators and other statistics (e.g., number of tickets closed by agent, number of open tickets per day).
- Agents can belong to more than one department.
- Agents can see a client's history.
- Agents can watch tickets not assigned to them (e.g., when transferring a ticket, the agent can check a box stating that he still wants to follow the ticket).
- Tickets can be merged together or marked as duplicates from another ticket.
- Tickets can have to-do lists that must be completed before the ticket is closed.
- Tasks can also be assigned to agents.
