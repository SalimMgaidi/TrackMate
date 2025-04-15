
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
    <title>Student Registration - TrackMate</title>
    <link rel="icon" href="imgs/logo-removebg-preview.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: black;
            background-color: #FCF4F0;
        }
        .registration-card {
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
        .input-error {
            border-color: #F44336 !important;
        }
        .error-message {
            color: #F44336;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
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

            <form id="registrationForm">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-[#F0A07D] border-b pb-2">Personal Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name*</label>
                            <input 
                                type="text" 
                                id="firstName" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition"
                                placeholder="John"
                                required>
                            <div id="firstNameError" class="error-message"></div>
                        </div>
                        
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Last Name*</label>
                            <input 
                                type="text" 
                                id="lastName" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition"
                                placeholder="Doe"
                                required>
                            <div id="lastNameError" class="error-message"></div>
                        </div>
                    </div>
                    
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="birthDay" class="block text-sm font-medium text-gray-700 mb-1">Day*</label>
                            <select 
                                id="birthDay" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition"
                                required>
                                <option value="" disabled selected>Day</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="birthMonth" class="block text-sm font-medium text-gray-700 mb-1">Month*</label>
                            <select 
                                id="birthMonth" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition"
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
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition"
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
                                <input type="radio" name="gender" value="male" class="text-[#F0A07D] focus:ring-[#F0A07D]">
                                <span class="ml-2">Male</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="female" class="text-[#F0A07D] focus:ring-[#F0A07D]">
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition"
                            placeholder="john.doe@example.com"
                            required>
                        <div id="emailError" class="error-message"></div>
                    </div>
                    
                    <div class="mt-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number*</label>
                        <input 
                            type="tel" 
                            id="phone" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition"
                            placeholder="12345678"
                            pattern="[0-9]{8}"
                            maxlength="8"
                            required>
                        <div id="phoneError" class="error-message"></div>
                    </div>
                    
                    <div class="mt-4">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address*</label>
                        <input 
                            type="text" 
                            id="address" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition"
                            placeholder="123 Main St, City, Country"
                            required>
                        <div id="addressError" class="error-message"></div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-[#F0A07D] border-b pb-2">Academic Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="currentYear" class="block text-sm font-medium text-gray-700 mb-1">Current Academic Year*</label>
                            <select 
                                id="currentYear" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition"
                                required>
                                <option value="" disabled selected>Select your year</option>
                                <option value="1">Year 1</option>
                                <option value="2">Year 2</option>
                                <option value="3">Year 3</option>
                                <option value="4">Year 4</option>
                                <option value="5+">Year 5+</option>
                            </select>
                            <div id="currentYearError" class="error-message"></div>
                        </div>
                        
                        <div>
                            <label for="program" class="block text-sm font-medium text-gray-700 mb-1">Program of Study*</label>
                            <select 
                                id="program" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#F0A07D] focus:border-[#F0A07D] outline-none transition"
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
                </div>

                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="terms" class="text-[#F0A07D] focus:ring-[#F0A07D] rounded">
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
    
                if (!month || !year) return;
    
                if (month === '2') {
                    days = (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0) ? 29 : 28;
                } else if (['4', '6', '9', '11'].includes(month)) {
                    days = 30;
                }
    
                const currentDay = birthDaySelect.value;
                birthDaySelect.innerHTML = '<option value="" disabled selected>Day</option>';
    
                for (let day = 1; day <= days; day++) {
                    const option = document.createElement('option');
                    option.value = day;
                    option.textContent = day;
                    if (day == currentDay) option.selected = true;
                    birthDaySelect.appendChild(option);
                }
            }
    
            for (let day = 1; day <= 31; day++) {
                const option = document.createElement('option');
                option.value = day;
                option.textContent = day;
                birthDaySelect.appendChild(option);
            }
    
            for (let year = currentYear; year >= currentYear - 100; year--) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                birthYearSelect.appendChild(option);
            }
    
            birthMonthSelect.addEventListener('change', updateDays);
            birthYearSelect.addEventListener('change', updateDays);
    
            const phoneInput = document.getElementById('phone');
            phoneInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 8) {
                    this.value = this.value.slice(0, 8);
                }
            });
        });
    
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let isValid = true;
    
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            document.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
    
            const firstName = document.getElementById('firstName');
            if (!firstName.value.trim()) {
                document.getElementById('firstNameError').textContent = 'First name is required';
                firstName.classList.add('input-error');
                isValid = false;
            } else if (firstName.value.length < 2) {
                document.getElementById('firstNameError').textContent = 'First name must be at least 2 characters';
                firstName.classList.add('input-error');
                isValid = false;
            }
    
            const lastName = document.getElementById('lastName');
            if (!lastName.value.trim()) {
                document.getElementById('lastNameError').textContent = 'Last name is required';
                lastName.classList.add('input-error');
                isValid = false;
            } else if (lastName.value.length < 2) {
                document.getElementById('lastNameError').textContent = 'Last name must be at least 2 characters';
                lastName.classList.add('input-error');
                isValid = false;
            }
    
            const day = document.getElementById('birthDay').value;
            const month = document.getElementById('birthMonth').value;
            const year = document.getElementById('birthYear').value;
            
            if (!day || !month || !year) {
                document.getElementById('birthDateError').textContent = 'Complete date of birth is required';
                isValid = false;
            } else {
                const selectedDate = new Date(year, month - 1, day);
                const currentDate = new Date();
                
                if (selectedDate > currentDate) {
                    document.getElementById('birthDateError').textContent = 'Birth date cannot be in the future';
                    isValid = false;
                } else if (month === '2') {
                    const isLeap = (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
                    const maxDay = isLeap ? 29 : 28;
                    if (day > maxDay) {
                        document.getElementById('birthDateError').textContent = `Invalid date: February ${year} only has ${maxDay} days`;
                        alert('Invalid date: This month has lessdays')
                        isValid = false;
                    }
                } else if (['4', '6', '9', '11'].includes(month) && day > 30) {
                    document.getElementById('birthDateError').textContent = 'Invalid date: This month only has 30 days';
                    alert('Invalid date: This month has lessdays')
                    isValid = false;
                }
            }
    
            const email = document.getElementById('email');
            if (!email.value.trim()) {
                document.getElementById('emailError').textContent = 'Email is required';
                email.classList.add('input-error');
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                document.getElementById('emailError').textContent = 'Please enter a valid email address (e.g., user@example.com)';
                email.classList.add('input-error');
                isValid = false;
            }
    
            const phone = document.getElementById('phone');
            if (!phone.value.trim()) {
                document.getElementById('phoneError').textContent = 'Phone number is required';
                phone.classList.add('input-error');
                isValid = false;
            } else if (!/^[0-9]{8}$/.test(phone.value)) {
                document.getElementById('phoneError').textContent = 'Phone number must be exactly 8 digits (e.g., 12345678)';
                phone.classList.add('input-error');
                isValid = false;
            }
    
            const address = document.getElementById('address');
            if (!address.value.trim()) {
                document.getElementById('addressError').textContent = 'Address is required';
                address.classList.add('input-error');
                isValid = false;
            } else if (address.value.length < 10) {
                document.getElementById('addressError').textContent = 'Address must be at least 10 characters';
                address.classList.add('input-error');
                isValid = false;
            }
    
            const currentYear = document.getElementById('currentYear');
            if (!currentYear.value) {
                document.getElementById('currentYearError').textContent = 'Academic year is required';
                currentYear.classList.add('input-error');
                isValid = false;
            }
    
            const program = document.getElementById('program');
            if (!program.value) {
                document.getElementById('programError').textContent = 'Program of study is required';
                program.classList.add('input-error');
                isValid = false;
            }
    
            if (!document.getElementById('terms').checked) {
                document.getElementById('termsError').textContent = 'You must accept the terms and conditions to continue';
                isValid = false;
            }
    
            if (isValid) {
                const birthDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
                alert('Registration successful! We will contact you soon.');
            }
        });
    </script>

           


            
    
</body>
</html>