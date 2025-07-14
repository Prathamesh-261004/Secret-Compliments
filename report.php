<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user'])) die("Unauthorized.");

$user = $_SESSION['user'];
$cid = $_GET['cid'] ?? '';

if ($cid) {
  // Prevent duplicate report by same user
  $check = $conn->prepare("SELECT * FROM reports WHERE comment_id=? AND reported_by=?");
  $check->bind_param("is", $cid, $user);
  $check->execute();
  $res = $check->get_result();

  if ($res->num_rows == 0) {
    $stmt = $conn->prepare("INSERT INTO reports (comment_id, reported_by) VALUES (?, ?)");
    $stmt->bind_param("is", $cid, $user);
    $stmt->execute();

    // Count reports and auto-delete if 3+
    $rc = $conn->query("SELECT COUNT(*) as cnt FROM reports WHERE comment_id=$cid")->fetch_assoc();
    if ($rc['cnt'] >= 3) {
      $conn->query("DELETE FROM comments WHERE id=$cid");
      $conn->query("DELETE FROM reports WHERE comment_id=$cid");
    }
  }
}
header("Location: home.php");
