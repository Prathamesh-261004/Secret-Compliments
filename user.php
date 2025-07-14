<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user'])) die("Unauthorized.");
$current = $_SESSION['user'];

if (!isset($_GET['u'])) die("Invalid user.");
$viewing = $_GET['u'];

// Check if they're friends
$q = $conn->query("SELECT * FROM friend_requests WHERE ((sender='$current' AND receiver='$viewing') OR (sender='$viewing' AND receiver='$current')) AND status='accepted'");
if ($q->num_rows < 2) die("❌ You are not friends.");

// Show profile
$user = $conn->query("SELECT * FROM users WHERE username='$viewing'")->fetch_assoc();
$photos = $conn->query("SELECT * FROM photos WHERE user='$viewing' ORDER BY uploaded_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>@<?= $viewing ?>'s Profile</title>
  <style>
    body { font-family: Arial; text-align: center; background: #f4f4f4; }
    img.dp { width: 100px; border-radius: 50%; }
    img.pic { width: 90%; border-radius: 10px; margin: 10px 0; }
    .card { background: white; margin: 20px auto; padding: 20px; width: 90%; max-width: 500px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
  </style>
</head>
<body>
  <h2>@<?= $viewing ?> — <?= htmlspecialchars($user['display_name']) ?></h2>
  <img src="<?= $user['profile_pic'] ?>" class="dp"><br>
  <p><?= nl2br(htmlspecialchars($user['description'])) ?></p>

  <h3>📸 Posts</h3>
  <?php while($p = $photos->fetch_assoc()): ?>
    <div class="card">
      <img src="<?= $p['photo_path'] ?>" class="pic">
    </div>
  <?php endwhile; ?>
</body>
</html>
