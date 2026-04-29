<?php
$host = 'localhost';
$dbname = 'SALANE_BASE_DE_DONNEE';
$user = 'root';
$pass = ''; // Par défaut vide sur XAMPP/WAMP

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Configuration pour PHP 8.2 : Gestion des erreurs en mode Exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion à la base Salane : " . $e->getMessage());
}
?>