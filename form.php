<?php
// form.php
include 'checkSession.php';
class form
{

  public $fname;
  public $lname;
  public $fullname;
  public $marksInput;
  public $marksArray = [];
  public $phone;
  public $email;
  public $content;
  public $fileName;

  public function __construct()
  {
    if (empty($_POST['fname'])) {
      $this->content .= "<p style='color: red;'>Enter First Name</p>";
    } else if (!preg_match('/^[a-zA-Z]+$/', $_POST['fname'])) {
      $this->content .= "<p style='color: red;'>First name can only contain letters!</p>";
    } else {
      $this->fname = $this->test_input($_POST["fname"]);
    }

    if (empty($_POST['lname'])) {
      $this->content .= "<p style='color: red;'>Enter Last Name</p>";
    } else if (!preg_match('/^[a-zA-Z]+$/', $_POST['lname'])) {
      $this->content .= "<p style='color: red;'>Last name can only contain letters!</p>";
    } else {
      $this->lname = $this->test_input($_POST["lname"]);
    }

    if (!empty($this->fname) && !empty($this->lname)) {
      $this->fullname = $this->fname . ' ' . $this->lname;
      $this->content .= '<h1>Hello ' . $this->fullname . '!</h1>';
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
      $this->content .= "<p style='color: red;'>No file uploaded.</p>";
      return;
    }
    $target_dir = __DIR__ . '/uploads/';
    $target_file = $target_dir . basename($_FILES["uploadImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    umask(0);

    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
      $this->content .= "<p style='color: red;'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
      return;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      $this->content .= "<p style='color: red;'>Sorry, your file was not uploaded.</p>";
    } else {
      // Attempt to upload the file
      if (move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $target_file)) {
        if ($_GET['q'] == 6) {
          $this->content .= '<img width="300" height="300" src="' . __dir__ . '/uploads/' . htmlspecialchars($_FILES["uploadImage"]["name"]) . '"/>';
        } else {
          $this->content .= '<img width="300" height="300" src="uploads/' . htmlspecialchars($_FILES["uploadImage"]["name"]) . '"/>';
        }
      } else {
        $this->content .= "<p style='color: red;'>Sorry, there was an error uploading your file.</p>";
      }
    }
  }
  public function marksValidation()
  {
    if (!empty($_POST['marks'])) {

      $this->marksInput = $this->test_input($_POST['marks']);
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
            $this->content .= "<p style='color: red;'>Duplicate entry for subject: $subject</p>";
            return;
          } elseif ($mark <= 100) {
            $this->marksArray[] = ["subject" => $subject, "mark" => $mark];
          } else {
            $this->content .= "<p style='color: red;'>Marks for $subject must be between 0 and 100. You entered: $mark</p>";
            return;
          }
        } else {
          $this->content .= "<p style='color: red;'>Invalid format: $line (Correct format: Subject|Marks)</p>";
          return;
        }
      }
    }

    if (!empty($this->marksArray)) {
      $this->content .= "<h2>Your Marks:</h2>";
      $this->content .= "<table border='1' style='border-collapse: collapse; width: 50%; text-align: left;'>";
      $this->content .= "<tr><th>Subject</th><th>Marks</th></tr>";

      foreach ($this->marksArray as $entry) {
        $this->content .= "<tr>";
        $this->content .= "<td>" . htmlspecialchars($entry['subject']) . "</td>";
        $this->content .= "<td>" . htmlspecialchars($entry['mark']) . "</td>";
        $this->content .= "</tr>";
      }

      $this->content .= "</table>";
    } else {
      $this->content .= "<p style='color: red;'>No valid marks provided.</p>";
    }
  }

  public function phoneValidation()
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      if (empty($_POST['phone'])) {
        $this->content .= "<p style='color: red;'>Enter Phone Number</p>";
      } else if (!preg_match('/^\+91\s?\d{10}$/', $_POST['phone'])) {
        $this->content .= "<p style='color: red;'>Invalid Format For Phone Number</p>";
      } else {
        $this->phone = $this->test_input($_POST["phone"]);
        $this->content .= '<p>Your phone number is ' . $this->phone . '</p>';
      }
    }
  }

  public function emailValidation()
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      if (empty($_POST['email'])) {
        $this->content .= "<p style='color: red;'>Enter Your Email</p>";
      } else if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/', $_POST['email'])) {
        $this->content .= "<p style='color: red;'>Invalid Format For Email</p>";
      } else {
        // set API Access Key
        $access_key = '46ff2d5dd622a481bd7721e49f8e8660';

        // set email address
        $email_address = $this->test_input($_POST['email']);

        $ch = curl_init('https://apilayer.net/api/check?access_key=' . $access_key . '&email=' . $email_address . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Receive the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $validationResult = json_decode($json, true);

        if (!$validationResult['mx_found']) {
          $this->content .= "<p style='color: red;'>Correct syntax but invalid email</p>";
        } else {
          $this->email = $email_address;
          $this->content .= '<p>Your Email is valid</p>';
        }
      }
    }
  }

  public function printContent()
  {
    $this->fileName = fopen("$this->fullname.doc", "w") or die("Unable to Open File .!!");
    fwrite($this->fileName, $this->content);
    fclose($this->fileName);
    echo $this->content;
  }
}

if (isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST['submit'])) {
  $formdata = new form();
  switch ($_GET['q']) {
    case 1:
      echo $formdata->content;
      break;
    case 2:
      $formdata->imageValidation();
      echo $formdata->content;
      break;
    case 3:
      $formdata->imageValidation();
      $formdata->marksValidation();
      echo $formdata->content;
      break;
    case 4:
      $formdata->imageValidation();
      $formdata->marksValidation();
      $formdata->phoneValidation();
      echo $formdata->content;
      break;
    case 5:
      $formdata->imageValidation();
      $formdata->marksValidation();
      $formdata->phoneValidation();
      $formdata->emailValidation();
      echo $formdata->content;
      break;
    case 6:
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
