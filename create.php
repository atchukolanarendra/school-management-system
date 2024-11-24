<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image'];

    if (empty($name)) {
        $error = "Name is required.";
    } elseif ($image['error'] === 0) {
        $allowed = ['image/jpeg', 'image/png'];
        if (!in_array($image['type'], $allowed)) {
            $error = "Only JPG and PNG images are allowed.";
        } else {
            $imagePath = 'uploads/' . time() . '_' . basename($image['name']);
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
    } else {
        $imagePath = null;
    }

    if (empty($error)) {
        $stmt = $pdo->prepare("INSERT INTO students (name, email, address, class_id, image) 
                               VALUES (:name, :email, :address, :class_id, :image)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':address' => $address,
            ':class_id' => $class_id,
            ':image' => $imagePath,
        ]);
        header('Location: index.php');
        exit;
    }
}

$classes = $pdo->query("SELECT * FROM classes")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Add New Student</h1>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="class_id" class="form-label">Class</label>
            <select name="class_id" id="class_id" class="form-control" required>
                <option value="">Select Class</option>
                <?php foreach ($classes as $class): ?>
                    <option value="<?= $class['class_id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Add Student</button>
    </form>
</div>
</body>
</html>
