<?php
session_start();

function sendOtpToMobile($mobile, $otp) {
    // Use an SMS API to send OTP to mobile (e.g., Twilio, Nexmo, etc.)
    // This is just a placeholder function
    // Example: https://www.twilio.com/docs/sms/send-messages

    // Assuming the API request is successful:
    return true;
}

function sendOtpToEmail($email, $otp) {
    $subject = "Your OTP Verification Code";
    $message = "Your OTP for verification is: " . $otp;
    $headers = "From: no-reply@example.com";

    return mail($email, $subject, $message, $headers);
}

// Get mobile and email from form
$mobile = $_POST['mobile'];
$email = $_POST['email'];

// Generate a 6-digit OTP
$otp = rand(100000, 999999);

// Store OTP in session to verify later
$_SESSION['otp'] = $otp;

// Send OTP to mobile and email
$mobileSent = sendOtpToMobile($mobile, $otp);
$emailSent = sendOtpToEmail($email, $otp);

if ($mobileSent && $emailSent) {
    echo "OTP has been sent to your mobile number and email.";
    // Redirect to verify OTP page
    header('Location: verifyOtp.php');
} else {
    echo "Failed to send OTP. Please try again.";
}
?>
