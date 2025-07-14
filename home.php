<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user'])) die("Unauthorized. <a href='login.php'>Login</a>");
$user = $_SESSION['user'];

// Fetch users excluding self
$stmt = $conn->prepare("SELECT username, profile_pic, display_name FROM users WHERE username != ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$res = $stmt->get_result();

// Fetch posts
$photos = $conn->query("SELECT * FROM photos ORDER BY uploaded_at DESC");

// Incoming friend requests
$incoming_stmt = $conn->prepare("SELECT sender FROM friend_requests WHERE receiver=? AND status='pending'");
$incoming_stmt->bind_param("s", $user);
$incoming_stmt->execute();
$incoming = $incoming_stmt->get_result();

// Check friendship
function isFriend($a, $b, $conn) {
  $q = $conn->prepare("SELECT COUNT(*) as cnt FROM friend_requests WHERE ((sender=? AND receiver=?) OR (sender=? AND receiver=?)) AND status='accepted'");
  $q->bind_param("ssss", $a, $b, $b, $a);
  $q->execute();
  $r = $q->get_result()->fetch_assoc();
  return $r['cnt'] >= 2;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 20px;
      background: linear-gradient(135deg, #ff6b6b, #54a0ff, #45b7d1, #feca57, #4ecdc4, #ff9ff3);
      background-size: 400% 400%;
      animation: flow 20s ease infinite;
      text-align: center;
      color: #333;
    }

    @keyframes flow {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }

    .topbar {
      background: rgba(0,0,0,0.6);
      color: white;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }

    .topbar a {
      color: #ffb3b3;
      margin: 0 12px;
      font-weight: bold;
      text-decoration: none;
    }

    .topbar a:hover {
      color: white;
      text-shadow: 0 0 5px #ff6b6b;
    }

    h2 {
      background: rgba(255, 255, 255, 0.2);
      display: inline-block;
      padding: 10px 25px;
      border-radius: 10px;
      backdrop-filter: blur(5px);
      color: #fff;
      margin: 30px 0 10px;
    }

    .incoming, .user-card, .card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      padding: 15px;
      margin: 15px auto;
      max-width: 500px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .incoming {
      background: #fff9e6;
      width: 300px;
    }

    .user-card {
      display: inline-block;
      vertical-align: top;
      width: 210px;
      margin: 10px;
      padding: 15px;
    }

    .user-card img {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 10px;
    }

    img.photo {
      width: 100%;
      border-radius: 12px;
    }

    .comment {
      background: #f1f1f1;
      padding: 8px;
      border-radius: 8px;
      margin: 5px 0;
      text-align: left;
    }

    input[type="text"] {
      width: 80%;
      padding: 8px;
      margin: 10px auto;
      display: block;
      border-radius: 10px;
      border: 1px solid #ccc;
    }

    button {
      background: linear-gradient(to right, #ff6b6b, #ff8e8e, #ffb3b3);
      color: white;
      font-weight: bold;
      padding: 10px 18px;
      border: none;
      border-radius: 50px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    button:hover {
      transform: scale(1.05);
      background-position: right center;
    }

    a {
      color: #e91e63;
      text-decoration: none;
      font-weight: bold;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="topbar">
  Welcome, <b><?= $user ?></b> |
  <a href="profile.php">My Profile</a> |
  <a href="logout.php">Logout</a> |
  <a href="delete_account.php" style="color:#ff4d4d;">🗑️ Delete Account</a>
</div>

<h2>📨 Incoming Friend Requests</h2><br>
<?php while($row = $incoming->fetch_assoc()): ?>
  <div class="incoming">
    @<?= $row['sender'] ?> <br>
    <a href="friend_request.php?action=accept&from=<?= $row['sender'] ?>">✅ Accept</a> |
    <a href="friend_request.php?action=reject&from=<?= $row['sender'] ?>" style="color:red;">❌ Reject</a>
  </div>
<?php endwhile; ?>

<h2>🌟 Explore Users</h2><br>
<?php
$res->data_seek(0);
while ($row = $res->fetch_assoc()):
  $other = $row['username'];
  $status = isFriend($user, $other, $conn);
?>
  <div class="user-card">
    <img src="<?= $row['profile_pic'] ?>"><br>
    <a href="user.php?u=<?= $other ?>">@<?= $other ?></a><br>
    <small><?= htmlspecialchars($row['display_name']) ?></small><br>
    <form method="GET" action="friend_request.php">
      <input type="hidden" name="action" value="<?= $status ? 'unfriend' : 'send' ?>">
      <input type="hidden" name="to" value="<?= $other ?>">
      <button type="submit"><?= $status ? '❌ Unfriend' : '➕ Add Friend' ?></button>
    </form>
  </div>
<?php endwhile; ?><br>

<h2>🖼️ Latest Posts</h2>
<?php while($row = $photos->fetch_assoc()):
  $poster = $row['user'];
  $pid = $row['id'];
  $photo_path = $row['photo_path'];
  $dname = $conn->query("SELECT display_name FROM users WHERE username='$poster'")->fetch_assoc()['display_name'];
?>
  <div class="card">
    <img src="<?= $photo_path ?>" class="photo"><br><br>
    <b><a href="user.php?u=<?= $poster ?>">@<?= $poster ?></a></b> — <?= htmlspecialchars($dname) ?>

    <form action="comment.php" method="POST">
      <input type="hidden" name="to_user" value="<?= $poster ?>">
      <input type="hidden" name="photo_id" value="<?= $pid ?>">
      <input type="text" name="comment_text" placeholder="Say something nice" required>
      <button type="submit">Comment</button>
    </form>

    ❤️ <a href="react.php?to_user=<?= $poster ?>&photo_id=<?= $pid ?>&emoji=❤️">React</a>
    🔥 <a href="react.php?to_user=<?= $poster ?>&photo_id=<?= $pid ?>&emoji=🔥">React</a>
    😊 <a href="react.php?to_user=<?= $poster ?>&photo_id=<?= $pid ?>&emoji=😊">React</a>

    <?php
    $comments = $conn->prepare("SELECT * FROM comments WHERE photo_id=?");
    $comments->bind_param("i", $pid);
    $comments->execute();
    $commentResult = $comments->get_result();
    while($c = $commentResult->fetch_assoc()):
      $from = $c['from_user'];
      $isFriend = isFriend($user, $from, $conn);
      $display = "Anonymous";
      if ($isFriend) {
        $dn = $conn->query("SELECT display_name FROM users WHERE username='$from'")->fetch_assoc()['display_name'];
        $display = "<a href='user.php?u=$from'>" . htmlspecialchars($dn) . "</a>";
      }
    ?>
      <div class="comment">
        <b><?= $display ?>:</b>
        <?= htmlspecialchars($c['comment_text']) ?>
        <a href="report.php?cid=<?= $c['id'] ?>" style="float:right;color:red;">🚩</a>
      </div>
    <?php endwhile; ?>
  </div>
<?php endwhile; ?>

</body>
</html>
