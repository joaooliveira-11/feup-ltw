
const filter_department_button = document.getElementById('DepartmentFilterButton');

filter_department_button.addEventListener('click', async function () {
    const response = await fetch('../api/api_departments.php');
    const departments = await response.json();
    var filterDepartment = document.createElement('ul');
    for (department of departments){
        console.log(department);
        filterDepartment.appendChild(department);
    }
})