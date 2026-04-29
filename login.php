<?php
session_start();
// Si l'utilisateur est déjà connecté, on le redirige vers l'index
if (isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Royal Immo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --royal-light: #00BFFF; --royal-dark: #003366; }
        body, html { height: 100%; margin: 0; font-family: 'Segoe UI', sans-serif; overflow: hidden; }
        
        /* Vidéo de fond */
        #bg-video { position: fixed; right: 0; bottom: 0; min-width: 100%; min-height: 100%; z-index: -2; object-fit: cover; }
        .video-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4); z-index: -1; }

        .auth-wrapper { height: 100vh; display: flex; align-items: center; justify-content: center; }
        
        /* Formulaire transparent (Glassmorphism) */
        .glass-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            color: white;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37);
        }

        .nav-tabs { border: none; justify-content: center; margin-bottom: 25px; }
        .nav-tabs .nav-link { color: rgba(255, 255, 255, 0.5); border: none; font-weight: 700; text-transform: uppercase; }
        .nav-tabs .nav-link.active { color: white; background: transparent; border-bottom: 3px solid var(--royal-light); }

        .form-control { 
            background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.2); 
            color: white; padding: 12px; border-radius: 10px; 
        }
        .form-control:focus { background: rgba(255, 255, 255, 0.15); color: white; border-color: var(--royal-light); box-shadow: none; }
        .form-control::placeholder { color: rgba(255, 255, 255, 0.4); }

        .btn-auth { 
            background: var(--royal-light); color: var(--royal-dark); border: none; 
            width: 100%; padding: 14px; font-weight: 800; border-radius: 10px; margin-top: 15px; transition: 0.3s; 
        }
        .btn-auth:hover { background: white; transform: translateY(-2px); }
        .logo-img { max-height: 100px; margin-bottom: 20px;border-radius:50%; }
    </style>
</head>
<body>

    <video autoplay muted loop playsinline id="bg-video">
        <source src="video/login_bg.mp4" type="video/mp4">
    </video>
    <div class="video-overlay"></div>

    <div class="auth-wrapper">
        <div class="glass-card text-center">
            <img src="logo.jpeg" alt="Royal Immo" class="logo-img">
            
            <ul class="nav nav-tabs" id="authTab" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#login">Connexion</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#register">Inscription</button></li>
            </ul>

            <div class="tab-content text-start">
                <div class="tab-pane fade show active" id="login">
                    <form action="auth_process.php" method="POST">
                        <input type="hidden" name="action" value="login">
                        <div class="mb-3">
                            <label class="form-label small">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="votre@email.sn" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Mot de passe</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn-auth">SE CONNECTER</button>
                    </form>
                </div>

                <div class="tab-pane fade" id="register">
                    <form action="auth_process.php" method="POST">
                        <input type="hidden" name="action" value="register">
                        <div class="mb-3">
                            <label class="form-label small">Nom Complet</label>
                            <input type="text" name="nom" class="form-control" placeholder="Nom complet" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="votre@email.sn" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Mot de passe</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn-auth">CRÉER COMPTE</button>
                    </form>
                </div>
            </div>
            <a href="index.php" class="d-block mt-4 text-white-50 text-decoration-none small">Retour au site</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>