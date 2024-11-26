<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Task 4</title>
</head>
<body>

<h1>Fill the Form</h1>
<form method="post" action="form.php" enctype="multipart/form-data">
    <label for="fname">First Name: </label>
    <input type="text" name="fname" id="fname" oninput="autofill('fname','lname','fullname')" required>
    <span class="error" style="color: red;">* </span>
    <br><br>
    <label for="lname">Last Name: </label>
    <input type="text" name="lname" id="lname" oninput="autofill('fname','lname','fullname')" required>
    <span class="error" style="color: red;">* </span>
    <br><br>
    <label for="name">Full Name: </label>
    <input type="text" name="name" id="fullname" value="" disabled>
    <br><br>
    <label for="image">Choose an image:</label>
    <input type="file" id="image" name="uploadImage">
    <br><br>
    <label for="marks">Subject Marks (Subject|marks) :</label>
    <textarea name="marks" id="marks" rows="5" cols="25"></textarea>
    <br><br>
    <label for="phone">Phone (+91 xxxxxxxxxx): </label>
    <input type="text" id="phone" name="phone">
    <br><br>
    <input type="submit" name="submit" id="submit">
  </form>

  <script src="/js/script.js"></script>
</body>
</html>