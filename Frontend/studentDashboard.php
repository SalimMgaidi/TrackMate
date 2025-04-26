<?php
    session_start();
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
      $_SESSION = array();
      session_destroy();
      header("Location: index.php");
      exit();
  }
  if (!isset($_SESSION['user'])) {
      header("Location: login.php");
      exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Dashboard</title>
  <link rel="icon" href="imgs/logo-removebg-preview.png">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    .grade-A { color: #4CAF50; font-weight: bold; }
    .grade-B { color: #8BC34A; font-weight: bold; }
    .grade-C { color: #FFC107; font-weight: bold; }
    .grade-D { color: #FF9800; font-weight: bold; }
    .grade-F { color: #F44336; font-weight: bold; }
    .empty-slot {
      background-color: #f5f5f5;
      color: #999;
      font-style: italic;
    }
  </style>
</head>
<body class="flex bg-[#f9f7f4] text-black">
  <aside class="w-64 bg-white min-h-screen p-6 shadow-xl">
    <div class="flex items-center gap-3 mb-8">
      <img id="profileImage" src="imgs/animated-profile-icon.png" alt="Profile" class="w-12 h-12 rounded-full hover:scale-110 duration-300 object-cover">
      <div>
        <h3 class="text-base font-semibold"><?php echo htmlspecialchars($_SESSION['user']['nom']);?></h3>
        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
      </div>
    </div>
    <input type="file" accept="image/*" class="mb-5 w-full text-sm" onchange="uploadImage(event)">
    <nav>
      <div class="flex gap-2 items-center mb-8">
        <img src="imgs/logo.png" class="w-6" alt="">
        <h3 class="text-lg font-semibold text-gray-700"><span class="text-[#F0A07D]">T</span>rack<span class="text-[#F0A07D]">M</span>ate</h3>
      </div>
      <ul class="space-y-2">
        <li><a href="#profile" class="block px-3 py-2 rounded-lg hover:bg-gray-100 transition">Profile</a></li>
        <li><a href="#statistics" class="block px-3 py-2 rounded-lg hover:bg-gray-100 transition">Statistics</a></li>
        <li><a href="#timetable" class="block px-3 py-2 rounded-lg hover:bg-gray-100 transition">Timetable</a></li>
        <li><a href="#grades" class="block px-3 py-2 rounded-lg hover:bg-gray-100 transition">Grades</a></li>
        <li><a href="#settings" class="block px-3 py-2 rounded-lg hover:bg-gray-100 transition">Settings</a></li>
      </ul>
    </nav>
  </aside>

  <main class="flex-1 p-10 space-y-12">
    <header class="flex justify-between items-center">
      <h1 class="text-3xl font-bold">Student Dashboard</h1>
      <button class="bg-[#F0A07D] text-white px-5 py-2 rounded-full hover:bg-[#d88b6c] transition"><a href="studentDashboard.php?action=logout">Logout</a></button>
    </header>

    <section id="profile">
      <h2 class="text-2xl font-bold mb-4">Student Profile</h2>
      <div class="bg-white p-6 rounded-xl shadow-md flex gap-6">
        <img id="profilePreview" src="imgs/animated-profile-icon.png" alt="Profile" class="w-28 h-28 rounded-full object-cover">
        <div class="grid grid-cols-2 gap-4 w-full">
          <div><h3 class="font-medium">Full Name</h3><p class="text-gray-600"><?php echo htmlspecialchars($_SESSION['user']['nom'] ?? '-'); ?></p></div>
          <div><h3 class="font-medium">Student ID</h3><p class="text-gray-600"><?php echo htmlspecialchars($_SESSION['student_info']['cin'] ?? '-'); ?></p></div>
          <div><h3 class="font-medium">Email</h3><p class="text-gray-600"><?php echo htmlspecialchars($_SESSION['user']['email'] ?? '-'); ?></p></div>
          <div><h3 class="font-medium">Class</h3><p class="text-gray-600"><?php echo htmlspecialchars($_SESSION['student_info']['nom_filiere'] ?? '-'); ?></p></div>
          <div><h3 class="font-medium">Enrollment Date</h3><p class="text-gray-600"><?php 
            if (isset($_SESSION['user']['created_at'])) {
                echo htmlspecialchars(date('Y-m-d', strtotime($_SESSION['user']['created_at'])));
            } else {
                echo '-';
            }
            ?></p></div>
        </div>
      </div>
    </section>
    <section id="statistics">
      <h2 class="text-2xl font-bold mb-4">Statistics</h2>
      <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-md">
          <h3 class="text-lg font-semibold mb-3">Grade Growth</h3>
          <canvas id="gradeChart" class="w-full h-48"></canvas>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md">
          <h3 class="text-lg font-semibold mb-3">Attendance Trend</h3>
          <canvas id="attendanceChart" class="w-full h-48"></canvas>
        </div>
      </div>
    </section>

    <section id="timetable">
  <h2 class="text-2xl font-bold mb-4">Weekly Timetable</h2>
  <div class="bg-white p-6 rounded-xl shadow-md overflow-x-auto">
    <table class="w-full text-sm border-collapse">
      <thead class="bg-gray-100 text-left">
        <tr>
          <th class="p-3 border">Time</th>
          <th class="p-3 border">Monday</th>
          <th class="p-3 border">Tuesday</th>
          <th class="p-3 border">Wednesday</th>
          <th class="p-3 border">Thursday</th>
          <th class="p-3 border">Friday</th>
        </tr>
      </thead>
      <tbody>
      <?php
        require_once '../Backend/connection.php';
        $filiere_id = $_SESSION['student_info']['filiere_id'] ?? null;
        
        if($filiere_id) {
            $stmt = $pdo->prepare("SELECT jour, heure_debut, heure_fin, salle, m.nom_matiere 
                FROM emploi_temps et
                JOIN matieres m ON et.matiere_id = m.id
                WHERE filiere_id = ?
                ORDER BY heure_debut
            ");
            $stmt->execute([$filiere_id]);
            $timetableData = $stmt->fetchAll(PDO::FETCH_GROUP);
            
            $timeSlots = ['08:00:00' => '08:00 - 09:00',
                '09:00:00' => '09:00 - 10:00',
                '10:00:00' => '10:00 - 11:00',
                '11:00:00' => '11:00 - 12:00',
                '12:00:00' => '12:00 - 13:00',
                '13:00:00' => '13:00 - 14:00',
                '14:00:00' => '14:00 - 15:00',
                '15:00:00' => '15:00 - 16:00'
            ];

            foreach ($timeSlots as $startTime => $timeLabel) {
                echo "<tr>";
                echo "<td class='p-3 border'>$timeLabel</td>";
                
                foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'] as $day) {
                    $cellContent = '-';
                    if(isset($timetableData[$day])) {
                        foreach($timetableData[$day] as $course) {
                            $courseStart = date('H:i:s', strtotime($course['heure_debut']));
                            $courseEnd = date('H:i:s', strtotime($course['heure_fin']));
                            
                            if($courseStart === $startTime) {
                                $cellContent = "
                                    <div class='font-medium'>".htmlspecialchars($course['nom_matiere'])."</div>
                                    <div class='text-sm text-gray-500'>".htmlspecialchars($course['salle'])."</div>
                                    <div class='text-sm'>".date('H:i', strtotime($courseStart))." - ".date('H:i', strtotime($courseEnd))."</div>
                                ";
                                break;
                            }
                        }
                    }
                    echo "<td class='p-3 border'>".($cellContent === '-' ? "<div class='empty-slot'>-</div>" : $cellContent)."</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='p-3 text-center text-gray-500'>No timetable available</td></tr>";
        }
      ?>
      </tbody>
    </table>
  </div>
</section>
<section id="grades">
  <h2 class="text-2xl font-bold mb-4">Academic Grades</h2>
  <div class="bg-white p-6 rounded-xl shadow-md overflow-x-auto">
    <table class="w-full text-sm border-collapse">
      <thead class="bg-gray-100 text-left">
        <tr>
          <th class="p-3 border">Subject</th>
          <th class="p-3 border">Grade</th>
          <th class="p-3 border">Score</th>
          <th class="p-3 border">Credits</th>
          <th class="p-3 border">Status</th>
          <th class="p-3 border">Semester</th>
        </tr>
      </thead>
      <tbody>
      <?php
        if(isset($_SESSION['student_info']['id'])) {
            $etudiant_id = $_SESSION['student_info']['id'];
            $stmt = $pdo->prepare("SELECT n.note, m.nom_matiere, m.credit, b.semestre 
                FROM notes n
                JOIN matieres m ON n.matiere_id = m.id
                JOIN bulletins b ON n.etudiant_id = b.etudiant_id
                WHERE n.etudiant_id = ?
                ORDER BY b.semestre
            ");
            $stmt->execute([$etudiant_id]);
            
            if($stmt->rowCount() > 0) {
                while($grade = $stmt->fetch()) {
                    $gradeClass = 'grade-';
                    if($grade['note'] >= 16) $gradeClass .= 'A';
                    elseif($grade['note'] >= 14) $gradeClass .= 'B';
                    elseif($grade['note'] >= 12) $gradeClass .= 'C';
                    elseif($grade['note'] >= 10) $gradeClass .= 'D';
                    else $gradeClass .= 'F';
                    
                    echo "
                    <tr>
                        <td class='p-3 border'>".htmlspecialchars($grade['nom_matiere'])."</td>
                        <td class='p-3 border $gradeClass'>".htmlspecialchars($grade['note'])."/20</td>
                        <td class='p-3 border'>".htmlspecialchars($grade['note'])."</td>
                        <td class='p-3 border'>".htmlspecialchars($grade['credit'])."</td>
                        <td class='p-3 border'>".($grade['note'] >= 10 ? 'Passed' : 'Failed')."</td>
                        <td class='p-3 border'>".htmlspecialchars($grade['semestre'])."</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='p-3 text-center text-gray-500'>No grades available</td></tr>";
            }
        }
      ?>
      </tbody>
    </table>
  </div>
  <div class="flex justify-end mt-4">
    <a href="../Backend/studentBulletin.php" download class="bg-[#F0A07D] text-white px-4 py-2 rounded hover:bg-[#d88b6c] transition text-sm">
      Download Grades (PDF)
    </a>
  </div>
</section>
  </main>

  <script>
    function uploadImage(event) {
      const reader = new FileReader();
      reader.onload = function () {
        document.getElementById("profileImage").src = reader.result;
        document.getElementById("profilePreview").src = reader.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    }

    const gradeCtx = document.getElementById('gradeChart').getContext('2d');
    new Chart(gradeCtx, {
      type: 'line',
      data: {
        labels: ['Sem 1', 'Sem 2', 'Sem 3'],
        datasets: [{
          label: 'Grade',
          data: [2.5, 2.8, 3.2, 3.6],
          borderColor: '#3B82F6',
          backgroundColor: 'rgba(240,160,125,0.1)',
          fill: true,
          tension: 0.4
        }]
      }
    });

    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr'],
        datasets: [{
          label: 'Attendance (%)',
          data: [85, 90, 88, 92],
          backgroundColor: '#3B82F6'
        }]
      }
    });
  </script>
</body>
</html>




