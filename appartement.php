<?php 
include 'includes/header.php'; 

// Connexion BDD
$host = 'localhost'; $dbname = 'SALANE_BASE_DE_DONNEE'; $user = 'root'; $pass = '';
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    
    // 1. On récupère uniquement les appartements
    $stmt = $db->prepare("SELECT * FROM annonces WHERE categorie = 'appartement' ORDER BY date_publication DESC");
    $stmt->execute();
    $apparts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. Gestion de la vidéo (Initialisation pour éviter le Warning)
    $video_appart = null;
    $vid_query = $db->prepare("SELECT video_url FROM videos_accueil WHERE section_nom = ?");
    $vid_query->execute(['appartement']);
    $video_appart = $vid_query->fetchColumn();

} catch (Exception $e) { 
    $apparts = []; 
    $video_appart = null;
}


?>
<style>
    :root {
        --royal-dark: #003366;
        --royal-light: #00BFFF;
    }

    /* --- HERO CATEGORY --- */
    .hero-category {
        position: relative;
        height: 50vh;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-align: center;
    }
    .hero-category video {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        object-fit: cover; z-index: -1;
    }
    
    /* --- MODIFICATION : OVERLAY TOTALEMENT TRANSPARENT --- */
    .hero-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 51, 102, 0); /* Alpha mis à 0 */
        z-index: 0;
        pointer-events: none; 
    }

    /* --- GRILLE D'APPARTEMENTS --- */
    .apparts-section { padding: 80px 0; background: #fdfdfd; }
    
    .annonce-link { text-decoration: none; color: inherit; display: block; }
    
    .project-card { 
        position: relative; 
        height: 400px; 
        border-radius: 15px; 
        overflow: hidden; 
        display: flex; 
        flex-direction: column; 
        justify-content: flex-end; 
        background-size: cover; 
        background-position: center;
        transition: all 0.3s ease-in-out;
        border: 1px solid #eee;
    }
    
    .annonce-link:hover .project-card {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 51, 102, 0.2);
    }

    /* L'info reste lisible grâce au dégradé progressif en bas */
    .project-info { 
        background: linear-gradient(to top, rgba(0, 51, 102, 0.95) 30%, transparent); 
        padding: 30px 20px; 
        color: #fff; 
    }
    .project-info h4 { margin: 0; font-size: 1.4rem; font-weight: 700; }
    .project-info .price { color: var(--royal-light); font-size: 1.2rem; font-weight: 800; margin-top: 5px; }
    
    .category-title {
        color: var(--royal-dark);
        font-weight: 900;
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 40px;
        text-transform: uppercase;
    }
    .category-title::after {
        content: '';
        position: absolute;
        bottom: 0; left: 50%;
        transform: translateX(-50%);
        width: 80px; height: 4px;
        background: var(--royal-light);
    }
</style>

<main>
    <section class="hero-category">
        <video autoplay muted loop playsinline>
            <source src="appartement.mp4" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-content" style="position:relative; z-index:1;">
            <h1 class="display-3 fw-bold">Appartements de Standing</h1>
            <p class="lead">Modernité, confort et sécurité au cœur des plus beaux quartiers de Dakar.</p>
        </div>
    </section>

    <section class="container apparts-section">
        <div class="text-center">
            <h2 class="category-title">Nos Opportunités Résidentielles</h2>
        </div>

        <?php if (count($apparts) > 0): ?>
            <div class="row g-4">
                <?php foreach ($apparts as $row): ?>
                <div class="col-md-4">
                    <a href="details.php?id=<?= $row['id'] ?>" class="annonce-link">
                        <div class="project-card" style="background-image: url('img/annonces/<?= $row['image_url'] ?>');">
                            <div class="project-info">
                                <h4><?= htmlspecialchars($row['titre']) ?></h4>
                                <div class="price"><?= number_format($row['prix'], 0, ',', ' ') ?> FCFA</div>
                                <div style="font-size: 0.9rem; opacity: 0.9; margin-top: 10px;">
                                    <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($row['localisation']) ?> <br>
                                    <i class="bi bi-door-open"></i> <?= $row['chambres'] ?> Chambres | 
                                    <i class="bi bi-rulers"></i> <?= $row['surface'] ?> m²
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-building-exclamation display-1 text-muted"></i>
                <p class="mt-3 fs-5 text-muted">Aucun appartement disponible pour le moment.</p>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php include 'includes/footer.php'; ?>