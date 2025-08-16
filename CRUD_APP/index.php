<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CRUD_APP";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO students (name, email, phone, address) VALUES ('$name','$email','$phone','$address')";
    $conn->query($sql);
    header("Location: index.php");
    exit();
}

// Delete data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM students WHERE id=$id");
    header("Location: index.php");
    exit();
}

// Update data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "UPDATE students SET name='$name', email='$email', phone='$phone', address='$address' WHERE id=$id";
    $conn->query($sql);
    header("Location: index.php");
    exit();
}

// Fetch all students
$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CRUD APP</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f7f7;
      margin: 20px;
      padding: 0;
    }
    h2 {
      text-align: center;
      color: #333;
    }
    form {
      background: #fff;
      padding: 20px;
      margin: 20px auto;
      width: 400px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    input, textarea {
      width: 100%;
      padding: 8px;
      margin: 6px 0 12px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    input[type=submit] {
      background: #28a745;
      color: white;
      border: none;
      cursor: pointer;
      transition: 0.3s;
    }
    input[type=submit]:hover {
      background: #218838;
    }
    table {
      width: 90%;
      margin: 20px auto;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    table th, table td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    table th {
      background: #007bff;
      color: white;
    }
    a {
      text-decoration: none;
      padding: 5px 10px;
      border-radius: 5px;
      color: white;
    }
    .edit {
      background: #ffc107;
    }
    .delete {
      background: #dc3545;
    }
  </style>
</head>
<body>

<h2>CRUD Application (PHP & MySQL)</h2>

<?php
// If editing, show update form
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = $conn->query("SELECT * FROM students WHERE id=$id")->fetch_assoc();
?>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $editData['id']; ?>">
        <input type="text" name="name" value="<?= $editData['name']; ?>" required>
        <input type="email" name="email" value="<?= $editData['email']; ?>" required>
        <input type="text" name="phone" value="<?= $editData['phone']; ?>" required>
        <textarea name="address" required><?= $editData['address']; ?></textarea>
        <input type="submit" name="update" value="Update Student">
    </form>
<?php
} else {
?>
    <form method="POST">
        <input type="text" name="name" placeholder="Enter Name" required>
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="text" name="phone" placeholder="Enter Phone" required>
        <textarea name="address" placeholder="Enter Address" required></textarea>
        <input type="submit" name="submit" value="Add Student">
    </form>
<?php } ?>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['id']; ?></td>
        <td><?= $row['name']; ?></td>
        <td><?= $row['email']; ?></td>
        <td><?= $row['phone']; ?></td>
        <td><?= $row['address']; ?></td>
        <td>
            <a href="index.php?edit=<?= $row['id']; ?>" class="edit">Edit</a>
            <a href="index.php?delete=<?= $row['id']; ?>" class="delete" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
