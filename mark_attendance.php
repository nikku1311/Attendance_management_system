<?php include 'auth.php'; ?>
<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Mark Attendance</h2>
    <form action="submit_attendance.php" method="post">
        <table>
            <tr><th>Student</th><th>Status</th></tr>
            <?php
            $result = $conn->query("SELECT * FROM students");
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>
                            <label><input type='radio' name='attendance[{$row['id']}]' value='present' required> Present</label>
                            <label><input type='radio' name='attendance[{$row['id']}]' value='absent'> Absent</label>
                        </td>
                      </tr>";
            }
            ?>
        </table>
        <input type="submit" value="Submit Attendance">
    </form>
</body>
</html>