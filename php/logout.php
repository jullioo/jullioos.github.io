<?php
session_start(); // Access the existing session

// Clear session array
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to index.php
header("Location: ../index.php");
exit;
