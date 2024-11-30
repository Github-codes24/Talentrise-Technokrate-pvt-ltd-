
  document.getElementById('search-button').addEventListener('click', function() {
    // Get the search input value
    const searchTerm = document.getElementById('search-input').value.toLowerCase();

    // Get all the content
    const boxes = document.querySelectorAll('.ProcessWeFollow');

    // Loop through the boxes and search for the term
    boxes.forEach(function(ProcessWeFollow) {
      const boxContent = ProcessWeFollow.textContent.toLowerCase(); // Search the actual content inside the box

      // Show or hide the box based on whether it contains the search term
      if (boxContent.includes(searchTerm)) {
        ProcessWeFollow.style.display = 'block'; 
      } else {
        ProcessWeFollow.style.display = 'none';
      }
    });
  });

  // Allow pressing Enter key to search as well
  document.getElementById('search-input').addEventListener('keyup', function(event) {
    if (event.key === 'Enter') {
      document.getElementById('search-button').click();
    }
  });
