<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

require_once('fpdf.php');
require_once '../Backend/connection.php';

if (!isset($_SESSION['student_info']['id'])) {
    exit('Student information not found.');
}

$etudiant_id = $_SESSION['student_info']['id'];
$stmt = $pdo->prepare("SELECT n.note, m.nom_matiere, m.credit, b.semestre 
    FROM notes n
    JOIN matieres m ON n.matiere_id = m.id
    JOIN bulletins b ON n.etudiant_id = b.etudiant_id
    WHERE n.etudiant_id = ?
    ORDER BY b.semestre");
$stmt->execute([$etudiant_id]);
$grades = $stmt->fetchAll();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Academic Grades Report', 0, 1, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 10, 'Subject', 1);
$pdf->Cell(30, 10, 'Grade', 1);
$pdf->Cell(30, 10, 'Credits', 1);
$pdf->Cell(40, 10, 'Semester', 1);
$pdf->Ln();
$pdf->SetFont('Arial', '', 10);
foreach ($grades as $row) {
    $pdf->Cell(90, 10, $row['nom_matiere'], 1);
    $pdf->Cell(30, 10, $row['note'] . '/20', 1);
    $pdf->Cell(30, 10, $row['credit'], 1);
    $pdf->Cell(40, 10, $row['semestre'], 1);
    $pdf->Ln();
}

$pdf->Output('D', 'grades_report.pdf');
?>