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
  public $full_name;

  /**
   * An array to hold marks for subjects.
   *
   * @var array
   */
  public $marks_array = [];

  /**
   * Holds the raw input for marks.
   *
   * @var string
   */
  public $marks_input;

  /**
   * Holds the phone number.
   *
   * @var string
   */
  public $phone;

  /**
   * Holds the email address.
   *
   * @var string
   */
  public $email;

  /**
   * Constructs a Form object.
   *
   * Checks the input of first and last name, initializes the first,
   * last, and full name, and displays greetings.
   */
  public function __construct() {
    if (empty($_POST['fname'])) {
      // Check for empty first name input.
      echo 'Enter First Name<br>';
    }
    elseif (!preg_match('/^[a-zA-Z]+$/', $_POST['fname'])) {
      // Check that input only contains alphabets.
      echo 'First name can only contain letters!<br>';
    }
    else {
      // Initialize first name after data cleaning.
      $this->fname = $this->testInput($_POST['fname']);
    }

    if (empty($_POST['lname'])) {
      // Check for empty last name input.
      echo 'Enter Last Name<br>';
    }
    elseif (!preg_match('/^[a-zA-Z]+$/', $_POST['lname'])) {
      // Check that input only contains alphabets.
      echo 'Last name can only contain letters!<br>';
    }
    else {
      // Initialize last name after data cleaning.
      $this->lname = $this->testInput($_POST['lname']);
    }

    if (!empty($this->fname) && !empty($this->lname)) {
      // Concatenate first and last name and display greetings.
      $this->full_name = $this->fname . ' ' . $this->lname;
      echo '<h1>Hello ' . $this->full_name . '!</h1>';
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
      // Check if any file is uploaded.
      echo 'No file uploaded.<br>';
      return;
    }

    $targetDir = __DIR__ . '/uploads/';
    $targetFile = $targetDir . basename($_FILES['uploadImage']['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Allow certain file formats.
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
      echo 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>';
      return;
    }

    // Attempt to upload the file.
    if (move_uploaded_file($_FILES['uploadImage']['tmp_name'], $targetFile)) {
      echo '<img width="300" height="300" src="uploads/' . htmlspecialchars($_FILES['uploadImage']['name']) . '"/>';
    }
    else {
      echo 'Sorry, there was an error uploading your file.<br>';
    }
  }

  /**
   * Validates and processes marks input.
   *
   * @return void
   */
  public function marksValidation() {
    if (!empty($_POST['marks'])) {
      $this->marks_input = $_POST['marks'];
      $lines = explode("\n", trim($this->marks_input));

      foreach ($lines as $line) {
        $line = trim($line);
        if (preg_match("/^[a-zA-Z\s]+\|[0-9]+$/", $line)) {
          list($subject, $mark) = explode('|', $line);
          $mark = (int) $mark;

          // Validate marks range.
          if ($mark <= 100) {
            $this->marks_array[] = [
              'subject' => $subject,
              'mark' => $mark,
            ];
          }
          else {
            echo "<p style='color: red;'>Marks for $subject must be between 0 and 100. You entered: $mark</p>";
            return;
          }
        }
        else {
          echo "<p style='color: red;'>Invalid format: $line (Correct format: Subject|Marks)</p>";
          return;
        }
      }
    }

    // Display marks in form of table.
    if (!empty($this->marks_array)) {
      echo '<h2>Your Marks:</h2>';
      echo '<table border="1" style="border-collapse: collapse; width: 50%; text-align: left;">';
      echo '<tr><th>Subject</th><th>Marks</th></tr>';

      foreach ($this->marks_array as $entry) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($entry['subject']) . '</td>';
        echo '<td>' . htmlspecialchars($entry['mark']) . '</td>';
        echo '</tr>';
      }

      echo '</table>';
    }
    else {
      echo '<p style="color: red;">No valid marks provided.</p>';
    }
  }

  /**
   * Validates and processes phone input.
   *
   * @return void
   */
  public function phoneValidation() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (empty($_POST['phone'])) {
        // Check if input is empty.
        echo '<p style="color: red;">Enter Phone Number</p>';
      }
      elseif (!preg_match('/^\+91\s?\d{10}$/', $_POST['phone'])) {
        // Check that input follows the pattern.
        echo '<p style="color: red;">Invalid Format For Phone Number</p>';
      }
      else {
        // Set value of phone and display.
        $this->phone = $this->testInput($_POST['phone']);
        echo '<p>Your phone number is ' . $this->phone . '</p>';
      }
    }
  }

  /**
   * Validates and processes email input.
   *
   * @return void
   */
  public function emailValidation() {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      if (empty($_POST['email'])) {
        echo "<p style='color: red;'>Enter Your Email</p>";
      } 
      elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/', $_POST['email'])) {
        echo "<p style='color: red;'>Invalid Format For Email</p>";
      } 
      else {
        // Set API Access Key
        $accessKey = '46ff2d5dd622a481bd7721e49f8e8660';

        // Set email address
        $emailAddress = $this->testInput($_POST['email']);

        $ch = curl_init('https://apilayer.net/api/check?access_key=' . $accessKey . '&email=' . $emailAddress . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Receive the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $validationResult = json_decode($json, true);

        if (!$validationResult['mx_found']) {
          echo "<p style='color: red;'>Correct syntax but invalid email</p>";
        } 
        else {
          $this->email = $emailAddress;
          echo '<p>Your Email is valid</p>';
        }
      }
    }
  }
}

// Execute form actions if POST request is made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form_data = new Form();
  $form_data->imageValidation();
  $form_data->marksValidation();
  $form_data->phoneValidation();
  $form_data->emailValidation();
}
