<?php
// index.php
include 'checkSession.php';

// sets what task is selected, by default 4.
$taskNumber = isset($_GET['q']) ? (int)$_GET['q'] : 4;

// Includes the task which is selected.
switch ($taskNumber) {
  case 1:
    include 'task1.php';
    break;
  case 2:
    include 'task2.php';
    break;
  case 3:
    include 'task3.php';
    break;
  case 4:
    include 'task4.php';
    break;
  case 5:
    include 'task5.php';
    break;
  case 6:
    include 'task6.php';
    break;
  default:
    echo "<h1>Invalid Task</h1>";
}
