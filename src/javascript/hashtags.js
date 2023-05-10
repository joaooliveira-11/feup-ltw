function addHashtag() {
    const container = document.querySelector('.hashtags-container');
    const button = document.querySelector('#add-hashtags-button');
  
    if (!container.querySelector('textarea')) {
      const textarea = document.createElement('textarea');
      textarea.setAttribute('name', 'hashtags');
      textarea.setAttribute('placeholder', 'Type a hashtag');
  
      textarea.addEventListener('input', handleHashtagInput);
      textarea.addEventListener('keydown', handleHashtagKeydown);
  
      container.insertBefore(textarea, button.nextSibling);
      setTimeout(() => {
        if (!textarea.value) {
          container.removeChild(textarea);
        }
      }, 30000);
    }
  }
  
  function handleHashtagInput(event) {
    const input = event.target;
    const value = input.value.trim();
  
    if (value && value.length > 1) {
      fetch(`../api/api_get_hashtags.php?q=${value}`)
        .then(response => response.json())
        .then(data => {
          const suggestions = data.map(hashtag => hashtag.name);
          showAutocompleteSuggestions(input, suggestions);
          verifyHashtag(input, value);
        })
        .catch(error => console.log(error));
    } else {
      hideAutocompleteSuggestions(input);
    }
  }
  
  function handleHashtagKeydown(event) {
    const input = event.target;
    const value = input.value.trim();
    const suggestions = input.parentNode.querySelector('.autocomplete-suggestions');
  
    if (event.key === 'Enter' && value) {
      event.preventDefault();
      if (!suggestions || !suggestions.querySelector('.selected')) {
        addHashtagToTicket(input, value);
      }
    } else if (event.key === 'ArrowUp' || event.key === 'ArrowDown') {
      event.preventDefault();
      if (suggestions) {
        const selected = suggestions.querySelector('.selected');
        if (selected) {
          selected.classList.remove('selected');
          const next = event.key === 'ArrowUp' ? selected.previousSibling : selected.nextSibling;
          if (next) {
            next.classList.add('selected');
            input.value = next.innerText;
          }
        } else {
          suggestions.firstChild.classList.add('selected');
          input.value = suggestions.firstChild.innerText;
        }
      }
    }
  }
  
  function showAutocompleteSuggestions(input, suggestions) {
    const container = document.createElement('div');
    container.setAttribute('class', 'autocomplete-suggestions');
  
    suggestions.forEach(suggestion => {
      const suggestionElement = document.createElement('div');
      suggestionElement.setAttribute('class', 'autocomplete-suggestion');
      suggestionElement.innerText = suggestion;
      suggestionElement.addEventListener('click', () => {
        input.value = suggestion;
        addHashtagToTicket(input, suggestion);
        hideAutocompleteSuggestions(input);
      });
      container.appendChild(suggestionElement);
    });
  
    input.parentNode.appendChild(container);
  }
  
  function hideAutocompleteSuggestions(input) {
    const container = input.parentNode.querySelector('.autocomplete-suggestions');
    if (container) {
      input.parentNode.removeChild(container);
    }
  }
  
  function verifyHashtag(input, value) {
    const exists = input.parentNode.querySelector(`[data-name="${value}"]`);
    if (!exists) {
      fetch(`../actions/action_add_hashtag.php`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `hashtag=${value}`
      })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(error => console.log(error));
    }
  }
  
  function addHashtagToTicket(input, value) {
    const container = input.parentNode;
    const textarea = container.querySelector('textarea');
    const ticketId = container.getAttribute('data-ticket-id');
    const hashtagName = value.toLowerCase();
  
    // Verify if hashtag already exists on ticket
    const existingHashtag = container.querySelector(`[data-name="${hashtagName}"]`);
    if (existingHashtag) {
      hideAutocompleteSuggestions(input);
      input.value = '';
      return;
    }
  
    // Create hashtag if it doesn't exist
    fetch(`../actions/action_add_hashtag.php?hashtag=${hashtagName}`)
      .then(response => response.json())
      .then(data => {
        // Add hashtag to ticket_hashtags
        const hashtagId = data.id;
        fetch(`../actions/action_add_hashtag_to_ticket.php?ticket_id=${ticketId}&hashtag_id=${hashtagId}`)
          .then(response => response.json())
          .then(data => {
            // Create new hashtag element
            const hashtagElement = document.createElement('span');
            hashtagElement.setAttribute('class', 'ticket-hashtag');
            hashtagElement.setAttribute('data-name', hashtagName);
            hashtagElement.innerText = `#${hashtagName}`;
            
            // Add remove button
            const removeButton = document.createElement('button');
            removeButton.setAttribute('class', 'remove-hashtag');
            removeButton.innerText = 'x';
            removeButton.addEventListener('click', () => {
              removeHashtagFromTicket(container, hashtagId);
            });
            hashtagElement.appendChild(removeButton);
  
            // Insert new hashtag element
            textarea.parentNode.insertBefore(hashtagElement, textarea);
            hideAutocompleteSuggestions(input);
            input.value = '';
          })
          .catch(error => console.log(error));
      })
      .catch(error => console.log(error));
  }
  