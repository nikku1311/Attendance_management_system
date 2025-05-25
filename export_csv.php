<?php
$conn = new mysqli("localhost", "root", "your sql password", "attendance_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get distinct subjects for dynamic headers
$subjects = [];
$subject_result = $conn->query("SELECT DISTINCT subject FROM marks");
while ($row = $subject_result->fetch_assoc()) {
    $subjects[] = $row['subject'];
}

// CSV headers
$headers = array_merge(
    ['Student ID', 'Name', 'Total Days', 'Present Days', 'Absent Days'],
    $subjects
);

// Output headers
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="Attendance_Marks_Report.csv"');
$output = fopen('php://output', 'w');

fputcsv($output, $headers);

// Fetch all students
$students = $conn->query("SELECT id, name FROM students");

while ($student = $students->fetch_assoc()) {
    $id = $student['id'];
    $name = $student['name'];

    // Count attendance
    $count = $conn->query("
        SELECT 
            COUNT(*) AS total,
            SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) AS present_days,
            SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) AS absent_days
        FROM attendance
        WHERE student_id = $id
    ")->fetch_assoc();

    $total = $count['total'] ?? 0;
    $present = $count['present_days'] ?? 0;
    $absent = $count['absent_days'] ?? 0;

    // Get marks by subject
    $marks = array_fill_keys($subjects, '');
    $marks_result = $conn->query("SELECT subject, marks FROM marks WHERE student_id = $id");
    while ($mark = $marks_result->fetch_assoc()) {
        $marks[$mark['subject']] = $mark['marks'];
    }

    // Output row
    $row = array_merge([$id, $name, $total, $present, $absent], $marks);
    fputcsv($output, $row);
}

fclose($output);
exit;
?>
