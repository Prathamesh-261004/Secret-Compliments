<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user'])) die("Unauthorized");

$user1 = $_SESSION['user'];
$user2 = $_GET['user2'] ?? '';

if (!$user2) die("No user specified.");

$q1 = $conn->query("SELECT * FROM friend_requests WHERE sender='$user1' AND receiver='$user2' AND status='accepted'");
$q2 = $conn->query("SELECT * FROM friend_requests WHERE sender='$user2' AND receiver='$user1' AND status='accepted'");

echo ($q1->num_rows > 0 && $q2->num_rows > 0) ? 'yes' : 'no';
