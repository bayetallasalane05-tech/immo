<?php 
include 'includes/header.php'; 

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$host = 'localhost'; $dbname = 'SALANE_BASE_DE_DONNEE'; $user = 'root'; $pass = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $stmt = $db->prepare("SELECT * FROM annonces WHERE id = ?");
    $stmt->execute([$id]);
    $annonce = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$annonce) {
        echo "<div class='container py-5'><h3>Bien immobilier introuvable.</h3></div>";
        include 'includes/footer.php'; exit;
    }
} catch (Exception $e) { die('Erreur : ' . $e->getMessage()); }
?>

<style>
    /* Style Grandiose */
    .hero-detail {
        height: 65vh;
        background: url('img/annonces/<?= $annonce['image_url'] ?>') center/cover no-repeat;
        position: relative;
        display: flex;
        align-items: flex-end;
    }
    .hero-detail::after {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to bottom, transparent 40%, rgba(0, 51, 102, 0.8));
    }
    .hero-content-text { position: relative; z-index: 2; padding-bottom: 40px; color: white; }
    
    .info-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-top: -50px; /* Chevauchement sur l'image */
        background: white;
        z-index: 5;
        position: relative;
    }
    .feature-icon {
        background: #f0f7ff;
        color: var(--royal-dark);
        width: 60px; height: 60px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%;
        font-size: 1.5rem;
        margin: 0 auto 10px;
    }
    .sidebar-contact {
        position: sticky;
        top: 100px;
        border-radius: 15px;
        background: var(--royal-dark);
        color: white;
    }
</style>

<main style="background: #f4f7f6; padding-bottom: 80px;">
    <section class="hero-detail">
        <div class="container hero-content-text text-center">
            <span class="badge bg-cyan mb-2" style="background:var(--royal-light)"><?= strtoupper($annonce['categorie']) ?></span>
            <h1 class="display-3 fw-bold"><?= htmlspecialchars($annonce['titre']) ?></h1>
            <p class="fs-4"><i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($annonce['localisation']) ?></p>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card info-card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold m-0" style="color:var(--royal-dark)"><?= number_format($annonce['prix'], 0, ',', ' ') ?> FCFA</h2>
                        <span class="text-muted fw-bold">Réf: #RI-00<?= $annonce['id'] ?></span>
                    </div>

                    <div class="row text-center mb-4">
                        <?php if($annonce['categorie'] != 'terrain'): ?>
                            <div class="col-4">
                                <div class="feature-icon"><i class="bi bi-door-open"></i></div>
                                <small class="text-muted d-block">CHAMBRES</small>
                                <strong><?= $annonce['chambres'] ?></strong>
                            </div>
                            <div class="col-4">
                                <div class="feature-icon"><i class="bi bi-droplet"></i></div>
                                <small class="text-muted d-block">S. DE BAIN</small>
                                <strong><?= $annonce['salles_de_bain'] ?></strong>
                            </div>
                        <?php endif; ?>
                        <div class="col-4">
                            <div class="feature-icon"><i class="bi bi-rulers"></i></div>
                            <small class="text-muted d-block">SURFACE</small>
                            <strong><?= $annonce['surface'] ?> m²</strong>
                        </div>
                    </div>

                    <hr>
                    <h4 class="fw-bold mt-4">Description détaillée</h4>
                    <p class="text-muted fs-5" style="line-height: 1.8;">
                        <?= nl2br(htmlspecialchars($annonce['description'])) ?>
                    </p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card sidebar-contact p-4 border-0 shadow">
                    <h4 class="fw-bold mb-4">Une question sur cette <?= $annonce['categorie'] ?> ?</h4>
                    <p class="opacity-75">Nos conseillers Royal Immo sont disponibles 7j/7 pour vous accompagner dans votre projet.</p>
                    
                    <a href="tel:+221XXXXXXXXX" class="btn btn-light btn-lg w-100 fw-bold py-3 mb-3" style="color:var(--royal-dark)">
                        <i class="bi bi-telephone-fill me-2"></i> Appeler l'agence
                    </a>
                    
                    <a href="https://wa.me/221XXXXXXXXX?text=Bonjour, je suis intéressé par l'annonce : <?= urlencode($annonce['titre']) ?>" 
                       target="_blank" class="btn btn-success btn-lg w-100 fw-bold py-3">
                        <i class="bi bi-whatsapp me-2"></i> WhatsApp direct
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>