<?php
require 'db.php';

if (!isset($_GET['id'])) {
    die("Student ID not provided.");
}

$id = (int)$_GET['id'];

// Fetch student to get image path
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
$stmt->execute([':id' => $id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found.");
}

// Delete the image if it exists
if (!empty($student['image']) && file_exists($student['image'])) {
    unlink($student['image']);
}

// Delete the student from the database
$stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
$stmt->execute([':id' => $id]);

header('Location: index.php');
exit;
?>
