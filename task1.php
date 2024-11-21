<?php

class formdetails
{
  public $fnameErr, $lnameErr, $phoneErr, $emailErr = "";
  public $fname, $lname, $name, $phone, $email = "";
  public $marksInput = "";
  public $marksArray = [];

  public function nameValidation()
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

      if (empty($_POST['fname'])) {
        $this->fnameErr = "First name can't be empty";
      } else if (!preg_match('/^[a-zA-Z]+$/', $_POST['fname'])) {
        $this->fnameErr = "Only letters allowed";
      } else {
        $this->fname = $this->test_input($_POST["fname"]);
      }

      if (empty($_POST['lname'])) {
        $this->lnameErr = "Last name can't be empty";
      } else if (!preg_match('/^[a-zA-Z]+$/', $_POST['lname'])) {
        $this->lnameErr = "Only letters allowed";
      } else {
        $this->lname = $this->test_input($_POST["lname"]);
      }

      if (!empty($this->fname) && !empty($this->lname)) {
        $this->name = $this->fname . " " . $this->lname;
      }
    }
  }

  public function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  public function greetings()
  {
    if (!empty($this->name)) {
      echo "<h2>Hello $this->name</h2>";
    }
  }

  public function marksValidate()
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
          } elseif ($mark >= 0 && $mark <= 100) {
            $this->marksArray[] = ["subject" => $subject, "mark" => $mark];
          } else {
            echo "<p style='color: red;'>Marks for $subject must be between 0 and 100. You entered: $mark</p>";
          }
        } else {
          echo "<p style='color: red;'>Invalid format: $line (Correct format: Subject|Marks)</p>";
        }
      }
    }
  }

  public function displayMarksTable()
  {
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
        $this->phoneErr = "Phone number can't be empty";
      } else if (!preg_match('/^\+91\s?\d{10}$/', $_POST['phone'])) {
        $this->phoneErr = "Invalid Format";
      } else {
        $this->phone = $this->test_input($_POST["phone"]);
      }
    }
  }

  public function phoneOutput()
  {
    if (!empty($this->phone)) {
      echo 'Your phone number is ' . $this->phone . '<br><br>';
    }
  }

  public function emailValidation()
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      if (empty($_POST['email'])) {
        $this->emailErr = "Email can't be empty";
      } else if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/', $_POST['email'])) {
        $this->emailErr = "Invalid Format";
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
          $this->emailErr = "Correct syntax but email is invalid.";
        } else {
          $this->email = $email_address;
        }
      }
    }
  }

  public function emailOutput()
  {
    if (!empty($this->email)) {
      echo 'Your Email is ' . $this->email . '<br><br>';
    }
  }
}

$formdata = new formdetails();
$formdata->nameValidation();
$formdata->phoneValidation();
$formdata->emailValidation();
