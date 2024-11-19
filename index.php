<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/favicon.ico">
  <title>Task 1 PHP</title>
</head>

<body>

  <?php include 'task1.php'; ?>

  <h1>PHP Form</h1>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
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
    <input type="submit" name="submit" id="submit">
  </form>

  <?php echo $formdata->greetings(); ?>

</body>

</html>