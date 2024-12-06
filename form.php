<?php

/**
 * Class Form.
 *
 * Represents a form with inputs.
 */
class Form {

  /**
   * The first name input.
   *
   * @var string
   */
  public $fname;

  /**
   * The last name input.
   *
   * @var string
   */
  public $lname;

  /**
   * The full name concatenated from first and last names.
   *
   * @var string
   */
  public $fullname;

  /**
   * Constructs a Form object.
   *
   * Checks the input of first and last name, initializes the first,
   * last, and full name, and displays greetings.
   */
  public function __construct() {
    if (empty($_POST['fname'])) {
      // Check for empty first name input.
      echo "Enter First Name<br>";
    }
    elseif (!preg_match('/^[a-zA-Z]+$/', $_POST['fname'])) {
      // Check that input only contains alphabets.
      echo "First name can only contain letters!<br>";
    }
    else {
      // Initialize first name after data cleaning.
      $this->fname = $this->testInput($_POST['fname']);
    }

    if (empty($_POST['lname'])) {
      // Check for empty last name input.
      echo "Enter Last Name<br>";
    }
    elseif (!preg_match('/^[a-zA-Z]+$/', $_POST['lname'])) {
      // Check that input only contains alphabets.
      echo "Last name can only contain letters!<br>";
    }
    else {
      // Initialize last name after data cleaning.
      $this->lname = $this->testInput($_POST['lname']);
    }

    if (!empty($this->fname) && !empty($this->lname)) {
      // Concatenate first and last name and display greetings.
      $this->fullname = $this->fname . ' ' . $this->lname;
      echo '<h1>Hello ' . $this->fullname . '!</h1><br>';
    }
  }

  /**
   * Cleans the input data.
   *
   * @param string $data
   *   The input data to clean.
   *
   * @return string
   *   The sanitized input data.
   */
  public function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  /**
   * Validates and processes an uploaded image.
   *
   * @return void
   */
  public function imageValidation() {
    if (!isset($_FILES['uploadImage'])) {
      // check if any file is uploaded
      echo "No file uploaded.<br>";
      return;
    }

    $target_dir = __DIR__ . '/uploads/';
    $target_file = $target_dir . basename($_FILES['uploadImage']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    umask(0);

    // Allow certain file formats.
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
      return;
    }

    // Attempt to upload the file.
    if (move_uploaded_file($_FILES['uploadImage']['tmp_name'], $target_file)) {
      echo '<img width="300" height="300" src="uploads/' . htmlspecialchars($_FILES['uploadImage']['name']) . '"/>';
    }
    else {
      echo "Sorry, there was an error uploading your file.<br>";
    }
  }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $formdata = new Form();
  $formdata->imageValidation();
}
