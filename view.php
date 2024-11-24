<?php
require 'db.php';

if (!isset($_GET['id'])) {
    die("Student ID not provided.");
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT students.*, classes.name AS class_name 
                       FROM students 
                       LEFT JOIN classes ON students.class_id = classes.class_id 
                       WHERE students.id = :id");
$stmt->execute([':id' => $id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>View Student</h1>
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <td><?= htmlspecialchars($student['name']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($student['email']) ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?= htmlspecialchars($student['address']) ?></td>
        </tr>
        <tr>
            <th>Class</th>
            <td><?= htmlspecialchars($student['class_name']) ?: 'No Class' ?></td>
        </tr>
        <tr>
            <th>Image</th>
            <td>
                <?php if (!empty($student['image']) && file_exists($student['image'])): ?>
                    <img src="<?= htmlspecialchars($student['image']) ?>" alt="Student Image" width="150">
                <?php else: ?>
                    <span>No Image</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Created At</th>
            <td><?= htmlspecialchars($student['created_at']) ?></td>
        </tr>
    </table>
    <a href="index.php" class="btn btn-primary">Back to List</a>
</div>
</body>
</html>
