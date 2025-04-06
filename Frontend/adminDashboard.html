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
                <h3 class="text-lg font-bold">Mgaidi Salim</h3>
                <p class="text-[12px]">salimmgaidi69@gmail.com</p>
            </div>
        </div>
        <div class="mt-5">
            <nav>
                <ul>
                    <div class="flex gap-2 ml-3 mb-9">
                        <img src="imgs/logo.png" class="w-6" alt="">
                        <h3 class="font-[poppins]"><span class="text-[#F0A07D] font-semibold">T</span>rack<span class="text-[#F0A07D] font-semibold">M</span>ate</h3>
                    </div>
                    <li class="mb-2"><a href="#statistics" class="block p-2 hover:bg-gray-200 rounded hover:scale-105 transition-transform duration-800 hover:text-black">Statistics</a></li>
                    <li class="mb-2"><a href="#students" class="block p-2 hover:bg-gray-200 rounded hover:scale-105 transition-transform duration-800 hover:text-black">Manage Students</a></li>
                    <li class="mb-2"><a href="#subjects" class="block p-2 hover:bg-gray-200 rounded hover:scale-105 transition-transform duration-800 hover:text-black">Manage Subjects</a></li>
                    <li class="mb-2"><a href="#grades" class="block p-2 hover:bg-gray-200 rounded hover:scale-105 transition-transform duration-800 hover:text-black">Manage Grades</a></li>
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
          <input type="file"  class="p-2.5 bg-white ml-[70px]  text-[12px] rounded-md">
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

          <script>

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
          </script>

    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10 bg-[#FCF4F0] pl-10 ml-64">
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Dashboard</h1>
            <div class="flex gap-4">
              
                <button class="bg-[#F0A07D] text-white px-4 py-2 rounded-3xl hover:bg-[#d88b6c]">Logout</button>
            </div>
        </header>

        <!-- Statistics Section -->
        <section id="statistics" class="mb-10">
            <h2 class="text-2xl font-bold mb-5">Statistics</h2>
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="bg-white p-5 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold">Total Students</h3>
                    <p class="text-3xl font-semibold">1200</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold">Total Subjects</h3>
                    <p class="text-3xl font-semibold">50</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold">Average Grades</h3>
                    <p class="text-3xl font-semibold">85%</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 pb-10">
               
                    <script>
                        window.onload = function() {
                            const ctx1 = document.getElementById('linechart').getContext('2d');
                            const myChart1 = new Chart(ctx1, {
                                type: 'line',
                                data: {
                                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                    datasets: [{
                                        label: 'My First Dataset',
                                        data: [65, 59, 80, 81, 56, 55, 40],
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(tooltipItem) {
                                                    return tooltipItem.raw + ' units';
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        

                        
                            const ctx2 = document.getElementById('piechart').getContext('2d');
                            const myChart2 = new Chart(ctx2, {
                                type: 'pie',
                                data: {
                                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                    datasets: [{
                                        label: 'My First Dataset',
                                        data: [65, 59, 80, 81, 56, 55, 40],
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(tooltipItem) {
                                                    return tooltipItem.raw + ' units';
                                                }
                                            }
                                        }
                                    }
                                }
                            });

                            const ctx3 = document.getElementById('barchart').getContext('2d');
                            const myChart3 = new Chart(ctx3, {
                                type: 'bar',
                                data: {
                                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                    datasets: [{
                                        label: 'My First Dataset',
                                        data: [65, 59, 80, 81, 56, 55, 40],
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(tooltipItem) {
                                                    return tooltipItem.raw + ' units';
                                                }
                                            }
                                        }
                                    }
                                }
                            });

                            const ctx4 = document.getElementById('polarchart').getContext('2d');
                            const myChart34 = new Chart(ctx4, {
                                type: 'polarArea',
                                data: {
                                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                    datasets: [{
                                        label: 'My First Dataset',
                                        data: [65, 59, 80, 81, 56, 55, 40],
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(tooltipItem) {
                                                    return tooltipItem.raw + ' units';
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    </script>
                     <div class="bg-white p-5 rounded-lg shadow-lg h-[600px]">
                        <h3 class="text-xl font-bold">Students Growth</h3>
                        <canvas id="linechart" width="300" height="200"></canvas>
                    </div>

                    <div class="bg-white p-5 rounded-lg shadow-lg ">
                        <h3 class="text-xl font-bold">Grade Distribution</h3>
                        <canvas id="barchart" width="300" height="150"></canvas>
                        
                    </div>
              
                <div class="bg-white p-5 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold">Grade Distribution</h3>
                    <canvas id="piechart" width="150" height="100"></canvas>
                    
                </div>
                
                <div class="bg-white p-5 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold">Grade Distribution</h3>
                    <canvas id="polarchart" width="100" height="100"></canvas>
                    
                </div>
            </div>
        </section>
         <!-- Students Section -->
         <section id="students" class="mb-10">
            <h2 class="text-2xl font-bold mb-5">Manage Students</h2>
            <div class="fflex gap-4">
            <input type="number" id="searchInput" placeholder="Search by ID" class="p-2 border rounded-xl mb-3">
            <button id="searchBtn" class="bg-green-200 w-20 h-8  rounded-xl">Search</button>
        </div>
            <!-- Add Student Button -->
            <div class="flex gap-4 mb-5">
                <button id="asb" class="bg-[#F0A07D] text-white px-5 py-3 rounded-lg">Add Student</button>
            </div>
        
            <!-- Students Table -->
            <div class="bg-white p-5 rounded-lg shadow-lg overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="p-3 border">ID</th>
                            <th class="p-3 border">Name</th>
                            <th class="p-3 border">Email</th>
                            <th class="p-3 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentTableBody">
                        <!-- Rows will be added dynamically -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Subjects Section -->
        <section id="subjects" class="mb-10">
            <h2 class="text-2xl font-bold mb-5">Manage Subjects</h2>
            <div class="flex gap-4 mb-5">
                <button class="bg-[#F0A07D] text-white px-5 py-3 rounded-lg">Add Subject</button>
                <button class="bg-yellow-500 text-white px-5 py-3 rounded-lg">Update Subject</button>
                <button class="bg-red-500 text-white px-5 py-3 rounded-lg">Delete Subject</button>
            </div>
        </section>

        <!-- Grades Section -->
        <section id="grades" class="mb-10">
            <h2 class="text-2xl font-bold mb-5">Manage Grades</h2>
            <div class="flex gap-4 mb-5">
                <button class="bg-[#F0A07D] text-white px-5 py-3 rounded-lg">Add Grade</button>
                <button class="bg-yellow-500 text-white px-5 py-3 rounded-lg">Update Grade</button>
                <button class="bg-red-500 text-white px-5 py-3 rounded-lg">Delete Grade</button>
            </div>
        </section>
    </main>
    
    <script src="functions.js"></script>
   
    
</body>
</html>