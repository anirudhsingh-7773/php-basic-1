<?php
class formdetails
{
  public $fnameErr, $lnameErr = "";
  public $fname, $lname, $name = "";

  function validation()
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

  function test_input($data)
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
}

$formdata = new formdetails();
$formdata->validation();
?>

