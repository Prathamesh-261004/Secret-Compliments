<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user'])) die("Unauthorized.");

$from = $_SESSION['user'];
$to = $_GET['to_user'] ?? '';
$emoji = $_GET['emoji'] ?? '';
$photo_id = $_GET['photo_id'] ?? '';

if ($to && $emoji && $photo_id) {
  // Only one reaction per user per photo — update if exists
  $check = $conn->prepare("SELECT * FROM reactions WHERE from_user=? AND photo_id=?");
  $check->bind_param("si", $from, $photo_id);
  $check->execute();
  $res = $check->get_result();

  if ($res->num_rows > 0) {
    $stmt = $conn->prepare("UPDATE reactions SET emoji=? WHERE from_user=? AND photo_id=?");
    $stmt->bind_param("ssi", $emoji, $from, $photo_id);
  } else {
    $stmt = $conn->prepare("INSERT INTO reactions (from_user, to_user, emoji, photo_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $from, $to, $emoji, $photo_id);
  }

  $stmt->execute();
}
header("Location: home.php");
