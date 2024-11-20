<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP task</title>
</head>

<body>

  <?php require 'task1.php'; ?>

  <h1>PHP Form</h1>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
    <label for="fname">First Name: </label>
    <input type="text" name="fname">
    <span class="error" style="color: red;">* <?php echo $formdata->fnameErr; ?></span>
    <br><br>
    <label for="lname">Last Name: </label>
    <input type="text" name="lname">
    <span class="error" style="color: red;">* <?php echo $formdata->lnameErr; ?></span>
    <br><br>
    <label for="name">Full Name: </label>
    <input type="text" name="name" value="<?php echo $formdata->name; ?>" disabled>
    <br><br>
    <label for="fileToUpload">Select some image:</label>
    <input type="file" id="fileToUpload" name="fileToUpload" />
    <br><br>
    <label for="marks">Subject Marks (Subject|marks) :</label>
    <textarea name="marks" id="marks" rows="5" cols="25"></textarea>
    <br><br>
    <input type="submit" name="submit" id="submit">
  </form>
  <br>


  <?php
  require 'upload.php';
  $formdata->marksValidate();
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $fileobject->validate();
    echo '<img src="/uploads/' . $_FILES["fileToUpload"]["name"] . '" alt="image" height = "300" width = "300">';
    echo $formdata->greetings();
    $formdata->displayMarksTable();
  }
  ?>
</body>

</html>