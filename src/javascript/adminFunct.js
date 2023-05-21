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


function drawUsers(users) {
  const usersBody = document.querySelector('#usersBody');
  usersBody.innerHTML = '';

  users.forEach(function(user) {
    const row = document.createElement('tr');
    row.classList.add('availableAgents');

    const usernameCell = document.createElement('td');
    usernameCell.textContent = user.username;
    row.appendChild(usernameCell);

    const nameCell = document.createElement('td');
    nameCell.textContent = user.name;
    row.appendChild(nameCell);

    const roleCell = document.createElement('td');
    roleCell.textContent = user.roleName;
    row.appendChild(roleCell);

    const actionsCell = document.createElement('td');
    actionsCell.id = 'actionsManageUsers';

    if (user.role < 3) {
      const upgradeForm = document.createElement('form');
      upgradeForm.method = 'post';
      upgradeForm.action = '../actions/action_upgrade_user.php';

      const userIdInput = document.createElement('input');
      userIdInput.type = 'hidden';
      userIdInput.name = 'user';
      userIdInput.value = user.userid;
      upgradeForm.appendChild(userIdInput);

      const roleIdInput = document.createElement('input');
      roleIdInput.type = 'hidden';
      roleIdInput.name = 'role';
      roleIdInput.value = user.role;
      upgradeForm.appendChild(roleIdInput);

      const upgradeButton = document.createElement('button');
      upgradeButton.type = 'submit';
      upgradeButton.textContent = 'Upgrade to ' + (user.role < 2 ? 'Agent' : 'Admin');

      upgradeForm.appendChild(upgradeButton);
      actionsCell.appendChild(upgradeForm);

      upgradeForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_upgrade_user.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
          if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            loadUsers();
          }
        };
        xhr.send(`user=${encodeURIComponent(user.userid)}&role=${encodeURIComponent(user.role + 1)}`);
      });

      if (user.role === 1) {
        const banForm = document.createElement('form');
        banForm.method = 'post';
        banForm.action = '../pages/banUser.php';

        const banButton = document.createElement('button');
        banButton.type = 'submit';
        banButton.name = 'idUser';
        banButton.value = user.userid;
        banButton.textContent = 'Ban User';

        banForm.appendChild(banButton);
        actionsCell.appendChild(banForm);
      }
    }

    row.appendChild(actionsCell);
    usersBody.appendChild(row);
  });
}

function loadUsers() {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '../api/api_getUsers.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      const users = JSON.parse(this.responseText);
      drawUsers(users);
    }
  };
  xhr.send();
}

loadUsers();

