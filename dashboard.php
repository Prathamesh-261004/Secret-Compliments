<?php
require 'db.php';
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}

$users = $conn->query("SELECT username, email, display_name FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <style>
    @keyframes bgShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
  </style>
</head>
<body style="
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(145deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57, #ff9ff3, #54a0ff);
  background-size: 400% 400%;
  animation: bgShift 20s ease infinite;
  color: #fff;
  text-align: center;
  padding: 40px;
">

  <h2 style="
    background: linear-gradient(to right, #fff, #f0f0f0, #fff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 36px;
    margin-bottom: 30px;
  ">🔐 Admin Dashboard</h2>

  <div style="
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 25px;
    width: 90%;
    max-width: 1000px;
    margin: auto;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    color: #fff;
  ">
    <table style="width:100%; border-collapse:collapse; color:white;">
      <tr>
        <th style="padding:10px; border:1px solid #ccc; background:#333; color:white;">Username</th>
        <th style="padding:10px; border:1px solid #ccc; background:#333; color:white;">Email</th>
        <th style="padding:10px; border:1px solid #ccc; background:#333; color:white;">Display Name</th>
        <th style="padding:10px; border:1px solid #ccc; background:#333; color:white;">Action</th>
      </tr>

      <?php while ($u = $users->fetch_assoc()): ?>
      <tr>
        <td style="padding:10px; border:1px solid #ccc;"><?= $u['username'] ?></td>
        <td style="padding:10px; border:1px solid #ccc;"><?= $u['email'] ?></td>
        <td style="padding:10px; border:1px solid #ccc;"><?= htmlspecialchars($u['display_name']) ?></td>
        <td style="padding:10px; border:1px solid #ccc;">
          <a href="delete_account.php?admin=1&user=<?= $u['username'] ?>" 
             style="color:#ff6b6b; text-shadow:0 0 5px #ff6b6b; font-weight:bold; text-decoration:none;" 
             onclick="return confirm('Delete user?')">🗑️ Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <div style="margin-top: 30px;">
    <a href="stats.php" style="
      display:inline-block;
      padding: 12px 25px;
      background: linear-gradient(135deg, #4ecdc4, #44a08d, #3d8b7f);
      color: white;
      font-weight: bold;
      border-radius: 8px;
      margin: 10px;
      text-decoration: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    ">📊 View Stats</a>

    <a href="reports.php" style="
      display:inline-block;
      padding: 12px 25px;
      background: linear-gradient(135deg, #9b59b6, #8e44ad, #7d3c98);
      color: white;
      font-weight: bold;
      border-radius: 8px;
      margin: 10px;
      text-decoration: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    ">🚩 View Reports</a>

    <a href="logout.php" style="
      display:inline-block;
      padding: 12px 25px;
      background: linear-gradient(135deg, #ff6b6b, #ff8e8e, #ffb3b3);
      color: white;
      font-weight: bold;
      border-radius: 8px;
      margin: 10px;
      text-decoration: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    ">🚪 Logout</a>
  </div>

  <footer style="margin-top: 50px; color: rgba(255, 255, 255, 0.9); font-size: 14px;">
    © <?= date("Y") ?> Secret Compliments Admin Panel
  </footer>

</body>
</html>
