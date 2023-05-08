
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

const ticket_list = document.querySelectorAll(".retangulo");
ticket_list_dictionary = [];
ticket_list.forEach(function(ticket,index){
    const ticket_key = `ticket_${index}`;
    ticket_list_dictionary[ticket_key] = 0;
    console.log(ticket_key);
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
        const ticket_key = `ticket_${index}`;
        if(ticket.getAttribute('data-department') === id){
            if (arrayDepartmentsSelected[i]) {
                ticket_list_dictionary[ticket_key]--;
            }
            else {
                ticket_list_dictionary[ticket_key]++;
            }
            if (ticket_list_dictionary[ticket_key] === 0) {
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
        const ticket_key=`ticket_${index}`;
        if(ticket.getAttribute('data-Status') === id) {
            if (arrayStatusSelected[i]) {
                ticket_list_dictionary[ticket_key]--;
            }
            else {
                ticket_list_dictionary[ticket_key]++;
            }
            if (ticket_list_dictionary[ticket_key] === 0) {
                ticket.style.display = "block";
            }
            else {
                ticket.style.display = "none";
            }
        }
    })
}
