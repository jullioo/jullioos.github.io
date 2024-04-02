<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}


// Database connection variables
$host = 'localhost';
$dbUsername = 'root'; // default username for localhost
$dbPassword = ''; // default password for localhost
$dbName = 'finalproject';

// Create database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize input data
    $firstName = $conn->real_escape_string(trim($_POST['firstname']));
    $lastName = $conn->real_escape_string(trim($_POST['lastname']));
    $dob = $conn->real_escape_string(trim($_POST['dob']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $_POST['password']; // Password will be hashed, no need to escape

    if (empty($email) || empty($password)) {
        die("Email and password are required.");
    }

    // More validation can be added here as needed

    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();
    if ($checkEmail->num_rows > 0) {
        die("An account with this email already exists.");
    }
    $checkEmail->close();

    // Prepare SQL query to insert the new user into the database
    $query = $conn->prepare("INSERT INTO users (firstname, lastname, dob, phone, email, password) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssssss", $firstName, $lastName, $dob, $phone, $email, $passwordHash);

    // Execute the query
    if ($query->execute()) {
        // Success: Set session variable or send a success response
        $_SESSION['user_id'] = $conn->insert_id; // Optionally set the user session
        // Redirect to index.php or another success page
        header("Location: ../index.php");
        exit;
    } else {
        // Handle errors, e.g., failed to insert data
        die("Error creating account: " . $conn->error);
    }

    // Close statement and connection
    $query->close();
    $conn->close();
} else {
    // Not a POST request
    die("Invalid request.");
}
?>