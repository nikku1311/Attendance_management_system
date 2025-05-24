<?php
include "db.php";

// Add Student
if (isset($_POST['add_student'])) {
    $name = trim($_POST['student_name']);
    $nationality = $_POST['nationality'];
    $bloodgroup = $_POST['bloodgroup'];
    $phonenumber = $_POST['phonenumber'];
    $race = $_POST['race'];
    $age = $_POST['age'];
    $birthday = $_POST['birthday'];
    $parents_name = $_POST['parents_name'];
    $address = $_POST['address'];

    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO students 
            (name, nationality, bloodgroup, phonenumber, race, age, birthday, parents_name, address) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssisss", $name, $nationality, $bloodgroup, $phonenumber, $race, $age, $birthday, $parents_name, $address);
        $stmt->execute();
    }
}

// Delete Student
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $conn->query("DELETE FROM attendance WHERE student_id = $id");
    $conn->query("DELETE FROM students WHERE id = $id");
}

// Mark Attendance
if (isset($_POST['mark_attendance'])) {
    $date = $_POST['date'];
    foreach ($_POST['status'] as $student_id => $status) {
        $stmt = $conn->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $student_id, $date, $status);
        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Attendance Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>👤 Add Student</h2>
<form method="POST">
    <input type="text" name="student_name" placeholder="Name" required>
    <input type="text" name="nationality" placeholder="Nationality" required>
    <input type="text" name="bloodgroup" placeholder="Blood Group" required>
    <input type="text" name="phonenumber" placeholder="Phone Number" required>
    <input type="text" name="race" placeholder="Race" required>
    <input type="number" name="age" placeholder="Age" required>
    <input type="date" name="birthday" required>
    <input type="text" name="parents_name" placeholder="Parents' Name" required>
    <input type="text" name="address" placeholder="Address" required>
    <button type="submit" name="add_student">Add Student</button>
</form>

<h2>📋 Student List</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Nationality</th>
        <th>Blood Group</th>
        <th>Phone</th>
        <th>Race</th>
        <th>Age</th>
        <th>Birthday</th>
        <th>Parents</th>
        <th>Address</th>
        <th>Delete</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM students");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['nationality']}</td>
                <td>{$row['bloodgroup']}</td>
                <td>{$row['phonenumber']}</td>
                <td>{$row['race']}</td>
                <td>{$row['age']}</td>
                <td>{$row['birthday']}</td>
                <td>{$row['parents_name']}</td>
                <td>{$row['address']}</td>
                <td><a href='?delete_id={$row['id']}' onclick='return confirm(\"Delete this student?\")'>Delete</a></td>
              </tr>";
    }
    ?>
</table>

<h2>✅ Mark Attendance</h2>
<form method="POST">
    <label>Date:</label>
    <input type="date" name="date" required>
    <table border="1" cellpadding="5">
        <tr>
            <th>Student</th>
            <th>Present</th>
            <th>Absent</th>
        </tr>
        <?php
        $students = $conn->query("SELECT * FROM students");
        while ($s = $students->fetch_assoc()) {
            echo "<tr>
                    <td>{$s['name']}</td>
                    <td><input type='radio' name='status[{$s['id']}]' value='present' required></td>
                    <td><input type='radio' name='status[{$s['id']}]' value='absent'></td>
                  </tr>";
        }
        ?>
    </table>
    <button type="submit" name="mark_attendance">Submit Attendance</button>
</form>

<h2>📊 Attendance Report</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Name</th>
        <th>Date</th>
        <th>Status</th>
    </tr>
    <?php
    $report = $conn->query("SELECT s.name, a.date, a.status 
                            FROM attendance a 
                            JOIN students s ON s.id = a.student_id 
                            ORDER BY a.date DESC");
    while ($r = $report->fetch_assoc()) {
        echo "<tr>
                <td>{$r['name']}</td>
                <td>{$r['date']}</td>
                <td>{$r['status']}</td>
              </tr>";
    }
    ?>
</table>

</body>
</html>
