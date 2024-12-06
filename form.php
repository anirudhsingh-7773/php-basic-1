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
   * Holds all the output for doc file.
   *
   * @var string
   */
  public $content;

  /**
   * Name for the file.
   *
   * @var resource
   */
  public $file_name;

  /**
   * Constructs a form object and validates the first and last name inputs.
   */
  public function __construct() {
    if (empty($_POST['fname'])) {
      // Check for empty first name input.
      $this->content .= '<p style="color: red;">Enter First Name</p>';
    }
    elseif (!preg_match('/^[a-zA-Z]+$/', $_POST['fname'])) {
      // Check that input only contains alphabets.
      $this->content .= '<p style="color: red;">First name can only contain letters!</p>';
    }
    else {
      // Initialize first name after data cleaning.
      $this->fname = $this->testInput($_POST['fname']);
    }

    if (empty($_POST['lname'])) {
      // Check for empty last name input.
      $this->content .= '<p style="color: red;">Enter Last Name</p>';
    }
    elseif (!preg_match('/^[a-zA-Z]+$/', $_POST['lname'])) {
      // Check that input only contains alphabets.
      $this->content .= '<p style="color: red;">Last name can only contain letters!</p>';
    }
    else {
      // Initialize last name after data cleaning.
      $this->lname = $this->testInput($_POST['lname']);
    }

    if (!empty($this->fname) && !empty($this->lname)) {
      // Concatenate first and last name and display greetings.
      $this->full_name = $this->fname . ' ' . $this->lname;
      $this->content .= '<h1>Hello ' . $this->full_name . '!</h1>';
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
      $this->content .= "<p style='color: red;'>No file uploaded.</p>";
      return;
    }

    $target_dir = __DIR__ . '/uploads/';
    $target_file = $target_dir . basename($_FILES['uploadImage']['name']);
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    umask(0);

    // Allow certain file formats.
    if (!in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
      $this->content .= "<p style='color: red;'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
      return;
    }

    // Attempt to upload the file.
    if (move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $target_file)) {
      if ($_GET['q'] == 6) {
          $this->content .= '<img width="300" height="300" src="' . __dir__ . '/uploads/' . htmlspecialchars($_FILES["uploadImage"]["name"]) . '"/>';
        } else {
          $this->content .= '<img width="300" height="300" src="uploads/' . htmlspecialchars($_FILES["uploadImage"]["name"]) . '"/>';
        }
    }
    else {
      $this->content .= "<p style='color: red;'>Sorry, there was an error uploading your file.</p>";
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
            $this->content .= "<p style='color: red;'>Marks for $subject must be between 0 and 100. You entered: $mark</p>";
            return;
          }
        }
        else {
          $this->content .= "<p style='color: red;'>Invalid format: $line (Correct format: Subject|Marks)</p>";
          return;
        }
      }
    }

    // Display marks in the form of a table.
    if (!empty($this->marks_array)) {
      $this->content .= '<h2>Your Marks:</h2>';
      $this->content .= '<table border="1" style="border-collapse: collapse; width: 50%; text-align: left;">';
      $this->content .= '<tr><th>Subject</th><th>Marks</th></tr>';

      foreach ($this->marks_array as $entry) {
        $this->content .= '<tr>';
        $this->content .= '<td>' . htmlspecialchars($entry['subject']) . '</td>';
        $this->content .= '<td>' . htmlspecialchars($entry['mark']) . '</td>';
        $this->content .= '</tr>';
      }

      $this->content .= '</table>';
    }
    else {
      $this->content .= '<p style="color: red;">No valid marks provided.</p>';
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
        $this->content .= '<p style="color: red;">Enter Phone Number</p>';
      }
      elseif (!preg_match('/^\+91\s?\d{10}$/', $_POST['phone'])) {
        // Check that input follows the pattern.
        $this->content .= '<p style="color: red;">Invalid Format For Phone Number</p>';
      }
      else {
        // Set value of phone and display.
        $this->phone = $this->testInput($_POST['phone']);
        $this->content .= '<p>Your phone number is ' . $this->phone . '</p>';
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
        $this->content .= "<p style='color: red;'>Enter Your Email</p>";
      }
      else if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/', $_POST['email'])) {
        $this->content .= "<p style='color: red;'>Invalid Format For Email</p>";
      }
      else {
        // Set email address
        $access_key = '46ff2d5dd622a481bd7721e49f8e8660';
        $email_address = $this->testInput($_POST['email']);

        $ch = curl_init('https://apilayer.net/api/check?access_key=' . $access_key . '&email=' . $email_address . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Receive the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $validationResult = json_decode($json, true);

        if (!$validationResult['mx_found']) {
          $this->content .= "<p style='color: red;'>Correct syntax but invalid email</p>";
        }
        else {
          $this->email = $email_address;
          $this->content .= '<p>Your Email is valid</p>';
        }
      }
    }
  }

  /**
   * Prints the content to a file and outputs it.
   */
  public function printContent() {
    $this->file_name = fopen("$this->full_name.doc", "w") or die("Unable to Open File .!!");
    fwrite($this->file_name, $this->content);
    fclose($this->file_name);
    echo $this->content;
  }
}

// Execute form actions if POST request is made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $formdata = new Form();
  // Selects the question using url
  switch ($_GET['q']) {
    case 1:
      // For Question 1.
      echo $formdata->content;
      break;
    case 2:
      // For Question 2.
      $formdata->imageValidation();
      echo $formdata->content;
      break;
    case 3:
      // For Question 3.
      $formdata->imageValidation();
      $formdata->marksValidation();
      echo $formdata->content;
      break;
    case 4:
      // For Question 4.
      $formdata->imageValidation();
      $formdata->marksValidation();
      $formdata->phoneValidation();
      echo $formdata->content;
      break;
    case 5:
      // For Question 5.
      $formdata->imageValidation();
      $formdata->marksValidation();
      $formdata->phoneValidation();
      $formdata->emailValidation();
      echo $formdata->content;
      break;
    case 6:
      // For Question 6.
      $formdata->imageValidation();
      $formdata->marksValidation();
      $formdata->phoneValidation();
      $formdata->emailValidation();
      $formdata->printContent();

      // Set headers for Word document download
      header("Content-type: application/vnd.ms-word");
      header("Content-Disposition: attachment;Filename=form-data.doc");
      header("Pragma: no-cache");
      header("Expires: 0");
      break;
    default:
      echo "<h1>Error</h1>";
  }
}
