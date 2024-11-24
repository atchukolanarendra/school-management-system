<?php
require 'db.php';

$query = "SELECT students.*, classes.name AS class_name FROM students 
          LEFT JOIN classes ON students.class_id = classes.class_id";
$stmt = $pdo->query($query);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Student List</h1>
    <a href="create.php" class="btn btn-primary mb-3">Add New Student</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Class</th>
            <th>Created At</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($students): ?>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student['name']) ?></td>
                    <td><?= htmlspecialchars($student['email']) ?></td>
                    <td><?= htmlspecialchars($student['class_name']) ?: 'No Class' ?></td>
                    <td><?= htmlspecialchars($student['created_at']) ?></td>
                    <td>
                        <?php if (!empty($student['image']) && file_exists($student['image'])): ?>
                            <img src="<?= htmlspecialchars($student['image']) ?>" width="50" height="50" alt="Student Image">
                        <?php else: ?>
                            <span>No Image</span>
                        <?php endif; ?>
                    </td>
                    <td>
                      <a href="view.php?id=<?= $student['id'] ?>" class="btn btn-info btn-sm">View</a>
                      <a href="edit.php?id=<?= $student['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                      <a href="delete.php?id=<?= $student['id'] ?>" class="btn btn-danger btn-sm" 
                      onclick="return confirm('Are you sure?')">Delete</a>
                    </td>

                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No students found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
