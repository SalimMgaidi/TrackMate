<?php

session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ( password_verify($password, $user["mot_de_passe"])) {
                $_SESSION['user'] = $user;
                $_SESSION['role'] = $user['role_id'];
                setcookie('user_email', $email, time() + (7 * 24 * 60 * 60), "/");
                setcookie('session_id', session_id(), time() + (7 * 24 * 60 * 60), "/");
                switch ($user['role_id']) {
                    case 1: 
                        header("Location: ../Frontend/adminDashboard.php");

                    case 0: 
                        $stmt = $pdo->prepare(" SELECT e.*, f.nom_filiere 
                            FROM etudiant e 
                            JOIN filieres f ON e.filiere_id = f.id 
                            WHERE e.user_id = :user_id
                        ");
                        $stmt->bindParam(':user_id', $user['id']);
                        $stmt->execute();
                        $studentInfo = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($studentInfo) {
                            $_SESSION['student_info'] = $studentInfo;
                            header("Location: ../Frontend/studentDashboard.php");
                        
                        } else {
                            header("Location: ../Frontend/login.php?error=no_student_data");
                
                        }
                        exit();

                    default: 
                        header("Location: ../Frontend/login.php?error=unknown_role");
                        exit();
                }
            } else {
                header("Location: ../Frontend/login.php?error=invalid_password");
                
                exit();
            }
        } else {
            header("Location: ../Frontend/login.php?error=no_user");
            exit();
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>