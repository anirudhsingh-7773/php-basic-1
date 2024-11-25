<?php
class form
{

  public $fname;
  public $lname;
  public $fullname;
  public $content;
  public $marksInput;
  public $marksArray = [];
  public $phone;

  public function __construct()
  {
    if (empty($_POST['fname'])) {
      echo "<p style='color: red;'>Enter First Name</p><br>";
    } else if (!preg_match('/^[a-zA-Z]+$/', $_POST['fname'])) {
      echo "<p style='color: red;'>First name can only contain letters!</p><br>";
    } else {
      $this->fname = $this->test_input($_POST["fname"]);
    }

    if (empty($_POST['lname'])) {
      echo "<p style='color: red;'>Enter Last Name</p><br>";
    } else if (!preg_match('/^[a-zA-Z]+$/', $_POST['lname'])) {
      echo "<p style='color: red;'>Last name can only contain letters!</p><br>";
    } else {
      $this->lname = $this->test_input($_POST["lname"]);
    }

    if (!empty($this->fname) && !empty($this->lname)) {
      $this->fullname = $this->fname . ' ' . $this->lname;
      echo '<h1>Hello ' . $this->fullname . '!</h1><br>';
    }
  }

  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  public function imageValidation()
  {
    if (!isset($_FILES["uploadImage"])) {
      echo "<p style='color: red;'>No file uploaded.</p><br>";
      return;
    }
    $target_dir = __DIR__ . '/uploads/';
    $target_file = $target_dir . basename($_FILES["uploadImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    umask(0);

    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
      echo "<p style='color: red;'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p><br>";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "<p style='color: red;'>Sorry, your file was not uploaded.</p><br>";
    } else {
      // Attempt to upload the file
      if (move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $target_file)) {
        echo '<img width="300" height="300" src="uploads/' . htmlspecialchars($_FILES["uploadImage"]["name"]) . '"/>';
      } else {
        echo "<p style='color: red;'>Sorry, there was an error uploading your file.</p><br>";
      }
    }
  }
  public function marksValidation()
  {
    if (!empty($_POST['marks'])) {

      $this->marksInput = $_POST['marks'];
      $lines = explode("\n", trim($this->marksInput));

      foreach ($lines as $line) {
        $line = trim($line);
        if (preg_match("/^[a-zA-Z\s]+\|[0-9]+$/", $line)) {
          list($subject, $mark) = explode('|', $line);
          $mark = (int)$mark;

          // Check if the subject is already in the array
          $subjectExists = false;
          foreach ($this->marksArray as $entry) {
            if (strtolower($entry['subject']) === strtolower($subject)) {
              $subjectExists = true;
              break;
            }
          }

          if ($subjectExists) {
            echo "<p style='color: red;'>Duplicate entry for subject: $subject</p>";
          } elseif ($mark <= 100) {
            $this->marksArray[] = ["subject" => $subject, "mark" => $mark];
          } else {
            echo "<p style='color: red;'>Marks for $subject must be between 0 and 100. You entered: $mark</p>";
          }
        } else {
          echo "<p style='color: red;'>Invalid format: $line (Correct format: Subject|Marks)</p>";
        }
      }
    }

    if (!empty($this->marksArray)) {
      echo "<h2>Your Marks:</h2>";
      echo "<table border='1' style='border-collapse: collapse; width: 50%; text-align: left;'>";
      echo "<tr><th>Subject</th><th>Marks</th></tr>";

      foreach ($this->marksArray as $entry) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($entry['subject']) . "</td>";
        echo "<td>" . htmlspecialchars($entry['mark']) . "</td>";
        echo "</tr>";
      }

      echo "</table>";
    } else {
      echo "<p style='color: red;'>No valid marks provided.</p>";
    }
  }

  public function phoneValidation()
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      if (empty($_POST['phone'])) {
        echo "<p style='color: red;'>Enter Phone Number</p>";
      } else if (!preg_match('/^\+91\s?\d{10}$/', $_POST['phone'])) {
        echo "<p style='color: red;'>Invalid Format</p>";
      } else {
        $this->phone = $this->test_input($_POST["phone"]);
        echo '<p>Your phone number is ' . $this->phone . '</p><br><br>';
      }
    }
  }
}

$formdata = new form();
$formdata->imageValidation();
$formdata->marksValidation();
$formdata->phoneValidation();
