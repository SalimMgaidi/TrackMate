<?php
session_start();
require('../Backend/connection.php');
//stat
$_SESSION["nbstudents"] = $pdo->query("SELECT COUNT(id) FROM utilisateur WHERE role_id = 0")->fetchColumn();
$_SESSION["nbsubjects"] = $pdo->query("SELECT COUNT(id) FROM matieres")->fetchColumn();
$_SESSION["avggrade"] = $pdo->query("SELECT sum(note)/count(id) from notes")->fetchColumn();
//bar
$_SESSION["nbf2"] = $pdo->query("SELECT count(id) from etudiant where filiere_id=2")->fetchColumn();
$_SESSION["nbf6"] = $pdo->query("SELECT count(id) from etudiant where filiere_id=6")->fetchColumn();
$_SESSION["nbf7"] = $pdo->query("SELECT count(id) from etudiant where filiere_id=7")->fetchColumn();
$_SESSION["nbf3"] = $pdo->query("SELECT count(id) from etudiant where filiere_id=3")->fetchColumn();
$_SESSION["nbf1"] = $pdo->query("SELECT count(id) from etudiant where filiere_id=1")->fetchColumn();
$_SESSION["nbf5"] = $pdo->query("SELECT count(id) from etudiant where filiere_id=5")->fetchColumn();
//line
$_SESSION["max_f2"] = $pdo->query("SELECT MAX(n.note) FROM notes n JOIN etudiant e ON n.etudiant_id = e.id WHERE e.filiere_id = 2")->fetchColumn();
$_SESSION["max_f6"] = $pdo->query("SELECT MAX(n.note) FROM notes n JOIN etudiant e ON n.etudiant_id = e.id WHERE e.filiere_id = 6")->fetchColumn();
$_SESSION["max_f7"] = $pdo->query("SELECT MAX(n.note) FROM notes n JOIN etudiant e ON n.etudiant_id = e.id WHERE e.filiere_id = 7")->fetchColumn();
$_SESSION["max_f3"] = $pdo->query("SELECT MAX(n.note) FROM notes n JOIN etudiant e ON n.etudiant_id = e.id WHERE e.filiere_id = 3")->fetchColumn();
$_SESSION["max_f1"] = $pdo->query("SELECT MAX(n.note) FROM notes n JOIN etudiant e ON n.etudiant_id = e.id WHERE e.filiere_id = 1")->fetchColumn();
$_SESSION["max_f5"] = $pdo->query("SELECT MAX(n.note) FROM notes n JOIN etudiant e ON n.etudiant_id = e.id WHERE e.filiere_id = 5")->fetchColumn();

$gradeToEdit = null;

//-------------------------------------------------------manage students-------------------------------------------------------------
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        // Add new student
        $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, email, mot_de_passe, role_id, sexe) VALUES (?, ?, ?, 0, ?)");
        $stmt->execute([$_POST['nom'], $_POST['email'], password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT), $_POST['sexe']]);
        
        $user_id = $pdo->lastInsertId();
        
        $stmt = $pdo->prepare("INSERT INTO etudiant (user_id, date_naissance, filiere_id, cin) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $_POST['date_naissance'], $_POST['filiere_id'], $_POST['cin']]);
        
        header("Location: adminDashboard.php?success=added");
        exit;
    } elseif (isset($_POST['update'])) {
        // Update student
        $stmt = $pdo->prepare("UPDATE utilisateur SET nom = ?, email = ?, sexe = ? WHERE id = ?");
        $stmt->execute([$_POST['nom'], $_POST['email'], $_POST['sexe'], $_POST['user_id']]);
        
        $stmt = $pdo->prepare("UPDATE etudiant SET date_naissance = ?, filiere_id = ?, cin = ? WHERE user_id = ?");
        $stmt->execute([$_POST['date_naissance'], $_POST['filiere_id'], $_POST['cin'], $_POST['user_id']]);
        
        header("Location: adminDashboard.php#students?success=updated");
        exit;
    }
}

// Handle delete action for students
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    
    // First delete from etudiant table
    $stmt = $pdo->prepare("DELETE FROM etudiant WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    // Then delete from utilisateur table
    $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE id = ?");
    $stmt->execute([$user_id]);
    
    header("Location: adminDashboard.php#students?success=deleted");
    exit;
}

// Get all students with their filiere information
$stmt = $pdo->query("
    SELECT u.id, u.nom, u.email, u.sexe, e.date_naissance, e.cin, f.nom_filiere 
    FROM utilisateur u
    JOIN etudiant e ON u.id = e.user_id
    JOIN filieres f ON e.filiere_id = f.id
    WHERE u.role_id = 0
");
$students = $stmt->fetchAll();

// Get all filieres for dropdown
$filieres = $pdo->query("SELECT id, nom_filiere FROM filieres")->fetchAll();

// Get specific student for editing
$studentToEdit = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("
        SELECT u.id as user_id, u.nom, u.email, u.sexe, e.id as etudiant_id, e.date_naissance, e.filiere_id, e.cin 
        FROM utilisateur u
        JOIN etudiant e ON u.id = e.user_id
        WHERE u.id = ?
    ");
    $stmt->execute([$_GET['edit']]);
    $studentToEdit = $stmt->fetch();
}
//-------------------------------------------------------manage students-------------------------------------------------------------

//-------------------------------------------------------manage subjects/grades-------------------------------------------------------------
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addgrade'])) {
        // Add new grade
        $stmt = $pdo->prepare("INSERT INTO notes (etudiant_id, matiere_id, note) VALUES (?, ?, ?)");
        $stmt->execute([
            $_POST['studentid'],
            $_POST['subjectid'],
            $_POST['grade']
        ]);
        
        header("Location: adminDashboard.php?success=grade_added#grades");
        exit;
    } elseif (isset($_POST['updategrade'])) {
        // Update grade
        $stmt = $pdo->prepare("UPDATE notes SET etudiant_id = ?, matiere_id = ?, note = ? WHERE id = ?");
        $stmt->execute([
            $_POST['studentid'],
            $_POST['subjectid'],
            $_POST['grade'],
            $_POST['gradeid']
        ]);
        header("Location: adminDashboard.php?success=grade_updated#grades");
        exit;
    }
}

// Handle delete action for grades
if (isset($_GET['deletegrade'])) {
    $grade_id = $_GET['deletegrade'];

    $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ?");
    $stmt->execute([$grade_id]);

    header("Location: adminDashboard.php?success=grade_deleted#grades");
    exit;
}

// Get all grades with related information
$stmt = $pdo->query("
    SELECT 
        f.id AS fid,
        n.id as nid,
        f.nom_filiere,
        m.id AS mid,
        m.nom_matiere,
        m.coefficient,
        e.id AS stid,
        u.nom,
        e.cin,
        n.note
    FROM utilisateur u, matieres m, notes n, etudiant e, filieres f
    WHERE n.matiere_id = m.id 
        AND n.etudiant_id = e.id 
        AND e.user_id = u.id 
        AND e.filiere_id = f.id 
        AND u.role_id = 0
");
$grades = $stmt->fetchAll();

// Get all subjects for dropdown
$subjects = $pdo->query("SELECT id, nom_matiere FROM matieres")->fetchAll();

// Get specific grade for editing
if (isset($_GET['editgrade'])) {
    $stmt = $pdo->prepare("
        SELECT n.id as gradeid, n.etudiant_id as studentid, n.matiere_id as subjectid, n.note as grade
        FROM notes n
        WHERE n.id = ?
    ");
    $stmt->execute([$_GET['editgrade']]);
    $gradeToEdit = $stmt->fetch();
}
//-------------------------------------------------------manage subjects/grades-------------------------------------------------------------

//-------------------------------------------------------manage timetable-------------------------------------------------------------
// Handle timetable form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_timetable'])) {
        // Add new timetable entry
        $stmt = $pdo->prepare("INSERT INTO emploi_temps (filiere_id, matiere_id, jour, heure_debut, heure_fin, salle) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['filiere_id'],
            $_POST['matiere_id'],
            $_POST['jour'],
            $_POST['heure_debut'],
            $_POST['heure_fin'],
            $_POST['salle']
        ]);
        
        header("Location: adminDashboard.php?success=timetable_added#tb");
        exit;
    } elseif (isset($_POST['update_timetable'])) {
        // Update timetable entry
        $stmt = $pdo->prepare("UPDATE emploi_temps SET filiere_id = ?, matiere_id = ?, jour = ?, heure_debut = ?, heure_fin = ?, salle = ? WHERE id = ?");
        $stmt->execute([
            $_POST['filiere_id'],
            $_POST['matiere_id'],
            $_POST['jour'],
            $_POST['heure_debut'],
            $_POST['heure_fin'],
            $_POST['salle'],
            $_POST['timetable_id']
        ]);
        
        header("Location: adminDashboard.php?success=timetable_updated#tb");
        exit;
    }
}

// Handle delete action for timetable
if (isset($_GET['deletetimetable'])) {
    $timetable_id = $_GET['deletetimetable'];

    $stmt = $pdo->prepare("DELETE FROM emploi_temps WHERE id = ?");
    $stmt->execute([$timetable_id]);

    header("Location: adminDashboard.php?success=timetable_deleted#tb");
    exit;
}

// Get timetable data
$stmt = $pdo->query("
    SELECT et.id, f.nom_filiere AS filiere, m.nom_matiere AS matiere, 
    et.jour, et.heure_debut, et.heure_fin, et.salle, et.filiere_id, et.matiere_id
    FROM emploi_temps et
    JOIN filieres f ON et.filiere_id = f.id
    JOIN matieres m ON et.matiere_id = m.id
    ORDER BY et.jour, et.heure_debut
");
$emploi_temps = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get specific timetable entry for editing
$timetableToEdit = null;
if (isset($_GET['edittimetable'])) {
    $stmt = $pdo->prepare("
        SELECT et.id as timetable_id, et.filiere_id, et.matiere_id, et.jour, 
        et.heure_debut, et.heure_fin, et.salle
        FROM emploi_temps et
        WHERE et.id = ?
    ");
    $stmt->execute([$_GET['edittimetable']]);
    $timetableToEdit = $stmt->fetch();
}
//-------------------------------------------------------manage timetable-------------------------------------------------------------

//-------------------------------------------------------logout-------------------------------------------------------------
if (isset($_GET["logout"]) && $_GET["logout"] == "true") {
    session_start();
    session_destroy(); 
    header("Location: index.php"); 
    exit(); 
}
//-------------------------------------------------------logout-------------------------------------------------------------
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="imgs/logo-removebg-preview.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="flex bg-[#FCF4F0] dark:bg-gray-900">
    <!-- Sidebar -->
    <aside class="w-64 bg-white text-black min-h-screen p-5 shadow-lg fixed top-0 left-0">
        <div class="flex items-center gap-3 mb-5">
            <img src="imgs/animated-profile-icon.png" alt="Profile" class="w-12 h-12 rounded-full hover:scale-110 duration-500">
            <div>
                <h3 class="text-lg font-bold"><?php echo $_SESSION["user"]["nom"] ?></h3>
                <p class="text-[12px]"><?php echo $_SESSION["user"]["email"] ?></p>
            </div>
        </div>
        <div class="mt-5">
            <nav>
                <ul>
                    <div class="flex gap-2 ml-3 mb-9">
                        <img src="imgs/logo.png" class="w-6" alt="">
                        <h3 class="font-[poppins]"><span class="text-[#F0A07D] font-semibold">T</span>rack<span class="text-[#F0A07D] font-semibold">M</span>ate</h3>
                    </div>
                    <li class="mb-2"><a href="#stat" class="block p-2 hover:bg-gray-200 rounded hover:scale-105 transition-transform duration-800 hover:text-black">Statistics</a></li>
                    <li class="mb-2"><a href="#students" class="block p-2 hover:bg-gray-200 rounded hover:scale-105 transition-transform duration-800 hover:text-black">Manage Students</a></li>
                    <li class="mb-2"><a href="#grades" class="block p-2 hover:bg-gray-200 rounded hover:scale-105 transition-transform duration-800 hover:text-black">Manage Subjects/grades</a></li>
                    <li class="mb-2"><a href="#tb" class="block p-2 hover:bg-gray-200 rounded hover:scale-105 transition-transform duration-800 hover:text-black">Time Table</a></li>
                    <li class="mb-2"><a href="#bulletins" class="block p-2 hover:bg-gray-200 rounded hover:scale-105 transition-transform duration-800 hover:text-black">Manage Bulletins</a></li>
                    <li class="mb-2"><a href="#settings" class="block p-2 hover:bg-gray-200 rounded hover:scale-105 transition-transform duration-800 hover:text-black"> <button id="settings-btn">Settings</button></a></li>
                </ul>
            </nav>
        </div>

        <!-- Settings Popup -->
        <div id="settings-popup" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-[800px] max-h-[90vh] overflow-y-auto">
                <!-- Initial Settings -->
                <div id="popup-content">
                    <h3 class="text-2xl font-bold mb-6 text-center">Settings</h3>
                    <button id="profile-btn" class="bg-[#F0A07D] w-full py-3 rounded-lg mb-4 hover:bg-[#d88b6c]">Profile</button>
                    <button id="theme-btn" class="bg-[#F0A07D] w-full py-3 rounded-lg hover:bg-[#d88b6c]">Change Theme</button>
                </div>

                <!-- Profile Content -->
                <div id="profile-content" class="hidden">
                    <h3 class="text-2xl font-semibold mb-4 text-center font-[poppins]">Profile Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 p-5 gap-10">
                        <!-- Profile Picture and Button -->
                        <div class="flex flex-col items-center space-y-4">
                            <img src="imgs/animated-profile-icon.png" alt="Profile" class="rounded-full scale-75 m-auto p-5">
                            <button class="p-2.5 bg-gray-200 rounded-md">Update Profile Image</button>
                            <input type="file" class="p-2.5 bg-white ml-[70px] text-[12px] rounded-md">
                        </div>
                        <!-- Profile Form -->
                        <form id="profile-form" class="flex flex-col space-y-3 w-full max-w-xs mt-4 md:mt-16 mx-auto">
                            <input type="text" placeholder="Update Name" class="w-full p-3 border rounded-md">
                            <input type="email" placeholder="Update Email" class="w-full p-3 border rounded-md">
                            <input type="password" placeholder="Update Password" class="w-full p-3 border rounded-md">
                            <button type="submit" class="bg-[#F0A07D] w-full py-3 rounded-lg hover:bg-[#d88b6c]">Save</button>
                        </form>
                    </div>
                    <button id="back-from-profile" class="text-[#F0A07D] mt-4 text"><i class="fa-solid fa-arrow-left" style="color: #e39a1c;"><-</i></button>
                </div>

                <!-- Theme Content -->
                <div id="theme-content" class="hidden">
                    <button id="back-from-theme" class="text-blue-600 mt-4 underline text-[20px]"> </button>
                    <h3 class="text-2xl font-bold mb-4 text-center">Change Theme</h3>
                    <button id="light-theme" class="bg-[#F0A07D] w-full py-3 rounded-lg mb-4 hover:bg-gray-200">Light Theme</button>
                    <button id="dark-theme" class="bg-[#F0A07D] w-full py-3 rounded-lg hover:bg-black hover:text-white">Dark Theme</button>
                </div>

                <!-- Close Button -->
                <button id="close-popup" class="mt-6 bg-red-400 text-white w-full py-2 rounded-lg hover:bg-red-500">Close</button>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main id="stat" class="flex-1 p-10 bg-[#FCF4F0] pl-10 ml-64">
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Dashboard</h1>
            <div class="flex gap-4">
                <a href="adminDashboard.php?logout=true" class="bg-[#F0A07D] text-white px-4 py-2 rounded-3xl hover:bg-[#d88b6c]">Logout</a>
            </div>
        </header>

        <!-- Statistics Section -->
        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-5">Statistics</h2>
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="bg-white p-5 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold">Total Students</h3>
                    <p class="text-3xl font-semibold"><?php echo $_SESSION["nbstudents"] ?></p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold">Total Subjects</h3>
                    <p class="text-3xl font-semibold"><?php echo $_SESSION["nbsubjects"]?></p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold">Average Grade</h3>
                    <p class="text-3xl font-semibold"><?php echo round($_SESSION["avggrade"],2)?></p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 pb-10">
                <div class="bg-white p-5 rounded-lg shadow-lg h-[600px]">
                    <h3 class="text-xl font-bold">Students Growth</h3>
                    <canvas id="linechart" width="300" height="200"></canvas>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold">Grade Distribution</h3>
                    <canvas id="barchart" width="300" height="150"></canvas>
                </div>
            </div>
        </section>

        <!-- Success Messages -->
        <?php if (isset($_GET['success'])): ?>
            <div class="bg-[#F0A07D] text-white p-3 rounded mb-4">
                <?php 
                switch($_GET['success']) {
                    case 'added': echo "Student added successfully!"; break;
                    case 'updated': echo "Student updated successfully!"; break;
                    case 'deleted': echo "Student deleted successfully!"; break;
                    case 'grade_added': echo "Grade added successfully!"; break;
                    case 'grade_updated': echo "Grade updated successfully!"; break;
                    case 'grade_deleted': echo "Grade deleted successfully!"; break;
                    case 'timetable_added': echo "Timetable entry added successfully!"; break;
                    case 'timetable_updated': echo "Timetable entry updated successfully!"; break;
                    case 'timetable_deleted': echo "Timetable entry deleted successfully!"; break;
                }
                ?>
            </div>
        <?php endif; ?>
        
        <!-- Students Section -->
        <section id="students">
            <h1 class="text-3xl p-5 text-[#F0A07D] font-[poppins] font-bold">Manage students</h1>
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-2xl font-bold text-[#F0A07D] mb-6">
                    <?= $studentToEdit ? 'Edit Student' : 'Add New Student' ?>
                </h2>
                
                <form method="POST" class="space-y-4">
                    <?php if ($studentToEdit): ?>
                        <input type="hidden" name="user_id" value="<?= $studentToEdit['user_id'] ?>">
                    <?php endif; ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="nom" class="block text-sm font-medium text-gray-700">Full Name:</label>
                            <input type="text" id="nom" name="nom" required 
                                   value="<?= $studentToEdit ? $studentToEdit['nom'] : '' ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                            <input type="email" id="email" name="email" required 
                                   value="<?= $studentToEdit ? $studentToEdit['email'] : '' ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                        </div>
                        
                        <?php if (!$studentToEdit): ?>
                        <div class="space-y-2">
                            <label for="mot_de_passe" class="block text-sm font-medium text-gray-700">Password:</label>
                            <input type="password" id="mot_de_passe" name="mot_de_passe" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                        </div>
                        <?php endif; ?>
                        
                        <div class="space-y-2">
                            <label for="sexe" class="block text-sm font-medium text-gray-700">Gender:</label>
                            <select id="sexe" name="sexe" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                                <option value="homme" <?= $studentToEdit && $studentToEdit['sexe'] == 'homme' ? 'selected' : '' ?>>Male</option>
                                <option value="femme" <?= $studentToEdit && $studentToEdit['sexe'] == 'femme' ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="date_naissance" class="block text-sm font-medium text-gray-700">Birth Date:</label>
                            <input type="date" id="date_naissance" name="date_naissance" required 
                                   value="<?= $studentToEdit ? $studentToEdit['date_naissance'] : '' ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="filiere_id" class="block text-sm font-medium text-gray-700">Program:</label>
                            <select id="filiere_id" name="filiere_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                                <?php foreach ($filieres as $filiere): ?>
                                    <option value="<?= $filiere['id'] ?>" 
                                        <?= $studentToEdit && $studentToEdit['filiere_id'] == $filiere['id'] ? 'selected' : '' ?>>
                                        <?= $filiere['nom_filiere'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="cin" class="block text-sm font-medium text-gray-700">CIN:</label>
                            <input type="text" id="cin" name="cin" required 
                                   value="<?= $studentToEdit ? $studentToEdit['cin'] : '' ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4 pt-4">
                        <?php if ($studentToEdit): ?>
                            <button type="submit" name="update" 
                                    class="px-4 py-2 bg-[#F0A07D] text-white rounded-md hover:bg-[#e0906d] focus:outline-none focus:ring-2 focus:ring-[#F0A07D] focus:ring-offset-2">
                                Update Student
                            </button>
                            <a href="adminDashboard.php#students" 
                               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                                Cancel
                            </a>
                        <?php else: ?>
                            <button type="submit" name="add" 
                                    class="px-4 py-2 bg-[#F0A07D] text-white rounded-md hover:bg-[#e0906d] focus:outline-none focus:ring-2 focus:ring-[#F0A07D] focus:ring-offset-2">
                                Add Student
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div id="sl" class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-[#F0A07D] mb-6">Student List</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Birth Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CIN</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($students as $student): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $student['id'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($student['nom']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($student['email']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $student['sexe'] == 'homme' ? 'Male' : 'Female' ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $student['date_naissance'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $student['cin'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($student['nom_filiere']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="adminDashboard.php?edit=<?= $student['id'] ?>#students" class="text-[#F0A07D] hover:text-[#e0906d] mr-3">Edit</a>
                                        <a href="adminDashboard.php?delete=<?= $student['id'] ?>#students" onclick="return confirm('Are you sure you want to delete this student?')" class="text-red-600 hover:text-red-900">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Grades Section -->
        <section id="grades">
            <h1 class="text-3xl p-5 text-[#F0A07D] font-[poppins] font-bold">Manage grades and subjects</h1>
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-2xl font-bold text-[#F0A07D] mb-6">
                    <?= $gradeToEdit ? 'Edit Grade' : 'Add New Grade' ?>
                </h2>

                <form method="POST" class="space-y-4">
                    <?php if ($gradeToEdit): ?>
                        <input type="hidden" name="gradeid" value="<?= $gradeToEdit['gradeid'] ?>">
                    <?php endif; ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="studentid" class="block text-sm font-medium text-gray-700">Student ID</label>
                            <input type="number" id="studentid" name="studentid" required
                                   value="<?= $gradeToEdit ? $gradeToEdit['studentid'] : '' ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                        </div>

                        <div class="space-y-2">
                            <label for="subjectid" class="block text-sm font-medium text-gray-700">Subject ID</label>
                            <input type="number" id="subjectid" name="subjectid" required
                                   value="<?= $gradeToEdit ? $gradeToEdit['subjectid'] : '' ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                        </div>

                        <div class="space-y-2">
                            <label for="grade" class="block text-sm font-medium text-gray-700">Grade</label>
                            <input type="number" id="grade" name="grade" step="0.01" min="0" max="20" required
                                   value="<?= $gradeToEdit ? $gradeToEdit['grade'] : '' ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 pt-4">
                        <?php if ($gradeToEdit): ?>
                            <button type="submit" name="updategrade"
                                    class="px-4 py-2 bg-[#F0A07D] text-white rounded-md hover:bg-[#e0906d]">
                                Update Grade
                            </button>
                            <a href="adminDashboard.php#grades"
                               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                                Cancel
                            </a>
                        <?php else: ?>
                            <button type="submit" name="addgrade"
                                    class="px-4 py-2 bg-[#F0A07D] text-white rounded-md hover:bg-[#e0906d]">
                                Add Grade
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-[#F0A07D] mb-6">Grades List</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coefficient</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student CIN</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($grades as $grade): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $grade['fid'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($grade['nom_filiere']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $grade['mid'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $grade['nom_matiere'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $grade['coefficient'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $grade['stid'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $grade['nom'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $grade['cin'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $grade['note'] ?></td>
                                   
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="adminDashboard.php?editgrade=<?= $grade['nid'] ?>#grades" class="text-[#F0A07D] hover:text-[#e0906d] mr-3">Edit</a>
                                        <a href="adminDashboard.php?deletegrade=<?= $grade['nid'] ?>#grades" onclick="return confirm('Are you sure you want to delete this grade?')" class="text-red-600 hover:text-red-900">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Timetable Section -->
        <section id="tb">
            <h1 class="text-3xl p-5 text-[#F0A07D] font-[poppins] font-bold">Manage Timetable</h1>
            
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-2xl font-bold text-[#F0A07D] mb-6">
                    <?= $timetableToEdit ? 'Edit Timetable Entry' : 'Add New Timetable Entry' ?>
                </h2>
                
                <form method="POST" class="space-y-4">
                    <?php if ($timetableToEdit): ?>
                        <input type="hidden" name="timetable_id" value="<?= $timetableToEdit['timetable_id'] ?>">
                    <?php endif; ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="filiere_id" class="block text-sm font-medium text-gray-700">Program:</label>
                            <select id="filiere_id" name="filiere_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                                <?php foreach ($filieres as $filiere): ?>
                                    <option value="<?= $filiere['id'] ?>" 
                                        <?= $timetableToEdit && $timetableToEdit['filiere_id'] == $filiere['id'] ? 'selected' : '' ?>>
                                        <?= $filiere['nom_filiere'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="matiere_id" class="block text-sm font-medium text-gray-700">Subject:</label>
                            <select id="matiere_id" name="matiere_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                                <?php foreach ($subjects as $subject): ?>
                                    <option value="<?= $subject['id'] ?>" 
                                        <?= $timetableToEdit && $timetableToEdit['matiere_id'] == $subject['id'] ? 'selected' : '' ?>>
                                        <?= $subject['nom_matiere'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="jour" class="block text-sm font-medium text-gray-700">Day:</label>
                            <select id="jour" name="jour" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                                <option value="Monday" <?= $timetableToEdit && $timetableToEdit['jour'] == 'Monday' ? 'selected' : '' ?>>Monday</option>
                                <option value="Tuesday" <?= $timetableToEdit && $timetableToEdit['jour'] == 'Tuesday' ? 'selected' : '' ?>>Tuesday</option>
                                <option value="Wednesday" <?= $timetableToEdit && $timetableToEdit['jour'] == 'Wednesday' ? 'selected' : '' ?>>Wednesday</option>
                                <option value="Thursday" <?= $timetableToEdit && $timetableToEdit['jour'] == 'Thursday' ? 'selected' : '' ?>>Thursday</option>
                                <option value="Friday" <?= $timetableToEdit && $timetableToEdit['jour'] == 'Friday' ? 'selected' : '' ?>>Friday</option>
                                <option value="Saturday" <?= $timetableToEdit && $timetableToEdit['jour'] == 'Saturday' ? 'selected' : '' ?>>Saturday</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="heure_debut" class="block text-sm font-medium text-gray-700">Start Time:</label>
                            <input type="time" id="heure_debut" name="heure_debut" required 
                                   value="<?= $timetableToEdit ? $timetableToEdit['heure_debut'] : '' ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="heure_fin" class="block text-sm font-medium text-gray-700">End Time:</label>
                            <input type="time" id="heure_fin" name="heure_fin" required 
                                   value="<?= $timetableToEdit ? $timetableToEdit['heure_fin'] : '' ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="salle" class="block text-sm font-medium text-gray-700">Room:</label>
                            <input type="text" id="salle" name="salle" required 
                                   value="<?= $timetableToEdit ? $timetableToEdit['salle'] : '' ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4 pt-4">
                        <?php if ($timetableToEdit): ?>
                            <button type="submit" name="update_timetable" 
                                    class="px-4 py-2 bg-[#F0A07D] text-white rounded-md hover:bg-[#e0906d] focus:outline-none focus:ring-2 focus:ring-[#F0A07D] focus:ring-offset-2">
                                Update Timetable
                            </button>
                            <a href="adminDashboard.php#tb" 
                               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                                Cancel
                            </a>
                        <?php else: ?>
                            <button type="submit" name="add_timetable" 
                                    class="px-4 py-2 bg-[#F0A07D] text-white rounded-md hover:bg-[#e0906d] focus:outline-none focus:ring-2 focus:ring-[#F0A07D] focus:ring-offset-2">
                                Add Timetable
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-[#F0A07D] mb-6">Timetable List</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#F0A07D]">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Program</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Day</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Time</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Subject</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Room</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($emploi_temps as $cours): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($cours['filiere']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($cours['jour']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= date('H:i', strtotime($cours['heure_debut'])) ?> - <?= date('H:i', strtotime($cours['heure_fin'])) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($cours['matiere']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($cours['salle']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="adminDashboard.php?edittimetable=<?= $cours['id'] ?>#tb" class="text-[#F0A07D] hover:text-[#e0906d] mr-3">Edit</a>
                                    <a href="adminDashboard.php?deletetimetable=<?= $cours['id'] ?>#tb" onclick="return confirm('Are you sure you want to delete this timetable entry?')" class="text-red-600 hover:text-red-900">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <section id="bulletins" class="mb-10">
    <h1 class="text-3xl p-5 text-[#F0A07D] font-[poppins] font-bold">Manage Bulletins</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-bold text-[#F0A07D] mb-6">Generate Student Report</h2>
        
        <form method="POST" action="../Backend/bulletin.php" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID:</label>
                    <input type="number" id="student_id" name="student_id" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                </div>
                
                
            </div>
            
            <div class="flex items-center space-x-4 pt-4">
                <button type="submit" 
                        class="px-4 py-2 bg-[#F0A07D] text-white rounded-md hover:bg-[#e0906d] focus:outline-none focus:ring-2 focus:ring-[#F0A07D] focus:ring-offset-2">
                    Generate Bulletin
                </button>
                
                <button type="button" onclick="showStudentList()"
                        class="px-4 py-2 border border-[#F0A07D] text-[#F0A07D] rounded-md hover:bg-[#F0A07D] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#F0A07D]">
                  <a href="adminDashboard.php#sl">View Student List</a>  
                </button>
            </div>
        </form>
    </div>

    </main>

    <script>
        // Settings Popup Logic
        const popup = document.getElementById('settings-popup');
        const settingsBtn = document.getElementById('settings-btn');
        const closeBtn = document.getElementById('close-popup');

        const mainContent = document.getElementById('popup-content');
        const profileContent = document.getElementById('profile-content');
        const themeContent = document.getElementById('theme-content');

        const profileBtn = document.getElementById('profile-btn');
        const themeBtn = document.getElementById('theme-btn');
        const backProfile = document.getElementById('back-from-profile');
        const backTheme = document.getElementById('back-from-theme');

        // Show popup
        settingsBtn.addEventListener('click', () => {
            popup.classList.remove('hidden');
            mainContent.classList.remove('hidden');
            profileContent.classList.add('hidden');
            themeContent.classList.add('hidden');
        });

        // Close popup
        closeBtn.addEventListener('click', () => {
            popup.classList.add('hidden');
        });

        // Show profile settings
        profileBtn.addEventListener('click', () => {
            mainContent.classList.add('hidden');
            profileContent.classList.remove('hidden');
        });

        // Show theme settings
        themeBtn.addEventListener('click', () => {
            mainContent.classList.add('hidden');
            themeContent.classList.remove('hidden');
        });

        // Back to main from profile
        backProfile.addEventListener('click', () => {
            profileContent.classList.add('hidden');
            mainContent.classList.remove('hidden');
        });

        // Back to main from theme
        backTheme.addEventListener('click', () => {
            themeContent.classList.add('hidden');
            mainContent.classList.remove('hidden');
        });

        // Chart Initialization
        window.onload = function() {
            // Line Chart
            const ctx1 = document.getElementById('linechart').getContext('2d');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: ['Computer Science', 'Cyber Security', 'Economics', 'Finance', 'Management', 'Marketing'],
                    datasets: [{
                        label: 'Students by Program',
                        data: [<?php echo $_SESSION["max_f2"]?>, <?php echo $_SESSION["max_f6"]?>, <?php echo $_SESSION["max_f7"]?>, 
                               <?php echo $_SESSION["max_f3"]?>, <?php echo $_SESSION["max_f1"]?>, <?php echo $_SESSION["max_f5"]?>],
                        borderColor: 'rgba(240, 160, 125, 1)',
                        backgroundColor: 'rgba(240, 160, 125, 0.2)',
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.raw + ' students';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Bar Chart
            const ctx2 = document.getElementById('barchart').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: ['Computer Science', 'Cyber Security', 'Economics', 'Finance', 'Management', 'Marketing'],
                    datasets: [{
                        label: 'Students by Program',
                        data: [<?php echo $_SESSION["nbf2"]?>, <?php echo $_SESSION["nbf6"]?>, <?php echo $_SESSION["nbf7"]?>, 
                               <?php echo $_SESSION["nbf3"]?>, <?php echo $_SESSION["nbf1"]?>, <?php echo $_SESSION["nbf5"]?>],
                        backgroundColor: 'rgba(240, 160, 125, 0.7)',
                        borderColor: 'rgba(240, 160, 125, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.raw + ' students';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>