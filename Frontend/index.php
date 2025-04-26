<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrackMate</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="icon" href="imgs/logo-removebg-preview.png">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
</head>
<body >
  <header class="px-14 fixed top-0 left-0 w-full z-10 bg-white shadow-sm shadow-[#f0f0f0] transition-all duration-300" id="header">
    <div class="flex space-x-[1300px] p-4">
        <div class="flex space-x-2">
            <img src="imgs/logo.png" class="w-6" alt="">
            <h3 class="font-[poppins]"><span class="text-[#F0A07D] font-semibold">T</span>rack<span class="text-[#F0A07D] font-semibold">M</span>ate</h3>
        </div>

        <div class="text-gray-500 font-[poppins]">
            <ul class="flex space-x-9 font-medium">
                <li class="hover:scale-105 transition-transform duration-200 hover:text-black"><a href="index.php">Home</a></li>
                <li class="hover:scale-105 transition-transform duration-200 hover:text-black"><a href="#prog">Programs</a></li>
                <li class="hover:scale-105 transition-transform duration-200 hover:text-black"><a href="#conc">About</a></li>
                <li class="text-orange-300 rounded-md hover:font-semibold  hover:scale-105 transition-transform duration-200 hover:text-orange-500"><a target="_blank" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</header>

<!-- Add some content below for scroll effect -->
<div class="pt-[100px]"> <!-- Adjust this padding to ensure content is not hidden behind header -->
    <!-- Add your content here -->
</div>

    <section class="p-2.5">
        <div class="flex gap-54 p-4">
<div class="m-5 p-10 space-y-8">
    <h1 class="text-[80px]  font-semibold font-[poppins] w-[560px]">Welcome<br>To<span class="text-orange-300">TrackMate</span></h1>
    <p class="text-[15px] font-[poppins] w-[500px]"><span class="font-semibold text-lg">TrackMate</span> allows you to <span class="text-[#F4A69D] font-bold text-xl hover:text-[#f17466] ">save</span>, 
      <span class="text-[#3EAC60] font-bold text-xl hover:text-[#4be77c] ">secure</span>, and <span class="text-[#54BEC7] font-bold text-xl hover:text-[#40d6e4]">visualize</span> student notes and data effortlessly. Stay organized, 
        track progress, and gain valuable insights — all in one place. Empower your learning journey with a reliable and user-friendly platform designed to help you succeed</p>
    <img src="imgs/progressBar.png" alt="" class="w-[600px]">
    <button class="w-64 h-16 bg-orange-300 text-white rounded-xl text-[25px] font-medium hover:scale-105 transition-transform duration-200 hover:bg-orange-400"><a href="registration.php">Register Now</a></button>
</div>
<div>
    <img src="imgs/mainPageImg.png" alt="" class="w-[1300px]">
</div>
        </div>
    </section>
    
    <section id="prog" class="py-12 bg-[#F0A07D] ">
    
        <div class="max-w-6xl mx-auto px-1">
          <h2 class="text-7xl font-bold text-center mb-0.5  text-white font-[poppins] pt-5">Our Programs</h2>
          <p class="text-white font-[poppins] text-[15px] text-center p-8"><br><span class=" text-[45px] font-semibold">TrackMate is here to guide you every step of the way!</span> </p>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition hover:scale-105 duration-700">
              <h3 class="text-[22px] text-center font-semibold text-gray-900 p-5">Data Structures & Algorithms</h3>
              <img src="imgs/datastructure.jpg" alt="" class=" ">
              <p class="text-gray-600 mt-2 text-[12px]">Learn about arrays, linked lists, stacks, queues, trees, and graphs along with sorting and searching algorithms.</p>
              <div class="mt-4">
                  <span class="text-sm text-black">Level of Hardness: <strong>⭐⭐⭐⭐</strong></span>
              </div>
              <p class="mt-2 text-sm text-gray-500">Perfect for competitive programming and technical interviews.</p>
              <button class="mt-4 w-full bg-[#9CB9E1] text-white font-semibold py-2 rounded-lg hover:bg-[#7A9CC9] transition duration-300">
                Enroll Now
            </button>
          </div>
            
            <!-- Card 2 -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition hover:scale-105 duration-700">
              <h3 class="text-[22px] text-center font-semibold text-gray-900 p-5">Database Management Systems </h3>
              <img src="imgs//db.jpg" alt="" class=" w-[260px] m-auto">
              <p class="text-gray-600 mt-2 text-[12px]">Students learn about relational databases, SQL, normalization, indexing, and transactions. 
               </p>
              <div class="mt-4">
                  <span class="text-sm text-black">Level of Hardness: <strong>⭐⭐⭐</strong></span>
              </div>
              <p class="mt-2 text-sm text-gray-500">Basic understanding of programming and data storage concepts.</p>
              <button class="mt-4 w-full bg-[#EE7500] text-white font-semibold py-2 rounded-lg hover:bg-[#a3652b] transition duration-300">
                Enroll Now
            </button>
              
          </div>
      
            <!-- Card 3 -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition hover:scale-105 duration-700 ">
              <h3 class="text-[22px] text-center font-semibold text-gray-900 p-5">Machine Learning Basicss</h3>
              <img src="imgs/ml.jpg" alt="" class=" m-auto w-[270px] ">
              <p class="text-gray-600 mt-2 text-[12px]">Introduction to supervised and unsupervised learning, regression, classification, and neural networks. 
                </p>
              <div class="mt-4">
                  <span class="text-sm text-black">Level of Hardness: <strong>⭐⭐⭐⭐⭐</strong></span>
              </div>
              <p class="mt-2 text-sm text-gray-500">Knowledge of Python, statistics, and linear algebra.

              </p>
              <button class="mt-4 w-full bg-[#F04F5F] text-white font-semibold py-2 rounded-lg hover:bg-[#9c323d] transition duration-300">
                Enroll Now
            </button>
          </div>
        </div>
        <div class="flex justify-center p-5">
          <a href="#" class="text-[#fdfdfd] text-center p-8 font-[poppins] hover:underline  hover:text-[#fff]">View More ></a>
      </div>
    
      </section>
      <section class="flex flex-col md:flex-row items-center justify-center gap-8 p-24">
        <!-- About Section -->
        <div id="about" class=" p-8 rounded-lg w-full md:w-1/2">
          <div class="text-center">
            <h2 class=" font-bold   text-[#FFB86A] text-[90px]">About TrackMate</h2>
            <p class="text-lg mb-6 ">
              TrackMate is a comprehensive student management system designed to help educational institutions keep track of their students'
              progress, manage schedules, and improve communication between students, teachers, and administrators.
            </p>
          </div>
      
          <!-- Social Media Links -->
          <div class=" bg-[#F7B305] w-[500px] rounded-full ml-32">
            <h3 class="text-[30px] font-semibold  font-[poppins] text-center   text-white">Follow Us</h3>
            <div class="flex justify-center space-x-4 p-5">
              <a href="https://facebook.com/trackmate" target="_blank" class="text-blue-600">
                <i class="fab fa-facebook-f"></i> Facebook
              </a>
              <a href="https://twitter.com/trackmate" target="_blank" class="text-blue-400">
                <i class="fab fa-twitter"></i> Twitter
              </a>
              <a href="https://instagram.com/trackmate" target="_blank" class="text-pink-600">
                <i class="fab fa-instagram"></i> Instagram
              </a>
              <a href="https://linkedin.com/company/trackmate" target="_blank" class="text-blue-700">
                <i class="fab fa-linkedin-in"></i> LinkedIn
              </a>
            </div>
          </div>
        </div>

 
  <!-- Compact Contact Section -->
<div class="bg-[#F0A07D] p-3 rounded-4xl  font-[Poppins] text-xs h-[400px]  w-[400px] " id="conc">
  <h3 class="text-[42px] p-10 font-semibold mb-2 text-center text-white">Contact Us</h3>
  <p class="text-xs mb-3 text-center text-[12px] text-white">
    Reach out to us with any questions or feedback.
  </p>
  <form action="#" method="POST">
    <div class="mb-2">
      <label for="name" class="block text-white text-left text-xs">Name</label>
      <input type="text" id="name" name="name" class="w-full p-1 border border-white bg-transparent text-white rounded-sm text-xs" required>
    </div>
    <div class="mb-2">
      <label for="email" class="block text-white text-left text-xs">Email</label>
      <input type="email" id="email" name="email" class="w-full p-1 border border-white bg-transparent text-white rounded-sm text-xs" required>
    </div>
    <div class="mb-2">
      <label for="message" class="block text-white text-left text-xs">Message</label>
      <textarea id="message" name="message" class="w-full p-1 border border-white bg-transparent text-white rounded-sm text-xs" rows="2" required></textarea>
    </div>
    <button type="submit" class="bg-[#e27367] rounded-3xl text-white py-1 px-3  hover:bg-[#ffaca3] w-full text-xs">
      Send
    </button>
  </form>
</div>


      
            <!-- Additional Contact Info -->
            <div class=" p-8  rounded-4xl bg-[#B8E2F8]">
              <h3 class=" font-semibold mb-4 text-[45px] font-[poppins] text-center p-10 w-[400px]">Other Ways to Reach Us</h3>
              <p class="text-lg mb-4 text-center">You can also reach us via:</p>
              <div class="flex flex-col space-y-4 text-center">
                <a href="mailto:support@trackmate.com" class="text-blue-600">Email: support@trackmate.com</a>
                <a href="tel:+1234567890" class="text-blue-600">Phone: +123-456-7890</a>
              </div>
            </div>
          
          </section>
          <!-- Credits -->
          <div class="mt-6 text-sm text-center">
            <p>© 2025 TrackMate. All rights reserved.</p>
            
          </div>
       
      
      
      
</body>
</html>