<?php include 'auth.php'; ?>
<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Attendance Report</h2>
    <table>
        <tr><th>Date</th><th>Student</th><th>Status</th></tr>
        <?php
        $result = $conn->query("SELECT a.date, s.name, a.status FROM attendance a JOIN students s ON a.student_id = s.id ORDER BY a.date DESC");
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['date']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['status']}</td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>