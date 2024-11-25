<?php
class form
{

  public $fname;
  public $lname;
  public $fullname;

  public function __construct()
  {
    if (empty($_POST['fname'])) {
      echo "Enter First Name<br>";
    } else if (!preg_match('/^[a-zA-Z]+$/', $_POST['fname'])) {
      echo "First name can only contain letters!<br>";
    } else {
      $this->fname = $this->test_input($_POST["fname"]);
    }

    if (empty($_POST['lname'])) {
      echo "Enter Last Name<br>";
    } else if (!preg_match('/^[a-zA-Z]+$/', $_POST['lname'])) {
      echo "Last name can only contain letters!<br>";
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
}

$formdata = new form();
