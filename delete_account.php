<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user'])) die("Unauthorized.");

$user = $_SESSION['user'];

// Delete all related data
$conn->query("DELETE FROM users WHERE username='$user'");
$conn->query("DELETE FROM photos WHERE user='$user'");
$conn->query("DELETE FROM comments WHERE from_user='$user' OR to_user='$user'");
$conn->query("DELETE FROM friend_requests WHERE sender='$user' OR receiver='$user'");
$conn->query("DELETE FROM reactions WHERE from_user='$user' OR to_user='$user'");
$conn->query("DELETE FROM reports WHERE reported_by='$user'");

// Destroy session and redirect
session_destroy();
header("Location: login.php");
