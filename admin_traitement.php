<?php
session_start();

// 1. PROTECTION : Redirection si non connecté
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: login.php');
    exit();
}

// 2. CONNEXION BDD
$host = 'localhost'; $dbname = 'SALANE_BASE_DE_DONNEE'; $user = 'root'; $pass = '';
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) { 
    die('Erreur BDD : ' . $e->getMessage()); 
}

// 3. LOGIQUE D'AJOUT DE CONTENU
if (isset($_POST['publier_bien'])) {
    $titre  = htmlspecialchars($_POST['titre']);
    $type   = $_POST['type_bien']; // INDEX, VILLA, APPARTEMENT, TERRAIN ou PROJET
    $desc   = htmlspecialchars($_POST['description']);
    $prix   = $_POST['prix'];
    $loc    = htmlspecialchars($_POST['localisation']);
    $statut = $_POST['statut'];

    // Gestion de l'image
    $image_name = time() . '_' . $_FILES['image']['name'];
    $target = "../uploads/" . $image_name;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO annonces (titre, description, prix, localisation, type_bien, image_principale, statut) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$titre, $desc, $prix, $loc, $type, $image_name, $statut]);
        $msg_success = "Publication réussie dans la section : " . $type;
    }
}

// 4. RÉCUPÉRATION DES DONNÉES (Messages et Utilisateurs)
$messages = $db->query("SELECT * FROM contacts ORDER BY id_contact DESC LIMIT 20")->fetchAll(PDO::FETCH_ASSOC);
$utilisateurs = $db->query("SELECT * FROM utilisateurs ORDER BY date_inscription DESC")->fetchAll(PDO::FETCH_ASSOC);

// FONCTION POUR GÉNÉRER LES FORMULAIRES DE SECTION
function afficherFormulaire($code_section, $label_bouton) {
    echo '
    <form method="POST" enctype="multipart/form-data" class="bg-white p-3 rounded shadow-sm">
        <input type="hidden" name="type_bien" value="'.$code_section.'">
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label fw-bold small">Nom du bien / Titre</label><input type="text" name="titre" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label fw-bold small">Prix (FCFA)</label><input type="number" name="prix" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label fw-bold small">Statut</label><select name="statut" class="form-select"><option>Disponible</option><option>Vendu</option><option>Réservé</option></select></div>
            <div class="col-md-6"><label class="form-label fw-bold small">Quartier / Ville</label><input type="text" name="localisation" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label fw-bold small text-primary">Image (Format JPG/PNG)</label><input type="file" name="image" class="form-control" required></div>
            <div class="col-12"><label class="form-label fw-bold small">Texte Descriptif</label><textarea name="description" class="form-control" rows="2" required></textarea></div>
            <div class="col-12"><button type="submit" name="publier_bien" class="btn btn-dark w-100 fw-bold">'.$label_bouton.'</button></div>
        </div>
    </form>';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin RoyalImmo | Gestion Totale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --royal: #003366; --accent: #00BFFF; }
        body { background: #f0f2f5; font-family: sans-serif; }
        .sidebar { background: var(--royal); min-height: 100vh; position: fixed; width: 280px; color: white; padding-top: 20px; z-index: 1000; }
        .main-content { margin-left: 280px; padding: 40px; }
        .nav-link { color: rgba(255,255,255,0.8); margin-bottom: 10px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.15); color: var(--accent); border-radius: 8px; }
        .accordion-button:not(.collapsed) { background-color: #e7f1ff; color: var(--royal); font-weight: bold; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        /* Style ajouté pour le bouton Voir le site */
        .btn-site { border: 1px solid var(--accent); color: var(--accent) !important; font-weight: bold; text-align: center; margin-top: 15px; padding: 10px; border-radius: 8px; text-decoration: none; display: block; }
        .btn-site:hover { background: var(--accent); color: var(--royal) !important; }
    </style>
</head>
<body>

<div class="sidebar shadow">
    <div class="text-center mb-5 border-bottom border-secondary pb-3 mx-3">
        <h4 class="fw-bold m-0 text-white">ROYAL <span style="color:var(--accent)">IMMO</span></h4>
        <small class="text-uppercase" style="letter-spacing: 1px; font-size: 10px;">Espace Administrateur</small>
    </div>
    
    <div class="nav flex-column nav-pills px-3" role="tablist">
        <button class="nav-link active text-start" data-bs-toggle="pill" data-bs-target="#tab-site"><i class="bi bi-window-sidebar me-2"></i> Gestion du Site</button>
        <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#tab-users"><i class="bi bi-people me-2"></i> Utilisateurs</button>
        <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#tab-msgs"><i class="bi bi-envelope-paper me-2"></i> Messages Reçus</button>
        <hr class="text-secondary">
        
        <a href="index.php" class="btn-site"><i class="bi bi-box-arrow-up-right me-2"></i> VOIR LE SITE</a>
        
        <a href="logout.php" class="nav-link text-danger mt-5"><i class="bi bi-power me-2"></i> Déconnexion</a>
    </div>
</div>

<div class="main-content">
    <div class="tab-content">

        <div class="tab-pane fade show active" id="tab-site">
            <h2 class="fw-bold mb-4">Mise à jour des Sections</h2>
            <?php if(isset($msg_success)): ?>
                <div class="alert alert-success border-0 shadow-sm mb-4"><i class="bi bi-check2-circle me-2"></i><?= $msg_success ?></div>
            <?php endif; ?>

            <div class="accordion accordion-flush card-custom overflow-hidden" id="accSite">
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#col-index">
                            <i class="bi bi-house me-2"></i> Page d'accueil (Annonces Récentes)
                        </button>
                    </h2>
                    <div id="col-index" class="accordion-collapse collapse show" data-bs-parent="#accSite">
                        <div class="accordion-body bg-light"><?php afficherFormulaire('INDEX', 'Mettre en avant sur l\'Index'); ?></div>
                    </div>
                </div>

                <div class="accordion-item border-top">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#col-villas">
                            <i class="bi bi-star me-2"></i> Page Villas (Découvrez nos opportunités)
                        </button>
                    </h2>
                    <div id="col-villas" class="accordion-collapse collapse" data-bs-parent="#accSite">
                        <div class="accordion-body bg-light"><?php afficherFormulaire('VILLA', 'Ajouter à la page Villas'); ?></div>
                    </div>
                </div>

                <div class="accordion-item border-top">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#col-apparts">
                            <i class="bi bi-building me-2"></i> Page Appartements (Opportunités Résidentielles)
                        </button>
                    </h2>
                    <div id="col-apparts" class="accordion-collapse collapse" data-bs-parent="#accSite">
                        <div class="accordion-body bg-light"><?php afficherFormulaire('APPARTEMENT', 'Ajouter à la page Appartements'); ?></div>
                    </div>
                </div>

                <div class="accordion-item border-top">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#col-terrains">
                            <i class="bi bi-geo-alt me-2"></i> Page Terrains (Opportunités Foncières)
                        </button>
                    </h2>
                    <div id="col-terrains" class="accordion-collapse collapse" data-bs-parent="#accSite">
                        <div class="accordion-body bg-light"><?php afficherFormulaire('TERRAIN', 'Ajouter à la page Terrains'); ?></div>
                    </div>
                </div>

                <div class="accordion-item border-top">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#col-projets">
                            <i class="bi bi-grid-3x3-gap me-2"></i> Page Nos Projets (Tous nos Programmes)
                        </button>
                    </h2>
                    <div id="col-projets" class="accordion-collapse collapse" data-bs-parent="#accSite">
                        <div class="accordion-body bg-light"><?php afficherFormulaire('PROJET', 'Ajouter au Catalogue Projets'); ?></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="tab-pane fade" id="tab-users">
            <h2 class="fw-bold mb-4">Annuaire des Utilisateurs</h2>
            <div class="card card-custom p-0 overflow-hidden">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-dark">
                        <tr><th>ID</th><th>Nom Complet</th><th>Email</th><th>Téléphone</th><th>Inscription</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($utilisateurs as $u): ?>
                        <tr>
                            <td class="small text-muted">#<?= $u['id'] ?></td>
                            <td class="fw-bold text-primary"><?= $u['nom'] ?></td>
                            <td><?= $u['email'] ?></td>
                            <td><?= $u['telephone'] ?></td>
                            <td><?= date('d/m/Y', strtotime($u['date_inscription'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="tab-msgs">
            <h2 class="fw-bold mb-4">Derniers Contacts Clients</h2>
            <div class="card card-custom p-0 overflow-hidden">
                <table class="table table-striped mb-0 align-middle">
                    <thead class="table-info">
                        <tr><th>Client</th><th>Sujet</th><th>Message</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($messages as $m): ?>
                        <tr>
                            <td class="fw-bold"><?= $m['nom'] ?></td>
                            <td><span class="badge bg-secondary"><?= $m['sujet'] ?></span></td>
                            <td class="small"><?= $m['message'] ?></td>
                            <td><a href="mailto:<?= $m['email'] ?>" class="btn btn-sm btn-outline-dark">Répondre</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>