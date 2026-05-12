<?php include 'db.php'; ?>

<?php
// ===================== UPDATE HANDLER (FIX ADDED) =====================
if (isset($_POST['id'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday'];

    // IMAGE HANDLING
    $image = $_POST['old_image'];

    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
    }

    $conn->query("UPDATE contacts SET 
        name='$name',
        phone='$phone',
        email='$email',
        address='$address',
        birthday='$birthday',
        image='$image'
        WHERE id=$id
    ");

    header("Location: index.php");
    exit();
}

// ===================== OVERVIEW COUNTS =====================
$totalContacts = $conn->query("SELECT COUNT(*) as total FROM contacts")->fetch_assoc()['total'];

$totalEmail = $conn->query("SELECT COUNT(email) as total FROM contacts WHERE email != ''")->fetch_assoc()['total'];

$totalPhone = $conn->query("SELECT COUNT(phone) as total FROM contacts WHERE phone != ''")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
    background: rgba(0,0,0,0.18);
    backdrop-filter: blur(14px);
    border-right: 1px solid rgba(255,255,255,0.25);
    padding: 25px;
}

.logo-box {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}

.logo-box img { width: 38px; }
.logo-box h4 { color: white; font-weight: 700; }

.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 12px;
    margin: 10px 0;
    border-radius: 10px;
    background: rgba(255,255,255,0.12);
    transition: 0.3s;
}

.sidebar a:hover {
    transform: translateX(6px);
    background: rgba(255,255,255,0.25);
}

/* MAIN */
.main-content { margin-left: 260px; }

.card-box {
    background: #fff;
    padding: 25px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.profile-img {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    object-fit: cover;
}

.action-btn {
    border: none;
    background: none;
    margin: 0 5px;
    font-size: 18px;
}

.action-btn.edit { color: #f0ad4e; }
.action-btn.delete { color: #dc3545; }

.overview-card {
    padding: 20px;
    border-radius: 12px;
    color: white;
    text-align: center;
}

.overview-blue { background: #0d6efd; }
.overview-green { background: #198754; }
.overview-yellow { background: #ffc107; color: black; }
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo-box">
        <img src="https://www.flaticon.com/free-icon/dashboard_15066899">
        <h4>ContactSys</h4>
    </div>

    <a href="index.php">🏠 Dashboard</a>
    <a href="add.php">➕ Add Contact</a>
</div>

<!-- MAIN -->
<div class="main-content">
<div class="container mt-5">
<div class="card-box">

<h2>📇 Contact Management</h2>

<!-- OVERVIEW -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="overview-card overview-blue">
            <h5>Total Contacts</h5>
            <h3><?= $totalContacts ?></h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="overview-card overview-green">
            <h5>With Email</h5>
            <h3><?= $totalEmail ?></h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="overview-card overview-yellow">
            <h5>With Phone</h5>
            <h3><?= $totalPhone ?></h3>
        </div>
    </div>
</div>

<!-- SEARCH -->
<form method="GET" class="mb-3">
<input type="text" name="search" class="form-control" placeholder="Search...">
</form>

<!-- TABLE -->
<table class="table table-hover text-center">
<thead>
<tr>
<th>ID</th><th>Image</th><th>Name</th><th>Phone</th><th>Email</th><th>Address</th><th>Birthday</th><th>Action</th>
</tr>
</thead>

<tbody>

<?php
if (!empty($_GET['search'])) {
    $search = $_GET['search'];
    $result = $conn->query("SELECT * FROM contacts WHERE name LIKE '%$search%' OR phone LIKE '%$search%' OR email LIKE '%$search%'");
} else {
    $result = $conn->query("SELECT * FROM contacts");
}

while($row = $result->fetch_assoc()) {
?>

<tr>
    <div class="modal fade" id="imgModal<?= $row['id']; ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: transparent; border: none;">

      <div class="modal-body text-center">
        <img src="uploads/<?= $row['image']; ?>" 
             style="width:100%; max-height:500px; object-fit:contain; border-radius:10px;">
      </div>

    </div>
  </div>
</div>
<td><?= $row['id'] ?></td>

<td>

<?php if(!empty($row['image'])) { ?>

<img src="uploads/<?= $row['image']; ?>" 
     class="profile-img"
     style="cursor:pointer;"
     data-bs-toggle="modal"
     data-bs-target="#imgModal<?= $row['id']; ?>">

<?php } else { ?>

<img src="https://via.placeholder.com/55" class="profile-img">

<?php } ?>

</td>

<td><?= $row['name'] ?></td>
<td><?= $row['phone'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['address'] ?></td>
<td><?= $row['birthday'] ?></td>

<td>

<!-- EDIT ICON -->
<button class="action-btn edit" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id']; ?>">
    <i class="fa-solid fa-pen-to-square"></i>
</button>

<!-- DELETE ICON -->
<a href="delete.php?id=<?= $row['id']; ?>" 
   class="action-btn delete"
   onclick="return confirm('Are you sure you want to delete this contact?')">

    <i class="fa-solid fa-trash"></i>
</a>

</td>

<!-- EDIT MODAL -->
<div class="modal fade" id="edit<?= $row['id'] ?>">
<div class="modal-dialog">
<div class="modal-content">

<form method="POST" enctype="multipart/form-data">

<div class="modal-header">
<h5>Edit Contact</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="hidden" name="id" value="<?= $row['id'] ?>">
<input type="hidden" name="old_image" value="<?= $row['image'] ?>">

<input type="text" name="name" class="form-control mb-2" value="<?= $row['name'] ?>">
<input type="text" name="phone" class="form-control mb-2" value="<?= $row['phone'] ?>">
<input type="email" name="email" class="form-control mb-2" value="<?= $row['email'] ?>">
<input type="text" name="address" class="form-control mb-2" value="<?= $row['address'] ?>">
<input type="date" name="birthday" class="form-control mb-2" value="<?= $row['birthday'] ?>">

<label>Change Image</label>
<input type="file" name="image" class="form-control">

</div>

<div class="modal-footer">
<button class="btn btn-primary">Update</button>
</div>

</form>

</div>
</div>
</div>

<?php } ?>

</tbody>
</table>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>