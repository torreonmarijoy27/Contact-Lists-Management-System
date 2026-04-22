<?php
include 'db.php';

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday'];

    $image = "";

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $target = __DIR__ . "/uploads/" . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image = $imageName;
        }
    }

    $sql = "INSERT INTO contacts (name, phone, email, address, birthday, image)
            VALUES ('$name', '$phone', '$email', '$address', '$birthday', '$image')";

    if ($conn->query($sql)) {
        header("Location: index.php");
        exit();
    } else {
        die("Database Error: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Contact</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to right, #4facfe, #00f2fe);
    min-height: 100vh;
}

/* SIDEBAR */
.sidebar {
    width: 240px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;

    background: rgba(0,0,0,0.22);
    backdrop-filter: blur(16px);
    border-right: 1px solid rgba(255,255,255,0.25);

    padding: 25px;
}

/* LOGO */
.logo-box {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.logo-box img {
    width: 36px;
    height: 36px;
    transition: 0.4s ease;
    filter: drop-shadow(0 0 10px rgba(255,255,255,0.5));
}

.logo-box img:hover {
    transform: scale(1.2) rotate(8deg);
    filter: drop-shadow(0 0 18px rgba(79,172,254,0.9));
}

.logo-box h4 {
    color: white;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 0 10px rgba(79,172,254,0.6);
}

/* LINKS */
.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 12px;
    margin: 10px 0;
    border-radius: 10px;
    background: rgba(255,255,255,0.15);
    transition: 0.3s;
}

.sidebar a:hover {
    transform: translateX(6px);
    background: rgba(255,255,255,0.35);
    box-shadow: 0 0 12px rgba(255,255,255,0.3);
}

/* MAIN CONTENT */
.main-content {
    margin-left: 260px;
}

/* CARD */
.card-box {
    background: #ffffff;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    transition: 0.3s;
}

.card-box:hover {
    transform: translateY(-3px);
}

/* TITLE */
.title {
    font-weight: 600;
    color: #0f2027;
}

/* BUTTON */
.btn-custom {
    background: #4facfe;
    color: white;
    border-radius: 8px;
    transition: 0.3s;
    border: none;
}

.btn-custom:hover {
    transform: scale(1.05);
    background: #00c6ff;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

/* FORM */
.form-control {
    border-radius: 8px;
}

label {
    font-weight: 500;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo-box">
        <img src="https://cdn-icons-png.flaticon.com/512/1256/1256652.png" alt="logo">
        <h4>ContactSys</h4>
    </div>

    <a href="index.php">🏠 Dashboard</a>
    <a href="add.php">➕ Add Contact</a>
</div>

<!-- MAIN -->
<div class="main-content">

<div class="container mt-5">
    <div class="card-box">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="title">Add Contact</h2>
            <a href="index.php" class="btn btn-custom">← Back</a>
        </div>

        <form method="POST" enctype="multipart/form-data">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Birthday</label>
                    <input type="date" name="birthday" class="form-control">
                </div>

                <div class="col-12 mb-3">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control">
                </div>

                <div class="col-12 mb-4">
                    <label>Profile Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>

            <div class="text-end">
                <button name="submit" class="btn btn-custom">Save Contact</button>
            </div>

        </form>

    </div>
</div>

</div>

</body>
</html>