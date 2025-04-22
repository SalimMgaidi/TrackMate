

<?php
require('./fpdf.php'); // Include FPDF library

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trackmate";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];

    // Get student details
    $sql_student = "SELECT * FROM etudiant WHERE id = $student_id";
    $student_result = $conn->query($sql_student);
    $student = $student_result->fetch_assoc();

    // Get student grades and subjects
    $sql_grades = "SELECT matieres.nom_matiere, matieres.coefficient, notes.note FROM notes 
                   JOIN matieres ON notes.matiere_id = matieres.id 
                   WHERE notes.etudiant_id = $student_id";
    $grades_result = $conn->query($sql_grades);

    // Calculate the general average
    $total_weighted_score = 0;
    $total_coefficients = 0;
    while ($row = $grades_result->fetch_assoc()) {
        $total_weighted_score += $row['note'] * $row['coefficient'];
        $total_coefficients += $row['coefficient'];
    }
    $general_average = $total_weighted_score / $total_coefficients;

    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Title
    $pdf->Cell(200, 10, 'Student Report Card', 0, 1, 'C');

    // Student details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(200, 10, 'Student Name: ' . $student['id'], 0, 1);
    
    $pdf->Cell(200, 10, 'Date of Birth: ' . $student['date_naissance'], 0, 1);

    // Grades table header
    $pdf->Cell(80, 10, 'Subject', 1);
    $pdf->Cell(40, 10, 'Coefficient', 1);
    $pdf->Cell(40, 10, 'Grade', 1);
    $pdf->Ln();

    // Add subjects and grades
    $grades_result->data_seek(0); // Reset result pointer
    while ($row = $grades_result->fetch_assoc()) {
        $pdf->Cell(80, 10, $row['nom_matiere'], 1);
        $pdf->Cell(40, 10, $row['coefficient'], 1);
        $pdf->Cell(40, 10, $row['note'], 1);
        $pdf->Ln();
    }

    // General average
    $pdf->Cell(80, 10, 'General Average:', 1);
    $pdf->Cell(40, 10, '', 0);
    $pdf->Cell(40, 10, number_format($general_average, 2), 1);
    $pdf->Ln();

    // Output the PDF
    $pdf->Output();
}

$conn->close();
?>









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form method="POST" action="bulltin.php">
  <label for="student_id">Enter Student ID:</label>
  <input type="number" id="student_id" name="student_id" required>
  <button type="submit">Generate PDF</button>
</form>
    
</body>
</html>