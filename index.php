<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Task 1</title>
</head>

<body>

  <h1>Fill the Form</h1>
  <!-- Create a form with two input fields for first and last name, and a button to submit the form. -->
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label for="fname">First Name: </label>
    <input 
      type="text" 
      name="fname" 
      id="fname" 
      oninput="autofill('fname', 'lname', 'fullname')">
    <span class="error" style="color: red;">* </span>
    <br><br>

    <label for="lname">Last Name: </label>
    <input 
      type="text" 
      name="lname" 
      id="lname" 
      oninput="autofill('fname', 'lname', 'fullname')">
    <span class="error" style="color: red;">* </span>
    <br><br>

    <label for="name">Full Name: </label>
    <input 
      type="text" 
      name="name" 
      id="fullname" 
      value="" 
      disabled>
    <br><br>

    <input type="submit" name="submit" id="submit">
  </form>

  <!-- Include form.php for form handling. -->
  <?php require 'form.php'; ?>

  <!-- Include script.js for scripting. -->
  <script src="/js/script.js"></script>

</body>

</html>
