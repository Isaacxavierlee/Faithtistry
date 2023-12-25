<?php
// Check if SQLite3 extension is available
if (!extension_loaded('sqlite3')) {
    die('SQLite3 extension is not loaded. Please enable it in your PHP configuration.');
}

session_start(); // Start a new session

// Rest of your code...

// Add your database connection logic here
$databaseFile = 'database.sqlite';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {<?php
  session_start(); // Start a new session

  // SQLite database file path
  $databaseFile = 'database.db'; // Replace with your actual database file path

  try {
      // Create a new PDO instance
      $pdo = new PDO("sqlite:$databaseFile");

      // Set the PDO error mode to exception
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Retrieve submitted username and password
      $username = $_POST['username'];
      $password = $_POST['password'];

      // Prepare and execute the SQL statement
      $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
      $stmt->bindParam(':username', $username, PDO::PARAM_STR);
      $stmt->bindParam(':password', $password, PDO::PARAM_STR);
      $stmt->execute();

      // Fetch the result as an associative array
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      // Check if a user was found
      if ($user) {
          // Authentication successful, store user details in the session
          $_SESSION['username'] = $user['username'];
          $_SESSION['user_id'] = $user['id'];

          // Redirect to the dashboard
          header('Location: dashboard.php');
          exit;
      } else {
          // Authentication failed, redirect back to login.php
          header('Location: login.php');
          exit;
      }

  } catch (PDOException $e) {
      die("Database connection failed: " . $e->getMessage());
  }
  ?>

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create a new SQLite3 database or open an existing one
    $db = new SQLite3($databaseFile);

    if (!$db) {
        die("Error: Unable to open the database.\n");
    }

    // Example: Check the username and password against the users table
    $sql = "SELECT * FROM users WHERE username=:username AND password=:password";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':password', $password, SQLITE3_TEXT);

    // Execute the prepared statement
    $result = $stmt->execute();

    // Fetch the result as an associative array
    $user = $result->fetchArray(SQLITE3_ASSOC);

    // Check if a user was found
    if ($user) {
        // Authentication successful, store user details in the session
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];

        // Redirect to the dashboard
        header('Location: dashboard.php');
        exit;
    } else {
        // Authentication failed, redirect back to login.php
        header('Location: login.php');
        exit;
    }

    // Close the database connection
    $db->close();
} else {
    // Redirect back to login.php if the form was not submitted
    header('Location: login.php');
    exit;
}
?>
