const messageContainer = document.querySelector('#messages');
const sendMessageForm = document.querySelector('#send-message-form');
const messageInput = document.querySelector('#message-input');

function scrollBar() {
    const lastMessage = messageContainer.lastElementChild;
    if (lastMessage) {
      lastMessage.scrollIntoView({ behavior: 'smooth' });
    }
  }

function loadMessages() {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '../api/api_getMessages.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      const messages = JSON.parse(this.responseText);
      messageContainer.innerHTML = '';
      messages.forEach(function(message) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('message');
        messageElement.classList.add(message.idUser == window.idUser ? 'message-me' : 'message-other');
        messageElement.innerHTML = `
          <div class="message-sender">${message.username}</div>
          <div class="message-content">${message.message}</div>
          <div class="message-timestamp">${message.create_date}</div>
        `;
        messageContainer.appendChild(messageElement);
      });
      scrollBar();
    }
  };
  xhr.send(`Ticket=${encodeURIComponent(ticketId)}`);
}

function sendMessage(event) {
    event.preventDefault();
    const content = messageInput.value.trim();
  
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../api/api_sendMessage.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        const lastReply = JSON.parse(this.responseText);
        const messageElement = document.createElement('div');
        messageElement.classList.add('message');
        messageElement.classList.add(lastReply.idUser == window.idUser ? 'message-me' : 'message-other');
        messageElement.innerHTML = `
          <div class="message-sender">${lastReply.username}</div>
          <div class="message-content">${lastReply.message}</div>
          <div class="message-timestamp">${lastReply.create_date}</div>
        `;
        messageContainer.appendChild(messageElement);
        scrollBar();
      }
    };
    xhr.send(`Ticket=${encodeURIComponent(ticketId)}&content=${encodeURIComponent(content)}`);
    messageInput.value = '';
}

sendMessageForm.addEventListener('submit', sendMessage);
loadMessages();
