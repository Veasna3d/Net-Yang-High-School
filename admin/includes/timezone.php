<?php
include 'dbConnection.php';

  $timezone = 'Asia/Manila';
  date_default_timezone_set($timezone);

  $today = date('Y-m-d');
  $year = date('Y');
  if (isset($_GET['year'])) {
      $year = $_GET['year'];
  }
?>