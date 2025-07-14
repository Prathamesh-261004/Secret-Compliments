<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user'])) die("Unauthorized.");
$user = $_SESSION['user'];

// Update display name and description
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['update'])) {
    $name = $_POST['display_name'];
    $desc = $_POST['description'];
    $stmt = $conn->prepare("UPDATE users SET display_name=?, description=? WHERE username=?");
    $stmt->bind_param("sss", $name, $desc, $user);
    $stmt->execute();
  }

  // Upload new photo
  if (isset($_FILES['new_photo'])) {
    $filename = "uploads/" . time() . "_" . basename($_FILES["new_photo"]["name"]);
    move_uploaded_file($_FILES["new_photo"]["tmp_name"], $filename);
    $stmt = $conn->prepare("INSERT INTO photos (user, photo_path) VALUES (?, ?)");
    $stmt->bind_param("ss", $user, $filename);
    $stmt->execute();
  }

  // Delete photo
  if (isset($_POST['delete_photo_id'])) {
    $photo_id = $_POST['delete_photo_id'];
    $conn->query("DELETE FROM photos WHERE id='$photo_id' AND user='$user'");
    $conn->query("DELETE FROM comments WHERE photo_id='$photo_id'");
    $conn->query("DELETE FROM reactions WHERE photo_id='$photo_id'");
  }
}

// Fetch profile info
$data = $conn->query("SELECT * FROM users WHERE username='$user'")->fetch_assoc();
$photos = $conn->query("SELECT * FROM photos WHERE user='$user' ORDER BY uploaded_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Profile</title>
  <style>
    body {
      margin: 0;
      padding: 30px 20px;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #ff9ff3, #54a0ff, #45b7d1, #feca57, #4ecdc4, #ff6b6b);
      background-size: 400% 400%;
      animation: gradientFlow 18s ease infinite;
      color: #333;
      text-align: center;
    }

    @keyframes gradientFlow {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    h2, h3 {
      color: white;
      background: rgba(0, 0, 0, 0.4);
      display: inline-block;
      padding: 10px 20px;
      border-radius: 12px;
      backdrop-filter: blur(5px);
      box-shadow: 0 0 10px rgba(255,255,255,0.2);
      animation: fadeInDown 1s ease both;
    }

    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    img.dp {
      width: 130px;
      height: 130px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid white;
      margin: 20px 0;
      box-shadow: 0 0 15px rgba(0,0,0,0.5);
      animation: popIn 1s ease-in-out;
    }

    @keyframes popIn {
      0% { transform: scale(0.5); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }

    form {
      background: rgba(255, 255, 255, 0.15);
      padding: 20px;
      margin: 20px auto;
      border-radius: 16px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      backdrop-filter: blur(10px);
      animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }

    input, textarea {
      width: 90%;
      max-width: 400px;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      background: rgba(255, 255, 255, 0.9);
      box-shadow: inset 0 0 4px rgba(0,0,0,0.2);
    }

    button {
      padding: 12px 24px;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 50px;
      cursor: pointer;
      margin-top: 10px;
      background: linear-gradient(135deg, #ff6b6b, #ff8e8e, #ffb3b3);
      background-size: 200%;
      color: white;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      transition: all 0.4s ease;
    }

    button:hover {
      background-position: right;
      transform: scale(1.05);
      box-shadow: 0 8px 25px rgba(0,0,0,0.4);
    }

    .post {
      background: rgba(255,255,255,0.9);
      border-radius: 16px;
      padding: 16px;
      margin: 25px auto;
      width: 92%;
      max-width: 520px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }

    .post:hover {
      transform: scale(1.01);
    }

    img.pic {
      width: 100%;
      border-radius: 12px;
      margin-bottom: 10px;
    }

    a {
      color: white;
      text-decoration: underline;
      display: inline-block;
      margin-top: 30px;
      font-weight: bold;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <h2>👤 My Profile - @<?= $user ?></h2>
  <img src="<?= $data['profile_pic'] ?>" class="dp"><br>

  <form method="POST">
    <input type="text" name="display_name" value="<?= htmlspecialchars($data['display_name']) ?>" placeholder="Display Name" required><br>
    <textarea name="description" placeholder="Description"><?= htmlspecialchars($data['description']) ?></textarea><br>
    <button type="submit" name="update">Update Info</button>
  </form>

  <h3>📸 Upload Photo</h3>
  <form method="POST" enctype="multipart/form-data">
    <input type="file" name="new_photo" accept="image/*" required>
    <button type="submit">Upload</button>
  </form>

  <h3>🖼️ Your Posts</h3>
  <?php while($p = $photos->fetch_assoc()): 
    $pid = $p['id'];
    $reactions = $conn->query("SELECT COUNT(*) as cnt FROM reactions WHERE photo_id='$pid'")->fetch_assoc()['cnt'];
    $comments = $conn->query("SELECT COUNT(*) as cnt FROM comments WHERE photo_id='$pid'")->fetch_assoc()['cnt'];
  ?>
    <div class="post">
      <img src="<?= $p['photo_path'] ?>" class="pic"><br>
      ❤️ Reactions: <?= $reactions ?> | 💬 Comments: <?= $comments ?>
      <form method="POST" onsubmit="return confirm('Delete this photo?');">
        <input type="hidden" name="delete_photo_id" value="<?= $pid ?>">
        <button type="submit">🗑️ Delete</button>
      </form>
    </div>
  <?php endwhile; ?>

  <a href="home.php">← Back to Home</a>
</body>
</html>
