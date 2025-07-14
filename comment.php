<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user'])) die("Unauthorized.");

$from = $_SESSION['user'];
$to = $_POST['to_user'];
$photo_id = $_POST['photo_id'];
$text = trim($_POST['comment_text']);

if ($text && $photo_id && $to && $from != $to) {
  $stmt = $conn->prepare("INSERT INTO comments (from_user, to_user, comment_text, photo_id) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("sssi", $from, $to, $text, $photo_id);
  $stmt->execute();
}
header("Location: home.php");
