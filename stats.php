<?php
require 'db.php';
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}

$users = $conn->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()['c'];
$photos = $conn->query("SELECT COUNT(*) AS c FROM photos")->fetch_assoc()['c'];
$comments = $conn->query("SELECT COUNT(*) AS c FROM comments")->fetch_assoc()['c'];
$reactions = $conn->query("SELECT COUNT(*) AS c FROM reactions")->fetch_assoc()['c'];
$reports = $conn->query("SELECT COUNT(*) AS c FROM reports")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Site Stats</title>
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
  ">📊 Platform Stats</h2>

  <div style="
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
  ">

    <div style="
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 25px;
      width: 180px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    ">
      <h3 style="
        margin: 0;
        font-size: 28px;
        background: linear-gradient(to right, #fff, #eee);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
      "><?= $users ?></h3>
      <p style="color: rgba(255,255,255,0.9);">Users</p>
    </div>

    <div style="
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 25px;
      width: 180px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    ">
      <h3 style="
        margin: 0;
        font-size: 28px;
        background: linear-gradient(to right, #fff, #eee);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
      "><?= $photos ?></h3>
      <p style="color: rgba(255,255,255,0.9);">Photos</p>
    </div>

    <div style="
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 25px;
      width: 180px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    ">
      <h3 style="
        margin: 0;
        font-size: 28px;
        background: linear-gradient(to right, #fff, #eee);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
      "><?= $comments ?></h3>
      <p style="color: rgba(255,255,255,0.9);">Comments</p>
    </div>

    <div style="
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 25px;
      width: 180px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    ">
      <h3 style="
        margin: 0;
        font-size: 28px;
        background: linear-gradient(to right, #fff, #eee);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
      "><?= $reactions ?></h3>
      <p style="color: rgba(255,255,255,0.9);">Reactions</p>
    </div>

    <div style="
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 25px;
      width: 180px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    ">
      <h3 style="
        margin: 0;
        font-size: 28px;
        background: linear-gradient(to right, #fff, #eee);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
      "><?= $reports ?></h3>
      <p style="color: rgba(255,255,255,0.9);">Reports</p>
    </div>
  </div>

  <br><br>
  <a href="dashboard.php" style="
    display: inline-block;
    padding: 12px 25px;
    font-size: 16px;
    border-radius: 8px;
    margin: 20px auto;
    text-decoration: none;
    color: white;
    font-weight: bold;
    background: linear-gradient(135deg, #4ecdc4, #44a08d, #3d8b7f);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    transition: transform 0.2s ease;
  " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">← Back to Dashboard</a>

</body>
</html>
