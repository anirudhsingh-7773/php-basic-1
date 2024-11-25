<?php
require 'task1.php';
require 'upload.php';

header("Content-Type: application/msword");
header("Content-Disposition: attachment; filename=your_file_name.doc");



$formdata->marksValidate();
if (!($_FILES['fileToUpload']['error'] === UPLOAD_ERR_NO_FILE)) {
  $fileobject->validate();

  // Function to convert an image to base64
  function base64_encode_image($image_path)
  {
    $image_data = file_get_contents($image_path);
    $base64_image = base64_encode($image_data);
    return $base64_image;
  }

  // Path to the image
  $image_path = '/uploads/' . htmlspecialchars($_FILES["fileToUpload"]["name"]);

  // Get the base64 encoded image
  $base64_image = base64_encode_image($image_path);
  $dir = __DIR__;
  if (file_exists($_SERVER['DOCUMENT_ROOT'] . $image_path)) {
    echo "<img src=' $dir . $image_path' alt='Embedded Image' height='300' width='300' />";
} else {
    echo "Error: File not found.";
}
}
$formdata->greetings();
$formdata->phoneOutput();
$formdata->emailOutput();
$formdata->displayMarksTable();
