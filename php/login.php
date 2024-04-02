<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}


// Connect to the database
$db = new mysqli('localhost', 'root', '', 'finalproject');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize input data
    $email = $db->real_escape_string($_POST['email']);
    $password = $_POST['password'];  // No need to escape passwords; they will be hashed

    // Server-side validation (simplified)
    if (empty($email) || empty($password)) {
        // Handle the error accordingly
        die("Email and password are required.");
    }

    // Authenticate the user
    $query = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set user session or cookie
            $_SESSION['user_id'] = $user['id'];
            header('Location: ../index.php');
            exit();
        } else {
            die("Invalid credentials.");
        }
    } else {
        die("User not found.");
    }
}
?>
