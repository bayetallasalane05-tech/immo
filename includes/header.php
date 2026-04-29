<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. GESTION DES COOKIES ET DES INITIALES
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['user_nom'] = $_COOKIE['user_fullname']; 
}

// Calcul des initiales si l'utilisateur est connecté
$initials = "";
if (isset($_SESSION['user_nom'])) {
    $parts = explode(' ', $_SESSION['user_nom']);
    $p = substr($parts[0] ?? 'U', 0, 1);
    $n = isset($parts[1]) ? substr($parts[1], 0, 1) : '';
    $initials = strtoupper($p . $n);
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Immo | Sécurité et Confort</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --royal-dark: #003366;
            --royal-light: #00BFFF;
            --royal-bg: #f4f7f6;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--royal-bg);
            color: #333;
        }

        /* --- NAVBAR & LOGO --- */
        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 10px 0;
        }

        .navbar-brand img {
            height: auto; 
            width: 140px;
        }

        .nav-link {
            color: var(--royal-dark) !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            padding: 10px 15px !important;
            position: relative;
        }

        .nav-link.active, .nav-link:hover {
            color: var(--royal-light) !important;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 5px; left: 15px; right: 15px;
            height: 2px;
            background-color: var(--royal-light);
        }

        /* --- AVATAR & PROFIL --- */
        .profile-stack {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none !important;
            padding: 0 10px;
        }

        .avatar-circle {
            width: 38px;
            height: 38px;
            background-color: var(--royal-light);
            color: var(--royal-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            border: 2px solid var(--royal-dark);
            transition: 0.3s;
        }

        .user-name-label {
            font-size: 9px;
            color: var(--royal-dark);
            font-weight: 700;
            margin-top: 2px;
            text-transform: uppercase;
            max-width: 90px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn-login {
            background-color: var(--royal-dark);
            color: white !important;
            border-radius: 5px;
            padding: 8px 20px !important;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: var(--royal-light);
            transform: translateY(-2px);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            border-radius: 10px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="logo.jpeg" alt="Royal Immo Logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'villas.php') ? 'active' : ''; ?>" href="villas.php">Villas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'appartement.php') ? 'active' : ''; ?>" href="appartement.php">Appartements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'terrains.php') ? 'active' : ''; ?>" href="terrains.php">Terrains</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'nos_projet.php') ? 'active' : ''; ?>" href="nos_projet.php">Nos Projets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'contact.php') ? 'active' : ''; ?>" href="contact.php">Contact</a>
                </li>
                
                <li class="nav-item ms-lg-3">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="dropdown">
                            <a href="#" class="profile-stack dropdown-toggle" data-bs-toggle="dropdown">
                                <div class="avatar-circle">
                                    <?= $initials ?>
                                </div>
                                <span class="user-name-label"><?= htmlspecialchars($_SESSION['user_nom']) ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="login.php"><i class="bi bi-person me-2"></i>Mon Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="logout2.php"><i class="bi bi-power me-2"></i>Déconnexion</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a class="nav-link btn-login" href="login.php">
                            <i class="bi bi-person-circle"></i> CONNEXION
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>