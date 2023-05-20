console.log('hashtags.js loaded');

function addHashtag(idTicket, autocompleteId) {
  console.log('addHashtag() called');
  
  const container = document.querySelector(`#hashtags-container-${idTicket}`);

  console.log(container);
  if (!container) {
    // Container element not found, do something (e.g., log an error message)
    console.error(`Container element not found for ticket ${idTicket}`);
    return;
  }

  const button = container.querySelector(`#add-hashtags-button-${idTicket}`);

  if (!button) {
    console.error(`Button element not found for ticket ${idTicket}`);
    return;
  }
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
      xhr.open('GET', `../api/api_hashtags.php?q=${encodeURIComponent(query)}`, true);
      xhr.onload = function() {
        if (xhr.status === 200) {
          const hashtags = JSON.parse(xhr.responseText);
          showAutocomplete(hashtags, input, idTicket, autocompleteId);          
        }
      };
      document.querySelector(`#hashtags-container-${idTicket}`).classList.remove('active');
      xhr.send();
    });

    input.addEventListener('blur', function() {
      // Delay hiding the autocomplete options to allow the user to click on an option
      document.querySelector(`#hashtags-container-${idTicket}`).classList.remove('active');
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

  document.querySelector(`#hashtags-container-${idTicket}`).classList.add('active');

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

      const xhr = new XMLHttpRequest();
      xhr.open('GET', `../api/api_hashtags.php?q=add:${hashtag}:${idTicket}`, true);

      xhr.onload = function() {
        const response = JSON.parse(xhr.responseText);
        const updatedHashtags = response.hashtags;

        const hashtagButtonContainer = document.getElementById(`hashtag-button-container-${idTicket}`);

        if (hashtagButtonContainer) {
          hashtagButtonContainer.innerHTML = '';
        
          updatedHashtags.forEach((updatedHashtag) => {
            const hashtagButton = document.createElement('button');
            hashtagButton.classList.add('hashtag-button');
            hashtagButton.dataset.ticketId = idTicket;
            hashtagButton.dataset.hashtagId = updatedHashtag.idHashtag;
            hashtagButton.id = `hashtag-button-${idTicket}-${updatedHashtag.idHashtag}`;

            const hashtagText = document.createElement('a');
            hashtagText.text = `#${updatedHashtag.name}`;

            const removeIcon = document.createElement('img');
            removeIcon.src = '../docs/images/icons-multiply.png';
            removeIcon.alt = 'remove_hashtag';

            hashtagButton.appendChild(hashtagText);
            hashtagButton.appendChild(removeIcon);
            hashtagButtonContainer.appendChild(hashtagButton);
            hashtagButton.setAttribute('onclick', `removeHashtag(${idTicket}, ${updatedHashtag.idHashtag});`);
          });
        }
          input.parentNode.removeChild(input);
      }
      xhr.send();
      document.querySelector(`#hashtags-container-${idTicket}`).classList.remove('active');
    });

    list.appendChild(item);
  }
}

function removeHashtag(ticketId, hashtagId) {
 console.log('hereeee');
  const xhr = new XMLHttpRequest();
  xhr.open('POST', `../api/api_hashtags.php?q=remove:${hashtagId}:${ticketId}`, true);
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {

      var buttonId = "hashtag-button-" + ticketId + "-" + hashtagId;
      var button = document.getElementById(buttonId);
      if (button) {
        button.parentNode.removeChild(button);
      }
    }
  };
  
  xhr.send();
}