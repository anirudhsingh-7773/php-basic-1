<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP task</title>
</head>

<body>

  <?php require 'task1.php';
  require 'upload.php'; 
  echo $PATH;
  ?>

  <h1>PHP Form</h1>
  <form method="post" action="submission.php" enctype="multipart/form-data">
    <label for="fname">First Name: </label>
    <input type="text" name="fname">
    <span class="error" style="color: red;">* <?php echo $formdata->fnameErr; ?></span>
    <br><br>
    <label for="lname">Last Name: </label>
    <input type="text" name="lname">
    <span class="error" style="color: red;">* <?php echo $formdata->lnameErr; echo __DIR__; ?></span>
    <br><br>
    <label for="name">Full Name: </label>
    <input type="text" name="name" value="<?php echo $formdata->name; ?>" disabled>
    <br><br>
    <label for="fileToUpload">Select some image:</label>
    <input type="file" id="fileToUpload" name="fileToUpload" />
    <span class="error" style="color: red;">* <?php echo $fileobject->imageErr; ?></span>
    <br><br>
    <label for="marks">Subject Marks (Subject|marks) :</label>
    <textarea name="marks" id="marks" rows="5" cols="25"></textarea>
    <br><br>
    <label for="phone">Phone (+91 xxxxxxxxxx): </label>
    <input type="text" id="phone" name="phone">
    <span class="error" style="color: red;">* <?php echo $formdata->phoneErr; ?></span>
    <br><br>
    <label for="email">Enter E-mail: </label>
    <input type="text" id="email" name="email" placeholder="email@example.com">
    <span class="error" style="color: red;">* <?php echo $formdata->emailErr; ?></span>
    <br><br>
    <input type="submit" name="submit" id="submit">
  </form>
  <br>


</body>

</html>