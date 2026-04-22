<?php include 'db.php'; ?>

<?php
// OVERVIEW COUNTS (NEW ADDED ONLY)
$totalContacts = $conn->query("SELECT COUNT(*) as total FROM contacts")->fetch_assoc()['total'];

$totalEmail = $conn->query("SELECT COUNT(email) as total FROM contacts WHERE email != ''")->fetch_assoc()['total'];

$totalPhone = $conn->query("SELECT COUNT(phone) as total FROM contacts WHERE phone != ''")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Management</title>
// BOOTSTRAP 5, FONT AWESOME, GOOGLE FONTS

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

.logo-box img {
    width: 38px;
}

.logo-box h4 {
    color: white;
    font-weight: 700;
}

/* LINKS */
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
.main-content {
    margin-left: 260px;
}

/* CARD */
.card-box {
    background: #fff;
    padding: 25px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

/* PROFILE IMAGE */
.profile-img {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    object-fit: cover;
    transition: 0.3s;
}

.profile-img:hover {
    transform: scale(1.2);
}

/* SEARCH INPUT */
.form-control {
    border-radius: 10px;
    border: 2px solid #0d6efd;
    background: #f8fbff;
    transition: 0.3s ease;
}

.form-control:focus {
    border-color: #00c6ff;
    box-shadow: 0 0 8px rgba(13, 110, 253, 0.3);
    background: #ffffff;
}

/* SEARCH ICON INSIDE INPUT */
.search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
}

.search-wrapper i {
    position: absolute;
    left: 12px;
    color: #0d6efd;
    font-size: 18px;
    pointer-events: none;
}

.search-wrapper input {
    padding-left: 35px;
}

/* TABLE */
.table {
    border-radius: 12px;
    overflow: hidden;
}

/* ACTION BUTTONS */
.action-btn {
    border: none;
    background: none;
    margin: 0 5px;
    transition: 0.2s;
    font-size: 18px;
}

.action-btn.edit {
    color: #f0ad4e;
}

.action-btn.delete {
    color: #dc3545;
}

.action-btn.search {
    color: #0d6efd;
}

.action-btn:hover {
    transform: scale(1.3);
}

/* BUTTON */
.btn-custom {
    background: #4facfe;
    color: white;
    border-radius: 8px;
}

.btn-custom:hover {
    background: #00c6ff;
}

/* OVERVIEW CARDS (NEW) */
.overview-card {
    padding: 20px;
    border-radius: 12px;
    color: white;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.overview-blue {
    background: #0d6efd;
}

.overview-green {
    background: #198754;
}

.overview-yellow {
    background: #ffc107;
    color: black;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo-box">
        <img src="https://cdn-icons-png.flaticon.com/512/1256/1256652.png">
        <h4>ContactSys</h4>
    </div>

    <a href="index.php">🏠 Dashboard</a>
    <a href="add.php">➕ Add Contact</a>
</div>

<!-- MAIN -->
<div class="main-content">
<div class="container mt-5">
<div class="card-box">

<h2 class="mb-3">📇 Contact Management</h2>

<!-- OVERVIEW (NEW SECTION) -->
<div class="row mb-4">

    <div class="col-md-4">
        <div class="overview-card overview-blue">
            <h5>Total Contacts</h5>
            <h3><?php echo $totalContacts; ?></h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="overview-card overview-green">
            <h5>With Email</h5>
            <h3><?php echo $totalEmail; ?></h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="overview-card overview-yellow">
            <h5>With Phone</h5>
            <h3><?php echo $totalPhone; ?></h3>
        </div>
    </div>

</div>

<!-- SEARCH -->
<form method="GET" class="mb-3 d-flex gap-2">

<div class="search-wrapper">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="text" name="search" class="form-control"
    placeholder=""
    value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
</div>

<?php if (!empty($_GET['search'])) { ?>
<a href="index.php" class="btn btn-custom">← Back</a>
<?php } ?>

</form>

<!-- TABLE -->
<table class="table table-hover align-middle text-center">
<thead>
<tr>
<th>ID</th>
<th>Image</th>
<th>Name</th>
<th>Phone</th>
<th>Email</th>
<th>Address</th>
<th>Birthday</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
if (!empty($_GET['search'])) {
$search = $_GET['search'];
$result = $conn->query("SELECT * FROM contacts 
WHERE name LIKE '%$search%' 
OR phone LIKE '%$search%' 
OR email LIKE '%$search%'");
} else {
$result = $conn->query("SELECT * FROM contacts");
}

while($row = $result->fetch_assoc()) {
?>

<tr>
<td><?php echo $row['id']; ?></td>

<td>
<?php if(!empty($row['image'])) { ?>
<img src="uploads/<?php echo $row['image']; ?>" class="profile-img">
<?php } else { ?>
<img src="https://via.placeholder.com/55" class="profile-img">
<?php } ?>
</td>

<td><?php echo $row['name']; ?></td>
<td><?php echo $row['phone']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['address']; ?></td>
<td><?php echo $row['birthday']; ?></td>

<td>
<button class="action-btn edit" data-bs-toggle="modal" data-bs-target="#edit<?php echo $row['id']; ?>">
    <i class="fa-solid fa-pen-to-square"></i>
</button>

<button class="action-btn delete" data-bs-toggle="modal" data-bs-target="#delete<?php echo $row['id']; ?>">
    <i class="fa-solid fa-trash"></i>
</button>
</td>
</tr>

<!-- EDIT MODAL -->
<div class="modal fade" id="edit<?php echo $row['id']; ?>">
<div class="modal-dialog">
<div class="modal-content">

<form action="update.php" method="POST" enctype="multipart/form-data">

<div class="modal-header">
<h5>Edit Contact</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<input type="text" name="name" class="form-control mb-2" value="<?php echo $row['name']; ?>">
<input type="text" name="phone" class="form-control mb-2" value="<?php echo $row['phone']; ?>">
<input type="email" name="email" class="form-control mb-2" value="<?php echo $row['email']; ?>">
<input type="text" name="address" class="form-control mb-2" value="<?php echo $row['address']; ?>">
<input type="date" name="birthday" class="form-control mb-2" value="<?php echo $row['birthday']; ?>">

<input type="hidden" name="old_image" value="<?php echo $row['image']; ?>">

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

<!-- DELETE MODAL -->
<div class="modal fade" id="delete<?php echo $row['id']; ?>">
<div class="modal-dialog">
<div class="modal-content text-center p-4">

<h5>Delete this contact?</h5>

<div class="mt-3">
<a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Yes</a>
<button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
</div>

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