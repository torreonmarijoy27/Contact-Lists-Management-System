<?php
include 'db.php';
echo "ID: " . $id;
// ✅ FIX: prevent Undefined array key error
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// SAFE QUERY
$result = $conn->query("SELECT * FROM contacts WHERE id=$id");
$row = $result->fetch_assoc();

if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday'];

    // KEEP OLD IMAGE
    $image = $row['image'];

    // NEW IMAGE UPLOAD
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $target = "uploads/" . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image = $imageName;
        }
    }

    // SAFE UPDATE QUERY
    $sql = "UPDATE contacts SET
            name='$name',
            phone='$phone',
            email='$email',
            address='$address',
            birthday='$birthday',
            image='$image'
            WHERE id=$id";

    $conn->query($sql);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Contact</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            min-height: 100vh;
        }

        .card-box {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            max-width: 600px;
            margin: auto;
        }

        .title {
            font-weight: 600;
        }

        .btn-custom {
            background: #4facfe;
            color: white;
            border-radius: 8px;
        }

        .btn-custom:hover {
            background: #00c6ff;
        }

        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<div class="container mt-5">
    <div class="card-box">

        <h2 class="title mb-4 text-center"> Update Contact</h2>

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-2">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>" required>
            </div>

            <div class="mb-2">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="<?= $row['phone'] ?>" required>
            </div>

            <div class="mb-2">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= $row['email'] ?>" required>
            </div>

            <div class="mb-2">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="<?= $row['address'] ?>" required>
            </div>

            <div class="mb-2">
                <label>Birthday</label>
                <input type="date" name="birthday" class="form-control" value="<?= $row['birthday'] ?>" required>
            </div>

            <div class="mb-2 text-center">
                <label>Current Image</label><br>

                <?php if (!empty($row['image'])) { ?>
                    <img src="uploads/<?= $row['image'] ?>" class="profile-img">
                <?php } else { ?>
                    <p>No Image</p>
                <?php } ?>
            </div>

            <div class="mb-3">
                <label>Change Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="text-center">
                <button type="submit" name="update" class="btn btn-custom px-4">Update</button>
                <a href="index.php" class="btn btn-custom">← Back</a>
            </div>

        </form>

    </div>
</div>

</body>
</html>