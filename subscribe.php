<?php
header('Content-Type: application/json'); // Set the response content type to JSON

$servername = "72.167.64.115";
$username = "techplug";
$password = "P@ssw0rd321!";
$dbname = "ask777";

$message = '';
$statusCode = 200;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  $statusCode = 500;
  $message = "Connection failed: " . $conn->connect_error;
} else {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $statusCode = 400;
      $message = "Invalid email format";
    } else {
      $sql = "SELECT * FROM Subscribers WHERE email='$email'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        $statusCode = 400;
        $message = "Email already exists";
      } else {
        $sql = "INSERT INTO Subscribers (email) VALUES ('$email')";

        if ($conn->query($sql) === TRUE) {
          $message = "You have successfully subscribed";

          // Email parameters
          $to = $email;
          $subject = "Subscription Confirmation";

          // Email content
          $template = "
            <html>
            <head>
            <title>Subscription Confirmation</title>
            </head>
            <body>
            <div style='background-color: red; color: black; padding: 10px;'>
            <h1>Subscription Confirmation</h1>
            </div>
            <div style='background-color: black; color: white; padding: 10px;'>
            <p>Thank you for subscribing! You are now confirmed in our database.</p>
            </div>
            </body>
            </html>
          ";

          // Email headers
          $headers = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
          $headers .= "From: non-reply@membersclub.io\r\n";

          // Send the email
          if (!mail($to, $subject, $template, $headers)) {
            $message = "Email sending failed...";
          }

        } else {
          $statusCode = 500;
          $message = "Error: " . $sql . "<br>" . $conn->error;
        }
      }
    }
  }
}

$conn->close();

// Return a JSON response
echo json_encode(['statusCode' => $statusCode, 'message' => $message]);
?>
<?php
header('Content-Type: application/json'); // Set the response content type to JSON

$servername = "72.167.64.115";
$username = "techplug";
$password = "P@ssw0rd321!";
$dbname = "ask777";

$message = '';
$statusCode = 200;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  $statusCode = 500;
  $message = "Connection failed: " . $conn->connect_error;
} else {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $statusCode = 400;
      $message = "Invalid email format";
    } else {
      $sql = "SELECT * FROM Subscribers WHERE email='$email'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        $statusCode = 400;
        $message = "Email already exists";
      } else {
        $sql = "INSERT INTO Subscribers (email) VALUES ('$email')";

        if ($conn->query($sql) === TRUE) {
          $message = "You have successfully subscribed";

          // Email parameters
          $to = $email;
          $subject = "Subscription Confirmation";

          // Email content
          $template = "
            <html>
            <head>
            <title>Subscription Confirmation</title>
            </head>
            <body>
            <div style='background-color: red; color: black; padding: 10px;'>
            <h1>Subscription Confirmation</h1>
            </div>
            <div style='background-color: black; color: white; padding: 10px;'>
            <p>Thank you for subscribing! You are now confirmed in our database.</p>
            </div>
            </body>
            </html>
          ";

          // Email headers
          $headers = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
          $headers .= "From: non-reply@membersclub.io\r\n";

          // Send the email
          if (!mail($to, $subject, $template, $headers)) {
            $message = "Email sending failed...";
          }

        } else {
          $statusCode = 500;
          $message = "Error: " . $sql . "<br>" . $conn->error;
        }
      }
    }
  }
}

$conn->close();

// Return a JSON response
echo json_encode(['statusCode' => $statusCode, 'message' => $message]);
?>
