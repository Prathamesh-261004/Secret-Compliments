<?php
require 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

$msg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $display_name = $_POST['display_name'];
  $photo = $_FILES['profile_pic'];

  $username = strtolower(explode('@', $email)[0]) . rand(100, 999);
  $password_plain = bin2hex(random_bytes(3));
  $password = password_hash($password_plain, PASSWORD_DEFAULT);

  $filename = "uploads/" . time() . "_" . basename($photo['name']);
  move_uploaded_file($photo['tmp_name'], $filename);

  $stmt = $conn->prepare("INSERT INTO users (email, username, password, profile_pic, display_name) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $email, $username, $password, $filename, $display_name);

  if ($stmt->execute()) {
    $mail = new PHPMailer(true);
    try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'psrane26@gmail.com'; 
      $mail->Password = 'yqwo ksns fvzk uicu'; // Use Gmail App Password
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom('psrane26@gmail.com', 'Secret Compliments');
      $mail->addAddress($email);
      $mail->isHTML(true);
      $mail->Subject = 'Welcome to Secret Compliments!';

      $mail->Body = "
        <div style='font-family: Arial, sans-serif; background-color: #fdf6f9; padding: 20px; border-radius: 10px; color: #333;'>
          <h2 style='color: #d63384;'>🌸 Welcome to Secret Compliments!</h2>
          <p>Your account has been <strong>successfully created</strong>. Here are your login credentials:</p>
          <div style='background: #fff; padding: 15px; border: 1px solid #eee; border-radius: 8px;'>
            <p><strong>Username:</strong> $username</p>
            <p><strong>Password:</strong> $password_plain</p>
          </div>
          <p>👉 <a href='http://localhost/s/login.php' style='background: #d63384; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none;'>Login Now</a></p>
          <p style='font-size: 14px; color: #777;'>If you didn't register, you can ignore this email.</p>
        </div>
      ";

      $mail->send();
      header("Location: login.php?success=1");
      exit;
    } catch (Exception $e) {
      $msg = "❌ Mail Error: {$mail->ErrorInfo}";
    }
  } else {
    $msg = "❌ Registration failed.";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57, #ff9ff3, #54a0ff);
      background-size: 600% 600%;
      animation: gradient 20s ease infinite;
      text-align: center;
      padding: 50px 20px;
      color: white;
    }

    @keyframes gradient {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    form {
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(12px);
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.2);
      display: inline-block;
      min-width: 300px;
    }

    input {
      width: 90%;
      padding: 12px;
      margin: 12px 0;
      font-size: 16px;
      border: none;
      border-radius: 10px;
      background: rgba(255,255,255,0.95);
    }

    button {
      width: 94%;
      padding: 14px;
      font-size: 17px;
      background: linear-gradient(135deg, #ff6b6b, #ff8e8e, #ffb3b3);
      color: white;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    button:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(0,0,0,0.3);
    }

    h2 {
      font-size: 30px;
      margin-bottom: 15px;
      background: linear-gradient(to right, #fff, #f0f0f0, #fff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .msg {
      margin: 10px auto;
      padding: 10px;
      background: rgba(255, 0, 0, 0.85);
      border-radius: 10px;
      width: 80%;
      font-weight: bold;
      color: white;
    }

    a {
      color: #fff;
      text-decoration: underline;
      font-size: 15px;
    }
  </style>
</head>
<body>
  <h2>📝 Register</h2>
  <?php if (isset($msg) && $msg): ?>
    <div class="msg"><?= $msg ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="display_name" placeholder="Display Name" required>
    <input type="file" name="profile_pic" accept="image/*" required>
    <button type="submit">Register</button>
    
  <p><a href="login.php">← Back to Login</a></p>
  </form>

</body>
</html>

