/*
const change_ticketstatus_button = document.getElementById('change-status-btn');
const selectnewstatus = document.createElement('ul');
selectnewstatus.classList.add("StatuschangeList");
selectnewstatus.style.display="none";
const filter_new_status = document.querySelector('#status_change');
filter_new_status.appendChild(selectnewstatus);

let displayStatus2 = false;
let possiblestatus;

change_ticketstatus_button.addEventListener('click', async function () {
    const response = await fetch('../api/api_possibleStatus.php?Ticket='+this.value);
    possiblestatus = await response.json();
    const filter_search = document.querySelector(".StatuschangeList");
    displayStatus2 = !displayStatus2;
    if(!displayStatus2){
        selectnewstatus.style.display = "none";
    }
    else{
        selectnewstatus.style.display = "block";
    }
    if(filter_search) filter_search.innerHTML = "";
    
    for (Status of possiblestatus){
        const item = document.createElement('button');
        item.value = Status;
        item.innerText = Status;
        item.addEventListener('click', () => updateTicketStatus(item.value, this.value));
        selectnewstatus.appendChild(item);
    }
})

async function updateTicketStatus(Status, Ticket){
    const response = await fetch('../api/api_changeStatus.php?Ticket='+Ticket+'&Status='+Status);
    answer = await response.json();
}
*/