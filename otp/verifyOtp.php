<?php
session_start();

// Get OTP from form
$userOtp = $_POST['otp'];

// Check if the OTP matches the one generated
if ($userOtp == $_SESSION['otp']) {
    echo "OTP verification successful!";
    // Proceed with further actions (e.g., registration, login, etc.)
    unset($_SESSION['otp']); // Clear OTP from session
} else {
    echo "Invalid OTP. Please try again.";
}
?>
