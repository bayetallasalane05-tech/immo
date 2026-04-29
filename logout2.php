<?php
session_start();

// 1. On vide toutes les variables de session
$_SESSION = array();

// 2. On détruit la session côté serveur
session_destroy();

// 3. On supprime les cookies en réglant leur expiration dans le passé
if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, "/");
}
if (isset($_COOKIE['user_fullname'])) {
    setcookie('user_fullname', '', time() - 3600, "/");
}

// 4. Redirection immédiate vers la page d'accueil
header('Location: index.php');
exit();
?>