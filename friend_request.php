<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user'])) die("Unauthorized.");
$user = $_SESSION['user'];

$action = $_GET['action'] ?? '';
$target = $_GET['to'] ?? $_GET['from'] ?? '';

if ($action === 'send') {
  $stmt = $conn->prepare("INSERT INTO friend_requests (sender, receiver, status) VALUES (?, ?, 'pending')");
  $stmt->bind_param("ss", $user, $target);
  $stmt->execute();
}

if ($action === 'accept') {
  $stmt = $conn->prepare("UPDATE friend_requests SET status='accepted' WHERE sender=? AND receiver=?");
  $stmt->bind_param("ss", $target, $user);
  $stmt->execute();
}

if ($action === 'reject') {
  $stmt = $conn->prepare("DELETE FROM friend_requests WHERE sender=? AND receiver=? AND status='pending'");
  $stmt->bind_param("ss", $target, $user);
  $stmt->execute();
}

if ($action === 'unfriend') {
  $stmt = $conn->prepare("DELETE FROM friend_requests WHERE ((sender=? AND receiver=?) OR (sender=? AND receiver=?)) AND status='accepted'");
  $stmt->bind_param("ssss", $user, $target, $target, $user);
  $stmt->execute();
}

header("Location: home.php");
exit;
