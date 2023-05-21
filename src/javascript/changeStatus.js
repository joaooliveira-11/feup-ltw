const change_ticketstatus_buttons = document.querySelectorAll('.change-status-btn');

change_ticketstatus_buttons.forEach(function(change_ticketstatus_button) {
    const ticket_id = change_ticketstatus_button.getAttribute('data-ticket-id');
    const selectnewstatus = document.createElement('ul');
    selectnewstatus.classList.add("StatuschangeList");
    selectnewstatus.id= "StatuschangeList_"+ticket_id;
    selectnewstatus.style.display="none";
    const filter_new_status = document.querySelector('#status_change_'+ticket_id);
    filter_new_status.appendChild(selectnewstatus);

    let displayStatus2 = false;
    let possiblestatus;

    change_ticketstatus_button.addEventListener('click', async function () {
        const response = await fetch('../api/api_possibleStatus.php?Ticket='+ticket_id );
        possiblestatus = await response.json();
        const filter_search = document.querySelector("#StatuschangeList_"+ticket_id);
        displayStatus2 = !displayStatus2;
        if(!displayStatus2){
            selectnewstatus.style.display = "none";
        }
        else{
            selectnewstatus.style.display = "flex";
        }
        if(filter_search) filter_search.innerHTML = "";
        for (Status of possiblestatus){
            const li = document.createElement('li');
            //const item = document.createElement('button');
            li.value = Department;
            li.innerText = Department;
            li.addEventListener('click', () => updateTicketDepartment(li.value, ticket_id));
            //li.appendChild(item);
            selectnewdepartment.appendChild(li);
        }
    })
    async function updateTicketStatus(Status, Ticket){
        const response = await fetch('../api/api_changeStatus.php?Ticket='+Ticket+'&Status='+Status);
        answer = await response.json();
        location.reload();
    }
})

const change_ticketdepartment_buttons = document.querySelectorAll('.change-department-btn');

change_ticketdepartment_buttons.forEach(function(change_ticketdepartment_button) {
    const ticket_id = change_ticketdepartment_button.getAttribute('data-ticket-id');
    const selectnewdepartment = document.createElement('ul');
    selectnewdepartment.classList.add("DepartmentchangeList");
    selectnewdepartment.id= "DepartmentchangeList_"+ticket_id;
    selectnewdepartment.style.display="none";
    const filter_new_department = document.querySelector('#department_change_'+ticket_id);
    filter_new_department.appendChild(selectnewdepartment);

    let displayDepartment2 = false;
    let possibleDepartment;

    change_ticketdepartment_button.addEventListener('click', async function () {
        const response = await fetch('../api/api_possibleDepartments.php?Ticket='+ticket_id );
        possibleDepartment = await response.json();
        const filter_search = document.querySelector("#DepartmentchangeList_"+ticket_id);
        displayDepartment2 = !displayDepartment2;
        if(!displayDepartment2){
            selectnewdepartment.style.display = "none";
        }
        else{
            selectnewdepartment.style.display = "flex";
        }
        if(filter_search) filter_search.innerHTML = "";
        for (Department of possibleDepartment){
            const item = document.createElement('button');
            item.value = Department;
            item.innerText = Department;
            item.addEventListener('click', () => updateTicketDepartment(item.value, ticket_id));
            selectnewdepartment.appendChild(item);
        }
    })
    async function updateTicketDepartment(Department, Ticket){
        const response = await fetch('../api/api_changeDepartment.php?Ticket='+Ticket+'&Department='+Department);
        answer = await response.json();
        location.reload();
    }
})