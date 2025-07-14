<?php
session_start();
$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $admin_user = $_POST['username'];
  $admin_pass = $_POST['password'];

  // Preset credentials
  $preset_user = "admin";
  $preset_pass = "admin123";

  if ($admin_user === $preset_user && $admin_pass === $preset_pass) {
    $_SESSION['admin'] = $admin_user;
    header("Location: dashboard.php");
    exit;
  } else {
    $msg = "❌ Invalid admin credentials.";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57, #ff9ff3, #54a0ff);
      background-size: 600% 600%;
      animation: gradient 20s ease infinite;
      text-align: center;
      padding: 60px 20px;
      color: white;
    }

    @keyframes gradient {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    form {
      background: rgba(255,255,255,0.15);
      padding: 40px 30px;
      border-radius: 16px;
      backdrop-filter: blur(12px);
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
      background: linear-gradient(135deg, #9b59b6, #8e44ad, #7d3c98);
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

    .error {
      background: rgba(255, 0, 0, 0.85);
      padding: 10px 15px;
      border-radius: 8px;
      margin-bottom: 15px;
      font-weight: bold;
    }

    h2 {
      font-size: 30px;
      margin-bottom: 15px;
      background: linear-gradient(to right, #fff, #f0f0f0, #fff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
  </style>
</head>
<body>
  <h2>🛡️ Admin Panel Login</h2>
  <?php if ($msg): ?>
    <div class="error"><?= $msg ?></div>
  <?php endif; ?>

  <form method="POST">
    <input type="text" name="username" placeholder="Admin Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Enter Admin Area</button>
      <p><a href="login.php">← Back to Login</a></p>
  </form>
</body>
</html>
