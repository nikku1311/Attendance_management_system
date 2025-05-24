<?php include 'auth.php'; ?>
<?php
include 'db.php';
include 'send_email.php'; // Make sure this is placed BEFORE using the function

$date = date('Y-m-d');

// Get student emails and names
$studentData = [];
$result = $conn->query("SELECT id, name, email FROM students");
while ($row = $result->fetch_assoc()) {
    $studentData[$row['id']] = ['name' => $row['name'], 'email' => $row['email']];
}

foreach ($_POST['attendance'] as $student_id => $status) {
    $stmt = $conn->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $student_id, $date, $status);
    $stmt->execute();

    // Send email if student is marked absent
    if ($status === 'absent' && isset($studentData[$student_id])) {
        $name = $studentData[$student_id]['name'];
        $email = $studentData[$student_id]['email'];
        sendAbsentEmail($email, $name, $date);
    }
}

header("Location: mark_attendance.php");
exit;
?>
