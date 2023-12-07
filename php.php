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

    // Save the application to a file or database (replace this with your storage mechanism)
    saveApplication($username, $email, $characterName, $reason);

    // Optionally, send a confirmation email to the applicant
    sendConfirmationEmail($email);

    // Display a success message
    echo "Application submitted successfully. Thank you for applying!";
} else {
    // If the form is not submitted through POST, redirect to the application form page
    header("Location: whitelist_application.html");
}

// Function to save the application data (replace this with your storage mechanism)
function saveApplication($username, $email, $characterName, $reason) {
    // Example: Save the application data to a text file
    $data = "$username, $email, $characterName, $reason\n";
    file_put_contents("whitelist_applications.txt", $data, FILE_APPEND);
}

// Function to send a confirmation email (replace this with your email sending mechanism)
function sendConfirmationEmail($email) {
    // Example: Send a confirmation email to the applicant
    $subject = "Whitelist Application Submitted";
    $message = "Thank you for submitting your whitelist application. We will review it shortly.";
    mail($email, $subject, $message);
}

?>
