<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        header("Location: index.php#contact?error=All fields are required");
        exit();
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.php#contact?error=Invalid email format");
        exit();
    }
    
    // Email recipient
    $to = "noorjahan@example.com";
    
    // Email headers
    $headers = "From: $name <$email>" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    
    // Email content
    $email_content = "<h2>Contact Form Submission</h2>";
    $email_content .= "<p><strong>Name:</strong> $name</p>";
    $email_content .= "<p><strong>Email:</strong> $email</p>";
    $email_content .= "<p><strong>Subject:</strong> $subject</p>";
    $email_content .= "<p><strong>Message:</strong></p><p>" . nl2br($message) . "</p>";
    
    // Send email
    $success = mail($to, "Contact Form: $subject", $email_content, $headers);
    
    if ($success) {
        header("Location: index.php#contact?success=Your message has been sent successfully!");
    } else {
        header("Location: index.php#contact?error=Sorry, there was an error sending your message");
    }
    exit();
}

// If not a POST request, redirect to home page
header("Location: index.php");
exit();
?>
