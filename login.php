<?php
// login.php
session_start();

if ($_SESSION['logged_in'] == true) {
    $redirectTo = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php?q=4'; // Redirect to requested page or default
    header("Location: $redirectTo");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded credentials
    $validUsername = "admin";
    $validPassword = "password";

    if ($username === $validUsername && $password === $validPassword) {
        $_SESSION['logged_in'] = true;
        $redirectTo = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php?q=4'; // Redirect to requested page or default
        header("Location: $redirectTo");
        exit();
    } else {
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
    <section>
        <h1>Login</h1>
        <form method="post" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <?php if (isset($error)) {
                echo "<p style='color: red;'>$error</p>";
            } ?>
            <button type="submit">Login</button>
        </form>
    </section>
</body>

</html>