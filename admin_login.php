<?php
session_start();

// Identifiants fixes
$admin_email_fixe = "Royalsalane&sowimmo@gmail.com";
$admin_pass_fixe  = "Skd2026";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email === $admin_email_fixe && $password === $admin_pass_fixe) {
        $_SESSION['admin_logged'] = true;
        $_SESSION['admin_email'] = $admin_email_fixe;
        header('Location: admin_traitement.php');
        exit();
    } else {
        $error = "Accès refusé. Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin | Royal Immo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: #003366; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border-radius: 15px; width: 100%; max-width: 400px; border: none; }
        .btn-admin { background: #00BFFF; color: #003366; font-weight: bold; border: none; }
        .input-group-text { cursor: pointer; background: white; border-left: none; }
        .form-control { border-right: none; }
    </style>
</head>
<body>
    <div class="card shadow-lg p-4">
        <h3 class="text-center fw-bold mb-4" style="color: #003366;">ADMIN ROYAL IMMO</h3>
        <?php if(isset($error)): ?> <div class="alert alert-danger py-2 small text-center"><?= $error ?></div> <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold small">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Royalsalane..." required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold small">Mot de passe</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <span class="input-group-text" id="togglePassword"><i class="bi bi-eye-slash" id="eyeIcon"></i></span>
                </div>
            </div>
            <button type="submit" class="btn btn-admin w-100 py-2">SE CONNECTER</button>
        </form>
    </div>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>