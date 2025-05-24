<?php
include 'auth.php';   // Ensure user is logged in
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = trim($_POST['subject']);
    if (!empty($subject) && !empty($_POST['marks'])) {
        foreach ($_POST['marks'] as $student_id => $mark) {
            $mark = intval($mark);
            // Insert or update marks for this student and subject
            // To avoid duplicates, you can do an UPSERT with ON DUPLICATE KEY UPDATE
            $stmt = $conn->prepare("INSERT INTO marks (student_id, subject, marks) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE marks = ?");
            $stmt->bind_param("isii", $student_id, $subject, $mark, $mark);
            $stmt->execute();
        }
        $success = "Marks saved successfully!";
    } else {
        $error = "Please enter a subject and marks.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Marks</title>
</head>
<body>
<h2>Add Marks for Students</h2>

<?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post">
    Subject: <input type="text" name="subject" required>
    <br><br>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Student</th>
            <th>Marks</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM students");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td><input type='number' name='marks[{$row['id']}]' min='0' max='100' required></td>
                  </tr>";
        }
        ?>
    </table>
    <br>
    <input type="submit" value="Save Marks">
</form>
</body>
</html>
