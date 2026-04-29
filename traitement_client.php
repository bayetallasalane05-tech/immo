<?php
session_start();

// Connexion BDD
$host = 'localhost'; $dbname = 'SALANE_BASE_DE_DONNEE'; $user = 'root'; $pass = '';
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (Exception $e) { die('Erreur : ' . $e->getMessage()); }

if (isset($_POST['login_submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    $req = $db->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $req->execute([$email]);
    $user = $req->fetch();

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        // Succès : On crée la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        
        // Optionnel : Créer des cookies pour se souvenir de l'utilisateur
        setcookie('user_id', $user['id'], time() + (86400 * 30), "/");
        setcookie('user_fullname', $user['nom'], time() + (86400 * 30), "/");

        header('Location: index.php'); // Redirection vers l'accueil
        exit();
    } else {
        // Erreur
        header('Location: login.php?error=1');
        exit();
    }
}