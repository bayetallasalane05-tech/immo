<?php
include('includes/header.php'); 

$host = 'localhost'; 
$dbname = 'SALANE_BASE_DE_DONNEE'; 
$user = 'root'; 
$pass = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {

    $error = "Impossible de se connecter à la base de données.";
}


if (isset($_POST['envoyer'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $sujet = htmlspecialchars($_POST['sujet']);
    $message = htmlspecialchars($_POST['message']);
    
    if (!empty($nom) && !empty($email) && !empty($message)) {
        try {
            $stmt = $db->prepare("INSERT INTO messages (nom, email, sujet, message) VALUES (:nom, :email, :sujet, :message)");
            $stmt->execute([
                ':nom' => $nom,
                ':email' => $email,
                ':sujet' => $sujet,
                ':message' => $message
            ]);
            $success = "Merci $nom, votre message a bien été enregistré. Notre équipe vous recontactera bientôt.";
        } catch (Exception $e) {
            $error = "Désolé, une erreur technique est survenue lors de l'envoi.";
        }
    } else {
        $error = "Veuillez remplir tous les champs obligatoires.";
    }
}
?>

<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: var(--royal-dark);">CONTACTEZ-NOUS</h1>
        <p class="text-muted">Une question sur une villa ou un terrain ? Notre équipe vous répond sous 24h.</p>
    </div>

    <div class="row g-5">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-4 h-100" style="background: var(--royal-dark); color: white; border-radius: 15px;">
                <h3 class="mb-4">Nos Coordonnées</h3>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box me-3" style="background: rgba(255,255,255,0.1); padding: 10px; border-radius: 10px;">
                        <i class="bi bi-geo-alt-fill fs-4" style="color: var(--royal-light);"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Adresse</h6>
                        <p class="small mb-0">Pikine Dagoudane, Dakar, Sénégal</p>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box me-3" style="background: rgba(255,255,255,0.1); padding: 10px; border-radius: 10px;">
                        <i class="bi bi-telephone-fill fs-4" style="color: var(--royal-light);"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Téléphone</h6>
                        <p class="small mb-0">+221 78 014 54 97</p>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box me-3" style="background: rgba(255,255,255,0.1); padding: 10px; border-radius: 10px;">
                        <i class="bi bi-envelope-fill fs-4" style="color: var(--royal-light);"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Email</h6>
                        <p class="small mb-0">Royalsalane&sowimmo@gmail.com</p>
                    </div>
                </div>

                <div class="mt-auto">
                    <h6>Suivez-nous</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white fs-5"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white fs-5"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white fs-5"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
                
                <?php if(isset($success)): ?>
                    <div class="alert alert-success border-0 shadow-sm mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i> <?= $success ?>
                    </div>
                <?php endif; ?>

                <?php if(isset($error)): ?>
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nom Complet</label>
                            <input type="text" name="nom" class="form-control" placeholder="Ex: Baye Talla" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Votre Email</label>
                            <input type="email" name="email" class="form-control" placeholder="exemple@mail.com" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Sujet</label>
                            <input type="text" name="sujet" class="form-control" placeholder="Ex: Question sur la Villa n°12" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Message</label>
                            <textarea name="message" class="form-control" rows="6" placeholder="Écrivez votre message ici..." required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" name="envoyer" class="btn btn-lg w-100 mt-3 fw-bold" style="background: var(--royal-dark); color: white; border-radius: 10px;">
                                <i class="bi bi-send-fill me-2"></i> ENVOYER LE MESSAGE
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-0 mt-5">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61751.1895209252!2d-17.4208468!3d14.7578278!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xec10d323a676b73%3A0xe54d89b3f309d43d!2sPikine%2C%20S%C3%A9n%C3%A9gal!5e0!3m2!1sfr!2sfr!4v1700000000000" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>
 
<?php include('includes/footer.php'); ?>