<?php include 'checkSession.php'; ?>
<!-- task1.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>PHP Task 1</title>
</head>

<body>
  <section>
    <h1>Fill the Form</h1>
    <form method="post" action="form.php?q=1">
      <label for="fname">First Name: </label>
      <input type="text" name="fname" id="fname" oninput="autofill('fname','lname','fullname')" required placeholder="John">
      <span class="error" style="color: red;">* </span>
      <br><br>
      <label for="lname">Last Name: </label>
      <input type="text" name="lname" id="lname" oninput="autofill('fname','lname','fullname')" required placeholder="Doe">
      <span class="error" style="color: red;">* </span>
      <br><br>
      <label for="name">Full Name: </label>
      <input type="text" name="name" id="fullname" value="" disabled>
      <br><br>
      <input type="submit" name="submit" id="submit">
    </form>

    <!-- Pager -->
    <div class="pager">
      <a style="background-color: black; color: white;" href="index.php?q=<?php echo $taskNumber = 1; ?>">Question 1</a>
      <a href="index.php?q=<?php echo $taskNumber = 2; ?>">Question 2</a>
      <a href="index.php?q=<?php echo $taskNumber = 3; ?>">Question 3</a>
      <a href="index.php?q=<?php echo $taskNumber = 4; ?>">Question 4</a>
      <a href="index.php?q=<?php echo $taskNumber = 5; ?>">Question 5</a>
      <a href="index.php?q=<?php echo $taskNumber = 6; ?>">Question 6</a>
      <a href="logout.php">Logout</a>

    </div>
  </section>
  <script src="/js/script.js"></script>
</body>

</html>