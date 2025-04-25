<?php
session_start();
include 'connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($password, $user["mot_de_passe"])) {
            $_SESSION['user'] = $user;
            $_SESSION['role'] = $user['role_id'];

            // Set cookies - expires in 7 days
            setcookie('user_email', $email, time() + (7 * 24 * 60 * 60), "/");
            setcookie('session_id', session_id(), time() + (7 * 24 * 60 * 60), "/");

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
