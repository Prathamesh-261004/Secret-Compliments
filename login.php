<?php
session_start();
require 'db.php';

$msg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($username === 'admin' && $password === 'supersecret123') {
    $_SESSION['admin'] = true;
    header("Location: dashboard.php");
    exit;
  }

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $res = $stmt->get_result();

  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['user'] = $username;
      header("Location: home.php");
      exit;
    } else {
      $msg = "❌ Invalid password.";
    }
  } else {
    $msg = "❌ No such user.";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login - Secret Compliments</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57, #ff9ff3, #54a0ff);
      background-size: 600% 600%;
      animation: bgMove 20s ease infinite;
      text-align: center;
      padding: 60px 20px;
      color: #fff;
    }

    @keyframes bgMove {
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
      min-width: 320px;
      max-width: 400px;
      margin-top: 20px;
    }

    input {
      width: 90%;
      padding: 12px;
      margin: 15px 0;
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

    a {
      display: inline-block;
      margin-top: 18px;
      font-size: 15px;
      color: rgba(255,255,255,0.9);
      text-decoration: none;
      transition: color 0.3s;
    }

    a:hover {
      color: #fff;
    }
  </style>
</head>
<body>

<h2>🔐 Login to Secret Compliments</h2>
<?php if ($msg) echo "<div class='error'>$msg</div>"; ?>

<form method="POST">
  <input type="text" name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">✨ Login Now</button>
  
<a href="register.php">🌸 Create an Account</a> | 
<a href="admin_login.php">🛡️ Admin Panel</a>
  <p><a href="index.php">← Back to Login</a></p>
</form>

</body>
</html>
