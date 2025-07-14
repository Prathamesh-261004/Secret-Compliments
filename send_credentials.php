<?php
// send_credentials.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'db.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

function generateRandom($length = 8) {
  return substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, $length);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $username = generateRandom(6);
  $password = generateRandom(10);
  $hashed = password_hash($password, PASSWORD_DEFAULT);

  // Handle profile picture upload
  $target = "dp_" . time() . "_" . basename($_FILES["profile_pic"]["name"]);
  move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target);

  // Insert into DB
  $stmt = $conn->prepare("INSERT INTO users (email, username, password, profile_pic) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $email, $username, $hashed, $target);
  $stmt->execute();

  // Send Email
  $mail = new PHPMailer(true);
  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Change if using another provider
    $mail->SMTPAuth = true;
    $mail->Username = 'psrane26@gmail.com'; 
        $mail->Password = 'yqwo ksns fvzk uicu';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

    $mail->setFrom('psrane26@gmail.com', 'Secret Compliments');
    $mail->addAddress($email);

    $mail->isHTML(true);
   $mail->Subject = ' Welcome to Secret Compliments!';

$mail->Body = "
<div style='font-family: Arial, sans-serif; background-color: #fdf6f9; padding: 20px; border-radius: 10px; color: #333;'>
  <h2 style='color: #d63384;'>🌸 Welcome to Secret Compliments!</h2>
  <p style='font-size: 16px;'>Hi there,</p>

  <p style='font-size: 16px;'>Your account has been <strong>successfully created</strong>. Here are your login credentials:</p>

  <div style='background-color: #fff; padding: 15px; border: 1px solid #eee; border-radius: 8px; margin: 20px 0;'>
    <p style='font-size: 16px;'><strong>Username:</strong> <span style='color: #333;'>$username</span></p>
    <p style='font-size: 16px;'><strong>Password:</strong> <span style='color: #333;'>$password</span></p>
  </div>

  <p style='font-size: 16px;'>You can now log in and start sending or receiving <span style='color: #e83e8c;'>sweet anonymous compliments</span> 💌</p>

  <a href='https://localhost/s/login.php' style='display: inline-block; background-color: #d63384; color: #fff; text-decoration: none; padding: 12px 20px; border-radius: 5px; font-size: 16px; margin-top: 10px;'>🌟 Go to Login</a>

  <hr style='margin: 30px 0; border: none; border-top: 1px dashed #ccc;'>

  <p style='font-size: 14px; color: #777;'>If you didn't register for Secret Compliments, please ignore this email.</p>
</div>
";

/*       $mail->Username   = 'your-email@gmail.com';
        $mail->Password   = 'your-app-password';  // Use app password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('your-email@gmail.com', 'Secret Compliments'); */
    $mail->send();
    header("Location: login.php?success=1");
    exit();
  } catch (Exception $e) {
    echo "Error sending email: {$mail->ErrorInfo}";
  }
}
?>
