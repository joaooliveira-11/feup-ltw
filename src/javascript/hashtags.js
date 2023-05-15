function addHashtag(idTicket, autocompleteId) {
  const container = document.querySelector(`#ticket-${idTicket} .hashtags-container`);
  const button = container.querySelector('#add-hashtags-button');

  if (!container.querySelector('textarea')) {
    const textarea = document.createElement('textarea');
    textarea.setAttribute('name', 'hashtags');
    textarea.setAttribute('id', `hashtags-${idTicket}`);
    textarea.setAttribute('placeholder', 'Type a hashtag');

    container.insertBefore(textarea, button.nextSibling);
    setTimeout(() => {
      if (!textarea.value) {
        container.removeChild(textarea);
      }
    }, 10000);
  }

  const input = document.getElementById(`hashtags-${idTicket}`);

  if (input) {

    input.addEventListener('focus', function() {
      // Trigger the input event to show the autocomplete options
      const inputEvent = new Event('input');
      this.dispatchEvent(inputEvent);
    });

    input.addEventListener('input', function() {
      const query = this.value;

      // Make an AJAX request to fetch the matching hashtags from the server
      const xhr = new XMLHttpRequest();
      xhr.open('GET', `../javascript/hashtags.php?q=${encodeURIComponent(query)}`, true);
      xhr.onload = function() {
        if (xhr.status === 200) {
          const hashtags = JSON.parse(xhr.responseText);
          console.log(hashtags)
          showAutocomplete(hashtags, input, idTicket, autocompleteId);          
        }
      };
      document.querySelector(`#ticket-${idTicket} .hashtags-container`).classList.remove('active');
      xhr.send();
    });

    input.addEventListener('blur', function() {
      // Delay hiding the autocomplete options to allow the user to click on an option
      document.querySelector(`#ticket-${idTicket} .hashtags-container`).classList.remove('active');
      setTimeout(() => {
        const list = document.getElementById(autocompleteId);
        list.innerHTML = '';
      }, 200);
    });

  } 

}
  
function showAutocomplete(hashtags, input, idTicket, autocompleteId) {
  const list = document.getElementById(autocompleteId);
  const hashtagButtonContainer = document.getElementById(`hashtag-button-container-${idTicket}`);

  document.querySelector(`#ticket-${idTicket} .hashtags-container`).classList.add('active');

  list.innerHTML = '';

  if (hashtags.length === 0) {
    const item = document.createElement('li');
    item.textContent = 'No hashtags found';
    list.appendChild(item);
  }

  for (let i = 0; i < hashtags.length; i++) {
    const hashtag = hashtags[i];
    const item = document.createElement('li');
    item.textContent = hashtag;

    item.addEventListener('mousedown', function(event) {
      event.preventDefault();
      input.value = hashtag;
      list.innerHTML = '';

      // Make an AJAX request to insert the chosen hashtag into the database
      const xhr = new XMLHttpRequest();
      xhr.open('GET', `../javascript/hashtags.php?q=add:${hashtag}:${idTicket}`, true);

      xhr.onload = function() {
        const response = JSON.parse(xhr.responseText);
        const updatedHashtags = response.hashtags;

        const hashtagButtonContainer = document.getElementById(`hashtag-button-container-${idTicket}`);
        if (hashtagButtonContainer) {
          // Clear existing hashtag buttons
          hashtagButtonContainer.innerHTML = '';
        
          // Create and append new hashtag buttons
          updatedHashtags.forEach((updatedHashtag) => {
            const hashtagButton = document.createElement('button');
            hashtagButton.classList.add('hashtag-button');
            hashtagButton.dataset.ticketId = idTicket;
            hashtagButton.dataset.hashtagId = updatedHashtag.id;

            const hashtagText = document.createElement('a');
            hashtagText.text = `#${updatedHashtag.name}`;

            const removeIcon = document.createElement('img');
            removeIcon.src = '../docs/images/icons-multiply.png';
            removeIcon.alt = 'remove_hashtag';

            hashtagButton.appendChild(hashtagText);
            hashtagButton.appendChild(removeIcon);
            hashtagButtonContainer.appendChild(hashtagButton);
          });
        }
          input.parentNode.removeChild(input);
      }
      xhr.send();
      document.querySelector(`#ticket-${idTicket} .hashtags-container`).classList.remove('active');
    });

    list.appendChild(item);
  }
}
