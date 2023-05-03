
const filter_department_button = document.getElementById('DepartmentFilterButton');
const filterDepartment = document.createElement('ul');
filterDepartment.classList.add("FilterList");
const filter_section = document.querySelector('#Filter');
filter_section.appendChild(filterDepartment);
let display = false;

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
    for (department of departments){
        console.log(department);
        const list_item = document.createElement('li');
        list_item.textContent = departments;
        filterDepartment.appendChild(list_item);
    }
})