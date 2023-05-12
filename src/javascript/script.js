
const filter_department_button = document.getElementById('DepartmentFilterButton');
const filterDepartment = document.createElement('ul');
filterDepartment.classList.add("FilterListDepartment");
filterDepartment.style.display="none";
const filter_section_Departments = document.querySelector('#DepartmentFilter');
filter_section_Departments.appendChild(filterDepartment);
let displayDepartments = false;
let departments;

const filter_status_button = document.getElementById('StatusFilterButton');
const filterStatus = document.createElement('ul');
filterStatus.classList.add("FilterListStatus");
filterDepartment.style.display="none";
const filter_section_Status = document.querySelector('#StatusFilter');
filter_section_Status.appendChild(filterStatus);
let displayStatus = false;
let statuses;

const order_date_button = document.getElementById("DateFilterButton");
let date_order = 0;
let image = document.querySelector('#DateFilterButton img');
order_date_button.appendChild(image);

let ticket_list = document.querySelectorAll(".retangulo");
let ticket_list_dictionary = [];
let dictionaryForOrder = [];
let arrayToOrder = [];
ticket_list.forEach(function(ticket,index){
    ticket_list_dictionary[index] = 0;
    dictionaryForOrder[index] = ticket;
    arrayToOrder.push(index);
})

let arrayDepartmentsSelected=[];
let arrayStatusSelected=[];

filter_department_button.addEventListener('click', async function () {
    const response = await fetch('../api/api_departments.php');
    departments = await response.json();
    const filter_search = document.querySelector(".FilterListDepartment");
    displayDepartments = !displayDepartments;
    if(!displayDepartments){
        filterDepartment.style.display = "none";
    }
    else{
        filterDepartment.style.display = "block";
    }
    if(filter_search) filter_search.innerHTML = "";
    if(arrayDepartmentsSelected.length===0){
        for(let i=0;i<departments.length;i++){
            arrayDepartmentsSelected.push(true);
        }
    }
    for (let i=0;i<departments.length;i++){
        const list_item = document.createElement('input');
        list_item.type = "checkbox";
        list_item.value = departments[i][0];
        list_item.checked = arrayDepartmentsSelected[i];
        list_item.addEventListener('click',() => updateTicketPageDepartment(list_item.value, i));
        const deptDiv = document.createElement('div');
        deptDiv.innerText = departments[i][1];
        deptDiv.appendChild(list_item);
        filterDepartment.appendChild(deptDiv);
    }
})

function updateTicketPageDepartment(id,i){
    arrayDepartmentsSelected[i] = !arrayDepartmentsSelected[i];
    ticket_list.forEach(async function (ticket,index){
        if(ticket.getAttribute('data-department') === id){
            if (arrayDepartmentsSelected[i]) {
                ticket_list_dictionary[index]--;
            }
            else {
                ticket_list_dictionary[index]++;
            }
            if (ticket_list_dictionary[index] === 0) {
                ticket.style.display = "block";
            }
            else {
                ticket.style.display = "none";
            }
        }
    })
}


filter_status_button.addEventListener('click',async function (){
    const response = await fetch('../api/api_getAllStatus.php');
    statuses = await response.json();
    const filter_search = document.querySelector(".FilterListStatus");
    displayStatus = !displayStatus;
    if(!displayStatus){
        filterStatus.style.display = "none";
    }
    else{
        filterStatus.style.display = "block";
    }
    if(filter_search) filter_search.innerHTML = "";
    if(arrayStatusSelected.length===0){
        for(let i=0;i<statuses.length;i++){
            arrayStatusSelected.push(true);
        }
    }
    for (let i=0;i<statuses.length;i++){
        const list_item = document.createElement('input');
        list_item.type = "checkbox";
        list_item.value = statuses[i];
        list_item.checked = arrayStatusSelected[i];
        list_item.addEventListener('click',() => updateTicketPageStatus(list_item.value, i));
        const deptDiv = document.createElement('div');
        deptDiv.innerText = statuses[i];
        deptDiv.appendChild(list_item);
        filterStatus.appendChild(deptDiv);
    }
})

function updateTicketPageStatus(id, i){
    arrayStatusSelected[i] = !arrayStatusSelected[i];
    ticket_list.forEach(async function (ticket,index){
        if(ticket.getAttribute('data-Status') === id) {
            if (arrayStatusSelected[i]) {
                ticket_list_dictionary[index]--;
            }
            else {
                ticket_list_dictionary[index]++;
            }
            if (ticket_list_dictionary[index] === 0) {
                ticket.style.display = "block";
            }
            else {
                ticket.style.display = "none";
            }
        }
    })
}

order_date_button.addEventListener('click',async function(){
    date_order++;
    if(date_order===1){
        image.src = '../docs/images/seta_para_baixo.png'
    }
    else if(date_order===2){
        image.src = '../docs/images/seta_para_cima.png'
    }
    else {
        date_order=0;
        image.src='../docs/images/icon-minus.png';

    }
    sectionParent = ticket_list[0].parentNode;
    if(date_order===0){
        for(i= ticket_list.length-1;i>0;i--){
            sectionParent.insertBefore(ticket_list[i-1],ticket_list[i]);
        }
    }
    else {
        for (i = 0; i < arrayToOrder.length - 1; i++) {
            let imin = i;
            for (j = i + 1; j <arrayToOrder.length; j++) {
                const ticketA = dictionaryForOrder[imin];
                const ticketA_date = ticketA.querySelector("section:last-child h5:nth-child(3)").getAttribute('data-date');
                const ticketA_realDate = dateToNumber(ticketA_date);
                const ticketB = dictionaryForOrder[j];
                const ticketB_date = ticketB.querySelector("section:last-child h5:nth-child(3)").getAttribute('data-date');
                const ticketB_realDate = dateToNumber(ticketB_date);
                if (date_order === 1) {
                    if (ticketA_realDate < ticketB_realDate) {
                        imin = j;
                    }
                } else if (date_order === 2) {
                    if (ticketA_realDate > ticketB_realDate) {
                        imin = j;
                    }
                }
            }
            changePosition(i,imin,sectionParent);
            if(date_order===1) {
            }
        }
        for(i= ticket_list.length-1;i>0;i--){
            sectionParent.insertBefore(dictionaryForOrder[i-1],dictionaryForOrder[i]);
        }
    }
})


function changePosition(i,j,parent){
    const temp = dictionaryForOrder[arrayToOrder[i]];
    dictionaryForOrder[arrayToOrder[i]] = dictionaryForOrder[arrayToOrder[j]];
    dictionaryForOrder[arrayToOrder[j]] = temp;
}

function dateToNumber(date){
    let parts = date.split('-');
    let day = parts[0];
    let month = parts[1];
    let year = parts[2];

    return parseInt(day) + parseInt(month)*100 + parseInt(year)*10000;
}