<?php 
session_start();
include '../Backend/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    if (!preg_match('/^[0-9]{8}$/', $_POST['Student_ID'])) {
        $errors[] = "invalid_student_id";
    }
    if (strlen($_POST['FirstName']) < 2 || strlen($_POST['LastName']) < 2) {
        $errors[] = "invalid_name";
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "invalid_email";
    }
    if (empty($_POST['program'])) {
        $errors[] = "invalid_program";
    }
    if (!preg_match('/^[A-Za-z0-9]{4,8}$/', $_POST['password'])) {
        $errors[] = "invalid_password";
    }
    if ($_POST['password'] !== $_POST['confirmPassword']) {
        $errors[] = "password_mismatch";
    }
    if (empty($_POST['birthDay']) || empty($_POST['birthMonth']) || empty($_POST['birthYear'])) {
        $errors[] = "invalid_birthdate";
    }
    if (empty($_POST['gender'])) {
        $errors[] = "invalid_gender";
    }
    if (!isset($_POST['terms'])) {
        $errors[] = "terms_required";
    }

    if (!empty($errors)) {
        header("Location: registration.php?error=" . urlencode($errors[0]));
        exit();
    }

    try {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $birth_date = $_POST['birthYear'] . '-' . $_POST['birthMonth'] . '-' . $_POST['birthDay'];
        $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, email, mot_de_passe, role_id, sexe, created_at)
            VALUES (:nom, :email, :mot_de_passe, 0, :sexe, NOW())");
        
        $stmt->execute([
            ':nom' => $_POST['FirstName'] . ' ' . $_POST['LastName'],
            ':email' => $_POST['email'],
            ':mot_de_passe' => $hashed_password,
            ':sexe' => $_POST['gender']
        ]);
        
        $user_id = $pdo->lastInsertId();
        $stmt = $pdo->prepare("INSERT INTO etudiant (user_id, date_naissance, filiere_id, cin)
            VALUES (:user_id, :date_naissance, 
                   (SELECT id FROM filieres WHERE nom_filiere = :filiere), 
                   :cin)");
        
        $stmt->execute([
            ':user_id' => $user_id,
            ':date_naissance' => $birth_date,
            ':filiere' => $_POST['program'],
            ':cin' => $_POST['Student_ID']
        ]);

        header("Location: login.php?registration=success");
        exit();
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            header("Location: registration.php?error=email_exists");
        } else {
            header("Location: registration.php?error=database_error");
        }
        exit();
    }
}
if (isset($_GET['error'])): ?>
<script>
    <?php 
    $errorMessages = [
        'invalid_student_id' => "❌ Student ID must be 8 digits",
        'invalid_name' => "❌ Names must be at least 2 characters",
        'invalid_email' => "❌ Invalid email format",
        'invalid_program' => "❌ Select study program",
        'invalid_password' => "❌ Password needs 4+ chars with uppercase, lowercase, number ",
        'password_mismatch' => "❌ Passwords don't match",
        'invalid_birthdate' => "❌ Complete birth date required",
        'invalid_gender' => "❌ Select gender",
        'email_exists' => "❌ Email already registered",
        'database_error' => "❌ Database error. Please try again."
    ];
    
    if (isset($errorMessages[$_GET['error']])): ?>
        alert("<?= $errorMessages[$_GET['error'] ]?>");
    <?php endif; ?>
</script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - TrackMate</title>
    <link rel="icon" href="imgs/logo-removebg-preview.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #FCF4F0; }
        .registration-card { box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); border-radius: 12px; }
        .btn-primary { transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(240, 160, 125, 0.3); }
        .input-error { border-color: #F44336 !important; }
        .error-message { color: #F44336; font-size: 0.75rem; margin-top: 0.25rem; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-2xl">
        <div class="flex justify-center mb-8">
            <div class="flex items-center gap-2">
                <img src="imgs/logo.png" class="w-10" alt="TrackMate Logo">
                <h1 class="text-3xl font-bold">
                    <span class="text-[#F0A07D]">T</span>rack<span class="text-[#F0A07D]">M</span>ate
                </h1>
            </div>
        </div>

        <div class="bg-white registration-card p-8">
            <h2 class="text-2xl font-bold mb-1 text-center">Student Registration</h2>
            <p class="text-gray-600 text-center mb-6">Please fill in your details</p>

            <form id="registrationForm"  method="POST" action="registration.php">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-[#F0A07D] border-b pb-2">Student Identification</h3>
                    <div>
                        <label for="studentId" class="block text-sm font-medium text-gray-700 mb-1">Student CIN*</label>
                        <input type="text" id="studentId" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition" placeholder="12345678" pattern="[0-9]{8}" maxlength="8" name="Student_ID"required>
                        <div id="studentIdError" class="error-message"></div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-[#F0A07D] border-b pb-2">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name*</label>
                            <input type="text" id="firstName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition" name="FirstName" required>
                            <div id="firstNameError" class="error-message"></div>
                        </div>
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Last Name*</label>
                            <input type="text" id="lastName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition" name="LastName" required>
                            <div id="lastNameError" class="error-message"></div>
                        </div>
                    </div>
                    
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="birthDay" class="block text-sm font-medium text-gray-700 mb-1">Day*</label>
                            <select id="birthDay"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition"name="birthDay" required>
                                <option value="" disabled selected>Day</option>
                            </select>
                        </div>
                        <div>
                            <label for="birthMonth" class="block text-sm font-medium text-gray-700 mb-1">Month*</label>
                            <select 
                                id="birthMonth" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition" name="birthMonth"
                                required>
                                <option value="" disabled selected>Month</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div>
                            <label for="birthYear" class="block text-sm font-medium text-gray-700 mb-1">Year*</label>
                            <select 
                                id="birthYear" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition" name="birthYear"
                                required>
                                <option value="" disabled selected>Year</option>
                            </select>
                        </div>
                    </div>
                    <div id="birthDateError" class="error-message"></div>
                    
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="homme" class="text-[#F0A07D] focus:ring-[#F0A07D]">
                                <span class="ml-2">Male</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="femme" class="text-[#F0A07D] focus:ring-[#F0A07D]">
                                <span class="ml-2">Female</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-[#F0A07D] border-b pb-2">Contact Information</h3>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
                        <input 
                            type="email" 
                            id="email" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition" name="email"
                            placeholder="etudiant@example.com"
                            required>
                        <div id="emailError" class="error-message"></div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-[#F0A07D] border-b pb-2">Academic Information</h3>
                    <div class="mt-4">
                        <label for="program" class="block text-sm font-medium text-gray-700 mb-1">Program of Study*</label>
                        <select 
                            id="program" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition" name="program"
                            required>
                            <option value="" disabled selected>Select your program</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Finance">Finance</option>
                            <option value="Management">Management</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Cyber Security">Cyber Security</option>
                            <option value="Economics">Economics</option>
                        </select>
                        <div id="programError" class="error-message"></div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-[#F0A07D] border-b pb-2">Account Security</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password*</label>
                            <input 
                                type="password" 
                                id="password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition" name="password"
                                placeholder="••••••••"
                                required>
                            <div id="passwordError" class="error-message"></div>
                        </div>
                        
                        <div>
                            <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password*</label>
                            <input type="password" id="confirmPassword" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition" name="confirmPassword" placeholder="••••••••"
                                required>
                            <div id="confirmPasswordError" name="confirmPassword" id="confirmPasswordHidden" class="error-message"></div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                     <label class="inline-flex items-center">
                    <input type="checkbox" id="terms" class="text-[#F0A07D] focus:ring-[#F0A07D] rounded" name="terms">
                    <span class="ml-2 text-sm">I agree to the <a href="#" class="text-[#F0A07D] hover:underline">Terms and Conditions</a>*</span>
                    </label>
                    <div id="termsError" class="error-message"></div>
                </div>

                <button 
                    type="submit"
                    class="w-full bg-[#F0A07D] text-white py-3 px-4 rounded-lg font-semibold btn-primary hover:bg-[#d88b6c]">
                    Complete Registration
                </button>
            </form>

            <div class="text-center text-sm mt-4">
                <p class="text-gray-600">Already have an account? 
                    <a href="login.php" class="text-[#F0A07D] font-semibold hover:underline">Login here</a>
                </p>
            </div>
        </div>

        <div class="text-center mt-6 text-xs text-gray-500">
            <p>© 2023 TrackMate. All rights reserved.</p>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const birthDaySelect = document.getElementById('birthDay');
    const birthMonthSelect = document.getElementById('birthMonth');
    const birthYearSelect = document.getElementById('birthYear');
    const currentYear = new Date().getFullYear();

    function updateDays() {
        const month = birthMonthSelect.value;
        const year = birthYearSelect.value;
        let days = 31;
        if (month === '2') days = (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0)) ? 29 : 28;
        else if (['4','6','9','11'].includes(month)) days = 30;
        
        birthDaySelect.innerHTML = '<option value="" disabled selected>Day</option>';
        for (let day = 1; day <= days; day++) birthDaySelect.appendChild(new Option(day, day));
    }

    for (let day = 1; day <= 31; day++) birthDaySelect.appendChild(new Option(day, day));
    for (let year = currentYear; year >= currentYear - 100; year--) birthYearSelect.appendChild(new Option(year, year));

    birthMonthSelect.addEventListener('change', updateDays);
    birthYearSelect.addEventListener('change', updateDays);

    document.getElementById('registrationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;
        const errors = [];

        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
        document.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));

        const validateField = (field, condition, errorMsg) => {
            if (!condition) {
                errors.push(errorMsg);
                document.getElementById(`${field}Error`).textContent = errorMsg;
                document.getElementById(field).classList.add('input-error');
                isValid = false;
            }
        };

        const studentId = document.getElementById('studentId');
        const firstName = document.getElementById('firstName');
        const lastName = document.getElementById('lastName');
        const email = document.getElementById('email');
        const program = document.getElementById('program');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        const terms = document.getElementById('terms');

        validateField('studentId', /^[0-9]{8}$/.test(studentId.value), "Student ID must be 8 digits");
        validateField('firstName', firstName.value.trim().length >= 2, "First name must be at least 2 characters");
        validateField('lastName', lastName.value.trim().length >= 2, "Last name must be at least 2 characters");
        
        if (!birthDaySelect.value || !birthMonthSelect.value || !birthYearSelect.value) {
            errors.push("Complete birth date required");
            document.getElementById('birthDateError').textContent = 'Birth date required';
            isValid = false;
        }

        validateField('email', /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value), "Invalid email format");
        validateField('program', program.value, "Select study program");
        validateField('password', /^[A-Za-z0-9]{4,8}$/.test(password.value), "Password must be 4-8 letters/digits");

        if (password.value !== confirmPassword.value) {
            errors.push("Passwords don't match");
            document.getElementById('confirmPasswordError').textContent = "Passwords don't match";
            confirmPassword.classList.add('input-error');
            isValid = false;
        }

        if (!terms.checked) {
            errors.push("You must accept terms");
            document.getElementById('termsError').textContent = "Accept terms required";
            isValid = false;
        }

        if (!isValid) {
            alert("Please fix these errors:\n\n" + errors.join('\n'));
        } else {
            this.submit();
        }
    });
});
</script>
    

    </script>

</body>
</html>