function addHashtag(idTicket) {
    const container = document.querySelector('.hashtags-container');
    const button = document.querySelector('#add-hashtags-button');
  
    if (!container.querySelector('textarea')) {
      const textarea = document.createElement('textarea');
      textarea.setAttribute('name', 'hashtags');
      textarea.setAttribute('id', 'hashtags');
      textarea.setAttribute('placeholder', 'Type a hashtag');
  
      container.insertBefore(textarea, button.nextSibling);
      setTimeout(() => {
        if (!textarea.value) {
          container.removeChild(textarea);
        }
      }, 30000);
    }
  
    const input = document.getElementById('hashtags');
  
    if (input) {
      input.addEventListener('input', function() {
        const query = this.value;
  
        // Make an AJAX request to fetch the matching hashtags from the server
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `../javascript/hashtags.php?q=${encodeURIComponent(query)}`, true);
        xhr.onload = function() {
          if (xhr.status === 200) {
            const hashtags = JSON.parse(xhr.responseText);
            showAutocomplete(hashtags, input, idTicket);          
            }
        };
        xhr.send();
      });
    }
  }
  
  function showAutocomplete(hashtags, input, idTicket) {
    const list = document.getElementById('autocomplete-list');
    list.innerHTML = '';
  
    let i;
    for (i = 0; i < hashtags.length; i++) {
      const hashtag = hashtags[i];
      const item = document.createElement('li');
      item.textContent = hashtag;
      item.addEventListener('click', function() {
        input.value = hashtag; 
        list.innerHTML = '';
      });
      list.appendChild(item);
    }

    list.addEventListener('click', function() {
        const hashtag = this.textContent;
    
        // Make an AJAX request to insert the chosen hashtag into the database
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `../javascript/hashtags.php?q=add:${i+1}:${idTicket}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                console.log(response.message);
            }
        };
        xhr.send();
    
        input.value = hashtag;
        list.innerHTML = '';
    });
}