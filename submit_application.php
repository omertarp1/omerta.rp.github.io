<?php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Collect form data
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $characterName = trim($_POST["character_name"]);
    $reason = trim($_POST["reason"]);

    // Validate form data (you can add more validation as needed)
    if (empty($username) || empty($email) || empty($characterName) || empty($reason)) {
        echo "All fields are required.";
        exit;
    }

    // Save the application to the database
    saveApplicationToDatabase($username, $email, $characterName, $reason);

    // Optionally, send a confirmation email to the applicant
    sendConfirmationEmail($email);

    // Display a success message
    echo "Application submitted successfully. Thank you for applying!";
} else {
    // If the form is not submitted through POST, redirect to the application form page
    header("Location: whitelist_application.html");
}

// Function to save the application data to the database
function saveApplicationToDatabase($username, $email, $characterName, $reason) {
    // Replace these database credentials with your actual database information
    $dbHost = 'your_database_host';
    $dbUser = 'your_database_user';
    $dbPassword = 'your_database_password';
    $dbName = 'your_database_name';

    // Create a database connection
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape user inputs for security (to prevent SQL injection)
    $username = $conn->real_escape_string($username);
    $email = $conn->real_escape_string($email);
    $characterName = $conn->real_escape_string($characterName);
    $reason = $conn->real_escape_string($reason);

    // Insert data into the database
    $sql = "INSERT INTO whitelist_applications (username, email, character_name, reason) 
            VALUES ('$username', '$email', '$characterName', '$reason')";

    if ($conn->query($sql) === TRUE) {
        // Application saved successfully
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}

// Function to send a confirmation email (replace this with your email sending mechanism)
function sendConfirmationEmail($email) {
    // Example: Send a confirmation email to the applicant
    $subject = "Whitelist Application Submitted";
    $message = "Thank you for submitting your whitelist application. We will review it shortly.";
    mail($email, $subject, $message);
}

?>

