<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user']) || !isset($_GET['user'])) die("Unauthorized.");

$me = $_SESSION['user'];
$other = $_GET['user'];

// Delete both directions
$stmt = $conn->prepare("DELETE FROM friend_requests WHERE 
  (sender=? AND receiver=?) OR 
  (sender=? AND receiver=?)");
$stmt->bind_param("ssss", $me, $other, $other, $me);
$stmt->execute();

header("Location: home.php");
exit();
