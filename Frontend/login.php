
<?php if (isset($_GET['error'])): ?>
    <script>
        <?php if ($_GET['error'] == 'invalid_password'): ?>
            alert("❌ Incorrect password.");
        <?php elseif ($_GET['error'] == 'no_user'): ?>
            alert("❌ No user found with this email.");
        <?php elseif ($_GET['error'] == 'unknown_role'): ?>
            alert("❌ Unknown role. Please contact admin.");
        <?php endif; ?>
    </script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TrackMate</title>
    <link rel="icon" href="imgs/logo-removebg-preview.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: black;
            background-color: #FCF4F0;
        }
        .login-card {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }
        .btn-primary {
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(240, 160, 125, 0.3);
        }
        .role-option {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .role-option:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .role-option.selected {
            border-color: #F0A07D;
            background-color: rgba(240, 160, 125, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo Header -->
        <div class="flex justify-center mb-8">
            <div class="flex items-center gap-2">
                <img src="imgs/logo.png" class="w-10" alt="TrackMate Logo">
                <h1 class="text-3xl font-bold">
                    <span class="text-[#F0A07D]">T</span>rack<span class="text-[#F0A07D]">M</span>ate
                </h1>
            </div>
        </div>

        <!-- Login Card -->
        <div class="bg-white login-card p-8">
            <h2 class="text-2xl font-bold mb-1 text-center">Welcome to TrackMate</h2>
            <p class="text-gray-600 text-center mb-6">Select your login type</p>

            <!-- Role Selection -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <button id="studentBtn" class="role-option selected p-6 rounded-lg flex flex-col items-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Student" class="w-16 h-16 mb-3">
                    <h3 class="font-semibold">Student</h3>
                    <p class="text-sm text-gray-500 mt-1">Access your learning dashboard</p>
                </button>
                <button id="adminBtn" class="role-option p-6 rounded-lg flex flex-col items-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/2206/2206368.png" alt="Admin" class="w-16 h-16 mb-3">
                    <h3 class="font-semibold">Administrator</h3>
                    <p class="text-sm text-gray-500 mt-1">Manage system settings</p>
                </button>
            </div>

            <!-- Login Form (initially hidden) -->
            <form id="loginForm" class="hidden" method="post" action="../backend/redirect.php">
                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        <span id="emailLabel">Student</span> Email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition"
                        placeholder="Enter your email"
                        required>
                </div>

                <!-- Password Input -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition"
                        placeholder="Enter your password"
                        required>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember"
                            class="h-4 w-4 text-[#F0A07D] focus:ring-[#F0A07D] border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>
                    <a href="#" class="text-sm text-[#F0A07D] hover:underline">Forgot password?</a>
                </div>

                <!-- Login Button -->
                <button 
                    type="submit"
                    class="w-full bg-[#F0A07D] text-white py-3 px-4 rounded-lg font-semibold btn-primary hover:bg-[#d88b6c]">
                    Login as <span id="loginAsText">Student</span>
                </button>
            </form>

            <!-- Sign Up Link -->
            <div class="text-center text-sm mt-4" id="dontacc">
                <p class="text-gray-600">Don't have an account? 
                    <a href="registration.php" class="text-[#F0A07D] font-semibold hover:underline">create an account</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-xs text-gray-500">
            <p>© 2023 TrackMate. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Role selection functionality
        const studentBtn = document.getElementById('studentBtn');
        const adminBtn = document.getElementById('adminBtn');
        const loginForm = document.getElementById('loginForm');
        const emailLabel = document.getElementById('emailLabel');
        const loginAsText = document.getElementById('loginAsText');
        const dontacc= document.getElementById("dontacc");

        function selectRole(role) {
            // Update UI
            studentBtn.classList.toggle('selected', role === 'student');
            adminBtn.classList.toggle('selected', role === 'admin');
            
            // Update form labels
            if (role === 'student') {
                emailLabel.textContent = 'Student';
                loginAsText.textContent = 'Student';
                dontacc.classList.remove("hidden");
            } else {
                emailLabel.textContent = 'Admin';
                loginAsText.textContent = 'Administrator';
                dontacc.classList.add("hidden");
            }
            
            // Show login form
            loginForm.classList.remove('hidden');
        }

        // Event listeners
        studentBtn.addEventListener('click', () => selectRole('student'));
        adminBtn.addEventListener('click', () => selectRole('admin'));
    </script>
</body>
</html>