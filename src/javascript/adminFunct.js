function removeAgent(id) {
  document.getElementById(id).remove();
}

function selectAgent(userId) {
  const idDepartment = document.querySelector('#departinput').value;
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '../api/api_addDepartAgent.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      removeAgent(userId);
    }
  };
  xhr.send(`user=${encodeURIComponent(userId)}&department=${encodeURIComponent(idDepartment)}`);
}

const agentsOutsideForms = document.querySelectorAll('.agentsOutside');
agentsOutsideForms.forEach(function(form) {
  form.addEventListener('submit', function(event) {
    event.preventDefault();

    const userId = form.querySelector('input[name="idUser"]').value;

    selectAgent(userId);
  });
});

