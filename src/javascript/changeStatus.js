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
            const item = document.createElement('button');
            item.value = Status;
            item.innerText = Status;
            item.addEventListener('click', () => updateTicketStatus(item.value, ticket_id));
            selectnewstatus.appendChild(item);
        }
    })
    async function updateTicketStatus(Status, Ticket){
        const response = await fetch('../api/api_changeStatus.php?Ticket='+Ticket+'&Status='+Status);
        answer = await response.json();
        location.reload();
    }
})