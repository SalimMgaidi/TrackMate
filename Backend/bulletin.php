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

    // Get student details with more information
    $sql_student = "SELECT u.nom, u.email, u.sexe, e.*, f.nom_filiere 
                   FROM etudiant e 
                   JOIN utilisateur u ON e.user_id = u.id
                   JOIN filieres f ON e.filiere_id = f.id
                   WHERE e.id = $student_id";
    $student_result = $conn->query($sql_student);
    
    if ($student_result->num_rows == 0) {
        die("Student not found");
    }
    
    $student = $student_result->fetch_assoc();

    // Get student grades and subjects
    $sql_grades = "SELECT matieres.nom_matiere, matieres.coefficient, notes.note 
                  FROM notes 
                  JOIN matieres ON notes.matiere_id = matieres.id 
                  WHERE notes.etudiant_id = $student_id";
    $grades_result = $conn->query($sql_grades);

    // Calculate the general average
    $total_weighted_score = 0;
    $total_coefficients = 0;
    $grades = [];
    while ($row = $grades_result->fetch_assoc()) {
        $total_weighted_score += $row['note'] * $row['coefficient'];
        $total_coefficients += $row['coefficient'];
        $grades[] = $row;
    }
    
    $general_average = $total_coefficients > 0 ? $total_weighted_score / $total_coefficients : 0;

    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // School/University Header
    $logo_path = 'imgs/logo.png';
    if (file_exists($logo_path)) {
        try {
            $pdf->Image($logo_path, 10, 10, 30);
        } catch (Exception $e) {
            // If image can't be loaded, just continue without it
        }
    }
    
    $pdf->Cell(0, 10, 'TrackMate University', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Official Academic Transcript', 0, 1, 'C');
    $pdf->Ln(10);

    // Student details section
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Student Information', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    
    // Create a table-like structure for student info
    $info = [
        'Full Name' => $student['nom'],
        'Student ID' => $student['id'],
        'CIN' => $student['cin'],
        'Date of Birth' => $student['date_naissance'],
        'Gender' => $student['sexe'] == 'homme' ? 'Male' : 'Female',
        'Program' => $student['nom_filiere'],
        'Email' => $student['email']
    ];
    
    foreach ($info as $label => $value) {
        $pdf->Cell(50, 10, $label.':', 0);
        $pdf->Cell(0, 10, $value, 0, 1);
    }
    
    $pdf->Ln(15);

    // Academic performance section
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Academic Performance', 0, 1);
    
    // Only show grades table if there are grades
    if (count($grades) > 0) {
        $pdf->SetFont('Arial', 'B', 12);
        
        // Table header
        $pdf->Cell(90, 10, 'Subject', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Coefficient', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Grade', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Weighted Grade', 1, 1, 'C');
        
        // Table content
        $pdf->SetFont('Arial', '', 12);
        foreach ($grades as $row) {
            $weighted_grade = $row['note'] * $row['coefficient'];
            
            $pdf->Cell(90, 10, $row['nom_matiere'], 1);
            $pdf->Cell(30, 10, $row['coefficient'], 1, 0, 'C');
            $pdf->Cell(30, 10, number_format($row['note'], 2), 1, 0, 'C');
            $pdf->Cell(40, 10, number_format($weighted_grade, 2), 1, 1, 'C');
        }
        
        // Footer with general average
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(120, 10, 'General Average:', 1, 0, 'R');
        $pdf->Cell(70, 10, number_format($general_average, 2), 1, 1, 'C');
    } else {
        $pdf->Cell(0, 10, 'No grades available for this student', 0, 1);
    }
    
    // Additional information
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Grading Scale: 0-20 (Passing grade: 10)', 0, 1);
    $pdf->Cell(0, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 1);
    $pdf->Cell(0, 10, 'Official document - TrackMate University', 0, 1);
    
    // Signature line
    $pdf->Ln(15);
    $pdf->Cell(0, 10, '________________________________________', 0, 1, 'R');
    $pdf->Cell(0, 10, 'Academic Director Signature', 0, 1, 'R');

    // Output the PDF
    $pdf->Output('Student_Report_'.$student['id'].'.pdf', 'D');
}

$conn->close();
?>