<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Task 3</title>
</head>

<body>

  <h1>Fill the Form</h1>

  <!-- Create a form with input fields for first name, last name, and an image upload. -->
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">

    <!-- First Name Input -->
    <label for="fname">First Name: </label>
    <input type="text" name="fname" id="fname" oninput="autofill('fname', 'lname', 'fullname')">
    <span class="error" style="color: red;">*</span>
    <br><br>

    <!-- Last Name Input -->
    <label for="lname">Last Name: </label>
    <input type="text" name="lname" id="lname" oninput="autofill('fname', 'lname', 'fullname')">
    <span class="error" style="color: red;">*</span>
    <br><br>

    <!-- Full Name Display -->
    <label for="fullname">Full Name: </label>
    <input type="text" name="fullname" id="fullname" value="" disabled>
    <br><br>

    <!-- Image Upload Input -->
    <label for="image">Choose an image:</label>
    <input type="file" id="image" name="uploadImage">
    <br><br>

    <!-- Input subject and marks -->
    <label for="marks">Subject Marks (Subject|marks): </label>
    <textarea name="marks" id="marks" rows="5" cols="25"></textarea>
    <br><br>

    <!-- Submit Button -->
    <input type="submit" name="submit" id="submit">
  </form>

  <!-- Include form.php for form handling. -->
  <?php require 'form.php'; ?>

  <!-- Include script.js for scripting. -->
  <script src="/js/script.js"></script>

</body>

</html>
