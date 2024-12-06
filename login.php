<?php
// login.php

// Start the session to track user login status
session_start();

// Check if the user is already logged in
if ($_SESSION['logged_in'] == true) {
    // Redirect to the requested page or default to index.php with query parameter q=4
    $redirectTo = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php?q=4';
    header("Location: $redirectTo");
    exit(); // Always call exit after header redirection to stop further script execution
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and assign the form inputs to variables
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded credentials for login (this should be replaced with a secure method like a database lookup)
    $validUsername = "admin";
    $validPassword = "password";

    // Check if the provided credentials match the valid ones
    if ($username === $validUsername && $password === $validPassword) {
        // Successful login, set session variable to indicate user is logged in
        $_SESSION['logged_in'] = true;

        // Redirect to the requested page or default to index.php with query parameter q=4
        $redirectTo = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php?q=4';
        header("Location: $redirectTo");
        exit(); // Always call exit after header redirection to stop further script execution
    } else {
        // Invalid credentials, show error message
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <!-- Login section -->
        <section>
            <h1>Login</h1>
            <!-- Login form -->
            <form method="post" action="login.php">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <br><br>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br><br>

                <!-- Display error message if login fails -->
                <?php if (isset($error)) {
                    echo "<p style='color: red;'>$error</p>";
                } ?>

                <!-- Submit button -->
                <button type="submit">Login</button>
            </form>
        </section>
    </div>
</body>

</html>
