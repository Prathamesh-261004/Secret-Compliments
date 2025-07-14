<?php
session_start();
require 'db.php';
if (!isset($_SESSION['admin'])) die("Unauthorized.");

$id = $_GET['id'] ?? '';
if ($id) {
  $conn->query("DELETE FROM comments WHERE id=$id");
  $conn->query("DELETE FROM reports WHERE comment_id=$id");
}
header("Location: reports.php");
