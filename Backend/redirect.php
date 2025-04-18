<?php
session_start();
include 'connection.php'; // assumes $pdo is your PDO instance

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
 

    // Prepare and execute
    $stmt = $pdo->prepare("SELECT  * FROM utilisateur WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Fetch user
    $user = $stmt->fetch();
    echo "<pre>";
    print_r($user); 
    echo "</pre>";
    
    
    if ($user) {
        // Replace with password_verify() if you use hashed passwords
        if ($user["mot_de_passe"] == $password) {
            $_SESSION['user'] = $user;
            $_SESSION['role'] = $user['role_id'];

            // Redirect based on role
            if ($user['role_id'] == 1) {
                header("Location: ../frontend/adminDashboard.php");
                exit();
            } elseif ($user['role_id'] == 0) {
                header("Location: ../frontend/studentDashboard.php");
                exit();
            } else {
                header("Location: ../frontend/login.php?error=unknown_role");
                exit();
            }
        } else {
            header("Location: ../frontend/login.php?error=invalid_password");
            exit();
        }
    } else {
        header("Location: ../frontend/registration.php?error=no_user");
        exit();
    }
}

?>