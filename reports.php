<?php
require 'db.php';
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}

$reports = $conn->query("
  SELECT c.id, c.comment_text, c.from_user, c.to_user, COUNT(r.id) AS report_count
  FROM comments c
  JOIN reports r ON c.id = r.comment_id
  GROUP BY c.id
  ORDER BY report_count DESC
");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Reported Comments</title>
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
  padding: 30px;
">

  <h2 style="
    background: linear-gradient(to right, #fff, #f0f0f0, #fff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 36px;
    margin-bottom: 30px;
  ">🚨 Reported Comments</h2>

  <?php while ($row = $reports->fetch_assoc()): ?>
    <div style="
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 20px;
      margin: 20px auto;
      width: 90%;
      max-width: 600px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      color: #fff;
      text-align: left;
    ">
      <div style="margin-bottom: 10px;">
        <b style="color: #fff;">From:</b> @<?= $row['from_user'] ?> →
        <b style="color: #fff;">To:</b> @<?= $row['to_user'] ?>
      </div>
      <div style="margin-bottom: 10px;">
        <b style="color: #fff;">Comment:</b> <?= htmlspecialchars($row['comment_text']) ?>
      </div>
      <div style="margin-bottom: 10px;">
        <b style="color: #ffb3b3;">Reports:</b> <?= $row['report_count'] ?>
      </div>
      <a href="delete_comment.php?id=<?= $row['id'] ?>" 
         onclick="return confirm('Delete comment?')"
         style="
          display: inline-block;
          padding: 10px 20px;
          background: linear-gradient(135deg, #ff6b6b, #ff8e8e, #ffb3b3);
          border-radius: 8px;
          color: white;
          font-weight: bold;
          text-decoration: none;
          box-shadow: 0 4px 10px rgba(0,0,0,0.2);
          transition: transform 0.2s ease;
         "
         onmouseover="this.style.transform='scale(1.05)'"
         onmouseout="this.style.transform='scale(1)'"
      >🗑️ Delete Comment</a>
    </div>
  <?php endwhile; ?>

</body>
</html>
