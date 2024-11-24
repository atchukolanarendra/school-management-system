<?php
require 'db.php';

if (!isset($_GET['id'])) {
    die("Student ID not provided.");
}

$id = (int)$_GET['id'];

// Fetch current student data
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
$stmt->execute([':id' => $id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found.");
}

// Fetch classes for the dropdown
$classes = $pdo->query("SELECT * FROM classes")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $imagePath = $student['image'];

    if (empty($name)) {
        $error = "Name is required.";
    } else {
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image'];
            $allowed = ['image/jpeg', 'image/png'];

            if (!in_array($image['type'], $allowed)) {
                $error = "Only JPG and PNG images are allowed.";
            } else {
                // Delete old image
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                // Upload new image
                $imagePath = 'uploads/' . time() . '_' . basename($image['name']);
                move_uploaded_file($image['tmp_name'], $imagePath);
            }
        }

        if (empty($error)) {
            $stmt = $pdo->prepare("UPDATE students SET name = :name, email = :email, address = :address, 
                                   class_id = :class_id, image = :image WHERE id = :id");
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':address' => $address,
                ':class_id' => $class_id,
                ':image' => $imagePath,
                ':id' => $id,
            ]);
            header('Location: index.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Edit Student</h1>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($student['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($student['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address" class="form-control"><?= htmlspecialchars($student['address']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="class_id" class="form-label">Class</label>
            <select name="class_id" id="class_id" class="form-control" required>
                <option value="">Select Class</option>
                <?php foreach ($classes as $class): ?>
                    <option value="<?= $class['class_id'] ?>" <?= $class['class_id'] == $student['class_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($class['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <?php if (!empty($student['image']) && file_exists($student['image'])): ?>
                <img src="<?= htmlspecialchars($student['image']) ?>" alt="Student Image" width="100">
            <?php endif; ?>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update Student</button>
    </form>
</div>
</body>
</html>
