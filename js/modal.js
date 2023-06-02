
function setupModal(modalId, buttonId, closeButtonClass, formId, fetchUrl) {
  // Get the modal
  var modal = document.getElementById(modalId);

  // Get the button that opens the modal
  var btn = document.getElementById(buttonId);

  // Get the <span> element that closes the modal
  var span = document.querySelector('#' + modalId + ' .' + closeButtonClass);

  // Get the message box
  var messageBox = document.querySelector('#' + modalId + ' .message-box');

  if (!modal || !btn || !span || !messageBox) {
    console.error("Modal, button, close-button, or message-box not found for " + modalId);
  } else {
    // When the user clicks the button, open the modal 
    btn.onclick = function() {
      modal.style.display = 'block';
    };

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = 'none';
      messageBox.innerText = '';
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = 'none';
        messageBox.innerText = '';
      }
    };

    // Handle form submission
    document.getElementById(formId).addEventListener('submit', function(event) {
      event.preventDefault();

      messageBox.innerText = 'Loading...';

      fetch(fetchUrl, {
        method: 'POST',
        body: new FormData(event.target), // event.target is the form
      })
        .then(response => {
          if (!response.ok) throw Error(response.statusText);
          return response.json();
        })
        .then(data => {
          // Show the message in the modal
          messageBox.innerText = data.message;

          // If the status code is not 200, it means there was an error
          if (data.statusCode !== 200) {
            // Do something to handle the error, like showing the error message
          } else {
            // Do something to handle the success, like clearing the form and closing the modal
            event.target.reset();
            setTimeout(function() {
              modal.style.display = 'none';
              messageBox.innerText = '';
            }, 2000); // Close the modal after 2 seconds
          }
        })
        .catch(error => {
          // Do something to handle the network error
          console.error('Error:', error);
          messageBox.innerText = 'Error: ' + error;
        });
    });
  }
}

document.addEventListener("DOMContentLoaded", function() {
  // Setup the subscribe modal
  setupModal('subscribe-Modal', 'subscribe-button', 'close-button', 'subscribe-form', 'subscribe.php');

  // Setup the login modal
  setupModal('login-Modal', 'admin-btn', 'close', 'login-form', 'login.php');
});