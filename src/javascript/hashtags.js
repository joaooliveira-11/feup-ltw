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
    }, 30000);
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
      document.querySelector('.hashtags-container').classList.remove('active');
      setTimeout(() => {
        const list = document.getElementById(autocompleteId);
        list.innerHTML = '';
      }, 200);
    });

  } 

}
  
function showAutocomplete(hashtags, input, idTicket, autocompleteId) {
  const list = document.getElementById(autocompleteId);
  document.querySelector(`#ticket-${idTicket} .hashtags-container`).classList.add('active');

  list.innerHTML = '';

  for (let i = 0; i < hashtags.length; i++) {
    const hashtag = hashtags[i];
    const item = document.createElement('li');
    item.textContent = hashtag;
    item.addEventListener('mousedown', function(event) {
      // Prevent the input box from losing focus when an autocomplete option is clicked
      event.preventDefault();
      input.value = hashtag;
      list.innerHTML = '';

      // Make an AJAX request to insert the chosen hashtag into the database
      const xhr = new XMLHttpRequest();
      xhr.open('GET', `../javascript/hashtags.php?q=add:${hashtag}:${idTicket}`, true);
      xhr.onload = function() {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          console.log(response.message);
        }
      };
      xhr.send();
      document.querySelector(`#ticket-${idTicket} .hashtags-container`).classList.remove('active');

    });
    list.appendChild(item);
  }
}

  