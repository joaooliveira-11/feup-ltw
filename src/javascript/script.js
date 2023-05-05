
const filter_department_button = document.getElementById('DepartmentFilterButton');
const filterDepartment = document.createElement('ul');
filterDepartment.classList.add("FilterList");
filterDepartment.style.display="none";
const departments_text = document.createElement("div");
departments_text.innerText = "Departments:";
const filter_section = document.querySelector('#DepartmentFilter');
filter_section.appendChild(filterDepartment);
let display = false;
const ticket_list = document.querySelectorAll(".retangulo");

filter_department_button.addEventListener('click', async function () {
    const response = await fetch('../api/api_departments.php');
    const departments = await response.json();
    const filter_search = document.querySelector(".FilterList");
    display = !display;
    console.log(display);
    if(!display){
        filterDepartment.style.display = "none";
    }
    else{
        filterDepartment.style.display = "block";
    }
    if(filter_search) filter_search.innerHTML = "";
    filterDepartment.appendChild(departments_text);
    for (department of departments){
        const list_item = document.createElement('input');
        list_item.type = "checkbox";
        list_item.value = department[0];
        list_item.checked = true;
        list_item.addEventListener('click',() => updateTicketPage(list_item.value));
        const deptDiv = document.createElement('div');
        deptDiv.id = "DepartmentListObject";
        deptDiv.innerText = department[1];
        deptDiv.appendChild(list_item);
        filterDepartment.appendChild(deptDiv);
    }
})

function updateTicketPage(id){
    ticket_list.forEach(async function (ticket){
        if(ticket.getAttribute('data-department') === id){
            console.log()
            if(ticket.style.display==="none") ticket.style.display = "block";
            else ticket.style.display = "none";
        }
    })
}