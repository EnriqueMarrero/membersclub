<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BETA</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Sedgwick+Ave+Display&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/modal.css">
  <link rel="stylesheet" href="css/matrix.css">
</head>
<body class="light">
<div id="preloader">
  <div id="preloader-top" class="preloader-half"></div>
  <div id="preloader-bottom" class="preloader-half"></div>
  <div id="loading-logo-container">
    <svg id="ethereum-logo" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="100%" height="100%" version="1.1" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 784.37 1277.39" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xodm="http://www.corel.com/coreldraw/odm/2003">
      <g id="Layer_x0020_1">
        <metadata id="CorelCorpID_0Corel-Layer"/>
        <g id="_1421394342400">
          <g>
            <polygon class="eth-logo-part" fill="#343434" fill-rule="nonzero" points="392.07,0 383.5,29.11 383.5,873.74 392.07,882.29 784.13,650.54 "/>
            <polygon class="eth-logo-part" fill="#8C8C8C" fill-rule="nonzero" points="392.07,0 -0,650.54 392.07,882.29 392.07,472.33 "/>
            <polygon class="eth-logo-part" fill="#3C3C3B" fill-rule="nonzero" points="392.07,956.52 387.24,962.41 387.24,1263.28 392.07,1277.38 784.37,724.89 "/>
            <polygon class="eth-logo-part" fill="#8C8C8C" fill-rule="nonzero" points="392.07,1277.38 392.07,956.52 -0,724.89 "/>
            <polygon class="eth-logo-part" fill="#141414" fill-rule="nonzero" points="392.07,882.29 784.13,650.54 392.07,472.33 "/>
            <polygon class="eth-logo-part" fill="#393939" fill-rule="nonzero" points="0,650.54 392.07,882.29 392.07,472.33 "/>
          </g>
        </g>
      </g>
    </svg>
    <div id="loading-text">Loading...</div>
  </div>
</div>

  <canvas id="matrix-canvas"></canvas>
  <header>
    <button id="admin-btn" class="btn">Admin Access</button>
    <button id="wallet-button" class="btn">EARLY ACCESS</button>
    <button id="disconnect-wallet-button" style="display: none;">Disconnect Wallet</button>
  </header>
  <main>
    <div class="center-content">
      <div class="text-container animated-text">
        <span id="animated-span" class="hidden"></span>
      </div>
      <div class="content-container">
        <div class="card">
          <div class="card__face card__face--front">
            <img id="main-image" class="pfp" src="img/pfp.jpeg" alt="Your Image" />
          </div>
          <div class="card__face card__face--back">
            <img id="back-image" class="pfp" src="img/pfp-2.jpeg" alt="Your Image" />
          </div>
        </div>
      </div>

      <div id="social-media-icons">
        <a href="your-instagram-url"><i class="fab fa-instagram"></i></a>
        <a href="your-twitter-url"><i class="fab fa-twitter"></i></a>
        <a href="your-facebook-url"><i class="fab fa-discord"></i></a>
      </div>
      <button id="subscribe-button" class="btn">PRE-REGISTER</button>
    </div>
  </main>
  <?php include 'footer.php';?>

  <!-- LOGIN MODAL -->
  <div id="login-Modal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Login</h2>
      <div class="message-box"></div>
      <form id="login-form" action="login.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="pwd">Password:</label><br>
        <input type="password" id="pwd" name="password"><br>
        <label for="remember-me">
          <input type="checkbox" id="remember-me" name="remember-me"> Remember Me
        </label><br>
        <input type="submit" value="Submit">
      </form>
    </div>
  </div>

  <!-- SUBSCRIBE MODAL -->
  <div id="subscribe-Modal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close-button">&times;</span>
      <h2>STAY AHEAD OF LAUNCH</h2>
      <div class="message-box"></div>
      <form id="subscribe-form" action="subscribe.php" method="post">
        <input type="email" id="email" name="email" placeholder="Your email address" required>
        <input type="submit" value="SUBSCRIBE">
      </form>
    </div>
  </div>

  <script>
    window.addEventListener('load', () => {
      const preloader = document.getElementById('preloader');
      preloader.style.transition = 'opacity 0.5s ease'; // Add CSS transition for smooth fade

      setTimeout(() => {
        preloader.style.opacity = '0'; // Set opacity to 0 for fade-out effect

        // After the fade-out animation, hide the preloader
        setTimeout(() => {
          preloader.style.display = 'none';
        }, 500); // wait for 0.5 seconds (matching the transition duration)
      }, 1000); // wait for 3 seconds
    });

    $(document).ready(function () {
      // Check if there is a saved username and set it in the input field
      var savedUsername = localStorage.getItem('savedUsername');
      if (savedUsername) {
        $('#username').val(savedUsername);
      }

      $("#login-form").submit(function (event) {
        event.preventDefault(); // Prevent the form from submitting normally

        // Get the form data
        var formData = $(this).serialize();

        // Check if Remember Me checkbox is checked
        var rememberMe = $('#remember-me').is(':checked');
        if (rememberMe) {
          // Save the username in local storage
          var username = $('#username').val();
          localStorage.setItem('savedUsername', username);
        } else {
          // Clear the saved username from local storage
          localStorage.removeItem('savedUsername');
        }

        // Send an AJAX request to the login.php script
        $.ajax({
          type: "POST",
          url: "login.php",
          data: formData,
          dataType: "json",
          success: function (response) {
            // Check the status in the response
            if (response.status === 1) {
              // Successful login
              $(".message-box").text(response.message);

              // Redirect to the dashboard page
              window.location.href = response.redirect;
            } else {
              // Display the error message
              $(".message-box").text(response.message);
            }
          },
          error: function () {
            // Display an error message
            $(".message-box").text("An error occurred during the login process.");
          }
        });
      });
    });

    $(document).ready(function () {
      // Check if the user is logged in
      var loggedIn = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;

      // Function to update the admin access button text and behavior based on login status
      function updateAdminButton() {
        var adminButton = $('#admin-btn');
        if (loggedIn) {
          var username = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>";
          adminButton.text("Welcome, " + username);
          adminButton.click(function () {
            window.location.href = "admin/index.php";
          });
        } else {
          adminButton.text("Admin Access");
          adminButton.click(function () {
            // Show the login modal or perform other actions
            // Add your logic here
          });
        }
      }

      // Call the updateAdminButton function on page load
      updateAdminButton();

      // Update the admin access button on subsequent page loads using AJAX
      $(document).ajaxComplete(function () {
        updateAdminButton();
      });
    });

    async function connectWallet() {
      if (window.ethereum) {
        try {
          // Request access to the user's MetaMask accounts
          await ethereum.request({ method: 'eth_requestAccounts' });

          // Get the selected account
          const accounts = await ethereum.request({ method: 'eth_accounts' });
          const selectedAccount = accounts[0];

          console.log('Connected to MetaMask');
          console.log('Selected Account:', selectedAccount);

          // Update button state
          $('#wallet-button').hide();
          $('#disconnect-wallet-button').show();
        } catch (error) {
          console.error('Error connecting to MetaMask:', error);
        }
      } else {
        console.error('MetaMask not found');
      }
    }

    async function disconnectWallet() {
      if (window.ethereum) {
        try {
          // Disconnect from MetaMask
          await ethereum.request({ method: 'wallet_requestPermissions', params: [{ eth_accounts: {} }] });

          console.log('Disconnected from MetaMask');

          // Update button state
          $('#wallet-button').show();
          $('#disconnect-wallet-button').hide();
        } catch (error) {
          console.error('Error disconnecting from MetaMask:', error);
        }
      } else {
        console.error('MetaMask not found');
      }
    }

    window.addEventListener('load', () => {
      const connectWalletButton = document.getElementById('wallet-button');
      const disconnectWalletButton = document.getElementById('disconnect-wallet-button');

      connectWalletButton.addEventListener('click', connectWallet);
      disconnectWalletButton.addEventListener('click', disconnectWallet);
    });
  </script>
  <script src="js/main.js"></script>
  <script src="js/modal.js"></script>
  <script src="js/matrix.js"></script>
</body>
</html>