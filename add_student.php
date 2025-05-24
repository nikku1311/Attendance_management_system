<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $nationality = $_POST['nationality'];
    $bloodgroup = $_POST['bloodgroup'];
    $phonenumber = $_POST['phonenumber'];
    $email = $_POST['email'];
    $race = $_POST['race'];
    $age = $_POST['age'];
    $birthday = $_POST['birthday'];
    $parents_name = $_POST['parents_name'];
    $address = $_POST['address'];

    // Prepared statement for security — now with correct binding
    $stmt = $conn->prepare("INSERT INTO students (name, nationality, bloodgroup, phonenumber, email, race, age, birthday, parents_name, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssisss", $name, $nationality, $bloodgroup, $phonenumber, $email, $race, $age, $birthday, $parents_name, $address);
    $stmt->execute();

    $success = "Student added successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>
    <h2>Add New Student</h2>
    <form method="post">
        Name: <input type="text" name="name" required><br><br>
        Nationality: <input type="text" name="nationality"><br><br>
        Blood Group: <input type="text" name="bloodgroup"><br><br>
        Phone Number: <input type="text" name="phonenumber"><br><br>
        Parent Email: <input type="email" name="email" required><br><br>
        Race: <input type="text" name="race"><br><br>
        Age: <input type="number" name="age"><br><br>
        Birthday: <input type="date" name="birthday"><br><br>
        Parent's Name: <input type="text" name="parents_name"><br><br>
        Address: <textarea name="address" rows="3" cols="30"></textarea><br><br>
        <input type="submit" value="Add Student">
    </form>

    <?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
</body>
</html>
